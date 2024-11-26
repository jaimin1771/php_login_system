<?php
// Start session only if it hasn't been started already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Assign username or default to "Guest"
htmlspecialchars($_SESSION['username']);
// Assign user role or default to "2" (Standard User role)
$user_role = isset($_SESSION['role']) ? $_SESSION['role'] : '2';

// Ensure user role is properly set
if (!in_array($user_role, ['1', '2'])) {
    $user_role = '2'; // Default to user role if the role is invalid
}
// Get the first letter of the username
$firstLetter = strtoupper(substr($username, 0, 1));

// Define menu items for roles
$menu_items = [
    '1' => [ // Admin menu
        'Home' => 'home.php',
        'Recent Activities' => 'recent-activities.php',
        'Upcoming Events' => 'upcoming-events.php',
        'Settings' => 'settings.php',
        'Contact' => 'contact.php',
    ],
    '2' => [ // User menu
        'Home' => 'home.php',
        'Settings' => 'settings.php',
    ],
];

// Get the menu for the current role
$role_menu = $menu_items[$user_role];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 font-sans leading-normal tracking-normal text-gray-300 h-screen flex">

    <!-- Sidebar -->
    <div id="sidebar" class="w-64 bg-gradient-to-b from-indigo-800 via-indigo-700 to-indigo-600 h-screen shadow-lg p-6 flex flex-col justify-between fixed ">
        <!-- Sidebar Header -->
        <div>
            <h1 class="text-3xl font-semibold text-white mb-8">
                Dashboard
            </h1>
            <!-- Navigation Links -->
            <nav class="space-y-4">
                <?php foreach ($role_menu as $label => $link) : ?>
                    <a href="<?php echo $link; ?>" class="block text-gray-300 hover:text-white hover:bg-indigo-800 rounded-lg px-4 py-2">
                        <?php echo $label; ?>
                    </a>
                <?php endforeach; ?>
            </nav>
        </div>

        <!-- Profile Section -->
        <div class="relative group mt-8">
            <div class="flex items-center space-x-2 cursor-pointer">
                <div class="w-10 h-10 rounded-full flex items-center justify-center bg-pink-600 text-white font-bold">
                    <?php echo $firstLetter; ?>
                </div>
                <span class="text-white font-semibold">
                    <?php echo $username; ?>
                </span>
            </div>
            <!-- Hover Dropdown -->
            <div class="absolute bottom-0 left-0 mb-14 w-full bg-white rounded-lg shadow-lg text-gray-800 opacity-0 group-hover:opacity-100 group-hover:translate-y-0 transform transition-all duration-200 ease-in-out">
                <a href="profile.php" class="block px-4 py-2 hover:bg-gray-200">Profile</a>
                <form method="POST" action="logout.php">
                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-200">Logout</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>