<?php
// Start the session
session_start();

// Import Connection Files
include '../../../database/connection.php';
$conn = connect();

// Get transaction data from POST request and sanitize it
// Get the data sent from JavaScript
$fromAddress = $_POST['from_address'];
$toAddress = $_POST['to_address'];
$amount = $_POST['amount'];
$txHash = $_POST['tx_hash'];
$mobileNumber = $_POST['mobile_number'];
$operator = $_POST['operator'];
$state = $_POST['state'];


// Calculate the plan price based on the selected plan in the HTML form
$plan_price = '399';

$from_address = $mobileNumber . ' ' . $operator . ' ' . $plan_price;

// Get user's email from session and sanitize it
$email = mysqli_real_escape_string($conn, $_SESSION["email"]);

// Prepare SQL statement and handle any errors
$stmt = $conn->prepare("INSERT INTO transactions (from_address, to_address, amount, tx_hash, email) VALUES (?, ?, ?, ?, ?) WHERE email = ?");
if (!$stmt) {
    die("Error preparing statement: " . mysqli_error($conn));
}

// Bind parameters to statement and handle any errors
$stmt->bind_param("ssssss", $from_address, $to_address, $amount, $tx_hash, $email, $email);
if (!$stmt) {
    die("Error binding parameters: " . mysqli_error($conn));
}

// Execute the SQL statement and handle any errors
if ($stmt->execute()) {
    echo "Transaction data inserted successfully!";
} else {
    echo "Error inserting transaction data: " . $stmt->error;
}

// Close the prepared statement and database connection
$stmt->close();
mysqli_close($conn);
