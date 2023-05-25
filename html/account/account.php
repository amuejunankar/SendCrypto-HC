<?php
session_start();

// Check if user is not logged in, then redirect to login page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login.php");
    exit;
}

// logout script
if (isset($_POST['logout'])) {
    // unset all session variables
    session_unset();
    // destroy the session
    session_destroy();
    // redirect to the login page
    header('Location: ../login.php');
    exit;
}

// Add Session FIles
$email = $_SESSION['email'];

// Import Connection Files
include '../../database/connection.php';
$conn = connect();

// Retrieve profile picture from database and output as HTML
$email = $_SESSION['email'];
$sql = "SELECT profile_picture FROM accounttable WHERE email = ?"; // Replace with your appropriate query
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $profile_picture = $row["profile_picture"];
    // encode the image data as base64 for use in the data URI
    $base64_image = base64_encode($profile_picture);
    $image_src = 'data:image/png;base64,' . $base64_image; // replace "png" with the appropriate image format
    // output the HTML code with the profile picture
} else {
    echo "0 results";
}

// Query to fetch email and mobile number for a specific email address
// Check if email is set in the URL
$email = ''; // Initialize email variable
$fname = ''; // Initialize first name variable
$lname = ''; // Initialize last name variable
$mobileNumber = ''; // Initialize mobile number variable

if ($email = $_SESSION['email']) {

    // Query to fetch email, first name, last name, and mobile number for a specific email address
    $sql = "SELECT email, fname, lname, mobilenumber FROM accounttable WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {

        // Loop through the query result and fetch email, first name, last name, and mobile number
        while ($row = mysqli_fetch_assoc($result)) {
            $email = $row["email"];
            $fname = $row["fname"];
            $lname = $row["lname"];
            $mobileNumber = $row["mobilenumber"];
        }
    } else {
        // Display nothing if no rows are returned
        // Alternatively, you can show an error message or redirect to another page
    }
}

// Free the query result
mysqli_free_result($result);

// Close the database connection
mysqli_close($conn);

?>


<!DOCTYPE html>
<html>

<head>
    <title>My Account</title>
    <link rel="stylesheet" href="../../styles/navbar.css">
    <link rel="stylesheet" href="./styles/sidebar.css">
    <link rel="stylesheet" href="./styles/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-xxx" crossorigin="anonymous" />


</head>


<body class="body">
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
                <a href="" target="">Home</a>
                <a href="<?php

                            // Check if user is logged in
                            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                                // If user is logged in, display My Account link
                                echo '../send.php';
                            } else {
                                // If user is not logged in, display Login link
                                echo '../sendOld.php';
                            }
                            ?>" target="">Send</a>
                <a href="<?php

                            // Check if user is logged in
                            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                                // If user is logged in, display My Account link
                                echo '../receive.php';
                            } else {
                                // If user is not logged in, display Login link
                                echo '../receiveOld.php';
                            }
                            ?>" target="">Receive</a>
                <?php
                // Check if user is logged in
                if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                    // If user is logged in, display My Account link
                    echo '<a href="">My Account</a>';
                } else {
                    // If user is not logged in, display Login link
                    echo '<a href="./html/login.php">Login</a>';
                }
                ?>
            </div>

        </div>


    </div>
    <br><br><br><br><br>




    <div class="s-layout">
        <!-- Sidebar -->
        <div class="s-layout__sidebar">
            <a class="s-sidebar__trigger" href="#0">
                <i class="fa fa-bars"></i>
            </a>

            <nav class="s-sidebar__nav">
                <ul>
                    <li>
                        <a class="s-sidebar__nav-link" href="">
                            <i class="fa fa-user"></i><em>Profile Settings</em>
                        </a>
                    </li>
                    <li>
                        <a class="s-sidebar__nav-link" href="./transaction-history.php">
                            <i class="fa fa-history"></i><em>Transaction History</em>
                        </a>
                    </li>
                    <li>
                        <a class="s-sidebar__nav-link" href="./transaction_settings.php">
                            <i class="fa fa-cogs"></i><em>Transaction Settings</em>
                        </a>
                    </li>
                    <li>
                        <a class="s-sidebar__nav-link" href="./security.php">
                            <i class="fa fa-lock"></i><em>Security</em>
                        </a>
                    </li>
                    <li>
                        <form method="POST">
                            <button type="submit" name="logout" class="logout-button">
                                <i class="fa fa-sign-out"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>



        <main class="s-layout__content">


            <div class="profile-info" style="margin-left: auto;
                                    margin-top: 30px;">

                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <div class="profile-header">
                        <h1>Profile</h1>
                    </div>
                    <div class="profile-container">
                        <div class="profile-picture-container form-group">
                            <img src="<?= $image_src ?>" alt="Profile Picture" id="profile-picture">
                            <input type="file" id="profile-picture-input" accept="image/*" name="imageFile">
                        </div>
                        <div class="form-group">
                            <label for="first-name">First Name:</label>
                            <input value="<?= $fname ?>" type="text" id="fname" name="fname" required>
                        </div>

                        <div class="form-group">
                            <label for="last-name">Last Name:</label>
                            <input value="<?= $lname ?>" type="text" id="lname" name="lname" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input value="<?= $email ?>" type="email" id="email" name="email" required disabled>
                        </div>

                        <div class="form-group">
                            <label for="mobile-number">Mobile Number:</label>
                            <input value="<?= $mobileNumber ?>" type="tel" id="mobile-number" name="mobile-number" required disabled>
                        </div>

                    </div>
                    <button class="save-btn" type="submit">Save Changes</button>
                </form>

                <script>
                    const profilePicture = document.getElementById('profile-picture');
                    const profilePictureInput = document.getElementById('profile-picture-input');

                    profilePicture.addEventListener('click', () => {
                        profilePictureInput.click();
                    });

                    profilePictureInput.addEventListener('change', (event) => {
                        const file = event.target.files[0];
                        const reader = new FileReader();
                        reader.readAsDataURL(file);
                        reader.onload = () => {
                            profilePicture.src = reader.result;
                        };
                    });
                </script>




        </main>
    </div>

</body>

</html>