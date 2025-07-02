<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>

<body class="bg-gray-200 font-sans text-gray-700">

    <!-- navbar -->
    <header class="bg-blue-700 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex flex-col sm:flex-row justify-between items-center gap-4">
            <!-- Logo Judul -->
            <a href="laman_utama.php" class="text-2xl font-semibold flex items-center gap-2 ">
                Perpustakaan Digital
            </a>
            <div class="flex items-center gap-4 justify-between">
                <!-- navigasi -->
                <div>
                    <a href="user_home.php">Daftar Buku</a>
                </div>
                <!-- Profil User -->
                <a href="profile.php" class="flex items-center gap-1 sm:order-2 flex ">
                    <i class="fas fa-user-circle text-2xl"></i>
                    <h3 class="hover:underline"><?php echo $_SESSION['username']; ?></h3>
                </a>

            </div>

        </div>
    </header>
    <!-- history -->
    <main class="max-w-4xl mx-auto px-4 py-8 space-y-8">

        <!-- Buku yang Anda Pinjam -->
        <div class="bg-white rounded-2xl shadow-2xl p-6">
    <h2 class="text-2xl font-semibold text-blue-700 mb-4 flex items-center gap-2">
        <i class="fas fa-book-reader"></i> Buku Yang Anda Pinjam
    </h2>

    <!-- Tombol Kembalikan Semua -->
    <div class="mb-4">
        <a href="aksi_user.php?action=kembalikan_semua&user_id=<?= $user_id ?>" 
           class="inline-block bg-red-600 text-white text-sm px-4 py-2 rounded hover:bg-red-700 transition">
           Kembalikan Semua
        </a>
    </div>

    <ul class="space-y-3">
        <?php
        $pinjaman = $conn->query("SELECT b.id, b.judul, b.status, p.tanggal_pinjam,p.tenggat_kembali, p.tanggal_kembali 
                                  FROM perpus_peminjaman p 
                                  JOIN perpus_buku b ON p.buku_id = b.id 
                                  WHERE p.user_id = $user_id AND p.status = 'dipinjam' 
                                  ORDER BY p.tanggal_pinjam DESC");

        while ($r = $pinjaman->fetch_assoc()) {
            echo "<li class='bg-gray-50 p-4 rounded-lg flex flex-col sm:flex-row sm:justify-between items-start sm:items-center border border-gray-200 hover:shadow-lg transition-shadow'>";
            echo "<div><span class='font-medium'>{$r['judul']}</span><br><span class='text-gray-500 text-sm'>Dipinjam: {$r['tanggal_pinjam']}</span><br><span class='text-gray-500 text-sm'>batas pengembalian: {$r['tenggat_kembali']}</span></div>";
            if ($r['status'] == 1) {
                echo "<a href='aksi_user.php?action=kembalikan&id={$r['id']}' class='mt-2 sm:mt-0 inline-block bg-blue-600 text-white text-sm px-4 py-1.5 rounded hover:bg-blue-700 transition'>Kembalikan</a>";
            }
            echo "</li>";
        }
        ?>
    </ul>
</div>


        <!-- Riwayat Peminjaman -->
        <div id class="bg-white rounded-2xl shadow-2xl p-6">
            <h2 class="text-2xl font-semibold text-blue-700 mb-4 flex items-center gap-2">
                <i class="fas fa-history"></i> Riwayat Peminjaman
            </h2>
            <ul class="space-y-3 ">
                <?php
                $riwayat = $conn->query("SELECT b.judul, p.tanggal_pinjam, p.tanggal_kembali FROM perpus_peminjaman p JOIN perpus_buku b ON p.buku_id = b.id WHERE p.user_id = $user_id ORDER BY p.tanggal_pinjam DESC LIMIT 5");
                while ($r = $riwayat->fetch_assoc()) {
                    $kembali = $r['tanggal_kembali'] ?? '<span class="text-red-600">Belum</span>';
                    echo "<li class='bg-gray-50 p-4 rounded-lg border border-gray-200 hover:shadow-lg transition-shadow duration-200'>";
                    echo "<span class='font-medium'>{$r['judul']}</span><br>";
                    echo "<span class='text-sm text-gray-500'>Pinjam: {$r['tanggal_pinjam']} | Kembali: {$kembali}</span>";
                    echo "</li>";
                }
                ?>
            </ul>
        </div>

    </main>
</body>

</html>