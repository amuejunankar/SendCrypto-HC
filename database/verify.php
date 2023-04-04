<?php
// connect DB
include './connection.php';
$conn = connect();


if (isset($_GET['email'])) {
    $email = $_GET['email'];

    // Email OTP
    $query = "SELECT otp FROM accounttable WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);


    // SMS OTP
    $query = "SELECT otpsms FROM accounttable WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result_sms = mysqli_stmt_get_result($stmt);


    if (mysqli_num_rows($result) > 0 && mysqli_num_rows($result_sms) > 0) {
        $row = mysqli_fetch_assoc($result);
        $otp_db = $row['otp'];

        $row2 = mysqli_fetch_assoc($result_sms);
        $otp_db_sms = isset($row2['otpsms']) ? $row2['otpsms'] : null;


        // Take input email and mobile OTp from user > u
        $uotp = isset($_POST['otp']) ? mysqli_real_escape_string($conn, $_POST['otp']) : '';
        $uotpsms = isset($_POST['otpsms']) ? mysqli_real_escape_string($conn, $_POST['otpsms']) : '';

        if ($otp_db == $uotp && $otp_db_sms == $uotpsms) {
            // OTP matches, update is_verified field to 1
            $update_query = "UPDATE accounttable SET is_verified = 1 WHERE email = ?";
            $stmt = mysqli_prepare($conn, $update_query);
            mysqli_stmt_bind_param($stmt, "s", $email);

            if (mysqli_stmt_execute($stmt)) {
                // Update successful
                $sql = "UPDATE accounttable SET otp = 0, otpsms = 0 WHERE email = '$email'";
                mysqli_query($conn, $sql);

                echo "<script>alert('Account verified successfully'); 
                window.location='../html/login.html';
                </script>";
            } else {
                // Error occurred while updating
                echo "<script>alert('Error updating database: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            // OTP did not match, show error message
            
        }
    } else {
        // No OTP found for the given email, show error message
        echo "No OTP found for the given email";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Account</title>
    <link rel="stylesheet" href="../styles/navbar.css">
    </head>
    

<body>

<style>
        .body {
            margin: 0;
            padding: 0;
        }

        .forgot-password-container {
            margin: 0 auto;
            width: 250px;
            text-align: center;
        }

        .forgot-password-div {
            color: #1e0f0f81;
        }

        .button {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            margin-top: 4px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            font-family: sans-serif;
        }

        .button:hover {
            background-color: #6f972e;
        }

        .login-container {
            background-size: cover;
            background-color: #4f6bff;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: sans-serif;
        }

        .login-form {
            background-color: hsla(240, 21%, 95%, 0.727);
            padding: 45px;
            border-radius: 10px;
            text-align: center;
            font-family: sans-serif;
        }

        .arrow {
            position: relative;
            margin-left: 20px;
            margin-bottom: -20px;
            opacity: 0.9;
        }

        .login-form h1 {
            margin-bottom: 30px;
        }

        .login-form label {
            display: block;
            text-align: left;
            margin-bottom: 10px;
        }

        .login-form input[type="text"] {
            width: 100%;
            padding: 10px 20px;
            margin: 1px 0;
            border: none;
            border-radius: 4px;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        .login-form button[type="submit"] {
            background-color: #4f6bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .login-form button[type="submit"]:hover {
            background-color: #5555d9;
        }
</style>


    <div class="header">
        <div class="navbar">
            <div class="logo">
                <a href="../index.html">Send Crypto</a>
            </div>
            <ul class="navLinks">
                <li>
                    <a href="../index.html">Home</a>
                </li>
                <li>
                    <a href="../html/send.html">Send</a>
                </li>
                <li>
                    <a href="">Receive</a>
                </li>
                <li>
                    <a href="../html/login.html">My Account</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="login-container">
        <div class="login-form-ot">
            <div class="login-form">
                <br>
                <h1>Verify Account</h1>
                <div class="forgot-password-container">
                    <div class="forgot-password-div">
                        <p>To verify your account, enter the OTP sent to your email and mobile number.</p>
                    </div>
                </div>
                <form method="POST" action="">
                    <label for="otp">Email OTP:</label>
                    
                    <input placeholder="Enter your Email OTP" type="text" pattern="[0-9]{6}" id="otp" name="otp" minlength="5" maxlength="6" required>
                    <br><br>
                    <label for="otpsms">Mobile OTP:</label>

                    <input placeholder="Enter your Mobile OTP" type="text" pattern="[0-9]{6}" id="otpsms" name="otpsms" minlength="5" maxlength="6" required>
                    <br><br>
                    <button class="button" type="submit">Verify</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>