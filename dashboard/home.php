<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "dashboard.php";
?>

<!-- Page Content -->
<div class="p-6 md:p-10">
    <h1 class='text-2xl font-bold'>Welcome, <?php echo $username; ?>!</h1>
    <strong class="text-indigo-400">
        <?php echo ($user_role == '1') ? 'Administrator' : 'Standard User'; ?>
    </strong>.
    <div>
        <?php if ($user_role === '1') : ?>
            <p class="mt-4">You have full access to manage activities, events, and settings.</p>
        <?php elseif ($user_role === '2') : ?>
            <p class="mt-4">You have access to basic settings and home functionalities.</p>
        <?php endif; ?>
    </div>
</div>