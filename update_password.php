<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit;
}

$email = $_SESSION['reset_email'];
$password = $_POST['password'];
$confirm = $_POST['confirm_password'];

if ($password !== $confirm) {
    echo "Konfirmasi password tidak cocok. <a href='reset_password.php'>Kembali</a>";
    exit;
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);
$query = mysqli_query($conn, "UPDATE perpus_users SET password='$password_hash' WHERE email='$email'");

if ($query) {
    unset($_SESSION['reset_email']);
    echo "Password berhasil diubah. <a href='index.php'>Login Sekarang</a>";
} else {
    echo "Gagal memperbarui password. <a href='reset_password.php'>Coba lagi</a>";
}
?>