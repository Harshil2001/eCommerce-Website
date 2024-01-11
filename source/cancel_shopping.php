<?php
// Start the session to access session variables
session_start();

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

    // Cancel shopping - update transaction status, cart status, and restore inventory quantity
    $userId = $_SESSION['user_id'];

    // Update Transaction_Status in transactions table to 'Cancelled'
    $updateTransactionStatus = "UPDATE transactions t
                                   JOIN carts c ON t.Transaction_ID = c.Transaction_ID
                                   SET t.Transaction_Status = 'Cancelled'
                                   WHERE c.Customer_ID = $userId AND c.Cart_Status = 'In_Cart'";
    $conn->query($updateTransactionStatus);

    // Restore inventory quantity
    $restoreInventory = "UPDATE inventory i
                            JOIN carts c ON i.Item_Num = c.Item_Num
                            SET i.Quantity = i.Quantity + c.Quantity
                            WHERE c.Customer_ID = $userId AND c.Cart_Status = 'In_Cart'";
    $conn->query($restoreInventory);

    // Update Cart_Status in carts table to 'Cancelled'
    $updateCartStatus = "UPDATE carts
                            SET Cart_Status = 'Cancelled'
                            WHERE Customer_ID = $userId AND Cart_Status = 'In_Cart'";
    $conn->query($updateCartStatus);

    // Close connection
    $conn->close();

    // Display JavaScript alert
    echo "<script>alert('Shopping cancelled successfully!');";
    echo "window.location.href='cart.php';</script>";
    exit();
} else {
    // If user is not logged in, provide appropriate response
    echo "<p>User not logged in.</p>";
}
?>
