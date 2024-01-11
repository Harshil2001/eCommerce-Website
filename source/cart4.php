<!DOCTYPE html>
<html lang="en">

<?php
    session_start();

    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        $username = $_SESSION['username'];
        // Other actions or page content
    } else {
        // Redirect to the login page or perform other actions
        header("Location: index.html");
        exit();
    }
?>

<head>
    <!-- <script src="jquery-3.7.1.min.js"></script> -->
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
        <div class="right-content">
            <h3><em>Here is your cart!</em></h3>

            <div id="cart">
                <ul id="cart-items"></ul>
            </div>
            <br>
            <button id="clear-button">Clear Cart</button>
            <button id="purchase">Buy Now</button>
        </div>
    </main>
    <footer>
        <p>Harshil Ambalal Senghani (HAS220004)</p>
        <div class="datetime" id="date_time"></div>
    </footer>
    <script src="timing.js"></script>
    <!-- <script src="ext_script.js"></script> -->
    <script src="cart.js"></script>
    <script>
        // displayCart();
        // const clearButton = document.getElementById("clear-button")
        // clearButton.addEventListener("click", function() {
        //     localStorage.removeItem("cart")
        //     displayCart()
        // })

        displayCart();

        const clearButton = document.getElementById("clear-button")
        clearButton.addEventListener("click", function(){
            localStorage.removeItem("cart")
            localStorage.removeItem("json_inventory")
            localStorage.removeItem("xml_inventory")
            displayCart()
        })

        const buyButton = document.getElementById("purchase");
        buyButton.addEventListener("click", function(){
            purchaseOrder();
            alert("Items purchased. Inventories have been updated.")
        })
    </script>
</body>