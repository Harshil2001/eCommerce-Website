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
    <title>Frozen | Cake Island</title>
</head>
<body>
    <header>
        <h1>Frozen</h1>
        <nav>
            <ul>
                <li><a href="fresh-products.php">Fresh Products</a></li>
                <li class="active"><a href="frozen.php">Frozen</a></li>
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
                <h3>Red Velvet Cake</h3>
                <p>It's dense and soft with a moist and <em>velvety</em> crumb. However, the absolute best part about <strong>red velvet cake</strong> is the cream cheese frosting.</p>
            </div>
            <div>
                <img src="red-velvet.jpg" alt="Image of Cake">
            </div>
        </section>

        <div id="subcategory-selector">
            <select id="subcategory-select">
                <option value="frozen">Shop All</option>
                <option value="frozen-bf">Frozen Breakfast</option>
                <option value="frozen-dessert">Frozen Dessert</option>
                <option value="frozen-meal">Frozen Meal</option>
                <option value="frozen-pizza">Frozen Pizza</option>
                <option value="frozen-meat">Frozen Meat</option>
                <option value="frozen-snacks">Frozen Snacks</option>
            </select>
        </div>

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
        const initialcategory = "frozen";
        // fetchAndDisplayProductsFromXml(initialcategory, "all", "all");
        fetchAndDisplayProductsFromDatabase(initialcategory, "all", "all");
    </script>
</body>
</html>
