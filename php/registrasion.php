<?php
session_start(); // Start the session
include "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $country_code = $_POST['country_code']; // Country code
    $phone_number = $_POST['phone_number']; // Phone number (fixed the name)
    $password = $_POST['password'];

    // Combine country code and phone number
    $phone = $country_code . $phone_number;

    // Validate and sanitize inputs
    $full_name = htmlspecialchars($full_name);
    $username = htmlspecialchars($username);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars($phone);
    $password = password_hash($password, PASSWORD_BCRYPT); // Hash the password for security

    // Check if the username exists
    $username_query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $username_result = mysqli_query($conn, $username_query);

    // Check if the email exists
    $email_query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $email_result = mysqli_query($conn, $email_query);

    if (mysqli_num_rows($username_result) > 0 && mysqli_num_rows($email_result) > 0) {
        // If both username and email exist
        echo json_encode(['status' => 'error', 'message' => "Error: username or email already exists."]);
    } elseif (mysqli_num_rows($username_result) > 0) {
        // If only username exists
        echo json_encode(['status' => 'error', 'message' => "Error: username already exists."]);
    } elseif (mysqli_num_rows($email_result) > 0) {
        // If only email exists
        echo json_encode(['status' => 'error', 'message' => "Error: email already exists."]);
    } else {
        // Prepare SQL query to insert the data into the database
        $query = "INSERT INTO users (full_name, username, email, phone, password) VALUES ('$full_name', '$username', '$email', '$phone', '$password')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Send a success response
            echo json_encode(['status' => 'success', 'message' => 'Registration successful!']);
        } else {
            // Send an error response for database failure
            echo json_encode(['status' => 'error', 'message' => "Error: " . mysqli_error($conn)]);
        }
    }
}
