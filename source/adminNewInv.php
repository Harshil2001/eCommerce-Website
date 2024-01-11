<?php
session_start();

if (isset($_POST['submit'])) {
    $fileType = $_POST['file_type']; // 'xml' or 'json'

    // Process the uploaded file based on $fileType
    if ($fileType === 'xml') {
        handleXmlUpload();
    } elseif ($fileType === 'json') {
        handleJsonUpload();
    }
}

function handleXmlUpload() {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $uploadedFileName = $_FILES['file']['name'];
        $tmpFileName = $_FILES['file']['tmp_name'];

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

        // Validate if the file is XML
        $fileExtension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);
        if (strtolower($fileExtension) === 'xml') {
            $xml = simplexml_load_file($tmpFileName);

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
                    $insertQuery = "INSERT INTO inventory (Name, Unit_Price, Quantity, Sub_Category, ImageSrc, Category)
                                    VALUES ('$name', '$unitPrice', '$quantity', '$subCategory', '$imageSrc', '$category')";

                    if ($conn->query($insertQuery) === TRUE) {
                        echo "Record inserted successfully for Item_Num: $itemNum<br>";
                    } else {
                        echo "Error inserting record: " . $conn->error . "<br>";
                    }
                }
            }
            echo "<script>alert('XML file processed successfully!');";
            echo "window.location.href='admin-account.php';</script>";
        } else {
            echo "<script>alert('Error: Please upload a valid XML file.');";
            echo "window.location.href='admin-account.php';</script>";
        }
    } else {
        echo "<script>alert('Error: Failed to upload the XML file.');";
        echo "window.location.href='admin-account.php';</script>";
    }
}

function handleJsonUpload() {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $uploadedFileName = $_FILES['file']['name'];
        $tmpFileName = $_FILES['file']['tmp_name'];

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

        // Validate if the file is JSON
        $fileExtension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);
        if (strtolower($fileExtension) === 'json') {
            // Read JSON file
            $jsonData = file_get_contents($tmpFileName);

            // Decode JSON data
            $products = json_decode($jsonData, true);

            // Your existing code to process JSON data (e.g., updating inventory)
            foreach ($products as $product) {
                // Extract data from XML
                $itemNum = $product['id'];
                $name = $product['name'];
                $unitPrice = $product['price'];
                $quantity = $product['quantity'];
                $subCategory = $product['sub_category'];
                $imageSrc = $product['imageSrc'];
                $category = $product['category'];

                // Check if the item already exists in the inventory
                $existingItemQuery = "SELECT * FROM inventory WHERE Item_Num = '$itemNum'";
                // $existingItemQuery = "SELECT * FROM inventory WHERE Name = '$name' AND Unit_Price = '$unitPrice' AND Sub_Category = '$subCategory' AND Category = '$category' AND ImageSrc = '$imageSrc'";
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
                    $insertQuery = "INSERT INTO inventory (Name, Unit_Price, Quantity, Sub_Category, ImageSrc, Category)
                                    VALUES ('$name', '$unitPrice', '$quantity', '$subCategory', '$imageSrc', '$category')";

                    if ($conn->query($insertQuery) === TRUE) {
                        echo "Record inserted successfully for Item_Num: $itemNum<br>";
                    } else {
                        echo "Error inserting record: " . $conn->error . "<br>";
                    }
                }
            }

            echo "<script>alert('JSON file processed successfully!');";
            echo "window.location.href='admin-account.php';</script>";
        } else {
            echo "<script>alert('Error: Please upload a valid JSON file.');";
            echo "window.location.href='admin-account.php';</script>";
        }
    } else {
        echo "<script>alert('Error: Failed to upload the JSON file.');";
        echo "window.location.href='admin-account.php';</script>";
    }
}

?>
