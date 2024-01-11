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
    <title>About Us | Cake Island</title>
</head>
<body>
    <header>
        <h1>About Us</h1>
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
                <li class="active"><a href="about-us.php">About Us</a></li>
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
                <h3>Welcome to Cake Island.</h3>
                <p>Here we are destined to provide you with the most amazing cakes and pastries you have ever tried!!!</p>
            </div>
            <div>
                <img src="red-velvet.jpg" alt="Image of Cake">
            </div>
        </section>
        <h3>Additional Information</h3>
        <ol>
            <li>Chocolate Cake is a classic favorite.</li>
            <li>Vanilla Cake is a simple yet delicious choice.</li>
            <li>Strawberry Cake is perfect for fruit lovers.</li>
        </ol>

        <h3>Cake Details</h3>
        <dl>
            <dt>Chocolate Cake</dt>
            <dd>A rich and decadent chocolate cake.</dd>
            <dt>Vanilla Cake</dt>
            <dd>A light and fluffy vanilla-flavored cake.</dd>
            <dt>Strawberry Cake</dt>
            <dd>A moist and fruity strawberry cake.</dd>
        </dl>
    </main>

    <footer>
        <p>Harshil Ambalal Senghani (HAS220004)</p>
        <div class="datetime" id="date_time"></div>
    </footer>
    <script src="timing.js"></script>
</body>
</html>
