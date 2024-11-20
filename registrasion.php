<?php
include "php/registrasion.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal text-gray-800 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-6 text-center">Create an Account</h2>
        <form id="registrationForm" method="POST" action="php/registrasion.php" novalidate>
            <!-- Full Name -->
            <div class="mb-4">
                <input type="text" placeholder="Full Name" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" name="full_name" id="full_name">
                <p id="full_name_error" class="text-red-500 text-xs hidden">Full name is required</p>
            </div>
            <!-- Username -->
            <div class="mb-4">
                <input type="text" placeholder="Username" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" name="username" id="username">
                <p id="username_error" class="text-red-500 text-xs hidden">Username is required</p>
            </div>
            <!-- Email -->
            <div class="mb-4">
                <input type="email" placeholder="Email" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" name="email" id="email">
                <p id="email_error" class="text-red-500 text-xs hidden">Enter a valid email address</p>
            </div>
            <!-- Country Code and Phone -->
            <div class="mb-4">
                <div class="flex items-center">
                    <!-- Country Code Dropdown -->
                    <select id="country_code" name="country_code" class="border border-gray-300 rounded-md p-2 mr-2">
                        <option value="+91">+91 (India)</option>
                        <option value="+1">+1 (USA)</option>
                        <option value="+44">+44 (UK)</option>
                        <!-- Add more country codes as needed -->
                    </select>
                    <!-- Phone Input -->
                    <input type="tel" placeholder="Phone" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" name="phone" id="phone">
                </div>
                <p id="phone_error" class="text-red-500 text-xs hidden">Enter a valid phone number</p>
            </div>
            <!-- Password -->
            <div class="mb-4">
                <input type="password" placeholder="Password" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" name="password" id="password">
                <p id="password_error" class="text-red-500 text-xs hidden">
                    Password must be at least 8 characters, with one uppercase letter, one number, and one special character.
                </p>
            </div>
            <!-- Confirm Password -->
            <div class="mb-6">
                <input type="password" placeholder="Confirm Password" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" id="confirm_password">
                <p id="confirm_password_error" class="text-red-500 text-xs hidden">Passwords do not match</p>
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

    <script>
        document.getElementById("registrationForm").addEventListener("submit", function(event) {
            let isValid = true;

            // Full Name Validation
            const fullName = document.getElementById("full_name");
            if (!fullName.value.trim()) {
                isValid = false;
                document.getElementById("full_name_error").classList.remove("hidden");
            } else {
                document.getElementById("full_name_error").classList.add("hidden");
            }

            // Username Validation
            const username = document.getElementById("username");
            if (!username.value.trim()) {
                isValid = false;
                document.getElementById("username_error").classList.remove("hidden");
            } else {
                document.getElementById("username_error").classList.add("hidden");
            }

            // Email Validation
            const email = document.getElementById("email");
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!email.value.trim() || !emailPattern.test(email.value)) {
                isValid = false;
                document.getElementById("email_error").classList.remove("hidden");
            } else {
                document.getElementById("email_error").classList.add("hidden");
            }

            // Phone Validation
            const phone = document.getElementById("phone");
            if (!phone.value.trim() || isNaN(phone.value)) {
                isValid = false;
                document.getElementById("phone_error").classList.remove("hidden");
            } else {
                document.getElementById("phone_error").classList.add("hidden");
            }

            // Password Validation
            const password = document.getElementById("password");
            const passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            if (!password.value.trim() || !passwordPattern.test(password.value)) {
                isValid = false;
                document.getElementById("password_error").classList.remove("hidden");
            } else {
                document.getElementById("password_error").classList.add("hidden");
            }

            // Confirm Password Validation
            const confirmPassword = document.getElementById("confirm_password");
            if (confirmPassword.value !== password.value) {
                isValid = false;
                document.getElementById("confirm_password_error").classList.remove("hidden");
            } else {
                document.getElementById("confirm_password_error").classList.add("hidden");
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    </script>
</body>

</html>