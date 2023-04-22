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
  <title>Send</title>
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
          <a href="">Receive</a>
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
  <div class="dashboard-card">
    <div class="dashboard-left">
      <div class="card-section recent-activity">
        <h2>Recent Activity</h2>
        <p>
          <strong>03/28/2023:</strong> Purchased groceries for $100<br />
          <strong>03/25/2023:</strong> Paid rent for $1500
        </p>
      </div>
      <div class="card-section month-spending">
        <h2>Recharge Prepaid</h2>
        <p>Jio And Airtel</p>
      </div>
      <div class="card-section payment-settings">
        <h2>Payment Settings</h2>
        <p>Credit card ending in **** **** **** 1234</p>
      </div>
    </div>
    <div class="dashboard-right your-transactions">
      <div class="large-card">
        <h2>Your Transactions</h2>
        <p>2 transactions totaling $250</p>
      </div>
    </div>
  </div>
</body>

</html>