<?php
// Set no-cache header
header("Cache-Control: no cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

include './sendMail.php';
include './OTP/generate_otp.php';
include './connection.php';

$conn = connect();  // connected to DB "./connection.php"

$email = mysqli_real_escape_string($conn, $_POST['email']);

// Check if email exists in database
$email_query = "SELECT * FROM accounttable WHERE email = '$email'";
$email_result = mysqli_query($conn, $email_query);

if (mysqli_num_rows($email_result) > 0) {
    // Email Exists, Send Mail > $email
    $otp = generate_random_int();
    // Add OTP in DB
    $update_otp = "UPDATE accounttable SET otp = $otp WHERE email = '$email'";
    mysqli_query($conn, $update_otp);
    
    // Now Send Mail - OTP
    sendMail($email,$otp);
    // Move to Verify OTP
    header("Location: ../database/verifyforgetotp.php?email=$email");
} else {
    echo "<script>
    alert('Email Not Found, Please SignUp');
    </script>";
}


?>

