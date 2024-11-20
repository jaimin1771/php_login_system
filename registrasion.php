<?php
include "php/registrasion.php"
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form with Country Code</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
    <style>
        .iti {
            width: 100%;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal text-gray-800 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-6 text-center">Create an Account</h2>
        <form id="registrationForm" method="POST" action="php/registrasion.php">
            <!-- Full Name -->
            <div class="mb-4">
                <input type="text" placeholder="Full Name" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" name="full_name" id="full_name">
                <p id="full_name_error" class="text-red-500 text-xs hidden">Full name is </p>
            </div>
            <!-- Username -->
            <div class="mb-4">
                <input type="text" placeholder="Username" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" name="username" id="username">
                <p id="username_error" class="text-red-500 text-xs hidden">Username is </p>
                <p id="username_taken_error" class="text-red-500 text-xs hidden">Username already taken</p>
            </div>
            <!-- Email -->
            <div class="mb-4">
                <input type="email" placeholder="Email" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" name="email" id="email">
                <p id="email_error" class="text-red-500 text-xs hidden">Email is </p>
                <p id="email_taken_error" class="text-red-500 text-xs hidden">Email already taken</p>
            </div>
            <!-- Phone Number with Country Code -->
            <div class="mb-4">
                <input id="phone" type="tel" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" name="phone">
                <p id="phone_error" class="text-red-500 text-xs hidden">Phone number is </p>
            </div>
            <!-- Password -->
            <div class="mb-4">
                <input type="password" placeholder="Password" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" name="password" id="password">
                <p id="password_error" class="text-red-500 text-xs hidden">Password is </p>
            </div>
            <!-- Confirm Password -->
            <div class="mb-6">
                <input type="password" placeholder="Confirm Password" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" id="confirm_password">
                <p id="confirm_password_error" class="text-red-500 text-xs hidden">Confirm password is </p>
                <p id="password_mismatch_error" class="text-red-500 text-xs hidden">Passwords do not match</p>
            </div>
            <!-- Register Button -->
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded font-semibold hover:bg-blue-600 transition duration-300">Register</button>
        </form>
        <!-- Link to Login -->
        <p class="text-center text-sm text-gray-600 mt-4">
            Already have an account?
            <a href="index.php" class="text-blue-500 font-semibold hover:underline">Login here</a>
        </p>
    </div>


</body>

</html>