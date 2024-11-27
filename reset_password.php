<?php
// Include PHPMailer and your DB connection here if necessary
include 'php/connection.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Initialize variables for form fields and messages
$new_password = '';
$confirm_password = '';
$message = '';
$redirect = false;
$current_password = 'currentPasswordFromDb'; // Replace this with a real query to get the current password from the database

// Check if the token is valid (you'll need to implement token validation logic here)
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Add logic to verify the token against the database and check for expiration
    $valid_token = true;  // Replace this with your token validation

    if ($valid_token) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get new password and confirm password
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            // Validate passwords
            if ($new_password === $confirm_password) {
                // Check if the new password is the same as the current password
                if ($new_password === $current_password) {
                    $message = "New password cannot be the same as the old password. Please choose a different one.";
                } else {
                    // Hash the password and update it in the database
                    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

                    // Update the user's password in the database (you should implement the DB update logic)
                    $sql = "UPDATE users SET password = ? WHERE token = ?";

                    if ($conn->query($sql) === TRUE) {
                        echo "Record updated successfully";
                    } else {
                        echo "Error updating record:";
                    }

                    $password_reset_success = true;  // Assume success after DB update

                    if ($password_reset_success) {
                        $message = "Password successfully reset. You will be redirected to the login page shortly.";
                        $redirect = true;  // Set flag to redirect after 2 seconds
                    } else {
                        $message = "Failed to reset the password. Please try again later.";
                    }
                }
            } else {
                $message = "Passwords do not match. Please try again.";
            }
        }
    } else {
        $message = "Invalid or expired token. Please request a new password reset.";
    }
} else {
    $message = "No token provided. Please request a password reset first.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.11.3/dist/cdn.min.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-gray-300 font-sans leading-normal tracking-normal flex items-center justify-center min-h-screen">
    <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-semibold text-center text-gray-100 mb-4">Reset Your Password</h2>
        <p class="text-center text-gray-400 mb-6">Enter your new password below.</p>

        <!-- Reset Password Form -->
        <form id="reset-password-form" method="POST" action="" onsubmit="return validateForm()">
            <!-- New password input -->
            <div class="mb-4">
                <label for="new_password" class="block text-sm font-medium text-gray-100">New Password</label>
                <input type="password" id="new_password" name="new_password" value="<?php echo htmlspecialchars($new_password); ?>" class="mt-1 px-4 py-2 w-full bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-white" placeholder="Enter your new password">
            </div>

            <!-- Confirm password input -->
            <div class="mb-4">
                <label for="confirm_password" class="block text-sm font-medium text-gray-100">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" value="<?php echo htmlspecialchars($confirm_password); ?>" class="mt-1 px-4 py-2 w-full bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-white" placeholder="Confirm your new password">
            </div>

            <!-- Submit button -->
            <div class="flex justify-center">
                <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">Reset Password</button>
            </div>
        </form>

        <!-- Message container -->
        <?php if ($message): ?>
            <div id="message" class="mt-4 text-center text-sm <?php echo ($redirect) ? 'text-green-500' : 'text-red-500'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function validateForm() {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            // Regular expression for validating the password
            const passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/;

            // Validate password length and format
            if (!passwordRegex.test(newPassword)) {
                document.getElementById('message').textContent = 'Password must be at least 6 characters long, contain 1 uppercase letter, 1 special character, 1 number, and no spaces.';
                document.getElementById('message').classList.remove('hidden');
                return false;
            }

            // Check if passwords match
            if (newPassword !== confirmPassword) {
                document.getElementById('message').textContent = 'Passwords do not match. Please try again.';
                document.getElementById('message').classList.remove('hidden');
                return false;
            }

            return true; // Form is valid
        }
    </script>
</body>

</html>