<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
    <link rel="icon" href="favicon.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Perpustakaan Aku</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-blue-50 flex items-center justify-center min-h-screen">
  <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
    <h2 class="text-2xl font-bold mb-6 text-center text-blue-700">Login</h2>
    <?php if (isset($_SESSION['error'])): ?>
      <div class="bg-red-100 text-red-600 p-3 mb-4 rounded"><?php echo $_SESSION['error'];
      unset($_SESSION['error']); ?>
      </div>
    <?php endif; ?>
    <form action="proses_login.php" method="POST" class="space-y-4">
      <div>
        <label class="block font-medium mb-1">Username</label>
        <input type="text" name="username" required
          class="w-full px-4 py-2 border rounded focus:ring focus:ring-blue-300">
      </div>
      <div>
        <label class="block font-medium mb-1">Password</label>
        <input id="password" type="password" name="password" required
          class="w-full px-4 py-2 border rounded focus:ring focus:ring-blue-300">
      </div>
      <button type="submit" class="w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800">Login</button>
    </form>

    <div class="checkbox-container mt-4">
      <input class="checkbox" type="checkbox"
        onclick="document.getElementById('password').type = this.checked ? 'text' : 'password'">
      <label>
        Show password
      </label>
    </div>
    <p class="mt-4 text-sm text-center">
      Belum punya akun?
      <a href="register.php" class="text-blue-600 hover:underline">Daftar di sini</a>
    </p>
      <p><a href="forgot_password.php">Lupa Password?</a></p>
  </div>
</body>

</html>