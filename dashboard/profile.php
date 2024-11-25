<?php
// Start the session to access user data, only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection file
include "../php/connection.php";  // Adjust path to your connection.php file

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    // If not logged in, redirect to login page or show an error
    header("Location: login.php");
    exit;
}

// Get the user ID from the session
$userId = $_SESSION['id'];

// Query to fetch user data from the database (removed profilePicture)
$query = "SELECT id, username, full_name, email, phone, profile_picture FROM users WHERE id = ?";
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // Store user data in variables
        $username = $user['username'];
        $fullName = $user['full_name'];
        $email = $user['email'];
        $phone = $user['phone'];
        $profilePicture = $user['profile_picture']; // Add profile_picture field

        // Remove the country code from the phone number if needed (adjust based on your data structure)
        $phoneWithoutCountryCode = $phone;  // Modify if phone contains country code
    } else {
        // If no user is found, redirect to the login page
        header("Location: login.php");
        exit;
    }

    $stmt->close();
} else {
    echo "Database error.";
    exit;
}
include "dashboard.php";  // If you have a dashboard page to include
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Update</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 min-h-screen text-gray-200">
  <div class="flex items-center justify-center min-h-screen w-full">
    <div class="bg-gray-800 shadow-lg rounded-lg w-full p-6 sm:p-10">
      <div class="text-center mb-6">
        <div class="relative w-32 h-32 mx-auto mb-4">
          <!-- Profile Picture Preview -->
          <img id="profilePicturePreview" 
               src="<?= $profilePicture ? '../uploads/' . htmlspecialchars($profilePicture) : 'https://via.placeholder.com/150' ?>" 
               alt="Profile Picture" 
               class="w-full h-full object-cover rounded-full border-4 border-gray-700">
          <label for="profilePictureInput" 
                 class="absolute bottom-0 right-0 bg-gray-700 text-gray-200 p-2 rounded-full shadow-lg cursor-pointer hover:bg-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
          </label>
          <input type="file" id="profilePictureInput" name="profilePictureInput" accept="image/*" class="hidden" onchange="previewProfilePicture(event)">
        </div>
        <h2 class="text-xl font-semibold">Update Your Profile</h2>
      </div>

      <form action="update_profile.php" method="POST" enctype="multipart/form-data" class="space-y-6 w-full">
        <div class="grid grid-cols-1 gap-4">
          <input 
            type="text" 
            name="fullName" 
            value="<?= htmlspecialchars($fullName ?? '') ?>" 
            placeholder="Full Name" 
            class="w-full p-3 border border-gray-700 bg-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          <input 
            type="text" 
            name="username" 
            value="<?= htmlspecialchars($username ?? '') ?>" 
            placeholder="Username" 
            class="w-full p-3 border border-gray-700 bg-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          <input 
            type="email" 
            name="email" 
            value="<?= htmlspecialchars($email ?? '') ?>" 
            placeholder="Email" 
            class="w-full p-3 border border-gray-700 bg-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          <div class="flex items-center space-x-4">
            <input 
              type="tel" 
              name="phone" 
              value="<?= htmlspecialchars($phoneWithoutCountryCode ?? '') ?>" 
              placeholder="Phone Number" 
              class="w-full p-3 border border-gray-700 bg-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>
        </div>

        <button 
          type="submit" 
          class="w-full bg-blue-600 text-white font-semibold p-3 rounded-lg hover:bg-blue-700 transition duration-300">
          Update Profile
        </button>
      </form>
    </div>
  </div>

  <script>
    function previewProfilePicture(event) {
      const file = event.target.files[0];  // Get the file object
      if (file) {
        const reader = new FileReader();   // Create a new FileReader instance
        reader.onload = function (e) {
          // Set the preview image source to the file's data URL
          document.getElementById('profilePicturePreview').src = e.target.result;
        };
        reader.readAsDataURL(file);  // Read the file as a data URL
      }
    }
  </script>
</body>
</html>
