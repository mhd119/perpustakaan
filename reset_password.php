<?php
session_start();
if (!isset($_SESSION['reset_email'])) {
  header("Location: forgot_password.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <link rel="icon" href="favicon.ico" />
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Halaman untuk mereset password perpustakaan">
  <title>Reset Password</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center">

  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-4xl bg-white shadow-lg rounded-xl p-8">

      <!-- Kiri: Info / Progres -->
      <div class="flex flex-col justify-center text-center md:text-left">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Lupa Password</h2>
        <p class="text-gray-600 mb-2">Verifikasi Email</p>
       <p class="text-gray-500 text-sm"><?php echo $_SESSION['reset_email']; ?></p>
      </div>

      <!-- Kanan: Form Reset -->
      <div>
        <h2 class="text-xl font-bold mb-4 text-center md:text-left">Reset Password</h2>
        <form action="update_password.php" method="POST" class="space-y-4">
          <input type="password" name="password" placeholder="Password Baru" required
            class="w-full px-4 py-2 border rounded">
          <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required
            class="w-full px-4 py-2 border rounded">
          <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">Simpan
            Password</button>
        </form>
        <div class="text-center mt-4">
          <a href="index.php" class="text-blue-500 text-sm hover:underline">Kembali ke Login</a>
        </div>
      </div>

    </div>
  </div>


</body>

</html>
