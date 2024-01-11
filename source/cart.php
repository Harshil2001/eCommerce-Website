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

    // Fetch cart items for the logged-in user
    $userId = $_SESSION['user_id'];
    $sql = "SELECT i.Item_Num, i.Category, i.Sub_Category, i.Name, c.Quantity, t.Transaction_ID, t.Total_Price
            FROM carts c
            JOIN inventory i ON c.Item_Num = i.Item_Num
            JOIN transactions t ON c.Transaction_ID = t.Transaction_ID
            WHERE c.Customer_ID = $userId AND c.Cart_Status = 'In_Cart'";

    $result = $conn->query($sql);
} else {
    // Redirect to the login page or perform other actions
    header("Location: index.html");
    exit();
}
?>


<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="mystyle.css">
    <title>Cart</title>
</head>
<body>
    <header>
        <h1>Cart Page</h1>
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
                <li><a href="my-account.php">My Account</a></li>
                <li><a href="about-us.php">About Us</a></li>
                <li><a href="contact-us.php">Contact Us</a></li>
                <li class="active"><a href="cart.php">Cart</a></li>
                <li><a href="logout.php">logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php
        if ($result->num_rows > 0) {
            // Display cart items
            echo "<h2>Your Cart</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Item ID</th><th>Category</th><th>Subcategory</th><th>Name</th><th>Quantity</th><th>Transaction ID</th><th>Total Price</th></tr>";
    
            // Initialize total price
            $totalPrice = 0; 
    
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['Item_Num'] . "</td>";
                echo "<td>" . $row['Category'] . "</td>";
                echo "<td>" . $row['Sub_Category'] . "</td>";
                echo "<td>" . $row['Name'] . "</td>";
                echo "<td>" . $row['Quantity'] . "</td>";
                echo "<td>" . $row['Transaction_ID'] . "</td>";
                echo "<td>" . $row['Total_Price'] . "</td>";
                echo "</tr>";
    
                // Accumulate total price
                $totalPrice += $row['Total_Price'];
            }
    
            echo "</table>";
    
            // Display total price
            echo "<p>Total Price to be Paid: $totalPrice</p>";
    
            // Provide options for the user
            echo "<br>";
            echo "<form action='checkout.php' method='post'>";
            echo "<input type='submit' name='checkout' value='Proceed to Checkout'>";
            echo "</form>";
    
            echo "<br>";
    
            echo "<form action='cancel_shopping.php' method='post'>";
            echo "<input type='submit' name='cancel' value='Cancel Shopping'>";
            echo "</form>";
        } else {
            // No items in the cart
            echo "<p>Your cart is empty.</p>";
        }
    
        // Close connection
        $conn->close();
        ?>

    </main>
    <footer>
        <p>Harshil Ambalal Senghani (HAS220004)</p>
        <div class="datetime" id="date_time"></div>
    </footer>
    <script src="timing.js"></script>
</body>