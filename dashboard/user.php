<?php
include "dashboard.php";
include_once "../php/connection.php"; // Include your database connection

// Fetch all users
$query = "SELECT * FROM users";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<!-- Modal for Create New User -->
 
<div id="createUserModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Create New User</h2>
        <form id="createUserForm" action="../php/adduser.php" method="POST">
            <input type="text" name="username" placeholder="Username" class="w-full p-3 mb-4 border border-gray-300 rounded" required>
            <input type="text" name="full_name" placeholder="Full Name" class="w-full p-3 mb-4 border border-gray-300 rounded" required>
            <input type="email" name="email" placeholder="Email" class="w-full p-3 mb-4 border border-gray-300 rounded" required>
            <input type="text" name="phone" placeholder="Phone" class="w-full p-3 mb-4 border border-gray-300 rounded" required>
            <input type="password" name="password" placeholder="Password" class="w-full p-3 mb-4 border border-gray-300 rounded" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" class="w-full p-3 mb-4 border border-gray-300 rounded" required>
            <select name="role" class="w-full p-3 mb-4 border border-gray-300 rounded">
                <option value="1">Admin</option>
                <option value="2">User</option>
            </select>
            <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded hover:bg-blue-600">Create User</button>
        </form>
        <button onclick="closeCreateUserModal()" class="mt-4 text-red-500">Cancel</button>
    </div>
</div>

<!-- Main Content -->
<div class="bg-gray-[#f3f4f6] shadow-lg rounded-lg w-[80%] max-w-7xl p-6 sm:p-10 ms-auto me-1.5 mt-8 bg-white">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">List of Users</h1>
    <button onclick="openCreateUserModal()" class="bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600 mb-4 inline-block">Create New User</button>
    
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-lg">
            <thead class="bg-blue-500 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium">ID</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Username</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Full Name</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Phone</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Role</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $result->fetch_assoc()) { ?>
                    <tr class="border-b hover:bg-gray-50 <?php echo ($user['id'] % 2 == 0) ? 'bg-gray-100' : 'bg-white'; ?>">
                        <td class="px-6 py-3"><?php echo $user['id']; ?></td>
                        <td class="px-6 py-3"><?php echo $user['username']; ?></td>
                        <td class="px-6 py-3"><?php echo $user['full_name']; ?></td>
                        <td class="px-6 py-3"><?php echo $user['email']; ?></td>
                        <td class="px-6 py-3"><?php echo $user['phone']; ?></td>
                        <td class="px-6 py-3"><?php echo $user['role'] == 1 ? 'Admin' : 'User'; ?></td>
                        <td class="px-6 py-3 flex space-x-4">
                            <button onclick="openEditUserModal(<?php echo $user['id']; ?>, '<?php echo $user['username']; ?>', '<?php echo $user['full_name']; ?>', '<?php echo $user['email']; ?>', '<?php echo $user['phone']; ?>', <?php echo $user['role']; ?>)" class="text-indigo-600 hover:text-indigo-800">
                                Edit
                </button>
                            <button onclick="openDeleteUserModal(<?php echo $user['id']; ?>)" class="text-red-600 hover:text-red-800">
                                Delete
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Open and close the Create New User modal
    function openCreateUserModal() {
        document.getElementById('createUserModal').classList.remove('hidden');
    }

    function closeCreateUserModal() {
        document.getElementById('createUserModal').classList.add('hidden');
    }
</script>

</body>
</html>
