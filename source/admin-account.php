<!DOCTYPE html>
<html lang="en">

<?php
    session_start();

    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        $username = $_SESSION['username'];
        // Other actions or page content

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

    } else {
        // Redirect to the login page or perform other actions
        header("Location: index.html");
        exit();
    }
?>

<head>
    <script src="jquery-3.7.1.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="mystyle.css">
    <title>Admin Account</title>
</head>
<body>
    <header>
        <h1>Admin Account</h1>
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
                <li class="active"><a href="admin-account.php">My Account</a></li>
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
                <p>Admin</p>
            </div>
        </section>
        <!-- Add to Inventory -->
        <h2>Admin Add Inventory</h2>
        
        <?php
        if (isset($uploadSuccess)) {
            echo "<p>$uploadSuccess</p>";
        }
        ?>

        <form action="adminNewInv.php" method="post" enctype="multipart/form-data">
            <label for="fileType">Select File Type:</label>
            <select name="file_type" id="fileType">
                <option value="xml">XML</option>
                <option value="json">JSON</option>
            </select>

            <label for="file">Choose File:</label>
            <input type="file" name="file" id="file" accept=".xml, .json" required>

            <button type="submit" name="submit">Upload</button>
        </form>
        <br></br>

        <!-- View Inventory -->
        <h2>View Inventory</h2>

        <?php
        // Perform a SELECT query to retrieve data from the inventory table
        $sql = "SELECT * FROM inventory";
        $result = $conn->query($sql);

        // Check if there are rows in the result
        if ($result->num_rows > 0) {
            echo "<table border='1'>
                    <tr>
                        <th>Item_Num</th>
                        <th>Name</th>
                        <th>Unit_Price</th>
                        <th>Quantity</th>
                        <th>Sub_Category</th>
                        <th>Category</th>
                    </tr>";

            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['Item_Num']}</td>
                        <td>{$row['Name']}</td>
                        <td>{$row['Unit_Price']}</td>
                        <td>{$row['Quantity']}</td>
                        <td>{$row['Sub_Category']}</td>
                        <td>{$row['Category']}</td>
                    </tr>";
            }

            echo "</table>";
        } else {
            echo "0 results";
        }
        ?>
        <br></br>

        <!-- View Low Items Inventory -->
        <h2>Low Inventory Items</h2>
        <?php
        // Define the threshold for low inventory
        $lowInventoryThreshold = 3;

        // Perform a SELECT query to retrieve low inventory items
        $sql = "SELECT * FROM inventory WHERE Quantity < $lowInventoryThreshold";
        $result = $conn->query($sql);

        // Check if there are low inventory items
        if ($result->num_rows > 0) {
            echo "<table border='1'>
                    <tr>
                        <th>Item_Num</th>
                        <th>Name</th>
                        <th>Unit_Price</th>
                        <th>Quantity</th>
                        <th>Sub_Category</th>
                        <th>ImageSrc</th>
                        <th>Category</th>
                    </tr>";

            // Output data of each low inventory item
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['Item_Num']}</td>
                        <td>{$row['Name']}</td>
                        <td>{$row['Unit_Price']}</td>
                        <td>{$row['Quantity']}</td>
                        <td>{$row['Sub_Category']}</td>
                        <td>{$row['ImageSrc']}</td>
                        <td>{$row['Category']}</td>
                    </tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No low inventory items found.</p>";
        }
        ?>
        <br></br>

        <!-- Specfic Date, Customers with more than 2 transactions -->
        <h2>Get Customers with more than 2 Transactions on Specified Date</h2>
        <!-- HTML form for entering a specific date -->
        <form action="" method="post">
            <label for="specificDate">Enter Specific Date:</label>
            <input type="date" name="specific_date" id="specificDate" required>
            <button type="submit" name="submit1">Submit</button>
        </form>
        <?php
        if (isset($_POST['submit1'])) {
            // Get the specific date entered by the admin
            $specificDate = $_POST['specific_date'];

            // Perform a SELECT query to retrieve customers with more than 2 transactions on the specific date
            $sql = "SELECT c.Customer_ID, c.First_Name, c.Last_Name, COUNT(t.Transaction_ID) AS transaction_count
                    FROM customers c
                    JOIN carts ct ON c.Customer_ID = ct.Customer_ID
                    JOIN transactions t ON ct.Transaction_ID = t.Transaction_ID
                    WHERE t.Transaction_Date = '$specificDate'
                    GROUP BY c.Customer_ID
                    HAVING transaction_count > 2";
            
            $result = $conn->query($sql);

            // Check if there are customers with more than 2 transactions on the specific date
            if ($result->num_rows > 0) {
                echo "<h3>Customers with more than 2 transactions on $specificDate:</h3>";
                echo "<table border='1'>
                        <tr>
                            <th>Customer_ID</th>
                            <th>First_Name</th>
                            <th>Last_Name</th>
                            <th>Transaction_Count</th>
                        </tr>";

                // Output data of each customer
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['Customer_ID']}</td>
                            <td>{$row['First_Name']}</td>
                            <td>{$row['Last_Name']}</td>
                            <td>{$row['transaction_count']}</td>
                        </tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No customers found with more than 2 transactions on $specificDate.</p>";
            }
        }
        ?>
        <br></br>

        <!-- See Customers who live in Specified zip code and more than 2 transactions in the specified month -->
        <h2>See Customers who live in Specified zip code and more than 2 transactions in the specified month</h2>
        <!-- HTML form for entering a zip code and a month -->
        <form action="" method="post">
            <label for="zipCode">Enter ZIP Code:</label>
            <input type="text" name="zip_code" id="zipCode" required>

            <label for="specifiedMonth">Enter Month:</label>
            <input type="month" name="specified_month" id="specifiedMonth" required>

            <button type="submit" name="submit2">Submit</button>
        </form>
        <?php
        if (isset($_POST['submit2'])) {
            // Get the zip code and month entered by the admin
            $zipCode = $_POST['zip_code'];
            $specifiedMonth = $_POST['specified_month'];

            // Perform a SELECT query to retrieve customers with more than 2 transactions in the specified month and zip code
            $sql = "SELECT c.Customer_ID, c.First_Name, c.Last_Name, COUNT(t.Transaction_ID) AS transaction_count
                    FROM customers c
                    JOIN carts ct ON c.Customer_ID = ct.Customer_ID
                    JOIN transactions t ON ct.Transaction_ID = t.Transaction_ID
                    WHERE c.Address LIKE '%$zipCode%' AND DATE_FORMAT(t.Transaction_Date, '%Y-%m') = '$specifiedMonth'
                    GROUP BY c.Customer_ID
                    HAVING transaction_count > 2";
            
            $result = $conn->query($sql);

            // Check if there are customers with more than 2 transactions in the specified month and zip code
            if ($result->num_rows > 0) {
                echo "<h3>Customers in ZIP code $zipCode with more than 2 transactions in $specifiedMonth:</h3>";
                echo "<table border='1'>
                        <tr>
                            <th>Customer_ID</th>
                            <th>First_Name</th>
                            <th>Last_Name</th>
                            <th>Transaction_Count</th>
                        </tr>";

                // Output data of each customer
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['Customer_ID']}</td>
                            <td>{$row['First_Name']}</td>
                            <td>{$row['Last_Name']}</td>
                            <td>{$row['transaction_count']}</td>
                        </tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No customers found in ZIP code $zipCode with more than 2 transactions in $specifiedMonth.</p>";
            }
        }
        ?>
        <br></br>

        <!-- Modify the unit price and/or the Quantity in inventory for the item in the inventory table -->
        <h2>Modify Unit Price and/or Quantity in inventory for specified item</h2>
        <!-- HTML form for entering item number, new unit price, and new quantity -->
        <form action="" method="post">
            <label for="itemNumber">Enter Item Number:</label>
            <input type="text" name="item_number" id="itemNumber" required>

            <label for="newUnitPrice">New Unit Price (leave blank to keep unchanged):</label>
            <input type="text" name="new_unit_price" id="newUnitPrice">

            <label for="newQuantity">New Quantity (leave blank to keep unchanged):</label>
            <input type="text" name="new_quantity" id="newQuantity">

            <button type="submit" name="submit3">Submit</button>
        </form>
        <?php
        // Check if the form is submitted
        if (isset($_POST['submit3'])) {
            // Get the item number, new unit price, and new quantity entered by the admin
            $itemNumber = $_POST['item_number'];
            $newUnitPrice = $_POST['new_unit_price'];
            $newQuantity = $_POST['new_quantity'];

            // Perform an UPDATE query to modify the unit price and/or quantity in the inventory
            $updateQuery = "UPDATE inventory SET ";
            if (!empty($newUnitPrice)) {
                $updateQuery .= "Unit_Price = '$newUnitPrice', ";
            }
            if (!empty($newQuantity)) {
                $updateQuery .= "Quantity = '$newQuantity', ";
            }
            // Remove the trailing comma and space
            $updateQuery = rtrim($updateQuery, ", ");
            $updateQuery .= " WHERE Item_Num = '$itemNumber'";

            if ($conn->query($updateQuery) === TRUE) {
                echo "<p>Inventory updated successfully for Item Number: $itemNumber</p>";
            } else {
                echo "<p>Error updating inventory: " . $conn->error . "</p>";
            }
        }
        ?>
        <br></br>

        <!-- See list of Customers older > 20 years old and more than 3 Transactions -->
        <h2>List of Customers older > 20 years old and more than 3 Transactions</h2>
        <?php
        // Perform a SELECT query to retrieve the desired customer information
        $selectQuery = "SELECT c.Customer_ID, c.First_Name, c.Last_Name, c.Age, COUNT(t.Transaction_ID) AS transaction_count
                        FROM customers c
                        LEFT JOIN carts ca ON c.Customer_ID = ca.Customer_ID
                        LEFT JOIN transactions t ON ca.Transaction_ID = t.Transaction_ID
                        WHERE c.Age > 20
                        GROUP BY c.Customer_ID
                        HAVING transaction_count > 3";

        $result = $conn->query($selectQuery);

        // Check if there are results
        if ($result->num_rows > 0) {
            // Display the results in a table
            echo '<table border="1">
                    <tr>
                        <th>Customer ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Age</th>
                        <th>Transaction Count</th>
                    </tr>';

            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>' . $row['Customer_ID'] . '</td>
                        <td>' . $row['First_Name'] . '</td>
                        <td>' . $row['Last_Name'] . '</td>
                        <td>' . $row['Age'] . '</td>
                        <td>' . $row['transaction_count'] . '</td>
                    </tr>';
            }

            echo '</table>';
        } else {
            echo '<p>No customers match the criteria.</p>';
        }
        ?>

    </main>

    <footer>
        <p>Harshil Ambalal Senghani (HAS220004)</p>
        <div class="datetime" id="date_time"></div>
    </footer>
    <script src="timing.js"></script>
</body>
</html>
