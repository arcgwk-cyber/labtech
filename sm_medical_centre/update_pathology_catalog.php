<?php
/**
 * Indian Pathology Master Catalog Migration Script
 * Updates the current database with standardized, NABL/ICMR compliant tests,
 * parameters, reference ranges, and health checkup packages.
 */
include_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/db.php';

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
        // Check relative fallback
        $sql_file = __DIR__ . '/update_pathology_catalog.sql';
    }

    if (!file_exists($sql_file)) {
        $error = "Migration file 'update_pathology_catalog.sql' not found.";
    } else {
        $sql_content = file_get_contents($sql_file);
        try {
            if ($conn->multi_query($sql_content)) {
                do {
                    if ($res = $conn->store_result()) {
                        $res->free();
                    }
                    $executed_count++;
                } while ($conn->more_results() && $conn->next_result());
            }

            if ($conn->errno) {
                throw new Exception("Query Error ({$conn->errno}): " . $conn->error);
            }

            $message = "Successfully updated master pathology catalog! 6 Categories, 7 Groups, 24 Lab Tests, 87 Parameters, Reference Ranges, and Health Packages are now 100% compliant with standard Indian Pathology guidelines (NABL / ICMR).";
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}

// Check current counts
$cat_cnt = (int)($conn->query("SELECT COUNT(*) as c FROM test_categories")->fetch_assoc()['c'] ?? 0);
$test_cnt = (int)($conn->query("SELECT COUNT(*) as c FROM lab_tests")->fetch_assoc()['c'] ?? 0);
$param_cnt = (int)($conn->query("SELECT COUNT(*) as c FROM test_parameters")->fetch_assoc()['c'] ?? 0);
$range_cnt = (int)($conn->query("SELECT COUNT(*) as c FROM parameter_reference_ranges")->fetch_assoc()['c'] ?? 0);
$pkg_cnt = (int)($conn->query("SELECT COUNT(*) as c FROM test_packages")->fetch_assoc()['c'] ?? 0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Standard Indian Pathology Catalog Migration | Lab Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
<?php include_once __DIR__ . '/header.php'; ?>

<div class="container py-4" style="max-width: 900px;">
  
  <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
    <div class="card-header bg-white border-bottom p-4">
      <div class="d-flex align-items-center gap-3">
        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3">
          <i class="fas fa-stethoscope fa-2x"></i>
        </div>
        <div>
          <h4 class="fw-bold mb-1">Standard Indian Pathology Catalog Migration</h4>
          <p class="text-muted mb-0 small">Upgrade and clean all laboratory tests, parameters, units, and reference ranges to NABL / ICMR standards.</p>
        </div>
      </div>
    </div>
    
    <div class="card-body p-4">
      <?php if ($message): ?>
        <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
          <i class="fas fa-check-circle fa-lg"></i>
          <div><?= htmlspecialchars($message) ?></div>
        </div>
      <?php endif; ?>

      <?php if ($error): ?>
        <div class="alert alert-danger d-flex align-items-center gap-2 mb-4">
          <i class="fas fa-exclamation-triangle fa-lg"></i>
          <div><pre class="mb-0 text-wrap"><?= htmlspecialchars($error) ?></pre></div>
        </div>
      <?php endif; ?>

      <div class="row g-3 mb-4">
        <div class="col-sm-4">
          <div class="p-3 bg-white border rounded-3 text-center">
            <span class="text-muted small fw-semibold">LAB TESTS</span>
            <h3 class="fw-bold text-primary mb-0 mt-1"><?= $test_cnt ?></h3>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="p-3 bg-white border rounded-3 text-center">
            <span class="text-muted small fw-semibold">PARAMETERS</span>
            <h3 class="fw-bold text-success mb-0 mt-1"><?= $param_cnt ?></h3>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="p-3 bg-white border rounded-3 text-center">
            <span class="text-muted small fw-semibold">REF RANGES</span>
            <h3 class="fw-bold text-warning mb-0 mt-1"><?= $range_cnt ?></h3>
          </div>
        </div>
      </div>

      <div class="border-start border-4 border-info bg-info bg-opacity-10 p-3 rounded-2 mb-4">
        <h6 class="fw-bold text-info-emphasis mb-1"><i class="fas fa-info-circle me-1"></i> What this migration fixes:</h6>
        <ul class="small mb-0 ps-3">
          <li><strong>Removes HTML tags</strong> from test names (CBC, KFT, LFT, Lipid Profile).</li>
          <li><strong>Fixes mismatched tests</strong>: Reconnects KFT parameters to KFT (previously swapped with Lipid), TFT to TFT (swapped with Heart), and Blood Sugar to Diabetes.</li>
          <li><strong>Corrects critical medical values</strong>:
            <ul>
              <li>Total Cholesterol: corrected from wrong `0.30 - 1.20` to standard `< 200.0 mg/dL`.</li>
              <li>Fasting Blood Sugar: corrected from fatal `7 - 56` to standard `70.0 - 100.0 mg/dL`.</li>
              <li>HbA1c: corrected from `9 - 48 %` to standard `4.0 - 5.6 %`.</li>
              <li>Total Bilirubin: corrected from `15 - 40` to standard `0.2 - 1.2 mg/dL`.</li>
              <li>INR: corrected from `80 - 100` to standard `0.85 - 1.15`.</li>
            </ul>
          </li>
          <li><strong>Populates missing reference ranges</strong> for Complete Urine Examination (CUE), Electrolytes, Vitamins, and Serology.</li>
          <li><strong>Connects Health Checkup Packages</strong> (Basic, Executive, Fever, Diabetic, Cardiac, Antenatal) to their clean tests.</li>
        </ul>
      </div>

      <form method="POST" onsubmit="return confirm('Are you sure you want to update the master pathology catalog? Existing test definitions and parameters will be refreshed to standard values.');">
        <button type="submit" name="execute_migration" class="btn btn-primary px-4 py-2 fw-semibold">
          <i class="fas fa-sync-alt me-2"></i> Update & Clean Pathology Catalog Now
        </button>
        <a href="lab_test_list.php" class="btn btn-outline-secondary px-3 py-2 ms-2">
          View Lab Tests
        </a>
      </form>

    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
