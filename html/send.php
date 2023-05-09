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

<body class="body">

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
          <a href="">Send</a>
        </li>
        <li>
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
            echo '<a href="../html/login.html">Login</a>';
          }
          ?>
        </li>

      </ul>


    </div>
  </div>
  <br></br><br></br>



  <div class="card-container">
    <a href="./qrcode.php" class="card">
      <img src="./account/src/image4.png" alt="Image 1">
      <div class="overlay">
        <h1>Scan QR Code</h1>
        <br><br><br><br><br>
        <p>Scanning and paying by direct transactions to the user.</p>
      </div>
    </a>

    <div class="card-container">
      <a href="./sendCrypto/sendNumber.php" class="card">
        <img src="./account/src/image1.jpg" alt="Image 1">
        <div class="overlay">
          <h1>Send To Number</h1>
          <br><br><br><br><br>
          <p>Send Crypto money via mobile money transfer service</p>
        </div>
      </a>
      <a href="./sendCrypto/sendAddress.php" class="card">
        <img src="./account/src/image3.webp" alt="Image 2">
        <div class="overlay">
          <h1>Send To Address</h1>
          <br><br><br><br><br>
          <p>Securely send money to recipients anywhere anytime</p>
        </div>
      </a>
      <a href="recharge-prepaid.html" class="card">
        <img src="./account/src/image2.jpg" alt="Image 2">
        <div class="overlay">
          <h1>Progress / Working</h1>
          <br><br><br><br>
          <p>Recharge Your Prepaid Number with our best professional solutions</p>
        </div>
      </a>
      <!-- Add more cards as needed -->
    </div>





</body>

</html>