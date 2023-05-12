<?php
// Start the session
session_start();

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

// Get transaction data from POST request and sanitize it
$from_address = mysqli_real_escape_string($conn, $_POST["from_address"]);
$to_address = mysqli_real_escape_string($conn, $_POST["to_address"]);
$amount = mysqli_real_escape_string($conn, $_POST["amount"]);
$tx_hash = mysqli_real_escape_string($conn, $_POST["tx_hash"]);

// Get user's email from session and sanitize it
$email = mysqli_real_escape_string($conn, $_SESSION["email"]);

// Prepare SQL statement and handle any errors
$stmt = $conn->prepare("INSERT INTO transactions (from_address, to_address, amount, tx_hash, email) VALUES (?, ?, ?, ?, ?)");

if (!$stmt) {
  die("Error preparing statement: " . mysqli_error($conn));
}

$stmt->bind_param("ssdss", $from_address, $to_address, $amount, $tx_hash, $email);

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
