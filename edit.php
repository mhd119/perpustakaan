<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
  $id = (int) $_GET['id'];
  $result = $conn->query("SELECT * FROM perpus_buku WHERE id = $id");
  $buku = $result->fetch_assoc();
}
?>

<head>
  <meta charset="UTF-8">
  <title>Edit Buku</title>
  <link rel="icon" href="favicon.ico" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<h2 class="text-2xl font-semibold mb-4 flex justify-center">Edit Buku</h2>
<form method="POST" action="aksi.php" class="space-y-4 bg-white p-6 rounded-lg shadow-xl max-w-md mx-auto">
  <input type="hidden" name="aksi" value="edit">
  <input type="hidden" name="id" value="<?= $buku['id'] ?>">

  <div>
    <label class="block text-sm font-medium text-gray-700">Judul:</label>
    <input type="text" name="judul" value="<?= $buku['judul'] ?>"
      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
  </div>

  <div>
    <label class="block text-sm font-medium text-gray-700">Penulis:</label>
    <input type="text" name="penulis" value="<?= $buku['penulis'] ?>"
      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
  </div>

  <div>
    <label class="block text-sm font-medium text-gray-700">Tahun:</label>
    <input type="number" name="tahun" value="<?= $buku['tahun'] ?>"
      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
  </div>

  <div>
    <label class="block text-sm font-medium text-gray-700">Genre:</label>
    <input type="text" name="genre" value="<?= $buku['genre'] ?>"
      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
  </div>
  <div>
    <label class="block text-sm font-medium text-gray-700">deskripsi:</label>
    <input type="text" name="description" value="<?= $buku['description'] ?>"
      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
  </div>

  <button type="submit"
    class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
    Simpan Perubahan
  </button>
</form>