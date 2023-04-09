<?php
session_start();

// Check if user is not logged in, then redirect to login page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login.html");
    exit;
}

// logout script
if (isset($_POST['logout'])) {
    // unset all session variables
    session_unset();
    // destroy the session
    session_destroy();
    // redirect to the login page
    header('Location: ../login.html');
    exit;
}

?>



<!DOCTYPE html>
<html>

<head>
    <title>Transaction History</title>
    <link rel="stylesheet" href="../../styles/navbar.css">
    <link rel="stylesheet" href="./styles/sidebar.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            margin-left: 18%;
            margin-right: 18%;
        }

        th,
        td {
            text-align: center;
            padding: 8px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        @media only screen and (max-width: 600px) {
            table {
                width: 100%;
                margin-left: 5%;
                margin-right: 5%;
            }

            th,
            td {
                display: block;
                text-align: center;
            }

            th {
                height: 50px;
            }

            td {
                height: 70px;
            }

            td:before {
                content: attr(data-label);
                float: left;
                font-weight: bold;
                text-transform: uppercase;
                margin-bottom: 5px;
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
                    <a href="./account.php">My Account</a>
                </li>
            </ul>
        </div>
    </div>
    <br><br><br><br><br>

    <div class="sidebar">
        <ul>
            <li><a href="./account.php">Profile Settings</a></li>
            <li><a href="">Transaction History</a></li>
            <li><a href="">Transaction Settings</a></li>
            <li><a href="">Security</a></li>

            <li>
                <form method="POST"><button type="submit" name="logout">Logout</button></form>
            </li>
        </ul>
    </div>


    <!-- Add your HTML content here -->


    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Sender</th>
                <th>Receiver</th>
                <th>Type</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td data-label="Date">01/01/2022</td>
                <td data-label="Sender">John</td>
                <td data-label="Receiver">Sarah</td>
                <td data-label="Type">Send</td>
                <td data-label="Amount">$100.00</td>
            </tr>
            <tr>
                <td data-label="Date">02/01/2022</td>
                <td data-label="Sender">Sarah</td>
                <td data-label="Receiver">John</td>
                <td data-label="Type">Receive</td>
                <td data-label="Amount">$50.00</td>
            </tr>
            <tr>
                <td data-label="Date">03/01/2022</td>
                <td data-label="Sender">David</td>
                <td data-label="Receiver">John</td>
                <td data-label="Type">Send</td>
                <td data-label="Amount">$75.00</td>
            </tr>
            <tr>
                <td data-label="Date">04/01/2022</td>
                <td data-label="Sender">John</td>
                <td data-label="Receiver">David</td>
                <td data-label="Type">Receive</td>
                <td data-label="Amount">$25.00</td>
            </tr>
        </tbody>
    </table>
    </div>





</body>

</html>