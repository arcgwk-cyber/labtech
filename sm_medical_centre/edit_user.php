<?php
require_once 'db.php';

// Get user ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: users.php");
    exit;
}

$user_id = intval($_GET['id']);

// Fetch user details
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) {
    echo "User not found.";
    exit;
}

// Fetch all roles
$roles = mysqli_query($conn, "SELECT * FROM roles ORDER BY role_name");

// Handle update
if (isset($_POST['update'])) {
    $username = trim($_POST['username']);
    $fullname = trim($_POST['fullname']);
    $role_id = intval($_POST['role']);
    $status = $_POST['status'];

    // If password field is filled, hash and update it
    if (!empty($_POST['password'])) {
        $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET username = ?, password_hash = ?, full_name = ?, role_id = ?, status = ? WHERE user_id = ?");
        $stmt->bind_param("sssssi", $username, $password, $fullname, $role_id, $status, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET username = ?, full_name = ?, role_id = ?, status = ? WHERE user_id = ?");
        $stmt->bind_param("ssssi", $username, $fullname, $role_id, $status, $user_id);
    }

    $stmt->execute();
    $stmt->close();

    header("Location: users.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f9f9f9; }
        .container { max-width: 700px; margin-top: 50px; }
    </style>
</head>
<body>
<?php include_once __DIR__ . '/header.php'; ?>

<div class="container">
    <h3 class="mb-4 text-center">Edit User</h3>
    <form method="post" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>New Password (leave blank to keep current)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label>Full Name</label>
            <input type="text" name="fullname" value="<?= htmlspecialchars($user['full_name']) ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-select" required>
                <option value="">Select Role</option>
                <?php while ($r = mysqli_fetch_assoc($roles)) { ?>
                    <option value="<?= $r['role_id'] ?>" <?= $r['role_id'] == $user['role_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($r['role_name']) ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select" required>
                <option value="active" <?= $user['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= $user['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>
        <div class="d-flex justify-content-between">
            <a href="users.php" class="btn btn-secondary">Cancel</a>
            <button type="submit" name="update" class="btn btn-primary">Update User</button>
        </div>
    </form>
</div>
</body>
</html>
