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

// T O   D O

// Import Connection Files

include '../../database/connection.php';
$conn = connect();

// Retrieve profile picture from database and output as HTML
$email = 'junankgg@gmail.com';
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

// Upload Image File

// Update Form

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

    <div class="profile-info" style="margin-left: 42%;
                                    margin-top: 1%;">
        <!DOCTYPE html>
        <html>

        <head>
            <title>Profile Form</title>
        </head>

        <body>
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
        </body>

        </html>



</body>

</html>