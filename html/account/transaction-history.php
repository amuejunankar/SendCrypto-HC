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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-xxx" crossorigin="anonymous" />


</head>


<body class="body">

    <div class="header">

        <div class="nav">
            <input type="checkbox" id="nav-check">
            <div class="nav-header">
                <div class="nav-title">
                    SendCrypto
                </div>
            </div>
            <div class="nav-btn">
                <label for="nav-check">
                    <span></span>
                    <span></span>
                    <span></span>
                </label>
            </div>

            <div class="nav-links">
                <a href="../../index.php" target="">Home</a>
                <a href="<?php
                            // Start the session

                            // Check if user is logged in
                            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                                // If user is logged in, display My Account link
                                echo '../send.php';
                            } else {
                                // If user is not logged in, display Login link
                                echo '../sendOld.php';
                            }
                            ?>" target="">Send</a>
                <a href="<?php
                            // Start the session

                            // Check if user is logged in
                            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                                // If user is logged in, display My Account link
                                echo '../receive.php';
                            } else {
                                // If user is not logged in, display Login link
                                echo '../receiveOld.php';
                            }
                            ?>" target="">Receive</a>
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
            </div>


        </div>





    </div>
    <br><br><br><br><br>




    <div class="s-layout">
        <!-- Sidebar -->
        <div class="s-layout__sidebar">
            <a class="s-sidebar__trigger" href="#0">
                <i class="fa fa-bars"></i>
            </a>

            <nav class="s-sidebar__nav">
                <ul>
                    <li>
                        <a class="s-sidebar__nav-link" href="./account.php">
                            <i class="fa fa-user"></i><em>Profile Settings</em>
                        </a>
                    </li>
                    <li>
                        <a class="s-sidebar__nav-link" href="">
                            <i class="fa fa-history"></i><em>Transaction History</em>
                        </a>
                    </li>
                    <li>
                        <a class="s-sidebar__nav-link" href="./transaction_settings.php">
                            <i class="fa fa-cogs"></i><em>Transaction Settings</em>
                        </a>
                    </li>
                    <li>
                        <a class="s-sidebar__nav-link" href="./security.php">
                            <i class="fa fa-lock"></i><em>Security</em>
                        </a>
                    </li>
                    <li>
                        <form method="POST">
                            <button type="submit" name="logout" class="logout-button">
                                <i class="fa fa-sign-out"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>




        <!-- Content -->


        <main class="s-layout__content">
            



            <div class="table-container">
                <table>
                    <tr>
                        <th>From Address</th>
                        <th>To Address</th>
                        <th>Amount</th>
                        <th>Amount ETH</th>
                        <th>Transaction Hash</th>
                    </tr>

                    <?php
                    // Retrieve email from session
                    $email = $_SESSION["email"];

                    // Import Connection Files
                    include '../../database/connection.php';
                    $conn = connect();

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
                            echo "<td>" . $row["amountRupee"] . " INR" . "</td>";
                            echo "<td>" . $row["amount"] . " ETH" . "</td>";
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

        </main>

    </div>









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



</body>

</html>