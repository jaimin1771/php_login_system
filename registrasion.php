<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal text-gray-800 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-6 text-center">Create an Account</h2>
        <form id="registrationForm" method="POST" action="php/registrasion.php" novalidate>
            <!-- Success Message -->
            <div id="successMessage" class="hidden bg-green-100 text-green-500 p-2 rounded mb-4"></div>

            <!-- Full Name -->
            <div class="mb-4">
                <input type="text" placeholder="Full Name" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" name="full_name" id="full_name">
                <p class="text-red-500 text-sm mt-1 hidden" id="Username_err"></p>
            </div>

            <!-- Username -->
            <div class="mb-4">
                <input type="text" placeholder="Username" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" name="username" id="username">
                <p class="text-red-500 text-sm mt-1 hidden" id="username_error"></p>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <input type="email" placeholder="Email" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" name="email" id="email">
                <p class="text-red-500 text-sm mt-1 hidden" id="email_error"></p>
            </div>

            <!-- Phone -->
            <div class="mb-4">
                <div class="flex items-center gap-2">
                    <select name="country_code" id="country_code" class="px-2 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        <option value="+1">+1</option>
                        <option value="+44">+44</option>
                        <option value="+91">+91</option>
                    </select>
                    <input type="text" placeholder="Phone Number" name="phone" id="phone" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>
                <p class="text-red-500 text-sm mt-1 hidden" id="phone_error"></p>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <input type="password" placeholder="Password" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" name="password" id="password">
                <p class="text-red-500 text-sm mt-1 hidden" id="password_error"></p>
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <input type="password" placeholder="Confirm Password" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" name="confirm_password" id="confirm_password">
                <p class="text-red-500 text-sm mt-1 hidden" id="confirm_password_error"></p>
            </div>

            <button type="submit" id="submitBtn" class="w-full bg-blue-500 text-white py-2 rounded font-semibold hover:bg-blue-600 transition duration-300">Register</button>
        </form>
    </div>

    <script>
        // Check username availability via AJAX
        $('#username').on('blur', function() {
            var username = $(this).val().trim();
            if (username.length > 0) {
                $.ajax({
                    type: 'POST',
                    url: 'your-php-script.php',
                    data: {
                        check_username: username
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.status === 'error') {
                            $('#username-status').text(data.message);
                        } else {
                            $('#username-status').text(data.message).removeClass('text-red-500').addClass('text-green-500');
                        }
                    }
                });
            }
        });

        // Handle form submission via AJAX
        $('#registration-form').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            var formData = $(this).serialize();

            // Disable the submit button to prevent multiple submissions
            $('#submit-button').prop('disabled', true);

            $.ajax({
                type: 'POST',
                url: 'your-php-script.php',
                data: formData,
                success: function(response) {
                    var data = JSON.parse(response);
                    alert(data.message);
                    if (data.status === 'success') {
                        $('#registration-form')[0].reset();
                    }
                    $('#submit-button').prop('disabled', false); // Enable the submit button after submission
                }
            });
        });

        function validateUsername() {
            const username = $("#username").val().trim();
            if (!username) {
                $("#username_error").text("Username is required.").removeClass("hidden");
            } else {
                $("#username_error").addClass("hidden");
                $.ajax({
                    type: "POST",
                    url: "php/registrasion.php",
                    data: {
                        check_username: username
                    },
                    success: function(response) {
                        const data = JSON.parse(response);
                        if (data.status === "error") {
                            $("#username_error").text(data.message).removeClass("hidden");
                        } else {
                            $("#username_error").addClass("hidden");
                        }
                    },
                });
            }
        }

        function validateFields() {
            validateUsername();
        }


        $(document).ready(function() {
            // Live validation on input change
            $("#username").on("keyup", function() {
                validateUsername();
            });
            $("#email").on("keyup", function() {
                validateEmail();
            });
            $("#phone").on("keyup", function() {
                validatePhone();
            });
            $("#password").on("keyup", function() {
                validatePassword();
            });
            $("#confirm_password").on("keyup", function() {
                validateConfirmPassword();
            });
            $("#full_name").on("keyup", function() {
                validateFullName(); // Live validation for full name
            });

            $("#registrationForm").submit(function(e) {
                e.preventDefault();
                validateFields();

                if (!$(".text-red-500:not(.hidden)").length) {
                    const formData = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: "php/registrasion.php",
                        data: formData,
                        success: function(response) {
                            const data = JSON.parse(response);
                            if (data.status === 'success') {
                                $("#successMessage").text(data.message).removeClass("hidden");
                                $("#registrationForm")[0].reset();
                            } else {
                                $(`#${data.field}_error`).text(data.message).removeClass("hidden");
                            }
                        }
                    });
                }
            });
        });

        // New function to validate Full Name
        function validateFullName() {
            const fullName = $("#full_name").val().trim();
            if (!fullName) {
                $("#Username_err").text("Full Name is required.").removeClass("hidden");
            } else if (fullName.split(" ").length < 2) {
                $("#Username_err").text("Full Name must contain both first and last name.").removeClass("hidden");
            } else {
                $("#Username_err").addClass("hidden");
            }
        }

        function validateUsername() {
            const username = $("#username").val().trim();
            const usernameRegex = /^[a-z0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~`]+$/;
            if (!username) {
                $("#username_error").text("Username is required.").removeClass("hidden");
            } else if (!usernameRegex.test(username)) {
                $("#username_error").text("Username can not contain Capital letters and space.").removeClass("hidden");
            } else {
                $("#username_error").addClass("hidden");
            }
        }

        function validateEmail() {
            const email = $("#email").val().trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email) {
                $("#email_error").text("Email is required.").removeClass("hidden");
            } else if (!emailRegex.test(email)) {
                $("#email_error").text("Enter a valid email address.").removeClass("hidden");
            } else {
                $("#email_error").addClass("hidden");
            }
        }

        function validatePhone() {
            const phone = $("#phone").val().trim();
            if (!phone) {
                $("#phone_error").text("Phone number is required.").removeClass("hidden");
            } else if (!/^\d+$/.test(phone)) {
                $("#phone_error").text("Phone number can only contain numbers.").removeClass("hidden");
            } else {
                $("#phone_error").addClass("hidden");
            }
        }

        function validatePassword() {
            const password = $("#password").val().trim();
            const regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z\d!@#$%^&*(),.?":{}|<>]{6,}$/;

            if (!password) {
                $("#password_error").text("Password is required.").removeClass("hidden");
            } else if (!regex.test(password)) {
                $("#password_error").text("Password must contain at least 1 uppercase letter, 1 number, 1 special character, and be at least 6 characters long.").removeClass("hidden");
            } else {
                $("#password_error").addClass("hidden");
            }
        }


        function validateConfirmPassword() {
            const password = $("#password").val().trim();
            const confirmPassword = $("#confirm_password").val().trim();
            if (!confirmPassword) {
                $("#confirm_password_error").text("Confirm Password is required.").removeClass("hidden");
            } else if (confirmPassword !== password) {
                $("#confirm_password_error").text("Passwords do not match.").removeClass("hidden");
            } else {
                $("#confirm_password_error").addClass("hidden");
            }
        }

        function validateFields() {
            validateFullName(); // Validate Full Name
            validateUsername();
            validateEmail();
            validatePhone();
            validatePassword();
            validateConfirmPassword();
        }
        // Assuming you are using jQuery for AJAX
        $('#registration_form').submit(function(event) {
            event.preventDefault();

            $.ajax({
                url: 'register.php', // Your PHP file handling registration
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message); // Show the success message
                        if (response.redirect) {
                            window.location.href = response.redirect; // Redirect to index.php
                        }
                    } else {
                        alert(response.message); // Show error message
                    }
                },
                error: function() {
                    alert('An error occurred, please try again.');
                }
            });
        });
    </script>
</body>

</html>