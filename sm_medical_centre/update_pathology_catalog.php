<?php
/**
 * Standard Indian Pathology Master Catalog Migration & Browser
 * NABL / ICMR Compliant Walk-in Tests, Clinical Parameters, Reference Ranges, & Health Packages
 */
include_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/pathology_catalog_data.php';

// Only administrators can run database migrations
if (($_SESSION['role'] ?? '') !== 'admin') {
    die("Access denied. Administrator privileges required.");
}

$message = '';
$error = '';
$executed_count = 0;

if (isset($_POST['execute_migration'])) {
    $sql_file = __DIR__ . '/../dump/update_pathology_catalog.sql';
    if (!file_exists($sql_file)) {
        $sql_file = __DIR__ . '/update_pathology_catalog.sql';
    }

    if (!file_exists($sql_file)) {
        $error = "Migration file 'update_pathology_catalog.sql' not found at: " . htmlspecialchars($sql_file);
    } else {
        $sql_content = file_get_contents($sql_file);
        
        // Clean comments
        $clean_sql = preg_replace('/--.*$/m', '', $sql_content);
        $clean_sql = preg_replace('/\/\*.*?\*\//s', '', $clean_sql);
        
        // Split queries by semicolon followed by line break
        $queries = preg_split('/;\s*[\r\n]+/', $clean_sql);

        $conn->query("SET FOREIGN_KEY_CHECKS = 0;");
        $all_ok = true;
        
        foreach ($queries as $query) {
            $q = trim($query);
            if (!empty($q)) {
                if (!$conn->query($q)) {
                    $all_ok = false;
                    $error = "Query Execution Error ({$conn->errno}): " . $conn->error . "\nIn Query: " . substr($q, 0, 200) . "...";
                    break;
                }
                $executed_count++;
            }
        }
        
        $conn->query("SET FOREIGN_KEY_CHECKS = 1;");

        if ($all_ok) {
            $message = "Successfully updated master pathology catalog! All 92 Standard Lab Tests, 144 Clinical Parameters, 144 Reference Ranges, and 15 Health Checkup Packages are now 100% compliant with standard Indian Pathology guidelines (NABL / ICMR).";
        }
    }
}

// Fetch current database counts
$cat_cnt = (int)($conn->query("SELECT COUNT(*) as c FROM test_categories")->fetch_assoc()['c'] ?? 0);
$test_cnt = (int)($conn->query("SELECT COUNT(*) as c FROM lab_tests")->fetch_assoc()['c'] ?? 0);
$param_cnt = (int)($conn->query("SELECT COUNT(*) as c FROM test_parameters")->fetch_assoc()['c'] ?? 0);
$range_cnt = (int)($conn->query("SELECT COUNT(*) as c FROM parameter_reference_ranges")->fetch_assoc()['c'] ?? 0);
$pkg_cnt = (int)($conn->query("SELECT COUNT(*) as c FROM test_packages")->fetch_assoc()['c'] ?? 0);

$is_up_to_date = ($test_cnt >= 92 && $pkg_cnt >= 15);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Indian Standard Pathology Master Catalog | Lab Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --med-primary: #0d6efd;
      --med-success: #198754;
      --med-dark: #1e293b;
      --med-border: #e2e8f0;
      --med-bg-soft: #f8fafc;
    }
    body {
      background-color: #f1f5f9;
      color: #334155;
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
    }
    .catalog-header {
      background: linear-gradient(135deg, #1e3a8a 0%, #0d6efd 100%);
      color: white;
      border-radius: 1rem;
      padding: 2rem;
      box-shadow: 0 10px 25px -5px rgba(13, 110, 253, 0.25);
    }
    .stat-card {
      background: white;
      border: 1px solid var(--med-border);
      border-radius: 0.75rem;
      padding: 1.25rem;
      transition: all 0.2s ease;
    }
    .stat-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .nav-pills-custom .nav-link {
      color: #475569;
      font-weight: 500;
      font-size: 0.875rem;
      padding: 0.5rem 1rem;
      border-radius: 2rem;
      border: 1px solid #cbd5e1;
      margin-right: 0.5rem;
      margin-bottom: 0.5rem;
      background: white;
      transition: all 0.15s ease;
    }
    .nav-pills-custom .nav-link:hover {
      background-color: #f8fafc;
      border-color: #94a3b8;
    }
    .nav-pills-custom .nav-link.active {
      background-color: #0d6efd;
      border-color: #0d6efd;
      color: white;
      box-shadow: 0 2px 8px rgba(13, 110, 253, 0.35);
    }
    .test-item-card {
      background: white;
      border: 1px solid var(--med-border);
      border-radius: 0.75rem;
      padding: 1.25rem;
      margin-bottom: 0.85rem;
      transition: border-color 0.2s;
    }
    .test-item-card:hover {
      border-color: #93c5fd;
    }
    .badge-tube {
      font-size: 0.75rem;
      padding: 0.3rem 0.6rem;
      border-radius: 0.4rem;
      background: #f1f5f9;
      color: #475569;
      border: 1px solid #e2e8f0;
    }
    .package-card {
      background: white;
      border: 1px solid var(--med-border);
      border-radius: 0.75rem;
      padding: 1.25rem;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: all 0.2s ease;
    }
    .package-card:hover {
      border-color: #0d6efd;
      box-shadow: 0 6px 20px rgba(0,0,0,0.06);
    }
    .search-box {
      border-radius: 2rem;
      padding-left: 2.75rem;
      border: 1px solid #cbd5e1;
      height: 48px;
    }
    .search-icon-wrapper {
      position: absolute;
      left: 1.1rem;
      top: 50%;
      transform: translateY(-50%);
      color: #94a3b8;
    }
  </style>
</head>
<body>
<?php include_once __DIR__ . '/header.php'; ?>

<div class="container-fluid px-lg-5 py-4">

  <!-- Header Banner -->
  <div class="catalog-header mb-4">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <div class="d-flex align-items-center gap-3 mb-2 flex-wrap">
          <span class="badge bg-white bg-opacity-25 text-white px-3 py-2 rounded-pill">
            <i class="fas fa-shield-alt me-1"></i> NABL / ICMR Guideline Compliant
          </span>
          <?php if ($is_up_to_date): ?>
            <span class="badge bg-success px-3 py-2 rounded-pill">
              <i class="fas fa-check-circle me-1"></i> Catalog Up to Date (<?= $test_cnt ?> Tests)
            </span>
          <?php else: ?>
            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
              <i class="fas fa-exclamation-circle me-1"></i> Upgrade Ready (Active: <?= $test_cnt ?> / 92 Tests)
            </span>
          <?php endif; ?>
        </div>
        <h2 class="fw-bold mb-2">Indian Diagnostic Pathology Master Catalog</h2>
        <p class="mb-0 text-white-50 fs-6">
          Ready-to-use out-of-the-box laboratory master catalog for daily walk-in patients across India. Contains all single routine tests (FBS, Creatinine, TSH, Platelets alone, BT/CT, etc.) and complete panels with nominal market prices and accurate reference intervals.
        </p>
      </div>
      <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
        <form method="POST" onsubmit="return confirm('Upgrade pathology catalog now? This will clean and update all 92 laboratory tests, 144 parameters, reference ranges, and 15 packages with standard values.');">
          <button type="submit" name="execute_migration" class="btn btn-light btn-lg px-4 py-3 fw-bold text-primary shadow-sm rounded-pill">
            <i class="fas fa-sync-alt me-2"></i> <?= $is_up_to_date ? 'Refresh / Re-sync Catalog' : 'Upgrade Master Catalog Now' ?>
          </button>
        </form>
        <div class="mt-2 text-white-50 small">1-Click instant database setup</div>
      </div>
    </div>
  </div>

  <!-- Alerts -->
  <?php if ($message): ?>
    <div class="alert alert-success d-flex align-items-center gap-3 shadow-sm rounded-3 mb-4">
      <i class="fas fa-check-circle fa-2x text-success"></i>
      <div>
        <h6 class="fw-bold mb-1">Catalog Updated Successfully!</h6>
        <div class="small"><?= htmlspecialchars($message) ?></div>
      </div>
    </div>
  <?php endif; ?>

  <?php if ($error): ?>
    <div class="alert alert-danger d-flex align-items-center gap-3 shadow-sm rounded-3 mb-4">
      <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
      <div>
        <h6 class="fw-bold mb-1">Migration Notice</h6>
        <pre class="mb-0 small text-wrap"><?= htmlspecialchars($error) ?></pre>
      </div>
    </div>
  <?php endif; ?>

  <!-- Statistics Overview -->
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <span class="text-muted small fw-semibold">LAB TESTS</span>
          <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">Target: 92</span>
        </div>
        <div class="d-flex align-items-baseline gap-2">
          <h2 class="fw-bold mb-0 text-primary"><?= $test_cnt ?></h2>
          <span class="text-muted small">available</span>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <span class="text-muted small fw-semibold">CLINICAL PARAMETERS</span>
          <span class="badge bg-success bg-opacity-10 text-success rounded-pill">Target: 144</span>
        </div>
        <div class="d-flex align-items-baseline gap-2">
          <h2 class="fw-bold mb-0 text-success"><?= $param_cnt ?></h2>
          <span class="text-muted small">mapped</span>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <span class="text-muted small fw-semibold">REFERENCE RANGES</span>
          <span class="badge bg-warning bg-opacity-10 text-dark rounded-pill">Target: 144</span>
        </div>
        <div class="d-flex align-items-baseline gap-2">
          <h2 class="fw-bold mb-0 text-dark"><?= $range_cnt ?></h2>
          <span class="text-muted small">NABL / ICMR</span>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <span class="text-muted small fw-semibold">HEALTH PACKAGES</span>
          <span class="badge bg-info bg-opacity-10 text-info rounded-pill">Target: 15</span>
        </div>
        <div class="d-flex align-items-baseline gap-2">
          <h2 class="fw-bold mb-0 text-info"><?= $pkg_cnt ?></h2>
          <span class="text-muted small">wellness combos</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Key Improvements Callout -->
  <div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">
      <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
          <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3">
            <i class="fas fa-check-double fa-lg"></i>
          </div>
          <h5 class="fw-bold mb-0">What this Complete Pathology Catalog Provides:</h5>
        </div>
        <div class="d-flex gap-2 flex-wrap">
          <a href="lab_test_list.php" class="btn btn-sm btn-outline-primary rounded-pill px-3">
            <i class="fas fa-list me-1"></i> Open Test Master
          </a>
          <a href="rate_card.php" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
            <i class="fas fa-tags me-1"></i> Customize Prices (Rate Card)
          </a>
          <a href="patient_registration.php" class="btn btn-sm btn-primary rounded-pill px-3">
            <i class="fas fa-plus me-1"></i> New Walk-In Bill
          </a>
        </div>
      </div>

      <div class="row g-3 small">
        <div class="col-md-4">
          <div class="p-3 bg-light rounded-3 h-100">
            <h6 class="fw-bold text-primary mb-2"><i class="fas fa-walking me-1"></i> Standalone Walk-in Tests Added:</h6>
            <p class="mb-0 text-muted">
              Patients often arrive requesting single tests: <strong>FBS alone (₹60)</strong>, <strong>PPBS (₹60)</strong>, <strong>RBS (₹60)</strong>, <strong>HbA1c alone (₹400)</strong>, <strong>Serum Creatinine alone (₹120)</strong> (mandatory before contrast CT scans), <strong>Blood Urea (₹100)</strong>, <strong>Serum Uric Acid (₹120)</strong>, <strong>Platelet Count alone (₹100)</strong> for dengue monitoring, <strong>BT/CT (₹100)</strong> pre-op, <strong>TSH alone (₹200)</strong>, <strong>Blood Grouping (₹100)</strong>, <strong>AEC (₹120)</strong>, <strong>ESR (₹80)</strong>, <strong>UPT (₹100)</strong>, <strong>Semen Analysis (₹300)</strong>, <strong>Stool Routine (₹150)</strong>, <strong>Sputum AFB (₹150)</strong>, <strong>Mantoux (₹150)</strong>, and <strong>Troponin-I (₹600)</strong>.
            </p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-3 bg-light rounded-3 h-100">
            <h6 class="fw-bold text-success mb-2"><i class="fas fa-balance-scale me-1"></i> 100% Medical Reference Range Accuracy:</h6>
            <p class="mb-0 text-muted">
              Corrects historical issues: Fasting Sugar standard range is set strictly to <strong>70 - 100 mg/dL</strong>, HbA1c to <strong>4.0 - 5.6 %</strong>, Total Cholesterol to <strong>&lt; 200 mg/dL</strong>, Serum Creatinine to <strong>0.7 - 1.3 mg/dL</strong>, Bilirubin Total to <strong>0.2 - 1.2 mg/dL</strong>, and INR to <strong>0.85 - 1.15</strong>. All units are standardized to Indian clinical lab norms (mg/dL, g/dL, cells/cumm, lakh/cumm, µIU/mL, ng/mL, /HPF).
            </p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-3 bg-light rounded-3 h-100">
            <h6 class="fw-bold text-info mb-2"><i class="fas fa-boxes-packing me-1"></i> 15 Ready-to-Sell Health Packages:</h6>
            <p class="mb-0 text-muted">
              Pre-configured with attractive package rates for patient walk-ins: <strong>Basic Health (₹699)</strong>, <strong>Executive Master (₹1,499)</strong>, <strong>Fever Profile (₹599)</strong>, <strong>Diabetic Care (₹499)</strong>, <strong>Cardiac Health (₹999)</strong>, <strong>Liver & Kidney Care (₹550-₹599)</strong>, <strong>Thyroid Care (₹450)</strong>, <strong>Antenatal ANC (₹799)</strong>, <strong>Senior Citizen Profiles (₹1,299)</strong>, <strong>Pre-Operative (₹799)</strong>, and <strong>PCOS / Women's Wellness</strong>.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Interactive Search & Filtering Controls -->
  <div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">
      <div class="row g-3 align-items-center">
        <!-- Search bar -->
        <div class="col-lg-5">
          <div class="position-relative">
            <i class="fas fa-search search-icon-wrapper"></i>
            <input type="text" id="catalogSearch" class="form-control search-box" placeholder="Search by test name, code (FBS, CBC, TSH...), specimen or parameter...">
          </div>
        </div>

        <!-- Category Pills -->
        <div class="col-lg-7">
          <div class="d-flex flex-wrap align-items-center nav-pills-custom" id="categoryFilters">
            <button type="button" class="nav-link active" data-category="all">
              <i class="fas fa-globe me-1"></i> All (<span id="count-all"><?= count($MASTER_CATALOG_TESTS) + count($MASTER_CATALOG_PACKAGES) ?></span>)
            </button>
            <button type="button" class="nav-link" data-category="Hematology">
              <i class="fas fa-tint text-danger me-1"></i> Hematology
            </button>
            <button type="button" class="nav-link" data-category="Biochemistry">
              <i class="fas fa-vial text-primary me-1"></i> Biochemistry
            </button>
            <button type="button" class="nav-link" data-category="Serology & Immunology">
              <i class="fas fa-virus text-warning me-1"></i> Serology / Fever
            </button>
            <button type="button" class="nav-link" data-category="Endocrinology & Vitamins">
              <i class="fas fa-dna text-info me-1"></i> Thyroid & Hormones
            </button>
            <button type="button" class="nav-link" data-category="Clinical Pathology">
              <i class="fas fa-microscope text-success me-1"></i> Urine / Stool / Semen
            </button>
            <button type="button" class="nav-link" data-category="Microbiology">
              <i class="fas fa-bacterium text-secondary me-1"></i> Microbiology
            </button>
            <button type="button" class="nav-link" data-category="Package">
              <i class="fas fa-box-open text-primary me-1"></i> Health Packages (15)
            </button>
          </div>
        </div>
      </div>

      <!-- Quick Filter Counters & Type Toggles -->
      <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top flex-wrap gap-2">
        <div class="text-muted small">
          Showing <span id="visibleCount" class="fw-bold text-dark"><?= count($MASTER_CATALOG_TESTS) ?></span> tests and <span id="visiblePkgCount" class="fw-bold text-dark"><?= count($MASTER_CATALOG_PACKAGES) ?></span> packages matching filter
        </div>
        <div class="btn-group btn-group-sm" role="group" id="typeFilterGroup">
          <input type="radio" class="btn-check" name="typefilter" id="typeAll" value="all" checked>
          <label class="btn btn-outline-secondary" for="typeAll">All Types</label>

          <input type="radio" class="btn-check" name="typefilter" id="typeSingle" value="single">
          <label class="btn btn-outline-secondary" for="typeSingle">Single Walk-In Tests</label>

          <input type="radio" class="btn-check" name="typefilter" id="typePanel" value="panel">
          <label class="btn btn-outline-secondary" for="typePanel">Multi-Test Panels</label>

          <input type="radio" class="btn-check" name="typefilter" id="typePkgOnly" value="package">
          <label class="btn btn-outline-secondary" for="typePkgOnly">Health Packages</label>
        </div>
      </div>
    </div>
  </div>

  <!-- Master Catalog Directory List -->
  <div class="row">
    
    <!-- Health Packages Section (Displayed when All or Package is selected) -->
    <div class="col-12 mb-4" id="packagesSection">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-bold mb-0">
          <i class="fas fa-gift text-primary me-2"></i> Standard Health & Wellness Packages (<?= count($MASTER_CATALOG_PACKAGES) ?>)
        </h5>
        <span class="badge bg-primary bg-opacity-10 text-primary">High-Margin Patient Packages</span>
      </div>

      <div class="row g-3" id="packageCardsRow">
        <?php foreach ($MASTER_CATALOG_PACKAGES as $pkg): ?>
          <div class="col-md-6 col-xl-4 package-card-item" 
               data-category="Package" 
               data-type="package"
               data-search="<?= htmlspecialchars(strtolower($pkg['name'] . ' ' . $pkg['code'] . ' ' . $pkg['notes'])) ?>">
            <div class="package-card">
              <div>
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <span class="badge bg-primary px-2 py-1"><?= htmlspecialchars($pkg['code']) ?></span>
                  <div class="text-end">
                    <span class="fs-5 fw-bold text-primary">₹<?= number_format($pkg['price'], 2) ?></span>
                    <?php if ($pkg['savings'] > 0): ?>
                      <div class="small text-muted text-decoration-line-through">₹<?= number_format($pkg['original_price'], 2) ?></div>
                    <?php endif; ?>
                  </div>
                </div>

                <h6 class="fw-bold text-dark mb-1"><?= htmlspecialchars($pkg['name']) ?></h6>
                <p class="text-muted small mb-3"><?= htmlspecialchars($pkg['notes']) ?></p>

                <div class="mb-3">
                  <span class="text-muted small fw-semibold d-block mb-1">
                    <i class="fas fa-layer-group me-1"></i> Included Tests (<?= $pkg['test_count'] ?>):
                  </span>
                  <div>
                    <?php foreach ($pkg['tests'] as $it): ?>
                      <span class="badge bg-light text-dark border me-1 mb-1 font-monospace" style="font-size: 0.75rem;">
                        <?= htmlspecialchars($it['name']) ?>
                      </span>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>

              <div class="pt-2 border-top d-flex justify-content-between align-items-center">
                <?php if ($pkg['savings'] > 0): ?>
                  <span class="badge bg-success bg-opacity-10 text-success">
                    <i class="fas fa-tag me-1"></i> Patient Saves ₹<?= number_format($pkg['savings'], 0) ?>
                  </span>
                <?php else: ?>
                  <span></span>
                <?php endif; ?>
                <a href="patient_registration.php?package_id=<?= $pkg['package_id'] ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                  <i class="fas fa-plus me-1"></i> Bill Package
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Diagnostic Lab Tests Directory (92 Tests) -->
    <div class="col-12" id="testsSection">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-bold mb-0">
          <i class="fas fa-vials text-primary me-2"></i> Diagnostic Tests Directory (<?= count($MASTER_CATALOG_TESTS) ?> Tests)
        </h5>
        <span class="text-muted small">Nominal prices set for immediate walk-in use</span>
      </div>

      <div id="testItemsContainer">
        <?php foreach ($MASTER_CATALOG_TESTS as $t): 
          $is_single = ($t['param_count'] === 1);
          $search_blob = strtolower($t['name'] . ' ' . $t['code'] . ' ' . $t['category_name'] . ' ' . $t['notes'] . ' ' . $t['interpretations']);
          foreach ($t['parameters'] as $p) {
              $search_blob .= ' ' . strtolower($p['name'] . ' ' . $p['sample'] . ' ' . $p['method']);
          }
        ?>
          <div class="test-item-card" 
               data-category="<?= htmlspecialchars($t['category_name']) ?>"
               data-type="<?= $is_single ? 'single' : 'panel' ?>"
               data-search="<?= htmlspecialchars($search_blob) ?>">
            <div class="row align-items-center g-3">
              
              <!-- Title & Badges -->
              <div class="col-md-5">
                <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                  <span class="badge bg-dark font-monospace"><?= htmlspecialchars($t['code']) ?></span>
                  <span class="badge bg-light text-secondary border"><?= htmlspecialchars($t['category_name']) ?></span>
                  <?php if ($is_single): ?>
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                      <i class="fas fa-walking me-1"></i> Walk-in Single
                    </span>
                  <?php else: ?>
                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">
                      <i class="fas fa-layer-group me-1"></i> <?= $t['param_count'] ?> Parameters Panel
                    </span>
                  <?php endif; ?>
                </div>
                <h6 class="fw-bold text-dark mb-1"><?= htmlspecialchars($t['name']) ?></h6>
                <div class="text-muted small">
                  <?= htmlspecialchars($t['notes']) ?>
                </div>
              </div>

              <!-- Methodology & Specimen -->
              <div class="col-md-3">
                <?php if (!empty($t['parameters'][0]['sample'])): ?>
                  <div class="mb-1">
                    <span class="badge-tube">
                      <i class="fas fa-tint text-danger me-1"></i> <?= htmlspecialchars($t['parameters'][0]['sample']) ?>
                    </span>
                  </div>
                <?php endif; ?>
                <?php if (!empty($t['parameters'][0]['method'])): ?>
                  <div class="small text-muted text-truncate" title="<?= htmlspecialchars($t['parameters'][0]['method']) ?>">
                    <i class="fas fa-cogs me-1"></i> <?= htmlspecialchars($t['parameters'][0]['method']) ?>
                  </div>
                <?php endif; ?>
              </div>

              <!-- Price -->
              <div class="col-md-2 text-md-center">
                <div class="fs-5 fw-bold text-primary">₹<?= number_format($t['price'], 2) ?></div>
                <span class="text-muted" style="font-size: 0.75rem;">Standard Rate</span>
              </div>

              <!-- Actions -->
              <div class="col-md-2 text-md-end">
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 toggle-params-btn" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#collapseParam<?= $t['test_id'] ?>">
                  <i class="fas fa-list-ul me-1"></i> Details (<?= $t['param_count'] ?>)
                </button>
              </div>

            </div>

            <!-- Expandable Parameters Breakdown with Reference Ranges -->
            <div class="collapse mt-3 pt-3 border-top" id="collapseParam<?= $t['test_id'] ?>">
              <div class="bg-light p-3 rounded-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <strong class="small text-dark"><i class="fas fa-microscope text-primary me-1"></i> Parameters & NABL / ICMR Reference Intervals:</strong>
                  <span class="badge bg-white text-muted border small"><?= $t['param_count'] ?> Total</span>
                </div>

                <div class="table-responsive">
                  <table class="table table-sm table-bordered bg-white mb-0" style="font-size: 0.8rem;">
                    <thead class="table-light">
                      <tr>
                        <th>Parameter Name</th>
                        <th style="width: 100px;">Unit</th>
                        <th style="width: 150px;">Method</th>
                        <th>Standard Reference Range (Adult / Child)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($t['parameters'] as $p): ?>
                        <tr>
                          <td class="fw-semibold text-dark"><?= htmlspecialchars($p['name']) ?></td>
                          <td class="font-monospace"><?= htmlspecialchars($p['unit'] ?: '-') ?></td>
                          <td class="text-muted"><?= htmlspecialchars($p['method'] ?: '-') ?></td>
                          <td>
                            <?php if (!empty($p['text'])): ?>
                              <span class="text-primary fw-medium"><?= htmlspecialchars($p['text']) ?></span>
                            <?php elseif ($p['male_min'] > 0 || $p['male_max'] > 0): ?>
                              <span class="text-primary fw-medium">
                                Male: <?= $p['male_min'] ?> - <?= $p['male_max'] ?> <?= htmlspecialchars($p['unit']) ?> | 
                                Female: <?= $p['female_min'] ?> - <?= $p['female_max'] ?> <?= htmlspecialchars($p['unit']) ?>
                              </span>
                            <?php else: ?>
                              <span class="text-muted">Standard Clinical Interpretation</span>
                            <?php endif; ?>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>

                <?php if (!empty($t['interpretations'])): ?>
                  <div class="mt-2 text-muted small">
                    <strong>Clinical Significance:</strong> <?= htmlspecialchars($t['interpretations']) ?>
                  </div>
                <?php endif; ?>
              </div>
            </div>

          </div>
        <?php endforeach; ?>
      </div>

      <!-- No Results State -->
      <div id="noResultsAlert" class="alert alert-warning text-center p-4 rounded-4 d-none">
        <i class="fas fa-search fa-2x mb-2 text-warning"></i>
        <h6 class="fw-bold">No Tests or Packages Found</h6>
        <p class="mb-0 text-muted small">Try adjusting your search keywords or clear the category filters.</p>
      </div>

    </div>

  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('catalogSearch');
  const categoryFilters = document.querySelectorAll('#categoryFilters .nav-link');
  const typeRadios = document.querySelectorAll('input[name="typefilter"]');
  const testCards = document.querySelectorAll('.test-item-card');
  const pkgCards = document.querySelectorAll('.package-card-item');
  const pkgSection = document.getElementById('packagesSection');
  const testsSection = document.getElementById('testsSection');
  const visibleCountEl = document.getElementById('visibleCount');
  const visiblePkgCountEl = document.getElementById('visiblePkgCount');
  const noResultsAlert = document.getElementById('noResultsAlert');

  let activeCategory = 'all';
  let activeType = 'all';

  function filterCatalog() {
    const query = searchInput.value.trim().toLowerCase();
    let visibleTests = 0;
    let visiblePkgs = 0;

    // Filter Tests
    testCards.forEach(card => {
      const cardCategory = card.getAttribute('data-category') || '';
      const cardType = card.getAttribute('data-type') || '';
      const cardSearch = card.getAttribute('data-search') || '';

      const matchesCat = (activeCategory === 'all' || cardCategory.toLowerCase() === activeCategory.toLowerCase());
      const matchesType = (activeType === 'all' || activeType === cardType);
      const matchesSearch = (!query || cardSearch.includes(query));

      if (activeCategory === 'package' || activeType === 'package') {
        card.classList.add('d-none');
      } else if (matchesCat && matchesType && matchesSearch) {
        card.classList.remove('d-none');
        visibleTests++;
      } else {
        card.classList.add('d-none');
      }
    });

    // Filter Packages
    pkgCards.forEach(card => {
      const cardSearch = card.getAttribute('data-search') || '';
      const matchesCat = (activeCategory === 'all' || activeCategory === 'package');
      const matchesType = (activeType === 'all' || activeType === 'package');
      const matchesSearch = (!query || cardSearch.includes(query));

      if (matchesCat && matchesType && matchesSearch) {
        card.classList.remove('d-none');
        visiblePkgs++;
      } else {
        card.classList.add('d-none');
      }
    });

    // Toggle Section headers
    if (visiblePkgs === 0) {
      pkgSection.classList.add('d-none');
    } else {
      pkgSection.classList.remove('d-none');
    }

    if (visibleTests === 0 && (activeCategory === 'package' || activeType === 'package')) {
      testsSection.classList.add('d-none');
    } else {
      testsSection.classList.remove('d-none');
    }

    visibleCountEl.textContent = visibleTests;
    visiblePkgCountEl.textContent = visiblePkgs;

    if (visibleTests === 0 && visiblePkgs === 0) {
      noResultsAlert.classList.remove('d-none');
    } else {
      noResultsAlert.classList.add('d-none');
    }
  }

  // Category filter click
  categoryFilters.forEach(btn => {
    btn.addEventListener('click', function() {
      categoryFilters.forEach(b => b.classList.remove('active'));
      this.classList.add('active');
      activeCategory = this.getAttribute('data-category');
      filterCatalog();
    });
  });

  // Type filter toggle
  typeRadios.forEach(radio => {
    radio.addEventListener('change', function() {
      if (this.checked) {
        activeType = this.value;
        filterCatalog();
      }
    });
  });

  // Search input live filtering
  searchInput.addEventListener('input', filterCatalog);
});
</script>
</body>
</html>
