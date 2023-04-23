<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Crypto</title>
    <link rel="stylesheet" type="text/css" href="./styles/navbar.css">
    <link rel="stylesheet" type="text/css" href="./styles/landing.css">


</head>

<body class="body">

    <div class="header">
        <div class="navbar">
            <div class="logo">
                <a href="">Send Crypto</a>
            </div>
            <ul class="navLinks">
                <li>
                    <a href="">Home</a>
                </li>
                <li>
                    <?php
                    // Start the session
                    session_start();

                    // Check if user is logged in
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                        // If user is logged in, display My Account link
                        echo '<a href="./html/send.php">Send</a>';
                    } else {
                        // If user is not logged in, display Login link
                        echo '<a href="./html/sendOld.php">Send</a>';
                    }
                    ?>
                </li>
                <li>
                    <a href="">Receive</a>
                </li>
                <li>
                    <?php
                    // Start the session
                    

                    // Check if user is logged in
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                        // If user is logged in, display My Account link
                        echo '<a href="./html/account/account.php">My Account</a>';
                    } else {
                        // If user is not logged in, display Login link
                        echo '<a href="./html/login.php">Login</a>';
                    }
                    ?>
                </li>
            </ul>
        </div>
    </div>

    <div class="landing-page-container">
        <h1 class="landing-page-title">Crypto Transfer Evolution</h1>
        <p class="landing-page-description">With our platform, you can easily transfer your cryptocurrencies to anyone, anywhere in the world.</p>
        <a href="./html/login.php">
            <button class="landing-page-button">Get Started</button>
        </a>
    </div>


</body>


</html>