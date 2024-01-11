<?php
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

    // Retrieve user input
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Validate inputs
    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    if (strlen($password) < 8) {
        die("Password must be at least 8 characters.");
    }

    // Validate date of birth format (MM/DD/YYYY)
    $dobRegex = '/^\d{2}\/\d{2}\/\d{4}$/';
    if (!preg_match($dobRegex, $dob)) {
        die("Invalid date of birth format. Use MM/DD/YYYY.");
    }

    // Extract month, day, and year from the date of birth
    list($month, $day, $year) = explode('/', $dob);

    // Check if the date is valid
    if (!checkdate($month, $day, $year)) {
        die("Invalid date of birth.");
    }

    // Calculate age
    $currentYear = date('Y');
    $age = $currentYear - $year;

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Hash the password
    // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the Customers table
    $sqlCustomers = "INSERT INTO Customers (First_Name, Last_Name, Age, Email, Address) 
    VALUES ('$firstName', '$lastName', $age, '$email', '$address')";

    if ($conn->query($sqlCustomers) === TRUE) {
        // Retrieve the last inserted auto-increment ID
        $customerId = $conn->insert_id;

        // Insert user data into the Users table
        $sqlUsers = "INSERT INTO Users (Customer_ID, User_Name, Password) 
        VALUES ($customerId, '$username', '$password')";

        if ($conn->query($sqlUsers) === TRUE) {
            echo "Registration successful. You can now log in.";
        } else {
            echo "Error: " . $sqlUsers . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $sqlCustomers . "<br>" . $conn->error;
    }
    
    $conn->close();
?>
