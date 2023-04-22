<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="../styles/login.css">
  <link rel="stylesheet" href="../styles/navbar.css">
  <link rel="stylesheet" type="text/css" href="../styles/signup.css">

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
      </li>
        <li>
          <a href="">Receive</a>
        </li>
        <li>
          <a href="">My Account</a>
        </li>
      </ul>
    </div>
  </div>

  <div class="login-container">
    <div class="login-form">
      <h1>Login</h1>
      <form method="POST" action="../database/login.php" >
        <label for="email">Email:</label>
        <input placeholder="Enter your email" type="email" id="email" name="email" required />
        <label for="password">Password:</label>
        <input placeholder="Enter a Password" type="password" id="password" name="password" required />

        <button class="button" type="submit">Login</button>
        <a href="../html/forgetpassword.html">
          <p>Forgot Your Password?</p>
        </a>
        <hr>

        <p>Don't have an account? Sign up</p>
        <!-- Add a button to move to registration account -->
        <a href="signup.html">
          <button class="button" type="button">
            Sign up
          </button>
        </a>

      </form>
    </div>
  </div>


</body>

</html>