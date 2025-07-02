<?php
include 'koneksi.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama = htmlspecialchars($_POST['nama']);
  $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
  $email = htmlspecialchars($_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $role = 'user';

  $cek = $conn->query("SELECT * FROM perpus_users WHERE email = '$email'");
  if ($cek->num_rows > 0) {
    $message = "Email sudah terdaftar!";
  } else {
    $sql = "INSERT INTO perpus_users (username,nama_lengkap, email, password, role) VALUES ('$nama','$nama_lengkap', '$email', '$password', '$role')";
    if ($conn->query($sql) === TRUE) {
      header("Location: index.php?success=1");
      exit();
    } else {
      $message = "Pendaftaran gagal. Silakan coba lagi.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
    <link rel="icon" href="favicon.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register - Perpustakaan</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center text-blue-700">Daftar Akun Baru</h2>

    <?php if ($message): ?>
      <div class="mb-4 text-red-600 text-sm text-center font-medium"><?= $message ?></div>
    <?php endif; ?>

    <form action="" method="POST" class="space-y-4">
      <div>
        <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
        <input type="text" name="nama" required
          class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:ring-blue-300" />
      </div>
      <div>
        <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" required
          class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:ring-blue-300" />
      </div>
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" required
          class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:ring-blue-300" />
      </div>
      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input id="password" type="password" name="password" required
          class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:ring-blue-300" />
      </div>
      <button type="submit"
        class="w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800 transition">Daftar</button>
    </form>
    <div class="checkbox-container mt-4">
      <input class="checkbox" type="checkbox"
        onclick="document.getElementById('password').type = this.checked ? 'text' : 'password'">
      <label>
        Show password
      </label>
    </div>
    <p class="mt-4 text-sm text-center">
      Sudah punya akun?
      <a href="index.php" class="text-blue-600 hover:underline">Login di sini</a>
    </p>
  </div>
</body>

</html>