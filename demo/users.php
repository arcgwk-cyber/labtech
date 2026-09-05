<?php
session_start();
require_once 'db.php';

// Fetch roles for the dropdown
$roles = mysqli_query($conn, "SELECT * FROM roles ORDER BY role_name");

$demo_notice = "";

// Handle insert - BLOCKED in demo
if (isset($_POST['submit'])) {
    $demo_notice = "Demo Version Notice: Creating new user accounts is disabled in this demo environment.";
}

// Handle delete - BLOCKED in demo
if (isset($_GET['delete'])) {
    $demo_notice = "Demo Version Notice: User deletion is disabled in this demo environment.";
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
    <title>User Management | Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f7f9fc; }
        .container { max-width: 900px; margin-top: 30px; }
        .table th, .table td { vertical-align: middle; }
    </style>
</head>
<body>
<?php include_once __DIR__ . '/header.php'; ?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold"><i class="fas fa-users-cog text-primary me-2"></i>User Management</h3>
        <span class="badge bg-warning text-dark px-3 py-2"><i class="fas fa-lock me-1"></i> Demo Protected</span>
    </div>

    <?php if (!empty($demo_notice)): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i><?= htmlspecialchars($demo_notice) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Demo Version Notice Banner -->
    <div class="alert alert-info border-0 shadow-sm d-flex align-items-center mb-4">
        <i class="fas fa-shield-alt text-info fs-3 me-3"></i>
        <div>
            <strong>Demo Protection Active:</strong>
            <div class="small text-muted">Creating new users, deleting users, and changing passwords are disabled in this demo version to preserve testing access for all evaluators.</div>
        </div>
    </div>

    <!-- Disabled Add User Form in Demo -->
    <form class="card p-4 shadow-sm mb-4 border-0">
        <h6 class="fw-bold text-muted text-uppercase small mb-3"><i class="fas fa-user-plus me-1"></i> Add New User (Disabled in Demo)</h6>
        <div class="row mb-3">
            <div class="col">
                <input type="text" class="form-control bg-light" placeholder="Username (Disabled in Demo)" disabled readonly>
            </div>
            <div class="col">
                <input type="password" class="form-control bg-light" placeholder="Password (Disabled in Demo)" disabled readonly>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <input type="text" class="form-control bg-light" placeholder="Full Name (Disabled in Demo)" disabled readonly>
            </div>
            <div class="col">
                <select class="form-select bg-light" disabled>
                    <option value="">Select Role (Disabled in Demo)</option>
                </select>
            </div>
        </div>
        <button type="button" class="btn btn-secondary w-100" disabled>
            <i class="fas fa-ban me-1"></i> Add User (Disabled in Demo Version)
        </button>
    </form>

    <div class="card shadow-sm border-0 p-3">
        <h6 class="fw-bold text-dark mb-3"><i class="fas fa-list me-1"></i> Active Demo Users</h6>
        <table class="table table-bordered table-hover bg-white mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php $i = 1; while ($user = mysqli_fetch_assoc($users)) { ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><strong><?= htmlspecialchars($user['username']) ?></strong></td>
                    <td><?= htmlspecialchars($user['full_name']) ?></td>
                    <td><span class="badge bg-primary bg-opacity-10 text-primary"><?= htmlspecialchars($user['role_name']) ?></span></td>
                    <td><span class="badge bg-success"><?= htmlspecialchars($user['status']) ?></span></td>
                    <td class="text-center">
                        <a href="edit_user.php?id=<?= $user['user_id'] ?>" class="btn btn-sm btn-outline-primary" title="View details">
                            <i class="fas fa-eye me-1"></i> View / Edit
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-secondary" disabled title="Deletion disabled in demo version">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
