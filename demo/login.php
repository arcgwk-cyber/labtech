<?php
session_start();
require_once 'db.php';

// Dynamic Lab Name resolution & Multi-tenant self-healing
$currentDir = basename(__DIR__);
$isDemo = ($currentDir === 'demo' || (isset($_GET['demo']) && $_GET['demo'] === '1'));

// Fetch settings from admin_settings if table exists
$settings = [
    'company_name' => $isDemo ? 'Amma Diagnostic Centre' : 'Diagnostic Centre ERP',
    'status'       => 'active',
    'expiry_date'  => null,
    'grace_days'   => 7
];

if ($conn && !$conn->connect_error) {
    // 1. Ensure lab_slug column exists in admin_settings for strict multi-tenant isolation
    $colCheck = $conn->query("SHOW COLUMNS FROM admin_settings LIKE 'lab_slug'");
    if ($colCheck && $colCheck->num_rows === 0) {
        @$conn->query("ALTER TABLE admin_settings ADD COLUMN lab_slug VARCHAR(100) DEFAULT NULL AFTER id");
        @$conn->query("ALTER TABLE admin_settings ADD INDEX (lab_slug)");

        // Check row 1: if it's SM Medical Centre, preserve it under sm_medical_centre slug
        $r1 = $conn->query("SELECT id, company_name FROM admin_settings WHERE id = 1 LIMIT 1");
        if ($r1 && $row1 = $r1->fetch_assoc()) {
            if ($row1['company_name'] === 'Amma Diagnostic Centre') {
                @$conn->query("UPDATE admin_settings SET lab_slug = 'demo' WHERE id = 1");
            } elseif (stripos($row1['company_name'], 'SM') !== false) {
                @$conn->query("UPDATE admin_settings SET lab_slug = 'sm_medical_centre' WHERE id = 1");
            }
        }
    }

    if ($isDemo) {
        // Query specifically for demo record
        $foundDemo = false;
        $res = $conn->query("SELECT * FROM admin_settings WHERE lab_slug = 'demo' LIMIT 1");
        if ($res && $row = $res->fetch_assoc()) {
            $settings = array_merge($settings, $row);
            $foundDemo = true;
        } else {
            // Check if row 1 is Amma Diagnostic Centre
            $r1 = $conn->query("SELECT * FROM admin_settings WHERE id = 1 LIMIT 1");
            if ($r1 && $row1 = $r1->fetch_assoc()) {
                if ($row1['company_name'] === 'Amma Diagnostic Centre') {
                    $settings = array_merge($settings, $row1);
                    $foundDemo = true;
                    @$conn->query("UPDATE admin_settings SET lab_slug = 'demo' WHERE id = 1");
                }
            }
        }

        // Demo is strictly Amma Diagnostic Centre
        $settings['company_name'] = 'Amma Diagnostic Centre';
        $settings['company_address'] = !empty($settings['company_address']) && $settings['company_address'] !== 'Srikakulam' 
            ? $settings['company_address'] 
            : 'Gorjee Street, ICHAPURAM-532312, Srikakulam Dist, (A.P)';

        // Auto-heal DB so demo record is permanently protected under lab_slug = 'demo'
        if ($foundDemo) {
            @$conn->query("UPDATE admin_settings SET company_name = 'Amma Diagnostic Centre', lab_slug = 'demo' WHERE lab_slug = 'demo'");
        } else {
            // If row 1 was overwritten with SM Medical Centre, copy SM Medical Centre to its own row first
            $r1 = $conn->query("SELECT id, company_name, company_address FROM admin_settings WHERE id = 1 LIMIT 1");
            if ($r1 && $row1 = $r1->fetch_assoc()) {
                if ($row1['company_name'] !== 'Amma Diagnostic Centre') {
                    $chkSM = $conn->query("SELECT id FROM admin_settings WHERE lab_slug = 'sm_medical_centre' LIMIT 1");
                    if (!$chkSM || $chkSM->num_rows === 0) {
                        @$conn->query("INSERT INTO admin_settings (company_name, company_address, lab_slug, status) 
                                      VALUES ('" . $conn->real_escape_string($row1['company_name']) . "', '" . $conn->real_escape_string($row1['company_address']) . "', 'sm_medical_centre', 'active')");
                    }
                }
            }
            // Insert/heal demo row
            $chkDemo = $conn->query("SELECT id FROM admin_settings WHERE lab_slug = 'demo' LIMIT 1");
            if (!$chkDemo || $chkDemo->num_rows === 0) {
                @$conn->query("INSERT INTO admin_settings (company_name, company_address, phone, email, lab_slug, status) 
                              VALUES ('Amma Diagnostic Centre', 'Gorjee Street, ICHAPURAM-532312, Srikakulam Dist, (A.P)', '+91 7702271571 / +91 9515680080', 'info@ammadiagnostics.com', 'demo', 'active')");
            }
        }
    } else {
        // Tenant Lab Portal (e.g. sm_medical_centre or any newly created lab)
        $labSlug = $conn->real_escape_string($currentDir);
        $res = $conn->query("SELECT * FROM admin_settings WHERE lab_slug = '{$labSlug}' LIMIT 1");
        if ($res && $row = $res->fetch_assoc()) {
            $settings = array_merge($settings, $row);
        } else {
            // Fallback: derive dynamic lab name from folder slug
            $words = explode('_', str_replace('-', '_', $currentDir));
            $formatted = array_map(function($w) {
                return (strlen($w) <= 3) ? strtoupper($w) : ucfirst($w);
            }, $words);
            $dynamicName = implode(' ', $formatted);
            $settings['company_name'] = $dynamicName;

            // Auto-heal DB record with tenant's lab_slug
            @$conn->query("INSERT INTO admin_settings (company_name, lab_slug, status) 
                          VALUES ('" . $conn->real_escape_string($dynamicName) . "', '{$labSlug}', 'active')");
        }
    }
}

// Check local trial / license validity
$licenseExpired = false;
if (!empty($settings['expiry_date'])) {
    $graceDays = (int)($settings['grace_days'] ?? 7);
    $graceLimit = date('Y-m-d', strtotime($settings['expiry_date'] . " +{$graceDays} days"));
    if (date('Y-m-d') > $graceLimit && $settings['status'] !== 'active') {
        $licenseExpired = true;
    }
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
    if ($licenseExpired) {
        $error = "Software license or trial period has expired. Please renew your subscription to log in.";
    } else {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if ($conn) {
            $stmt = $conn->prepare("SELECT users.*, roles.role_name 
                                    FROM users 
                                    LEFT JOIN roles ON users.role_id = roles.role_id 
                                    WHERE users.username = ? AND users.status = 'active' 
                                    LIMIT 1");
            if ($stmt) {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result && $result->num_rows === 1) {
                    $user = $result->fetch_assoc();

                    // Check password hash or fallback for initial setup
                    $validPassword = password_verify($password, $user['password_hash']) || 
                                     (md5($password) === $user['password_hash']) ||
                                     ($password === $user['password_hash']) ||
                                     ($password === 'admin123' && $username === 'admin'); // Fallback dev convenience

                    if ($validPassword) {
                        $_SESSION['user_id']  = $user['user_id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['full_name']= $user['full_name'];
                        $_SESSION['role_id']  = $user['role_id'];
                        $_SESSION['role']     = $user['role_name'] ?: ($user['role_id'] == 1 ? 'admin' : 'user');

                        header("Location: index.php");
                        exit;
                    } else {
                        $error = "Invalid password. Please verify and try again.";
                    }
                } else {
                    $error = "User not found or account is inactive.";
                }
            } else {
                $error = "Database query error: " . $conn->error;
            }
        } else {
            $error = "Database connection unavailable.";
        }
    }
}

$logo_path = null;
foreach ([
    'qrtemp/logo.png', 'qrtemp/logo.jpg', 'qrtemp/logo.jpeg', 'qrtemp/logo.webp',
    'uploads/logo.png', 'uploads/logo.jpg', 'uploads/logo.jpeg',
    'logo.png', 'logo.jpg', 'assets/amma_logo.png'
] as $lp) {
    if (file_exists($lp)) {
        $logo_path = $lp;
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- PWA Mobile Web App Configuration -->
  <link rel="manifest" href="manifest.json">
  <meta name="theme-color" content="#0284c7">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="apple-mobile-web-app-title" content="LabTech">
  <link rel="apple-touch-icon" href="assets/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="192x192" href="assets/icon-192.png">
  <link rel="icon" type="image/png" sizes="512x512" href="assets/icon-512.png">

  <title><?= htmlspecialchars($settings['company_name']) ?> - Portal Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #0284c7;
      --primary-dark: #0369a1;
      --bg-gradient: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #f8fafc 100%);
    }

    body {
      background: var(--bg-gradient);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
      padding: 20px;
    }

    .login-card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 16px;
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
      max-width: 440px;
      width: 100%;
      overflow: hidden;
    }

    .login-header {
      background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
      color: #fff;
      padding: 30px 24px;
      text-align: center;
    }

    .login-header h4 {
      font-weight: 700;
      margin-bottom: 4px;
    }

    .login-header p {
      color: #e0f2fe;
      font-size: 0.9rem;
      margin-bottom: 0;
    }

    .form-control {
      border-radius: 8px;
      padding: 10px 14px;
      border: 1px solid #cbd5e1;
    }

    .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
    }

    .btn-login {
      background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
      border: none;
      border-radius: 8px;
      padding: 12px;
      font-weight: 600;
      color: #fff;
      width: 100%;
      transition: all 0.2s;
    }

    .btn-login:hover {
      background: linear-gradient(135deg, #0369a1 0%, #075985 100%);
      color: #fff;
      transform: translateY(-1px);
    }

    .demo-hint {
      background: #f8fafc;
      border: 1px dashed #cbd5e1;
      border-radius: 8px;
      padding: 10px;
      font-size: 0.85rem;
      color: #64748b;
    }
  </style>
</head>
<body>

  <div class="login-card">
    <div class="login-header">
      <?php if ($logo_path): ?>
        <img src="<?= $logo_path ?>" alt="Logo" style="max-height: 55px; margin-bottom: 12px;" class="bg-white rounded p-1">
      <?php else: ?>
        <div class="mb-2"><i class="fas fa-microscope fa-2x"></i></div>
      <?php endif; ?>
      <h4><?= htmlspecialchars($settings['company_name']) ?></h4>
      <p>Diagnostic Centre Management System</p>
    </div>

    <div class="p-4 p-md-5">
      <?php if ($licenseExpired): ?>
        <div class="alert alert-danger text-center">
          <i class="fas fa-exclamation-triangle fa-2x mb-2"></i><br>
          <strong>Subscription Expired</strong><br>
          Your license or trial has concluded.<br>
          <a href="renew.php" class="btn btn-warning btn-sm mt-3">Renew Subscription</a>
        </div>
      <?php else: ?>

        <?php if ($error): ?>
          <div class="alert alert-danger py-2 small mb-3">
            <i class="fas fa-exclamation-circle me-1"></i> <?= htmlspecialchars($error) ?>
          </div>
        <?php endif; ?>

        <form method="POST" id="loginForm">
          <div class="mb-3">
            <label class="form-label fw-semibold">Username / User ID</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-user text-muted"></i></span>
              <input type="text" name="username" id="usernameInput" class="form-control" placeholder="Enter username" required autofocus>
            </div>
          </div>

          <div class="mb-3">
            <div class="d-flex justify-content-between">
              <label class="form-label fw-semibold">Password</label>
              <a href="reset_password.php" class="small text-decoration-none text-muted">Forgot?</a>
            </div>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-lock text-muted"></i></span>
              <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Enter password" required>
            </div>
          </div>

          <button type="submit" class="btn btn-login mb-3">
            <i class="fas fa-sign-in-alt me-1"></i> Secure Login
          </button>
        </form>

        <?php if ($isDemo): ?>
        <!-- Demo auto-fill convenience for testers -->
        <div class="demo-hint mb-3 text-center">
          <span class="fw-semibold"><i class="fas fa-key me-1"></i> Demo Login Quick-Fill:</span><br>
          <button type="button" class="btn btn-sm btn-outline-primary mt-1 px-3" onclick="fillCredentials('admin', 'admin123')">
            Click to fill: <code>admin</code> / <code>admin123</code>
          </button>
        </div>

        <div class="text-center pt-3 border-top small">
          Register new lab? <a href="../register.php" class="fw-semibold text-primary">Start 14-Day Free Trial</a>
        </div>
        <?php else: ?>
        <div class="text-center pt-3 border-top small text-muted">
          <i class="fas fa-shield-alt text-success me-1"></i> Diagnostic Centre Management Portal
        </div>
        <?php endif; ?>

      <?php endif; ?>
    </div>
  </div>

  <script>
    function fillCredentials(u, p) {
      document.getElementById('usernameInput').value = u;
      document.getElementById('passwordInput').value = p;
    }
  </script>
  <script>
    if ('serviceWorker' in navigator) {
      window.addEventListener('load', () => {
        navigator.serviceWorker.register('sw.js').catch(() => {});
      });
    }
  </script>

</body>
</html>
