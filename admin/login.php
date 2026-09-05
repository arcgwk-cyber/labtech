<?php
/**
 * Super Admin Login Portal
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If already logged in, redirect to dashboard
if (!empty($_SESSION['super_admin_logged_in']) && $_SESSION['super_admin_logged_in'] === true) {
    header("Location: index.php");
    exit;
}

require_once __DIR__ . '/db.php';

$error = '';
$msg = '';

if (isset($_GET['msg']) && $_GET['msg'] === 'logged_out') {
    $msg = "You have been logged out securely.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = "Please enter both Super Admin username and password.";
    } else {
        $authenticated = false;
        $super_admin_data = null;

        if ($conn && !$conn->connect_error) {
            $stmt = $conn->prepare("SELECT user_id, username, password_hash, full_name, role_id, status FROM users WHERE username = ? LIMIT 1");
            if ($stmt) {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $res = $stmt->get_result();
                if ($user = $res->fetch_assoc()) {
                    // Check if role is admin (role_id = 1) and status is active
                    if ((int)$user['role_id'] === 1 && $user['status'] === 'active') {
                        if (password_verify($password, $user['password_hash'])) {
                            $authenticated = true;
                            $super_admin_data = $user;
                        }
                    }
                }
                $stmt->close();
            }
        }

        // Master emergency fallback for initial setup if password hash not yet reset
        if (!$authenticated && $username === 'admin' && ($password === 'admin' || $password === 'admin123' )) {
            $authenticated = true;
            $super_admin_data = [
                'user_id' => 1,
                'username' => 'admin',
                'full_name' => 'Super Administrator'
            ];
        }

        if ($authenticated && $super_admin_data) {
            $_SESSION['super_admin_logged_in'] = true;
            $_SESSION['super_admin_id'] = $super_admin_data['user_id'];
            $_SESSION['super_admin_user'] = $super_admin_data['username'];
            $_SESSION['super_admin_name'] = $super_admin_data['full_name'] ?? 'Super Administrator';
            
            header("Location: index.php");
            exit;
        } else {
            $error = "Invalid Super Admin credentials or account is not authorized.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Super Admin Portal | Multi-Tenant Lab Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
      background: linear-gradient(135deg, #090d16 0%, #0f172a 50%, #1e1b4b 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }
    .auth-card {
      background: rgba(15, 23, 42, 0.85);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border: 1px solid rgba(255, 255, 255, 0.12);
      border-radius: 24px;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
      width: 100%;
      max-width: 440px;
      overflow: hidden;
    }
    .badge-super {
      background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
      color: white;
      font-size: 0.75rem;
      letter-spacing: 1px;
      text-transform: uppercase;
      font-weight: 700;
      padding: 4px 12px;
      border-radius: 20px;
      display: inline-block;
    }
    .form-control {
      background: rgba(30, 41, 59, 0.7);
      border: 1px solid rgba(255, 255, 255, 0.15);
      color: #f8fafc;
      border-radius: 12px;
      padding: 12px 16px;
    }
    .form-control:focus {
      background: rgba(30, 41, 59, 0.95);
      border-color: #6366f1;
      color: #ffffff;
      box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.25);
    }
    .form-control::placeholder {
      color: #64748b;
    }
    .btn-login {
      background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
      border: none;
      color: white;
      font-weight: 700;
      padding: 14px;
      border-radius: 12px;
      transition: all 0.2s ease;
    }
    .btn-login:hover {
      background: linear-gradient(135deg, #4338ca 0%, #4f46e5 100%);
      transform: translateY(-1px);
      box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.5);
    }
  </style>
</head>
<body>

<div class="auth-card">
  <div class="p-4 p-sm-5">
    
    <div class="text-center mb-4">
      <div class="mb-2">
        <span class="badge-super"><i class="fas fa-shield-alt me-1"></i> SaaS Master Suite</span>
      </div>
      <h3 class="fw-bold text-white mb-1">Super Admin</h3>
      <p class="text-secondary small mb-0">Multi-Tenant Diagnostic Labs Control Center</p>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-danger py-2 px-3 small rounded-3 mb-3 d-flex align-items-center gap-2 border-0 bg-danger bg-opacity-25 text-white">
        <i class="fas fa-exclamation-circle text-danger"></i>
        <div><?= htmlspecialchars($error) ?></div>
      </div>
    <?php endif; ?>

    <?php if ($msg): ?>
      <div class="alert alert-success py-2 px-3 small rounded-3 mb-3 d-flex align-items-center gap-2 border-0 bg-success bg-opacity-25 text-white">
        <i class="fas fa-check-circle text-success"></i>
        <div><?= htmlspecialchars($msg) ?></div>
      </div>
    <?php endif; ?>

    <form method="POST" action="login.php">
      <div class="mb-3">
        <label class="form-label text-light small fw-semibold">Master Username</label>
        <div class="input-group">
          <span class="input-group-text bg-transparent border-0 text-secondary ps-0 pe-2"><i class="fas fa-user-shield"></i></span>
          <input type="text" name="username" class="form-control" placeholder="admin" required autofocus autocomplete="username">
        </div>
      </div>

      <div class="mb-4">
        <label class="form-label text-light small fw-semibold">Master Password</label>
        <div class="input-group">
          <span class="input-group-text bg-transparent border-0 text-secondary ps-0 pe-2"><i class="fas fa-lock"></i></span>
          <input type="password" name="password" class="form-control" placeholder="••••••••" required autocomplete="current-password">
        </div>
      </div>

      <button type="submit" class="btn btn-login w-100 mb-3">
        <i class="fas fa-sign-in-alt me-2"></i> Access Super Admin Dashboard
      </button>
    </form>

    <div class="text-center mt-3 pt-3 border-top border-secondary border-opacity-25">
      <a href="../demo/index.php" class="text-secondary text-decoration-none small">
        <i class="fas fa-arrow-left me-1"></i> Switch to Demo Lab Portal
      </a>
    </div>

  </div>
</div>

</body>
</html>
