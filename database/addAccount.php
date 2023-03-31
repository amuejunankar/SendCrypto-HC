<?php
// Replace database credentials with your own
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "account";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve form data
$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$mobileNumber = mysqli_real_escape_string($conn, $_POST['mobileNumber']);
$mobileCode = mysqli_real_escape_string($conn, $_POST['mobileCode']); // Retrieve mobile code

// Check if email already exists in database
$email_query = "SELECT * FROM accounttable WHERE email = '$email'";
$email_result = mysqli_query($conn, $email_query);

if(mysqli_num_rows($email_result) > 0) {
    // Email already exists in database, show error message
    echo "Email already exists";
} else {
    // Prepare SQL query
    $sql = "INSERT INTO accounttable (name, email, password, mobileNumber, mobileCode) VALUES ('$name', '$email', '$password', '$mobileNumber', '$mobileCode')";

    // Execute query
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "error";
    }
}


// Close connection
mysqli_close($conn);
