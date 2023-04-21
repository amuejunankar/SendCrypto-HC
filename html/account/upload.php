<?php
include '../../database/connection.php';
$conn = connect();

session_start();
$email = $_SESSION['email'];

// Check if file was uploaded
if (isset($_FILES["imageFile"]) && $_FILES["imageFile"]["error"] == 0) {
    $image = $_FILES["imageFile"]["tmp_name"];
    $image_data = file_get_contents($image);

    $email = $_SESSION['email']; // Get the email value from your form or another source
    $sql = "UPDATE accounttable SET profile_picture = ? WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $image_data, $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

$email = $_SESSION['email']; // Get the email value from your form or another source

$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);

$sql2 = "UPDATE accounttable SET fname = ?, lname = ? WHERE email = ?";
$stmt2 = mysqli_prepare($conn, $sql2);
mysqli_stmt_bind_param($stmt2, "sss", $fname, $lname, $email); // Bind parameters
mysqli_stmt_execute($stmt2);
mysqli_stmt_close($stmt2);


// Redirect back to account page
header("Location: account.php?email=$email");
exit();
?>
