<?php
// Start the session
session_start();

// Import Connection Files
include '../../database/connection.php';
$conn = connect();

// Get transaction data from POST request and sanitize it
$from_address = mysqli_real_escape_string($conn, $_POST["from_address"]);
$to_address = mysqli_real_escape_string($conn, $_POST["to_address"]);
$amount = mysqli_real_escape_string($conn, $_POST["amount"]);
$tx_hash = mysqli_real_escape_string($conn, $_POST["tx_hash"]);
$amountRupee = mysqli_real_escape_string($conn,$_POST['amountRupee']);

// Get user's email from session and sanitize it
$email = mysqli_real_escape_string($conn, $_SESSION["email"]);

// Prepare SQL statement and handle any errors
$stmt = $conn->prepare("INSERT INTO transactions (from_address, to_address, amountRupee, amount, tx_hash, email) VALUES (?, ?, ?, ?, ?, ?)");

if (!$stmt) {
  die("Error preparing statement: " . mysqli_error($conn));
}

$stmt->bind_param("ssddss", $from_address, $to_address, $amountRupee, $amount, $tx_hash, $email);

// Execute the SQL statement and handle any errors
if ($stmt->execute()) {
  echo "Transaction data inserted successfully!";
} else {
  echo "Error inserting transaction data: " . $stmt->error;
}

// Close the prepared statement and database connection
$stmt->close();
mysqli_close($conn);
?>
