<?php
// update_inventory_and_transaction.php
session_start();
$userId = $_SESSION['user_id'];
$username = $_SESSION['username'];

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

// Get data from the request
$data = json_decode(file_get_contents("php://input"), true);

$itemId = $data['cart'][0]['Item_Num'];
$quantity = $data['cart'][0]['quantity'];

// Check if the desired quantity exists in inventory
$sqlCheckInventory = "SELECT Item_Num, Name, Unit_Price, Quantity FROM inventory WHERE Item_Num = $itemId";
$result = $conn->query($sqlCheckInventory);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $availableQuantity = $row['Quantity'];

    if ($availableQuantity >= $quantity) {
        // Calculate total price
        $totalPrice = $quantity * $row['Unit_Price'];

        // Update inventory
        $sqlUpdateInventory = "UPDATE inventory SET Quantity = Quantity - $quantity WHERE Item_Num = $itemId";
        $conn->query($sqlUpdateInventory);

        // Insert into transaction table
        $sqlInsertTransaction = "INSERT INTO transactions (Transaction_Status, Transaction_Date, Total_Price) VALUES ('In_Cart', NOW(), $totalPrice)";
        $conn->query($sqlInsertTransaction);

        // Get the transaction ID
        $transactionId = $conn->insert_id;

        // Insert into cart table
        $sqlInsertCart = "INSERT INTO carts (Customer_ID, Transaction_ID, Item_Num, Quantity, Cart_Status) VALUES ($userId, $transactionId, $itemId, $quantity, 'In_Cart')";
        $conn->query($sqlInsertCart);

        // // Update the transaction ID in the inventory table
        // $sqlUpdateInventoryTransactionId = "UPDATE inventory SET Last_Transaction_ID = $transactionId WHERE Item_Num = $itemId";
        // $conn->query($sqlUpdateInventoryTransactionId);

        // Provide feedback or data back to the client
        $response = array(
            'success' => true,
            'message' => 'Item added to cart and inventory updated successfully',
            'transactionId' => $transactionId
        );

        echo json_encode($response);
    } else {
        // Not enough quantity in inventory
        $response = array(
            'success' => false,
            'message' => 'This item is out of stock'
        );

        echo json_encode($response);
    }
} else {
    // Item not found in inventory
    $response = array(
        'success' => false,
        'message' => 'Item not found in inventory'
    );

    echo json_encode($response);
}

// Close connection
$conn->close();
?>
