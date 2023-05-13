<?php
header("Cache-Control: no cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
// connect DB
include './connection.php';
$conn = connect();
$token = $_GET['token'];

if (isset($_GET['email']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
    $email = $_GET['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $stmt = mysqli_prepare($conn, "SELECT otp FROM accounttable WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $_GET['email']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $otp);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    
    $query = "SELECT token FROM accounttable WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $token_db = $stmt->get_result()->fetch_assoc()['token'];

    if ($password === $confirm_password && $token == $token_db ) {
        $sql2 = "UPDATE accounttable SET token = '0' WHERE email = '$email'";
        mysqli_query($conn, $sql2);

        // Update Password
        $sql = "UPDATE accounttable SET password = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $password, $email);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        echo "<script>
                alert('Your password has been changed successfully. Please click OK to proceed to the login page.!!'); 
                window.location='../html/login.php';
            </script>";
        exit;
    } else {
        
    } 
}


?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../styles/login.css">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/signup.css">

</head>

<body>

    <div class="header">
        <div class="navbar">
            <div class="logo">
                <a href="../index.php">Send Crypto</a>
            </div>
            <ul class="navLinks">
                <li>
                    <a href="../index.php">Home</a>
                </li>
                <li>
                    <a href="">Send</a>
                </li>
                <li>
                    <a href="">Receive</a>
                </li>
                <li>
                    <a href="../html/login.php">My Account</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="login-container">
        <div class="login-form">
            <h1>Reset Password</h1>
            <form method="POST" action="">
                <label for="password">Password:</label>
                <input placeholder="Enter a Password" type="password" id="password" name="password" required />

                <label for="confirm_password">Confirm Password:</label>
                <input placeholder="Confirm your Password" type="password" id="confirm_password" name="confirm_password" required onkeyup='checkPasswordMatch();'>

                <div id="password-match"></div>
                <button class="button" type="submit">Continue</button>

                <hr>

            </form>
        </div>
    </div>

    <script>
        function checkPasswordMatch() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;

            if (password != confirmPassword) {
                document.getElementById("password-match").innerHTML = "Passwords do not match!";
            } else {
                document.getElementById("password-match").innerHTML = "";
            }
        }
    </script>

</body>

</html>