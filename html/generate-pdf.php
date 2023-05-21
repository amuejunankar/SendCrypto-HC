<?php
session_start();
require_once('./TCPDF-main/tcpdf.php');
require_once('./phpqrcode-master/qrlib.php');
include '../database/connection.php';
$conn = connect();

// $email = $_SESSION['email'];
$email = 'junankgg@gmail.com';
// Prepare and execute the SQL query to fetch the data from the accounttable
$query = "SELECT fname, lname, mobilenumber FROM accounttable WHERE email = '$email'";
$result = $conn->query($query);

// Check if the query was successful
if ($result) {
    // Fetch the row containing the data
    $row = $result->fetch_assoc();

    // Store the data in separate variables
    $firstName = $row['fname'];
    $lastName = $row['lname'];
    $mobileNumber = $row['mobilenumber'];
    // Concatenate first name and last name to get the full name
    $fullName = $firstName . ' ' . $lastName;
   
} else {
    // Handle query error
    echo "Query failed: " . $conn->error;
}

// Close the database conn
$conn->close();


function generatePDF($name, $phoneNumber) {
    ob_clean(); // Clear any output buffer

    // Create a TCPDF instance
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('QR Code Stand PDF');
    $pdf->SetSubject('QR Code Stand');

    // Add a page
    $pdf->AddPage();

    // Set the QR code stand layout
    $pdf->Image('./logo.png', 75, 10, 60, 0, 'PNG');
    $pdf->SetFont('helvetica', 'B', 24);
    $pdf->Cell(0, 95, $name, 0, 0.5, 'C');

    // Generate the QR code image and add it to the PDF
    $qrCodeFile = tempnam(sys_get_temp_dir(), 'qr_code');
    QRcode::png($phoneNumber, $qrCodeFile, QR_ECLEVEL_H);
    
    $pdf->Image($qrCodeFile, 75, 80, 60, 60, 'PNG');
    unlink($qrCodeFile);

    // Add scan instructions
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 110, 'Scan QR code using the SendCrypto'."\n".'Web App for Crypto Payment.', 0, 1, 'C');

    // Output the PDF for download
    $pdf->Output($name . '_qr_code_stand.pdf', 'D');
}


// Call the generatePDF function with the desired name and phone number
generatePDF($fullName, $mobileNumber);
?>
