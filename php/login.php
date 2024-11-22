<?php
session_start();
include "connection.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username_email']) && isset($_POST['password'])) {
    $username_email = $_POST['username_email'];
    $password = $_POST['password'];

    // Check if the username/email exists
    $query = "SELECT * FROM users WHERE username = '$username_email' OR email = '$username_email'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        // Successful login, store user id in session
        $_SESSION['user_id'] = $user['id'];  // Assuming 'id' is the primary key of the user

        echo json_encode(['status' => 'success', 'message' => 'Login successful']);
    } else {
        // Invalid credentials
        echo json_encode(['status' => 'error', 'message' => 'Invalid username/email or password']);
    }
    exit;
}
