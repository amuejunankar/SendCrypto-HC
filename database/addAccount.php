<?php

require_once './OTP/generate_otp.php';
require_once './sendSMS/sendOTP.php';


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
        // Set email subject and body
        $mail->Subject = 'Verification OTP from SendCrypto';
        $mail->Body = "<div style='background-color: #1f1f1f; color: #f9f9f9; font-family: sans-serif; border-radius: 10px; padding: 20px;'>\n";
        $mail->Body .= "<h2 style='font-size: 24px; font-weight: bold; margin-top: 0;'>Verification OTP from SendCrypto</h2>\n";
        $mail->Body .= "<p style='font-size: 18px;'>Your verification OTP code is:</p>\n";
        $mail->Body .= "<div style='font-size: 32px; font-weight: bold; background-color: #333; padding: 10px; border-radius: 5px; display: inline-block; margin-bottom: 20px;'>$otp</div>\n";
        $mail->Body .= "<p style='font-size: 18px;'>Please enter this code to verify your account.</p>\n";
        $mail->Body .= "</div>";

        // Send the email
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}


include './connection.php';
$conn = connect();

// Retrieve form data
$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$mobileNumber = mysqli_real_escape_string($conn, $_POST['mobileNumber']);
$mobileCode = mysqli_real_escape_string($conn, $_POST['mobileCode']); // Retrieve mobile code

// Check if email already exists in database
$email_query = "SELECT * FROM accounttable WHERE email = '$email'";
$email_result = mysqli_query($conn, $email_query);
$row = mysqli_fetch_assoc($email_result);
$is_verified = $row['is_verified'];

if (mysqli_num_rows($email_result) > 0 && $is_verified == 1) {
    // Email already exists in the database and account is verified, show error message
    echo "Email already exists";
} else {
    // Generate OTP
    $otp = generate_random_int();
    $otpsms = generate_random_int();

    // Store it into the Database
    $sql = "UPDATE accounttable SET name = '$name', password = '$password', mobileNumber = '$mobileNumber', mobileCode = '$mobileCode', otp = '$otp', otpsms = '$otpsms' WHERE email = '$email'";
    if ($conn->query($sql) === true) {
        if ($conn->affected_rows > 0) {
            // Data updated successfully
        } else {
            // If no rows were affected, it means the email does not exist, so insert a new row
            $insertSql = "INSERT INTO accounttable (name, email, password, mobileNumber, mobileCode, otp, otpsms) VALUES ('$name', '$email', '$password', '$mobileNumber', '$mobileCode', '$otp', '$otpsms')";
            if ($conn->query($insertSql) === true) {
            }// Data inserted successfully
        }
    }

    sendSMS($_POST['mobileNumber'], $otpsms);

    if (mysqli_query($conn, $sql) && sendMail($_POST['email'], $otp)) {
        header("Location: ../database/verify.php?email=$email");
    } else {
        // Error occurred
    }
}

// Close connection
mysqli_close($conn);
