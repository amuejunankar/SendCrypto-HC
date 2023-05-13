<?php
// Start the session
session_start();

// Import Connection Files
include '../../database/connection.php';
include '../../database/sendMail.php';
$conn = connect();

// Get transaction data from POST request and sanitize it
$from_address = mysqli_real_escape_string($conn, $_POST["from_address"]);
$to_address = mysqli_real_escape_string($conn, $_POST["to_address"]);
$amount = mysqli_real_escape_string($conn, $_POST["amount"]);
$tx_hash = mysqli_real_escape_string($conn, $_POST["tx_hash"]);
$amountRupee = mysqli_real_escape_string($conn,$_POST['amountRupee']);

$amountRupee = number_format(floatval($amountRupee), 2);


// Get user's email from session and sanitize it
$email = mysqli_real_escape_string($conn, $_SESSION["email"]);

$transaction_type = "transaction";

// Prepare SQL statement and handle any errors
$stmt = $conn->prepare("INSERT INTO transactions (from_address, to_address, amountRupee, amount, tx_hash, email, transaction_type) VALUES (?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) {
  die("Error preparing statement: " . mysqli_error($conn));
}

$stmt->bind_param("ssddsss", $from_address, $to_address, $amountRupee, $amount, $tx_hash, $email, $transaction_type);

// Execute the SQL statement and handle any errors
if ($stmt->execute()) {
  echo "Transaction data inserted successfully!";
} else {
  echo "Error inserting transaction data: " . $stmt->error;
}

// GRAB DATE from DB
// Prepare SQL query
$sql = "SELECT created_at FROM transactions
        WHERE email = '$email' AND transaction_type = '$transactionType'
        ORDER BY created_at DESC LIMIT 1";

// Execute query
$result = $conn->query($sql);

// Fetch result as associative array
$row = $result->fetch_assoc();

// Get value of "created_at" column from result
$date = $row['created_at'];


// Send Mail To User About Transaction
sendMailTransaction($email, $from_address, $to_address, $amount, $tx_hash, $amountRupee);

// Close the prepared statement and database connection
$stmt->close();
mysqli_close($conn);
?>
