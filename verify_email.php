
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
include 'koneksi.php';
session_start();

$email = mysqli_real_escape_string($conn, $_POST['email']);
$query = mysqli_query($conn, "SELECT * FROM perpus_users WHERE email = '$email'");

if (mysqli_num_rows($query) > 0) {
    $_SESSION['reset_email'] = $email;

    // Generate OTP dan waktu kadaluarsa
    $otp = rand(100000, 999999);
    $_SESSION['reset_otp'] = $otp;
    $_SESSION['reset_otp_expiry'] = time() + 120;
    echo "<div class='max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow-md'>";

    echo "<p class='mb-4 text-lg'>Kode OTP Anda: <strong class='text-blue-600 text-xl'>$otp</strong></p>";

    echo "
<form action='verify_otp.php' method='POST' class='space-y-4'>
  <label class='block text-gray-700 font-medium'>Masukkan Kode OTP (berlaku 5 menit):</label>
  <input type='text' name='otp_input' required
         class='w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400' />
  
  <button type='submit' class='w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition duration-200'>
    Verifikasi
  </button>
</form>";

    echo "</div>";
} else {
    echo "Email tidak ditemukan. <a  href='forgot_password.php'>Coba lagi</a>";
}
?>
</body>
</html>
