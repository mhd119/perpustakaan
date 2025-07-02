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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
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
  <!-- detail -->
  <section class=" ">
    <div>
      <h1 class="text-2xl font-bold text-center mb-6">Detail Buku</h1>

      <?php
      $query = "SELECT * FROM perpus_buku WHERE id = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("i", $_GET['id']);
      $stmt->execute();
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
        // Tampilkan detail buku
      
        echo "<div class='flex ml-4 mr-4 border rounded-lg  shadow hover:shadow-md transition bg-white mx-w-xs'>";
        $gambar = !empty($book['images']) && file_exists("./images/uploads/" . $book['images'])
          ? "./images/uploads/" . $book['images']
          : "https://via.placeholder.com/300x400?text=Buku";

        echo "
<picture class='flex-shrink-0'>

  <img 
    src='$gambar' 
    alt='Gambar Buku' 
    class=' w-full h-60 aspect-[3/4] object-cover rounded-lg'
    loading='lazy'
  >
</picture>";
        echo "<div class='mb-4 ml-4'>";
        echo "<h1 class='text-2xl font-bold'>judul : " . htmlspecialchars($book['judul']) . "</h1>";
        echo "<p><strong>Penulis:</strong> " . htmlspecialchars($book['penulis']) . "</p>";
        echo "<p><strong>Genre:</strong> " . htmlspecialchars($book['genre']) . "</p>";
        // Simulasi rating bintang (static)
        echo "<div class='mt-2 mb-3'>";
        for ($i = 0; $i < 5; $i++) {
          echo "<i class='fas fa-star text-yellow-400 mr-1'></i>";
        }
        
      } else {
        echo "<p>Buku tidak ditemukan.</p>";
      }
      echo "<p><strong>Deskripsi:</strong> " . htmlspecialchars($book['description']) . "</p>";
      echo "</div>";
      ?>
    </div>
  </section>
</body>

</html>