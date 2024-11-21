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

        <!-- Error/Success Message Display -->
        <div id="responseMessage" class="hidden text-center mb-4 p-2 rounded"></div>

        <form id="registrationForm" method="POST" novalidate>
            <!-- Full Name -->
            <div class="mb-4">
                <input type="text" placeholder="Full Name" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    name="full_name" id="full_name">
                <p class="text-red-500 text-sm mt-1 hidden" id="full_name_error"></p>
            </div>
            <!-- Username -->
            <div class="mb-4">
                <input type="text" placeholder="Username" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    name="username" id="username">
                <p class="text-red-500 text-sm mt-1 hidden" id="username_error"></p>
            </div>
            <!-- Email -->
            <div class="mb-4">
                <input type="email" placeholder="Email" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    name="email" id="email">
                <p class="text-red-500 text-sm mt-1 hidden" id="email_error"></p>
            </div>

            <!-- Phone Number and Country Code -->
            <div class="mb-4 flex items-center">
                <select name="country_code" id="country_code" class="w-1/4 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    <option value="+1">+1</option>
                    <option value="+44">+44</option>
                    <option value="+91">+91</option>
                    <!-- Add more country codes as needed -->
                </select>
                <input type="text" placeholder="Phone Number" name="phone_number" id="phone_number"
                    class="w-3/4 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
            </div>
            <p class="text-red-500 text-sm mt-1 hidden" id="phone_error"></p>

            <!-- Password -->
            <div class="mb-4">
                <input type="password" placeholder="Password" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    name="password" id="password">
                <p class="text-red-500 text-sm mt-1 hidden" id="password_error"></p>
            </div>
            <!-- Confirm Password -->
            <div class="mb-6">
                <input type="password" placeholder="Confirm Password" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    id="confirm_password">
                <p class="text-red-500 text-sm mt-1 hidden" id="confirm_password_error"></p>
            </div>
            <!-- Register Button -->
            <button type="submit" id="submitBtn" class="w-full bg-blue-500 text-white py-2 rounded font-semibold hover:bg-blue-600 transition duration-300" disabled>Register</button>
        </form>

        <!-- Link to Login -->
        <p class="text-center text-sm text-gray-600 mt-4">
            Already have an account?
            <a href="index.php" class="text-blue-500 font-semibold hover:underline">Login here</a>
        </p>
    </div>

    <script>
        // Real-time validation
        document.getElementById("registrationForm").addEventListener("input", validateFields);
        document.getElementById("registrationForm").addEventListener("submit", function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch("php/registrasion.php", {
                    method: "POST",
                    body: formData,
                })
                .then((response) => response.json())
                .then((data) => {
                    const responseMessage = document.getElementById("responseMessage");
                    if (data.status === "error") {
                        responseMessage.textContent = data.message;
                        responseMessage.className = "text-red-500 p-2 rounded bg-red-100";
                    } else if (data.status === "success") {
                        responseMessage.textContent = data.message;
                        responseMessage.className = "text-green-500 p-2 rounded bg-green-100";
                        setTimeout(() => {
                            window.location.href = "index.php";
                        }, 2000);
                    }
                    responseMessage.classList.remove("hidden");
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        });

        // Validation logic
        function validateFields() {
            let isFormValid = true;

            // Full Name Validation
            const fullName = document.getElementById("full_name").value.trim();
            const fullNameError = document.getElementById("full_name_error");
            if (!fullName) {
                fullNameError.textContent = "Full name is required.";
                fullNameError.classList.remove("hidden");
                isFormValid = false;
            } else {
                fullNameError.textContent = "";
                fullNameError.classList.add("hidden");
            }

            // Username Validation
            const username = document.getElementById("username").value.trim();
            const usernameError = document.getElementById("username_error");
            if (!username) {
                usernameError.textContent = "Username is required.";
                usernameError.classList.remove("hidden");
                isFormValid = false;
            } else {
                usernameError.textContent = "";
                usernameError.classList.add("hidden");
            }

            // Email Validation
            const email = document.getElementById("email").value.trim();
            const emailError = document.getElementById("email_error");
            if (!email || !validateEmail(email)) {
                emailError.textContent = "Please enter a valid email.";
                emailError.classList.remove("hidden");
                isFormValid = false;
            } else {
                emailError.textContent = "";
                emailError.classList.add("hidden");
            }

            // Phone Number Validation
            const phoneNumber = document.getElementById("phone_number").value.trim();
            const phoneError = document.getElementById("phone_error");
            if (!phoneNumber) {
                phoneError.textContent = "Phone number is required.";
                phoneError.classList.remove("hidden");
                isFormValid = false;
            } else {
                phoneError.textContent = "";
                phoneError.classList.add("hidden");
            }

            // Password Validation
            const password = document.getElementById("password").value.trim();
            const passwordError = document.getElementById("password_error");
            if (!password) {
                passwordError.textContent = "Password is required.";
                passwordError.classList.remove("hidden");
                isFormValid = false;
            } else {
                passwordError.textContent = "";
                passwordError.classList.add("hidden");
            }

            // Confirm Password Validation
            const confirmPassword = document.getElementById("confirm_password").value.trim();
            const confirmPasswordError = document.getElementById("confirm_password_error");
            if (password !== confirmPassword) {
                confirmPasswordError.textContent = "Passwords do not match.";
                confirmPasswordError.classList.remove("hidden");
                isFormValid = false;
            } else {
                confirmPasswordError.textContent = "";
                confirmPasswordError.classList.add("hidden");
            }

            // Enable or disable the submit button
            document.getElementById("submitBtn").disabled = !isFormValid;
        }

        // Email format validation
        function validateEmail(email) {
            const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            return re.test(email);
        }
    </script>
</body>

</html>