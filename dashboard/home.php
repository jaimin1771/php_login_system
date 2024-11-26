<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    // Redirect to login page if user is not logged in
    header("Location: /login.php");
    exit();
}

include_once "../php/connection.php"; // Ensure the path is correct
include_once "dashboard.php";

// Get the username from the session or set a default
$username = htmlspecialchars($_SESSION['username'] ?? 'Guest');
?>

<!-- Main Content -->
<div class="bg-gray-[#f3f4f6] shadow-lg rounded-lg w-[79%] p-6 sm:p-10 ml-auto m-4 bg-white">
    <h1 class="text-2xl font-bold">Welcome, <?php echo $username; ?>!</h1>
    <p class="mt-4">Use the sidebar to navigate through the dashboard.</p>
    </main>