<?php
include "php/registrasion.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gray-900 text-gray-300 font-sans leading-normal tracking-normal flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-gray-800 rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-100">Create an Account</h2>
        <form id="registrationForm" method="POST" action="php/registrasion.php" novalidate>
            <!-- Success Message -->
            <div id="successMessage" class="hidden bg-green-100 text-green-500 p-2 rounded mb-4"></div>

            <!-- Full Name -->
            <div class="mb-4">
                <input type="text" placeholder="Full Name" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-white" name="full_name" id="full_name">
                <p class="text-red-500 text-sm mt-1 hidden" id="full_name_error"></p>
            </div>

            <!-- Username -->
            <div class="mb-4">
                <input type="text" placeholder="Username" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-white" name="username" id="username">
                <p class="text-red-500 text-sm mt-1 hidden" id="username_error"></p>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <input type="email" placeholder="Email" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-white" name="email" id="email">
                <p class="text-red-500 text-sm mt-1 hidden" id="email_error"></p>
            </div>

            <!-- Phone -->
            <div class="mb-4">
                <div class="flex items-center gap-2">
                    <select name="country_code" id="country_code" class="px-2 py-2 bg-gray-700 border border-gray-600 rounded focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-white">
                        <option value="+91">+91</option>
                        <option value="+1">+1</option>
                        <option value="+44">+44</option>
                    </select>
                    <input type="text" placeholder="Phone Number" name="phone" id="phone" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-white">
                </div>
                <p class="text-red-500 text-sm mt-1 hidden" id="phone_error"></p>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <input type="password" placeholder="Password" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-white" name="password" id="password">
                <p class="text-red-500 text-sm mt-1 hidden" id="password_error"></p>
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <input type="password" placeholder="Confirm Password" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-white" name="confirm_password" id="confirm_password">
                <p class="text-red-500 text-sm mt-1 hidden" id="confirm_password_error"></p>
            </div>

            <button type="submit" id="registerBtn" class="w-full px-4 py-2 bg-indigo-600 text-white font-bold rounded hover:bg-indigo-700">Register</button>

            <!-- After the Register button -->
            <div class="mt-4 text-center">
                <p class="text-sm">
                    Already have an account? <a href="index.php" class="text-blue-500 hover:text-blue-700">Login here</a>
                </p>
            </div>

        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#registrationForm').on('submit', function(e) {
                e.preventDefault();

                // Clear previous errors
                $('.text-red-500').addClass('hidden');
                $('#successMessage').addClass('hidden');

                let formData = $(this).serialize();

                $.ajax({
                    url: 'php/registrasion.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(data) {
                        if (data.status === 'error') {
                            // Display field-specific errors
                            $.each(data.errors, function(field, message) {
                                $('#' + field + '_error').text(message).removeClass('hidden');
                            });
                        } else if (data.status === 'success') {
                            // Display success message
                            $('#successMessage').text(data.message).removeClass('hidden');
                            setTimeout(function() {
                                window.location.href = 'index.php'; // Redirect after success
                            }, 2000);
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
