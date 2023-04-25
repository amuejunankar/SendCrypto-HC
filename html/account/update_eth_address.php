<?php

// Import Connection Files
include '../../database/connection.php';
$conn = connect();

// Start session
session_start();

// Get the eth_address from the request
$eth_address = $_POST['eth_address'];

// Get the email from session
$email = $_SESSION['email'];

// Prepare the SQL update statement
$stmt = $conn->prepare('UPDATE accounttable SET eth_address = ? WHERE email = ?');
$stmt->bind_param('ss', $eth_address, $email); // Use 'ss' for two string parameters
$result = $stmt->execute();

if ($result) {
  echo 'eth_address updated successfully!';
} else {
  echo 'Failed to update eth_address: ' . $stmt->error;
}

$stmt->close();
$conn->close();


?>