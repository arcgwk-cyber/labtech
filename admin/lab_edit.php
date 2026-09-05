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

    if (empty($name)) {
        $error = "Lab name cannot be blank.";
    } else {
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
            
            // Sync tenant database and files if tenant folder exists
            $folder_slug = LabProvisioner::slugify($name);
            if (!empty($remarks) && preg_match('/Provisioned at \/([a-zA-Z0-9_\-]+)/', $remarks, $m)) {
                $folder_slug = $m[1];
            }
            $tenant_dir = dirname(__DIR__) . '/' . $folder_slug;
            $tenant_config = $tenant_dir . '/db.php';
            if (file_exists($tenant_config)) {
                try {
                    // Refresh login.php blueprint to tenant folder
                    $base_login = dirname(__DIR__) . '/base/login.php';
                    if (file_exists($base_login)) {
                        @copy($base_login, $tenant_dir . '/login.php');
                    }

                    include $tenant_config;
                    if (isset($conn) && !$conn->connect_error) {
                        $hash = password_hash($password, PASSWORD_BCRYPT);
                        $t_stmt = $conn->prepare("UPDATE users SET username = ?, password_hash = ?, full_name = ? WHERE role_id = 1 LIMIT 1");
                        if ($t_stmt) {
                            $t_stmt->bind_param("sss", $vendor_userid, $hash, $name);
                            $t_stmt->execute();
                            $t_stmt->close();
                        }
                        // Update admin_settings table with real lab name and address
                        $s_stmt = $conn->prepare("UPDATE admin_settings SET company_name = ?, company_address = ?, updated_at = NOW() WHERE id = 1");
                        if ($s_stmt) {
                            $s_stmt->bind_param("ss", $name, $address);
                            $s_stmt->execute();
                            $s_stmt->close();
                        }
                    }
                } catch (Exception $e) {
                    // ignore secondary sync
                }
                // Reconnect to master DB
                require __DIR__ . '/db.php';
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

// Handle 1-Click Sync Request
if (isset($_GET['sync']) && $_GET['sync'] == '1') {
    $tenant_dir = dirname(__DIR__) . '/' . $folder_slug;
    $tenant_config = $tenant_dir . '/db.php';
    $sync_ok = false;
    if (file_exists($tenant_config)) {
        try {
            $base_login = dirname(__DIR__) . '/base/login.php';
            if (file_exists($base_login)) {
                @copy($base_login, $tenant_dir . '/login.php');
            }

            include $tenant_config;
            if (isset($conn) && !$conn->connect_error) {
                // Ensure admin_settings exists and update branding
                $s_stmt = $conn->prepare("UPDATE admin_settings SET company_name = ?, company_address = ?, updated_at = NOW() WHERE id = 1");
                if ($s_stmt) {
                    $s_stmt->bind_param("ss", $lab['name'], $lab['address']);
                    $s_stmt->execute();
                    $s_stmt->close();
                    $sync_ok = true;
                }
            }
        } catch (Exception $e) {
            $error = "Sync notice: " . $e->getMessage();
        }
        require __DIR__ . '/db.php';
    }
    if ($sync_ok) {
        $message = "Successfully synchronized branding and portal files for '" . htmlspecialchars($lab['name']) . "'!";
    } else {
        $error = "Could not sync tenant files or database config for /" . htmlspecialchars($folder_slug);
    }
}
?>

<div class="container py-4" style="max-width: 800px;">

  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <a href="labs_manage.php" class="btn btn-sm btn-outline-secondary rounded-2 mb-2">
        <i class="fas fa-arrow-left me-1"></i> Back to All Labs
      </a>
      <h3 class="fw-bold mb-0 text-dark">Edit Diagnostic Laboratory #<?= $vendor_id ?></h3>
      <span class="text-muted small font-monospace">Folder: /<?= htmlspecialchars($folder_slug) ?></span>
    </div>
    <div class="d-flex align-items-center gap-2">
      <a href="lab_edit.php?id=<?= $vendor_id ?>&sync=1" class="btn btn-outline-info rounded-3 px-3 py-2 fw-semibold" title="Sync database branding and push latest portal files">
        <i class="fas fa-sync-alt me-1"></i> Sync Portal & DB
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
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
      <i class="fas fa-exclamation-circle fa-lg"></i>
      <div><?= htmlspecialchars($error) ?></div>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
