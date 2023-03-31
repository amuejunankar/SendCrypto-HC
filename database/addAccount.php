<?php

require_once './OTP/generate_otp.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function sendMail($email, $otp)
{
    require("PHPMailer/PHPMailer.php");
    require("PHPMailer/SMTP.php");
    require("PHPMailer/Exception.php");

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'mail.sendcrypto@gmail.com';                     //SMTP username
        $mail->Password   = 'juoajcewwpuigyvh';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('mail.sendcrypto@gmail.com', 'SendCrypto');
        $mail->addAddress($email);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Verification OTP from SendCrypto';
        $mail->Body    = "OTP code > $otp";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}



// Replace database credentials with your own
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "account";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve form data
$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$mobileNumber = mysqli_real_escape_string($conn, $_POST['mobileNumber']);
$mobileCode = mysqli_real_escape_string($conn, $_POST['mobileCode']); // Retrieve mobile code

// Check if email already exists in database
$email_query = "SELECT * FROM accounttable WHERE email = '$email'";
$email_result = mysqli_query($conn, $email_query);

if (mysqli_num_rows($email_result) > 0) {
    // Email already exists in database, show error message
    echo "Email already exists";
} else {
    // Generate OTP
    $otp = generate_random_int();
    echo $otp; // Print OTP

    // Store it into the Database
    $sql = "INSERT INTO accounttable (name, email, password, mobileNumber, mobileCode, otp) VALUES ('$name', '$email', '$password', '$mobileNumber', '$mobileCode','$otp')";
    // Execute SQL query

    if (mysqli_query($conn, $sql) && sendMail($_POST['email'], $otp)) {
        // Successfully inserted data
        header("Location: ../database/verify.php?email=$email");
        
    } else {
        // Error occurred
    }
}

// Close connection
mysqli_close($conn);
