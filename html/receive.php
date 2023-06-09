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


// Retrieve the email address from the session
$email = $_SESSION['email'];

// Import Connection Files
include '../database/connection.php';
$conn = connect();

// Get mobile number from database
$email = $_SESSION['email'];
$sql = "SELECT mobilenumber FROM accounttable WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Output data of each row
  while ($row = $result->fetch_assoc()) {
    $mobileNumber = $row["mobilenumber"];
  }
} else {
  echo "No results found";
}



// Get eth_address from database
$email = $_SESSION['email'];
$sql = "SELECT eth_address FROM accounttable WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Output data of each row
  while ($row = $result->fetch_assoc()) {
    $eth_address = $row["eth_address"];
  }
} else {
  echo "No results found";
}





$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Receive Crypto</title>
  <link rel="stylesheet" href="../styles/navbar.css">
  <link rel="stylesheet" href="../styles/receive.css">
  <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode-generator/1.4.4/qrcode.min.js"></script>

</head>

<body class="body">


  <div class="blur-image">
    <img src="../src/blur2.jpg" style="width:1200px;height:400px">
  </div>



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

        <?php
        // Start the session

        // Check if user is logged in
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
          // If user is logged in, display My Account link
          echo '<a href="./send.php">Send</a>';
        } else {
          // If user is not logged in, display Login link
          echo '<a href="./sendOld.php">Send</a>';
        }
        ?>

        <a href="" target="">Receive</a>

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
      </div>

    </div>




  </div>
  <br></br><br><br>


  <!-- Generate and show QR code of user. get value from Database -->
  <div class="container">
    <div class="card-wrapper">
      <div class="card" id="left-div">

        <div class="h1">
          <h2>Scan QR Code</h2>
        </div>
        <div id="qrcode"></div>
        <label id="phone-label" for="phone">Your mobile number:</label>
        <div id="phone" type="tel" id="phone" name="phone"><?php echo $mobileNumber; ?></div>
      </div>
    </div>

    <div class="card-wrapper">
      <div class="card" id="right-div">

        <h2>Scan QR Code</h2>
        <div id="qrcode2"></div>
        <label id="eth-label" for="eth">Your ETH Address:</label>
        <div id="eth" type="tel" id="eth" name="eth"><?php echo $eth_address; ?></div>
      </div>
    </div>
  </div>

<br><br><br>
  <!-- button -->
  <div class="center">
    <form action="generate-pdf.php" method="post">
      <input type="submit" name="download" value="Download QR Card" class="btn">
    </form>
  </div>



  <script>
    function generateQRCode() {
      const phoneNumber = document.getElementById("phone").textContent;
      const qrCodeDiv = document.getElementById("qrcode");
      qrCodeDiv.innerHTML = "";

      const qrCode = new QRCode(qrCodeDiv, {
        text: phoneNumber,
        width: 170,
        height: 170,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
      });
    }

    function generateQRCode2() {
      const eth = document.getElementById("eth").textContent;
      const qrCodeDiv = document.getElementById("qrcode2");
      qrCodeDiv.innerHTML = "";

      const qrCode = new QRCode(qrCodeDiv, {
        text: eth,
        width: 170,
        height: 170,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
      });
    }

    // Call the generateQRCode() function after the page is fully loaded
    window.addEventListener('load', generateQRCode);
    window.addEventListener('load', generateQRCode2);
  </script>



</body>

</html>