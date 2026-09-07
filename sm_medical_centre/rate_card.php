<?php
/**
 * Professional Diagnostic Laboratory Rate Card & Investigation Catalog
 * - Complete test tariff directory grouped by clinical department / category
 * - Live in-place editable rates for individual tests & health packages
 * - Bulk tariff adjustment modal (percentage increase/decrease & flat revisions)
 * - Detailed parameter breakdown with units and biological reference intervals
 * - Health Packages catalog with included tests and live savings calculation
 * - Neat printable & PDF-ready format for patient tariff display and doctor referrals
 */
include_once 'auth_check.php';
include_once 'db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Handle Direct AJAX Rate Updates if called on this script
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    $action = $_POST['action'];

    if ($action === 'update_single') {
        $type = trim($_POST['type'] ?? 'test');
        $id = (int)($_POST['id'] ?? 0);
        $price = isset($_POST['price']) ? (float)$_POST['price'] : -1;

        if ($id <= 0 || $price < 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid ID or rate amount.']);
            exit;
        }

        if ($type === 'package') {
            $stmt = $conn->prepare("UPDATE test_packages SET package_price = ? WHERE package_id = ?");
            $stmt->bind_param("di", $price, $id);
            $stmt->execute();
            $stmt->close();
            echo json_encode(['success' => true, 'type' => 'package', 'id' => $id, 'price' => $price, 'formatted_price' => number_format($price, 2)]);
            exit;
        } else {
            $stmt = $conn->prepare("UPDATE lab_tests SET price = ? WHERE test_id = ?");
            $stmt->bind_param("di", $price, $id);
            $stmt->execute();
            $stmt->close();
            echo json_encode(['success' => true, 'type' => 'test', 'id' => $id, 'price' => $price, 'formatted_price' => number_format($price, 2)]);
            exit;
        }
    }
}

// 1. Fetch Lab Branding Details
$lab_info = [
    'company_name'    => 'Diagnostic Centre ERP',
    'company_address' => 'Main Road, Healthcare Complex',
    'phone'           => '+91 98765 43210',
    'email'           => 'contact@pathlab.com',
    'reg_no'          => 'REG-LAB-2025'
];
$adm_q = $conn->query("SELECT * FROM admin_settings WHERE id = 1 LIMIT 1");
if ($adm_q && $ar = $adm_q->fetch_assoc()) {
    $lab_info = array_merge($lab_info, array_filter($ar));
}

// Dynamic logo search
$logo_file = null;
foreach (['qrtemp/logo.jpg', 'uploads/logo.jpg', 'uploads/logo.png', 'logo.png', 'logo.jpg'] as $lp) {
    if (file_exists(__DIR__ . '/' . $lp)) {
        $logo_file = $lp;
        break;
    }
}

// 2. Fetch Categories / Departments
$categories = [];
$cat_q = $conn->query("SELECT * FROM test_categories ORDER BY category_name ASC");
if ($cat_q) {
    while ($c = $cat_q->fetch_assoc()) {
        $categories[$c['category_id']] = $c['category_name'];
    }
}

// 3. Fetch All Tests with Category and Included Parameters
$tests_by_cat = [];
$all_tests_query = "
    SELECT t.test_id, t.test_name, t.test_code, t.category_id, t.price, t.notes,
           COALESCE(c.category_name, 'General Pathology') as category_name
    FROM lab_tests t
    LEFT JOIN test_categories c ON t.category_id = c.category_id
    ORDER BY c.category_name ASC, t.test_name ASC
";
$tests_res = $conn->query($all_tests_query);

// Pre-fetch parameters for all tests
$test_parameters = [];
$param_q = $conn->query("
    SELECT ltp.test_id, p.param_name, p.unit, p.method,
           r.male_min, r.male_max, r.female_min, r.female_max, r.reference_text, r.use_reference_text
    FROM lab_test_parameters ltp
    JOIN test_parameters p ON ltp.parameter_id = p.parameter_id
    LEFT JOIN parameter_reference_ranges r ON p.parameter_id = r.parameter_id
    ORDER BY ltp.test_id, ltp.sort_order ASC, p.param_name ASC
");
if ($param_q) {
    while ($p = $param_q->fetch_assoc()) {
        $test_parameters[$p['test_id']][] = $p;
    }
}

if ($tests_res) {
    while ($row = $tests_res->fetch_assoc()) {
        $cat = $row['category_name'];
        $row['parameters'] = $test_parameters[$row['test_id']] ?? [];
        $tests_by_cat[$cat][] = $row;
    }
}

$total_tests_count = array_sum(array_map('count', $tests_by_cat));

// 4. Fetch All Health Packages with Included Tests
$packages = [];
$pkg_q = $conn->query("SELECT * FROM test_packages ORDER BY package_name ASC");
if ($pkg_q) {
    while ($pk = $pkg_q->fetch_assoc()) {
        $pkg_id = (int)$pk['package_id'];
        $p_tests = [];
        $total_mrp = 0.0;
        $pt_q = $conn->query("
            SELECT t.test_id, t.test_name, t.price 
            FROM package_test_map m
            JOIN lab_tests t ON m.test_id = t.test_id
            WHERE m.package_id = $pkg_id
            ORDER BY t.test_name ASC
        ");
        if ($pt_q) {
            while ($pt = $pt_q->fetch_assoc()) {
                $p_tests[] = $pt;
                $total_mrp += (float)$pt['price'];
            }
        }
        $pk['tests'] = $p_tests;
        $pk['total_mrp'] = $total_mrp;
        $pk['savings'] = max(0, $total_mrp - (float)$pk['package_price']);
        $pk['discount_pct'] = $total_mrp > 0 ? round(($pk['savings'] / $total_mrp) * 100) : 0;
        $packages[] = $pk;
    }
}

// Tube recommendation helper
function getTestTubeBadge($test_name) {
    $str = strtolower($test_name);
    if (preg_match('/(cbc|hemogram|edta|hba1c|esr|platelet|blood group|wbc|rbc|malaria)/i', $str)) {
        return '<span class="tube-pill tube-edta" title="Lavender Tube"><span class="dot"></span>EDTA (Whole Blood)</span>';
    }
    if (preg_match('/(sugar|glucose|fbs|ppbs|rbs|gtt)/i', $str)) {
        return '<span class="tube-pill tube-fluoride" title="Grey Tube"><span class="dot"></span>Fluoride (Plasma)</span>';
    }
    if (preg_match('/(pt|inr|aptt|citrate|d-dimer)/i', $str)) {
        return '<span class="tube-pill tube-citrate" title="Blue Tube"><span class="dot"></span>Citrate (Plasma)</span>';
    }
    if (preg_match('/(urine|routine|microscopy|culture|stool|semen)/i', $str)) {
        return '<span class="tube-pill tube-urine" title="Sterile Cup"><span class="dot"></span>Sterile Container</span>';
    }
    return '<span class="tube-pill tube-sst" title="Yellow/Red Tube"><span class="dot"></span>SST / Serum (Plain)</span>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rate Card & Pathology Tariff | <?= htmlspecialchars($lab_info['company_name']) ?></title>
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
    ::placeholder,
    ::-webkit-input-placeholder,
    :-moz-placeholder,
    ::-moz-placeholder,
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
    .catalog-header-card {
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 14px;
      padding: 20px 26px;
      box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.04);
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 22px;
      flex-wrap: wrap;
      gap: 14px;
    }
    .catalog-title {
      font-size: 1.35rem;
      font-weight: 800;
      color: var(--text-main);
      margin: 0;
      display: flex;
      align-items: center;
      gap: 10px;
      letter-spacing: -0.3px;
    }
    .catalog-subtitle {
      font-size: 0.83rem;
      color: var(--text-muted);
      margin-top: 4px;
    }

    /* Nav Tabs */
    .catalog-tabs {
      display: flex;
      background: #f1f5f9;
      padding: 4px;
      border-radius: 10px;
      border: 1px solid var(--border-color);
      margin-bottom: 20px;
      gap: 4px;
      width: fit-content;
    }
    .catalog-tab-btn {
      padding: 8px 20px;
      font-size: 0.88rem;
      font-weight: 700;
      color: #64748b;
      border: none;
      background: transparent;
      border-radius: 8px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: all 0.2s ease;
    }
    .catalog-tab-btn.active {
      background: #ffffff;
      color: var(--brand-primary);
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    /* Filters Card */
    .filter-card {
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 12px;
      padding: 14px 18px;
      margin-bottom: 20px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }

    /* Department Sections */
    .dept-card {
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 14px;
      margin-bottom: 24px;
      box-shadow: 0 4px 16px rgba(15, 23, 42, 0.03);
      overflow: hidden;
    }
    .dept-header {
      background: linear-gradient(to right, #f8fafc, #ffffff);
      padding: 14px 22px;
      border-bottom: 1px solid var(--border-color);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .dept-title {
      font-size: 1.08rem;
      font-weight: 700;
      color: var(--brand-dark);
      margin: 0;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    /* Catalog Table */
    .catalog-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
    }
    .catalog-table th {
      background: #f8fafc;
      color: #475569;
      font-size: 0.78rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.6px;
      padding: 12px 18px;
      border-bottom: 1px solid var(--border-color);
    }
    .catalog-table td {
      padding: 12px 18px;
      vertical-align: middle;
      border-bottom: 1px solid var(--border-light);
      font-size: 0.88rem;
    }
    .catalog-table tr:last-child td {
      border-bottom: none;
    }
    .catalog-table tr:hover td {
      background-color: #f8fafc;
    }

    /* Tube Indicator Pills */
    .tube-pill {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 3px 9px;
      border-radius: 20px;
      font-size: 0.73rem;
      font-weight: 700;
      letter-spacing: 0.2px;
    }
    .tube-pill .dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
    }
    .tube-edta { background: #f3e8ff; color: #7c3aed; border: 1px solid #ddd6fe; }
    .tube-edta .dot { background: #7c3aed; }
    .tube-sst { background: #fef9c3; color: #a16207; border: 1px solid #fef08a; }
    .tube-sst .dot { background: #ca8a04; }
    .tube-fluoride { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
    .tube-fluoride .dot { background: #64748b; }
    .tube-citrate { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
    .tube-citrate .dot { background: #0284c7; }
    .tube-urine { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
    .tube-urine .dot { background: #10b981; }

    /* Parameters Details */
    .param-pill-badge {
      font-size: 0.72rem;
      font-weight: 600;
      background: #f1f5f9;
      color: #334155;
      padding: 2px 7px;
      border-radius: 4px;
      border: 1px solid #e2e8f0;
      display: inline-block;
      margin: 1px 2px;
    }

    /* In-place Editable Rate Styling */
    .rate-edit-wrap {
      position: relative;
    }
    .rate-input-group {
      width: 142px;
      border-radius: 8px;
      transition: all 0.2s ease;
    }
    .rate-input-group:focus-within {
      box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.18);
      border-color: var(--brand-primary);
    }
    .rate-input {
      font-family: 'JetBrains Mono', monospace;
      font-weight: 700;
      font-size: 0.95rem;
      color: var(--brand-dark);
      background-color: #ffffff;
      padding-right: 6px;
    }
    .rate-input:focus {
      background-color: #f0f9ff;
    }
    .btn-rate-save {
      font-size: 0.75rem;
      transition: all 0.2s;
    }
    .rate-saved-flash {
      background-color: #dcfce7 !important;
      border-color: #86efac !important;
      transition: background-color 0.5s ease;
    }
    .rate-saved-icon {
      color: #10b981;
      font-size: 0.85rem;
      margin-left: 4px;
      display: inline-block;
      animation: fadeIn 0.3s ease;
    }

    /* Package Grid Cards */
    .pkg-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
      gap: 20px;
    }
    .pkg-card {
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 14px;
      padding: 22px;
      box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .pkg-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
      border-color: #cbd5e1;
    }
    .pkg-badge {
      font-size: 0.72rem;
      font-weight: 800;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      background: #e0f2fe;
      color: #0369a1;
      padding: 3px 8px;
      border-radius: 6px;
    }
    .pkg-price-box {
      background: #f8fafc;
      border: 1px solid var(--border-color);
      border-radius: 10px;
      padding: 14px 16px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: 16px;
      gap: 12px;
    }
    .pkg-mrp {
      text-decoration: line-through;
      color: #94a3b8;
      font-size: 0.85rem;
    }
    .pkg-savings-pill {
      background: #ecfdf5;
      color: #047857;
      border: 1px solid #a7f3d0;
      font-size: 0.72rem;
      font-weight: 700;
      padding: 4px 9px;
      border-radius: 12px;
      display: inline-block;
    }

    /* Toast Notification */
    #rateToast {
      position: fixed;
      bottom: 24px;
      right: 24px;
      z-index: 9999;
      min-width: 300px;
      display: none;
    }

    /* Print Specific Styling */
    @media print {
      body {
        background: #ffffff !important;
        font-size: 9pt !important;
        padding: 0 !important;
      }
      .no-print, .catalog-tabs, .filter-card, .btn, .rate-edit-wrap, .modal, .phleb-header-card .d-flex {
        display: none !important;
      }
      .print-rate-display {
        display: inline-block !important;
        font-weight: 700 !important;
        font-family: 'JetBrains Mono', monospace !important;
      }
      .page-container {
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
      }
      .dept-card {
        border: 1px solid #000 !important;
        box-shadow: none !important;
        margin-bottom: 15px !important;
        page-break-inside: avoid;
      }
      .dept-header {
        background: #eee !important;
        border-bottom: 1px solid #000 !important;
        padding: 6px 10px !important;
      }
      .catalog-table th {
        background: #f0f0f0 !important;
        border-bottom: 1px solid #000 !important;
        padding: 4px 8px !important;
      }
      .catalog-table td {
        padding: 4px 8px !important;
        border-bottom: 0.5pt solid #ddd !important;
      }
      .print-header {
        display: block !important;
        margin-bottom: 15px;
        border-bottom: 2px solid #0284c7;
        padding-bottom: 8px;
      }
    }
    .print-header {
      display: none;
    }
    .print-rate-display {
      display: none;
    }
  </style>
</head>
<body>

<?php include_once __DIR__ . '/header.php'; ?>

<div class="page-container">

  <!-- Printable Header (Only in window.print) -->
  <div class="print-header">
    <div class="d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center gap-3">
        <?php if ($logo_file): ?>
          <img src="<?= htmlspecialchars($logo_file) ?>" alt="Logo" style="max-height: 55px; max-width: 55px; object-fit: contain;">
        <?php endif; ?>
        <div>
          <h3 class="fw-bold mb-0 text-primary"><?= htmlspecialchars($lab_info['company_name']) ?></h3>
          <div class="small text-muted"><?= htmlspecialchars($lab_info['company_address']) ?> &bull; Ph: <?= htmlspecialchars($lab_info['phone']) ?></div>
        </div>
      </div>
      <div class="text-end">
        <h5 class="fw-bold text-uppercase mb-0 text-dark">Official Pathology Tariff</h5>
        <div class="small text-muted">Effective: <?= date('F Y') ?></div>
      </div>
    </div>
  </div>

  <!-- Screen Studio Header -->
  <div class="catalog-header-card no-print">
    <div>
      <h1 class="catalog-title">
        <i class="bi bi-file-earmark-spreadsheet text-primary"></i> Pathology Rate Card & Tariff Studio
      </h1>
      <div class="catalog-subtitle">
        Official diagnostic price catalog with live in-place editable rates, tube requirements, parameter specifications, and bulk tariff adjustment.
      </div>
    </div>
    <div class="d-flex align-items-center gap-2">
      <button class="btn btn-outline-secondary btn-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#bulkRateModal">
        <i class="bi bi-sliders me-1 text-primary"></i> Bulk Adjust Rates
      </button>
      <a href="bill_add.php" class="btn btn-outline-primary btn-sm fw-semibold">
        <i class="bi bi-receipt me-1"></i> New Invoice
      </a>
      <button onclick="window.print()" class="btn btn-primary btn-sm fw-bold px-3 shadow-sm">
        <i class="bi bi-printer-fill me-1"></i> Print Rate Card
      </button>
    </div>
  </div>

  <!-- Dual View Tabs -->
  <div class="catalog-tabs no-print">
    <button type="button" class="catalog-tab-btn active" onclick="switchCatalogTab('tests')">
      <i class="bi bi-list-check"></i> Individual Tests (<?= $total_tests_count ?>)
    </button>
    <button type="button" class="catalog-tab-btn" onclick="switchCatalogTab('packages')">
      <i class="bi bi-box-seam"></i> Health Packages (<?= count($packages) ?>)
    </button>
  </div>

  <!-- Search & Filter Controls -->
  <div class="filter-card no-print">
    <div class="row g-2 align-items-center">
      <div class="col-md-5 col-12">
        <div class="input-group">
          <span class="input-group-text bg-light text-muted"><i class="bi bi-search"></i></span>
          <input type="text" id="catalogSearch" class="form-control" placeholder="Search test name, code, or parameter..." oninput="filterCatalog()">
        </div>
      </div>
      <div class="col-md-4 col-12">
        <select id="categoryFilter" class="form-select" onchange="filterCatalog()">
          <option value="">All Clinical Departments / Categories</option>
          <?php foreach ($categories as $cid => $cname): ?>
            <option value="<?= htmlspecialchars($cname) ?>"><?= htmlspecialchars($cname) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-3 col-12 text-md-end">
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle font-monospace py-2 px-3" title="Click any rate input to update price instantly">
          <i class="bi bi-lightning-charge-fill text-warning me-1"></i>Live Editable Rates
        </span>
      </div>
    </div>
  </div>

  <!-- SECTION 1: INDIVIDUAL TESTS DIRECTORY -->
  <div id="testsSection">
    <?php if (!empty($tests_by_cat)): ?>
      <?php foreach ($tests_by_cat as $cat_name => $cat_tests): ?>
        <div class="dept-card" data-category="<?= htmlspecialchars($cat_name) ?>">
          <div class="dept-header">
            <h2 class="dept-title">
              <i class="bi bi-journal-medical text-primary"></i> <?= htmlspecialchars($cat_name) ?>
            </h2>
            <span class="badge bg-light text-muted border font-monospace small"><?= count($cat_tests) ?> Tests</span>
          </div>
          <div class="table-responsive">
            <table class="catalog-table">
              <thead>
                <tr>
                  <th width="4%" class="text-center">#</th>
                  <th width="10%">Code</th>
                  <th width="28%">Investigation Name</th>
                  <th width="15%">Specimen / Tube</th>
                  <th width="25%">Included Parameters Details</th>
                  <th width="18%" class="text-end">Tariff Rate (₹)</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($cat_tests as $i => $t): ?>
                  <tr class="test-row" data-id="<?= $t['test_id'] ?>" data-name="<?= strtolower(htmlspecialchars($t['test_name'])) ?>" data-code="<?= strtolower(htmlspecialchars($t['test_code'] ?? '')) ?>">
                    <td class="text-center text-muted font-monospace small"><?= $i + 1 ?></td>
                    <td>
                      <span class="badge bg-light text-secondary border font-monospace">
                        <?= htmlspecialchars($t['test_code'] ?: 'TEST-'.$t['test_id']) ?>
                      </span>
                    </td>
                    <td>
                      <div class="fw-bold text-dark"><?= htmlspecialchars($t['test_name']) ?></div>
                      <?php if (!empty($t['notes'])): ?>
                        <div class="small text-muted fst-italic"><?= htmlspecialchars($t['notes']) ?></div>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?= getTestTubeBadge($t['test_name']) ?>
                    </td>
                    <td>
                      <?php if (!empty($t['parameters'])): ?>
                        <div class="d-flex flex-wrap gap-1">
                          <?php foreach ($t['parameters'] as $pm): ?>
                            <span class="param-pill-badge" title="<?= htmlspecialchars($pm['param_name']) ?><?= $pm['unit'] ? ' ('.$pm['unit'].')' : '' ?>">
                              <?= htmlspecialchars($pm['param_name']) ?>
                              <?php if (!empty($pm['unit'])): ?>
                                <small class="text-muted">(<?= htmlspecialchars($pm['unit']) ?>)</small>
                              <?php endif; ?>
                            </span>
                          <?php endforeach; ?>
                        </div>
                      <?php else: ?>
                        <span class="text-muted small">Single observation / Standard diagnostic report</span>
                      <?php endif; ?>
                    </td>
                    <td class="text-end">
                      <!-- Live Editable Rate Input for Screen -->
                      <div class="rate-edit-wrap d-inline-flex align-items-center justify-content-end gap-1">
                        <div class="input-group input-group-sm rate-input-group">
                          <span class="input-group-text bg-light text-muted fw-bold border-end-0">₹</span>
                          <input type="number" 
                                 step="0.01" 
                                 min="0" 
                                 class="form-control form-control-sm text-end fw-bold font-monospace border-start-0 border-end-0 rate-input" 
                                 data-type="test" 
                                 data-id="<?= $t['test_id'] ?>" 
                                 data-name="<?= htmlspecialchars($t['test_name']) ?>"
                                 data-original="<?= number_format((float)$t['price'], 2, '.', '') ?>" 
                                 value="<?= number_format((float)$t['price'], 2, '.', '') ?>"
                                 placeholder="0.00"
                                 onchange="saveRate(this)"
                                 onkeydown="if(event.key==='Enter'){this.blur();}">
                          <button class="btn btn-outline-primary btn-rate-save px-2" type="button" onclick="saveRate($(this).prev()[0])" title="Save Tariff">
                            <i class="fas fa-check"></i>
                          </button>
                        </div>
                        <span class="rate-status-icon" id="status-test-<?= $t['test_id'] ?>" style="width: 16px;"></span>
                      </div>
                      <!-- Clean display for Print / PDF -->
                      <span class="print-rate-display">
                        ₹ <?= number_format($t['price'], 2) ?>
                      </span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="alert alert-info text-center py-5">No laboratory tests currently listed in the database.</div>
    <?php endif; ?>
  </div>

  <!-- SECTION 2: HEALTH PACKAGES RATE CARD -->
  <div id="packagesSection" style="display: none;">
    <?php if (!empty($packages)): ?>
      <div class="pkg-grid">
        <?php foreach ($packages as $pkg): ?>
          <div class="pkg-card" data-name="<?= strtolower(htmlspecialchars($pkg['package_name'])) ?>">
            <div>
              <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="pkg-badge"><i class="bi bi-box-seam me-1"></i>Health Package</span>
                <span class="badge bg-light text-secondary border font-monospace"><?= htmlspecialchars($pkg['package_code']) ?></span>
              </div>
              <h4 class="fw-bold text-dark mb-1"><?= htmlspecialchars($pkg['package_name']) ?></h4>
              <?php if (!empty($pkg['notes'])): ?>
                <p class="small text-muted mb-3"><?= htmlspecialchars($pkg['notes']) ?></p>
              <?php endif; ?>

              <!-- Tests Included list -->
              <div class="border rounded-3 p-3 bg-light mb-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="small fw-bold text-uppercase text-secondary">Included Investigations</span>
                  <span class="badge bg-primary bg-opacity-10 text-primary fw-bold"><?= count($pkg['tests']) ?> Tests</span>
                </div>
                <div class="d-flex flex-wrap gap-1">
                  <?php foreach ($pkg['tests'] as $pt): ?>
                    <span class="badge bg-white text-dark border font-monospace small py-1 px-2">
                      <i class="bi bi-check-circle-fill text-success me-1"></i><?= htmlspecialchars($pt['test_name']) ?>
                    </span>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>

            <!-- Pricing Box with In-place Editable Rate -->
            <div class="pkg-price-box">
              <div class="flex-grow-1">
                <div class="small fw-bold text-muted text-uppercase mb-1">Package Tariff</div>
                <div class="rate-edit-wrap d-flex align-items-center gap-1">
                  <div class="input-group input-group-sm rate-input-group" style="width: 155px;">
                    <span class="input-group-text bg-white text-muted fw-bold border-end-0">₹</span>
                    <input type="number" 
                           step="0.01" 
                           min="0" 
                           class="form-control form-control-sm text-end fw-bold font-monospace border-start-0 border-end-0 rate-input" 
                           data-type="package" 
                           data-id="<?= $pkg['package_id'] ?>" 
                           data-name="<?= htmlspecialchars($pkg['package_name']) ?>"
                           data-mrp="<?= (float)$pkg['total_mrp'] ?>"
                           data-original="<?= number_format((float)$pkg['package_price'], 2, '.', '') ?>" 
                           value="<?= number_format((float)$pkg['package_price'], 2, '.', '') ?>"
                           onchange="saveRate(this)"
                           onkeydown="if(event.key==='Enter'){this.blur();}">
                    <button class="btn btn-outline-primary btn-rate-save px-2" type="button" onclick="saveRate($(this).prev()[0])" title="Save Package Rate">
                      <i class="fas fa-check"></i>
                    </button>
                  </div>
                  <span class="rate-status-icon" id="status-package-<?= $pkg['package_id'] ?>" style="width: 16px;"></span>
                </div>
                <!-- Clean display for Print -->
                <div class="print-rate-display fs-5 text-primary">
                  ₹ <?= number_format($pkg['package_price'], 2) ?>
                </div>

                <?php if ($pkg['total_mrp'] > 0): ?>
                  <div class="pkg-mrp mt-1" id="mrp-pkg-<?= $pkg['package_id'] ?>">MRP: ₹ <?= number_format($pkg['total_mrp'], 2) ?></div>
                <?php endif; ?>
              </div>

              <div class="text-end">
                <div class="pkg-savings-pill" id="savings-pkg-<?= $pkg['package_id'] ?>">
                  <?php if ($pkg['savings'] > 0): ?>
                    <i class="bi bi-tag-fill me-1"></i>Save <?= $pkg['discount_pct'] ?>% (₹<?= number_format($pkg['savings'], 0) ?>)
                  <?php else: ?>
                    <span class="text-muted small">Standard Package Rate</span>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="alert alert-info text-center py-5">No preventive health packages configured.</div>
    <?php endif; ?>
  </div>

  <!-- Print Footer Note -->
  <div class="mt-4 pt-3 border-top text-center text-muted small">
    Rates are subject to laboratory revision. Standard specimen collection and quality protocols apply across all clinical assays.
  </div>

</div>

<!-- BULK RATE ADJUSTER MODAL -->
<div class="modal fade" id="bulkRateModal" tabindex="-1" aria-labelledby="bulkRateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 14px;">
      <div class="modal-header border-bottom px-4 py-3" style="background: #f8fafc; border-top-left-radius: 14px; border-top-right-radius: 14px;">
        <h5 class="modal-title fw-bold text-dark" id="bulkRateModalLabel">
          <i class="bi bi-sliders text-primary me-2"></i>Bulk Tariff Adjustment
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <p class="text-muted small mb-3">
          Quickly apply percentage revisions (+10%, -5%) or flat amount adjustments across all tests or a specific clinical department.
        </p>
        <form id="bulkRateForm" onsubmit="event.preventDefault(); applyBulkAdjustment();">
          <div class="mb-3">
            <label class="form-label small fw-bold text-uppercase text-muted">1. Target Department Scope</label>
            <select id="bulkCategory" class="form-select fw-semibold">
              <option value="0">All Clinical Departments (<?= $total_tests_count ?> Tests)</option>
              <?php foreach ($categories as $cid => $cname): ?>
                <option value="<?= $cid ?>"><?= htmlspecialchars($cname) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-bold text-uppercase text-muted">2. Adjustment Type</label>
            <select id="bulkType" class="form-select fw-semibold" onchange="updateBulkSymbol()">
              <option value="percent_add">Percentage Increase (+ %)</option>
              <option value="percent_sub">Percentage Discount (- %)</option>
              <option value="flat_add">Flat Increase (+ ₹)</option>
              <option value="flat_sub">Flat Decrease (- ₹)</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-bold text-uppercase text-muted">3. Adjustment Value</label>
            <div class="input-group">
              <span class="input-group-text bg-white text-muted fw-bold" id="bulkSymbol">%</span>
              <input type="number" step="0.01" min="0.01" class="form-control fw-bold font-monospace" id="bulkValue" placeholder="e.g. 10" required>
            </div>
            <small class="text-muted">Enter positive number (e.g. 10 for 10% or 50 for ₹50).</small>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-bold text-uppercase text-muted">4. Rounding Options</label>
            <select id="bulkRound" class="form-select">
              <option value="0">No Rounding (Keep exact 2 decimal places)</option>
              <option value="5">Round to nearest ₹5 (e.g. 148 -> 150)</option>
              <option value="10">Round to nearest ₹10 (e.g. 142 -> 140, 146 -> 150)</option>
            </select>
          </div>

          <div id="bulkStatusMsg" class="alert alert-info small py-2 d-none"></div>

          <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="button" class="btn btn-outline-secondary btn-sm fw-semibold" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary btn-sm fw-bold px-4" id="btnApplyBulk">
              <i class="bi bi-check2-circle me-1"></i> Apply Tariff Adjustment
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Floating Toast Message Notification -->
<div id="rateToast" class="alert alert-dismissible shadow-lg fade show" role="alert">
  <div class="d-flex align-items-center gap-2">
    <i class="fas fa-check-circle text-success fs-5" id="rateToastIcon"></i>
    <span id="rateToastMsg" class="fw-semibold small"></span>
  </div>
</div>

<!-- Scripts -->
<script>
function switchCatalogTab(tab) {
  const tabs = document.querySelectorAll('.catalog-tab-btn');
  tabs.forEach(t => t.classList.remove('active'));

  if (tab === 'tests') {
    tabs[0].classList.add('active');
    document.getElementById('testsSection').style.display = 'block';
    document.getElementById('packagesSection').style.display = 'none';
  } else {
    tabs[1].classList.add('active');
    document.getElementById('testsSection').style.display = 'none';
    document.getElementById('packagesSection').style.display = 'block';
  }
}

function filterCatalog() {
  const q = document.getElementById('catalogSearch').value.toLowerCase().trim();
  const cat = document.getElementById('categoryFilter').value.trim();

  // Filter individual tests
  document.querySelectorAll('.dept-card').forEach(dept => {
    const deptCat = dept.getAttribute('data-category');
    let deptVisible = true;

    if (cat && deptCat !== cat) {
      deptVisible = false;
    }

    let hasMatchingTest = false;
    dept.querySelectorAll('.test-row').forEach(row => {
      const name = row.getAttribute('data-name');
      const code = row.getAttribute('data-code');
      const text = row.innerText.toLowerCase();

      if ((!q || text.includes(q)) && deptVisible) {
        row.style.display = '';
        hasMatchingTest = true;
      } else {
        row.style.display = 'none';
      }
    });

    if (deptVisible && (hasMatchingTest || !q)) {
      dept.style.display = '';
    } else {
      dept.style.display = 'none';
    }
  });

  // Filter packages
  document.querySelectorAll('.pkg-card').forEach(card => {
    const text = card.innerText.toLowerCase();
    if (!q || text.includes(q)) {
      card.style.display = '';
    } else {
      card.style.display = 'none';
    }
  });
}

// IN-PLACE RATE SAVE (AJAX)
function saveRate(inputElement) {
  const $input = $(inputElement);
  const type = $input.data('type') || 'test'; // 'test' or 'package'
  const id = $input.data('id');
  const name = $input.data('name') || '';
  const origVal = parseFloat($input.data('original'));
  const newVal = parseFloat($input.val());

  if (isNaN(newVal) || newVal < 0) {
    showRateToast('Please enter a valid non-negative tariff rate.', 'danger');
    $input.val(origVal.toFixed(2));
    return;
  }

  // If value is identical to original, no need to send request
  if (Math.abs(newVal - origVal) < 0.001) {
    return;
  }

  const $statusIcon = $('#status-' + type + '-' + id);
  $statusIcon.html('<i class="fas fa-spinner fa-spin text-muted" style="font-size: 0.75rem;"></i>');

  $.ajax({
    url: 'ajax_update_rate.php',
    method: 'POST',
    data: {
      action: 'update_single',
      type: type,
      id: id,
      price: newVal
    },
    success: function(resp) {
      const d = (typeof resp === 'object') ? resp : JSON.parse(resp);
      if (d.success) {
        $input.data('original', newVal.toFixed(2));
        $input.val(newVal.toFixed(2));
        $input.addClass('rate-saved-flash');
        setTimeout(() => { $input.removeClass('rate-saved-flash'); }, 1200);

        $statusIcon.html('<i class="fas fa-check rate-saved-icon" title="Saved!"></i>');
        setTimeout(() => { $statusIcon.empty(); }, 2500);

        // Update hidden print display
        const $row = $input.closest('td, .pkg-price-box');
        $row.find('.print-rate-display').text('₹ ' + d.formatted_price);

        // If package, update savings pill dynamically
        if (type === 'package') {
          const mrp = parseFloat($input.data('mrp')) || 0;
          const savings = Math.max(0, mrp - newVal);
          const discPct = mrp > 0 ? Math.round((savings / mrp) * 100) : 0;
          const $savingsPill = $('#savings-pkg-' + id);
          if (savings > 0) {
            $savingsPill.html('<i class="bi bi-tag-fill me-1"></i>Save ' + discPct + '% (₹' + Math.round(savings) + ')');
          } else {
            $savingsPill.html('<span class="text-muted small">Standard Package Rate</span>');
          }
        }

        showRateToast((name ? '<strong>' + name + '</strong> ' : '') + 'Tariff updated to ₹' + d.formatted_price, 'success');
      } else {
        $statusIcon.html('<i class="fas fa-exclamation-triangle text-danger"></i>');
        showRateToast(d.message || 'Failed to update rate.', 'danger');
        $input.val(origVal.toFixed(2));
      }
    },
    error: function() {
      $statusIcon.html('<i class="fas fa-times text-danger"></i>');
      showRateToast('Server communication error.', 'danger');
      $input.val(origVal.toFixed(2));
    }
  });
}

function updateBulkSymbol() {
  const type = document.getElementById('bulkType').value;
  const symbolSpan = document.getElementById('bulkSymbol');
  if (type.includes('percent')) {
    symbolSpan.innerText = '%';
  } else {
    symbolSpan.innerText = '₹';
  }
}

function applyBulkAdjustment() {
  const catId = $('#bulkCategory').val();
  const adjType = $('#bulkType').val();
  const adjVal = parseFloat($('#bulkValue').val());
  const roundTo = $('#bulkRound').val();

  if (isNaN(adjVal) || adjVal <= 0) {
    alert('Please enter a valid adjustment value greater than 0.');
    return;
  }

  const $btn = $('#btnApplyBulk');
  $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Updating...');

  $.ajax({
    url: 'ajax_update_rate.php',
    method: 'POST',
    data: {
      action: 'bulk_adjust',
      category_id: catId,
      adjust_type: adjType,
      adjust_value: adjVal,
      round_to: roundTo
    },
    success: function(resp) {
      $btn.prop('disabled', false).html('<i class="bi bi-check2-circle me-1"></i> Apply Tariff Adjustment');
      const d = (typeof resp === 'object') ? resp : JSON.parse(resp);

      if (d.success) {
        // Update input fields live if updated_items returned
        if (d.updated_items) {
          for (const [tid, newPrice] of Object.entries(d.updated_items)) {
            const $inp = $('.rate-input[data-type="test"][data-id="' + tid + '"]');
            if ($inp.length) {
              $inp.val(newPrice);
              $inp.data('original', newPrice);
              $inp.addClass('rate-saved-flash');
              setTimeout(() => { $inp.removeClass('rate-saved-flash'); }, 1500);
              $inp.closest('td').find('.print-rate-display').text('₹ ' + parseFloat(newPrice).toFixed(2));
            }
          }
        }
        $('#bulkRateModal').modal('hide');
        showRateToast(d.message, 'success');
      } else {
        alert(d.message || 'Adjustment failed.');
      }
    },
    error: function() {
      $btn.prop('disabled', false).html('<i class="bi bi-check2-circle me-1"></i> Apply Tariff Adjustment');
      alert('Communication error while applying bulk adjustment.');
    }
  });
}

function showRateToast(msg, type) {
  const $toast = $('#rateToast');
  $toast.removeClass('alert-success alert-danger alert-info alert-warning');
  $toast.addClass('alert-' + (type === 'danger' ? 'danger' : 'success'));
  $('#rateToastIcon').removeClass('fa-check-circle fa-exclamation-triangle text-success text-danger');
  $('#rateToastIcon').addClass(type === 'danger' ? 'fa-exclamation-triangle text-danger' : 'fa-check-circle text-success');
  $('#rateToastMsg').html(msg);
  $toast.fadeIn(200);
  setTimeout(() => { $toast.fadeOut(300); }, 3500);
}
</script>

</body>
</html>