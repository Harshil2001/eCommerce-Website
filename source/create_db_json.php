<?php
// Database connection details
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

// JSON file path
$jsonFilePath = "inventory.json";

// Read JSON file
$jsonData = file_get_contents($jsonFilePath);

// Decode JSON data
$products = json_decode($jsonData, true);

// Process each product in the JSON
foreach ($products as $product) {
    // Extract data from JSON
    $itemNum = $product['id'];
    $name = $product['name'];
    $unitPrice = $product['price'];
    $quantity = $product['quantity'];
    $subCategory = $product['sub_category'];
    $imageSrc = $product['imageSrc'];
    $category = $product['category'];

    // SQL query to insert data into the database
    $sql = "INSERT INTO inventory (Item_Num, Name, Unit_Price, Quantity, Sub_Category, ImageSrc, Category)
            VALUES ('$itemNum', '$name', '$unitPrice', '$quantity', '$subCategory', '$imageSrc', '$category')";

    if ($conn->query($sql) === TRUE) {
        echo "Record inserted successfully<br>";
    } else {
        echo "Error inserting record: " . $conn->error . "<br>";
    }
}

// Close connection
$conn->close();
?>
