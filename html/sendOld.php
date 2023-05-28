<?php
session_start();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ethereum Blockchain</title>
    <link rel="stylesheet" href="../styles/navbar.css">

    <style>
        .body {
            background-image: url("../src/blur2.jpg");
            background-size: auto; background-position: center;

        }

        h1 {
            font-size: 100px;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }

        /* Default styles */
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-top: 14%;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            max-width: 1200px;
            justify-content: center;
        }

        .card {
            flex-basis: calc(33.33% - 40px);
            margin: 10px;
            padding: 20px;
            text-align: center;
            border-radius: 20px;
            transition: 700ms;
            background: linear-gradient(45deg, #667eea, #764ba2, #ed64a6);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            color: #fff;
        }




        /* Responsive styles */
        @media screen and (max-width: 768px) {
            .card {
                flex-basis: calc(50% - 40px);

            }

            h1 {
                margin-top: 35%;
                font-size: 70px;
                font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            }
        }

        @media screen and (max-width: 480px) {
            .card {
                flex-basis: calc(100% - 40px);
            }

            h1 {
                margin-top: 35%;
                font-size: 50px;
                font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            }
        }
    </style>
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
                <a href="../index.php">Home</a>
                <?php
                echo '<a href="./sendOld.php">Send</a>';
                ?>
                <a href="<?php
                            echo './receiveOld.php';
                            ?>">Receive</a>
                <?php
                echo '<a href="./login.php">Login</a>';
                ?>
            </div>


        </div>
    </div>


    <div class="container">
        <h1 class="title">Features of SendCrypto</h1>
        <div class="card-container">
            <div class="card">
                <h2 class="card-title">Secure Transactions</h2>
                <p class="card-description">The Send Crypto website ensures secure and encrypted transactions, providing a safe platform for sending cryptocurrencies.</p>
            </div>
            <div class="card">
                <h2 class="card-title">Instant Transfers</h2>
                <p class="card-description">Send Crypto allows for instant transfers of cryptocurrencies, ensuring quick and efficient transactions.</p>
            </div>
            <div class="card">
                <h2 class="card-title">User-Friendly Interface</h2>
                <p class="card-description">With its intuitive user interface, Send Crypto offers a seamless and easy-to-use platform for sending cryptocurrencies.</p>
            </div>
            <div class="card">
                <h2 class="card-title">Multi-Currency Support</h2>
                <p class="card-description">Send Crypto supports a wide range of cryptocurrencies, allowing users to send various digital assets.</p>
            </div>
            <div class="card">
                <h2 class="card-title">Transaction History</h2>
                <p class="card-description">Users can access their transaction history on the Send Crypto website, providing transparency and a record of past transactions.</p>
            </div>
            <div class="card">
                <h2 class="card-title">Mobile Compatibility</h2>
                <p class="card-description">Send Crypto is fully compatible with mobile devices, enabling users to send cryptocurrencies on the go.</p>
            </div>
        </div>
    </div>




</body>

</html>