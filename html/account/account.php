<?php
session_start();

// Check if user is not logged in, then redirect to login page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login.html");
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
    <title>My Account</title>
    <link rel="stylesheet" href="../../styles/navbar.css">
    <link rel="stylesheet" href="./styles/sidebar.css">
    <link rel="stylesheet" href="./styles/profile.css">

</head>


<body class="body">

    <div class="header">
        <div class="navbar">
            <div class="logo">
                <a href="../../index.html">Send Crypto</a>
            </div>
            <ul class="navLinks">
                <li>
                    <a href="../../index.html">Home</a>
                </li>
                <li>
                    <a href="../send.html">Send</a>
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
    <br><br><br><br><br>
    <div class="sidebar">
        <ul>
            <li><a href="">Profile Settings</a></li>
            <li><a href="./transaction-history.php">Transaction History</a></li>
            <li><a href="">Transaction Settings</a></li>
            <li><a href="">Security</a></li>
            
            <li>
                <form method="POST"><button type="submit" name="logout">Logout</button></form>
            </li>
        </ul>
    </div>


    <!-- Add your HTML content here -->

    <div class="profile-header">
        <h1>Profile Settings</h1>
    </div>

    <div class="profile-container">
        <div class="profile-picture-container">
            <img src="../../src/default-profile-picture.png" alt="Profile Picture">
        </div>

        <div class="profile-info">
            <form>
                <div class="form-group">
                    <label for="first-name">First Name:</label>
                    <input value="First demo" type="text" id="first-name" name="first-name" required>
                </div>

                <div class="form-group">
                    <label for="last-name">Last Name:</label>
                    <input value="Last demo" type="text" id="last-name" name="last-name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input value="demo@gmail.com" type="email" id="email" name="email" required disabled>
                </div>

                <div class="form-group">
                    <label for="mobile-number">Mobile Number:</label>
                    <input value="12345678" type="tel" id="mobile-number" name="mobile-number" required disabled>
                </div>


                <button class="save-btn" type="submit">Save Changes</button>
            </form>
        </div>
    </div>




</body>

</html>