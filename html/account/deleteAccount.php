<?php
session_start();

include '../../database/connection.php';
$conn = connect();

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Check if email and password match in database
$query = "SELECT * FROM accounttable WHERE email = '$email' AND password = '$password'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // Email and password match, proceed to dashboard

    // Check if email matches the email in the session
    if ($_SESSION['email'] == $email) {
        // Delete account from database
        $sql = "DELETE FROM accounttable WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Account deleted successfully.";
            session_unset();
            session_destroy();
            $_SESSION['logged_in'] = false;
            header("Location: ../login.html");
        } else {
            echo "Failed to delete account. Please check your email and password.";
        }
    } else {
        echo "Invalid Email or Password";
    }
} else {
    // Email and password do not match, show error message
    echo "Invalid Email or Password";
}

// Close connection
mysqli_close($conn);
