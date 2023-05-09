<?php

session_start();

// Check if user is not logged in, then redirect to login page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../send.html");
    exit;
}

// logout script
if (isset($_POST['logout'])) {
    // unset all session variables
    session_unset();
    // destroy the session
    session_destroy();
    // redirect to the login page
    header('Location: ../login.html');
    exit;
}

// scanned Result code till toAddress

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    $toAddress = $_POST['toAddress'];
    $amount = $_POST['amount'];
    // Your code to transfer the ETH to $toAddress with $amount
} else {
    // Display form
    $toAddress = isset($_GET['toAddress']) ? $_GET['toAddress'] : '';
}



?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send ETH via Number</title>
    <link rel="stylesheet" href="../../styles/navbar.css">


    <style>
        .body {
            background-color: #4f6bff;
        }


        .card {
            max-width: 400px;
            margin: 200px auto;
            padding: 20px;
            background-color: #f8f8f8;
            border-radius: 5px;
            font-family: "Lato", sans-serif;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card h1 {
            text-align: center;
        }

        .enableEthereumButton,
        .sendEthButton {
            display: block;
            margin: 0 auto;
            margin-top: 10px;
            padding: 12px 24px;
            background-color: #007bff;
            /* Add background color */
            color: #fff;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 55%;
        }

        .enableEthereumButton:hover,
        .sendEthButton:hover {
            background-color: #0069d9;
        }

        .toAddressInput,
        .amountToSendInput {
            display: block;
            width: 55%;
            margin: 0 auto;
            margin-top: 10px;
            padding: 10px;
            /* Add padding */
            background-color: #f8f8f8;
            color: #333;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }


        .toAddressInput:focus,
        .amountToSendInput:focus {
            outline: none;
            border-color: #007bff;
        }

        .toAddressInput::-webkit-outer-spin-button,
        .toAddressInput::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .toAddressInput {
            -moz-appearance: textfield;
            appearance: textfield;
        }
    </style>
    </style>
</head>

<body class="body">

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
                    <a href="../send.php">Send</a>
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
                        echo '<a href=".././account/account.php">My Account</a>';
                    } else {
                        // If user is not logged in, display Login link
                        echo '<a href="../../html/login.html">Login</a>';
                    }
                    ?>
                </li>

            </ul>


        </div>
    </div>
    <br></br>




    <!-- HTML code -->
    <!-- HTML code -->
    <div class="card">
    <h1>Send To Number</h1>
    <form method="POST">
        <input type="number" class="toAddressInput" name="toAddress" placeholder="Enter recipient Mobile Number" value="<?php echo isset($toAddress) ? htmlspecialchars($toAddress) : ''; ?>">
        <input type="number" class="amountToSendInput" name="amount" placeholder="Enter amount (in Ether)" min="0.0001">
        <br>
        <button class="sendEthButton btn" type="submit">Send ETH</button>
    </form>
</div>

    <script>
        // JavaScript code
        const sendEthButton = document.querySelector('.sendEthButton');
        const toAddressInput = document.querySelector('.toAddressInput');
        const amountToSendInput = document.querySelector('.amountToSendInput');

        // Send Ethereum to an address
        sendEthButton.addEventListener('click', async () => {
            const mobileNumber = toAddressInput.value; // Get the recipient mobile number from the input field
            const amountToSend = amountToSendInput.value; // Get the amount to send from the input field
            const amountToSendWei = amountToSend * 1e18; // Convert ether to wei

            // Fetch eth_address from SQL database based on mobile number
            fetch('fetch_eth_address.php', {
                    method: 'POST',
                    body: JSON.stringify({
                        mobileNumber: mobileNumber
                    }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.eth_address) {
                        // Enable Ethereum if not enabled
                        if (typeof ethereum !== 'undefined') {
                            ethereum.enable();
                        }

                        // Send transaction
                        ethereum
                            .request({
                                method: 'eth_sendTransaction',
                                params: [{
                                    from: ethereum.selectedAddress, // The user's active address.
                                    to: data.eth_address, // Set the recipient address to the retrieved eth_address.
                                    value: '0x' + amountToSendWei.toString(16), // Set the amount to send in wei as a hexadecimal string.
                                }],
                            })
                            .then((txHash) => console.log(txHash)) // https://sepolia.etherscan.io/tx/0xcf....42
                            .catch((error) => console.error(error));
                    } else {
                        console.error('Failed to fetch eth_address for the provided mobile number');
                    }
                })
                .catch(error => console.error(error));
        });
    </script>



</body>

</html>