<?php
// Start session to access user data
session_start();

// Include the database connection file
include "../php/connection.php";  // Adjust the path to your connection.php file

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
  // If not logged in, redirect to login page
  header("Location: login.php");
  exit;
}

// Get the user ID from the session
$userId = $_SESSION['id'];

// Fetch current user data
$query = "SELECT id, username, full_name, email, phone, profile_picture FROM users WHERE id = ?";
if ($stmt = $conn->prepare($query)) {
  $stmt->bind_param("i", $userId);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($user = $result->fetch_assoc()) {
    $username = $user['username'];
    $fullName = $user['full_name'];
    $email = $user['email'];
    $phone = $user['phone'];
    $profilePicture = $user['profile_picture'] ?: 'https://via.placeholder.com/150';
  } else {
    header("Location: login.php");
    exit;
  }

  $stmt->close();
} else {
  echo "Error fetching user data.";
  exit;
}
include "dashboard.php"
?>



<body class="bg-gray-900 text-gray-200 h-screen">

  <div class="flex items-center justify-start h-full w-full">
    <div class="bg-gray-[#f3f4f6] shadow-lg rounded-lg w-[81%] px-6 sm:p-10 ml-auto my-auto">
      <form id="profileForm" action="profile-content.php" method="POST" enctype="multipart/form-data" class="space-y-6 w-full px-[10%]" onsubmit="return validateForm(event)">
        <div class="text-center mb-6">
          <div class="relative w-32 h-32 mx-auto mb-4">
            <img id="profilePicturePreview" src="<?= htmlspecialchars('../uploads/' . $profilePicture) ?>" alt="Profile Picture" class="w-full h-full object-cover rounded-full border-4 border-indigo-500 shadow-lg">
            <label for="profilePictureInput" class="absolute bottom-0 right-0 bg-indigo-500 text-gray-200 p-2 rounded-full shadow-lg cursor-pointer hover:bg-indigo-400">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
              </svg>
            </label>
            <input type="file" id="profilePictureInput" name="profilePictureInput" accept="image/*" class="hidden" onchange="previewProfilePicture(event)">
          </div>
          <h2 class="text-xl font-semibold text-gray-800">Update Your Profile</h2>
        </div>

        <!-- Username Field -->
        <div class="space-y-2">
          <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
          <input
            type="text"
            id="username"
            name="username"
            value="<?= htmlspecialchars($username ?? '') ?>"
            placeholder="Username"
            class="w-full p-3 border bg-gray-700 rounded-lg text-gray-400 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 cursor-not-allowed hover:bg-gray-600"
            readonly>
          <p id="usernameError" class="text-red-500 text-xs"></p>
        </div>

        <!-- Email Field -->
        <div class="space-y-2">
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input
            type="text"
            id="email"
            name="email"
            value="<?= htmlspecialchars($email ?? '') ?>"
            placeholder="Email"
            class="w-full p-3 border bg-gray-700 rounded-lg text-gray-400 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 cursor-not-allowed hover:bg-gray-600"
            readonly>
          <p id="emailError" class="text-red-500 text-xs"></p>
        </div>

        <!-- Full Name Field -->
        <div class="space-y-2">
          <label for="fullName" class="block text-sm font-medium text-gray-700">Full Name</label>
          <input
            type="text"
            id="fullName"
            name="fullName"
            value="<?= htmlspecialchars($fullName ?? '') ?>"
            placeholder="Full Name"
            class="w-full p-3 border bg-gray-900 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          <p id="fullNameError" class="text-red-500 text-xs"></p>
        </div>

        <!-- Phone Field -->
        <div class="space-y-2">
          <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
          <input
            type="text"
            id="phone"
            name="phone"
            value="<?= htmlspecialchars($phone ?? '') ?>"
            placeholder="Phone Number"
            class="w-full p-3 border bg-gray-900 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          <p id="phoneError" class="text-red-500 text-xs"></p>
        </div>


        <!-- Submit Button -->
        <div class="mt-6 text-center">
          <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Update Profile</button>
        </div>
      </form>
    </div>
  </div>
  <script>
    function previewProfilePicture(event) {
      const preview = document.getElementById('profilePicturePreview');
      const file = event.target.files[0];
      const reader = new FileReader();

      reader.onload = function() {
        preview.src = reader.result;
      };

      if (file) {
        reader.readAsDataURL(file);
      }
    }

    function validateForm(event) {
      let isValid = true;
      let errors = {};

      const username = document.getElementById('username').value;
      const email = document.getElementById('email').value;

      // Check if username contains spaces or uppercase letters
      if (/\s/.test(username)) {
        isValid = false;
        errors.username = "Username should not contain spaces.";
      }
      if (/[A-Z]/.test(username)) {
        isValid = false;
        errors.username = "Username should not contain uppercase letters.";
      }

      // Check if full name contains special characters
      const fullName = document.getElementById('fullName').value;
      if (/[^\w\s]/.test(fullName)) {
        isValid = false;
        errors.fullName = "Full name should not contain special characters.";
      }

      // Email Validation
      const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
      if (!emailPattern.test(email)) {
        isValid = false;
        errors.email = "Please enter a valid email address.";
      }

      // Phone Validation
      const phone = document.getElementById('phone').value;
      if (!/^\+[0-9]+$/.test(phone)) { // Ensures '+' is mandatory at the start and only numbers follow
        isValid = false;
        errors.phone = "Phone number should start with a '+' and contain only numbers.";
      }


      // Display errors
      document.getElementById('usernameError').textContent = errors.username || '';
      document.getElementById('fullNameError').textContent = errors.fullName || '';
      document.getElementById('emailError').textContent = errors.email || '';
      document.getElementById('phoneError').textContent = errors.phone || '';

      // AJAX Check for Existing Username and Email
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'check-username-email.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

      xhr.onload = function() {
        const response = JSON.parse(xhr.responseText);
        if (response.usernameExists) {
          isValid = false;
          errors.username = "Username already exists.";
        }
        if (response.emailExists) {
          isValid = false;
          errors.email = "Email already exists.";
        }

        // Display errors after AJAX check
        document.getElementById('usernameError').textContent = errors.username || '';
        document.getElementById('emailError').textContent = errors.email || '';

        // Prevent form submission if invalid
        if (!isValid) {
          event.preventDefault();
        }
      };

      // Send the username and email to the server for checking
      xhr.send('username=' + encodeURIComponent(username) + '&email=' + encodeURIComponent(email));

      return isValid;
    }
  </script>
</body>

</html>