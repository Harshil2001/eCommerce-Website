<?php
    // Start the Session
    session_start();

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

    // Retrieve and validate user login input
    $loginUsername = $_POST['loginUsername'];
    $loginPassword = $_POST['loginPassword'];

    // (Your login validation and password hashing logic goes here)

    // Check if the user exists in the Users table
    $sqlLogin = "SELECT * FROM Users WHERE User_Name = '$loginUsername'";
    $result = $conn->query($sqlLogin);

    if ($result->num_rows > 0) {
        // User found, validate password
        $row = $result->fetch_assoc();
        if ($loginPassword === $row['Password']) {
            echo "Login successful. Welcome, $loginUsername!";
            // Passwords match, user is authenticated
            $_SESSION['user_id'] = $row['Customer_ID']; // Set the user ID in the session
            $_SESSION['username'] = $row['User_Name']; // Set the username in the session

            // Redirect to a secure page or perform other actions
            header("Location: fresh-products.php");
            exit();
        } else {
            echo "Invalid password. Please try again.";
        }
    } else {
        echo "User not found. Please register first.";
    }

    $conn->close();
?>
