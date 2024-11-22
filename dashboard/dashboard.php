<?php


// Assign user name or default to "Guest"
$full_name = isset($_SESSION['full_name']) ? htmlspecialchars($_SESSION['full_name']) : 'Guest';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Layout</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 font-sans leading-normal tracking-normal text-gray-300 flex h-screen">

    <!-- Sidebar -->
    <div id="sidebar" class="w-64 bg-gradient-to-b from-indigo-800 via-indigo-700 to-indigo-600 h-screen shadow-lg p-6 hidden md:flex flex-col">
        <h1 class="text-3xl font-semibold text-white mb-8">Dashboard</h1>
        <nav class="space-y-4">
            <a href="home.php" class="block text-gray-300 hover:text-white hover:bg-indigo-800 rounded-lg px-4 py-2">Home</a>
            <a href="recent-activities.php" class="block text-gray-300 hover:text-white hover:bg-indigo-800 rounded-lg px-4 py-2">Recent Activities</a>
            <a href="upcoming-events.php" class="block text-gray-300 hover:text-white hover:bg-indigo-800 rounded-lg px-4 py-2">Upcoming Events</a>
            <a href="settings.php" class="block text-gray-300 hover:text-white hover:bg-indigo-800 rounded-lg px-4 py-2">Settings</a>
            <a href="contact.php" class="block text-gray-300 hover:text-white hover:bg-indigo-800 rounded-lg px-4 py-2">Contact</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col w-full">
        <!-- Navbar -->
        <nav class="bg-gradient-to-r from-indigo-900 to-indigo-800 p-4 text-white shadow-md">
            <div class="flex items-center justify-between">
                <button id="hamburger" class="block md:hidden">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <span class="text-2xl font-semibold"></span>

                <!-- Profile Dropdown -->
                <div class="relative group">
                    <button class="flex items-center space-x-2">
                        <img src="https://via.placeholder.com/40" alt="Profile" class="w-10 h-10 rounded-full border-2 border-white">
                        <span class="hidden md:inline font-semibold">
                            <?php echo $full_name; ?>
                        </span>
                    </button>
                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg text-gray-800 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        <a href="profile.php" class="block px-4 py-2 hover:bg-gray-200">Profile</a>
                        <form method="POST" action="logout.php" class="block">
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-200">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="p-6 md:p-10 flex-1">
            <?php
            // Include the page content
            if (isset($page_content)) {
                include $page_content;
            }
            ?>
        </div>
    </div>
</body>

</html>