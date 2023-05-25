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
    // Your code to transfer the ETH to $toAddress
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

        * {
            box-sizing: border-box;
        }

        .body {
            background-color: #f2f5f8;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            margin-bottom: 20px;
        }

        h1 {
            color: #4f6bff;
            font-size: 30px;
            margin: 0;
        }

        .form-group {
            margin-bottom: 30px;
        }

        .input-group {
            position: relative;
        }

        .toAddressInput {
            font-size: 17px;
            /* Set the desired font size for the first input */
        }

        #inr_amount {
            font-size: 24px;
            /* Set the desired font size for the second input */
        }

        .input-group input {
            padding: 12px;
            border-radius: 14px;
            border: none;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding-left: 35px;
        }

        .input-group1 input {
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
            border: none;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding-left: 35px;
        }

        .input-group input {
            width: 100%;
        }

        .input-group1 input {
            width: 80%;
        }

        .input-group::before {
            content: "\20B9";
            position: absolute;
            left: 10px;
            top: 79%;

            transform: translateY(-50%);
            font-size: 18px;
            color: #6c757d;
            background-color: honeydew;
        }

        .input-group1::before {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: #6c757d;
            \background-color: honeydew;
        }

        .input-group-addon {
            padding: 12px;
            font-size: 18px;
            border-radius: 8px 0 0 8px;
            border: none;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            color: #6c757d;
            background-color: honeydew;
            border-radius: 10px;
        }

        .eth-rate {
            font-size: 14px;
            color: #6c757d;
            text-align: center;
            margin-top: 20px;
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            gap: 10px;
            /* Adjust the value according to your desired gap size */

        }

        .btn-group .btn {
            flex-grow: 1;
            padding: 12px;
            color: #fff;
            background-color: #a6bdc1;

            border: none;
            border-radius: 8px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn-group .btn:hover {
            background-color: #4058c7;
        }

        .eth-rate {
            font-size: 14px;
            color: #6c757d;
            text-align: center;
            margin-top: 20px;
        }

        .sendEthButton {
            display: block;
            width: 100%;
            padding: 12px;
            color: #fff;
            background-color: #4f6bff;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .sendEthButton:hover {
            background-color: #4058c7;
        }
    </style>
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
                            // Check if user is logged in
                            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                                // If user is logged in, set the appropriate URL
                                echo '../send.php';
                            } else {
                                // If user is not logged in, set the appropriate URL
                                echo '../sendOld.php';
                            }
                            ?>" target="">Send</a>
                <a href="<?php
                            // Check if user is logged in
                            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                                // If user is logged in, set the appropriate URL
                                echo '../receive.php';
                            } else {
                                // If user is not logged in, set the appropriate URL
                                echo '../receiveOld.php';
                            }
                            ?>" target="">Receive</a>
                <a href="<?php
                            // Check if user is logged in
                            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                                // If user is logged in, set the appropriate URL
                                echo '../account/account.php';
                            } else {
                                // If user is not logged in, set the appropriate URL
                                echo './html/login.php';
                            }
                            ?>" target="">My Account</a>
            </div>
        </div>

    </div>
    <br></br><br></br>

    <!-- HTML code -->
    <div class="container">
        <div class="header">
            <h1>Pay to Contacts</h1>
        </div>
        <div class="form-group">
            <div class="input-group">
                <input type="text" class="toAddressInput" placeholder="Enter Mobile Number" value="<?php echo isset($toAddress) ? htmlspecialchars($toAddress) : ''; ?>">
                <p id="error-message" style="display: none; color: red;">Please enter a 10-digit mobile number.</p>

                <br>
                <input type="number" id="inr_amount" class="form-control" placeholder="Enter amount in INR" min="0" step="1" required>
            </div>
            <div class="btn-group">
                <button type="button" class="btn" data-amount="50">+50</button>
                <button type="button" class="btn" data-amount="100">+100</button>
                <button type="button" class="btn" data-amount="200">+200</button>
            </div>
        </div>

        <div class="form-group">
            <div class="input-group1">
                <span class="input-group-addon">ETH</span>
                <input type="text" id="eth_amount" class="form-control" placeholder="ETH calculated here" disabled>
            </div>
            <div class="eth-rate">1 ETH = ? INR</div>
        </div>
        <button class="sendEthButton">Pay Now</button>
    </div>


    <script>
        function validateMobileNumber(input) {
            var mobileNumber = input.value;

            if (mobileNumber.length !== 10) {
                // Show error message
                document.getElementById('error-message').style.display = 'block';
            } else {
                // Hide error message
                document.getElementById('error-message').style.display = 'none';
            }
        }
    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        let ethAmountglobal = '';

        $(document).ready(function() {
            // Get the current ETH to INR exchange rate from the CoinGecko API
            $.get('https://api.coingecko.com/api/v3/simple/price?ids=ethereum&vs_currencies=inr', function(data) {
                let ethRate = data.ethereum.inr;
                $('.eth-rate').text(`1 ETH = ${ethRate} INR`);

                // Update the ETH amount whenever the INR amount is changed
                $('#inr_amount').on('input', function() {
                    let inrAmount = $(this).val();
                    let ethAmount = inrAmount / ethRate;
                    ethAmountglobal = ethAmount;
                    $('#eth_amount').val(ethAmount.toFixed(6));
                });

                // Add the selected amount to the INR amount when the button is clicked
                $('.btn-group .btn').on('click', function() {
                    let amount = parseInt($(this).data('amount'));
                    let inrAmount = parseInt($('#inr_amount').val());
                    let newInrAmount = inrAmount ? inrAmount + amount : amount;
                    $('#inr_amount').val(newInrAmount).trigger('input');
                });

                // JavaScript code for sending ETH
                function sendEth() {
                    let sendEthButton = document.querySelector('.sendEthButton');
                    let toAddressInput = document.querySelector('.toAddressInput');

                    sendEthButton.addEventListener('click', async () => {
                        let mobileNumber = toAddressInput.value;
                        let amountToSend = ethAmountglobal;
                        let amountToSendWei = Math.floor(amountToSend * 1e18);

                        let amountToSendInr = 0;

                        // Get the ETH/INR exchange rate
                        await fetch('https://api.coingecko.com/api/v3/simple/price?ids=ethereum&vs_currencies=inr')
                            .then(response => response.json())
                            .then(data => {
                                let ethInrRate = data.ethereum.inr;
                                amountToSendInr = amountToSend * ethInrRate;
                            })
                            .catch(error => console.error(error));

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

                                    ethereum
                                        .request({
                                            method: 'eth_sendTransaction',
                                            params: [{
                                                from: ethereum.selectedAddress, // The user's active address.
                                                to: data.eth_address, // Set the recipient address to the retrieved eth_address.
                                                value: '0x' + amountToSendWei.toString(16), // Set the amount to send in wei as a hexadecimal string.
                                            }],
                                        })

                                        .then((txHash) => {
                                            console.log(txHash);
                                            console.log(`inside ethreum INR: ${amountToSendInr}`);

                                            // Add confirmation message
                                            let confirmationMsg = document.createElement('p');
                                            confirmationMsg.textContent = 'Transaction sent.';
                                            sendEthButton.parentElement.appendChild(confirmationMsg);

                                            // Add button to view transaction on a block explorer
                                            let viewTxButton = document.createElement('button');
                                            viewTxButton.textContent = 'View Transaction on Etherscan';
                                            viewTxButton.classList.add('viewTxButton', 'btn');
                                            viewTxButton.addEventListener('click', () => {
                                                window.open(`https://sepolia.etherscan.io/tx/${txHash}`, '_blank');
                                            });
                                            sendEthButton.parentElement.appendChild(viewTxButton);

                                            // Insert transaction data into database
                                            fetch('./insert_transaction_add.php', {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-type': 'application/x-www-form-urlencoded'
                                                    },
                                                    body: `from_address=${ethereum.selectedAddress}&to_address=${data.eth_address}&amount=${amountToSend}&amountRupee=${amountToSendInr}&tx_hash=${txHash}`
                                                })
                                                .then(response => {
                                                    if (response.ok) {
                                                        console.log('Transaction data inserted successfully!');
                                                    } else {
                                                        throw new Error('Error inserting transaction data');
                                                    }
                                                })
                                                .catch(error => {
                                                    console.error(error);
                                                    // Display error message to user
                                                    let errorMsg = document.createElement('p');
                                                    errorMsg.textContent = 'Transaction data could not be inserted into the database.';
                                                    sendEthButton.parentElement.appendChild(errorMsg);
                                                });
                                        })
                                        .catch(error => console.error(error));
                                } else {
                                    alert("Either the account doesn't exist or the recipient's Mobile Transaction is disabled. Please enable the wallet in the transaction settings.");
                                }
                            })
                            .catch(error => console.error(error));
                    });
                }

                // Call the sendEth function to initiate the sending process
                sendEth();
            });
        });
    </script>



</body>

</html>