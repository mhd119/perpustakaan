<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $judul = $conn->real_escape_string($_POST['judul']);
  $penulis = $conn->real_escape_string($_POST['penulis']);
  $tahun = (int) $_POST['tahun'];
  $genre = $conn->real_escape_string($_POST['genre']);
  $description = $conn->real_escape_string($_POST['description']);

  // Upload gambar
  $imageName = $_FILES['images']['name'];
  $imageTmp = $_FILES['images']['tmp_name'];

  // Nama file unik
  $newImageName = uniqid() . "_" . $imageName;

  // Buat folder uploads jika belum ada
  if (!is_dir('images\uploads')) {
    mkdir('images\uploads');
  }

  // Pindahkan gambar ke folder uploads/
  if (move_uploaded_file($imageTmp, 'images/uploads/' . $newImageName)) {
    // Simpan data ke database
    $sql = "INSERT INTO perpus_buku (judul, penulis, tahun, genre,description, images, status) 
            VALUES ('$judul', '$penulis', $tahun, '$genre','$description', '$newImageName', 0)";

    if ($conn->query($sql) === TRUE) {
      header('Location:dashboard.php?message=success');
      exit();
    } else {
      echo "Gagal menambahkan buku: " . $conn->error;
    }
  } else {
    echo "Gagal mengupload gambar.";
  }

  $conn->close();
} else {
  echo "Metode tidak valid.";
}
?>