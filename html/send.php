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
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Send Crypto</title>
  <link rel="stylesheet" href="../styles/navbar.css">
  <link rel="stylesheet" href="../styles/send.css">

</head>

<style>
  .left-card-items {
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 24px;
    max-width: 400px;
    margin: 0 auto;
  }

  .left-card-items h1 {
    font-size: 24px;
    margin-bottom: 16px;
    color: #333333;
  }

  .left-card-items hr {
    border: none;
    border-top: 1px solid #dddddd;
    margin: 12px 0;
  }

  .left-card-items h2 {
    font-size: 20px;
    margin-bottom: 8px;
    color: #555555;
  }

  .left-card-items h2#balance {
    font-size: 28px;
    font-weight: bold;
    color: #007bff;
  }

  .left-card-items h2#balance-inr {
    font-size: 20px;
    font-weight: bold;
    color: #ff8800;
  }

 
</style>

<body class="body">
  <div class="main-container">

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
          <a href="../index.php" target="">Home</a>
          <a href="" target="">Send</a>
          <?php
          // Start the session
          // Check if user is logged in
          if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
            // If user is logged in, display My Account link
            echo '<a href="./receive.php">Receive</a>';
          } else {
            // If user is not logged in, display Login link
            echo '<a href="./receiveOld.php">Receive</a>';
          }
          ?>

          <?php
          // Check if user is logged in
          if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
            // If user is logged in, display My Account link
            echo '<a href="./account/account.php">My Account</a>';
          } else {
            // If user is not logged in, display Login link
            echo '<a href="../html/login.html">Login</a>';
          }
          ?>
        </div>
      </div>


    </div>
    <br></br><br></br>


    <div class="container">


      <!-- Leftt Cards -->
      <div class="card-left" style="background-color: lightblue;">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
        <script src="https://cdn.jsdelivr.net/npm/web3@1.5.3/dist/web3.min.js"></script>

        <div class="left-card-items">
          <h1>Crypto Transactions Made Effortless</h1>
          <p>Simplify your crypto transactions with our platform's capabilities. Scan QR codes for easy payments, effortlessly send crypto funds, and confidently transfer worldwide.</p>
        </div>
        <br>
        <div class="left-card-items">
          <h1>Balance</h1>
          <hr>
          <h2 id="balance"></h2>
          <h2 id="balance-inr"></h2>
        </div>



      </div>


      <!-- RIght CARDS -->
      <div class="card-right" style="background-color: lightgreen;">
        <div class="card-container">
          <a href="./qrcode.php" class="card">
            <img src="./account/src/image4.png" alt="Image 1">
            <div class="overlay">
              <h1>Scan QR Code</h1>
              <br><br><br>
              <p>Scanning and paying by direct transactions to the user.</p>
            </div>
          </a>

          <a href="./sendCrypto/sendNumber.php" class="card">
            <img src="./account/src/image1.jpg" alt="Image 1">
            <div class="overlay">
              <h1>Pay To Contacts</h1>
              <br><br><br>
              <p>Send Crypto money via mobile money transfer service</p>
            </div>
          </a>

          <a href="./sendCrypto/sendAddress.php" class="card">
            <img src="./account/src/image3.webp" alt="Image 2">
            <div class="overlay">
              <h1>Pay To Address</h1>
              <br><br><br>
              <p>Send money to recipients anywhere anytime</p>
            </div>
          </a>

          <a href="./sendCrypto/recharge.php" class="card">
            <img src="./account/src/image2.jpg" alt="Image 2">
            <div class="overlay">
              <h1>Prepaid Recharge</h1>
              <br><br>
              <p>Recharge Your Prepaid Number with our best professional solutions</p>
            </div>
          </a>
          <!-- Add more cards as needed -->

        </div>
      </div>



    </div>
  </div>



  <script>
    // Check if MetaMask is installed and enabled
    if (typeof window.ethereum !== 'undefined' && window.ethereum.isMetaMask) {
      // Request access to accounts
      window.ethereum.request({
          method: 'eth_requestAccounts'
        })
        .then(function(accounts) {
          // Get the selected account
          var address = accounts[0];

          // Create a Web3 instance using MetaMask provider
          var web3 = new Web3(window.ethereum);

          // Get the balance of the address
          web3.eth.getBalance(address, function(error, balance) {
            if (error) {
              console.error(error);
            } else {
              // Convert balance from Wei to Ether and round to 3 decimal places
              var balanceInEther = web3.utils.fromWei(balance, 'ether');
              balanceInEther = parseFloat(balanceInEther).toFixed(3);

              // Update the balance in ETH in the HTML
              document.getElementById('balance').textContent = balanceInEther + ' ETH';

              // Fetch the conversion rate from ETH to INR
              fetch('https://api.coingecko.com/api/v3/simple/price?ids=ethereum&vs_currencies=inr')
                .then(function(response) {
                  return response.json();
                })
                .then(function(data) {
                  // Calculate the balance in INR
                  var conversionRate = data.ethereum.inr;
                  var balanceInINR = (balanceInEther * conversionRate).toFixed(2);

                  // Update the balance in INR in the HTML
                  document.getElementById('balance-inr').textContent = balanceInINR + ' INR';
                })
                .catch(function(error) {
                  console.error(error);
                });
            }
          });
        })
        .catch(function(error) {
          console.error(error);
        });
    } else {
      console.error('MetaMask is not installed or enabled.');
    }
  </script>

</body>

</html>