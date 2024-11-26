<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection file
include_once "../php/connection.php"; // Ensure only one inclusion

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

// Get the user ID from session
$userId = $_SESSION['id'];

// Check if the connection is active
if (!$conn->ping()) {
    die("Database connection is not alive.");
}

// Fetch user data from the database
$query = "SELECT id, username, full_name, email, phone, profile_picture, role FROM users WHERE id = ?";
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        $username = htmlspecialchars($user['username']); // Sanitize user data
        $fullName = htmlspecialchars($user['full_name']);
        $email = htmlspecialchars($user['email']);
        $phone = htmlspecialchars($user['phone']);
        $profilePicture = !empty($user['profile_picture']) ? $user['profile_picture'] : ''; // Profile picture path or empty if not set
        $role = htmlspecialchars($user['role']) ?? 'User'; // Sanitize and set default role if not found
        $_SESSION['role'] = $role; // Store role in session
    } else {
        header("Location: login.php");
        exit;
    }

    $stmt->close();
} else {
    die("Failed to prepare the query: " . $conn->error);
}

// Logout functionality
if (isset($_POST['logout'])) {
    // Destroy session and redirect to login page
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

// Get the current page name
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            min-height: 100vh;
        }
    </style>
</head>

<body class="font-sans leading-normal tracking-normal bg-[#eaf2f3] text-gray-800">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-r from-indigo-600 to-purple-700 text-white flex flex-col justify-between shadow-lg fixed h-full">
            <!-- Sidebar Top Section -->
            <div class="p-6 text-center text-xl font-semibold border-b border-gray-500">My Dashboard</div>
            <nav class="mt-6 space-y-2 flex flex-col justify-between">
                <div>
                    <a href="home.php" class="block px-4 py-2 <?php echo ($current_page == 'home.php') ? 'bg-indigo-500' : 'hover:bg-indigo-500'; ?> rounded-lg transition">Home</a>
                    <a href="settings.php" class="block px-4 py-2 <?php echo ($current_page == 'settings.php') ? 'bg-indigo-500' : 'hover:bg-indigo-500'; ?> rounded-lg transition">Settings</a>
                    <a href="events.php" class="block px-4 py-2 <?php echo ($current_page == 'events.php') ? 'bg-indigo-500' : 'hover:bg-indigo-500'; ?> rounded-lg transition">Events</a>
                    <a href="user.php" class="block px-4 py-2 <?php echo ($current_page == 'user.php') ? 'bg-indigo-500' : 'hover:bg-indigo-500'; ?> rounded-lg transition">User</a>
                </div>
            </nav>
            <div class="mt-auto w-[70%] mx-auto mb-3 text-center flex justify-center">
                <a href="logout.php" class="flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-all duration-200 ease-in-out text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H3m9 9l-9-9 9-9" />
                    </svg>
                    Logout
                </a>
            </div>

            <!-- Sidebar Bottom Section -->
            <a href="profile.php" class="text-xs text-gray-300 hover:text-white">
                <div class="border-t border-gray-500 px-3 py-1 flex items-center gap-4">

                    <?php if (!empty($profilePicture)) : ?>
                        <img src="../uploads/<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture"
                            class="w-14 h-14 rounded-full border-2 border-indigo-300 shadow-lg">
                    <?php else : ?>
                        <div class="w-16 h-16 rounded-full bg-gray-800 text-white flex items-center justify-center text-xl font-semibold border-2 border-indigo-300 shadow-lg">
                            <span><?php echo strtoupper(substr($username, 0, 1)); ?></span>
                        </div>
                    <?php endif; ?>
                    <div>
                        <p class="text-sm font-medium"><?php echo $username; ?></p>
                    </div>

                </div>

            </a>

        </aside>
    </div>
</body>

</html>