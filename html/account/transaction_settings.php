<?php
session_start();

// Check if user is not logged in, then redirect to login page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login.php");
    exit;
}

// logout script
if (isset($_POST['logout'])) {
    // unset all session variables
    session_unset();
    // destroy the session
    session_destroy();
    // redirect to the login page
    header('Location: ../login.php');
    exit;
}

// Add Session FIles
$email = $_SESSION['email'];

// Import Connection Files
include '../../database/connection.php';
$conn = connect();

// Close the database connection
mysqli_close($conn);

?>






<!DOCTYPE html>
<html>

<head>
    <title>Transaction Settings</title>
    <link rel="stylesheet" href="../../styles/navbar.css">
    <link rel="stylesheet" href="./styles/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-xxx" crossorigin="anonymous" />


    <style>
        .card {
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px 20px;
            text-align: center;
            margin-top: 5%;
            margin-left: 5%;
            margin-right: 5%;
            font-family: 'Arial', sans-serif;
            height: 200px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            color: #666;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }


        @media screen and (max-width: 672px) {
            .card {
                padding: 20px;
                margin-top: 20%;
                font-family: 'Arial', sans-serif;
            }

            h1 {
                font-size: 20px;
                margin-bottom: 8px;
            }

            p {
                font-size: 14px;
            }

            button {
                padding: 8px 16px;
                font-size: 16px;
            }
        }



        @media screen and (max-width: 450px) {
            .card {
                padding: 10px;
                margin-top: 20%;
                font-family: 'Arial', sans-serif;
            }

            h1 {
                font-size: 20px;
                margin-bottom: 8px;
            }

            p {
                font-size: 14px;
            }

            button {
                padding: 8px 16px;
                font-size: 16px;
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
                        <a class="s-sidebar__nav-link" href="./security.php">
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



            <!-- ---------------------MAIN THINGS----------------------- -->
            <div class="card">
                <h1>Transaction Settings</h1>
                <p id="address">Your MetaMask address will be displayed here.</p>
                <button id="enableBtn">Enable Mobile Number Transaction</button>
            </div>
            <script>
                // Declare global variable to store user's Ethereum address
                var eth_address = '';

                document.getElementById('enableBtn').addEventListener('click', function() {
                    // Check if MetaMask is installed
                    if (typeof window.ethereum === 'undefined') {
                        alert('Please install MetaMask to enable mobile number transaction.');
                        return;
                    }

                    // Request MetaMask to connect
                    ethereum.request({
                            method: 'eth_requestAccounts'
                        })
                        .then(accounts => {
                            // Store user's address in a variable
                            eth_address = accounts[0];
                            // Update the paragraph with the user's address
                            document.getElementById('address').textContent = 'Your MetaMask address: ' + eth_address;

                            // Send an AJAX request to update_eth_address.php to update the eth_address in the database
                            var xhr = new XMLHttpRequest();
                            xhr.open('POST', 'update_eth_address.php', true);
                            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;charset=UTF-8');
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === XMLHttpRequest.DONE) {
                                    if (xhr.status === 200) {
                                        console.log('eth_address updated successfully!');
                                    } else {
                                        console.error('Failed to update eth_address: ' + xhr.statusText);
                                    }
                                }
                            };
                            xhr.send('eth_address=' + eth_address);
                        })
                        .catch(error => {
                            console.error('Failed to connect to MetaMask:', error);
                        });
                });
            </script>


        </main>
    </div>













</body>

</html>