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
        .card {
            width: 500px;
            margin: 0 auto;
            padding: 20px;
            display: block;
            border-radius: 10px;
            margin-top: 6.5%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;

        }

        .card h1 {
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .card input[type="number"],
        .card select {
            display: block;
            width: 90%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .card input[type="radio"] {
            display: block;
            margin: 10px 0;
        }

        

        .card button[type="submit"],
        .card .sendEthButton.btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            font-size: 16px;
            border: none;
            border-radius: 10px;
            margin-top: 10px;
            cursor: pointer;
        }

        .card button[type="submit"]:hover,
        .card .sendEthButton.btn:hover {
            background-color: #3e8e41;
        }

        .card #plans {
            margin-top: 20px;
        }
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

    <div class="card">
        <form id="recharge-form" action="recharge.php" method="post">
            <h1>Prepaid Recharge Plans</h1>
            <input type="number" value="888635805" class="to_addressInput" name="mobile_number" id="mobile-number" placeholder="Enter your mobile number" required>
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
            <button class="sendEthButton btn">Recharge</button>
        </form>
    </div>

    <script>
        let mobileNumber = null;
        let operator = null;
        let state = null;
        let amountToSendInput = null;
        let selectedPlanValue = null;

        // Wait for the document to load before attaching event listeners
        document.addEventListener('DOMContentLoaded', function() {

            // Get references to the form and its elements
            var form = document.querySelector('form');
            var mobileNumberInput = form.querySelector('input[name="mobile_number"]');
            var operatorSelect = form.querySelector('select[name="operator"]');
            var stateSelect = form.querySelector('select[name="state"]');
            var plansContainer = document.querySelector('#plans');


            // Attach a submit event listener to the form
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                // Get the values of the form elements
                mobileNumber = mobileNumberInput.value;
                operator = operatorSelect.value;
                state = stateSelect.value;

                // Display a loading message while the plans are being fetched
                plansContainer.innerHTML = 'Loading plans...';

                // Fetch the recharge plans for the selected operator
                fetch('./plans.json')
                    .then(response => response.json())
                    .then(plans => {
                        // Clear the existing plan options
                        plansContainer.innerHTML = '';

                        for (var i = 0; i < plans[operator].length; i++) {
                            var plan = plans[operator][i];
                            var radioButton = document.createElement('input');
                            radioButton.type = 'radio';
                            radioButton.name = 'plan';
                            radioButton.value = plan.price;

                            var label = document.createElement('label');
                            label.textContent = `${plan.name} - ${plan.price}`;

                            plansContainer.appendChild(radioButton);
                            plansContainer.appendChild(label);

                            // Add an event listener to each radio button to update the amount to send
                            radioButton.addEventListener('change', function(plan) {
                                return function(event) {
                                    var inrAmount = parseFloat(event.target.value);
                                    var apiUrl = 'https://api.coingecko.com/api/v3/simple/price?ids=ethereum&vs_currencies=inr';

                                    // Update global variables with current values
                                    mobileNumber = mobileNumberInput.value;
                                    operator = operatorSelect.value;
                                    state = stateSelect.value;
                                    selectedPlanValue = plan.price;

                                    // Fetch the current ETH/INR exchange rate from the API
                                    fetch(apiUrl)
                                        .then(response => response.json())
                                        .then(data => {
                                            var ethToInr = data.ethereum.inr;
                                            var ethAmount = inrAmount / ethToInr;
                                            amountToSendInput = ethAmount;
                                            console.log(`Amount in ETH: ${amountToSendInput}`);

                                            // console.log("Inside " + mobileNumber);
                                            // console.log(operator);
                                            // console.log(state);
                                            // console.log(selectedPlanValue);


                                        })
                                        .catch(error => console.error(error));
                                };
                            }(plan));
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
                const to_address = '0x16530059aB82b5e1D2b1719d571fB5d77431468d'; // Get the recipient address from the input field
                const amount = (amountToSendInput * 1e18); // Convert ether to wei

                // console.log("OUT " + mobileNumber);
                // console.log(operator);
                // console.log(state);
                // console.log(selectedPlanValue);
                // console.log("Send "+ amountToSendInput);

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
                            to: to_address, // Set the recipient address to the user-entered value.
                            value: '0x' + amount.toString(16), // Set the amount to send in wei as a hexadecimal string.
                        }],
                    })
                    .then((tx_hash) => {
                        console.log(tx_hash); // https://sepolia.etherscan.io/tx/0xcf....42

                        // Add confirmation message
                        const confirmationMsg = document.createElement('p');
                        confirmationMsg.textContent = `Recharge is being processed.`;
                        sendEthButton.parentElement.appendChild(confirmationMsg);

                        // Add button to view transaction on a block explorer
                        const viewTxButton = document.createElement('button');
                        viewTxButton.textContent = 'View Transaction on Etherscan';
                        viewTxButton.classList.add('viewTxButton', 'btn');
                        viewTxButton.addEventListener('click', () => {
                            window.open(`https://sepolia.etherscan.io/tx/${tx_hash}`, '_blank');
                        });
                        sendEthButton.parentElement.appendChild(viewTxButton);

                        fetch('./insert_transaction_add1.php', {
                                method: 'POST',
                                headers: {
                                    'Content-type': 'application/x-www-form-urlencoded'
                                },
                                body: `from_address=${ethereum.selectedAddress}
                                &to_address=${to_address}
                                &amount=${amountToSendInput}
                                &tx_hash=${tx_hash}
                                &plan_value=${selectedPlanValue}
                                &mobile_number=${mobileNumber}
                                &operator=${operator}
                                &state=${state}`
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