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
  <meta charset="UTF-8">
  <link rel="icon" href="favicon.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perpustakaan - User</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
  <!-- Navbar -->
  <header class="bg-blue-700 text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-4 flex flex-col sm:flex-row justify-between items-center gap-4">
      <!-- Logo Judul -->
      <a href="laman_utama.php" class="text-2xl font-semibold flex items-center gap-2 ">
          Perpustakaan Digital
      </a>
      <!-- input search -->
      <div class="flex items-center gap-4 justify-between">
        <!-- navigasi -->
        <div class="gap-7">
          <a href="history.php" class="text-white hover:underline">history</a>
          <a href="user_home.php" class="text-white hover:underline ml-4">Daftar Buku</a>
        </div>
        <!-- Profil User -->
        <a href="profile.php" class="flex items-center gap-1 sm:order-2 flex ">
          <i class="fas fa-user-circle text-2xl"></i>
          <h3 class="hover:underline font-bold"><?php echo $_SESSION['username']; ?></h3>
        </a>

      </div>

    </div>
  </header>
  <!-- card -->
  <section id="book-list" class="bg-white rounded shadow-xl p-4 mb-6">
    <!-- Search Book Section -->
    <h2 class="text-xl font-semibold text-blue-700 flex items-center gap-2">
      <i class="fas fa-search"></i> Cari Buku
    </h2>
    <form " method=" GET" action="user_home.php" class="flex flex-col sm:flex-row gap-4">
      <input type="text" name="search" placeholder="Cari berdasarkan judul,penulis dan genre"
        class="flex-grow border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        value="<?php if (isset($_GET['search']))
          echo htmlspecialchars($_GET['search']); ?>" />
      <button type="submit" class="bg-blue-700 text-white px-5 py-2 rounded hover:bg-blue-800 transition">
        Cari
      </button>
    </form>
    <div>
    <h2 class="text-xl font-semibold mt-3 mb-4">Daftar Buku</h2>
     
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6 max-w-7xl mx-auto ">
      <?php
      // --- Pagination Setup ---
      $limit = 8;
      $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
      $offset = ($page - 1) * $limit;
      // hitung total buku
      $search = '';
      $whereClause = "WHERE status = 0";
      if (isset($_GET['search'])) {
        $search = $conn->real_escape_string($_GET['search']);
        $whereClause = "WHERE (judul LIKE '%$search%' OR penulis LIKE '%$search%' OR genre LIKE '%$search%' OR tahun LIKE '%$search%') AND status = 0";
      }

      $totalQuery = "SELECT COUNT(*) as total FROM perpus_buku $whereClause";
      $totalResult = $conn->query($totalQuery);
      $totalRow = $totalResult->fetch_assoc();
      $totalBooks = $totalRow['total'];

      $totalPages = ceil($totalBooks / $limit);

      // Query dengan limit dan offset
      $query = "SELECT * FROM perpus_buku $whereClause LIMIT $limit OFFSET $offset";
      $buku = $conn->query($query);
      while ($row = $buku->fetch_assoc()) {
        $status = $row['status'] == 1 ? 'Dipinjam' : 'Tersedia';

        echo "<div class='border rounded-lg p-4 shadow-lg hover:shadow-2xl transition duration-500  bg-white mx-w-xs'>";
        $gambar = !empty($row['images']) && file_exists("./images/uploads/" . $row['images'])
          ? "./images/uploads/" . $row['images']
          : "https://via.placeholder.com/300x400?text=Buku";

        echo "
<picture class='block w-full sm:max-w-full mb-3'>

  <img 
    src='$gambar' 
    alt='Gambar Buku' 
    class='w-full h-auto aspect-[3/4] object-cover rounded-lg'
    loading='lazy'
  >
</picture>";
        echo "<h3 class='text-lg truncate text-ellipsis font-bold text-blue-700 mb-1'>{$row['judul']}</h3>";
        echo "<p class='text-gray-700 truncate text-ellipsis'><strong>Penulis:</strong> {$row['penulis']}</p>";
        echo "<p class='text-gray-600 truncate text-ellipsis'><strong>Genre:</strong> {$row['genre']}</p>";

        // Simulasi rating bintang (static)
        echo "<div class='flex items-center mt-2 mb-3'>";
        for ($i = 0; $i < 5; $i++) {
          echo "<i class='fas fa-star text-yellow-400 mr-1'></i>";
        }
        echo "</div>";

        echo "<p class='text-sm mb-3'><strong>Status:</strong> <span class='font-medium'>$status</span></p>";
         echo "<a href='detail.php?id={$row['id']}' 
                  class='inline-block bg-blue-700 text-white px-4 py-2 mb-3 rounded w-full text-center hover:bg-blue-800 transition duration-500 hover:scale-105'>
                  <i class='fas fa-info-circle mr-2'></i>
                  Detail</a>";

        if ($row['status'] == 0) {
          echo "<a href='aksi_user.php?action=pinjam&id={$row['id']}' 
                  class='inline-block bg-blue-700 text-white px-4 py-2 rounded w-full text-center hover:bg-blue-800 transition duration-500 hover:scale-105'>
                  <i class='fas fa-book-reader mr-2'></i>
                  Pinjam</a>";
        }

        echo "</div>";

      }
      ?>
    </div>
    <!-- Pagination  -->
    <div class="mt-8 flex flex-wrap justify-center items-center gap-2">
      <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>"
          class="px-3 py-1 rounded bg-gray-200 text-gray-800 hover:bg-gray-300 transition">
          &laquo; Prev
        </a>
      <?php endif; ?>

      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"
          class="px-3 py-1 rounded <?= $i == $page ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' ?> transition">
          <?= $i ?>
        </a>
      <?php endfor; ?>

      <?php if ($page < $totalPages): ?>
        <a href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>"
          class="px-3 py-1 rounded bg-gray-200 text-gray-800 hover:bg-gray-300 transition">
          Next &raquo;
        </a>
      <?php endif; ?>
    </div>

  </section>

  <footer class="bg-blue-700 text-white text-center py-4 mt-8">
    <p>&copy; 2023 Perpustakaan. All rights reserved.</p>
  </footer>
</body>

</html>