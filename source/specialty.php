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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="mystyle.css">
    <title>Specialty | Cake Island</title>
</head>
<body>
    <header>
        <h1>Specialty shops</h1>
        <nav>
            <ul>
                <li><a href="fresh-products.php">Fresh Products</a></li>
                <li><a href="frozen.php">Frozen</a></li>
                <li><a href="pantry.php">Pantry</a></li>
                <li><a href="breakfast.php">Breakfast and Cereal</a></li>
                <li><a href="baking.php">Baking</a></li>
                <li><a href="snacks.php">Snacks</a></li>
                <li><a href="candy.php">Candy</a></li>
                <li class="active"><a href="specialty.php">Specialty Shops</a></li>
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
                <h3>Specialty Stores</h3>
                <p>It is a shop/store that carries a deep assortment of brands, styles, or models within a relatively narrow category of goods.</p>
            </div>
            <div>
                <img src="specialty.jpg" alt="Image of Specialty">
            </div>
        </section>
        <section>
            <h3>Get Your Special Offer</h3>
            <button id="startButton">Start Special Offer</button>

            <div id="quiz" style="display: none;">
            <p id="question"></p>
            <input type="radio" id="yes" name="answer" value="Yes">
            <label for="yes">Yes</label><br>
            <input type="radio" id="no" name="answer" value="No">
            <label for="no">No</label><br>
            <button id="nextButton">Next</button>
            <button id="skipButton">Skip</button>
            </div>

            <div id="result" style="display: none;"></div>
        </section>
    </main>

    <footer>
        <p>Harshil Ambalal Senghani (HAS220004)</p>
        <div class="datetime" id="date_time"></div>
    </footer>
    <script src="timing.js"></script>
    <script src="specialoffer.js"></script>
</body>
</html>
