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
$conn->close();
?>

<br><br><br><br><br><br><br>


<!-- Generate and show QR code of user. get value from Database -->

<div id="container">
  <div id="left-div">

    <h1>QR Code</h1>
    <div id="qrcode"></div>
    <label id="phone-label" for="phone">Your mobile number:</label>
    <div type="tel" id="phone" name="phone"><?php echo $mobileNumber; ?></div>
  </div>

  <div id="right-div">
    <h1>Right Div</h1>
    <p>This is the right div.</p>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode-generator/1.4.4/qrcode.min.js"></script>
<script>
  function generateQRCode() {
    const phoneNumber = document.getElementById("phone").textContent;
    const qrCodeDiv = document.getElementById("qrcode");
    qrCodeDiv.innerHTML = "";

    const qrCode = new QRCode(qrCodeDiv, {
      text: phoneNumber,
      width: 256,
      height: 256,
      colorDark: "#000000",
      colorLight: "#ffffff",
      correctLevel: QRCode.CorrectLevel.H
    });
  }

  // Call the generateQRCode() function after the page is fully loaded
  window.addEventListener('load', generateQRCode);
</script>












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
          <a href="./send.php">Send</a>
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


</body>

</html>