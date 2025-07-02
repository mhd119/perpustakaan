<?php
include 'koneksi.php';

if (isset($_GET['aksi'])) {
    $aksi = $_GET['aksi'];

    // DELETE BUKU
    if ($aksi == 'hapus' && isset($_GET['id'])) {
        $id = (int) $_GET['id'];

        // Hapus dulu data peminjaman yang terkait
        $conn->query("DELETE FROM perpus_peminjaman WHERE buku_id = $id");

        // Lalu hapus bukunya
        $sql = "DELETE FROM perpus_buku WHERE id = $id";
        if ($conn->query($sql)) {
            header("Location: dashboard.php?message=deleted");
            exit;
        } else {
            echo "Gagal hapus buku: " . $conn->error;
        }
    }

    // PINJAM BUKU
} elseif ($aksi == 'pinjam' && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $sql = "UPDATE perpus_buku SET status = 1 WHERE id = $id";
    if ($conn->query($sql)) {
        header("Location: dashboard.php?message=borrowed");
        exit;
    } else {
        echo "Gagal meminjam buku: " . $conn->error;
    }

    // KEMBALIKAN BUKU
} elseif ($aksi == 'kembalikan' && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $sql = "UPDATE perpus_buku SET status = 0 WHERE id = $id";
    if ($conn->query($sql)) {
        header("Location: dashboard.php?message=returned");
        exit;
    } else {
        echo "Gagal mengembalikan buku: " . $conn->error;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi'])) {
    $aksi = $_POST['aksi'];

    if ($aksi == 'edit') {
        $id = (int) $_POST['id'];
        $judul = $conn->real_escape_string($_POST['judul']);
        $penulis = $conn->real_escape_string($_POST['penulis']);
        $tahun = (int) $_POST['tahun'];
        $genre = $conn->real_escape_string($_POST['genre']);
        $description = $conn->real_escape_string($_POST['description']);

        $sql = "UPDATE perpus_buku SET judul='$judul', penulis='$penulis', tahun=$tahun, genre='$genre',description='$description' WHERE id=$id";
        if ($conn->query($sql)) {
            header("Location: dashboard.php?message=updated");
            exit;
        } else {
            echo "Gagal edit buku: " . $conn->error;
        }
    }
}
?>