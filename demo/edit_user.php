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

$error = null;
$message = null;

// Handle update in demo
if (isset($_POST['update'])) {
    // Check if password change was attempted
    if (!empty($_POST['password'])) {
        $error = "Demo Version Notice: Changing passwords is not permitted in the demo version.";
    } else {
        $fullname = trim($_POST['fullname']);
        $role_id = intval($_POST['role']);
        $status = $_POST['status'];

        // In demo, we allow updating display name, role, and status without modifying the password
        $stmt = $conn->prepare("UPDATE users SET full_name = ?, role_id = ?, status = ? WHERE user_id = ?");
        $stmt->bind_param("sssi", $fullname, $role_id, $status, $user_id);
        $stmt->execute();
        $stmt->close();

        // Refresh user info
        $user['full_name'] = $fullname;
        $user['role_id'] = $role_id;
        $user['status'] = $status;
        $message = "User details updated successfully (password preserved).";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit User | Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f9f9f9; }
        .container { max-width: 650px; margin-top: 40px; }
    </style>
</head>
<body>
<?php include_once __DIR__ . '/header.php'; ?>

<div class="container">
    <div class="card p-4 shadow-sm border-0">
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
            <h4 class="mb-0 fw-bold"><i class="fas fa-user-edit text-primary me-2"></i>Edit User</h4>
            <span class="badge bg-warning text-dark"><i class="fas fa-lock me-1"></i> Password Protected</span>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger py-2 small"><i class="fas fa-ban me-1"></i> <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($message): ?>
            <div class="alert alert-success py-2 small"><i class="fas fa-check-circle me-1"></i> <?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label fw-semibold">Username</label>
                <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" class="form-control bg-light" readonly disabled>
                <small class="text-muted">Username cannot be altered.</small>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-danger">
                    <i class="fas fa-lock me-1"></i> Password (Disabled in Demo Version)
                </label>
                <input type="password" name="password" class="form-control bg-light text-muted" placeholder="••••••••••••" disabled readonly>
                <div class="form-text text-danger small">
                    <i class="fas fa-info-circle me-1"></i> Password modification is disabled in the demo version to protect evaluation access.
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Full Name</label>
                <input type="text" name="fullname" value="<?= htmlspecialchars($user['full_name']) ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Role</label>
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
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select" required>
                    <option value="active" <?= $user['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= $user['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>

            <div class="d-flex justify-content-between pt-2">
                <a href="users.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back to Users</a>
                <button type="submit" name="update" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update User</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
