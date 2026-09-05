<?php
/**
 * Test Packages & Preventive Health Checkups Master
 * - Complete package creation & editing with multi-test assignment
 * - Live MRP vs Package Price calculation with savings percentage
 * - Detailed breakdown of tests inside each package
 * - Modern medical studio layout with light placeholders
 */
include_once 'auth_check.php';
include_once 'db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$edit = false;
$package = [];
$selected_tests = [];

// 1. Handle Delete
if (isset($_GET['delete'])) {
    $del_id = (int)$_GET['delete'];
    if ($del_id > 0) {
        $conn->query("DELETE FROM package_test_map WHERE package_id = $del_id");
        $conn->query("DELETE FROM test_packages WHERE package_id = $del_id");
        $_SESSION['alert'] = ['type' => 'danger', 'msg' => 'Test package deleted successfully.'];
    }
    header("Location: test_packages.php");
    exit;
}

// 2. Handle Form Submission (Add or Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['package_name'] ?? '');
    $code  = trim($_POST['package_code'] ?? '');
    $price = (float)($_POST['package_price'] ?? 0);
    $notes = trim($_POST['notes'] ?? '');
    $tests = $_POST['tests'] ?? [];

    if (!empty($name)) {
        if (isset($_POST['package_id']) && (int)$_POST['package_id'] > 0) {
            // Update
            $pkg_id = (int)$_POST['package_id'];
            $stmt = $conn->prepare("UPDATE test_packages SET package_name=?, package_code=?, package_price=?, notes=? WHERE package_id=?");
            $stmt->bind_param("ssdsi", $name, $code, $price, $notes, $pkg_id);
            $stmt->execute();
            $stmt->close();

            $conn->query("DELETE FROM package_test_map WHERE package_id = $pkg_id");
            $_SESSION['alert'] = ['type' => 'success', 'msg' => "Package '{$name}' updated successfully."];
        } else {
            // Insert
            $stmt = $conn->prepare("INSERT INTO test_packages (package_name, package_code, package_price, notes) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssds", $name, $code, $price, $notes);
            $stmt->execute();
            $pkg_id = $stmt->insert_id;
            $stmt->close();
            $_SESSION['alert'] = ['type' => 'success', 'msg' => "Package '{$name}' created successfully."];
        }

        // Insert mapped tests
        if (!empty($tests) && is_array($tests)) {
            $m_stmt = $conn->prepare("INSERT INTO package_test_map (package_id, test_id) VALUES (?, ?)");
            foreach ($tests as $t_id) {
                $tid = (int)$t_id;
                if ($tid > 0) {
                    $m_stmt->bind_param("ii", $pkg_id, $tid);
                    $m_stmt->execute();
                }
            }
            $m_stmt->close();
        }
    } else {
        $_SESSION['alert'] = ['type' => 'danger', 'msg' => 'Please provide a valid package name.'];
    }

    header("Location: test_packages.php");
    exit;
}

// 3. Handle Edit Load
if (isset($_GET['edit'])) {
    $edit = true;
    $id = (int)$_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM test_packages WHERE package_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $package = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($package) {
        $res = $conn->query("SELECT test_id FROM package_test_map WHERE package_id = $id");
        while ($row = $res->fetch_assoc()) {
            $selected_tests[] = (int)$row['test_id'];
        }
    }
}

// 4. Fetch All Available Lab Tests for Assignment
$all_tests = [];
$t_query = $conn->query("
    SELECT t.test_id, t.test_name, t.test_code, t.price, c.category_name 
    FROM lab_tests t 
    LEFT JOIN test_categories c ON t.category_id = c.category_id 
    ORDER BY c.category_name ASC, t.test_name ASC
");
if ($t_query) {
    while ($tr = $t_query->fetch_assoc()) {
        $all_tests[] = $tr;
    }
}

// 5. Fetch All Packages with Details of Mapped Tests
$packages_list = [];
$pk_res = $conn->query("SELECT * FROM test_packages ORDER BY package_name ASC");
if ($pk_res) {
    while ($pk = $pk_res->fetch_assoc()) {
        $pid = (int)$pk['package_id'];
        $m_tests = [];
        $sum_mrp = 0.0;
        $mp_res = $conn->query("
            SELECT t.test_id, t.test_name, t.price, c.category_name 
            FROM package_test_map m
            JOIN lab_tests t ON m.test_id = t.test_id
            LEFT JOIN test_categories c ON t.category_id = c.category_id
            WHERE m.package_id = $pid
            ORDER BY t.test_name ASC
        ");
        if ($mp_res) {
            while ($m = $mp_res->fetch_assoc()) {
                $m_tests[] = $m;
                $sum_mrp += (float)$m['price'];
            }
        }
        $pk['tests'] = $m_tests;
        $pk['mrp'] = $sum_mrp;
        $pk['savings'] = max(0, $sum_mrp - (float)$pk['package_price']);
        $pk['discount_pct'] = $sum_mrp > 0 ? round(($pk['savings'] / $sum_mrp) * 100) : 0;
        $packages_list[] = $pk;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Health Packages Master | Clinical Laboratory ERP</title>
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
    .pkg-header-card {
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
    .pkg-title {
      font-size: 1.35rem;
      font-weight: 800;
      color: var(--text-main);
      margin: 0;
      display: flex;
      align-items: center;
      gap: 10px;
      letter-spacing: -0.3px;
    }

    /* Section Cards */
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
      background-color: #ffffff;
    }
    .form-control:focus, .form-select:focus {
      border-color: var(--brand-primary);
      box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.12);
    }

    /* Test Selector Box */
    .test-selector-card {
      background: #f8fafc;
      border: 1px solid var(--border-color);
      border-radius: 12px;
      padding: 16px;
      max-height: 380px;
      overflow-y: auto;
    }
    .test-checkbox-item {
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 8px;
      padding: 9px 13px;
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      cursor: pointer;
      transition: all 0.15s ease;
    }
    .test-checkbox-item:hover {
      background: #f0f9ff;
      border-color: #bae6fd;
    }

    /* Package Table */
    .pkg-table-wrapper {
      border: 1px solid var(--border-color);
      border-radius: 12px;
      overflow: hidden;
      background: #ffffff;
    }
    .pkg-table {
      width: 100%;
      border-collapse: collapse;
      margin: 0;
    }
    .pkg-table th {
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
    .pkg-table td {
      padding: 12px 16px;
      vertical-align: middle;
      border-bottom: 1px solid var(--border-light);
      font-size: 0.88rem;
    }
    .pkg-table tr:last-child td {
      border-bottom: none;
    }
    .pkg-table tr:hover td {
      background-color: #fafbfc;
    }

    /* Savings and MRP badges */
    .mrp-strike {
      text-decoration: line-through;
      color: #94a3b8;
      font-size: 0.78rem;
      font-family: 'JetBrains Mono', monospace;
    }
    .savings-badge {
      background: #ecfdf5;
      color: #047857;
      border: 1px solid #a7f3d0;
      font-size: 0.72rem;
      font-weight: 700;
      padding: 2px 7px;
      border-radius: 12px;
      display: inline-block;
    }
  </style>
</head>
<body>

<?php include_once __DIR__ . '/header.php'; ?>

<div class="page-container">

  <!-- Header Card -->
  <div class="pkg-header-card">
    <div>
      <h1 class="pkg-title">
        <i class="bi bi-box-seam text-primary"></i> Test Packages Master
      </h1>
      <div class="text-muted small mt-1">
        Configure bundled diagnostic health checkup packages with multi-test inclusion and patient savings.
      </div>
    </div>
    <div class="d-flex align-items-center gap-2">
      <a href="rate_card.php" class="btn btn-outline-secondary btn-sm fw-semibold">
        <i class="bi bi-file-earmark-spreadsheet me-1"></i> View Rate Card
      </a>
      <a href="bill_add.php" class="btn btn-outline-primary btn-sm fw-semibold">
        <i class="bi bi-receipt me-1"></i> New Bill
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

  <!-- Row 1: Add / Edit Package Form -->
  <div class="studio-card">
    <div class="studio-card-title">
      <span>
        <i class="bi <?= $edit ? 'bi-pencil-square text-warning' : 'bi-plus-circle-fill text-primary' ?> me-2"></i>
        <?= $edit ? 'Edit Test Package #' . htmlspecialchars($package['package_id']) : 'Create New Health Checkup Package' ?>
      </span>
      <?php if ($edit): ?>
        <a href="test_packages.php" class="btn btn-outline-secondary btn-sm">
          <i class="bi bi-x-lg me-1"></i> Cancel Edit
        </a>
      <?php endif; ?>
    </div>

    <form method="POST" action="test_packages.php" id="packageForm">
      <?php if ($edit): ?>
        <input type="hidden" name="package_id" value="<?= $package['package_id'] ?>">
      <?php endif; ?>

      <div class="row g-3 mb-3">
        <div class="col-md-5 col-12">
          <label class="form-label">Package Name <span class="text-danger">*</span></label>
          <input type="text" name="package_name" class="form-control fw-bold" placeholder="e.g. Master Health Checkup, Executive Cardiac Profile" required value="<?= htmlspecialchars($package['package_name'] ?? '') ?>">
        </div>

        <div class="col-md-3 col-6">
          <label class="form-label">Package Code <span class="text-danger">*</span></label>
          <input type="text" name="package_code" class="form-control font-monospace" placeholder="e.g. MHC-01" required value="<?= htmlspecialchars($package['package_code'] ?? '') ?>">
        </div>

        <div class="col-md-4 col-6">
          <label class="form-label">Offer / Package Price (₹) <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text bg-light text-muted">₹</span>
            <input type="number" step="0.01" name="package_price" id="packagePriceInput" class="form-control font-monospace fw-bold" placeholder="0.00" required value="<?= htmlspecialchars($package['package_price'] ?? '') ?>" oninput="recalcSavings()">
          </div>
        </div>

        <div class="col-12">
          <label class="form-label">Description / Instructions</label>
          <textarea name="notes" class="form-control" rows="2" placeholder="e.g. 10-12 hrs fasting required. Complete screening of liver, kidney, heart & diabetes."><?= htmlspecialchars($package['notes'] ?? '') ?></textarea>
        </div>
      </div>

      <!-- Tests Selection Section with Live MRP Calculator -->
      <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
          <div>
            <label class="form-label mb-0">Select Included Laboratory Tests</label>
            <small class="text-muted">Check tests to include in this package bundle</small>
          </div>
          <!-- Live Savings & MRP Indicator -->
          <div class="d-flex align-items-center gap-3 bg-light border rounded-3 px-3 py-2">
            <div>
              <span class="small text-muted text-uppercase">Tests Selected:</span>
              <strong id="selectedTestsCount" class="text-primary font-monospace">0</strong>
            </div>
            <div class="border-start ps-3">
              <span class="small text-muted text-uppercase">Total MRP:</span>
              <strong class="font-monospace text-dark">₹ <span id="selectedTestsMrp">0.00</span></strong>
            </div>
            <div class="border-start ps-3" id="savingsContainer" style="display:none;">
              <span class="badge bg-success font-monospace" id="savingsBadgeText">Save 0%</span>
            </div>
          </div>
        </div>

        <!-- Quick filter box for tests -->
        <div class="input-group mb-2">
          <span class="input-group-text bg-light text-muted"><i class="bi bi-search"></i></span>
          <input type="text" id="testSearchInput" class="form-control" placeholder="Quickly filter tests by name or department..." oninput="filterTestCheckboxes()">
        </div>

        <!-- Scrollable Test Checkbox Grid -->
        <div class="test-selector-card">
          <div class="row g-2" id="testCheckboxList">
            <?php foreach ($all_tests as $t): ?>
              <?php $is_checked = in_array((int)$t['test_id'], $selected_tests); ?>
              <div class="col-md-4 col-sm-6 col-12 test-cb-wrapper" data-name="<?= strtolower(htmlspecialchars($t['test_name'])) ?>" data-cat="<?= strtolower(htmlspecialchars($t['category_name'] ?? '')) ?>">
                <label class="test-checkbox-item">
                  <div class="form-check mb-0">
                    <input class="form-check-input test-check" type="checkbox" name="tests[]" value="<?= $t['test_id'] ?>" data-price="<?= (float)$t['price'] ?>" <?= $is_checked ? 'checked' : '' ?> onchange="recalcSavings()">
                    <span class="form-check-label fw-semibold text-dark small ms-1">
                      <?= htmlspecialchars($t['test_name']) ?>
                    </span>
                    <div class="text-muted" style="font-size: 0.72rem; margin-left: 1.5rem;">
                      <?= htmlspecialchars($t['category_name'] ?: 'Pathology') ?>
                    </div>
                  </div>
                  <span class="badge bg-light text-secondary border font-monospace small">
                    ₹<?= number_format((float)$t['price'], 2) ?>
                  </span>
                </label>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <div class="d-flex align-items-center gap-2">
        <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm">
          <i class="bi bi-check2-circle me-1"></i> <?= $edit ? 'Update Package' : 'Save New Package' ?>
        </button>
        <?php if ($edit): ?>
          <a href="test_packages.php" class="btn btn-outline-secondary px-3">Cancel</a>
        <?php endif; ?>
      </div>
    </form>
  </div>

  <!-- Row 2: All Configured Packages Table -->
  <div class="studio-card">
    <div class="studio-card-title">
      <span><i class="bi bi-collection-fill text-primary me-2"></i> All Active Health Packages (<?= count($packages_list) ?>)</span>
    </div>

    <div class="pkg-table-wrapper">
      <table class="pkg-table">
        <thead>
          <tr>
            <th width="15%">Package Name</th>
            <th width="8%">Code</th>
            <th width="42%">Included Tests Breakdown</th>
            <th width="12%">Package Price (₹)</th>
            <th width="13%">Total MRP & Savings</th>
            <th width="10%" class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($packages_list)): ?>
            <?php foreach ($packages_list as $pk): ?>
              <tr>
                <td>
                  <div class="fw-bold text-dark"><?= htmlspecialchars($pk['package_name']) ?></div>
                  <?php if (!empty($pk['notes'])): ?>
                    <div class="small text-muted text-truncate" style="max-width: 200px;" title="<?= htmlspecialchars($pk['notes']) ?>">
                      <?= htmlspecialchars($pk['notes']) ?>
                    </div>
                  <?php endif; ?>
                </td>
                <td>
                  <span class="badge bg-light text-secondary border font-monospace">
                    <?= htmlspecialchars($pk['package_code']) ?>
                  </span>
                </td>
                <td>
                  <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge bg-primary bg-opacity-10 text-primary fw-bold">
                      <?= count($pk['tests']) ?> Tests Included
                    </span>
                  </div>
                  <!-- Pills of all tests -->
                  <div class="d-flex flex-wrap gap-1">
                    <?php foreach ($pk['tests'] as $pt): ?>
                      <span class="badge bg-light text-dark border font-monospace small py-1 px-2" title="Price: ₹<?= number_format($pt['price'], 2) ?>">
                        <?= htmlspecialchars($pt['test_name']) ?>
                      </span>
                    <?php endforeach; ?>
                  </div>
                </td>
                <td>
                  <div class="fw-bold text-primary font-monospace" style="font-size: 1.1rem;">
                    ₹ <?= number_format($pk['package_price'], 2) ?>
                  </div>
                </td>
                <td>
                  <?php if ($pk['mrp'] > 0): ?>
                    <div><span class="mrp-strike">MRP: ₹<?= number_format($pk['mrp'], 2) ?></span></div>
                    <?php if ($pk['savings'] > 0): ?>
                      <div class="savings-badge mt-1">
                        <i class="bi bi-tag-fill me-1"></i>Save <?= $pk['discount_pct'] ?>% (₹<?= number_format($pk['savings'], 0) ?>)
                      </div>
                    <?php endif; ?>
                  <?php else: ?>
                    <span class="text-muted small">N/A</span>
                  <?php endif; ?>
                </td>
                <td class="text-end">
                  <div class="d-flex align-items-center justify-content-end gap-1">
                    <a href="test_packages.php?edit=<?= $pk['package_id'] ?>" class="btn btn-sm btn-outline-warning" title="Edit Package">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <a href="test_packages.php?delete=<?= $pk['package_id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete package \'<?= htmlspecialchars(addslashes($pk['package_name'])) ?>\'?')" title="Delete Package">
                      <i class="bi bi-trash"></i>
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center py-5">
                <i class="bi bi-box-seam fa-3x text-muted mb-2 d-block opacity-50"></i>
                <h6 class="fw-bold text-secondary">No Test Packages Configured</h6>
                <p class="small text-muted mb-0">Use the form above to create bundled health checkup packages.</p>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function filterTestCheckboxes() {
  const searchInput = document.getElementById('testSearchInput');
  const q = searchInput ? searchInput.value.toLowerCase().trim() : '';
  document.querySelectorAll('.test-cb-wrapper').forEach(function(el) {
    const name = (el.getAttribute('data-name') || '').toLowerCase();
    const cat = (el.getAttribute('data-cat') || '').toLowerCase();
    if (!q || name.includes(q) || cat.includes(q)) {
      el.style.display = '';
    } else {
      el.style.display = 'none';
    }
  });
}

function recalcSavings() {
  let count = 0;
  let totalMrp = 0.0;

  document.querySelectorAll('.test-check:checked').forEach(function(el) {
    count++;
    totalMrp += parseFloat(el.getAttribute('data-price')) || 0;
  });

  const countEl = document.getElementById('selectedTestsCount');
  const mrpEl = document.getElementById('selectedTestsMrp');
  if (countEl) countEl.innerText = count;
  if (mrpEl) mrpEl.innerText = totalMrp.toFixed(2);

  const pkgPriceInput = document.getElementById('packagePriceInput');
  const pkgPrice = parseFloat(pkgPriceInput ? pkgPriceInput.value : 0) || 0;
  const savings = totalMrp - pkgPrice;

  const savingsContainer = document.getElementById('savingsContainer');
  const savingsBadgeText = document.getElementById('savingsBadgeText');
  if (totalMrp > 0 && pkgPrice > 0 && savings > 0) {
    const pct = Math.round((savings / totalMrp) * 100);
    if (savingsBadgeText) savingsBadgeText.innerText = 'Save ' + pct + '% (₹' + savings.toFixed(0) + ')';
    if (savingsContainer) savingsContainer.style.display = '';
  } else {
    if (savingsContainer) savingsContainer.style.display = 'none';
  }
}

document.addEventListener('DOMContentLoaded', recalcSavings);
</script>

</body>
</html>
