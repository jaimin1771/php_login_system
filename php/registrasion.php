<?php
include "connection.php"; // Ensure your database connection is included

// Check if username exists (AJAX request)
if (isset($_POST['check_username'])) {
    $username = strtolower(trim($_POST['check_username'])); // Convert to lowercase

    $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Username found.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found.']);
    }
    exit;
}

// Registration logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $country_code = $_POST['country_code'];
    $phone_number = $_POST['phone_number'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encrypt the password

    // Check if the username or email already exists
    $query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo json_encode(['status' => 'error', 'field' => 'username', 'message' => 'Username or email already exists.']);
    } else {
        // Insert the new user into the database
        $insert = "INSERT INTO users (full_name, username, email, country_code, phone_number, password) VALUES ('$full_name', '$username', '$email', '$country_code', '$phone_number', '$password')";
        if (mysqli_query($conn, $insert)) {
            echo json_encode(['status' => 'success', 'message' => 'Registration successful!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Registration failed. Please try again.']);
        }
    }
}
