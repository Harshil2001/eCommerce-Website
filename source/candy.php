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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="mystyle.css">
    <title>Candy | Cake Island</title>
</head>
<body>
    <header>
        <h1>Candy</h1>
    <nav>
        <ul>
            <li><a href="fresh-products.php">Fresh Products</a></li>
            <li><a href="frozen.php">Frozen</a></li>
            <li><a href="pantry.php">Pantry</a></li>
            <li><a href="breakfast.php">Breakfast and Cereal</a></li>
            <li><a href="baking.php">Baking</a></li>
            <li><a href="snacks.php">Snacks</a></li>
            <li class="active"><a href="candy.php">Candy</a></li>
            <li><a href="specialty.php">Specialty Shops</a></li>
            <li><a href="deals.php">Deals</a></li>
            <li><a href="my-account.php">My Account</a></li>
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
                <p>Cakes and Pastries</p>
            </div>
        </section>
        <aside>
            <p>While Chocolate Cake is made primarily with cocoa powder and sometimes melted chocolate, Red Velvet Cake is made with a small amount of cocoa powder, but is also known for its signature bright red color, which is usually achieved by adding red food coloring to the batter.</p>
        </aside>
        <section class="d-flex">
            <div>
                <h3>Candies</h3>
                <p>Candy, also called sweets or lollies, is a confection that features sugar as a principal ingredient. </p>
            </div>
            <div>
                <img src="candy.jpg" alt="Image of Candy">
            </div>
        </section>
        <section>
            <label for="candyName">Enter Candy Name:</label>
            <input type="text" id="search-input">
            <button id="search-button">Search</button>
        </section>

        <div id="product-list">

        </div>
    </main>

    <footer>
        <p>Harshil Ambalal Senghani (HAS220004)</p>
        <div class="datetime" id="date_time"></div>
    </footer>
    <script src="timing.js"></script>
    <!-- <script src="ext_script.js"></script> -->
    <!-- <script src="xml_script.js"></script> -->
    <script src="display.js"></script>
    <script>
        const searchInput = document.getElementById("search-input");
        const searchButton = document.getElementById("search-button");
        searchButton.addEventListener("click", function() {
            const searchQuery = searchInput.value.toLowerCase();
            const searchPattern = /^[a-zA-Z]+$/;
            if (!searchPattern.test(searchQuery)) {
                alert("Search must conatin only alphabets!");
            }
            else {
                // fetchAndDisplayProductsFromXml("candy", "all", searchQuery);
                fetchAndDisplayProductsFromDatabase("candy", "all", searchQuery);
            }
        });
    </script>
</body>
</html>
