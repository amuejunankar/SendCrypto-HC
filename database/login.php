<?php

include './connection.php';
$conn = connect();

// Retrieve form data
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Check if email and password match in database
$query = "SELECT * FROM accounttable WHERE email = '$email' AND password = '$password'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // Email and password match, proceed to dashboard
    session_start();
    $_SESSION['logged_in'] = true;
    $_SESSION['email'] = $email;
    header("Location: ../html/account/account.php");
} else {
    // Email and password do not match, show error message
    echo "Account not found";
}



// Close connection
mysqli_close($conn);

?>