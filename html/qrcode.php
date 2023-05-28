<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan And Pay Crypto</title>
    <link rel="stylesheet" href="../styles/navbar.css">

</head>

<body>
    <style>
        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
            border-radius: 14px;
        }

        #reader {
            width: 250px;
            height: 250px;
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            border-radius: 12px;
        }

        #result {
            margin-top: 20px;
            font-size: 16px;
            color: #333;
        }
    </style>

    <div class="main-container">

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
                    <a href="../index.php" target="">Home</a>
                    <?php
                    // Start the session

                    // Check if user is logged in
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                        // If user is logged in, display My Account link
                        echo '<a href="./send.php">Send</a>';
                    } else {
                        // If user is not logged in, display Login link
                        echo '<a href="./sendOld.php">Send</a>';
                    }
                    ?>
                    <?php
                    // Start the session
                    // Check if user is logged in
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                        // If user is logged in, display My Account link
                        echo '<a href="./receive.php">Receive</a>';
                    } else {
                        // If user is not logged in, display Login link
                        echo '<a href="./receiveOld.php">Receive</a>';
                    }
                    ?>

                    <?php
                    // Check if user is logged in
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                        // If user is logged in, display My Account link
                        echo '<a href="./account/account.php">My Account</a>';
                    } else {
                        // If user is not logged in, display Login link
                        echo '<a href="../html/login.php">Login</a>';
                    }
                    ?>
                </div>
            </div>


        </div>
        <br></br><br></br>



        <main>
            <div id="reader"></div>
            <div id="result"></div>
        </main>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.4/html5-qrcode.min.js" integrity="sha512-k/KAe4Yff9EUdYI5/IAHlwUswqeipP+Cp5qnrsUjTPCgl51La2/JhyyjNciztD7mWNKLSXci48m7cctATKfLlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        const scanner = new Html5QrcodeScanner('reader', {
            qrbox: {
                width: 250,
                height: 250,
            },
            fps: 30,
        });

        scanner.render(success, error);

        function success(result) {
            if (/^\d{10}$/.test(result)) {
                const url = `sendCrypto/sendNumberScan.php?toAddress=${result}`;
                window.location.href = url;
            } else if (/^[a-zA-Z0-9]{42}$/.test(result)) {
                const url = `sendCrypto/sendAddressScan.php?toAddress=${result}`;
                window.location.href = url;
            } else {
                alert('Invalid recipient mobile number or Ethereum address. Please try again.');
                scanner.restart();
            }
        }

        function error(err) {
            console.error(err);
        }
    </script>
</body>

</html>