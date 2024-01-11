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

// XML file path
$xmlFilePath = "inventory.xml";

// Load XML from file
$xml = simplexml_load_file($xmlFilePath);

// Process each product in the XML
foreach ($xml->Product as $product) {
    // Extract data from XML
    $itemNum = $product->id;
    $name = $product->name;
    $unitPrice = $product->price;
    $quantity = $product->quantity;
    $subCategory = $product->sub_category;
    $imageSrc = $product->imageSrc;
    $category = $product->category;

    // Check if the item already exists in the inventory
    $existingItemQuery = "SELECT * FROM inventory WHERE Item_Num = '$itemNum'";
    $existingItemResult = $conn->query($existingItemQuery);

    if ($existingItemResult->num_rows > 0) {
        // Item already exists, update the quantity
        $updateQuantityQuery = "UPDATE inventory SET Quantity = Quantity + '$quantity' WHERE Item_Num = '$itemNum'";
        if ($conn->query($updateQuantityQuery) === TRUE) {
            echo "Quantity updated successfully for Item_Num: $itemNum<br>";
        } else {
            echo "Error updating quantity: " . $conn->error . "<br>";
        }
    } else {
        // Item doesn't exist, insert a new row
        $insertQuery = "INSERT INTO inventory (Item_Num, Name, Unit_Price, Quantity, Sub_Category, ImageSrc, Category)
                        VALUES ('$itemNum', '$name', '$unitPrice', '$quantity', '$subCategory', '$imageSrc', '$category')";

        if ($conn->query($insertQuery) === TRUE) {
            echo "Record inserted successfully for Item_Num: $itemNum<br>";
        } else {
            echo "Error inserting record: " . $conn->error . "<br>";
        }
    }
}

// Close connection
$conn->close();
?>
