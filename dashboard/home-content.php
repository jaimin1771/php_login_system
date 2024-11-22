<div class="bg-gray-800 shadow-lg rounded-lg p-6">
    <h2 class="text-2xl font-semibold mb-4 text-white">Welcome, <?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Guest'; ?>!</h2>
    <p class="text-gray-400">This is your dashboard home page content.</p>
</div>