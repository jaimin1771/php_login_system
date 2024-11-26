<?php
include "dashboard.php";
include_once "../php/connection.php";  // Include your database connection

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
        <form action="create.php" method="POST">
            <input type="text" name="username" placeholder="Username" class="w-full p-3 mb-4 border border-gray-300 rounded" required>
            <input type="text" name="full_name" placeholder="Full Name" class="w-full p-3 mb-4 border border-gray-300 rounded" required>
            <input type="email" name="email" placeholder="Email" class="w-full p-3 mb-4 border border-gray-300 rounded" required>
            <input type="text" name="phone" placeholder="Phone" class="w-full p-3 mb-4 border border-gray-300 rounded" required>
            <select name="role" class="w-full p-3 mb-4 border border-gray-300 rounded">
                <option value="1">Admin</option>
                <option value="0">User</option>
            </select>
            <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded hover:bg-blue-600">Create User</button>
        </form>
        <button onclick="closeCreateUserModal()" class="mt-4 text-red-500">Cancel</button>
    </div>
</div>

<!-- Modal for Edit User -->
<div id="editUserModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Edit User</h2>
        <form id="editUserForm" method="POST">
            <input type="hidden" name="id" id="editUserId">
            <input type="text" name="username" id="editUsername" placeholder="Username" class="w-full p-3 mb-4 border border-gray-300 rounded" required>
            <input type="text" name="full_name" id="editFullName" placeholder="Full Name" class="w-full p-3 mb-4 border border-gray-300 rounded" required>
            <input type="email" name="email" id="editEmail" placeholder="Email" class="w-full p-3 mb-4 border border-gray-300 rounded" required>
            <input type="text" name="phone" id="editPhone" placeholder="Phone" class="w-full p-3 mb-4 border border-gray-300 rounded" required>
            <select name="role" id="editRole" class="w-full p-3 mb-4 border border-gray-300 rounded">
                <option value="1">Admin</option>
                <option value="0">User</option>
            </select>
            <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded hover:bg-blue-600">Update User</button>
        </form>
        <button onclick="closeEditUserModal()" class="mt-4 text-red-500">Cancel</button>
    </div>
</div>

<!-- Modal for Delete User -->
<div id="deleteUserModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Are you sure you want to delete this user?</h2>
        <form id="deleteUserForm" method="POST">
            <input type="hidden" name="id" id="deleteUserId">
            <button type="submit" class="w-full bg-red-500 text-white p-3 rounded hover:bg-red-600">Delete</button>
        </form>
        <button onclick="closeDeleteUserModal()" class="mt-4 text-green-500">Cancel</button>
    </div>
</div>

<!-- Main Content -->
<div class="bg-gray-[#f3f4f6] shadow-lg rounded-lg w-[79%] p-6 sm:p-10 ml-auto m-4 bg-white">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">List of Users</h1>
    <button onclick="openCreateUserModal()" class="bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600 mb-4 inline-block">Create New User</button>
    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-lg">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">ID</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Username</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Full Name</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Email</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Phone</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Role</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = $result->fetch_assoc()) { ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-3"><?php echo $user['id']; ?></td>
                    <td class="px-6 py-3"><?php echo $user['username']; ?></td>
                    <td class="px-6 py-3"><?php echo $user['full_name']; ?></td>
                    <td class="px-6 py-3"><?php echo $user['email']; ?></td>
                    <td class="px-6 py-3"><?php echo $user['phone']; ?></td>
                    <td class="px-6 py-3"><?php echo $user['role'] == 1 ? 'Admin' : 'User'; ?></td>
                    <td class="px-6 py-3">
                        <button onclick="openEditUserModal(<?php echo $user['id']; ?>, '<?php echo $user['username']; ?>', '<?php echo $user['full_name']; ?>', '<?php echo $user['email']; ?>', '<?php echo $user['phone']; ?>', <?php echo $user['role']; ?>)" class="text-indigo-600 hover:text-indigo-800">Edit</button>
                        <span class="mx-2">|</span>
                        <button onclick="openDeleteUserModal(<?php echo $user['id']; ?>)" class="text-red-600 hover:text-red-800">Delete</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
// Open and close the Create New User modal
function openCreateUserModal() {
    document.getElementById('createUserModal').classList.remove('hidden');
}

function closeCreateUserModal() {
    document.getElementById('createUserModal').classList.add('hidden');
}

// Open and close the Edit User modal
function openEditUserModal(id, username, fullName, email, phone, role) {
    document.getElementById('editUserId').value = id;
    document.getElementById('editUsername').value = username;
    document.getElementById('editFullName').value = fullName;
    document.getElementById('editEmail').value = email;
    document.getElementById('editPhone').value = phone;
    document.getElementById('editRole').value = role;
    document.getElementById('editUserModal').classList.remove('hidden');
}

function closeEditUserModal() {
    document.getElementById('editUserModal').classList.add('hidden');
}

// Open and close the Delete User modal
function openDeleteUserModal(id) {
    document.getElementById('deleteUserId').value = id;
    document.getElementById('deleteUserModal').classList.remove('hidden');
}

function closeDeleteUserModal() {
    document.getElementById('deleteUserModal').classList.add('hidden');
}
</script>

</body>
</html>
