<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "db_perpus";
$conn = mysqli_connect($host, $user, $pass, $db);
if ($conn == false) {

    die("Koneksi gagal: " . mysqli_connect_error());

}

?>