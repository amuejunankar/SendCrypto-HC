<!DOCTYPE html>
<html>

<head>
    <title>Ethereum Blockchain</title>
    <link rel="stylesheet" href="../styles/navbar.css">
    <style>
        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
        }

        .title {
            text-align: center;
            font-size: 48px;
            margin-bottom: 30px;
            animation: titleFadeIn 1s ease-in;
        }

        .card-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            width: 300px;
            padding: 20px;
            background-color: #ffffff;
            margin: 0 10px;
            text-align: center;
            border-radius: 5px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            animation: cardFadeIn 1s ease-in;
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333333;
        }

        .card-description {
            font-size: 16px;
            color: #777777;
        }

        @keyframes titleFadeIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes cardFadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
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
                    <a href="./send.php">Send</a>
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
                      echo '<a href="./account/account.php">My Account</a>';
                    } else {
                      // If user is not logged in, display Login link
                      echo '<a href="./login.php">Login</a>';
                    }
                    ?>
                  </li>
            </ul>
        </div>
    </div>


    <div class="container">
        <h1 class="title">Ethereum Blockchain</h1>
        <div class="card-container">
            <div class="card">
                <h2 class="card-title">Decentralized Transactions</h2>
                <p class="card-description">Ethereum blockchain enables secure and transparent transactions without the
                    need for intermediaries.</p>
            </div>
            <div class="card">
                <h2 class="card-title">Smart Contracts</h2>
                <p class="card-description">Ethereum's smart contracts allow for self-executing agreements, automating
                    processes and reducing costs.</p>
            </div>
            <div class="card">
                <h2 class="card-title">Tokenization</h2>
                <p class="card-description">Ethereum supports token creation, allowing for the representation of digital
                    assets, currencies, and more.</p>
            </div>
        </div>
    </div>
</body>

</html>