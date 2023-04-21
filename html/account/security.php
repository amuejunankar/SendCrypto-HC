<?php



include '../../database/connection.php';
$conn = connect();

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Check if email and password match in database
$query = "SELECT * FROM accounttable WHERE email = '$email' AND password = '$password'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // Email and password match, proceed to dashboard

    // Delete account from database
    $sql = "DELETE FROM accounttable WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Account deleted successfully.";
        session_unset();
        session_destroy();
        $_SESSION['logged_in'] = false;
        header("Location: ../login.html");
    } else {
        echo "Failed to delete account. Please check your email and password.";
    }

} else {
    // Email and password do not match, show error message
    echo "Invalid Email or Password";
}



// Close connection
mysqli_close($conn);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Delete Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/navbar.css">
    <link rel="stylesheet" href="./styles/sidebar.css">
    <link rel="stylesheet" href="./styles/profile.css">

    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 40px auto;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .message {
            text-align: center;
            color: #ff6666;
            font-size: 18px;
            margin-bottom: 20px;
        }

        form {
            margin-top: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-size: 16px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #ff6666;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #ff3333;
        }

        @media (max-width: 600px) {
            .container {
                margin: 40px auto;
                padding: 20px;
            }
        }
    </style>

</head>


<body class="body">

    <div class="header">
        <div class="navbar">
            <div class="logo">
                <a href="../../index.html">Send Crypto</a>
            </div>
            <ul class="navLinks">
                <li>
                    <a href="../../index.html">Home</a>
                </li>
                <li>
                    <a href="../send.html">Send</a>
                </li>
                <li>
                    <a href="">Receive</a>
                </li>
                <li>
                    <a href="">My Account</a>
                </li>
            </ul>
        </div>
    </div>
    <br><br><br><br><br>
    <div class="sidebar">
        <ul>
            <li><a href="./account.php">Profile Settings</a></li>
            <li><a href="./transaction-history.php">Transaction History</a></li>
            <li><a href="">Transaction Settings</a></li>
            <li><a href="./security.php?">Security</a></li>

            <li>
                <form method="POST"><button type="submit" name="logout">Logout</button></form>
            </li>
        </ul>
    </div>

    <div class="container">
        <h1>Delete Account</h1>
        <p class="message">Are you sure you want to delete your account? This action cannot be undone.</p>
        <form action="" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter Email">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter Password">
            </div>
            <button type="submit">Delete Account</button>
        </form>
    </div>
</body>

</html>