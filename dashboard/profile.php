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

// Check if connection is alive before using it
if (!$conn->ping()) {
  die("Database connection is not alive.");
}

// Query to fetch user data from the database
$query = "SELECT id, username, full_name, email, phone, profile_picture FROM users WHERE id = ?";

// Prepare the statement
if ($stmt = $conn->prepare($query)) {
  // Bind parameters
  $stmt->bind_param("i", $userId);
  // Execute the query
  $stmt->execute();
  // Get the result
  $result = $stmt->get_result();

  // If user is found, fetch data
  if ($user = $result->fetch_assoc()) {
    // Store user data in variables
    $username = $user['username'];
    $fullName = $user['full_name'];
    $email = $user['email'];
    $phone = $user['phone'];
    $profilePicture = $user['profile_picture'] ?: 'https://via.placeholder.com/150';
  } else {
    // If no user is found, redirect to the login page
    header("Location: login.php");
    exit;
  }

  // Close the prepared statement
  $stmt->close();
} else {
  echo "Database query preparation failed.";
  exit;
}
include 'dashboard.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Update</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-gray-200 h-screen">

  <div class="flex items-center justify-start h-full w-full">
    <div class="bg-gray-800 shadow-lg rounded-lg w-[81%] p-6 sm:p-10 ml-auto my-auto">

      <form action="profile-content.php" method="POST" enctype="multipart/form-data" class="space-y-6 w-full">
        <div class="text-center mb-6">
          <div class="relative w-32 h-32 mx-auto mb-4">
            <img id="profilePicturePreview" src="<?= htmlspecialchars('../uploads/' . $profilePicture) ?>" alt="Profile Picture" class="w-full h-full object-cover rounded-full border-4 border-gray-700">
            <label for="profilePictureInput" class="absolute bottom-0 right-0 bg-gray-700 text-gray-200 p-2 rounded-full shadow-lg cursor-pointer hover:bg-gray-600">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
              </svg>
            </label>
            <input type="file" id="profilePictureInput" name="profilePictureInput" accept="image/*" class="hidden" onchange="previewProfilePicture(event)">
          </div>
          <h2 class="text-xl font-semibold">Update Your Profile</h2>
        </div>

        <!-- Full Name Field -->
        <div class="space-y-2">
          <label for="fullName" class="block text-sm font-medium text-gray-300">Full Name</label>
          <input type="text" id="fullName" name="fullName" value="<?= htmlspecialchars($fullName ?? '') ?>" placeholder="Full Name" class="w-full p-3 border border-gray-700 bg-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Username Field -->
        <div class="space-y-2">
          <label for="username" class="block text-sm font-medium text-gray-300">Username</label>
          <input type="text" id="username" name="username" value="<?= htmlspecialchars($username ?? '') ?>" placeholder="Username" class="w-full p-3 border border-gray-700 bg-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Email Field -->
        <div class="space-y-2">
          <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
          <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" placeholder="Email" class="w-full p-3 border border-gray-700 bg-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Phone Field -->
        <div class="space-y-2">
          <label for="phone" class="block text-sm font-medium text-gray-300">Phone Number</label>
          <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($phone ?? '') ?>" placeholder="Phone Number" class="w-full p-3 border border-gray-700 bg-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-blue-600 text-white font-semibold p-3 rounded-lg hover:bg-blue-700 transition duration-300">
          Update Profile
        </button>
      </form>
    </div>
  </div>

  <script>
    // Preview profile picture when selected
    function previewProfilePicture(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('profilePicturePreview').src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    }
  </script>

</body>

</html>

<?php
// Close the connection after all script execution is complete (end of the file)
$conn->close();
?>