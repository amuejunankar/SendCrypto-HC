<?php

session_start();
require_once('../../html/TCPDF-main/tcpdf.php');
include '../../database/connection.php';
$conn = connect();

// Retrieve email from the session
$email = $_SESSION['email'];

// Prepare the SQL query using a prepared statement
$sql = "SELECT from_address, to_address, amountRupee, amount, tx_hash FROM transactions WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Create a new PDF instance with landscape orientation
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set the document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Transaction Details');
$pdf->SetSubject('Transaction Details');
$pdf->SetKeywords('Transaction, Details, PDF');

// Add a new page
$pdf->AddPage();

// Set the font and font size
$pdf->SetFont('helvetica', '', 8);

// Define column widths and heights
$columnWidths = array(70, 70, 15, 20, 110);
$rowHeight = 10;

// Add headers
$pdf->Cell($columnWidths[0], $rowHeight, 'From Address', 1);
$pdf->Cell($columnWidths[1], $rowHeight, 'To Address', 1);
$pdf->Cell($columnWidths[2], $rowHeight, 'Amt INR', 1);
$pdf->Cell($columnWidths[3], $rowHeight, 'Amt ETH', 1);
$pdf->Cell($columnWidths[4], $rowHeight, 'Transaction Hash', 1);
$pdf->Ln();

// Add transaction details
while ($row_data = $result->fetch_assoc()) {
  // Calculate the height needed for the current row based on the content
  $contentHeight = max(
    $pdf->getStringHeight($columnWidths[0], $row_data['from_address']),
    $pdf->getStringHeight($columnWidths[1], $row_data['to_address']),
    $pdf->getStringHeight($columnWidths[2], $row_data['amountRupee']),
    $pdf->getStringHeight($columnWidths[3], $row_data['amount']),
    $pdf->getStringHeight($columnWidths[4], $row_data['tx_hash'])
  );

  $pdf->Cell($columnWidths[0], $contentHeight, $row_data['from_address'], 1);
  $pdf->Cell($columnWidths[1], $contentHeight, $row_data['to_address'], 1);
  $pdf->Cell($columnWidths[2], $contentHeight, $row_data['amountRupee'], 1);
  $pdf->Cell($columnWidths[3], $contentHeight, $row_data['amount'], 1);
  $pdf->Cell($columnWidths[4], $contentHeight, $row_data['tx_hash'], 1);
  $pdf->Ln();
}

// Output the PDF as a download
$pdf->Output('transaction_details.pdf', 'D');
exit;

?>
