<?php
session_start();
require_once 'db.php';

// Fetch roles for the dropdown
$roles = mysqli_query($conn, "SELECT * FROM roles ORDER BY role_name");

// Handle insert
if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT); // secure hash
    $fullname = trim($_POST['fullname']);
    $role = intval($_POST['role']);

    $stmt = $conn->prepare("INSERT INTO users (username, password_hash, full_name, role_id, status) 
                            VALUES (?, ?, ?, ?, 'active')");
    $stmt->bind_param("sssi", $username, $password, $fullname, $role);
    $stmt->execute();
    $stmt->close();

    header("Location: users.php");
    exit;
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: users.php");
    exit;
}

// Fetch all users with role names
$users = mysqli_query($conn, "
    SELECT u.user_id, u.username, u.full_name, u.status, r.role_name 
    FROM users u 
    JOIN roles r ON u.role_id = r.role_id
    ORDER BY u.user_id DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f7f9fc; }
        .container { max-width: 900px; margin-top: 40px; }
        .table th, .table td { vertical-align: middle; }
    </style>
</head>
<body>
<?php include_once __DIR__ . '/header.php'; ?>

<div class="container">
    <h2 class="mb-4 text-center">User Management</h2>

    <form method="post" class="card p-4 shadow-sm mb-4">
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="col">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="fullname" class="form-control" placeholder="Full Name" required>
            </div>
            <div class="col">
                <select name="role" class="form-select" required>
                    <option value="">Select Role</option>
                    <?php while ($r = mysqli_fetch_assoc($roles)) { ?>
                        <option value="<?= $r['role_id'] ?>"><?= htmlspecialchars($r['role_name']) ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <button type="submit" name="submit" class="btn btn-primary w-100">Add User</button>
    </form>

    <table class="table table-bordered table-hover bg-white shadow-sm">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php $i = 1; while ($user = mysqli_fetch_assoc($users)) { ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['full_name']) ?></td>
                <td><?= htmlspecialchars($user['role_name']) ?></td>
                <td><?= htmlspecialchars($user['status']) ?></td>
                <td>
                    <a href="edit_user.php?id=<?= $user['user_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="users.php?delete=<?= $user['user_id'] ?>" onclick="return confirm('Delete this user?')" class="btn btn-sm btn-danger">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
