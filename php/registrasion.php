<?php
ob_start(); // Start output buffering at the top of the file
include "connection.php";

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
    $username = strtolower(trim($_POST['username'])); // Convert username to lowercase
    $email = trim($_POST['email']);
    $phone = $_POST['phone'];
    $country_code = $_POST['country_code']; // Country code will be stored in DB
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $errors = [];

    // Validate Full Name (no special characters allowed)
    if (empty($full_name)) {
        $errors['full_name'] = 'Full Name is required.';
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $full_name)) {
        $errors['full_name'] = 'Full Name should not contain special characters.';
    }

    // Validate Username (no spaces or capital letters)
    if (empty($username)) {
        $errors['username'] = 'Username is required.';
    } elseif (preg_match('/\s/', $username)) {
        $errors['username'] = 'Username should not contain spaces.';
    } elseif (preg_match('/[A-Z]/', $username)) {
        $errors['username'] = 'Username should not contain capital letters.';
    } else {
        $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $errors['username'] = 'Username already exists.';
        }
    }

    // Validate Email
    if (empty($email)) {
        $errors['email'] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format.';
    } else {
        $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $errors['email'] = 'Email already exists.';
        }
    }

    // Validate Phone Number (only numbers, no spaces)
    if (empty($phone)) {
        $errors['phone'] = 'Phone number is required.';
    } elseif (!preg_match("/^[0-9]*$/", $phone)) {
        $errors['phone'] = 'Phone number should only contain numbers, no spaces or characters.';
    }

    // Validate Password
    if (empty($password)) {
        $errors['password'] = 'Password is required.';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Password must be at least 6 characters long, contain at least 1 uppercase letter, 1 number, and 1 special character.';
    } elseif (!preg_match("/[A-Z]/", $password)) {
        $errors['password'] = 'Password must contain at least 1 uppercase letter.';
    } elseif (!preg_match("/[0-9]/", $password)) {
        $errors['password'] = 'Password must contain at least 1 number.';
    } elseif (!preg_match("/[\W_]/", $password)) {
        $errors['password'] = 'Password must contain at least 1 special character.';
    }

    // Validate Confirm Password
    if (empty($confirm_password)) {
        $errors['confirm_password'] = 'Confirm Password is required.';
    } elseif ($password !== $confirm_password) {
        $errors['confirm_password'] = 'Passwords do not match.';
    }

    // If there are validation errors, return them
    if (count($errors) > 0) {
        echo json_encode(['status' => 'error', 'errors' => $errors]);
        exit;
    }

    // Encrypt the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Concatenate country code and phone number
    $full_phone = $country_code . $phone; // Country code and phone number combined

    // Insert the new user into the database (now including the concatenated phone number)
    $insert = "INSERT INTO users (full_name, username, email, phone, password) 
               VALUES ('$full_name', '$username', '$email', '$full_phone', '$hashed_password')";

    if (mysqli_query($conn, $insert)) {
        // Return success response to be handled by JavaScript
        echo json_encode(['status' => 'success', 'message' => 'Registration successful.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Registration failed. Please try again.']);
    }
    exit;
}

ob_end_flush(); // Send the output at the end of the file