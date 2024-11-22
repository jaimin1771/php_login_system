<?php
include "php/login.php"; // Include your connection
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <!-- Centered Login Form -->
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm">
            <h2 class="text-2xl font-bold text-center mb-6">Login</h2>
            <form action="#" method="POST" id="login-form">

                <!-- Username or Email -->
                <div class="mb-4">
                    <label for="username-email" class="block text-sm font-medium text-gray-700">Username or Email</label>
                    <input
                        type="text"
                        id="username-email"
                        name="username-email"
                        placeholder="Enter your username or email"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        required />
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        required />
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full py-2 px-4 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Login
                </button>

                <!-- Forgot Password Link -->
                <div class="mt-4 text-center">
                    <a href="forgot_password.php" class="text-sm text-blue-600 hover:underline">Forgot Password?</a>
                </div>

                <!-- Register Link -->
                <div class="mt-2 text-center">
                    <p class="text-sm text-gray-600">Don't have an account?
                        <a href="registrasion.php" class="text-blue-600 hover:underline">Register here</a>
                    </p>
                </div>

            </form>
        </div>
    </div>

    <!-- Include jQuery (for AJAX example) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Handle form submission with AJAX
        $(document).ready(function() {
            $('#login-form').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                var usernameEmail = $('#username-email').val();
                var password = $('#password').val();

                // Basic validation
                if (!usernameEmail || !password) {
                    alert('Please fill in both fields.');
                    return;
                }

                // AJAX call to login endpoint (adjust URL as needed)
                $.ajax({
                    url: 'index.php', // The same page is used for login in this case
                    type: 'POST',
                    data: {
                        username_email: usernameEmail,
                        password: password
                    },
                    success: function(response) {
                        var res = JSON.parse(response);
                        if (res.status === 'success') {
                            window.location.href = 'dashboard/dashboard.php'; // Redirect to dashboard
                        } else {
                            alert(res.message); // Show error message
                        }
                    },
                    error: function() {
                        alert('An error occurred. Please try again.');
                    }
                });
            });
        });
    </script>

</body>

</html>