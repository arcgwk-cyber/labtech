<?php
require_once 'db.php';

$email = trim($_POST['email'] ?? '');
$new_pass = trim($_POST['new_password'] ?? '');
$confirm_pass = trim($_POST['confirm_password'] ?? '');

$error = null;
$success = false;

if (empty($email) || empty($new_pass) || empty($confirm_pass)) {
    $error = "All fields are required.";
} elseif ($new_pass !== $confirm_pass) {
    $error = "Passwords do not match.";
} elseif (strlen($new_pass) < 6) {
    $error = "Password must be at least 6 characters long.";
} else {
    if ($conn) {
        // Try searching user by username or email
        $stmt = $conn->prepare("SELECT user_id, username FROM users WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();

        $error = "Demo Version Notice: Password modification is disabled in this demo environment to preserve testing access.";
    } else {
        $error = "Database connection unavailable.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password Status</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background: #f8fafc;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      font-family: 'Segoe UI', system-ui, sans-serif;
    }
    .card-box {
      max-width: 480px;
      width: 100%;
      background: #fff;
      border-radius: 12px;
      border: 1px solid #e2e8f0;
      box-shadow: 0 4px 15px rgba(0,0,0,0.05);
      padding: 30px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="card-box">
    <?php if ($success): ?>
      <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
      <h4 class="fw-bold">Password Reset Successful!</h4>
      <p class="text-muted">Your password has been updated. You can now log in with your new credentials.</p>
      <a href="login.php" class="btn btn-primary w-100 mt-2">Proceed to Login</a>
    <?php else: ?>
      <i class="fas fa-exclamation-circle fa-4x text-danger mb-3"></i>
      <h4 class="fw-bold">Reset Failed</h4>
      <p class="text-danger"><?= htmlspecialchars($error) ?></p>
      <a href="reset_password.php" class="btn btn-secondary w-100 mt-2">Try Again</a>
    <?php endif; ?>
  </div>
</body>
</html>
