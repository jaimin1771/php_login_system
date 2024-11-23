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
  <title>Profile Update</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 min-h-screen text-gray-200">
  <div class="flex items-center justify-center min-h-screen w-full">
    <div class="bg-gray-800 shadow-lg rounded-lg w-full p-6 sm:p-10">
      <div class="text-center mb-6">
        <div class="relative w-32 h-32 mx-auto mb-4">
          <img id="profilePicturePreview" 
               src="https://via.placeholder.com/150" 
               alt="Profile Picture" 
               class="w-full h-full object-cover rounded-full border-4 border-gray-700">
          <label for="profilePictureInput" 
                 class="absolute bottom-0 right-0 bg-gray-700 text-gray-200 p-2 rounded-full shadow-lg cursor-pointer hover:bg-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
          </label>
          <input type="file" id="profilePictureInput" accept="image/*" class="hidden" onchange="previewProfilePicture(event)">
        </div>
        <h2 class="text-xl font-semibold">Update Your Profile</h2>
      </div>

      <form action="#" method="POST" class="space-y-6 w-full">
        <div class="grid grid-cols-1 gap-4">
          <input 
            type="text" 
            placeholder="Username" 
            class="w-full p-3 border border-gray-700 bg-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          <input 
            type="text" 
            placeholder="Full Name" 
            class="w-full p-3 border border-gray-700 bg-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          <input 
            type="email" 
            placeholder="Email" 
            class="w-full p-3 border border-gray-700 bg-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          <div class="flex items-center space-x-4">
            <select 
              class="w-1/3 p-3 border border-gray-700 bg-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
              <option value="+1">+1</option>
              <option value="+44">+44</option>
              <option value="+91">+91</option>
              <!-- Add more country codes as needed -->
            </select>
            <input 
              type="tel" 
              placeholder="Phone Number" 
              class="w-2/3 p-3 border border-gray-700 bg-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
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
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          document.getElementById('profilePicturePreview').src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    }
  </script>
</body>
</html>