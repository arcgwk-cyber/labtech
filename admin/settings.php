<?php
/**
 * Super Admin Settings & Security
 */
$page_title = "Settings & Security";
require_once __DIR__ . '/header.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'change_password') {
    $current_pass = trim($_POST['current_password'] ?? '');
    $new_pass     = trim($_POST['new_password'] ?? '');
    $confirm_pass = trim($_POST['confirm_password'] ?? '');

    if (empty($new_pass) || strlen($new_pass) < 6) {
        $error = "New password must be at least 6 characters long.";
    } elseif ($new_pass !== $confirm_pass) {
        $error = "New password and confirmation do not match.";
    } else {
        $admin_id = (int)($_SESSION['super_admin_id'] ?? 1);
        $new_hash = password_hash($new_pass, PASSWORD_BCRYPT);
        
        $stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE user_id = ? AND role_id = 1");
        $stmt->bind_param("si", $new_hash, $admin_id);
        if ($stmt->execute()) {
            $message = "Super Admin password updated successfully! Use your new password for next login.";
        } else {
            $error = "Failed to update password: " . $conn->error;
        }
        $stmt->close();
    }
}
?>

<div class="container py-4" style="max-width: 800px;">

  <div class="mb-4">
    <h3 class="fw-bold mb-1 text-dark">Super Admin Settings & Security</h3>
    <p class="text-muted small mb-0">Manage master administrator authentication and view cloud server environment health.</p>
  </div>

  <?php if ($message): ?>
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
      <i class="fas fa-check-circle fa-lg"></i>
      <div><?= htmlspecialchars($message) ?></div>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
      <i class="fas fa-exclamation-circle fa-lg"></i>
      <div><?= htmlspecialchars($error) ?></div>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <!-- Security Card -->
  <div class="card-sa p-4 mb-4">
    <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">
      <i class="fas fa-lock text-primary me-2"></i> Update Super Admin Password
    </h5>
    
    <form method="POST" action="settings.php">
      <input type="hidden" name="action" value="change_password">
      
      <div class="row g-3 mb-3">
        <div class="col-sm-6">
          <label class="form-label small fw-semibold text-muted">New Master Password</label>
          <input type="password" name="new_password" class="form-control" placeholder="••••••••" required minlength="6">
        </div>
        <div class="col-sm-6">
          <label class="form-label small fw-semibold text-muted">Confirm New Password</label>
          <input type="password" name="confirm_password" class="form-control" placeholder="••••••••" required minlength="6">
        </div>
      </div>

      <div class="text-end">
        <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 fw-bold">
          <i class="fas fa-key me-1"></i> Update Master Password
        </button>
      </div>
    </form>
  </div>

  <!-- System Health Card -->
  <div class="card-sa p-4">
    <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">
      <i class="fas fa-server text-info me-2"></i> Platform Infrastructure & Architecture
    </h5>

    <div class="row g-3">
      <div class="col-sm-6">
        <div class="p-3 bg-light rounded-3 border">
          <span class="text-muted small d-block">Super Admin User</span>
          <span class="fw-bold text-dark"><?= htmlspecialchars($_SESSION['super_admin_user'] ?? 'admin') ?></span>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="p-3 bg-light rounded-3 border">
          <span class="text-muted small d-block">PHP Version</span>
          <span class="fw-bold text-dark"><?= PHP_VERSION ?></span>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="p-3 bg-light rounded-3 border">
          <span class="text-muted small d-block">Master Database</span>
          <span class="fw-bold text-dark font-monospace"><?= htmlspecialchars($dbname ?? '') ?></span>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="p-3 bg-light rounded-3 border">
          <span class="text-muted small d-block">Operating System</span>
          <span class="fw-bold text-dark"><?= PHP_OS ?></span>
        </div>
      </div>
    </div>
  </div>

</div>

<?php require_once __DIR__ . '/footer.php'; ?>
