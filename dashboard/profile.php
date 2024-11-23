<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "dashboard.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Update Profile</h2>

        <!-- Profile Update Form -->
        <form action="/update-profile" method="POST" enctype="multipart/form-data">
            <!-- Profile Picture -->
            <div class="mb-4">
                <label for="profile_picture" class="block text-gray-700">Profile Picture</label>
                <div class="flex items-center space-x-4">
                    <!-- Profile Image Preview -->
                    <img id="profile_image_preview" src="current-profile.jpg" alt="Profile Picture" class="w-24 h-24 rounded-full object-cover">
                    <!-- File Input -->
                    <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="p-2 border border-gray-300 rounded-md">
                </div>
            </div>

            <!-- Username -->
            <div class="mb-4">
                <label for="username" class="block text-gray-700">Username</label>
                <input type="text" name="username" id="username" value="current-username" class="w-full p-3 border border-gray-300 rounded-md" required>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="current-email@example.com" class="w-full p-3 border border-gray-300 rounded-md" required>
            </div>

            <!-- Phone Number with Country Code -->
            <div class="mb-4 flex items-center space-x-2">
                <label for="phone_number" class="block text-gray-700">Phone Number</label>
                <!-- Country Code Dropdown -->
                <select name="country_code" id="country_code" class="p-3 border border-gray-300 rounded-md">
                    <option value="+1">+1 (USA)</option>
                    <option value="+44">+44 (UK)</option>
                    <option value="+91">+91 (India)</option>
                    <!-- Add more countries as needed -->
                </select>
                <!-- Phone Number -->
                <input type="text" name="phone_number" id="phone_number" value="123-456-7890" class="w-full p-3 border border-gray-300 rounded-md" required>
            </div>

            <!-- Submit Button -->
            <div class="mt-4">
                <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-md hover:bg-blue-700 focus:outline-none">Update Profile</button>
            </div>
        </form>
    </div>

    <!-- Script to Preview Profile Image -->
    <script>
        document.getElementById('profile_picture').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('profile_image_preview').src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>