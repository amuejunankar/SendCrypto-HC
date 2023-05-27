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
$amountRupee = mysqli_real_escape_string($conn, $_POST['amountRupee']);

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


// to add data  in receiver side --------------------------------------------

// Check if to_address is a mobile number
if (preg_match('/^\d{10}$/', $to_address)) {
  // It's a mobile number
  // Retrieve email from the database using the mobile number
  $query2 = "SELECT email FROM accounttable WHERE mobilenumber = '$to_address'";
  $result2 = $conn->query($query2);

  if ($result2->num_rows > 0) {
    // Mobile number found in the database
    $row2 = $result2->fetch_assoc();
    $emailR = $row2['email'];

    // Switch from_address and to_address
    $temp_address = $from_address;
    $from_address = $to_address;
    $to_address = $temp_address;

    // Prepare and execute the INSERT statement
    $stmt2 = $conn->prepare("INSERT INTO transactions (from_address, to_address, amountRupee, amount, tx_hash, email, transaction_type) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt2->bind_param("ssddsss", $from_address, $to_address, $amountRupee, $amount, $tx_hash, $emailR, $transaction_type);
    $stmt2->execute();

    sleep(10);
    // Send Mail To User About Transaction
    sendMailTransactionR($emailR, $from_address, $to_address, $amount, $tx_hash, $amountRupee);


    echo "Transaction data inserted successfully!";
  } else {
    // Mobile number not found in the database
    echo "No email associated with the provided mobile number.";
  }
} else {
  // It's an address

  // Check if to_address exists in the database and retrieve associated email
  $query3 = "SELECT email FROM accounttable WHERE eth_address = '$to_address'";
  $result3 = $conn->query($query3);

  if ($result3->num_rows > 0) {
    $row3 = $result3->fetch_assoc();
    $emailRAddr = $row3['email'];

    // Switch from_address and to_address
    $temp_address = $from_address;
    $from_address = $to_address;
    $to_address = $temp_address;

    // Prepare and execute the INSERT statement
    $stmt3 = $conn->prepare("INSERT INTO transactions (from_address, to_address, amountRupee, amount, tx_hash, email, transaction_type) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt3->bind_param("ssddsss", $from_address, $to_address, $amountRupee, $amount, $tx_hash, $emailRAddr, $transaction_type);
    $stmt3->execute();

    // Send Mail To User About Transaction
    sendMailTransactionR($emailRAddr, $from_address, $to_address, $amount, $tx_hash, $amountRupee);


    echo "Transaction data inserted successfully!";
  } else {
    echo "No email associated with the provided to_address.";
    // means send email to sender.
    sendMailTransaction($email, $from_address, $to_address, $amount, $tx_hash, $amountRupee);

  }
}

//END of receiver side --------------------------------------------


// Close the prepared statement and database connection
$stmt->close();
mysqli_close($conn);
