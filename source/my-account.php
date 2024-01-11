<?php
// Start the session to access session variables
session_start();
// Check if the user is an Admin
if (isset($_SESSION['user_id'])) {
    if ('admin' === $_SESSION['username']) {
        // Redirect to the login page or perform other actions
        header("Location: admin-account.php");
        exit();
    }
}

// Check if the user is logged in and user_id is set in the session
if (isset($_SESSION['user_id'])) {
    // Replace these with your actual database credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mytest";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $userId = $_SESSION['user_id'];

    // Function to cancel a transaction
    function cancelTransaction($conn, $transactionId) {
        // Restore inventory quantity
        $restoreInventory = "UPDATE inventory i
                                JOIN carts c ON i.Item_Num = c.Item_Num
                                SET i.Quantity = i.Quantity + c.Quantity
                                WHERE c.Transaction_ID = $transactionId";
        $conn->query($restoreInventory);

        // Update Transaction_Status in transactions table to 'Cancelled'
        $updateTransactionStatus = "UPDATE transactions
                                       SET Transaction_Status = 'Cancelled'
                                       WHERE Transaction_ID = $transactionId";
        $conn->query($updateTransactionStatus);

        // Update Cart_Status in carts table to 'Cancelled'
        $updateCartStatus = "UPDATE carts
                                       SET Cart_Status = 'Cancelled'
                                       WHERE Transaction_ID = $transactionId";
        $conn->query($updateCartStatus);

        // Display JavaScript alert
        echo "<script>alert('Transaction cancelled successfully!');";
        echo "window.location.href='my-account.php';</script>";
    }

    // Check if a cancel request is made for a specific transaction
    if (isset($_POST['cancel_transaction'])) {
        $transactionIdToCancel = $_POST['transaction_id_to_cancel'];
        cancelTransaction($conn, $transactionIdToCancel);
    }

    // Fetch user's ALL transactions
    $fetchTransactions = "SELECT t.Transaction_ID, t.Transaction_Status, t.Transaction_Date, t.Total_Price,
                                    c.Item_Num, c.Quantity, i.Name
                             FROM transactions t
                             JOIN carts c ON t.Transaction_ID = c.Transaction_ID
                             JOIN inventory i ON c.Item_Num = i.Item_Num
                             WHERE c.Customer_ID = $userId
                             ORDER BY t.Transaction_Date DESC";
    $result = $conn->query($fetchTransactions);

    // Filter by month
    $resultMonth = null; // Initialize the variable outside the condition
    if (isset($_POST['filter_transactions'])) {
        $filterMonth = $_POST['filter_month'];
        $fetchMonthTransactions = "SELECT t.Transaction_ID, t.Transaction_Status, t.Transaction_Date, t.Total_Price,
                                    c.Item_Num, c.Quantity, i.Name
                             FROM transactions t
                             JOIN carts c ON t.Transaction_ID = c.Transaction_ID
                             JOIN inventory i ON c.Item_Num = i.Item_Num
                             WHERE c.Customer_ID = $userId  
                             AND DATE_FORMAT(t.Transaction_Date, '%Y-%m') = '$filterMonth'
                             ORDER BY t.Transaction_Date DESC";
        $resultMonth = $conn->query($fetchMonthTransactions);
    }

    // Filter for the last 3 months
    $result3Month = null; // Initialize the variable outside the condition
    if (isset($_POST['filter_last_3_months'])) {
        $fetch3MonthTransactions = "SELECT t.Transaction_ID, t.Transaction_Status, t.Transaction_Date, t.Total_Price,
                                    c.Item_Num, c.Quantity, i.Name
                             FROM transactions t
                             JOIN carts c ON t.Transaction_ID = c.Transaction_ID
                             JOIN inventory i ON c.Item_Num = i.Item_Num
                             WHERE c.Customer_ID = $userId AND t.Transaction_Date >= DATE_SUB(NOW(), INTERVAL 3 MONTH)
                             ORDER BY t.Transaction_Date DESC";
        $result3Month = $conn->query($fetch3MonthTransactions);
    }

    // Filter by year
    $resultYear = null; // Initialize the variable outside the condition
    if (isset($_POST['filter_transactions_year'])) {
        $filterYear = $_POST['filter_year'];
        $fetchYearTransactions = "SELECT t.Transaction_ID, t.Transaction_Status, t.Transaction_Date, t.Total_Price,
                                    c.Item_Num, c.Quantity, i.Name
                             FROM transactions t
                             JOIN carts c ON t.Transaction_ID = c.Transaction_ID
                             JOIN inventory i ON c.Item_Num = i.Item_Num
                             WHERE c.Customer_ID = $userId AND YEAR(t.Transaction_Date) = '$filterYear'
                             ORDER BY t.Transaction_Date DESC";
        $resultYear = $conn->query($fetchYearTransactions);
    }
} else {
    // If user is not logged in, provide appropriate response or redirect to login page
    echo "<p>User not logged in.</p>";
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="jquery-3.7.1.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="mystyle.css">
    <title>My Account | Cake Island</title>
</head>
<body>
    <header>
        <h1>My Account</h1>
        <nav>
            <ul>
                <li><a href="fresh-products.php">Fresh Products</a></li>
                <li><a href="frozen.php">Frozen</a></li>
                <li><a href="pantry.php">Pantry</a></li>
                <li><a href="breakfast.php">Breakfast and Cereal</a></li>
                <li><a href="baking.php">Baking</a></li>
                <li><a href="snacks.php">Snacks</a></li>
                <li><a href="candy.php">Candy</a></li>
                <li><a href="specialty.php">Specialty Shops</a></li>
                <li><a href="deals.php">Deals</a></li>
                <li class="active"><a href="my-account.php">My Account</a></li>
                <li><a href="about-us.php">About Us</a></li>
                <li><a href="contact-us.php">Contact Us</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="logout.php">logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section>
            <div class="text-align-center banner-center-cover">
                <p>My Account</p>
            </div>
        </section>
        <section>
            
            <h2>Your Transactions</h2>

            <form method="post">
                <table border="1">
                    <tr>
                        <th>Transaction ID</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Item Number</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= $row['Transaction_ID'] ?></td>
                            <td><?= $row['Transaction_Status'] ?></td>
                            <td><?= $row['Transaction_Date'] ?></td>
                            <td><?= $row['Item_Num'] ?></td>
                            <td><?= $row['Name'] ?></td>
                            <td><?= $row['Quantity'] ?></td>
                            <td><?= $row['Total_Price'] ?></td>
                            <td>
                                <?php
                                if ($row['Transaction_Status'] === 'In_Cart') {
                                    ?>
                                    <button type="submit" name="cancel_transaction" value="1">Cancel</button>
                                    <input type="hidden" name="transaction_id_to_cancel" value="<?= $row['Transaction_ID'] ?>">
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </form>

            <h2>Filter Transactions</h2>

            <!-- Filter By Month -->
            <form method="post">
                <label for="filter_month">Filter by Month:</label>
                <input type="month" name="filter_month" id="filter_month">
                <button type="submit" name="filter_transactions">Filter</button>
            </form>
            <?php
            if ($resultMonth != null && $resultMonth->num_rows > 0) {
                ?>
                <table border="1">
                    <tr>
                        <th>Transaction ID</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Item Number</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                    <?php
                    while ($row = $resultMonth->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= $row['Transaction_ID'] ?></td>
                            <td><?= $row['Transaction_Status'] ?></td>
                            <td><?= $row['Transaction_Date'] ?></td>
                            <td><?= $row['Item_Num'] ?></td>
                            <td><?= $row['Name'] ?></td>
                            <td><?= $row['Quantity'] ?></td>
                            <td><?= $row['Total_Price'] ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <?php
            } else {
                // No items in the transactions
                echo "<p>No Transactions in the Selected Month. OR No Selection done.</p>";
            }
            ?>

            <!-- Filter Last 3 Months -->
            <form method="post">
                <button type="submit" name="filter_last_3_months">Filter Last 3 Months</button>
            </form>
            <?php
            if ($result3Month != null && $result3Month->num_rows > 0) {
                ?>
                <table border="1">
                    <tr>
                        <th>Transaction ID</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Item Number</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                    <?php
                    while ($row = $result3Month->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= $row['Transaction_ID'] ?></td>
                            <td><?= $row['Transaction_Status'] ?></td>
                            <td><?= $row['Transaction_Date'] ?></td>
                            <td><?= $row['Item_Num'] ?></td>
                            <td><?= $row['Name'] ?></td>
                            <td><?= $row['Quantity'] ?></td>
                            <td><?= $row['Total_Price'] ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <?php
            } else {
                // No items in the transactions
                echo "<p>No Transactions in the Last 3 Months. OR No Selection done.</p>";
            }
            ?>

            <!-- Filter By Year -->
            <form method="post">
                <label for="filter_year">Filter by Year:</label>
                <input type="number" name="filter_year" placeholder="Enter Year" id="filter_year">
                <button type="submit" name="filter_transactions_year">Filter</button>
            </form>
            <?php
            if ($resultYear != null && $resultYear->num_rows > 0) {
                ?>
                <table border="1">
                    <tr>
                        <th>Transaction ID</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Item Number</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                    <?php
                    while ($row = $resultYear->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= $row['Transaction_ID'] ?></td>
                            <td><?= $row['Transaction_Status'] ?></td>
                            <td><?= $row['Transaction_Date'] ?></td>
                            <td><?= $row['Item_Num'] ?></td>
                            <td><?= $row['Name'] ?></td>
                            <td><?= $row['Quantity'] ?></td>
                            <td><?= $row['Total_Price'] ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <?php
            } else {
                // No items in the transactions
                echo "<p>No Transactions in the Selected Year. OR No Selection done.</p>";
            }
            ?>

        </section>
    </main>

    <footer>
        <p>Harshil Ambalal Senghani (HAS220004)</p>
        <div class="datetime" id="date_time"></div>
    </footer>
    <script src="timing.js"></script>
</body>
</html>
