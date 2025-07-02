<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" href="favicon.ico" />
  <title>Library Book Management</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">
  <header class="bg-blue-700 text-white shadow">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
      <a href="dashboard.php" class="flex items-center space-x-2">
        <h1 class="text-white text-lg font-semibold">Perpustakaan Digital</h1>
      </a>
    </div>
  </header>

  <main class="container mx-auto px-4 py-8 flex-grow">
    <!-- Add Book Section -->
    <section id="add-book" class="mb-12 bg-white rounded-lg shadow p-6 max-w-3xl mx-auto">
      <h2 class="text-xl font-semibold mb-4 text-blue-700 flex items-center gap-2">
        <i class="fas fa-plus-circle"></i> Tambah Data Buku
      </h2>
      <form id="form-add-book" method="POST" action="tambah.php" enctype="multipart/form-data" class="space-y-4">
        <div>
          <label for="judul" class="block font-medium mb-1">Judul Buku</label>
          <input type="text" id="judul" name="judul" required
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Masukkan judul buku" />
        </div>
        <div>
          <label for="penulis" class="block font-medium mb-1">Penulis</label>
          <input type="text" id="penulis" name="penulis" required
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Masukkan nama penulis" />
        </div>
        <div>
          <label for="tahun" class="block font-medium mb-1">Tahun Terbit</label>
          <input type="number" id="tahun" name="tahun" min="1000" max="2099" required
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Masukkan tahun terbit" />
        </div>
        <div>
          <label for="genre" class="block font-medium mb-1">Genre</label>
          <input type="text" id="genre" name="genre" required
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Masukkan genre buku" />
        </div>
        <div>
          <label for="description" class="block font-medium mb-1">Deskripsi</label>
          <input type="text" id="description" name="description" required
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Masukkan genre buku" />
        </div>
        <div>
          <label for="images" class="block font-medium mb-1">Images</label>
          <input type="file" id="images" name="images" accept="asset/*" required
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Masukkan gambar buku" accept="image/*" />
          <img id="preview-image" class="mt-2 max-h-48" style="display: none;" />
        </div>
        <button type="submit" id="tambah" class="bg-blue-700 text-white px-5 py-2 rounded hover:bg-blue-800 transition">
          Tambah Buku
        </button>
      </form>
    </section>

    <!-- Search Book Section -->
    <section id="search-book" class="mb-12 bg-white rounded-lg shadow p-6 max-w-3xl mx-auto">
      <h2 class="text-xl font-semibold mb-4 text-blue-700 flex items-center gap-2">
        <i class="fas fa-search"></i> Cari Buku
      </h2>
      <form id="form-search-book" method="GET" action="dashboard.php #book-list"
        class="flex flex-col sm:flex-row gap-4">
        <input type="text" name="search" placeholder="Cari berdasarkan judul,penulis dan genre"
          class="flex-grow border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
          value="<?php if (isset($_GET['search']))
            echo htmlspecialchars($_GET['search']); ?>" />
        <button type="submit" class="bg-blue-700 text-white px-5 py-2 rounded hover:bg-blue-800 transition">
          Cari
        </button>
      </form>
    </section>

    <!-- Book List Section -->
    <section id="book-list" class="bg-white rounded-lg shadow p-6 max-w-5xl mx-auto">
      <h2 class="text-xl font-semibold mb-6 text-blue-700 flex items-center gap-2">
        <i class="fas fa-book"></i> Daftar Buku
      </h2>

      <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded">
          <thead class="bg-blue-100 text-blue-900">
            <tr>
              <th class="text-left px-4 py-2 border-b border-blue-200">#</th>
              <th class="text-left px-4 py-2 border-b border-blue-200">Judul</th>
              <th class="text-left px-4 py-2 border-b border-blue-200">Penulis</th>
              <th class="text-left px-4 py-2 border-b border-blue-200">Tahun</th>
              <th class="text-left px-4 py-2 border-b border-blue-200">Genre</th>
              <th class="text-left px-4 py-2 border-b border-blue-200">images</th>
              <th class="text-center px-4 py-2 border-b border-blue-200">Status</th>
              <th class="text-center  px-4 py-2 border-b border-blue-200">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php

            include 'koneksi.php';

            $limit = 5; // jumlah data per halaman
            $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
            $start = ($page - 1) * $limit;

            $search = '';
            $whereClause = '';
            if (isset($_GET['search'])) {
              $search = $conn->real_escape_string($_GET['search']);
              $whereClause = "WHERE judul LIKE '%$search%' OR penulis LIKE '%$search%' OR genre LIKE '%$search%'";
            }

            // Hitung total data
            $countSql = "SELECT COUNT(*) as total FROM perpus_buku $whereClause";
            $countResult = $conn->query($countSql);
            $rowCount = $countResult->fetch_assoc();
            $total = $rowCount['total'];
            $pages = ceil($total / $limit);

            // Ambil data sesuai halaman
            $sql = "SELECT * FROM perpus_buku $whereClause ORDER BY id DESC LIMIT $start, $limit";
            $result = $conn->query($sql);

            $no = $start + 1;

            if ($result && $result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<tr class='hover:bg-gray-50'>";
                echo "<td class='px-4 py-2 border-b border-gray-200'>{$no}</td>";
                echo "<td class='px-4 py-2 border-b border-gray-200'>{$row['judul']}</td>";
                echo "<td class='px-4 py-2 border-b border-gray-200'>{$row['penulis']}</td>";
                echo "<td class='px-4 py-2 border-b border-gray-200'>{$row['tahun']}</td>";
                echo "<td class='px-4 py-2 border-b border-gray-200'>{$row['genre']}</td>";
                echo "<td class='px-4 py-2 w-8 h-7 border-b border-gray-200'>";
                echo "<img src='./images/uploads/" . $row['images'] . "' alt='Gambar Alat'>";
                echo "</td>";
                echo "<td class='text-center'>
        <div class='text-red-600 font-semibold mb-1'>" . ($row['status'] == 1 ? "Dipinjam" : "Tersedia") . "</div>";

                if ($row['status'] == 1) {
                  echo "<button onclick=\"openModal('modalDetail{$row['id']}')\" class=\"bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm\">Detail</button>";
                }

                echo "</td>";
                echo "<td class='px-4 py-2 border-b border-gray-200 text-center'>";
                echo "<div class='flex justify-center items-center space-x-2'>";
                echo "<a href='edit.php?id={$row['id']}' class='text-yellow-600 hover:text-yellow-800' title='Edit'><i class='fas fa-edit'></i></a>";
                echo "<a href='aksi.php?aksi=hapus&id={$row['id']}' onclick='return confirm(\"Yakin ingin menghapus buku ini?\")' class='text-red-600 hover:text-red-800' title='Hapus'><i class='fas fa-trash-alt'></i></a>";
                echo "</div>";
                echo "</td>";
                echo "</tr>";
                $no++;
              }
            } else {
              echo "<tr><td colspan='8' class='text-center py-6 text-gray-500'>Tidak ada data buku ditemukan.</td></tr>";
            }

            $conn->close();
            ?>
          </tbody>
        </table>
        <!-- pagination -->
        <div class="mt-4 flex justify-center items-center space-x-2">
          <?php
          // Tombol "Previous"
          if ($page > 1) {
            $prevPage = $page - 1;
            echo "<a href='?page=$prevPage&search=" . urlencode($search) . "' class='px-3 py-1 rounded bg-gray-200 text-gray-800 hover:bg-gray-300'>&laquo; Prev</a>";
          }

          // Nomor halaman
          for ($i = 1; $i <= $pages; $i++) {
            $active = $i == $page ? "bg-blue-600 text-white" : "bg-gray-200 text-gray-800 hover:bg-gray-300";
            echo "<a href='?page=$i&search=" . urlencode($search) . "' class='px-3 py-1 rounded $active'>$i</a>";
          }

          // Tombol "Next"
          if ($page < $pages) {
            $nextPage = $page + 1;
            echo "<a href='?page=$nextPage&search=" . urlencode($search) . "' class='px-3 py-1 rounded bg-gray-200 text-gray-800 hover:bg-gray-300'>Next &raquo;</a>";
          }
          ?>
        </div>
        <!-- modal -->
        <?php

        include 'koneksi.php';
        $sql = "SELECT * FROM perpus_buku ORDER BY id DESC";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
          if ($row['status'] == 1) {
            $id_buku = $row['id'];
            $queryPinjam = "SELECT p.*, u.username, u.email 
                        FROM perpus_peminjaman p 
                        JOIN perpus_users u ON p.user_id = u.id 
                        WHERE p.buku_id = $id_buku AND p.status = 'dipinjam' 
                        ORDER BY p.id DESC LIMIT 1";
            $resPinjam = mysqli_query($conn, $queryPinjam);
            $pinjam = mysqli_fetch_assoc($resPinjam);
            if ($pinjam) {
              ?>
              <!-- Modal Detail Peminjam -->
              <div id="modalDetail<?= $id_buku ?>"
                class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 relative">
                  <button onclick="closeModal('modalDetail<?= $id_buku ?>')"
                    class="absolute top-2 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
                  <h2 class="text-xl font-semibold mb-4 text-blue-700">Detail Peminjam</h2>
                  <div class="space-y-2 text-gray-700">
                    <p><span class="font-semibold">Nama:</span> <?= htmlspecialchars($pinjam['username']); ?></p>
                    <p><span class="font-semibold">Email:</span> <?= htmlspecialchars($pinjam['email']); ?></p>
                    <p><span class="font-semibold">Judul Buku:</span> <?= htmlspecialchars($row['judul']); ?></p>
                    <p><span class="font-semibold">Tanggal Pinjam:</span> <?= htmlspecialchars($pinjam['tanggal_pinjam']); ?>
                    </p>
                  </div>
                </div>
              </div>
              <?php
            }
          }
        }
        $conn->close();
        ?>

      </div>
    </section>
  </main>

  <footer class="bg-blue-700 text-white py-4 mt-auto">
    <div class="container mx-auto px-4 text-center text-sm">
      &copy; 2024 Perpustakaan. All rights reserved.
    </div>
  </footer>
</body>
<!-- modal -->
<script>
  function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
  }

  function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
  }
</script>
<!-- menampilkan gambar -->
<script>
  document.getElementById("images").addEventListener("change", function (event) {
    const file = event.target.files[0];
    const preview = document.getElementById("preview-image");

    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        preview.src = e.target.result;
        preview.style.display = "block";
      };
      reader.readAsDataURL(file);
    } else {
      preview.src = "";
      preview.style.display = "none";
    }
  });
</script>

</html>