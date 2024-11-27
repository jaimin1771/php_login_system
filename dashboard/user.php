<?php
include "dashboard.php";

// Initialize error messages
$errors = [];

// Check if a form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $full_name = trim($_POST['full_name']);
    $username = strtolower(trim($_POST['username'])); // Convert to lowercase
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = intval($_POST['role']); // 1 = Admin, 2 = User

    // Validate Full Name
    if (empty($full_name)) {
        $errors['full_name'] = 'Full Name is .';
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $full_name)) {
        $errors['full_name'] = 'Full Name should not contain special characters.';
    }

    // Validate Username
    if (empty($username)) {
        $errors['username'] = 'Username is .';
    } elseif (preg_match('/\s/', $username)) {
        $errors['username'] = 'Username should not contain spaces.';
    } elseif (preg_match('/[A-Z]/', $username)) {
        $errors['username'] = 'Username should not contain capital letters.';
    } else {
        $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $errors['username'] = 'Username already exists.';
        }
    }

    // Validate Email
    if (empty($email)) {
        $errors['email'] = 'Email is .';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format.';
    } else {
        $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $errors['email'] = 'Email already exists.';
        }
    }

    // Validate Phone Number
    if (empty($phone)) {
        $errors['phone'] = 'Phone number is .';
    } elseif (!preg_match("/^[0-9]*$/", $phone)) {
        $errors['phone'] = 'Phone number should only contain numbers, no spaces or characters.';
    }

    // Validate Password
    if (empty($password)) {
        $errors['password'] = 'Password is .';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Password must be at least 6 characters long.';
    } elseif (!preg_match("/[A-Z]/", $password)) {
        $errors['password'] = 'Password must contain at least 1 uppercase letter.';
    } elseif (!preg_match("/[0-9]/", $password)) {
        $errors['password'] = 'Password must contain at least 1 number.';
    } elseif (!preg_match("/[\W_]/", $password)) {
        $errors['password'] = 'Password must contain at least 1 special character.';
    }

    // Validate Confirm Password
    if (empty($confirm_password)) {
        $errors['confirm_password'] = 'Confirm Password is .';
    } elseif ($password !== $confirm_password) {
        $errors['confirm_password'] = 'Passwords do not match.';
    }

    // If there are validation errors, do not proceed with the insert
    if (count($errors) === 0) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert into database
        $sql = "INSERT INTO users (full_name, username, email, phone, password, role) 
                VALUES ('$full_name', '$username', '$email', '$phone', '$hashed_password', '$role')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to the users page
            header("Location: user.php");
            exit; // Ensure no further code is executed
        } else {
            $errors['db'] = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

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
    <div id="createUserModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-[65%] my-[3%] mx-[26%]">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Create New User</h2>
            <form id="createUserForm" action="../php/adduser.php" method="POST">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input type="text" id="username" name="username" placeholder="Enter username" class="w-full p-3 border border-gray-300 rounded">
                    </div>
                    <!-- Full Name -->
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" id="full_name" name="full_name" placeholder="Enter full name" class="w-full p-3 border border-gray-300 rounded">
                    </div>
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter email address" class="w-full p-3 border border-gray-300 rounded">
                    </div>
                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                        <input type="text" id="phone" name="phone" placeholder="Enter phone number" class="w-full p-3 border border-gray-300 rounded">
                    </div>
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter password" class="w-full p-3 border border-gray-300 rounded">
                    </div>
                    <!-- Confirm Password -->
                    <div>
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm password" class="w-full p-3 border border-gray-300 rounded">
                    </div>
                    <!-- Role -->
                    <div class="sm:col-span-2">
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select id="role" name="role" class="w-full p-3 border border-gray-300 rounded">
                            <option value="1">Admin</option>
                            <option value="2">User</option>
                        </select>
                    </div>
                </div>
                <!-- Buttons -->
                <div class="flex justify-end gap-4 mt-6">
                    <button type="button" onclick="closeCreateUserModal()" class="bg-gray-200 text-gray-700 p-3 rounded hover:bg-gray-300">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white p-3 rounded hover:bg-blue-600">Create User</button>
                </div>
            </form>
        </div>

    </div>

    <!-- Modal for Edit User -->
    <div id="editUserModal" class="fixed inset-0 bg-gray-500 bg-opacity-50  items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-[50%] ms-auto mt-[3%] me-[16%]">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Edit User</h2>
            <form id="editUserForm" action="../php/edituser.php" method="POST">
                <input type="hidden" name="edit_user_id" id="edit_user_id">
                <input type="text" name="username" id="edit_username" placeholder="Username" class="w-full p-3 mb-4 border border-gray-300 rounded">
                <input type="text" name="full_name" id="edit_full_name" placeholder="Full Name" class="w-full p-3 mb-4 border border-gray-300 rounded">
                <input type="email" name="email" id="edit_email" placeholder="Email" class="w-full p-3 mb-4 border border-gray-300 rounded">
                <input type="text" name="phone" id="edit_phone" placeholder="Phone" class="w-full p-3 mb-4 border border-gray-300 rounded">
                <select name="role" id="edit_role" class="w-full p-3 mb-4 border border-gray-300 rounded">
                    <option value="1">Admin</option>
                    <option value="2">User</option>
                </select>
                <button type="submit" class="w-full bg-green-500 text-white p-3 rounded hover:bg-green-600">Update User</button>
            </form>
            <button onclick="closeEditUserModal()" class="mt-4 text-red-500">Cancel</button>
        </div>
    </div>

    <!-- Modal for Delete User -->
    <div id="deleteUserModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-[65%]">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Delete User</h2>
            <p class="text-gray-600 mb-6">Are you sure you want to delete this user?</p>
            <form id="deleteUserForm" action="../php/deleteuser.php" method="POST">
                <input type="hidden" name="delete_user_id" id="delete_user_id">
                <button type="submit" class="w-full bg-red-500 text-white p-3 rounded hover:bg-red-600">Yes, Delete</button>
            </form>
            <button onclick="closeDeleteUserModal()" class="mt-4 text-gray-600">Cancel</button>
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
                                <button onclick="openEditUserModal(<?php echo $user['id']; ?>, '<?php echo $user['username']; ?>', '<?php echo $user['full_name']; ?>', '<?php echo $user['email']; ?>', '<?php echo $user['phone']; ?>', <?php echo $user['role']; ?>)" class="text-indigo-600 hover:text-indigo-800">Edit</button>
                                <button onclick="openDeleteUserModal(<?php echo $user['id']; ?>)" class="text-red-600 hover:text-red-800">Delete</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Functions to toggle Create User Modal
        function openCreateUserModal() {
            document.getElementById('createUserModal').classList.remove('hidden');
        }

        function closeCreateUserModal() {
            document.getElementById('createUserModal').classList.add('hidden');
        }

        // Functions to toggle Edit User Modal
        function openEditUserModal(id, username, fullName, email, phone, role) {
            document.getElementById('edit_user_id').value = id;
            document.getElementById('edit_username').value = username;
            document.getElementById('edit_full_name').value = fullName;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_phone').value = phone;
            document.getElementById('edit_role').value = role;
            document.getElementById('editUserModal').classList.remove('hidden');
        }

        function closeEditUserModal() {
            document.getElementById('editUserModal').classList.add('hidden');
        }

        // Functions to toggle Delete User Modal
        function openDeleteUserModal(id) {
            document.getElementById('delete_user_id').value = id;
            document.getElementById('deleteUserModal').classList.remove('hidden');
        }

        function closeDeleteUserModal() {
            document.getElementById('deleteUserModal').classList.add('hidden');
        }
    </script>
</body>

</html>