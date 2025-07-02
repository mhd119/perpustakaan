<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <link rel="icon" href="favicon.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Halaman untuk mengatur ulang password perpustakaan">
  <title>Lupa Password</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center">

  <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
    <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Lupa Password</h2>

    <form action="verify_email.php" method="POST" class="space-y-5">
      <div>
        <label class="block text-gray-700">Masukkan Email:</label>
        <input type="email" name="email" required
          class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
      </div>

      <button type="submit"
        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition duration-200">
        Kirim OTP
      </button>
    </form>

    <p class="text-center text-sm text-gray-500 mt-6">
      <a href="index.php" class="text-blue-500 hover:underline">Kembali ke Login</a>
    </p>
  </div>

</body>

</html>