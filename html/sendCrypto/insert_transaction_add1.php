<?php
// Start the session
session_start();

// Import Connection Files
include '../../database/connection.php';
include '../../database/sendMail.php';
$conn = connect();

// Get transaction data from POST request and sanitize it
// Get the data sent from JavaScript

$from_address = $_POST['from_address'];
$to_address = $_POST['to_address'];
$amount = $_POST['amount'];
$tx_hash = $_POST['tx_hash'];
$amountRupee = $_POST['plan_value'];
$mobileNumber = $_POST['mobile_number'];
$operator = $_POST['operator'];
$state = $_POST['state'];



// $from_address = "ABCC";
// $to_address = "Me5646846864";
// $amount = "0.0123";
// $tx_hash = "0xedea";
// $mobileNumber = "646464";
// $operator = "JIO";
// $state = "USA";


// Calculate the plan price based on the selected plan in the HTML form
$from_address = 'Prepaid Recharge ';
$to_address = $mobileNumber . ' > ' . $operator;

// Get user's email from session and sanitize it
$email = mysqli_real_escape_string($conn, $_SESSION["email"]);
echo $email;

$transaction_type = "recharge";

// Prepare SQL statement and handle any errors
$stmt = $conn->prepare("INSERT INTO transactions (from_address, to_address, amount, tx_hash, amountRupee  , email, transaction_type) VALUES (?, ?, ?, ?, ?, ?,?)");
if (!$stmt) {
    die("Error preparing statement: " . mysqli_error($conn));
}

// Bind parameters to statement and handle any errors
$stmt->bind_param("sssssss", $from_address, $to_address, $amount, $tx_hash, $amountRupee, $email, $transaction_type);
if (!$stmt) {
    die("Error binding parameters: " . mysqli_error($conn));
}

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

// Send email after recharge
$msg = "Your recharge of Rs. $amountRupee to $mobileNumber is successful. Transaction date: $date.";
sendMailRecharge($email, $msg);


// Close the prepared statement and database connection
$stmt->close();
mysqli_close($conn);
