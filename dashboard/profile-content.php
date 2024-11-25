<?php
// Start the session and check if the user is logged in
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

// Include the database connection
include "../php/connection.php";  // Adjust path to your connection.php file

// Get user ID from session
$userId = $_SESSION['id'];

// Get the form data
$fullName = $_POST['fullName'];
$username = $_POST['username'];
$email = $_POST['email'];
$phone = $_POST['phone'];

// Check if a file was uploaded for the profile picture
if (isset($_FILES['profilePictureInput']) && $_FILES['profilePictureInput']['error'] === UPLOAD_ERR_OK) {
    // Debug: Check for errors
    if ($_FILES['profilePictureInput']['error'] != 0) {
        die("Error during file upload: " . $_FILES['profilePictureInput']['error']);
    }

    $fileTmpPath = $_FILES['profilePictureInput']['tmp_name'];
    $fileName = $_FILES['profilePictureInput']['name'];
    $fileSize = $_FILES['profilePictureInput']['size'];
    $fileType = $_FILES['profilePictureInput']['type'];

    // Get the file extension
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Allowed file extensions
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($fileExtension, $allowedExtensions)) {
        // Create a unique name for the file
        $newFileName = uniqid() . '.' . $fileExtension;
        $uploadPath = '../uploads/' . $newFileName;

        // Move the uploaded file to the server
        if (move_uploaded_file($fileTmpPath, $uploadPath)) {
            // Debug: Check if file is moved
            if (file_exists($uploadPath)) {
                echo "File uploaded successfully.";
            } else {
                echo "Failed to upload file.";
            }

            // Update profile picture in the database
            $query = "UPDATE users SET profile_picture = ?, full_name = ?, username = ?, email = ?, phone = ? WHERE id = ?";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("sssssi", $newFileName, $fullName, $username, $email, $phone, $userId);
                if ($stmt->execute()) {
                    header("Location: profile.php");
                    exit;
                } else {
                    echo "Failed to update profile.";
                }
            } else {
                echo "Database error.";
            }
        } else {
            echo "Failed to upload the file.";
        }
    } else {
        echo "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
    }
} else {
    // If no file was uploaded, update profile information without changing the picture
    $query = "UPDATE users SET full_name = ?, username = ?, email = ?, phone = ? WHERE id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ssssi", $fullName, $username, $email, $phone, $userId);
        if ($stmt->execute()) {
            header("Location: profile.php");
            exit;
        } else {
            echo "Failed to update profile.";
        }
    } else {
        echo "Database error.";
    }
}

$conn->close();
?>
