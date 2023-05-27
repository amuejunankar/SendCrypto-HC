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
    <link rel="stylesheet" href="./styles/sidebar.css">

</head>
<style>
    .download-button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        margin-left: 1%;
        border-radius: 10px;
        cursor: pointer;
        font-size: 16px;
        display: flex;
        align-items: center;
    }

    .download-button i {
        margin-right: 5px;
    }

    .download-button:hover {
        background-color: #45a049;
    }
</style>

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

                    // Define pagination variables
                    $resultsPerPage = 10;
                    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                    $startIndex = ($currentPage - 1) * $resultsPerPage;

                    // Prepare SQL statement and handle any errors
                    $stmt = $conn->prepare("SELECT * FROM transactions WHERE email = ? LIMIT ?, ?");
                    $stmt->bind_param("sii", $email, $startIndex, $resultsPerPage);

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

                    // Close the prepared statement
                    $stmt->close();

                    // Calculate total number of pages
                    $stmtCount = $conn->prepare("SELECT COUNT(*) AS total FROM transactions WHERE email = ?");
                    $stmtCount->bind_param("s", $email);
                    if ($stmtCount->execute()) {
                        $totalCount = $stmtCount->get_result()->fetch_assoc()['total'];
                        $totalPages = ceil($totalCount / $resultsPerPage);

                        // Close the prepared statement
                        $stmtCount->close();

                        // Display transactions in a table
                        echo "</table>";

                        // Display pagination links
                        echo "<div class='pagination'>";
                        if ($currentPage > 1) {
                            echo "<a href='?page=" . ($currentPage - 1) . "'>&laquo; Previous</a>";
                        }
                        for ($i = 1; $i <= $totalPages; $i++) {
                            echo "<a href='?page=" . $i . "'" . ($currentPage == $i ? " class='active'" : "") . ">" . $i . "</a>";
                        }
                        if ($currentPage < $totalPages) {
                            echo "<a href='?page=" . ($currentPage + 1) . "'>Next &raquo;</a>";
                        }
                        echo "</div>";
                    } else {
                        echo "Error retrieving transaction count: " . $stmtCount->error;
                    }

                    // Close the database connection
                    mysqli_close($conn);
                    ?>

                </table>

                <form method="post" action="getTransactions.php">
                    <button class="download-button" type="submit">
                        <i class="fa fa-download"></i> Download Transaction Details
                    </button>
                </form>

            </div>
        </main>
    </div>


</body>

</html>