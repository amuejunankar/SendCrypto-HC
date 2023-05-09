<?php
session_start();

// Check if user is not logged in, then redirect to login page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login.php");
    exit;
}

// logout script
if (isset($_POST['logout'])) {
    // unset all session variables
    session_unset();
    // destroy the session
    session_destroy();
    // redirect to the login page
    header('Location: ../login.php');
    exit;
}

?>


<!DOCTYPE html>
<html>

<head>
    <title>Transaction History</title>
    <link rel="stylesheet" href="../../styles/navbar.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/transaction_history.css">
    

</head>


<body class="body">

    <div class="header">
        <div class="navbar">
            <div class="logo">
                <a href="../../index.php">Send Crypto</a>
            </div>
            <ul class="navLinks">
                <li>
                    <a href="../../index.php">Home</a>
                </li>
                <li>
                    <?php
                    // Start the session

                    // Check if user is logged in
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                        // If user is logged in, display My Account link
                        echo '<a href="../send.php">Send</a>';
                    } else {
                        // If user is not logged in, display Login link
                        echo '<a href="../sendOld.php">Send</a>';
                    }
                    ?>
                </li>
                <li>
                    <a href="">Receive</a>
                </li>
                <li>
                    <?php
                    // Start the session

                    // Check if user is logged in
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                        // If user is logged in, display My Account link
                        echo '<a href="./account.php">My Account</a>';
                    } else {
                        // If user is not logged in, display Login link
                        echo '<a href="./html/login.php">Login</a>';
                    }
                    ?>
                </li>
            </ul>
        </div>
    </div>
    <br><br><br><br><br>

    <div class="container">
        <div class="sidebar">
            <ul>
                <li><a href="./account.php">Profile Settings</a></li>
                <li><a href="">Transaction History</a></li>
                <li><a href="./transaction_settings.php">Transaction Settings</a></li>
                <li><a href="./security.php">Security</a></li>

                <li>
                    <form method="POST"><button type="submit" name="logout">Logout</button></form>
                </li>
            </ul>
        </div>



        <div class="table-container">
            <table>
                <tr>
                    <th>From Address</th>
                    <th>To Address</th>
                    <th>Amount</th>
                    <th>Transaction Hash</th>
                </tr>

                <?php
                // Retrieve email from session
                $email = $_SESSION["email"];

                // Connection Details
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "account";

                // Create connection
                $conn = mysqli_connect($servername, $username, $password, $dbname);

                // Check connection
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // Prepare SQL statement and handle any errors
                $stmt = $conn->prepare("SELECT * FROM transactions WHERE email = ?");
                $stmt->bind_param("s", $email);

                if (!$stmt) {
                    die("Error preparing statement: " . mysqli_error($conn));
                }

                // Execute the SQL statement and handle any errors
                if ($stmt->execute()) {
                    // Store the result set in memory
                    $result = $stmt->get_result();

                    // Display transactions in a table
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["from_address"] . "</td>";
                        echo "<td>" . $row["to_address"] . "</td>";
                        echo "<td>" . $row["amount"] . "</td>";
                        echo "<td><a href='https://sepolia.etherscan.io/tx/" . $row["tx_hash"] . "' target='_blank'>" . $row["tx_hash"] . "</a></td>";
                        echo "</tr>";
                    }

                    // Free the memory used by the result set
                    $result->free();
                } else {
                    echo "Error retrieving transaction data: " . $stmt->error;
                }


                // Close the prepared statement and database connection
                $stmt->close();
                mysqli_close($conn);
                ?>
            </table>
        </div>
    </div>


</body>

</html>