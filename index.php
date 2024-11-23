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

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm">
            <h2 class="text-2xl font-bold text-center mb-6">Login</h2>
            <form id="loginForm">
                <div class="mb-4">
                    <input type="text" id="email" name="email" placeholder="Username or Email"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required />
                </div>
                <div class="mb-6">
                    <input type="password" id="password" name="password" placeholder="Password"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required />
                </div>
                <button type="submit"
                    class="w-full py-2 px-4 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Login
                </button>
                <div class="mt-4 text-center">
                    <a href="forgot_password.php" class="text-sm text-blue-600 hover:underline">Forgot Password?</a>
                </div>
                <div class="mt-2 text-center">
                    <p class="text-sm text-gray-600">Don't have an account?
                        <a href="registrasion.php" class="text-blue-600 hover:underline">Register here</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: 'php/login.php',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        window.location.href = 'dashboard/home.php';
                    } else {
                        alert(response.message);
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