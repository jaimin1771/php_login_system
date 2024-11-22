<?php
// Start the session only if it hasn't been started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "connection.php";

header('Content-Type: application/json');

// Check if the user is already logged in
if (isset($_SESSION['id'])) {
    echo json_encode(['status' => 'success', 'message' => 'Already logged in']);
    exit;
}

// Process login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        echo json_encode(['status' => 'error', 'message' => 'Email and password are required']);
        exit;
    }

    $emailOrUsername = trim($_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT id, full_name, username, email, password FROM users WHERE username = ? OR email = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ss", $emailOrUsername, $emailOrUsername);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['full_name'] = $user['full_name'];
                echo json_encode(['status' => 'success', 'message' => 'Login successful']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid username/email or password']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'User not found']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error']);
    }

    $conn->close();
    exit;
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}
