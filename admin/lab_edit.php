<?php
/**
 * Edit Lab Details, Credentials & Validity
 */
$page_title = "Edit Lab";
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/provision_helper.php';

$vendor_id = (int)($_GET['id'] ?? 0);
if ($vendor_id <= 0) {
    header("Location: labs_manage.php");
    exit;
}

$message = '';
$error = '';

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name          = trim($_POST['name'] ?? '');
    $vendor_userid = trim($_POST['vendor_userid'] ?? '');
    $password      = trim($_POST['password'] ?? '');
    $phone         = trim($_POST['phone'] ?? '');
    $email         = trim($_POST['email'] ?? '');
    $address       = trim($_POST['address'] ?? '');
    $pincode       = trim($_POST['pincode'] ?? '');
    $status        = trim($_POST['status'] ?? 'active');
    $due_date      = trim($_POST['due_date'] ?? '');
    $remarks       = trim($_POST['remarks'] ?? '');
    $db_name_post  = trim($_POST['db_name'] ?? '');
    $db_user_post  = trim($_POST['db_user'] ?? '');
    $db_pass_post  = trim($_POST['db_pass'] ?? '');

    if (empty($name)) {
        $error = "Lab name cannot be blank.";
    } else {
        // If DB name was specified and remarks doesn't have it or needs update
        if (!empty($db_name_post)) {
            if (preg_match('/DB:\s*[a-zA-Z0-9_\-]+/', $remarks)) {
                $remarks = preg_replace('/DB:\s*[a-zA-Z0-9_\-]+/', 'DB: ' . $db_name_post, $remarks);
            } else {
                $remarks = trim($remarks . ' | DB: ' . $db_name_post, ' |');
            }
        }

        $up = $conn->prepare("
            UPDATE vendor_master 
            SET name = ?, vendor_userid = ?, password = ?, phone = ?, email = ?, 
                address = ?, pincode = ?, status = ?, due_date = ?, remarks = ?
            WHERE vendor_id = ?
        ");
        $up->bind_param("ssssssssssi", 
            $name, $vendor_userid, $password, $phone, $email, 
            $address, $pincode, $status, $due_date, $remarks, $vendor_id
        );
        if ($up->execute()) {
            $message = "Laboratory details and credentials updated successfully!";

            // Ensure tenant directory exists and write db.php with submitted DB settings
            $folder_slug_temp = LabProvisioner::slugify($name);
            if (preg_match('/Provisioned at \/([a-zA-Z0-9_\-]+)/', $remarks, $m)) {
                $folder_slug_temp = $m[1];
            }
            $tDir = dirname(__DIR__) . '/' . $folder_slug_temp;
            if (!empty($db_name_post)) {
                if (!is_dir($tDir)) {
                    $baseDir = dirname(__DIR__) . '/base';
                    if (is_dir($baseDir)) {
                        LabProvisioner::copyDirectory($baseDir, $tDir);
                    }
                }
                if (is_dir($tDir)) {
                    $h = getenv('DB_HOST') ?: 'localhost';
                    $u = !empty($db_user_post) ? $db_user_post : (getenv('DB_USER') ?: 'root');
                    $p = $db_pass_post;
                    if ($p === '' && file_exists($tDir . '/db.php')) {
                        $cfg = file_get_contents($tDir . '/db.php');
                        if (preg_match('/\$pass\s*=\s*[\'"]([^\'"]*)[\'"]/', $cfg, $pm)) {
                            $p = $pm[1];
                        }
                    }
                    if ($p === '') {
                        $p = (getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');
                    }
                    LabProvisioner::writeDbConfigFile($tDir . '/db.php', $h, $u, $p, $db_name_post);
                }
            }
        } else {
            $error = "Failed to update record: " . $conn->error;
        }
        $up->close();
    }
}

// Fetch current vendor data
$stmt = $conn->prepare("SELECT * FROM vendor_master WHERE vendor_id = ? LIMIT 1");
$stmt->bind_param("i", $vendor_id);
$stmt->execute();
$lab = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$lab) {
    die("Lab record not found.");
}

$folder_slug = LabProvisioner::slugify($lab['name']);
if (!empty($lab['remarks']) && preg_match('/Provisioned at \/([a-zA-Z0-9_\-]+)/', $lab['remarks'], $m)) {
    $folder_slug = $m[1];
}
$tenant_dir = dirname(__DIR__) . '/' . $folder_slug;

/**
 * Robust Tenant Database & File Synchronizer
 * Connects independently to the tenant DB without overriding or corrupting the global master DB connection.
 */
function syncOrPurgeTenantLab($lab, $action = 'sync') {
    $workspaceRoot = dirname(__DIR__);
    
    // 1. Resolve folder slug
    $folder_slug = LabProvisioner::slugify($lab['name']);
    if (!empty($lab['remarks']) && preg_match('/Provisioned at \/([a-zA-Z0-9_\-]+)/', $lab['remarks'], $m)) {
        $folder_slug = $m[1];
    }
    $tenant_dir = $workspaceRoot . '/' . $folder_slug;

    // 1b. Auto-create tenant lab folder from blueprint if it doesn't exist yet!
    if (!is_dir($tenant_dir)) {
        $baseDir = $workspaceRoot . '/base';
        if (!is_dir($baseDir)) {
            return ['success' => false, 'error' => "Base template blueprint folder not found at: {$baseDir}"];
        }
        $copyOk = LabProvisioner::copyDirectory($baseDir, $tenant_dir);
        if (!$copyOk) {
            return ['success' => false, 'error' => "Failed to create tenant directory at: /{$folder_slug}. Please check server permissions."];
        }
    }

    // 2. Resolve database credentials
    $tenant_config = $tenant_dir . '/db.php';
    $db_host = null;
    $db_user = null;
    $db_pass = null;
    $db_name = null;

    if (file_exists($tenant_config)) {
        $cfg = file_get_contents($tenant_config);
        if (preg_match('/\$host\s*=\s*[\'"]([^\'"]+)[\'"]/', $cfg, $m)) $db_host = $m[1];
        if (preg_match('/\$user\s*=\s*[\'"]([^\'"]+)[\'"]/', $cfg, $m)) $db_user = $m[1];
        if (preg_match('/\$pass\s*=\s*[\'"]([^\'"]*)[\'"]/', $cfg, $m)) $db_pass = $m[1];
        if (preg_match('/\$dbname\s*=\s*[\'"]([^\'"]+)[\'"]/', $cfg, $m)) $db_name = $m[1];
    }

    // Fallback DB name from remarks e.g. "DB: u258033404_sm_medical"
    if (empty($db_name) && !empty($lab['remarks']) && preg_match('/DB:\s*([a-zA-Z0-9_\-]+)/', $lab['remarks'], $m)) {
        $db_name = $m[1];
    }

    // Auto-detect Hostinger database prefix if still unknown
    if (empty($db_name)) {
        $masterUser = getenv('DB_USER') ?: 'root';
        $prefix = (strpos($masterUser, '_') !== false) ? substr($masterUser, 0, strpos($masterUser, '_') + 1) : '';
        $db_name = $prefix . 'lab_' . $folder_slug;
    }

    // Fallback credentials from environment
    if (empty($db_host)) $db_host = getenv('DB_HOST') ?: 'localhost';
    if (empty($db_user)) $db_user = getenv('DB_USER') ?: 'root';
    if ($db_pass === null) $db_pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';

    // 3. Connect to tenant DB independently (DO NOT touch global $conn!)
    mysqli_report(MYSQLI_REPORT_OFF);
    $tConn = @new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($tConn->connect_error) {
        // Fallback: Try with master DB credentials if custom user is rejected
        $masterUser = getenv('DB_USER') ?: 'root';
        $masterPass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';
        $tConn = @new mysqli($db_host, $masterUser, $masterPass, $db_name);
        if ($tConn->connect_error) {
            $errDetail = "Database connection check failed for `{$db_name}`: " . $tConn->connect_error . ".<br><br>" .
                         "<strong>To fix this in Hostinger hPanel:</strong><br>" .
                         "1. Go to <strong>Hostinger hPanel &rarr; Databases (MySQL Databases)</strong>.<br>" .
                         "2. Under <em>List of Current MySQL Databases</em>, check the exact database name and user.<br>" .
                         "3. If user <code>" . htmlspecialchars($masterUser) . "</code> is not assigned to <code>" . htmlspecialchars($db_name) . "</code>, click <strong>Assign User</strong> with ALL PRIVILEGES.<br>" .
                         "4. Or if you created a dedicated database user and password, enter them below under <strong>Dedicated Database Configuration</strong> and click <strong>Save Changes</strong>.";
            return ['success' => false, 'error' => $errDetail];
        }
        $db_user = $masterUser;
        $db_pass = $masterPass;
    }
    $tConn->set_charset('utf8mb4');

    // Check if database tables exist; if empty, import master SQL dump
    $tblCheck = $tConn->query("SHOW TABLES");
    if ($tblCheck && $tblCheck->num_rows === 0) {
        $dumpPath = $workspaceRoot . '/dump/diagnostic_lab_db.sql';
        if (file_exists($dumpPath)) {
            try {
                $pTenant = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8mb4", $db_user, $db_pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]);
                LabProvisioner::importSqlFile($pTenant, $dumpPath);
            } catch (Exception $e) {
                // non-fatal
            }
        }
    }

    // 4. If purge action requested, truncate demo tables
    if ($action === 'purge') {
        $tablesToPurge = [
            'bills', 'bill_packages', 'bill_tests',
            'patients', 'patient_extra_info',
            'test_results', 'test_samples',
            'transactions', 'sign_master'
        ];
        $tConn->query("SET FOREIGN_KEY_CHECKS = 0;");
        foreach ($tablesToPurge as $tbl) {
            $res = $tConn->query("TRUNCATE TABLE `{$tbl}`;");
            if (!$res) {
                $tConn->query("DELETE FROM `{$tbl}`;");
                @$tConn->query("ALTER TABLE `{$tbl}` AUTO_INCREMENT = 1;");
            }
        }
        $tConn->query("SET FOREIGN_KEY_CHECKS = 1;");
    }

    // 5. Update/Seed Admin User in tenant DB
    $hash = password_hash($lab['password'], PASSWORD_BCRYPT);
    $chkU = $tConn->query("SELECT user_id FROM users WHERE username = '" . $tConn->real_escape_string($lab['vendor_userid']) . "' LIMIT 1");
    if ($chkU && $chkU->num_rows > 0) {
        $uRow = $chkU->fetch_assoc();
        $tConn->query("UPDATE users SET password_hash = '" . $tConn->real_escape_string($hash) . "', full_name = '" . $tConn->real_escape_string($lab['name']) . "', status = 'active' WHERE user_id = " . (int)$uRow['user_id']);
    } else {
        $tConn->query("INSERT INTO users (username, password_hash, full_name, role_id, status) VALUES ('" . $tConn->real_escape_string($lab['vendor_userid']) . "', '" . $tConn->real_escape_string($hash) . "', '" . $tConn->real_escape_string($lab['name']) . "', 1, 'active')");
    }

    // 6. Ensure and Update admin_settings safely
    $cols = [];
    $cRes = $tConn->query("SHOW COLUMNS FROM admin_settings");
    if ($cRes) {
        while ($cRow = $cRes->fetch_assoc()) {
            $cols[] = $cRow['Field'];
        }
    }
    if (!in_array('phone', $cols))       { @$tConn->query("ALTER TABLE admin_settings ADD COLUMN phone VARCHAR(50) DEFAULT NULL"); $cols[] = 'phone'; }
    if (!in_array('email', $cols))       { @$tConn->query("ALTER TABLE admin_settings ADD COLUMN email VARCHAR(100) DEFAULT NULL"); $cols[] = 'email'; }
    if (!in_array('status', $cols))      { @$tConn->query("ALTER TABLE admin_settings ADD COLUMN status VARCHAR(20) DEFAULT 'active'"); $cols[] = 'status'; }
    if (!in_array('expiry_date', $cols)) { @$tConn->query("ALTER TABLE admin_settings ADD COLUMN expiry_date DATE DEFAULT NULL"); $cols[] = 'expiry_date'; }
    if (!in_array('grace_days', $cols))  { @$tConn->query("ALTER TABLE admin_settings ADD COLUMN grace_days INT DEFAULT 7"); $cols[] = 'grace_days'; }

    $updateFields = [
        "company_name = '" . $tConn->real_escape_string($lab['name']) . "'",
        "company_address = '" . $tConn->real_escape_string($lab['address'] ?? '') . "'"
    ];
    if (in_array('phone', $cols)) $updateFields[] = "phone = '" . $tConn->real_escape_string($lab['phone'] ?? '') . "'";
    if (in_array('email', $cols)) $updateFields[] = "email = '" . $tConn->real_escape_string($lab['email'] ?? '') . "'";
    if (in_array('status', $cols)) $updateFields[] = "status = 'active'";
    if (in_array('expiry_date', $cols) && !empty($lab['due_date'])) $updateFields[] = "expiry_date = '" . $tConn->real_escape_string($lab['due_date']) . "'";
    if (in_array('grace_days', $cols)) $updateFields[] = "grace_days = 7";

    $tConn->query("UPDATE admin_settings SET " . implode(", ", $updateFields) . " WHERE id = 1");
    $tConn->close();

    // 7. Re-write tenant db.php config so tenant portal is 100% properly configured
    LabProvisioner::writeDbConfigFile($tenant_dir . '/db.php', $db_host, $db_user, $db_pass, $db_name);

    // 8. Refresh login.php blueprint
    $base_login = $workspaceRoot . '/base/login.php';
    if (file_exists($base_login)) {
        @copy($base_login, $tenant_dir . '/login.php');
    }

    // 9. Sync Logo and Letterhead assets
    $targetQrtemp  = $tenant_dir . '/qrtemp';
    $targetUploads = $tenant_dir . '/uploads';
    if (!is_dir($targetQrtemp))  { @mkdir($targetQrtemp, 0755, true); }
    if (!is_dir($targetUploads)) { @mkdir($targetUploads, 0755, true); }

    if (!empty($lab['logo_image'])) {
        $logoRel = ltrim($lab['logo_image'], '/\\');
        $logoSrc = $workspaceRoot . '/' . $logoRel;
        if (!file_exists($logoSrc) && file_exists(dirname(__DIR__) . '/' . $logoRel)) {
            $logoSrc = dirname(__DIR__) . '/' . $logoRel;
        }
        if (file_exists($logoSrc)) {
            @copy($logoSrc, $targetQrtemp . '/logo.jpg');
            @copy($logoSrc, $targetUploads . '/logo.jpg');
            @copy($logoSrc, $tenant_dir . '/logo.jpg');
            $ext = strtolower(pathinfo($logoSrc, PATHINFO_EXTENSION));
            if ($ext === 'png') {
                @copy($logoSrc, $targetQrtemp . '/logo.png');
                @copy($logoSrc, $targetUploads . '/logo.png');
                @copy($logoSrc, $tenant_dir . '/logo.png');
            }
        }
    }

    if (!empty($lab['letterhead_image'])) {
        $lhRel = ltrim($lab['letterhead_image'], '/\\');
        $lhSrc = $workspaceRoot . '/' . $lhRel;
        if (!file_exists($lhSrc) && file_exists(dirname(__DIR__) . '/' . $lhRel)) {
            $lhSrc = dirname(__DIR__) . '/' . $lhRel;
        }
        if (file_exists($lhSrc)) {
            @copy($lhSrc, $tenant_dir . '/letterhead.jpg');
            @copy($lhSrc, $targetQrtemp . '/letterhead.jpg');
            @copy($lhSrc, $targetUploads . '/letterhead.jpg');
            @copy($lhSrc, $tenant_dir . '/ammaletterhead.jpg');
            $ext = strtolower(pathinfo($lhSrc, PATHINFO_EXTENSION));
            if ($ext === 'png') {
                @copy($lhSrc, $tenant_dir . '/letterhead.png');
                @copy($lhSrc, $targetUploads . '/letterhead.png');
            }
        }
    }

    return ['success' => true, 'folder_slug' => $folder_slug, 'db_name' => $db_name];
}

// Handle 1-Click Sync Request
if (isset($_GET['sync']) && $_GET['sync'] == '1') {
    $sRes = syncOrPurgeTenantLab($lab, 'sync');
    if ($sRes['success']) {
        $message = "Successfully synchronized branding, logo, letterhead, and database config for '" . htmlspecialchars($lab['name']) . "' (DB: " . htmlspecialchars($sRes['db_name']) . ")!";
    } else {
        $error = $sRes['error'];
    }
}

// Handle 1-Click Purge Demo Data Request (Start 100% Fresh)
if (isset($_GET['purge']) && $_GET['purge'] == '1') {
    $pRes = syncOrPurgeTenantLab($lab, 'purge');
    if ($pRes['success']) {
        $message = "Demo transactional data purged successfully! Lab '" . htmlspecialchars($lab['name']) . "' now starts completely fresh with 0 patients, 0 bills, and its own registered logo/letterhead.";
    } else {
        $error = $pRes['error'];
    }
}

// Resolve current database details for form display
$current_db_name = '';
$current_db_user_val = '';
$tenant_config_file = $tenant_dir . '/db.php';
if (file_exists($tenant_config_file)) {
    $cfg_content = file_get_contents($tenant_config_file);
    if (preg_match('/\$dbname\s*=\s*[\'"]([^\'"]+)[\'"]/', $cfg_content, $m)) $current_db_name = $m[1];
    if (preg_match('/\$user\s*=\s*[\'"]([^\'"]+)[\'"]/', $cfg_content, $m)) $current_db_user_val = $m[1];
}
if (empty($current_db_name) && !empty($lab['remarks']) && preg_match('/DB:\s*([a-zA-Z0-9_\-]+)/', $lab['remarks'], $m)) {
    $current_db_name = $m[1];
}
if (empty($current_db_name)) {
    $mUser = getenv('DB_USER') ?: 'root';
    $pfx = (strpos($mUser, '_') !== false) ? substr($mUser, 0, strpos($mUser, '_') + 1) : '';
    $current_db_name = $pfx . 'lab_' . $folder_slug;
}
?>

<div class="container py-4" style="max-width: 860px;">

  <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
    <div>
      <a href="labs_manage.php" class="btn btn-sm btn-outline-secondary rounded-2 mb-2">
        <i class="fas fa-arrow-left me-1"></i> Back to All Labs
      </a>
      <h3 class="fw-bold mb-0 text-dark">Edit Diagnostic Laboratory #<?= $vendor_id ?></h3>
      <span class="text-muted small font-monospace">Folder: /<?= htmlspecialchars($folder_slug) ?></span>
    </div>
    <div class="d-flex flex-wrap align-items-center gap-2">
      <!-- 1-Click Purge Demo Data -->
      <a href="lab_edit.php?id=<?= $vendor_id ?>&purge=1" class="btn btn-outline-danger rounded-3 px-3 py-2 fw-semibold" onclick="return confirm('Purge demo patients, bills, samples, and reports for <?= addslashes($lab['name']) ?>? All clinical master catalogs, tests, and ranges will be preserved.');" title="Purge demo patients & bills so the lab starts 100% fresh">
        <i class="fas fa-trash-alt me-1"></i> Start Fresh (Purge Demo Data)
      </a>
      <!-- 1-Click Sync -->
      <a href="lab_edit.php?id=<?= $vendor_id ?>&sync=1" class="btn btn-outline-info rounded-3 px-3 py-2 fw-semibold" title="Sync database branding, logo, letterhead and push latest portal files">
        <i class="fas fa-sync-alt me-1"></i> Sync Assets & DB
      </a>
      <a href="../<?= htmlspecialchars($folder_slug) ?>/login.php" target="_blank" class="btn btn-primary rounded-3 px-3 py-2 fw-semibold">
        <i class="fas fa-external-link-alt me-1"></i> Open Portal
      </a>
    </div>
  </div>

  <?php if ($message): ?>
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
      <i class="fas fa-check-circle fa-lg"></i>
      <div><?= htmlspecialchars($message) ?></div>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-start gap-2 mb-4" role="alert">
      <i class="fas fa-exclamation-circle fa-lg mt-1"></i>
      <div class="small leading-relaxed"><?= $error ?></div>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <?php if (!is_dir($tenant_dir)): ?>
    <div class="alert alert-warning d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 p-3 mb-4 rounded-3 border-warning shadow-sm" role="alert">
      <div class="d-flex align-items-center gap-3">
        <div class="p-2 bg-warning bg-opacity-25 text-dark rounded-circle">
          <i class="fas fa-folder-plus fa-lg"></i>
        </div>
        <div>
          <strong class="text-dark d-block">Laboratory Portal Files Not Yet Deployed on Disk</strong>
          <span class="small text-muted">Directory <code>/<?= htmlspecialchars($folder_slug) ?></code> is missing. Click to deploy fresh portal files and database setup.</span>
        </div>
      </div>
      <a href="lab_edit.php?id=<?= $vendor_id ?>&purge=1" class="btn btn-warning fw-bold text-dark px-4 py-2 text-nowrap rounded-3">
        <i class="fas fa-rocket me-1"></i> Deploy Lab Portal Now
      </a>
    </div>
  <?php endif; ?>

  <div class="card-sa p-4 p-sm-5">
    <form method="POST" action="lab_edit.php?id=<?= $vendor_id ?>">
      
      <h5 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="fas fa-clinic-medical text-primary me-2"></i> General Information</h5>
      
      <div class="row g-3 mb-4">
        <div class="col-md-8">
          <label class="form-label small fw-semibold text-muted">Laboratory / Diagnostic Centre Name</label>
          <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($lab['name']) ?>" required>
        </div>
        <div class="col-md-4">
          <label class="form-label small fw-semibold text-muted">Account Status</label>
          <select name="status" class="form-select">
            <option value="active" <?= $lab['status'] === 'active' ? 'selected' : '' ?>>Active (Full Access)</option>
            <option value="inactive" <?= $lab['status'] === 'inactive' ? 'selected' : '' ?>>Inactive (Suspended)</option>
            <option value="pending" <?= $lab['status'] === 'pending' ? 'selected' : '' ?>>Pending Review</option>
            <option value="rejected" <?= $lab['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
          </select>
        </div>
      </div>

      <h5 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="fas fa-images text-primary me-2"></i> Branding Assets (Registered by Lab)</h5>
      <div class="row g-3 mb-4">
        <div class="col-md-6">
          <label class="form-label small fw-semibold text-muted">Laboratory Logo</label>
          <div class="border rounded p-3 text-center bg-light">
            <?php 
              $logoPath = !empty($lab['logo_image']) ? ltrim($lab['logo_image'], '/\\') : '';
              $logoExists = (!empty($logoPath) && (file_exists(dirname(__DIR__) . '/' . $logoPath) || file_exists($tenant_dir . '/qrtemp/logo.jpg') || file_exists($tenant_dir . '/logo.jpg')));
            ?>
            <?php if ($logoExists): ?>
              <?php 
                $displayLogo = file_exists(dirname(__DIR__) . '/' . $logoPath) ? '../' . $logoPath : '../' . $folder_slug . '/qrtemp/logo.jpg';
              ?>
              <img src="<?= htmlspecialchars($displayLogo) ?>" alt="Logo" class="img-fluid rounded mb-2 bg-white p-1 border shadow-sm" style="max-height: 80px; object-fit: contain;">
              <div class="text-success small fw-semibold"><i class="fas fa-check-circle me-1"></i> Custom Logo Active</div>
            <?php else: ?>
              <div class="text-muted small py-3"><i class="fas fa-image fa-2x mb-2 d-block text-secondary"></i> No custom logo uploaded at registration.</div>
            <?php endif; ?>
          </div>
        </div>
        <div class="col-md-6">
          <label class="form-label small fw-semibold text-muted">Report Letterhead</label>
          <div class="border rounded p-3 text-center bg-light">
            <?php 
              $lhPath = !empty($lab['letterhead_image']) ? ltrim($lab['letterhead_image'], '/\\') : '';
              $lhExists = (!empty($lhPath) && (file_exists(dirname(__DIR__) . '/' . $lhPath) || file_exists($tenant_dir . '/letterhead.jpg')));
            ?>
            <?php if ($lhExists): ?>
              <?php 
                $displayLh = file_exists(dirname(__DIR__) . '/' . $lhPath) ? '../' . $lhPath : '../' . $folder_slug . '/letterhead.jpg';
              ?>
              <img src="<?= htmlspecialchars($displayLh) ?>" alt="Letterhead" class="img-fluid rounded mb-2 bg-white p-1 border shadow-sm" style="max-height: 80px; object-fit: contain;">
              <div class="text-success small fw-semibold"><i class="fas fa-check-circle me-1"></i> Custom Letterhead Active</div>
            <?php else: ?>
              <div class="text-muted small py-3"><i class="fas fa-file-invoice fa-2x mb-2 d-block text-secondary"></i> No custom letterhead uploaded at registration.</div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <h5 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="fas fa-key text-primary me-2"></i> Administrator Login Credentials</h5>
      <div class="row g-3 mb-4">
        <div class="col-md-6">
          <label class="form-label small fw-semibold text-muted">Admin Username</label>
          <input type="text" name="vendor_userid" class="form-control" value="<?= htmlspecialchars($lab['vendor_userid'] ?? '') ?>" required>
        </div>
        <div class="col-md-6">
          <label class="form-label small fw-semibold text-muted">Admin Password (Plain Text / Master Reset)</label>
          <input type="text" name="password" class="form-control font-monospace" value="<?= htmlspecialchars($lab['password'] ?? '') ?>" required>
          <span class="text-muted small">Updating this also resets the tenant lab's login password.</span>
        </div>
      </div>

      <h5 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="fas fa-database text-primary me-2"></i> Dedicated Database Configuration</h5>
      <div class="row g-3 mb-4">
        <div class="col-md-6">
          <label class="form-label small fw-semibold text-muted">Hostinger Database Name</label>
          <input type="text" name="db_name" class="form-control font-monospace" value="<?= htmlspecialchars($current_db_name) ?>" required>
          <span class="text-muted small d-block mt-1" style="font-size: 0.75rem;">
            Must match the database name in Hostinger hPanel &rarr; Databases.
          </span>
        </div>
        <div class="col-md-6">
          <label class="form-label small fw-semibold text-muted">Database Username (Optional Override)</label>
          <input type="text" name="db_user" class="form-control font-monospace" value="<?= htmlspecialchars($current_db_user_val) ?>" placeholder="Default: <?= htmlspecialchars(getenv('DB_USER') ?: 'root') ?>">
          <span class="text-muted small d-block mt-1" style="font-size: 0.75rem;">
            Leave blank if using the default master user (<code><?= htmlspecialchars(getenv('DB_USER') ?: 'root') ?></code>).
          </span>
        </div>
        <div class="col-md-6">
          <label class="form-label small fw-semibold text-muted">Database Password (Optional Override)</label>
          <input type="password" name="db_pass" class="form-control font-monospace" placeholder="Leave blank to use default DB password">
          <span class="text-muted small d-block mt-1" style="font-size: 0.75rem;">
            Only enter if a unique password was assigned to this database in Hostinger.
          </span>
        </div>
      </div>

      <h5 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="fas fa-calendar-alt text-primary me-2"></i> Subscription & Contact Details</h5>
      <div class="row g-3 mb-4">
        <div class="col-md-6">
          <label class="form-label small fw-semibold text-muted">Subscription Due / Expiry Date</label>
          <input type="date" name="due_date" class="form-control" value="<?= htmlspecialchars($lab['due_date'] ?? '') ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label small fw-semibold text-muted">Phone Number</label>
          <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($lab['phone'] ?? '') ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label small fw-semibold text-muted">Email Address</label>
          <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($lab['email'] ?? '') ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label small fw-semibold text-muted">Pincode</label>
          <input type="text" name="pincode" class="form-control" value="<?= htmlspecialchars($lab['pincode'] ?? '') ?>">
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold text-muted">Full Address</label>
          <textarea name="address" class="form-control" rows="2"><?= htmlspecialchars($lab['address'] ?? '') ?></textarea>
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold text-muted">Super Admin Internal Remarks</label>
          <input type="text" name="remarks" class="form-control" value="<?= htmlspecialchars($lab['remarks'] ?? '') ?>">
        </div>
      </div>

      <div class="d-flex align-items-center justify-content-between pt-3 border-top">
        <a href="labs_manage.php" class="btn btn-outline-secondary px-4 py-2 rounded-3">Cancel</a>
        <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 fw-bold">
          <i class="fas fa-save me-1"></i> Save Changes
        </button>
      </div>

    </form>
  </div>

</div>

<?php require_once __DIR__ . '/footer.php'; ?>
