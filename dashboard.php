<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar with Navbar and Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal text-gray-800 flex">
    <!-- Sidebar -->
    <div class="w-64 bg-white h-screen shadow-lg">
        <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard</h1>
            <nav class="space-y-4">
                <a href="#" class="flex items-center text-gray-600 hover:text-blue-500 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6a4 4 0 11-8 0V5m0 0L5 12m0 0h14" />
                    </svg>
                    Home
                </a>
                <a href="#" class="flex items-center text-gray-600 hover:text-blue-500 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 14c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 20c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 2 2 2 2z" />
                    </svg>
                    Settings
                </a>
                <a href="#" class="flex items-center text-gray-600 hover:text-blue-500 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.657 0 3 1.343 3 3v2m-3 4v-4m-3-4h6m4 0a2 2 0 012 2v6a2 2 0 01-2 2h-8a2 2 0 01-2-2v-6a2 2 0 012-2z" />
                    </svg>
                    User
                </a>
                <a href="#" class="flex items-center text-gray-600 hover:text-blue-500 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20H9m0 0V4m0 16h3m4-16h-3m0 16h3m4-16h-3m0 16h3M5 20V4h14v16H5z" />
                    </svg>
                    Books
                </a>
            </nav>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col">
        <!-- Navbar -->
        <nav class="bg-white shadow p-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">My Dashboard</h1>
            <!-- Profile Section -->
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 font-semibold">Username</span>
                <img src="https://via.placeholder.com/40" alt="Profile" class="h-10 w-10 rounded-full">
            </div>
        </nav>
        <!-- Content Area -->
        <div class="p-6">
            <h2 class="text-2xl font-bold mb-4">Welcome to your Dashboard</h2>
            <!-- Your content goes here -->
        </div>
    </div>
</body>

</html>