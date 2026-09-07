<?php
/**
 * Available Diagnostic Tests Master Directory
 * - Detailed view of available laboratory tests
 * - Full breakdown of clinical parameters, units, and reference intervals
 * - Specimen vacutainer tube recommendations
 * - Modern medical studio layout with light placeholders and instant search
 */
include_once 'auth_check.php';
include_once 'db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Fetch Categories for Filter
$categories = [];
$cat_q = $conn->query("SELECT * FROM test_categories ORDER BY category_name ASC");
if ($cat_q) {
    while ($c = $cat_q->fetch_assoc()) {
        $categories[$c['category_id']] = $c['category_name'];
    }
}

// 2. Fetch Parameters mapped to each test
$test_params = [];
$p_query = "
    SELECT ltp.test_id, p.param_name, p.unit, p.method,
           r.male_min, r.male_max, r.female_min, r.female_max, r.reference_text, r.use_reference_text
    FROM lab_test_parameters ltp
    JOIN test_parameters p ON ltp.parameter_id = p.parameter_id
    LEFT JOIN parameter_reference_ranges r ON p.parameter_id = r.parameter_id
    ORDER BY ltp.test_id, ltp.sort_order ASC, p.param_name ASC
";
$p_res = $conn->query($p_query);
if ($p_res) {
    while ($pr = $p_res->fetch_assoc()) {
        $test_params[$pr['test_id']][] = $pr;
    }
}

// 3. Fetch All Tests with Category
$tests = [];
$t_query = "
    SELECT lt.*, tc.category_name as category 
    FROM lab_tests lt 
    LEFT JOIN test_categories tc ON lt.category_id = tc.category_id 
    ORDER BY lt.test_name ASC
";
$t_res = $conn->query($t_query);
if ($t_res) {
    while ($row = $t_res->fetch_assoc()) {
        $row['parameters'] = $test_params[$row['test_id']] ?? [];
        $tests[] = $row;
    }
}

// Metrics
$total_tests = count($tests);
$total_params = $conn->query("SELECT COUNT(*) as cnt FROM test_parameters")->fetch_assoc()['cnt'] ?? 0;
$total_cats = count($categories);

// Helper for vacutainer badge
function getSpecimenBadge($test_name) {
    $str = strtolower($test_name);
    if (preg_match('/(cbc|hemogram|edta|hba1c|esr|platelet|blood group|wbc|rbc|malaria)/i', $str)) {
        return '<span class="tube-badge tube-edta" title="Lavender Tube"><span class="dot"></span>EDTA (Whole Blood)</span>';
    }
    if (preg_match('/(sugar|glucose|fbs|ppbs|rbs|gtt)/i', $str)) {
        return '<span class="tube-badge tube-fluoride" title="Grey Tube"><span class="dot"></span>Fluoride Plasma</span>';
    }
    if (preg_match('/(pt|inr|aptt|citrate|d-dimer)/i', $str)) {
        return '<span class="tube-badge tube-citrate" title="Blue Tube"><span class="dot"></span>Sodium Citrate</span>';
    }
    if (preg_match('/(urine|routine|microscopy|culture|stool|semen)/i', $str)) {
        return '<span class="tube-badge tube-urine" title="Sterile Cup"><span class="dot"></span>Sterile Container</span>';
    }
    return '<span class="tube-badge tube-sst" title="Yellow/Red Tube"><span class="dot"></span>Serum (SST/Plain)</span>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Available Diagnostic Tests & Parameters | Laboratory ERP</title>
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
    .tests-header-card {
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
    .tests-title {
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
      padding: 20px 24px;
      margin-bottom: 22px;
    }

    /* Filter Controls */
    .form-control, .form-select {
      border-radius: 8px;
      border: 1px solid var(--border-color);
      font-size: 0.88rem;
      padding: 8px 12px;
      color: var(--text-main);
    }
    .form-control:focus, .form-select:focus {
      border-color: var(--brand-primary);
      box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.12);
    }

    /* Table Styling */
    .tests-table-wrapper {
      border: 1px solid var(--border-color);
      border-radius: 12px;
      overflow: hidden;
      background: #ffffff;
    }
    .tests-table {
      width: 100%;
      border-collapse: collapse;
      margin: 0;
    }
    .tests-table th {
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
    .tests-table td {
      padding: 12px 16px;
      vertical-align: middle;
      border-bottom: 1px solid var(--border-light);
      font-size: 0.88rem;
    }
    .tests-table tr:last-child td {
      border-bottom: none;
    }
    .tests-table tr:hover td {
      background-color: #fafbfc;
    }

    /* Specimen Tube Tag */
    .tube-badge {
      font-size: 0.72rem;
      font-weight: 700;
      padding: 2px 7px;
      border-radius: 6px;
      display: inline-flex;
      align-items: center;
      gap: 5px;
      white-space: nowrap;
    }
    .tube-badge .dot {
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

    /* Parameters Details Accordion */
    .param-chip {
      font-size: 0.72rem;
      font-weight: 600;
      background: #f1f5f9;
      color: #334155;
      padding: 2px 7px;
      border-radius: 4px;
      border: 1px solid #e2e8f0;
      display: inline-block;
      margin: 2px 2px;
    }
    .param-detail-toggle {
      font-size: 0.75rem;
      color: var(--brand-primary);
      text-decoration: none;
      cursor: pointer;
      font-weight: 700;
      display: inline-flex;
      align-items: center;
      gap: 4px;
      margin-top: 4px;
    }
    .param-detail-toggle:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<?php include_once __DIR__ . '/header.php'; ?>

<div class="page-container">

  <!-- Header Card -->
  <div class="tests-header-card">
    <div>
      <h1 class="tests-title">
        <i class="bi bi-clipboard2-pulse text-primary"></i> Available Diagnostic Tests Master
      </h1>
      <div class="text-muted small mt-1">
        Catalog of laboratory test profiles, clinical parameters, reference intervals, and vacutainer specimen guidelines.
      </div>
    </div>
    <div class="d-flex align-items-center gap-2">
      <a href="rate_card.php" class="btn btn-outline-secondary btn-sm fw-semibold">
        <i class="bi bi-file-earmark-spreadsheet me-1"></i> Tariff Rate Card
      </a>
      <a href="test_packages.php" class="btn btn-outline-info btn-sm fw-semibold">
        <i class="bi bi-box-seam me-1"></i> Health Packages
      </a>
      <a href="lab_test_form_with_sections.php" class="btn btn-primary btn-sm fw-bold px-3 shadow-sm">
        <i class="bi bi-plus-lg me-1"></i> Add New Test
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
        <i class="bi bi-clipboard2-pulse-fill"></i>
      </div>
      <div>
        <div class="metric-val" style="color: #0284c7;"><?= number_format($total_tests) ?></div>
        <div class="metric-label">Total Test Profiles</div>
      </div>
    </div>

    <div class="metric-card">
      <div class="metric-icon-box" style="background: #f0fdf4; color: #16a34a;">
        <i class="bi bi-list-check"></i>
      </div>
      <div>
        <div class="metric-val" style="color: #16a34a;"><?= number_format($total_params) ?></div>
        <div class="metric-label">Active Parameters</div>
      </div>
    </div>

    <div class="metric-card">
      <div class="metric-icon-box" style="background: #fefce8; color: #ca8a04;">
        <i class="bi bi-folder2-open"></i>
      </div>
      <div>
        <div class="metric-val" style="color: #ca8a04;"><?= number_format($total_cats) ?></div>
        <div class="metric-label">Clinical Categories</div>
      </div>
    </div>
  </div>

  <!-- Main Tests Table Card -->
  <div class="studio-card">
    
    <!-- Filter Toolbar -->
    <div class="row g-2 align-items-center mb-3">
      <div class="col-md-6 col-12">
        <div class="input-group">
          <span class="input-group-text bg-light text-muted"><i class="bi bi-search"></i></span>
          <input type="text" id="testFilterInput" class="form-control" placeholder="Search test name, code, or parameter..." oninput="filterTestsTable()">
        </div>
      </div>
      <div class="col-md-4 col-12">
        <select id="categoryFilter" class="form-select" onchange="filterTestsTable()">
          <option value="">All Clinical Departments / Categories</option>
          <?php foreach ($categories as $cid => $cname): ?>
            <option value="<?= htmlspecialchars($cname) ?>"><?= htmlspecialchars($cname) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-2 col-12 text-md-end">
        <span class="badge bg-light text-muted border font-monospace py-2 px-3" id="shownCountBadge">
          <?= $total_tests ?> Tests
        </span>
      </div>
    </div>

    <div class="tests-table-wrapper">
      <table class="tests-table">
        <thead>
          <tr>
            <th width="4%" class="text-center">#</th>
            <th width="22%">Investigation Name</th>
            <th width="15%">Category & Specimen</th>
            <th width="42%">Included Parameters Breakdown</th>
            <th width="10%">Price (₹)</th>
            <th width="7%" class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($tests)): ?>
            <?php foreach ($tests as $idx => $t): ?>
              <?php
              $p_count = count($t['parameters']);
              $cat_name = $t['category'] ?: 'General Pathology';
              ?>
              <tr class="test-row-item" data-name="<?= strtolower(htmlspecialchars($t['test_name'])) ?>" data-code="<?= strtolower(htmlspecialchars($t['test_code'] ?? '')) ?>" data-cat="<?= htmlspecialchars($cat_name) ?>">
                <td class="text-center text-muted font-monospace small"><?= $idx + 1 ?></td>
                <td>
                  <div class="fw-bold text-dark"><?= htmlspecialchars($t['test_name']) ?></div>
                  <?php if (!empty($t['test_code'])): ?>
                    <span class="badge bg-light text-secondary border font-monospace" style="font-size: 0.72rem;">
                      <?= htmlspecialchars($t['test_code']) ?>
                    </span>
                  <?php endif; ?>
                  <?php if (!empty($t['notes'])): ?>
                    <div class="small text-muted fst-italic mt-1" style="font-size:0.75rem;">
                      <?= htmlspecialchars($t['notes']) ?>
                    </div>
                  <?php endif; ?>
                </td>
                <td>
                  <div class="fw-semibold text-dark small mb-1"><?= htmlspecialchars($cat_name) ?></div>
                  <?= getSpecimenBadge($t['test_name']) ?>
                </td>
                <td>
                  <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge <?= $p_count > 0 ? 'bg-primary bg-opacity-10 text-primary' : 'bg-light text-muted border' ?> fw-bold font-monospace">
                      <?= $p_count ?> Parameters
                    </span>
                  </div>

                  <!-- Chips of parameter names with units -->
                  <div class="d-flex flex-wrap gap-1">
                    <?php if ($p_count > 0): ?>
                      <?php foreach (array_slice($t['parameters'], 0, 8) as $pm): ?>
                        <span class="param-chip" title="<?= htmlspecialchars($pm['param_name']) ?>">
                          <?= htmlspecialchars($pm['param_name']) ?>
                          <?php if (!empty($pm['unit'])): ?>
                            <small class="text-muted">(<?= htmlspecialchars($pm['unit']) ?>)</small>
                          <?php endif; ?>
                        </span>
                      <?php endforeach; ?>
                      <?php if ($p_count > 8): ?>
                        <span class="badge bg-light text-secondary border font-monospace small py-1">
                          +<?= $p_count - 8 ?> more
                        </span>
                      <?php endif; ?>
                    <?php else: ?>
                      <span class="text-muted small">Standard descriptive diagnostic observation</span>
                    <?php endif; ?>
                  </div>
                </td>
                <td>
                  <div class="fw-bold text-primary font-monospace" style="font-size: 1.05rem;">
                    ₹ <?= number_format($t['price'], 2) ?>
                  </div>
                </td>
                <td class="text-end">
                  <div class="d-flex align-items-center justify-content-end gap-1">
                    <a href="lab_test_form_with_sections.php?id=<?= $t['test_id'] ?>" class="btn btn-sm btn-outline-warning" title="Edit Test and Parameter Sections">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <a href="lab_test_delete.php?id=<?= $t['test_id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete test \'<?= htmlspecialchars(addslashes($t['test_name'])) ?>\'?')" title="Delete Test">
                      <i class="bi bi-trash"></i>
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center py-5">
                <i class="bi bi-clipboard2-x fa-3x text-muted mb-2 d-block opacity-50"></i>
                <h6 class="fw-bold text-secondary">No Diagnostic Tests Configured</h6>
                <p class="small text-muted mb-3">Add tests to start building your laboratory catalog.</p>
                <a href="lab_test_form_with_sections.php" class="btn btn-primary btn-sm">+ Add First Test</a>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </div>

</div>

<!-- Scripts -->
<script>
function filterTestsTable() {
  const q = document.getElementById('testFilterInput').value.toLowerCase().trim();
  const cat = document.getElementById('categoryFilter').value.trim();

  let count = 0;
  document.querySelectorAll('.test-row-item').forEach(row => {
    const name = row.getAttribute('data-name');
    const code = row.getAttribute('data-code');
    const rowCat = row.getAttribute('data-cat');
    const text = row.innerText.toLowerCase();

    const matchesQ = !q || text.includes(q);
    const matchesCat = !cat || rowCat === cat;

    if (matchesQ && matchesCat) {
      row.style.display = '';
      count++;
    } else {
      row.style.display = 'none';
    }
  });

  document.getElementById('shownCountBadge').innerText = count + ' Tests';
}
</script>

</body>
</html>
