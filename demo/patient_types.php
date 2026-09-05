<?php
/**
 * Patient Categories & Registration Fields Studio
 * - Unified management of Patient Categories (General, Corporate, Insurance, Camp, VIP)
 * - Custom dynamic registration fields (Employee ID, Company, Policy #, TPA Approval)
 * - Real-time usage metrics (Registered Bills & Patients count)
 * - Modern medical studio design with light placeholders
 */
include_once 'auth_check.php';
include_once 'db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure patient_types and patient_type_fields tables exist
$conn->query("
    CREATE TABLE IF NOT EXISTS patient_types (
        type_id INT AUTO_INCREMENT PRIMARY KEY,
        type_name VARCHAR(100) NOT NULL,
        description TEXT NULL,
        template_format MEDIUMTEXT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
    CREATE TABLE IF NOT EXISTS patient_type_fields (
        field_id INT AUTO_INCREMENT PRIMARY KEY,
        type_id INT NOT NULL,
        field_name VARCHAR(100) NOT NULL,
        field_label VARCHAR(150) NOT NULL,
        field_type VARCHAR(50) DEFAULT 'text',
        is_required TINYINT(1) DEFAULT 0,
        FOREIGN KEY (type_id) REFERENCES patient_types(type_id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// ============================================================================
// 1. SERVER-SIDE ACTION HANDLERS (HANDLED BEFORE ANY OUTPUT)
// ============================================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // A. Add Category
    if ($action === 'add_category') {
        $name = trim($_POST['type_name'] ?? '');
        $desc = trim($_POST['description'] ?? '');

        if (!empty($name)) {
            $stmt = $conn->prepare("INSERT INTO patient_types (type_name, description) VALUES (?, ?)");
            $stmt->bind_param("ss", $name, $desc);
            if ($stmt->execute()) {
                $_SESSION['alert'] = ['type' => 'success', 'msg' => "Category '{$name}' created successfully."];
            } else {
                $_SESSION['alert'] = ['type' => 'danger', 'msg' => "Error: " . $stmt->error];
            }
            $stmt->close();
        } else {
            $_SESSION['alert'] = ['type' => 'danger', 'msg' => "Category name cannot be empty."];
        }
        header("Location: patient_types.php");
        exit;
    }

    // B. Update Category
    if ($action === 'update_category') {
        $id   = intval($_POST['type_id'] ?? 0);
        $name = trim($_POST['type_name'] ?? '');
        $desc = trim($_POST['description'] ?? '');

        if ($id > 0 && !empty($name)) {
            $stmt = $conn->prepare("UPDATE patient_types SET type_name=?, description=? WHERE type_id=?");
            $stmt->bind_param("ssi", $name, $desc, $id);
            if ($stmt->execute()) {
                $_SESSION['alert'] = ['type' => 'success', 'msg' => "Category updated successfully."];
            } else {
                $_SESSION['alert'] = ['type' => 'danger', 'msg' => "Error: " . $stmt->error];
            }
            $stmt->close();
        }
        header("Location: patient_types.php");
        exit;
    }

    // C. Add Custom Field
    if ($action === 'add_field') {
        $type_id  = intval($_POST['type_id'] ?? 0);
        $label    = trim($_POST['field_label'] ?? '');
        $name     = trim($_POST['field_name'] ?? '');
        $type     = trim($_POST['field_type'] ?? 'text');
        $required = isset($_POST['is_required']) ? 1 : 0;

        if (empty($name)) {
            $name = strtolower(preg_replace('/[^a-zA-Z0-9_]/', '_', $label));
        }

        if ($type_id > 0 && !empty($label)) {
            $stmt = $conn->prepare("INSERT INTO patient_type_fields (type_id, field_name, field_label, field_type, is_required) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("isssi", $type_id, $name, $label, $type, $required);
            if ($stmt->execute()) {
                $_SESSION['alert'] = ['type' => 'success', 'msg' => "Custom registration field '{$label}' added successfully."];
            } else {
                $_SESSION['alert'] = ['type' => 'danger', 'msg' => "Error: " . $stmt->error];
            }
            $stmt->close();
        }
        header("Location: patient_types.php?tab=fields");
        exit;
    }

    // D. Update Custom Field
    if ($action === 'update_field') {
        $field_id = intval($_POST['field_id'] ?? 0);
        $type_id  = intval($_POST['type_id'] ?? 0);
        $label    = trim($_POST['field_label'] ?? '');
        $name     = trim($_POST['field_name'] ?? '');
        $type     = trim($_POST['field_type'] ?? 'text');
        $required = isset($_POST['is_required']) ? 1 : 0;

        if ($field_id > 0 && !empty($label)) {
            $stmt = $conn->prepare("UPDATE patient_type_fields SET type_id=?, field_name=?, field_label=?, field_type=?, is_required=? WHERE field_id=?");
            $stmt->bind_param("isssii", $type_id, $name, $label, $type, $required, $field_id);
            if ($stmt->execute()) {
                $_SESSION['alert'] = ['type' => 'success', 'msg' => "Field updated successfully."];
            } else {
                $_SESSION['alert'] = ['type' => 'danger', 'msg' => "Error: " . $stmt->error];
            }
            $stmt->close();
        }
        header("Location: patient_types.php?tab=fields");
        exit;
    }
}

// GET Delete actions
if (isset($_GET['delete_category'])) {
    $del_id = intval($_GET['delete_category']);
    if ($del_id > 0) {
        $conn->query("DELETE FROM patient_type_fields WHERE type_id = $del_id");
        $conn->query("DELETE FROM patient_types WHERE type_id = $del_id");
        $_SESSION['alert'] = ['type' => 'danger', 'msg' => "Patient category deleted successfully."];
    }
    header("Location: patient_types.php");
    exit;
}

if (isset($_GET['delete_field'])) {
    $del_fid = intval($_GET['delete_field']);
    if ($del_fid > 0) {
        $conn->query("DELETE FROM patient_type_fields WHERE field_id = $del_fid");
        $_SESSION['alert'] = ['type' => 'danger', 'msg' => "Custom field deleted successfully."];
    }
    header("Location: patient_types.php?tab=fields");
    exit;
}

// Edit Category load
$edit_category = null;
if (isset($_GET['edit_category'])) {
    $eid = intval($_GET['edit_category']);
    $e_stmt = $conn->prepare("SELECT * FROM patient_types WHERE type_id = ?");
    $e_stmt->bind_param("i", $eid);
    $e_stmt->execute();
    $edit_category = $e_stmt->get_result()->fetch_assoc();
    $e_stmt->close();
}

// Edit Field load
$edit_field = null;
if (isset($_GET['edit_field'])) {
    $efid = intval($_GET['edit_field']);
    $ef_stmt = $conn->prepare("SELECT * FROM patient_type_fields WHERE field_id = ?");
    $ef_stmt->bind_param("i", $efid);
    $ef_stmt->execute();
    $edit_field = $ef_stmt->get_result()->fetch_assoc();
    $ef_stmt->close();
}

// Active Tab
$active_tab = $_GET['tab'] ?? 'categories';

// ============================================================================
// 2. DATA FETCHING & METRICS
// ============================================================================
$total_types = $conn->query("SELECT COUNT(*) as cnt FROM patient_types")->fetch_assoc()['cnt'] ?? 0;
$total_fields = $conn->query("SELECT COUNT(*) as cnt FROM patient_type_fields")->fetch_assoc()['cnt'] ?? 0;
$total_bills = $conn->query("SELECT COUNT(*) as cnt FROM bills WHERE patient_type_id IS NOT NULL AND patient_type_id > 0")->fetch_assoc()['cnt'] ?? 0;

// Fetch all categories with bill count and fields list
$categories_res = $conn->query("
    SELECT pt.*,
           (SELECT COUNT(*) FROM bills b WHERE b.patient_type_id = pt.type_id) as bill_count
    FROM patient_types pt
    ORDER BY pt.type_id ASC
");
$categories = [];
if ($categories_res) {
    while ($c = $categories_res->fetch_assoc()) {
        $cid = (int)$c['type_id'];
        $c_fields = [];
        $cf_res = $conn->query("SELECT * FROM patient_type_fields WHERE type_id = $cid ORDER BY field_id ASC");
        if ($cf_res) {
            while ($cf = $cf_res->fetch_assoc()) $c_fields[] = $cf;
        }
        $c['fields'] = $c_fields;
        $categories[] = $c;
    }
}

// Fetch all fields with type name
$fields_res = $conn->query("
    SELECT f.*, pt.type_name 
    FROM patient_type_fields f 
    JOIN patient_types pt ON f.type_id = pt.type_id 
    ORDER BY pt.type_name ASC, f.field_id ASC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Patient Categories & Registration Fields | Laboratory ERP</title>
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
    ::-webkit-input-placeholder {
      color: var(--placeholder-color) !important;
      opacity: 0.75 !important;
      font-weight: 400 !important;
    }
    :-moz-placeholder {
      color: var(--placeholder-color) !important;
      opacity: 0.75 !important;
      font-weight: 400 !important;
    }
    ::-moz-placeholder {
      color: var(--placeholder-color) !important;
      opacity: 0.75 !important;
      font-weight: 400 !important;
    }
    :-ms-input-placeholder {
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
    .studio-header-card {
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
    .studio-title {
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

    /* Navigation Tabs */
    .nav-tabs-pill {
      display: flex;
      background: #f1f5f9;
      padding: 4px;
      border-radius: 10px;
      border: 1px solid var(--border-color);
      margin-bottom: 20px;
      gap: 4px;
      width: fit-content;
    }
    .tab-pill-btn {
      padding: 8px 20px;
      font-size: 0.88rem;
      font-weight: 700;
      color: #64748b;
      border: none;
      background: transparent;
      border-radius: 8px;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: all 0.15s ease;
    }
    .tab-pill-btn.active {
      background: #ffffff;
      color: var(--brand-primary);
      box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    /* Studio Card */
    .studio-card {
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 14px;
      box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.04);
      padding: 22px 24px;
      margin-bottom: 22px;
    }
    .studio-card-title {
      font-size: 1.02rem;
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
      font-size: 0.74rem;
      font-weight: 700;
      color: #64748b;
      margin-bottom: 5px;
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
    }
    .form-control:focus, .form-select:focus {
      border-color: var(--brand-primary);
      box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.12);
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

    /* Extra field pill badge */
    .field-pill {
      font-size: 0.73rem;
      font-weight: 600;
      background: #f1f5f9;
      color: #334155;
      padding: 3px 8px;
      border-radius: 6px;
      border: 1px solid #e2e8f0;
      display: inline-flex;
      align-items: center;
      gap: 4px;
      margin: 2px;
    }
  </style>
</head>
<body>

<?php include_once __DIR__ . '/header.php'; ?>

<div class="page-container">

  <!-- Header Card -->
  <div class="studio-header-card">
    <div>
      <h1 class="studio-title">
        <i class="bi bi-people-fill text-primary"></i> Patient Categories & Registration Fields Studio
      </h1>
      <div class="text-muted small mt-1">
        Configure billing patient categories (Corporate, TPA, Insurance, Walk-in) and their custom dynamic registration fields.
      </div>
    </div>
    <div class="d-flex align-items-center gap-2">
      <a href="bill_add.php" class="btn btn-outline-primary btn-sm fw-semibold">
        <i class="bi bi-receipt me-1"></i> New Invoice
      </a>
      <a href="patient_formats.php" class="btn btn-outline-secondary btn-sm fw-semibold">
        <i class="bi bi-file-earmark-richtext me-1"></i> Patient Formats
      </a>
    </div>
  </div>

  <!-- Session Alerts -->
  <?php if (!empty($_SESSION['alert'])): ?>
    <div class="alert alert-<?= htmlspecialchars($_SESSION['alert']['type'] ?? 'info') ?> alert-dismissible fade show shadow-sm" role="alert">
      <i class="bi bi-info-circle-fill me-2"></i><?= htmlspecialchars($_SESSION['alert']['msg'] ?? '') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['alert']); ?>
  <?php endif; ?>

  <!-- Metrics Grid -->
  <div class="metrics-grid">
    <div class="metric-card">
      <div class="metric-icon-box" style="background: #e0f2fe; color: #0284c7;">
        <i class="bi bi-person-badge-fill"></i>
      </div>
      <div>
        <div class="metric-val" style="color: #0284c7;"><?= number_format($total_types) ?></div>
        <div class="metric-label">Patient Categories</div>
      </div>
    </div>

    <div class="metric-card">
      <div class="metric-icon-box" style="background: #f0fdf4; color: #16a34a;">
        <i class="bi bi-card-checklist"></i>
      </div>
      <div>
        <div class="metric-val" style="color: #16a34a;"><?= number_format($total_fields) ?></div>
        <div class="metric-label">Custom Extra Fields</div>
      </div>
    </div>

    <div class="metric-card">
      <div class="metric-icon-box" style="background: #fefce8; color: #ca8a04;">
        <i class="bi bi-receipt-cutoff"></i>
      </div>
      <div>
        <div class="metric-val" style="color: #ca8a04;"><?= number_format($total_bills) ?></div>
        <div class="metric-label">Categorized Invoices</div>
      </div>
    </div>
  </div>

  <!-- Tabs Navigation -->
  <div class="nav-tabs-pill">
    <a href="patient_types.php?tab=categories" class="tab-pill-btn <?= $active_tab === 'categories' ? 'active' : '' ?>">
      <i class="bi bi-tags-fill"></i> Patient Categories (<?= $total_types ?>)
    </a>
    <a href="patient_types.php?tab=fields" class="tab-pill-btn <?= $active_tab === 'fields' ? 'active' : '' ?>">
      <i class="bi bi-input-cursor-text"></i> Custom Extra Fields (<?= $total_fields ?>)
    </a>
  </div>

  <!-- TAB 1: CATEGORIES -->
  <?php if ($active_tab === 'categories'): ?>
    
    <!-- Add / Edit Category Form -->
    <div class="studio-card">
      <div class="studio-card-title">
        <span>
          <i class="bi <?= $edit_category ? 'bi-pencil text-warning' : 'bi-plus-circle-fill text-primary' ?> me-2"></i>
          <?= $edit_category ? 'Edit Category #' . $edit_category['type_id'] : 'Create New Patient Category' ?>
        </span>
        <?php if ($edit_category): ?>
          <a href="patient_types.php?tab=categories" class="btn btn-outline-secondary btn-sm">Cancel Edit</a>
        <?php endif; ?>
      </div>

      <form method="POST" action="patient_types.php">
        <input type="hidden" name="action" value="<?= $edit_category ? 'update_category' : 'add_category' ?>">
        <?php if ($edit_category): ?>
          <input type="hidden" name="type_id" value="<?= $edit_category['type_id'] ?>">
        <?php endif; ?>

        <div class="row g-3 align-items-end">
          <div class="col-md-5 col-12">
            <label class="form-label">Category Name <span class="text-danger">*</span></label>
            <input type="text" name="type_name" class="form-control fw-bold" placeholder="e.g. Corporate / B2B, Insurance / TPA, VIP Patient" required value="<?= htmlspecialchars($edit_category['type_name'] ?? '') ?>">
          </div>
          <div class="col-md-5 col-12">
            <label class="form-label">Description / Remarks</label>
            <input type="text" name="description" class="form-control" placeholder="Optional notes about billing policy or documentation" value="<?= htmlspecialchars($edit_category['description'] ?? '') ?>">
          </div>
          <div class="col-md-2 col-12">
            <button type="submit" class="btn btn-primary w-100 fw-bold">
              <i class="bi bi-check2-circle me-1"></i> <?= $edit_category ? 'Update' : 'Save Category' ?>
            </button>
          </div>
        </div>
      </form>
    </div>

    <!-- Categories List Table -->
    <div class="studio-card">
      <div class="studio-card-title">
        <span><i class="bi bi-list-ul text-primary me-2"></i> Configured Categories & Dynamic Fields</span>
      </div>

      <div class="studio-table-wrapper">
        <table class="studio-table">
          <thead>
            <tr>
              <th width="5%">#</th>
              <th width="22%">Category Name</th>
              <th width="25%">Description</th>
              <th width="33%">Attached Custom Fields (Billing Form)</th>
              <th width="15%" class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($categories)): ?>
              <?php foreach ($categories as $i => $cat): ?>
                <tr>
                  <td class="text-muted font-monospace"><?= $i + 1 ?></td>
                  <td>
                    <div class="fw-bold text-dark"><?= htmlspecialchars($cat['type_name']) ?></div>
                    <span class="badge bg-light text-secondary border font-monospace mt-1" style="font-size:0.72rem;">
                      <i class="bi bi-receipt me-1"></i><?= $cat['bill_count'] ?> Invoices
                    </span>
                  </td>
                  <td>
                    <span class="text-muted small"><?= htmlspecialchars($cat['description'] ?: 'Standard patient registration category') ?></span>
                  </td>
                  <td>
                    <?php if (!empty($cat['fields'])): ?>
                      <div class="d-flex flex-wrap">
                        <?php foreach ($cat['fields'] as $fld): ?>
                          <span class="field-pill" title="Code: <?= htmlspecialchars($fld['field_name']) ?>">
                            <i class="bi bi-card-text text-primary"></i>
                            <?= htmlspecialchars($fld['field_label']) ?>
                            <small class="text-muted">(<?= htmlspecialchars($fld['field_type']) ?>)</small>
                            <?php if ($fld['is_required']): ?>
                              <span class="text-danger fw-bold">*</span>
                            <?php endif; ?>
                          </span>
                        <?php endforeach; ?>
                      </div>
                    <?php else: ?>
                      <span class="text-muted small fst-italic">No extra fields (Uses default patient registration)</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-end">
                    <div class="d-flex align-items-center justify-content-end gap-1">
                      <!-- Quick Add Field Button -->
                      <a href="patient_types.php?tab=fields&target_type=<?= $cat['type_id'] ?>" class="btn btn-sm btn-outline-primary" title="Add Custom Registration Field">
                        <i class="bi bi-plus-lg"></i> Field
                      </a>
                      <a href="patient_types.php?tab=categories&edit_category=<?= $cat['type_id'] ?>" class="btn btn-sm btn-outline-warning" title="Edit Category">
                        <i class="bi bi-pencil"></i>
                      </a>
                      <a href="patient_types.php?delete_category=<?= $cat['type_id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete category \'<?= htmlspecialchars(addslashes($cat['type_name'])) ?>\' and its custom fields?')" title="Delete Category">
                        <i class="bi bi-trash"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center py-4 text-muted">No patient categories configured yet.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  <!-- TAB 2: CUSTOM EXTRA FIELDS -->
  <?php else: ?>
    
    <!-- Add / Edit Field Form -->
    <div class="studio-card">
      <div class="studio-card-title">
        <span>
          <i class="bi <?= $edit_field ? 'bi-pencil text-warning' : 'bi-plus-circle-fill text-primary' ?> me-2"></i>
          <?= $edit_field ? 'Edit Field: ' . htmlspecialchars($edit_field['field_label']) : 'Add Custom Dynamic Registration Field' ?>
        </span>
        <?php if ($edit_field): ?>
          <a href="patient_types.php?tab=fields" class="btn btn-outline-secondary btn-sm">Cancel Edit</a>
        <?php endif; ?>
      </div>

      <form method="POST" action="patient_types.php">
        <input type="hidden" name="action" value="<?= $edit_field ? 'update_field' : 'add_field' ?>">
        <?php if ($edit_field): ?>
          <input type="hidden" name="field_id" value="<?= $edit_field['field_id'] ?>">
        <?php endif; ?>

        <div class="row g-3 mb-3">
          <div class="col-md-4 col-12">
            <label class="form-label">Target Patient Category <span class="text-danger">*</span></label>
            <select name="type_id" class="form-select" required>
              <option value="">-- Choose Category --</option>
              <?php 
              $pre_sel = $edit_field ? (int)$edit_field['type_id'] : intval($_GET['target_type'] ?? 0);
              foreach ($categories as $c): ?>
                <option value="<?= $c['type_id'] ?>" <?= ($pre_sel == $c['type_id']) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($c['type_name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-4 col-12">
            <label class="form-label">Field Label (Shown in Bill Entry) <span class="text-danger">*</span></label>
            <input type="text" name="field_label" class="form-control fw-bold" placeholder="e.g. Employee ID, Company Name, Policy #" required value="<?= htmlspecialchars($edit_field['field_label'] ?? '') ?>">
          </div>

          <div class="col-md-2 col-6">
            <label class="form-label">Input Data Type</label>
            <select name="field_type" class="form-select">
              <option value="text" <?= ($edit_field && $edit_field['field_type'] === 'text') ? 'selected' : '' ?>>Text String</option>
              <option value="number" <?= ($edit_field && $edit_field['field_type'] === 'number') ? 'selected' : '' ?>>Number</option>
              <option value="date" <?= ($edit_field && $edit_field['field_type'] === 'date') ? 'selected' : '' ?>>Date Picker</option>
              <option value="textarea" <?= ($edit_field && $edit_field['field_type'] === 'textarea') ? 'selected' : '' ?>>Text Area</option>
            </select>
          </div>

          <div class="col-md-2 col-6 d-flex align-items-center pt-3">
            <div class="form-check form-switch mt-2">
              <input class="form-check-input" type="checkbox" name="is_required" id="isReqSwitch" value="1" <?= (!empty($edit_field['is_required'])) ? 'checked' : '' ?>>
              <label class="form-check-label small fw-bold" for="isReqSwitch">Mandatory</label>
            </div>
          </div>
        </div>

        <div class="d-flex align-items-center gap-2">
          <button type="submit" class="btn btn-primary px-4 fw-bold">
            <i class="bi bi-check2-circle me-1"></i> <?= $edit_field ? 'Update Field' : 'Save Custom Field' ?>
          </button>
          <?php if ($edit_field): ?>
            <a href="patient_types.php?tab=fields" class="btn btn-outline-secondary">Cancel</a>
          <?php endif; ?>
        </div>
      </form>
    </div>

    <!-- All Fields List -->
    <div class="studio-card">
      <div class="studio-card-title">
        <span><i class="bi bi-card-checklist text-primary me-2"></i> All Configured Dynamic Registration Fields (<?= $total_fields ?>)</span>
      </div>

      <div class="studio-table-wrapper">
        <table class="studio-table">
          <thead>
            <tr>
              <th width="5%">#</th>
              <th width="25%">Field Label</th>
              <th width="25%">Belongs to Category</th>
              <th width="18%">Data Type</th>
              <th width="12%">Requirement</th>
              <th width="15%" class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($fields_res && $fields_res->num_rows > 0): ?>
              <?php $si = 1; while ($f = $fields_res->fetch_assoc()): ?>
                <tr>
                  <td class="text-muted font-monospace"><?= $si++ ?></td>
                  <td>
                    <strong class="text-dark"><?= htmlspecialchars($f['field_label']) ?></strong>
                    <div class="small text-muted font-monospace">code: <?= htmlspecialchars($f['field_name']) ?></div>
                  </td>
                  <td>
                    <span class="badge bg-light text-primary border font-monospace">
                      <?= htmlspecialchars($f['type_name']) ?>
                    </span>
                  </td>
                  <td>
                    <span class="badge bg-secondary bg-opacity-10 text-secondary border font-monospace">
                      <?= strtoupper(htmlspecialchars($f['field_type'])) ?>
                    </span>
                  </td>
                  <td>
                    <?php if ($f['is_required']): ?>
                      <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">Mandatory</span>
                    <?php else: ?>
                      <span class="badge bg-light text-muted border">Optional</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-end">
                    <div class="d-flex align-items-center justify-content-end gap-1">
                      <a href="patient_types.php?tab=fields&edit_field=<?= $f['field_id'] ?>" class="btn btn-sm btn-outline-warning" title="Edit Field">
                        <i class="bi bi-pencil"></i>
                      </a>
                      <a href="patient_types.php?delete_field=<?= $f['field_id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete field \'<?= htmlspecialchars(addslashes($f['field_label'])) ?>\'?')" title="Delete Field">
                        <i class="bi bi-trash"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center py-4 text-muted">No custom dynamic registration fields created yet.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  <?php endif; ?>

</div>

</body>
</html>
