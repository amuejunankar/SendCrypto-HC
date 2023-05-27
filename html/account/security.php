<!DOCTYPE html>
<html>

<head>
    <title>Delete Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/navbar.css">
    <link rel="stylesheet" href="./styles/sidebar.css">
    <link rel="stylesheet" href="./styles/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-xxx" crossorigin="anonymous" />


    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 40px auto;
            padding: 40px;
            height: 450px;
            background-color: #ffffff;
            border-radius: 10px;
            margin-top: 20%;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            transition: background-color 0.5s ease;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .message {
            text-align: center;
            color: #ff6666;
            font-size: 18px;
            margin-bottom: 20px;
        }

        form {
            margin-top: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-size: 16px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #ff6666;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #ff3333;
        }


        @media (max-width: 900px) {
            .container {
                margin: 0 20px 40px 20px;
                padding: 20px;
                margin-top: 30%;
                padding: 40px;
                transition: background-color 0.5s ease;
            }
        }

        @media (max-width: 600px) {
            .container {
                margin: 0 20px 40px 20px;
                padding: 20px;
                margin-top: 35%;
                padding: 40px;
                transition: background-color 0.5s ease;
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
                <a href="../../index.php" target="">Home</a>
                <a href="<?php
                            // Start the session

                            // Check if user is logged in
                            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                                // If user is logged in, display My Account link
                                echo '../send.php';
                            } else {
                                // If user is not logged in, display Login link
                                echo '../sendOld.php';
                            }
                            ?>" target="">Send</a>
                <a href="<?php
                            // Start the session

                            // Check if user is logged in
                            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                                // If user is logged in, display My Account link
                                echo '../receive.php';
                            } else {
                                // If user is not logged in, display Login link
                                echo '../receiveOld.php';
                            }
                            ?>" target="">Receive</a>
                <?php
                // Start the session

                // Check if user is logged in
                if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                    // If user is logged in, display My Account link
                    echo '<a href="./account.php">My Account</a>';
                } else {
                    // If user is not logged in, display Login link
                    echo '<a href="./html/login.php">Login</a>';
                }
                ?>
            </div>


        </div>


    </div>
    <br><br><br><br><br>


    <div class="s-layout">
        <!-- Sidebar -->
        <div class="s-layout__sidebar">
            <a class="s-sidebar__trigger" href="#0">
                <i class="fa fa-bars"></i>
            </a>

            <nav class="s-sidebar__nav">
                <ul>
                    <li>
                        <a class="s-sidebar__nav-link" href="./account.php">
                            <i class="fa fa-user"></i><em>Profile Settings</em>
                        </a>
                    </li>
                    <li>
                        <a class="s-sidebar__nav-link" href="./transaction-history.php">
                            <i class="fa fa-history"></i><em>Transaction History</em>
                        </a>
                    </li>
                    <li>
                        <a class="s-sidebar__nav-link" href="./transaction_settings.php">
                            <i class="fa fa-cogs"></i><em>Transaction Settings</em>
                        </a>
                    </li>
                    <li>
                        <a class="s-sidebar__nav-link" href="">
                            <i class="fa fa-lock"></i><em>Security</em>
                        </a>
                    </li>
                    <li>
                        <form method="POST">
                            <button type="submit" name="logout" class="logout-button">
                                <i class="fa fa-sign-out"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>


        <main class="s-layout__content">
            <div class="container">
                <h1>Delete Account</h1>
                <p class="message">Are you sure you want to delete your account? This action cannot be undone.</p>

                <form action="./deleteAccount.php" method="post">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="Enter Email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" placeholder="Enter Password">
                    </div>
                    <button type="submit">Delete Account</button>
                </form>

            </div>
        </main>
    </div>

</body>

</html>