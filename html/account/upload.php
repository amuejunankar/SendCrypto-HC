<?php
include '../../database/connection.php';
$conn = connect();

// Check if file was uploaded
if (isset($_FILES["imageFile"]) && $_FILES["imageFile"]["error"] == 0) {
    $image = $_FILES["imageFile"]["tmp_name"];
    $image_data = file_get_contents($image);

    $email = 'junankgg@gmail.com'; // Get the email value from your form or another source
    $sql = "UPDATE accounttable SET profile_picture = ? WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $image_data, $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Redirect back to account page
header("Location: account.php");
exit();
?>
