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
    <script src="jquery-3.7.1.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="mystyle.css">
    <title>Contact Us | Cake Island</title>
</head>
<body>
    <header>
        <h1>Contact Us</h1>
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
                <li class="active"><a href="contact-us.php">Contact Us</a></li>
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
        <section>
            <form id="validatedForm">
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" required> <br> <br> 
            
                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" required> <br> <br> 
            
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required> <br> <br> 
            
                <label for="phoneNumber">Phone Number:</label>
                <input type="tel" id="phoneNumber" name="phoneNumber" required> <br> <br> 
            
                <label for="male">Male</label>
                <input type="radio" id="gender" name="gender" value="male" required>
            
                <label for="female">Female</label>
                <input type="radio" id="gender " name="gender" value="female" required> <br> <br>
            
                <label for="comment">Comment:</label>
                <textarea id="comment" name="comment" rows="6" required></textarea><br> <br> 
            
                <span id="validationError" style="color: red;"></span> <br>
            
                <input type="submit" value="Submit">
            </form>
        </section>
    </main>

    <footer>
        <p>Harshil Ambalal Senghani (HAS220004)</p>
        <div class="datetime" id="date_time"></div>
    </footer>

    <script>
        // Get references to form elements
        const validationForm = document.getElementById("validatedForm");
        const firstNameInput = document.getElementById("firstName");
        const lastNameInput = document.getElementById("lastName");
        const phoneNumberInput = document.getElementById("phoneNumber");
        const emailInput = document.getElementById("email");
        const genderSelect = document.getElementById("gender");
        const commentTextarea = document.getElementById("comment");
        const validationError = document.getElementById("validationError");
    
        // Add a submit event listener to the form
        validationForm.addEventListener("submit", function(event) {
            // Prevent the form from submitting by default
            event.preventDefault();
            
            // Checking if all requirements are satisfied
            // Validate first name and last name (alphabetic and first letter capital)
            const firstNamePattern = /^[A-Z][a-zA-Z]*$/;
            const lastNamePattern = /^[A-Z][a-zA-Z]*$/;
    
            if (!firstNamePattern.test(firstNameInput.value) || !lastNamePattern.test(lastNameInput.value)) {
                validationError.textContent = "First name and last name should be alphabetic with the first letter capitalized.";
                return;
            }
    
            if (firstNameInput.value === lastNameInput.value) {
                validationError.textContent = "First name and last name cannot be the same.";
                return;
            }
    
            const phonePattern = /^\(\d{3}\) \d{3}-\d{4}$/;
            if (!phonePattern.test(phoneNumberInput.value)) {
                validationError.textContent = "Phone number must be formatted as (ddd) ddd-dddd.";
                return;
            }
    
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(emailInput.value)) {
                validationError.textContent = "Email address must contain '@' and '.'";
                return;
            }
    
            if (genderSelect.value === "") {
                validationError.textContent = "Please select a gender.";
                return;
            }
    
            if (commentTextarea.value.length < 10) {
                validationError.textContent = "Comment must be at least 10 characters long.";
                return;
            }
    
            // All validation checks passed, you can submit the form
            validationError.textContent = "";
            validationForm.submit();
        });
    </script>
    <script src="timing.js"></script>
</body>
</html>
