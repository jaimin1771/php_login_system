<?php
include "connection.php"; // Include your database connection

// Check if username exists (AJAX request)
if (isset($_POST['check_username'])) {
    $username = strtolower(trim($_POST['check_username'])); // Convert to lowercase

    $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Username already exists.']);
    } else {
        echo json_encode(['status' => 'success', 'message' => 'Username is available.']);
    }
    exit;
}

// Registration logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['full_name'])) {
    $full_name = $_POST['full_name'];
    $username = strtolower(trim($_POST['username']));
    $email = trim($_POST['email']);
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encrypt the password

    // Check if the username or email already exists
    $query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if ($row['username'] === $username) {
            echo json_encode(['status' => 'error', 'field' => 'username', 'message' => 'Username already exists.']);
        } elseif ($row['email'] === $email) {
            echo json_encode(['status' => 'error', 'field' => 'email', 'message' => 'Email already exists.']);
        }
        exit;
    } else {
        // Insert the new user into the database
        $insert = "INSERT INTO users (full_name, username, email, phone, password) 
                   VALUES ('$full_name', '$username', '$email', '$phone', '$password')";
        if (mysqli_query($conn, $insert)) {
            header('Location: ../registrasion.php');
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Registration failed. Please try again.']);
        }
    }
    exit;
}
