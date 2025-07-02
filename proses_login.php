<?php
session_start();
require 'koneksi.php'; // Pastikan koneksi sudah dimasukkan

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM perpus_users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    if ($user['role'] == 'admin') {
        header("Location: dashboard.php");
    } else {
        header("Location: laman_utama.php");
    }
    exit();
} else {
    $_SESSION['error'] = "Username atau password salah!";
    header("Location: index.php");
}
?>