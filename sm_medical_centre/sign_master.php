<?php
/**
 * Sign & Stamp Management Master
 * - Doctor, Lab Technician, and Radiologist Signatory Profiles
 * - Signature and Stamp uploads with live previews
 * - Qualifications & Credentials management
 * - Modern Medical Studio design language
 */
include_once 'auth_check.php';
include_once 'db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- Auto-Migration for 'role' and 'qualification' columns ---
if ($conn) {
    $checkRole = $conn->query("SHOW COLUMNS FROM sign_master LIKE 'role'");
    if ($checkRole && $checkRole->num_rows == 0) {
        $conn->query("ALTER TABLE sign_master ADD COLUMN role VARCHAR(50) NOT NULL DEFAULT 'Doctor' AFTER Name");
    }
    $checkQual = $conn->query("SHOW COLUMNS FROM sign_master LIKE 'qualification'");
    if ($checkQual && $checkQual->num_rows == 0) {
        $conn->query("ALTER TABLE sign_master ADD COLUMN qualification VARCHAR(255) NOT NULL DEFAULT '' AFTER role");
    }
}

$msg = '';
$msgClass = '';

// --- Handle Save / Update ---
if (isset($_POST['save'])) {
    $id            = !empty($_POST['id']) ? intval($_POST['id']) : null;
    $name          = trim($_POST['name'] ?? '');
    $role          = trim($_POST['role'] ?? 'Doctor');
    $qualification = trim($_POST['qualification'] ?? '');
    $status        = ($_POST['status'] ?? 'active') === 'inactive' ? 'inactive' : 'active';

    $valid_roles = ['Doctor', 'Lab Technician', 'Radiologist'];
    if (!in_array($role, $valid_roles)) {
        $role = 'Doctor';
    }

    $uploadDir = __DIR__ . '/sign_stamp/';
    if (!is_dir($uploadDir)) {
        @mkdir($uploadDir, 0777, true);
    }

    $sign = '';
    if (!empty($_FILES['signimage']['name'])) {
        $signFile = time() . '_sig_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $_FILES['signimage']['name']);
        if (move_uploaded_file($_FILES['signimage']['tmp_name'], $uploadDir . $signFile)) {
            $sign = $signFile;
        }
    }

    $stamp = '';
    if (!empty($_FILES['stampimage']['name'])) {
        $stampFile = time() . '_stamp_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $_FILES['stampimage']['name']);
        if (move_uploaded_file($_FILES['stampimage']['tmp_name'], $uploadDir . $stampFile)) {
            $stamp = $stampFile;
        }
    }

    if ($id) {
        $cur = $conn->query("SELECT signimage, stampimage FROM sign_master WHERE id=$id")->fetch_assoc();
        $sign  = $sign ?: ($cur['signimage'] ?? '');
        $stamp = $stamp ?: ($cur['stampimage'] ?? '');

        $stmt = $conn->prepare("UPDATE sign_master SET Name=?, role=?, qualification=?, signimage=?, stampimage=?, status=? WHERE id=?");
        $stmt->bind_param("ssssssi", $name, $role, $qualification, $sign, $stamp, $status, $id);
        $stmt->execute();
        $stmt->close();

        $msg = "Signatory profile '{$name}' updated successfully."; 
        $msgClass = 'success';
    } else {
        $stmt = $conn->prepare("INSERT INTO sign_master (Name, role, qualification, signimage, stampimage, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $role, $qualification, $sign, $stamp, $status);
        $stmt->execute();
        $stmt->close();

        $msg = "New {$role} '{$name}' registered successfully."; 
        $msgClass = 'success';
    }

    header("Location: sign_master.php?msg=" . urlencode($msg) . "&cls=$msgClass");
    exit;
}

// --- Handle Delete ---
if (isset($_GET['delete'])) {
    $did = intval($_GET['delete']);
    if ($did > 0) {
        $conn->query("DELETE FROM sign_master WHERE id=$did");
        $msg = "Signatory profile deleted successfully.";
        $msgClass = 'danger';
    }
    header("Location: sign_master.php?msg=" . urlencode($msg) . "&cls=$msgClass");
    exit;
}

// --- Load Edit ---
$edit = null;
if (isset($_GET['edit'])) {
    $eid = intval($_GET['edit']);
    if ($eid > 0) {
        $edit = $conn->query("SELECT * FROM sign_master WHERE id=$eid")->fetch_assoc();
    }
}

// --- Display Message ---
if (isset($_GET['msg'])) {
    $msg = htmlspecialchars($_GET['msg']);
    $msgClass = htmlspecialchars($_GET['cls'] ?? 'info');
}

// Metrics
$total_staff = 0;
$total_docs  = 0;
$total_techs = 0;
$total_rads  = 0;
if ($conn) {
    $total_staff = $conn->query("SELECT COUNT(*) as c FROM sign_master")->fetch_assoc()['c'] ?? 0;
    $total_docs  = $conn->query("SELECT COUNT(*) as c FROM sign_master WHERE role = 'Doctor'")->fetch_assoc()['c'] ?? 0;
    $total_techs = $conn->query("SELECT COUNT(*) as c FROM sign_master WHERE role = 'Lab Technician'")->fetch_assoc()['c'] ?? 0;
    $total_rads  = $conn->query("SELECT COUNT(*) as c FROM sign_master WHERE role = 'Radiologist'")->fetch_assoc()['c'] ?? 0;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Doctor & Staff Signatures Master | Laboratory ERP</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --brand-primary: #0284c7;
      --brand-dark: #0369a1;
      --surface-bg: #f8fafc;
      --border-color: #e2e8f0;
      --border-light: #f1f5f9;
      --text-main: #0f172a;
      --text-muted: #64748b;
      --placeholder-color: #94a3b8;
    }

    body {
      background-color: var(--surface-bg);
      font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
      color: var(--text-main);
      margin: 0;
      padding-bottom: 60px;
    }

    /* Universal Light Placeholders */
    ::placeholder {
      color: var(--placeholder-color) !important;
      opacity: 0.75 !important;
      font-weight: 400 !important;
    }
    .form-control::placeholder {
      color: var(--placeholder-color) !important;
      opacity: 0.75 !important;
      font-size: 0.85rem !important;
    }

    .page-container {
      max-width: 1400px;
      margin: 22px auto;
      padding: 0 18px;
    }

    /* Studio Header */
    .sign-header-card {
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 14px;
      padding: 18px 24px;
      box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.04);
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 22px;
      flex-wrap: wrap;
      gap: 12px;
    }
    .sign-title {
      font-size: 1.35rem;
      font-weight: 800;
      color: var(--text-main);
      margin: 0;
      display: flex;
      align-items: center;
      gap: 10px;
      letter-spacing: -0.3px;
    }

    /* Metrics Grid */
    .metrics-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 16px;
      margin-bottom: 22px;
    }
    .metric-card {
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 12px;
      padding: 16px 20px;
      box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
      display: flex;
      align-items: center;
      gap: 16px;
    }
    .metric-icon-box {
      width: 46px;
      height: 46px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.3rem;
    }
    .metric-val {
      font-size: 1.55rem;
      font-weight: 800;
      font-family: 'JetBrains Mono', monospace;
      line-height: 1.1;
    }
    .metric-label {
      font-size: 0.74rem;
      font-weight: 700;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-top: 2px;
    }

    /* Studio Card */
    .studio-card {
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 14px;
      box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.04);
      padding: 22px 26px;
      margin-bottom: 24px;
    }
    .studio-card-title {
      font-size: 1.05rem;
      font-weight: 700;
      color: var(--text-main);
      margin-bottom: 18px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid var(--border-light);
      padding-bottom: 12px;
    }

    /* Form Controls */
    .form-label {
      font-size: 0.76rem;
      font-weight: 700;
      color: #475569;
      margin-bottom: 6px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      display: block;
    }
    .form-control, .form-select {
      border-radius: 8px;
      border: 1px solid var(--border-color);
      font-size: 0.89rem;
      padding: 9px 13px;
      color: var(--text-main);
      background-color: #ffffff;
      transition: all 0.2s;
    }
    .form-control:focus, .form-select:focus {
      border-color: var(--brand-primary);
      box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.12);
    }

    /* Image Preview Boxes */
    .preview-box {
      border: 1px dashed var(--border-color);
      background: #f8fafc;
      border-radius: 8px;
      padding: 10px;
      min-height: 85px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-top: 8px;
    }
    .preview-box img {
      max-height: 75px;
      max-width: 100%;
      object-fit: contain;
      border-radius: 6px;
    }
    .preview-placeholder {
      font-size: 0.78rem;
      color: #94a3b8;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    /* Role Badges */
    .role-badge {
      font-size: 0.76rem;
      font-weight: 700;
      padding: 4px 10px;
      border-radius: 6px;
      display: inline-flex;
      align-items: center;
      gap: 5px;
      letter-spacing: 0.2px;
    }
    .badge-doctor {
      background-color: #e0f2fe;
      color: #0369a1;
      border: 1px solid #bae6fd;
    }
    .badge-tech {
      background-color: #ecfdf5;
      color: #047857;
      border: 1px solid #a7f3d0;
    }
    .badge-rad {
      background-color: #f3e8ff;
      color: #7c3aed;
      border: 1px solid #ddd6fe;
    }

    /* Table */
    .studio-table-wrapper {
      border: 1px solid var(--border-color);
      border-radius: 12px;
      overflow: hidden;
      background: #ffffff;
    }
    .studio-table {
      width: 100%;
      border-collapse: collapse;
      margin: 0;
    }
    .studio-table th {
      background-color: #f8fafc;
      color: #475569;
      font-size: 0.76rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      padding: 12px 16px;
      border-bottom: 1px solid var(--border-color);
      white-space: nowrap;
    }
    .studio-table td {
      padding: 12px 16px;
      vertical-align: middle;
      border-bottom: 1px solid var(--border-light);
      font-size: 0.88rem;
    }
    .studio-table tr:last-child td {
      border-bottom: none;
    }
    .studio-table tr:hover td {
      background-color: #fafbfc;
    }
    .table-thumb {
      max-height: 44px;
      max-width: 90px;
      object-fit: contain;
      border-radius: 4px;
      border: 1px solid #e2e8f0;
      background: #ffffff;
      padding: 2px;
    }
  </style>
</head>
<body>

<?php include_once __DIR__ . '/header.php'; ?>

<div class="page-container">

  <!-- Header Card -->
  <div class="sign-header-card">
    <div>
      <h1 class="sign-title">
        <i class="fas fa-signature text-primary"></i> Doctor & Staff Signatures Master
      </h1>
      <div class="text-muted small mt-1">
        Configure authorized signatories (Doctors, Lab Technicians, Radiologists), qualifications, digital signatures, and official laboratory stamps.
      </div>
    </div>
    <div class="d-flex align-items-center gap-2">
      <a href="template_designer.php" class="btn btn-outline-secondary btn-sm fw-semibold">
        <i class="bi bi-palette me-1"></i> Report Designer
      </a>
      <a href="lab_test_list.php" class="btn btn-outline-primary btn-sm fw-semibold">
        <i class="bi bi-clipboard2-pulse me-1"></i> Test Catalog
      </a>
    </div>
  </div>

  <!-- Session Alerts -->
  <?php if (!empty($msg)): ?>
    <div class="alert alert-<?= $msgClass ?> alert-dismissible fade show shadow-sm" role="alert">
      <i class="bi bi-check-circle-fill me-2"></i><?= $msg ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>

  <!-- Metrics Grid -->
  <div class="metrics-grid">
    <div class="metric-card">
      <div class="metric-icon-box" style="background: #e0f2fe; color: #0284c7;">
        <i class="fas fa-users"></i>
      </div>
      <div>
        <div class="metric-val" style="color: #0284c7;"><?= (int)$total_staff ?></div>
        <div class="metric-label">Total Signatories</div>
      </div>
    </div>

    <div class="metric-card">
      <div class="metric-icon-box" style="background: #e0f2fe; color: #0369a1;">
        <i class="fas fa-user-md"></i>
      </div>
      <div>
        <div class="metric-val" style="color: #0369a1;"><?= (int)$total_docs ?></div>
        <div class="metric-label">Doctors</div>
      </div>
    </div>

    <div class="metric-card">
      <div class="metric-icon-box" style="background: #ecfdf5; color: #047857;">
        <i class="fas fa-microscope"></i>
      </div>
      <div>
        <div class="metric-val" style="color: #047857;"><?= (int)$total_techs ?></div>
        <div class="metric-label">Lab Technicians</div>
      </div>
    </div>

    <div class="metric-card">
      <div class="metric-icon-box" style="background: #f3e8ff; color: #7c3aed;">
        <i class="fas fa-x-ray"></i>
      </div>
      <div>
        <div class="metric-val" style="color: #7c3aed;"><?= (int)$total_rads ?></div>
        <div class="metric-label">Radiologists</div>
      </div>
    </div>
  </div>

  <!-- Add / Edit Signatory Form Card -->
  <div class="studio-card">
    <div class="studio-card-title">
      <span>
        <i class="bi <?= $edit ? 'bi-pencil-square text-warning' : 'bi-plus-circle-fill text-primary' ?> me-2"></i>
        <?= $edit ? 'Edit Signatory: ' . htmlspecialchars($edit['Name']) : 'Register New Signatory Profile' ?>
      </span>
      <?php if ($edit): ?>
        <a href="sign_master.php" class="btn btn-outline-secondary btn-sm">
          <i class="bi bi-x-lg me-1"></i> Cancel Edit
        </a>
      <?php endif; ?>
    </div>

    <form method="post" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">

      <div class="row g-3">
        <!-- Name -->
        <div class="col-md-4">
          <label class="form-label">Full Name <span class="text-danger">*</span></label>
          <input type="text" name="name" class="form-control" required 
                 placeholder="e.g. Dr. N Srinivas Rao" 
                 value="<?= htmlspecialchars($edit['Name'] ?? '') ?>">
        </div>

        <!-- Role Provision (Doctor / Lab Technician / Radiologist) -->
        <div class="col-md-4">
          <label class="form-label">Signatory Role / Designation <span class="text-danger">*</span></label>
          <select name="role" class="form-select" required>
            <?php
            $current_role_val = $edit['role'] ?? 'Doctor';
            $roles = [
                'Doctor'         => 'Doctor (Pathologist / Physician)',
                'Lab Technician' => 'Lab Technician (Clinical Analyst)',
                'Radiologist'    => 'Radiologist (Imaging Specialist)'
            ];
            foreach ($roles as $rVal => $rLabel):
            ?>
              <option value="<?= $rVal ?>" <?= ($current_role_val === $rVal) ? 'selected' : '' ?>>
                <?= $rLabel ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Qualification -->
        <div class="col-md-4">
          <label class="form-label">Qualification / Degree</label>
          <input type="text" name="qualification" class="form-control" 
                 placeholder="e.g. MBBS, MD (Pathology) or B.Sc MLT, DMLT" 
                 value="<?= htmlspecialchars($edit['qualification'] ?? '') ?>">
        </div>

        <!-- Signature Upload -->
        <div class="col-md-5">
          <label class="form-label">Signature Image (PNG / JPG / WEBP)</label>
          <input type="file" name="signimage" class="form-control" accept="image/*" onchange="previewImg(this, 'signPrev', 'signPlaceholder')">
          <div class="preview-box">
            <?php $has_sig = !empty($edit['signimage']) && file_exists(__DIR__ . '/sign_stamp/' . $edit['signimage']); ?>
            <img id="signPrev" src="<?= $has_sig ? 'sign_stamp/' . htmlspecialchars($edit['signimage']) : '' ?>" 
                 style="<?= $has_sig ? '' : 'display:none;' ?>" alt="Signature Preview">
            <span id="signPlaceholder" class="preview-placeholder" style="<?= $has_sig ? 'display:none;' : '' ?>">
              <i class="bi bi-image text-muted"></i> No signature uploaded yet
            </span>
          </div>
        </div>

        <!-- Stamp Upload -->
        <div class="col-md-5">
          <label class="form-label">Stamp Image (PNG / JPG / WEBP)</label>
          <input type="file" name="stampimage" class="form-control" accept="image/*" onchange="previewImg(this, 'stampPrev', 'stampPlaceholder')">
          <div class="preview-box">
            <?php $has_stamp = !empty($edit['stampimage']) && file_exists(__DIR__ . '/sign_stamp/' . $edit['stampimage']); ?>
            <img id="stampPrev" src="<?= $has_stamp ? 'sign_stamp/' . htmlspecialchars($edit['stampimage']) : '' ?>" 
                 style="<?= $has_stamp ? '' : 'display:none;' ?>" alt="Stamp Preview">
            <span id="stampPlaceholder" class="preview-placeholder" style="<?= $has_stamp ? 'display:none;' : '' ?>">
              <i class="bi bi-shield-check text-muted"></i> No stamp uploaded yet
            </span>
          </div>
        </div>

        <!-- Status -->
        <div class="col-md-2">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
            <option value="active" <?= (!isset($edit['status']) || $edit['status'] === 'active') ? 'selected' : '' ?>>Active</option>
            <option value="inactive" <?= (isset($edit['status']) && $edit['status'] === 'inactive') ? 'selected' : '' ?>>Inactive</option>
          </select>
          <div class="mt-3">
            <button type="submit" name="save" class="btn btn-primary w-100 fw-bold py-2 shadow-sm">
              <i class="bi <?= $edit ? 'bi-check-lg' : 'bi-plus-lg' ?> me-1"></i>
              <?= $edit ? 'Update Profile' : 'Save Profile' ?>
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>

  <!-- Signatories List Card -->
  <div class="studio-card">
    <div class="studio-card-title">
      <span><i class="bi bi-card-list text-primary me-2"></i> Authorized Signatories & Staff Directory</span>
      <span class="badge bg-light text-muted border font-monospace"><?= (int)$total_staff ?> Records</span>
    </div>

    <div class="studio-table-wrapper">
      <table class="studio-table">
        <thead>
          <tr>
            <th width="4%" class="text-center">#</th>
            <th width="22%">Signatory Name</th>
            <th width="16%">Role / Designation</th>
            <th width="20%">Qualification</th>
            <th width="14%">Signature</th>
            <th width="14%">Stamp</th>
            <th width="5%" class="text-center">Status</th>
            <th width="5%" class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $rows = $conn->query("SELECT * FROM sign_master ORDER BY id DESC");
          if ($rows && $rows->num_rows > 0):
            while ($r = $rows->fetch_assoc()):
              $r_role = $r['role'] ?? 'Doctor';
              $badge_class = 'badge-doctor';
              $icon = 'fa-user-md';
              if ($r_role === 'Lab Technician') {
                  $badge_class = 'badge-tech';
                  $icon = 'fa-microscope';
              } elseif ($r_role === 'Radiologist') {
                  $badge_class = 'badge-rad';
                  $icon = 'fa-x-ray';
              }
              $has_sig_file = !empty($r['signimage']) && file_exists(__DIR__ . '/sign_stamp/' . $r['signimage']);
              $has_stamp_file = !empty($r['stampimage']) && file_exists(__DIR__ . '/sign_stamp/' . $r['stampimage']);
          ?>
            <tr>
              <td class="text-center text-muted font-monospace small"><?= $r['id'] ?></td>
              <td>
                <div class="fw-bold text-dark"><?= htmlspecialchars($r['Name']) ?></div>
              </td>
              <td>
                <span class="role-badge <?= $badge_class ?>">
                  <i class="fas <?= $icon ?>"></i> <?= htmlspecialchars($r_role) ?>
                </span>
              </td>
              <td>
                <?php if (!empty($r['qualification'])): ?>
                  <span class="text-dark fw-semibold"><?= htmlspecialchars($r['qualification']) ?></span>
                <?php else: ?>
                  <span class="text-muted small fst-italic">Not specified</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($has_sig_file): ?>
                  <img src="sign_stamp/<?= htmlspecialchars($r['signimage']) ?>" alt="Signature" class="table-thumb" title="<?= htmlspecialchars($r['signimage']) ?>">
                <?php else: ?>
                  <span class="badge bg-light text-muted border">No image</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($has_stamp_file): ?>
                  <img src="sign_stamp/<?= htmlspecialchars($r['stampimage']) ?>" alt="Stamp" class="table-thumb" title="<?= htmlspecialchars($r['stampimage']) ?>">
                <?php else: ?>
                  <span class="badge bg-light text-muted border">No image</span>
                <?php endif; ?>
              </td>
              <td class="text-center">
                <?php if ($r['status'] === 'active'): ?>
                  <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Active</span>
                <?php else: ?>
                  <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1">Inactive</span>
                <?php endif; ?>
              </td>
              <td class="text-end">
                <div class="d-flex align-items-center justify-content-end gap-1">
                  <a href="?edit=<?= $r['id'] ?>" class="btn btn-sm btn-outline-warning" title="Edit Signatory">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <a href="?delete=<?= $r['id'] ?>" class="btn btn-sm btn-outline-danger" 
                     onclick="return confirm('Delete signatory \'<?= htmlspecialchars(addslashes($r['Name'])) ?>\'?')" title="Delete Signatory">
                    <i class="bi bi-trash"></i>
                  </a>
                </div>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="8" class="text-center py-5 text-muted">
              <i class="fas fa-signature fa-3x text-muted mb-3 d-block opacity-50"></i>
              <h6 class="fw-bold text-secondary">No Signatories Configured</h6>
              <p class="small text-muted mb-0">Use the form above to add doctors, lab technicians, and radiologists.</p>
            </td>
          </tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<script>
function previewImg(input, imgId, placeholderId) {
  const pr = document.getElementById(imgId);
  const ph = document.getElementById(placeholderId);
  if (input.files && input.files[0]) {
    const fr = new FileReader();
    fr.onload = function(e) {
      pr.src = e.target.result;
      pr.style.display = 'block';
      if (ph) ph.style.display = 'none';
    };
    fr.readAsDataURL(input.files[0]);
  }
}
</script>

</body>
</html>
