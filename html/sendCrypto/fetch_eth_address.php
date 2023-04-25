<?php

// Import Connection Files
include '../../database/connection.php';
$conn = connect();

// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get the mobile number from the POST request
$requestPayload = file_get_contents('php://input');
$data = json_decode($requestPayload, true);
$mobileNumber = $data['mobileNumber'];

// Prepare and execute SQL query to fetch eth_address based on mobile number
$stmt = $conn->prepare("SELECT eth_address FROM accounttable WHERE mobilenumber = ?");
$stmt->bind_param("s", $mobileNumber);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $ethAddress = $row['eth_address'];

    // Return eth_address as JSON response
    echo json_encode(array("eth_address" => $ethAddress));
} else {
    // Return error message if eth_address not found
    echo json_encode(array("error" => "Eth address not found for the provided mobile number"));
}

// Close database connection
$stmt->close();
$conn->close();

?>