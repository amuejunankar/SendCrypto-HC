<?php

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

// Used To Send Mail after Transaction is being processed or done-
function sendMailTransaction($email, $msg)
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
        $mail->Body    = "OTP code > $msg";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Used To Send Mail after Recharge is being processed
function sendMailRecharge($email, $msg)
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
        $mail->Subject = 'Recharge Successful - SendCrypto';

        $mail->Body = "<div style='background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 10px; padding: 20px;'>\n";
        $mail->Body .= "<h2 style='font-size: 24px; font-weight: bold; margin-top: 0;'>Send Crypto - Prepaid Recharge</h2>\n";
        $mail->Body .= "<p style='font-size: 18px;'>Recharge Details:</p>\n";
        $mail->Body .= "<ul style='font-size: 16px; list-style: none; padding-left: 0;'>\n";
        $mail->Body .= "<p style='font-size: 18px;'><strong>$msg</strong></p>\n";
        $mail->Body .= "</ul>\n";
        $mail->Body .= "</div>";

        // Send the email
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
