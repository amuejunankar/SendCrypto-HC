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

echo '<script>';
echo 'console.log("to_address: ' . $to_address . '");';
echo 'console.log("amount: ' . $amount . '");';
echo 'console.log("tx_hash: ' . $tx_hash . '");';
echo 'console.log("mobile_number: ' . $mobile_number . '");';
echo 'console.log("operator: ' . $operator . '");';
echo 'console.log("state: ' . $state . '");';
echo '</script>';


// Calculate the plan price based on the selected plan in the HTML form
$plan_price = '399';

$from_address = $mobile_number . ' ' . $operator . ' ' . $plan_price;



// Get user's email from session and sanitize it
$email = mysqli_real_escape_string($conn, $_SESSION["email"]);

// Prepare SQL statement and handle any errors
$stmt = $conn->prepare("INSERT INTO transactions (from_address, to_address, amount, tx_hash, email) VALUES (?, ?, ?, ?, ?)");

if (!$stmt) {
    die("Error preparing statement: " . mysqli_error($conn));
}

$stmt->bind_param("sssss", $from_address, $to_address, $amount, $tx_hash, $email);

// Execute the SQL statement and handle any errors
if ($stmt->execute()) {
    echo "Transaction data inserted successfully!";
} else {
    echo "Error inserting transaction data: " . $stmt->error;
}

echo "Data received successfully!";


// Close the prepared statement and database connection
$stmt->close();
mysqli_close($conn);
?>