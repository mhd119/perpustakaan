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
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <link rel="icon" href="favicon.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="global.css" />
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  <title>Tentang Kami - Perpustakaan</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans text-gray-700">
  <header class="bg-blue-700 text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-4 flex flex-col sm:flex-row justify-between items-center gap-4">
      <!-- Logo Judul -->
      <a href="laman_utama.php" class="text-2xl font-semibold flex items-center gap-2 ">
        Perpustakaan Digital
      </a>
      <div class="flex items-center gap-4 justify-between">
        <!-- Profil User -->
        <a href="profile.php" class="flex items-center gap-1 sm:order-2 flex ">
          <i class="fas fa-user-circle text-2xl"></i>
          <h3 class="hover:underline"><?php echo $_SESSION['username']; ?></h3>
        </a>

      </div>

    </div>
  </header>
  <!-- Hero Section -->
  <section class="  ">
    <div class="relative">
      <img src="images\image\background.jpg" class="w-full h-screen object-cover" />
      <div class="absolute inset-0 bg-black bg-opacity-40"></div>
      <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white">
        <h1 class=" hero text-4xl font-bold drop-shadow-lg">Selamat Datang di Perpustakaan Digital</h1>
        <p class="hero text-lg mt-2 drop-shadow-md">Mari kembangkan budaya membaca untuk menambah ilmu pengetahuan </p>
        <div>
          <button data-aos="fade-up" data-aos-duration="3000"
            class="bg-blue-600 text-white px-6 py-3 rounded-full hover:bg-blue-700 transition mt-4 ">
            <a href="user_home.php"
              class="bg-blue-600 text-white px-6 py-3 rounded-full hover:bg-blue-700 transition mt-4">Mulai
              Membaca</a>
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- Info Singkat -->
  <section class="bg-gray-200 py-12">
    <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-6 text-center">
      <div data-aos="fade-up" data-aos-duration="2000"
        class="p-6 rounded shadow-xl hover:shadow-2xl transition duration=500">
        <h3 class="text-xl font-semibold text-blue-600 mb-2">Akses Mudah</h3>
        <p>Akses buku digital kapan saja dan di mana saja secara online.</p>
      </div>
      <div data-aos="fade-up" data-aos-duration="2500" class="p-6 rounded shadow-xl hover:shadow-2xl transition">
        <h3 class="text-xl font-semibold text-blue-600 mb-2">Referensi Akademik</h3>
        <p>Cocok untuk pelajar dan mahasiswa sebagai sumber literatur.</p>
      </div>
      <div data-aos="fade-up" data-aos-duration="3000" class="p-6 rounded shadow-xl hover:shadow-2xl transition">
        <h3 class="text-xl font-semibold text-blue-600 mb-2">Untuk Umum</h3>
        <p>Terbuka untuk seluruh masyarakat tanpa batasan usia atau profesi.</p>
      </div>
    </div>
  </section>

  <!-- Tentang & Visi Misi -->
  <section class="py-16 bg-gray-100 shadow-md">
    <div class="max-w-6xl mx-auto px-6">
      <div class="md:grid md:grid-cols-2 md:gap-10 items-center">
        <div>
          <h2 class="text-3xl font-bold text-blue-600 mb-4">Tentang Kami</h2>
          <p class="mb-4" data-aos="fade-up" data-aos-duration="3000">
            Perpustakaan Digital adalah website proyek akhir semester yang menyediakan layanan peminjaman dan pembacaan
            buku digital untuk masyarakat umum. Website ini dibangun dengan tujuan meningkatkan literasi dan kemudahan
            akses terhadap referensi ilmiah.
          </p>
        </div>
        <div>
          <img src="images/image/profile.jpeg" alt="Perpustakaan" class="rounded-lg shadow-lg" />
        </div>
      </div>

      <div class="mt-12 grid md:grid-cols-2 gap-10">
        <div data-aos="fade-up" data-aos-duration="3000" >
          <h3 class="text-xl font-semibold text-blue-600 mb-2">Visi</h3>
          <p>
            Menjadi perpustakaan digital yang inklusif dan mudah diakses, mendukung perkembangan literasi masyarakat.
          </p>
        </div>
        <div data-aos="fade-up" data-aos-duration="3000">
          <h3  class="text-xl font-semibold text-blue-600 mb-2">Misi</h3>
          <ul  class="list-disc list-inside space-y-1">
            <li>Menyediakan koleksi buku digital yang variatif.</li>
            <li>Memudahkan pencarian, peminjaman, dan pengembalian buku.</li>
            <li>Memberikan pengalaman membaca yang nyaman dan modern.</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- Fitur -->
  <section class="bg-gray-200 py-16">
    <div class="max-w-6xl mx-auto px-6 text-center">
      <h2 class="text-3xl font-bold text-blue-600 mb-10">Fitur Perpustakaan</h2>
      <div class="grid md:grid-cols-3 gap-8 text-left">
        <div data-aos="fade-up" data-aos-duration="2000" class="p-6 rounded shadow-xl hover:shadow-2xl transition">
          <h4 class="text-xl font-semibold mb-2">Pencarian Buku</h4>
          <p>Cari buku berdasarkan judul, penulis, atau genre.</p>
        </div>
        <div data-aos="fade-up" data-aos-duration="2500" class="p-6 rounded shadow-xl hover:shadow-2xl transition">
          <h4 class="text-xl font-semibold mb-2">Peminjaman Online</h4>
          <p>Lakukan peminjaman buku digital secara langsung dari akun pengguna.</p>
        </div>
        <div data-aos="fade-up" data-aos-duration="3000" class="p-6 rounded shadow-xl hover:shadow-2xl transition">
          <h4 class="text-xl font-semibold mb-2">Riwayat Pinjaman</h4>
          <p>Lihat riwayat buku yang telah dipinjam dan status pengembaliannya.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Kontak -->
  <section class="bg-blue-600 text-white py-16">
    <div class="max-w-4xl mx-auto px-6 text-center">
      <h2 class="text-3xl font-bold mb-4">Ingin tahu lebih lanjut?</h2>
      <p class="mb-6">Silakan hubungi kami jika Anda memiliki pertanyaan seputar layanan perpustakaan ini.</p>
      <form class="grid md:grid-cols-3 gap-4 max-w-2xl mx-auto">
        <input type="text" placeholder="Nama" class="p-2 rounded text-black" required />
        <input type="email" placeholder="Email" class="p-2 rounded text-black" required />
        <input type="text" placeholder="Pesan" class="p-2 rounded text-black col-span-full" required />
        <button type="submit"
          class="bg-white text-blue-600 font-semibold px-4 py-2 rounded hover:bg-gray-100 col-span-full">Kirim
          Pesan</button>
      </form>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-blue-700 text-white text-center py-4 ">
    <p>&copy; 2023 Perpustakaan. All rights reserved.</p>
  </footer>
  <!-- aos -->
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init(
      {
        once: true,
        easing: 'ease-in-out',
        disable: 'mobile',
      }
    );
  </script>
</body>

</html>