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

        <div class="nav">
            <input type="checkbox" id="nav-check">
            <div class="nav-header">
                <div class="nav-title">
                    SendCrypto
                </div>
            </div>
            <div class="nav-btn">
                <label for="nav-check">
                    <span></span>
                    <span></span>
                    <span></span>
                </label>
            </div>

            <div class="nav-links">
                <a href="" target="">Home</a>
                <a href="<?php
                            // Start the session
                            session_start();

                            // Check if user is logged in
                            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                                // If user is logged in, set the appropriate URL
                                echo './html/send.php';
                            } else {
                                // If user is not logged in, set the appropriate URL
                                echo './html/sendOld.php';
                            }
                            ?>" target="">Send</a>
                <a href="<?php
                            // Check if user is logged in
                            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                                // If user is logged in, set the appropriate URL
                                echo './html/receive.php';
                            } else {
                                // If user is not logged in, set the appropriate URL
                                echo './html/receiveOld.php';
                            }
                            ?>" target="">Receive</a>
                <?php
                // Check if user is logged in
                if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                    // If user is logged in, display My Account link
                    echo '<a href="./html/account/account.php">My Account</a>';
                } else {
                    // If user is not logged in, display Login link
                    echo '<a href="./html/login.php">Login</a>';
                }
                ?>
            </div>

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