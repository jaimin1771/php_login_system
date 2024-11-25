<?php
// Start the session to access user data, only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection file
include "../php/connection.php"; // Adjust the path if needed

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

// Get the user ID from the session
$userId = $_SESSION['id'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect user data from the form
    $fullName = $_POST['fullName'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Initialize profile picture path
    $profilePicturePath = null;

    // Handle profile picture upload (if a file is uploaded)
    if (isset($_FILES['profilePictureInput']) && $_FILES['profilePictureInput']['error'] === 0) {
        $profilePicture = $_FILES['profilePictureInput'];

        // Specify the folder to save the uploaded file
        $uploadDir = "../uploads/profile_pictures/";

        // Create the directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Validate the file size (e.g., max 2MB) and type
        $maxFileSize = 2 * 1024 * 1024; // 2MB
        $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExt = strtolower(pathinfo($profilePicture['name'], PATHINFO_EXTENSION));

        if ($profilePicture['size'] <= $maxFileSize && in_array($fileExt, $validExtensions)) {
            // Generate a unique filename
            $fileName = uniqid("profile_") . '.' . $fileExt;
            $filePath = $uploadDir . $fileName;

            // Move the uploaded file to the designated directory
            if (move_uploaded_file($profilePicture['tmp_name'], $filePath)) {
                $profilePicturePath = $filePath;
            } else {
                echo "Error uploading the file.";
            }
        } else {
            echo "Invalid file type or size. Please upload a valid image (max 2MB).";
        }
    }

    // Prepare the SQL query to update the user's profile
    if ($profilePicturePath) {
        $query = "UPDATE users SET username = ?, full_name = ?, email = ?, phone = ?, profile_picture = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssi", $username, $fullName, $email, $phone, $profilePicturePath, $userId);
    } else {
        $query = "UPDATE users SET username = ?, full_name = ?, email = ?, phone = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $username, $fullName, $email, $phone, $userId);
    }

    // Execute the query
    if ($stmt->execute()) {
        header("Location: profile.php"); // Redirect on success
        exit;
    } else {
        echo "Error updating profile.";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
