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
session_start();

if (!isset($_SESSION['reset_otp'], $_SESSION['reset_otp_expiry'], $_POST['otp_input'])) {
    header("Location: forgot_password.php");
    exit;
}

$otp_input = $_POST['otp_input'];
$otp = $_SESSION['reset_otp'];
$expired = $_SESSION['reset_otp_expiry'];

if (time() > $expired) {
    // OTP kadaluarsa
    unset($_SESSION['reset_otp'], $_SESSION['reset_otp_expiry']);
    echo "Kode OTP sudah kadaluarsa. <a href='forgot_password.php'>Coba lagi</a>";
    exit;
}

if ($otp_input == $otp) {
    // OTP valid
    unset($_SESSION['reset_otp'], $_SESSION['reset_otp_expiry']); 
    header("Location: reset_password.php");
    exit;
} else {
    echo "Kode OTP salah. <a href='forgot_password.php'>Coba dari awal</a>";
}
?>
</body>
</html>