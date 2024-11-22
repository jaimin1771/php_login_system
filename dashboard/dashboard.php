<?php
include "../php/dashboard.php"
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Dashboard with Tabs</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal text-gray-800 flex h-screen">

    <!-- Sidebar -->
    <div id="sidebar" class="w-64 bg-white h-screen shadow-lg sidebar p-6 hidden md:flex flex-col transition-transform duration-300 transform -translate-x-full md:translate-x-0">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard</h1>
        <nav class="space-y-4">
            <button class="tab-btn flex items-center text-gray-600 hover:text-blue-500 transition" data-tab="home">
                Home
            </button>
            <button class="tab-btn flex items-center text-gray-600 hover:text-blue-500 transition" data-tab="recent-activities">
                Recent Activities
            </button>
            <button class="tab-btn flex items-center text-gray-600 hover:text-blue-500 transition" data-tab="upcoming-events">
                Upcoming Events
            </button>
            <button class="tab-btn flex items-center text-gray-600 hover:text-blue-500 transition" data-tab="settings">
                Settings
            </button>
        </nav>
    </div>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col w-full">

        <!-- Navbar -->
        <nav class="bg-blue-600 p-4 text-white shadow-md">
            <div class="flex items-center justify-between">
                <button id="hamburger" class="block md:hidden">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <span class="text-2xl font-bold">MyDashboard</span>

                <!-- Profile Dropdown -->
                <div class="relative group">
                    <button class="flex items-center space-x-2">
                        <img src="https://via.placeholder.com/40" alt="Profile" class="w-10 h-10 rounded-full border-2 border-white">
                        <span class="hidden md:inline">
                            <?php
                            // Check if user_name is set before accessing it
                            if (isset($_SESSION['user_name'])) {
                                echo htmlspecialchars($_SESSION['user_name']);
                            } else {
                                echo "Guest";
                            }
                            ?>
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <!-- Dropdown Content -->
                    <div class="absolute right-0 mt-2 w-48 bg-white text-gray-800 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="profile.php" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                        <a href="php/logout.php" class="block px-4 py-2 hover:bg-gray-100">Logout</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Content Area -->
        <div class="p-6 bg-gray-100 md:p-10 flex-1">
            <!-- Tab Content -->
            <div class="tab-content hidden" id="home">
                <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                    <h2 class="text-2xl font-bold mb-4">Welcome, <?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Guest'; ?>!</h2>
                    <p class="text-gray-700">This is your dashboard where you can manage your profile, settings, and explore various features.</p>
                </div>
            </div>
            <!-- More tabs can be added similarly -->
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Toggle Sidebar
        document.getElementById('hamburger').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });

        // Tab Functionality
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const target = button.getAttribute('data-tab');

                // Hide all content
                tabContents.forEach(content => content.classList.add('hidden'));

                // Show target content
                document.getElementById(target).classList.remove('hidden');

                // Store active tab in localStorage
                localStorage.setItem('activeTab', target);
            });
        });

        // Check if a tab is already active on page load
        document.addEventListener('DOMContentLoaded', () => {
            const activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                document.getElementById(activeTab).classList.remove('hidden');
            } else {
                document.getElementById('home').classList.remove('hidden'); // Default tab
            }
        });
    </script>

</body>

</html>