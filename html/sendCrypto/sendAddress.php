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
  <title>Send ETH via MetaMask</title>
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
      width: 75%;
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
    <h1>Send To Address</h1>
    <input type="text" class="toAddressInput" placeholder="Enter recipient address">
    <input type="text" class="amountToSendInput" placeholder="Enter amount (in Ether)">
    <br>
    <button class="sendEthButton btn">Send ETH</button>
  </div>

  <script>
    // JavaScript code
    const sendEthButton = document.querySelector('.sendEthButton');
    const toAddressInput = document.querySelector('.toAddressInput');
    const amountToSendInput = document.querySelector('.amountToSendInput');

    // Send Ethereum to an address
    sendEthButton.addEventListener('click', async () => {
      const toAddress = toAddressInput.value; // Get the recipient address from the input field
      const amountToSend = amountToSendInput.value; // Get the amount to send from the input field
      const amountToSendWei = amountToSend * 1e18; // Convert ether to wei

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
        .then((txHash) => console.log(txHash)) // https://sepolia.etherscan.io/tx/0xcf....42
        .catch((error) => console.error(error));
    });
  </script>


</body>

</html>