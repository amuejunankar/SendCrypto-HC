<?php
require_once './PHPExcel-1.8/Classes/PHPExcel.php';

// Import Connection Files
include '../../database/connection.php';
$conn = connect();

// Create a new Excel workbook and worksheet
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$sheet = $objPHPExcel->getActiveSheet();


// Retrieve the email from the session or use a default value
$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'user@example.com';

// Fetch transaction details from MySQL
$sql = "SELECT * FROM transactions WHERE email = '$email'";
$result = $conn->query($sql);

// Set column headers
$sheet->setCellValue('A1', 'Transaction ID');
$sheet->setCellValue('B1', 'Amount');
$sheet->setCellValue('C1', 'Date');

// Populate transaction details in Excel
$row = 2;  // Start from the second row
while ($row_data = $result->fetch_assoc()) {
  $sheet->setCellValue('A' . $row, $row_data['transaction_id']);
  $sheet->setCellValue('B' . $row, $row_data['amount']);
  $sheet->setCellValue('C' . $row, $row_data['date']);
  $row++;
}

// Save the Excel file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('transaction_details.xlsx');

// Provide the file as a download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="transaction_details.xlsx"');
header('Content-Length: ' . filesize('transaction_details.xlsx'));
readfile('transaction_details.xlsx');

// Clean up - delete the temporary file
unlink('transaction_details.xlsx');







