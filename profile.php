<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data user
$query = "SELECT username, nama_lengkap, email, foto_profile FROM perpus_users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Proses update profil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
  $email = htmlspecialchars($_POST['email']);
  $foto_profil = $user['foto_profile'];

  // Cek jika ada file diupload
  if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
    $namaFile = $_FILES['foto']['name'];
    $tmpFile = $_FILES['foto']['tmp_name'];
    $ekstensi = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
    $ekstensiValid = ['jpg', 'jpeg', 'png'];

    if (in_array($ekstensi, $ekstensiValid)) {
      $namaBaru = uniqid() . '.' . $ekstensi;
      $folder = "images/user_profil/";
      if (move_uploaded_file($tmpFile, $folder . $namaBaru)) {
        if (!empty($user['foto_profile']) && $user['foto_profile'] !== 'default-avatar.jpg') {
          $oldPath = $folder . $user['foto_profile'];
          if (file_exists($oldPath)) {
            unlink($oldPath);
          }
        }
        $foto_profil = $namaBaru; // hanya simpan nama file
      }
    }
  }

  // Simpan ke database
  $updateQuery = "UPDATE perpus_users SET nama_lengkap = ?, email = ?, foto_profile = ? WHERE id = ?";
  $updateStmt = $conn->prepare($updateQuery);
  $updateStmt->bind_param("sssi", $nama_lengkap, $email, $foto_profil, $user_id);
  $updateStmt->execute();

  $_SESSION['message'] = "Profil berhasil diperbarui!";
  header("Location: profile.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Profil - User</title>
  <link rel="icon" href="favicon.ico" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

  <!-- Navbar -->
  <header class="bg-blue-700 text-white p-4 shadow-md">
    <div class="max-w-6xl mx-auto flex justify-between items-center">
      <a href="laman_utama.php" class="text-xl font-semibold flex items-center gap-2">
        Perpustakaan Digital
      </a>
      <div class="flex items-center gap-4">
        <a href="user_home.php" class="hover:underline">Daftar Buku</a>
        <a href="profile.php" class="hover:underline"><?php echo $_SESSION['username']; ?></a>
        <a href="logout.php" class="hover:underline">Logout</a>
      </div>
    </div>
  </header>

  <!-- Main -->
  <main class="p-6 max-w-xl mx-auto bg-white rounded shadow my-6">
    <h2 class="text-2xl font-bold text-center mb-4"><?php echo $_SESSION['username']; ?></h2>

    <?php if (isset($_SESSION['message'])): ?>
      <div class="bg-green-100 text-green-700 p-2 rounded mb-4 text-center">
        <?= $_SESSION['message'];
        unset($_SESSION['message']); ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data" class="space-y-4">
      <!-- Foto Profil -->
      <div class="text-center">

        <?php
        $fotoFile = !empty($user['foto_profile']) ? $user['foto_profile'] : 'default-avatar.jpg';
        $fotoPath = 'images/user_profil/' . $fotoFile;
        ?>
        <img id="preview" src="<?= $fotoPath ?>" alt="Foto Profil"
          class="w-32 h-32 object-cover rounded-full mx-auto border shadow">

        <label for="foto" class="cursor-pointer bg-gray-400 text-white px-2 py-1 mt- rounded hover:bg-blue-600">
          <i class="fas fa-camera"></i> 
        </label>
        <input type="file" name="foto" id="foto" class="hidden" accept="image/*" onchange="loadPreview(event)">

      </div>

      <!-- Input Nama -->
      <div>
        <label for="nama_lengkap" class="block text-gray-700">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" id="nama_lengkap" value="<?= htmlspecialchars($user['nama_lengkap']); ?>"
          class="w-full p-2 border rounded" required>
      </div>

      <!-- Input Email -->
      <div>
        <label for="email" class="block text-gray-700">Email</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']); ?>"
          class="w-full p-2 border rounded" required>
      </div>

      <!-- Submit -->
      <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition">
        Perbarui Profil
      </button>
    </form>
  </main>

  <script>
    function previewImage(input) {
      const file = input.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = e => {
          document.getElementById("preview").src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    }
  </script>

</body>

</html>