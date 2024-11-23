<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.11.3/dist/cdn.min.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-gray-300 font-sans leading-normal tracking-normal flex items-center justify-center min-h-screen">
    <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-semibold text-center text-gray-100 mb-4">Forgot Your Password?</h2>
        <p class="text-center text-gray-400 mb-6">Enter your email address to receive a password reset link.</p>

        <!-- Forgot Password Form -->
        <form id="forgot-password-form" method="POST" action="#" onsubmit="return false;">
            <!-- Email input -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-100">Email Address</label>
                <input type="email" id="email" name="email" class="mt-1 px-4 py-2 w-full bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-white" placeholder="Enter your email" required>
            </div>

            <!-- Submit button -->
            <div class="flex justify-center">
                <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">Send Reset Link</button>
            </div>

            <!-- Link to login -->
            <div class="mt-4 text-center">
                <a href="index.php" class="text-blue-500 hover:text-blue-700">Back to Login</a>
            </div>
        </form>

        <!-- Message container -->
        <div id="message" class="mt-4 text-center text-sm text-red-500 hidden"></div>
        <div id="success-message" class="mt-4 text-center text-sm text-green-500 hidden"></div>
    </div>

    <script>
        // AJAX request for forgot password form submission
        $(document).ready(function() {
            $('#forgot-password-form').on('submit', function(e) {
                e.preventDefault(); // Prevent the form from submitting the traditional way

                // Get the email value
                var email = $('#email').val();

                // Validate the email format (basic validation)
                if (email === '') {
                    $('#message').text('Please enter your email address.').removeClass('hidden');
                    return;
                }

                // AJAX request
                $.ajax({
                    url: '/forgot-password', // Endpoint for password reset logic (adjust URL as needed)
                    type: 'POST',
                    data: {
                        email: email
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#success-message').text('A password reset link has been sent to your email.').removeClass('hidden');
                            $('#message').addClass('hidden'); // Hide error message if successful
                        } else {
                            $('#message').text('There was an error processing your request. Please try again.').removeClass('hidden');
                        }
                    },
                    error: function() {
                        $('#message').text('Something went wrong. Please try again later.').removeClass('hidden');
                    }
                });
            });
        });
    </script>
</body>

</html>
