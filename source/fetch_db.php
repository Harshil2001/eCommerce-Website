<?php
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

// Fetch product data from the database
$sql = "SELECT * FROM inventory";
$result = $conn->query($sql);

// Check if there are rows in the result
if ($result->num_rows > 0) {
    // Convert result to associative array
    $products = [];
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    // Return products data in JSON format
    header('Content-Type: application/json');
    echo json_encode($products);
} else {
    echo "No products found";
}

// Close connection
$conn->close();
?>
