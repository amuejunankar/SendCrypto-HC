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


?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recharge Prepaid</title>
    <link rel="stylesheet" href="../../styles/navbar.css">


    <style>
        .body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        form {
            width: 500px;
            margin: 0 auto;
        }

        input,
        select {
            width: 200px;
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #000;
            color: #fff;
            border: 1px solid #fff;
            padding: 10px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #fff;
            color: #000;
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
    <br></br><br></br>





    <!-- HTML code -->


    <form id="recharge-form" action="/recharge" method="post">
        <h1>Prepaid Recharge Plans</h1>
        <input type="number" class="toAddressInput" name="mobile_number" id="mobile-number" placeholder="Enter your mobile number" required>
        <select name="operator" id="operator" required>
            <option value="">Select operator</option>
            <option value="Airtel">Airtel</option>
            <option value="Vodafone">Vodafone</option>
            <option value="Idea">Idea</option>
            <option value="Jio">Jio</option>
        </select>
        <select name="state" id="state" required>
            <option value="">Select state</option>
            <option value="Maharashtra">Maharashtra</option>
            <option value="Karnataka">Karnataka</option>
            <option value="Tamil Nadu">Tamil Nadu</option>
            <option value="Delhi">Delhi</option>
        </select>
        <div id="plans"></div>
        <button type="submit">Get Plans</button>

    </form>
    <button class="sendEthButton btn">Recharge</button>




    <script>
        // Wait for the document to load before attaching event listeners
        document.addEventListener('DOMContentLoaded', function() {

            // Get references to the form and its elements
            var form = document.querySelector('form');
            var mobileNumberInput = form.querySelector('input[name="mobile_number"]');
            var operatorSelect = form.querySelector('select[name="operator"]');
            var stateSelect = form.querySelector('select[name="state"]');
            var plansContainer = document.querySelector('#plans');

            // Initialize amountToSendInput to an initial value
            var amountToSendInput = '';

            // Attach a submit event listener to the form
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                // Get the values of the form elements
                var mobileNumber = mobileNumberInput.value;
                var operator = operatorSelect.value;
                var state = stateSelect.value;

                // Display a loading message while the plans are being fetched
                plansContainer.innerHTML = 'Loading plans...';

                // Fetch the recharge plans for the selected operator
                fetch('./plans.json')
                    .then(response => response.json())
                    .then(plans => {
                        // Clear the existing plan options
                        plansContainer.innerHTML = '';

                        // for (var i = 0; i < plans[operator].length; i++) {
                        //     var plan = plans[operator][i];
                        //     var radioButton = document.createElement('input');
                        //     radioButton.type = 'radio';
                        //     radioButton.name = 'plan';
                        //     radioButton.value = plan.id;

                        //     var label = document.createElement('label');
                        //     label.textContent = `${plan.name} - ${plan.price}`;

                        //     // Add an event listener to each radio button to update the amount to send
                        //     radioButton.addEventListener('change', function() {
                        //         amountToSendInput = plan.price;
                        //     });

                        //     plansContainer.appendChild(radioButton);
                        //     plansContainer.appendChild(label);
                        // }

                        for (var i = 0; i < plans[operator].length; i++) {
                            var plan = plans[operator][i];
                            var radioButton = document.createElement('input');
                            radioButton.type = 'radio';
                            radioButton.name = 'plan';
                            radioButton.value = plan.price;

                            var label = document.createElement('label');
                            label.textContent = `${plan.name} - ${plan.price}`;

                            // Add an event listener to each radio button to update the amount to send
                            radioButton.addEventListener('change', function(event) {
                                amountToSendInput = parseFloat(event.target.value);
                            });

                            plansContainer.appendChild(radioButton);
                            plansContainer.appendChild(label);
                        }


                    })
                    .catch(error => {
                        // Display an error message if there was a problem fetching the plans
                        plansContainer.innerHTML = 'Error fetching plans. Please try again later.';
                    });
            });

            // JavaScript code
            const sendEthButton = document.querySelector('.sendEthButton');

            // Send Ethereum to an address
            sendEthButton.addEventListener('click', async () => {
                const toAddress = '0x16530059aB82b5e1D2b1719d571fB5d77431468d'; // Get the recipient address from the input field
                const amountToSendWei = amountToSendInput * 1e18; // Convert ether to wei

                // Enable Ethereum if not enabled
                if (typeof ethereum !== 'undefined') {
                    await ethereum.enable();
                }

                // Send transaction
                ethereum
                    .request({
                        method: 'eth_sendTransaction',
                        params: [{
                            from: ethereum.selectedAddress, // The user's active address.
                            to: toAddress, // Set the recipient address to the user-entered value.
                            value: '0x' + amountToSendWei.toString(16), // Set the amount to send in wei as a hexadecimal string.
                        }],
                    })
                    .then((txHash) => {
                        console.log(txHash); // https://sepolia.etherscan.io/tx/0xcf....42

                        // Add confirmation message
                        const confirmationMsg = document.createElement('p');
                        confirmationMsg.textContent = `Transaction sent.`;
                        sendEthButton.parentElement.appendChild(confirmationMsg);

                        // Add button to view transaction on a block explorer
                        const viewTxButton = document.createElement('button');
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
                                body: `from_address=${ethereum.selectedAddress}&to_address=${toAddress}&amount=${amountToSend}&tx_hash=${txHash}`
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
                                const errorMsg = document.createElement('p');
                                errorMsg.textContent = 'Transaction data could not be inserted into the database.';
                                sendEthButton.parentElement.appendChild(errorMsg);
                            });
                    })
                    .catch((error) => console.error(error));

            });



        });
    </script>





</body>

</html>