<?php
session_start(); // Start the session to use session variables
include "connection.php";

// Initialize an error message variable
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $username_or_email = $_POST['username_or_email'];
    $password = $_POST['password'];

    // Sanitize inputs
    $username_or_email = htmlspecialchars($username_or_email);

    // Prepare the query to check if the username/email exists in the database
    $query = "SELECT * FROM users WHERE username = '$username_or_email' OR email = '$username_or_email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    // Check if the user exists
    if (mysqli_num_rows($result) > 0) {
        // Fetch the user data
        $user = mysqli_fetch_assoc($result);

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Set session variables to store the user data (you can also store user ID)
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];

            // Redirect to the dashboard or home page
            header("Location: dashboard.php");
            exit();
        } else {
            // If password is incorrect
            $_SESSION['error_message'] = "Invalid username/email or password.";
        }
    } else {
        // If no user was found with that username/email
        $_SESSION['error_message'] = "No user found with that username/email.";
    }
}

// Redirect back to the login page if there's an error
header("Location: login.php");
exit();
