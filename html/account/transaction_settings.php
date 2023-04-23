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
    <style>
        /* styles.css */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        p {
            text-align: center;
        }

        button {
            display: block;
            margin: 0 auto;
            margin-top: 20px;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        #address {
            margin-top: 20px;
            font-size: 14px;
            color: #333;
        }
    </style>
</head>

<body>


    <div class="header">
        <div class="navbar">
            <div class="logo">
                <a href="../../index.php">Send Crypto</a>
            </div>
            <ul class="navLinks">
                <li>
                    <a href="../../index.php">Home</a>
                </li>
                <li>
                    <?php
                    // Start the session


                    // Check if user is logged in
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                        // If user is logged in, display My Account link
                        echo '<a href="../send.php">Send</a>';
                    } else {
                        // If user is not logged in, display Login link
                        echo '<a href="../sendOld.php">Send</a>';
                    }
                    ?>
                </li>
                <li>
                    <a href="">Receive</a>
                </li>
                <li>
                    <a href="./account.php">My Account</a>
                </li>
            </ul>
        </div>
    </div>
    <br><br><br><br><br>
    <div class="sidebar">
        <ul>
            <li><a href="./account.php">Profile Settings</a></li>
            <li><a href="./transaction-history.php">Transaction History</a></li>
            <li><a href="./transaction_settings.php">Transaction Settings</a></li>
            <li><a href="./security.php">Security</a></li>

            <li>
                <form method="POST"><button type="submit" name="logout">Logout</button></form>
            </li>
        </ul>
    </div>

    <!-- ---------------------MAIN THINGS----------------------- -->
    
    <h1>Transaction Settings</h1>
    <p id="address">Your MetaMask address will be displayed here.</p>
    <button id="enableBtn">Enable Mobile Number Transaction</button>





    <script>
        
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
                    var user_addr = accounts[0];
                    // Update the paragraph with the user's address
                    document.getElementById('address').textContent = 'Your MetaMask address: ' + user_addr;
                })
                .catch(error => {
                    console.error('Failed to connect to MetaMask:', error);
                });
        });
    </script>

</body>

</html>