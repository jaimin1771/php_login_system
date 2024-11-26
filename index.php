<?php
// Start the session only if it hasn't been started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to the dashboard if the user is already logged in
if (isset($_SESSION['id'])) {
    header("Location: dashboard/home.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-gray-300">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-sm">
            <h2 class="text-2xl font-bold text-center mb-6 text-gray-100">Login</h2>
            <form id="loginForm">
                <div class="mb-4">
                    <input type="text" id="email" name="email" placeholder="Username or Email"
                        class="block w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md text-gray-300 placeholder-gray-500 focus:ring-indigo-500 focus:border-indigo-500" />
                </div>
                <div class="mb-6">
                    <input type="password" id="password" name="password" placeholder="Password"
                        class="block w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md text-gray-300 placeholder-gray-500 focus:ring-indigo-500 focus:border-indigo-500" />
                    <!-- Error message container -->
                </div>
                <button type="submit"
                    class="w-full py-2 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Login
                </button>
                <span id="passwordError" class="text-red-500 text-sm mt-1"></span>
                <div class="mt-4 text-center">
                    <a href="forgot_password.php" class="text-sm text-indigo-400 hover:underline">Forgot Password?</a>
                </div>
                <div class="mt-2 text-center">
                    <p class="text-sm text-gray-400">Don't have an account?
                        <a href="registrasion.php" class="text-indigo-400 hover:underline">Register here</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();

            // Clear previous errors
            $('#passwordError').text('');
            $('#passwordError').text('');

            $.ajax({
                url: 'php/login.php',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        window.location.href = 'dashboard/home.php';
                    } else {
                        // Display errors under the input fields
                        if (response.message.includes("Email and password are required")) {
                            $('#passwordError').text(response.message);
                            $('#passwordError').text(response.message);
                        } else if (response.message.includes("Invalid username/email or password")) {
                            $('#passwordError').text(response.message);
                            $('#passwordError').text(response.message);
                        } else if (response.message.includes("User not found")) {
                            $('#passwordError').text(response.message);
                        }
                    }
                },
                error: function() {
                    alert('An error occurred. Please try again.');
                }
            });
        });
    </script>
</body>

</html>