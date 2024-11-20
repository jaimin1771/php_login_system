<?php
// Include database connection file (make sure this is correct path)
include "connection.php";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];



    // Validate and sanitize inputs (basic example)
    $full_name = htmlspecialchars($full_name);
    $username = htmlspecialchars($username);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars($phone);
    $password = password_hash($password, PASSWORD_BCRYPT); // Hash the password for security

    // Prepare SQL query to insert the data into the database
    $query = "INSERT INTO users (full_name, username, email, phone, password) VALUES ('$full_name', '$username', '$email', '$phone', '$password')";
    $result = mysqli_query($conn, $query);

    // Check if the data was inserted successfully
    if ($result) {
        // Redirect to index.php (login page)
        header("Location: ../index.php");
        exit(); // Always call exit() after header() to stop script execution
    } else {
        // If there was an error with the database, handle it here (optional)
        echo "Error: " . mysqli_error($conn);
    }
}
