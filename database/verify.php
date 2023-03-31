<?php
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

if (isset($_GET['email'])) {
    $email = $_GET['email'];
    $query = "SELECT otp FROM accounttable WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $otp_db = $row['otp'];

        $uotp = mysqli_real_escape_string($conn, $_POST['otp']);

        if ($otp_db == $uotp) {
            // OTP matches, update is_verified field to 1
            $update_query = "UPDATE accounttable SET is_verified = 1 WHERE email = ?";
            $stmt = mysqli_prepare($conn, $update_query);
            mysqli_stmt_bind_param($stmt, "s", $email);
            
            if (mysqli_stmt_execute($stmt)) {
                // Update successful
                $sql = "UPDATE accounttable SET otp = 0 WHERE email = '$email'";
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
            echo "OTP did not match";
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
    <link rel="stylesheet" href="../styles/signup.css">
    <link rel="stylesheet" href="../styles/login.css">

    <style>
        .login-form input[type="text"] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        form {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }

        label {
            margin-right: 10px;
        }

        input,
        button {
            margin-left: 10px;
        }
    </style>
</head>

<body>
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
                        <p>To verify your account, please enter the One-Time Password (OTP) that has been sent to your email.</p>
                    </div>
                </div>
                <form method="POST" action="">
                    <input placeholder="Enter your OTP" type="text" pattern="[0-9]{6}" id="otp" name="otp" required>
                    <button class="button" type="submit">Verify</button>
                </form>

            </div>
        </div>
    </div>
</body>

</html>