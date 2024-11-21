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
            </div>
            <!-- Username -->
            <div class="mb-4">
                <input type="text" placeholder="Username" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    name="username" id="username">
            </div>
            <!-- Email -->
            <div class="mb-4">
                <input type="email" placeholder="Email" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    name="email" id="email">
            </div>
            <!-- Country Code and Phone -->
            <div class="mb-4">
                <div class="flex items-center">
                    <!-- Country Code Dropdown -->
                    <select id="country_code" name="country_code" class="border border-gray-300 rounded-md p-2 mr-2">
                        <option value="+91">+91</option>
                        <option value="+1">+1</option>
                        <option value="+44">+44</option>
                    </select>
                    <!-- Phone Input -->
                    <input type="tel" placeholder="Phone" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                        name="phone" id="phone">
                </div>
            </div>
            <!-- Password -->
            <div class="mb-4">
                <input type="password" placeholder="Password" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" name="password" id="password">
            </div>
            <!-- Confirm Password -->
            <div class="mb-6">
                <input type="password" placeholder="Confirm Password" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" id="confirm_password">
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
            event.preventDefault(); // Prevent default form submission

            // Collect form data
            const formData = new FormData(this);

            // Send data via AJAX
            fetch("php/registrasion.php", {
                    method: "POST",
                    body: formData,
                })
                .then((response) => response.json())
                .then((data) => {
                    const responseMessage = document.getElementById("responseMessage");
                    if (data.status === "error") {
                        // Show error message
                        responseMessage.textContent = data.message;
                        responseMessage.className = "text-red-500 p-2 rounded bg-red-100";
                    } else if (data.status === "success") {
                        // Show success message and redirect to login
                        responseMessage.textContent = data.message;
                        responseMessage.className = "text-green-500 p-2 rounded bg-green-100";
                        setTimeout(() => {
                            window.location.href = "index.php"; // Redirect to login page
                        }, 2000);
                    }
                    responseMessage.classList.remove("hidden");
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        });
    </script>
</body>

</html>