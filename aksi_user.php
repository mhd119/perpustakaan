<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['user_id']))
  exit;

$user_id = $_SESSION['user_id'];
$book_id = $_GET['id'];
$action = $_GET['action'];

if ($action == 'pinjam') {
  // Tandai buku sebagai dipinjam
  $conn->query("UPDATE perpus_buku SET status = 1 WHERE id = $book_id");

  // Hitung tenggat waktu: 7 hari dari hari ini
  $tanggal_pinjam = date('Y-m-d');
  $tenggat_kembali = date('Y-m-d', strtotime('+7 days'));

  // Simpan data peminjaman beserta tenggat
  $conn->query("INSERT INTO perpus_peminjaman (user_id, buku_id, tanggal_pinjam, tenggat_kembali) 
                VALUES ($user_id, $book_id, '$tanggal_pinjam', '$tenggat_kembali')");
} elseif ($action == 'kembalikan') {
  $conn->query("UPDATE perpus_buku SET status = 0 WHERE id = $book_id");
  $conn->query("UPDATE perpus_peminjaman SET tanggal_kembali = NOW(),
  status = 'dikembalikan' 
  WHERE user_id = $user_id AND buku_id = $book_id AND tanggal_kembali IS NULL");
} elseif ($action == 'kembalikan_semua' && isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Ambil semua pinjaman aktif user
    $result = $conn->query("SELECT buku_id FROM perpus_peminjaman WHERE user_id = $user_id AND status = 'dipinjam' AND tanggal_kembali IS NULL");

    while ($row = $result->fetch_assoc()) {
        $book_id = $row['buku_id'];

        // Ubah status buku jadi tersedia
        $conn->query("UPDATE perpus_buku SET status = 0 WHERE id = $book_id");

        // Ubah status peminjaman
        $conn->query("UPDATE perpus_peminjaman 
                      SET status = 'dikembalikan', tanggal_kembali = NOW() 
                      WHERE user_id = $user_id AND buku_id = $book_id AND tanggal_kembali IS NULL");
    }

    header("Location: history.php"); // kembali ke halaman user
    exit;
}


header("Location: history.php");