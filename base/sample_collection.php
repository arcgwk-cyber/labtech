<?php
/**
 * Professional Laboratory Phlebotomy & Sample Collection Workstation
 * - Multi-view dashboard: Pending Collection & Collected Records
 * - Intelligent vacutainer color-coded tube recommendation (EDTA, SST, Fluoride, Citrate, etc.)
 * - 1-Click Fast Collection & Bulk Multi-Sample Collection
 * - Code 128 Specimen Barcode & Thermal Tube Sticker Generator
 * - Real-time search, date filtering, and direct links to Result Entry & Bill Printing
 */
include_once 'auth_check.php';
include_once 'db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current_user_id = $_SESSION['user_id'] ?? 1;
$current_role    = $_SESSION['role'] ?? 'user';

// Ensure no duplicate sample rows exist for the same bill_id
$conn->query("
    DELETE ts1 FROM test_samples ts1
    INNER JOIN test_samples ts2 
    WHERE ts1.sample_id < ts2.sample_id AND ts1.bill_id = ts2.bill_id
");
@$conn->query("ALTER TABLE test_samples ADD UNIQUE KEY uq_bill_sample (bill_id)");


// ============================================================================
// 1. STANDALONE PRINT BARCODE LABEL VIEW
// ============================================================================
if (isset($_GET['action']) && $_GET['action'] === 'print_label') {
    $label_bill_id = (int)($_GET['bill_id'] ?? 0);
    if ($label_bill_id <= 0) {
        die("Invalid Bill ID for label printing.");
    }

    $b_stmt = $conn->prepare("
        SELECT b.bill_id, b.bill_date, p.full_name, p.gender, p.age, p.phone, p.dr_ref
        FROM bills b
        JOIN patients p ON b.patient_id = p.patient_id
        WHERE b.bill_id = ?
    ");
    $b_stmt->bind_param("i", $label_bill_id);
    $b_stmt->execute();
    $p_data = $b_stmt->get_result()->fetch_assoc();
    $b_stmt->close();

    if (!$p_data) {
        die("Bill #{$label_bill_id} not found.");
    }

    // Fetch tests
    $tests = [];
    $t_res = $conn->query("
        SELECT t.test_name FROM bill_tests bt 
        JOIN lab_tests t ON bt.test_id = t.test_id 
        WHERE bt.bill_id = $label_bill_id
    ");
    if ($t_res) {
        while ($tr = $t_res->fetch_assoc()) $tests[] = $tr['test_name'];
    }
    $p_res = $conn->query("
        SELECT p.package_name FROM bill_packages bp 
        JOIN test_packages p ON bp.package_id = p.package_id 
        WHERE bp.bill_id = $label_bill_id
    ");
    if ($p_res) {
        while ($pr = $p_res->fetch_assoc()) $tests[] = $pr['package_name'];
    }

    // Barcode Generation
    $barcode_svg = '';
    if (file_exists(__DIR__ . '/TCPDF/tcpdf_barcodes_1d.php')) {
        require_once __DIR__ . '/TCPDF/tcpdf_barcodes_1d.php';
        try {
            $bc = new TCPDFBarcode((string)$label_bill_id, 'C128');
            // Use getBarcodeSVGcode to return SVG markup WITHOUT sending HTTP download headers!
            $barcode_svg = $bc->getBarcodeSVGcode(1.5, 24, 'black');
            if ($barcode_svg) {
                // Strip XML declaration and doctype so it embeds cleanly in HTML5
                $barcode_svg = preg_replace('/<\?xml.*?\?>/is', '', $barcode_svg);
                $barcode_svg = preg_replace('/<!DOCTYPE.*?>/is', '', $barcode_svg);
            }
        } catch (Exception $e) {
            $barcode_svg = '';
        }
    }

    // Lab Name
    $lab_title = 'Diagnostic Centre ERP';
    $adm = $conn->query("SELECT company_name FROM admin_settings WHERE id = 1 LIMIT 1");
    if ($adm && $ar = $adm->fetch_assoc()) {
        if (!empty($ar['company_name'])) $lab_title = trim($ar['company_name']);
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <title>Specimen Label - Bill #<?= $label_bill_id ?></title>
      <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
      <style>
        @page {
          size: 50mm 28mm;
          margin: 0;
        }
        * {
          box-sizing: border-box;
        }
        body {
          margin: 0;
          padding: 0;
          font-family: Arial, -apple-system, BlinkMacSystemFont, sans-serif;
          color: #000000;
          background: #f8fafc;
          display: flex;
          align-items: center;
          justify-content: center;
          min-height: 100vh;
        }
        .sticker-card {
          width: 50mm;
          height: 28mm;
          max-height: 28mm;
          padding: 1.5mm 2.5mm;
          background: #ffffff;
          border: 1px dashed #94a3b8;
          border-radius: 4px;
          display: flex;
          flex-direction: column;
          justify-content: space-between;
          overflow: hidden;
          box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .lab-name {
          font-size: 6pt;
          font-weight: 800;
          text-transform: uppercase;
          text-align: center;
          border-bottom: 0.5pt solid #000;
          padding-bottom: 1px;
          white-space: nowrap;
          overflow: hidden;
          text-overflow: ellipsis;
          line-height: 1.1;
        }
        .patient-row {
          font-weight: 800;
          font-size: 7.5pt;
          white-space: nowrap;
          overflow: hidden;
          text-overflow: ellipsis;
          line-height: 1.15;
          margin-top: 1px;
        }
        .info-row {
          font-size: 6.5pt;
          display: flex;
          justify-content: space-between;
          line-height: 1.1;
        }
        .barcode-container {
          text-align: center;
          margin: 1px 0;
          overflow: hidden;
        }
        .barcode-container svg {
          max-width: 100%;
          height: 22px;
          display: block;
          margin: 0 auto;
        }
        .test-list {
          font-size: 6pt;
          white-space: nowrap;
          overflow: hidden;
          text-overflow: ellipsis;
          border-top: 0.5pt solid #000;
          padding-top: 1px;
          line-height: 1;
        }
        @media print {
          body {
            background: #ffffff !important;
            min-height: auto !important;
            display: block !important;
            padding: 0 !important;
            margin: 0 !important;
          }
          .sticker-card {
            border: none !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            width: 50mm !important;
            height: 28mm !important;
            padding: 1.5mm 2mm !important;
            page-break-inside: avoid !important;
          }
          .no-print {
            display: none !important;
          }
        }
      
    /* ==========================================================
       NATIVE MOBILE APP RESPONSIVE CARDS (sample_collection)
       ========================================================== */
    @media (max-width: 991.98px) {
      .page-container {
        padding: 0 10px !important;
        margin: 10px auto !important;
      }
      .phleb-header-card {
        padding: 12px 16px !important;
        margin-bottom: 12px !important;
      }
      .phleb-title {
        font-size: 1.15rem !important;
      }
      .phleb-kpi-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 8px !important;
        margin-bottom: 12px !important;
      }
      .kpi-card {
        padding: 10px 12px !important;
      }
      .kpi-val {
        font-size: 1.25rem !important;
      }
      .phleb-filter-card {
        padding: 10px 12px !important;
        margin-bottom: 12px !important;
      }
      .phleb-filter-card .col-md-4,
      .phleb-filter-card .col-md-2,
      .phleb-filter-card .col-auto {
        width: 100% !important;
        flex: 1 1 100% !important;
      }
      .phleb-filter-card .col-auto {
        display: flex !important;
        gap: 8px !important;
      }
      .phleb-filter-card .col-auto button,
      .phleb-filter-card .col-auto a {
        flex: 1 !important;
        justify-content: center !important;
      }

      /* Transform Sample Tables to Mobile Cards */
      .station-table thead {
        display: none !important;
      }
      .station-table, .station-table tbody, .station-table tr {
        display: block !important;
        width: 100% !important;
      }
      .station-table tr {
        background: #ffffff !important;
        border: 1px solid var(--border-color) !important;
        border-radius: 12px !important;
        padding: 14px !important;
        margin-bottom: 12px !important;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04) !important;
      }
      .station-table td {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        padding: 6px 0 !important;
        border: none !important;
        border-bottom: 1px solid var(--border-light) !important;
      }
      .station-table td:last-child {
        border-bottom: none !important;
        padding-top: 10px !important;
        flex-direction: column !important;
        align-items: stretch !important;
      }
      .station-table td::before {
        content: attr(data-label);
        font-weight: 700;
        font-size: 11px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
      }
      .station-table td:last-child::before,
      .station-table td.td-checkbox::before {
        display: none !important;
      }
      .station-table td.td-checkbox {
        justify-content: flex-start !important;
        padding-bottom: 4px !important;
      }
      .station-table td:last-child .d-flex {
        width: 100% !important;
      }
      .station-table td:last-child .d-flex button,
      .station-table td:last-child .d-flex a {
        flex: 1 !important;
        justify-content: center !important;
        padding: 8px 10px !important;
      }
    }

  </style>
    </head>
    <body>
      <div class="sticker-card">
        <div class="lab-name"><?= htmlspecialchars($lab_title) ?></div>
        <div class="patient-row"><?= htmlspecialchars($p_data['full_name']) ?></div>
        <div class="info-row">
          <span><?= htmlspecialchars($p_data['gender'] ?: 'M') ?> / <?= htmlspecialchars($p_data['age'] ?: '-') ?>Y</span>
          <span>ID: <strong>#<?= $label_bill_id ?></strong></span>
        </div>
        <div class="barcode-container">
          <?php if (!empty($barcode_svg)): ?>
            <?= $barcode_svg ?>
          <?php else: ?>
            <svg id="js-barcode"></svg>
            <script>
              try {
                JsBarcode("#js-barcode", "<?= htmlspecialchars($label_bill_id) ?>", {
                  format: "CODE128",
                  width: 1.4,
                  height: 20,
                  displayValue: false,
                  margin: 0
                });
              } catch(e) {}
            </script>
          <?php endif; ?>
        </div>
        <div class="info-row">
          <span><?= date('d-M-y H:i') ?></span>
          <span><?= htmlspecialchars($p_data['dr_ref'] ? 'Ref: '.$p_data['dr_ref'] : 'Self') ?></span>
        </div>
        <div class="test-list">
          <?= htmlspecialchars(implode(', ', array_slice($tests, 0, 4)) ?: 'Routine Pathology') ?>
        </div>
      </div>
    </body>
    </html>
    <?php
    exit;
}

// ============================================================================
// 2. SERVER-SIDE ACTION HANDLER (COLLECT / BULK / REVERT)
// ============================================================================
$is_ajax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') 
        || (isset($_POST['ajax']) && $_POST['ajax'] == '1');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // A. Single Sample Collection
    if ($action === 'collect_single') {
        $bill_id = (int)($_POST['bill_id'] ?? 0);
        $sample_type = trim($_POST['sample_type'] ?? 'Blood');
        $notes = trim($_POST['notes'] ?? '');

        if ($bill_id <= 0) {
            $msg = 'Invalid bill ID.';
            if ($is_ajax) { echo json_encode(['status' => 'error', 'message' => $msg]); exit; }
            $_SESSION['alert'] = ['type' => 'danger', 'msg' => $msg];
            header("Location: sample_collection.php");
            exit;
        }

        // Upsert sample status and clean any duplicate rows
        $chk = $conn->query("SELECT sample_id FROM test_samples WHERE bill_id = $bill_id ORDER BY sample_id DESC");
        if ($chk && $chk->num_rows > 0) {
            $rows = $chk->fetch_all(MYSQLI_ASSOC);
            $sid = (int)$rows[0]['sample_id'];
            $conn->query("UPDATE test_samples SET status = 'collected', sample_date = NOW(), collected_by = $current_user_id WHERE sample_id = $sid");
            if (count($rows) > 1) {
                $conn->query("DELETE FROM test_samples WHERE bill_id = $bill_id AND sample_id != $sid");
            }
        } else {
            $conn->query("INSERT INTO test_samples (bill_id, sample_date, collected_by, status) VALUES ($bill_id, NOW(), $current_user_id, 'collected')");
        }

        // Update bills sample_collected flag if column exists
        $conn->query("UPDATE bills SET sample_collected = 1 WHERE bill_id = $bill_id");

        $success_msg = "Sample for Bill #{$bill_id} marked as Collected successfully.";
        if ($is_ajax) {
            echo json_encode(['status' => 'success', 'message' => $success_msg, 'bill_id' => $bill_id]);
            exit;
        }
        $_SESSION['alert'] = ['type' => 'success', 'msg' => $success_msg];
        header("Location: sample_collection.php");
        exit;
    }

    // B. Bulk Sample Collection
    if ($action === 'collect_bulk') {
        $bill_ids = $_POST['selected_bills'] ?? [];
        if (is_array($bill_ids) && count($bill_ids) > 0) {
            $count = 0;
            foreach ($bill_ids as $bid) {
                $bid = (int)$bid;
                if ($bid <= 0) continue;

                $chk = $conn->query("SELECT sample_id FROM test_samples WHERE bill_id = $bid ORDER BY sample_id DESC");
                if ($chk && $chk->num_rows > 0) {
                    $rows = $chk->fetch_all(MYSQLI_ASSOC);
                    $sid = (int)$rows[0]['sample_id'];
                    $conn->query("UPDATE test_samples SET status = 'collected', sample_date = NOW(), collected_by = $current_user_id WHERE sample_id = $sid");
                    if (count($rows) > 1) {
                        $conn->query("DELETE FROM test_samples WHERE bill_id = $bid AND sample_id != $sid");
                    }
                } else {
                    $conn->query("INSERT INTO test_samples (bill_id, sample_date, collected_by, status) VALUES ($bid, NOW(), $current_user_id, 'collected')");
                }
                $conn->query("UPDATE bills SET sample_collected = 1 WHERE bill_id = $bid");
                $count++;
            }
            $msg = "Successfully marked {$count} samples as Collected!";
            if ($is_ajax) { echo json_encode(['status' => 'success', 'message' => $msg]); exit; }
            $_SESSION['alert'] = ['type' => 'success', 'msg' => $msg];
        } else {
            $msg = "No bills selected for bulk collection.";
            if ($is_ajax) { echo json_encode(['status' => 'warning', 'message' => $msg]); exit; }
            $_SESSION['alert'] = ['type' => 'warning', 'msg' => $msg];
        }
        header("Location: sample_collection.php");
        exit;
    }

    // C. Revert / Undo Collection back to Pending
    if ($action === 'revert_sample') {
        $bill_id = (int)($_POST['bill_id'] ?? 0);
        if ($bill_id > 0) {
            // Check if results already entered
            $res_chk = $conn->query("SELECT COUNT(*) as cnt FROM test_results WHERE bill_id = $bill_id");
            $has_res = $res_chk ? $res_chk->fetch_assoc()['cnt'] : 0;

            if ($has_res > 0 && $current_role !== 'admin') {
                $msg = "Cannot revert: Test results have already been entered for Bill #{$bill_id}. Only admins can revert.";
                if ($is_ajax) { echo json_encode(['status' => 'error', 'message' => $msg]); exit; }
                $_SESSION['alert'] = ['type' => 'danger', 'msg' => $msg];
            } else {
                $conn->query("UPDATE test_samples SET status = 'pending', sample_date = NULL WHERE bill_id = $bill_id");
                $conn->query("UPDATE bills SET sample_collected = 0 WHERE bill_id = $bill_id");
                $conn->query("
                    DELETE ts1 FROM test_samples ts1
                    INNER JOIN test_samples ts2 
                    WHERE ts1.sample_id < ts2.sample_id AND ts1.bill_id = ts2.bill_id AND ts1.bill_id = $bill_id
                ");
                $msg = "Sample for Bill #{$bill_id} reverted back to Pending.";
                if ($is_ajax) { echo json_encode(['status' => 'success', 'message' => $msg]); exit; }
                $_SESSION['alert'] = ['type' => 'info', 'msg' => $msg];
            }
        }
        header("Location: sample_collection.php?tab=collected");
        exit;
    }
}

// ============================================================================
// 3. FILTERING & PARAMETERS
// ============================================================================
$active_tab = $_GET['tab'] ?? 'pending'; // 'pending' or 'collected'
$search_q   = trim($_GET['q'] ?? '');
$start_date = trim($_GET['start_date'] ?? '');
$end_date   = trim($_GET['end_date'] ?? '');
$res_filter = trim($_GET['result_filter'] ?? ''); // 'entered', 'pending', ''

// ============================================================================
// 4. OVERALL METRICS
// ============================================================================
$today = date('Y-m-d');
$m_pending = $conn->query("
    SELECT COUNT(DISTINCT b.bill_id) as total 
    FROM bills b 
    LEFT JOIN test_samples ts ON b.bill_id = ts.bill_id 
    WHERE ts.sample_id IS NULL OR ts.status = 'pending'
")->fetch_assoc()['total'] ?? 0;

$m_collected_today = $conn->query("
    SELECT COUNT(DISTINCT bill_id) as total 
    FROM test_samples 
    WHERE status IN ('collected', 'completed', 'processing') AND DATE(sample_date) = '$today'
")->fetch_assoc()['total'] ?? 0;

$m_pending_results = $conn->query("
    SELECT COUNT(DISTINCT ts.bill_id) as total 
    FROM test_samples ts
    WHERE ts.status = 'collected' 
      AND NOT EXISTS (SELECT 1 FROM test_results tr WHERE tr.bill_id = ts.bill_id)
")->fetch_assoc()['total'] ?? 0;

$m_completed = $conn->query("
    SELECT COUNT(DISTINCT bill_id) as total 
    FROM test_results
")->fetch_assoc()['total'] ?? 0;

// ============================================================================
// 5. QUERY BUILDERS
// ============================================================================
// Helper for Tube Recommendations
function getTubeRecommendations($tests_list_str) {
    $tubes = [];
    $str = strtolower($tests_list_str);

    // EDTA Lavender
    if (preg_match('/(cbc|hemogram|edta|hba1c|esr|platelet|blood group|wbc|rbc|reticulocyte|malaria|ps for mp|smear)/i', $str)) {
        $tubes[] = ['type' => 'EDTA Whole Blood', 'color' => '#8b5cf6', 'tube' => 'Lavender Tube'];
    }
    // Serum / SST
    if (preg_match('/(lft|kft|rft|lipid|thyroid|tsh|t3|t4|creatinine|urea|uric|calcium|bilirubin|sgpt|sgot|protein|albumin|electrolyte|crp|ra factor|serology|widal|hiv|hbsag|vdrl|d-3|b12|ferritin|iron|profile|test)/i', $str)) {
        $tubes[] = ['type' => 'Serum (SST)', 'color' => '#eab308', 'tube' => 'Yellow / Red Tube'];
    }
    // Fluoride Grey
    if (preg_match('/(sugar|glucose|fbs|ppbs|rbs|gtt|ogtt|fluoride)/i', $str)) {
        $tubes[] = ['type' => 'Fluoride Plasma', 'color' => '#94a3b8', 'tube' => 'Grey Tube'];
    }
    // Citrate Blue
    if (preg_match('/(pt|inr|aptt|coagulation|citrate|d-dimer|fibrinogen)/i', $str)) {
        $tubes[] = ['type' => 'Sodium Citrate', 'color' => '#0284c7', 'tube' => 'Blue Tube'];
    }
    // Urine / Sterile Cup
    if (preg_match('/(urine|routine|microscopy|pregnancy|upt|culture|pus|stool|semen)/i', $str)) {
        $tubes[] = ['type' => 'Urine / Specimen', 'color' => '#10b981', 'tube' => 'Sterile Cup'];
    }

    // Default fallback
    if (empty($tubes)) {
        $tubes[] = ['type' => 'Standard Specimen', 'color' => '#64748b', 'tube' => 'Routine Tube'];
    }
    return $tubes;
}

// A. PENDING SAMPLES QUERY
$pending_sql = "
    SELECT b.bill_id, b.bill_date, b.total_amount,
           p.patient_id, p.full_name, p.gender, p.age, p.phone, p.dr_ref
    FROM bills b
    JOIN patients p ON b.patient_id = p.patient_id
    LEFT JOIN test_samples ts ON b.bill_id = ts.bill_id
    WHERE (ts.sample_id IS NULL OR ts.status = 'pending')
      AND NOT EXISTS (
          SELECT 1 FROM test_samples ts2 
          WHERE ts2.bill_id = b.bill_id AND ts2.status IN ('collected', 'completed', 'processing')
      )
";
$p_conditions = [];
if (!empty($search_q)) {
    $esc = $conn->real_escape_string($search_q);
    $p_conditions[] = "(p.full_name LIKE '%$esc%' OR p.phone LIKE '%$esc%' OR b.bill_id = '$esc')";
}
if (!empty($start_date) && !empty($end_date)) {
    $s_esc = $conn->real_escape_string($start_date);
    $e_esc = $conn->real_escape_string($end_date);
    $p_conditions[] = "(b.bill_date BETWEEN '$s_esc' AND '$e_esc')";
}
if (!empty($p_conditions)) {
    $pending_sql .= " AND " . implode(" AND ", $p_conditions);
}
$pending_sql .= " GROUP BY b.bill_id ORDER BY b.bill_id DESC LIMIT 100";
$pending_res = $conn->query($pending_sql);

// B. COLLECTED SAMPLES QUERY
$collected_sql = "
    SELECT b.bill_id, b.bill_date, b.total_amount,
           p.patient_id, p.full_name, p.gender, p.age, p.phone, p.dr_ref,
           MAX(ts.sample_id) as sample_id, 
           MAX(ts.sample_date) as sample_date, 
           MAX(ts.status) as sample_status,
           MAX(u.full_name) as phlebotomist_name, 
           MAX(u.username) as phlebotomist_user,
           (SELECT COUNT(*) FROM test_results tr WHERE tr.bill_id = b.bill_id) as result_count
    FROM bills b
    JOIN patients p ON b.patient_id = p.patient_id
    JOIN test_samples ts ON b.bill_id = ts.bill_id
    LEFT JOIN users u ON ts.collected_by = u.user_id
    WHERE ts.status IN ('collected', 'completed', 'processing')
";
$c_conditions = [];
if (!empty($search_q)) {
    $esc = $conn->real_escape_string($search_q);
    $c_conditions[] = "(p.full_name LIKE '%$esc%' OR p.phone LIKE '%$esc%' OR b.bill_id = '$esc')";
}
if (!empty($start_date) && !empty($end_date)) {
    $s_esc = $conn->real_escape_string($start_date);
    $e_esc = $conn->real_escape_string($end_date);
    $c_conditions[] = "(DATE(ts.sample_date) BETWEEN '$s_esc' AND '$e_esc')";
}
if (!empty($c_conditions)) {
    $collected_sql .= " AND " . implode(" AND ", $c_conditions);
}

$collected_sql .= " GROUP BY b.bill_id";

if ($res_filter === 'entered') {
    $collected_sql .= " HAVING result_count > 0";
} elseif ($res_filter === 'pending') {
    $collected_sql .= " HAVING result_count = 0";
}
$collected_sql .= " ORDER BY sample_date DESC LIMIT 100";
$collected_res = $conn->query($collected_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Phlebotomy & Sample Collection Station | Laboratory ERP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --brand-primary: #0284c7;
      --brand-dark: #0369a1;
      --brand-light: #f0f9ff;
      --brand-success: #10b981;
      --brand-warning: #f59e0b;
      --brand-danger: #ef4444;
      --surface-bg: #f8fafc;
      --card-bg: #ffffff;
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
      max-width: 1440px;
      margin: 22px auto;
      padding: 0 18px;
    }

    /* Top Workstation Header */
    .phleb-header-card {
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
    .phleb-title {
      font-size: 1.34rem;
      font-weight: 800;
      color: var(--text-main);
      margin: 0;
      display: flex;
      align-items: center;
      gap: 10px;
      letter-spacing: -0.3px;
    }
    .phleb-title i {
      color: #ef4444;
    }

    /* Metrics Grid */
    .metrics-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
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
      transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .metric-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(15, 23, 42, 0.06);
    }
    .metric-icon-box {
      width: 48px;
      height: 48px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.35rem;
    }
    .metric-val {
      font-size: 1.65rem;
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

    /* Workstation Main Card */
    .station-card {
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 14px;
      box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.04);
      padding: 0;
      overflow: hidden;
    }

    /* Navigation Tabs */
    .station-tabs-nav {
      display: flex;
      background: #f8fafc;
      border-bottom: 1px solid var(--border-color);
      padding: 6px 16px 0 16px;
      gap: 6px;
    }
    .station-tab-btn {
      padding: 12px 20px;
      font-size: 0.88rem;
      font-weight: 700;
      color: #64748b;
      border: none;
      background: transparent;
      border-radius: 8px 8px 0 0;
      display: flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      text-decoration: none;
      position: relative;
      transition: all 0.15s ease;
    }
    .station-tab-btn:hover {
      color: var(--brand-primary);
      background: #f1f5f9;
    }
    .station-tab-btn.active {
      color: var(--brand-primary);
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-bottom-color: #ffffff;
      margin-bottom: -1px;
    }
    .station-tab-btn .badge {
      font-size: 0.72rem;
      padding: 2px 7px;
      border-radius: 10px;
    }

    /* Filter & Search Bar */
    .station-filter-bar {
      padding: 16px 20px;
      background: #ffffff;
      border-bottom: 1px solid var(--border-light);
    }
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

    /* Floating Bulk Action Bar */
    .bulk-action-bar {
      background: #0f172a;
      color: #ffffff;
      padding: 10px 18px;
      border-radius: 10px;
      margin: 12px 20px 0 20px;
      display: none;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 6px 20px rgba(15, 23, 42, 0.2);
      animation: fadeIn 0.2s ease;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-6px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Workstation Table */
    .table-container {
      overflow-x: auto;
    }
    .station-table {
      width: 100%;
      border-collapse: collapse;
      margin: 0;
    }
    .station-table th {
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
    .station-table td {
      padding: 12px 16px;
      vertical-align: middle;
      border-bottom: 1px solid var(--border-light);
      background: #ffffff;
    }
    .station-table tr:hover td {
      background-color: #fafbfc;
    }

    /* Specimen Tube Tag */
    .tube-tag {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      font-size: 0.72rem;
      font-weight: 700;
      padding: 2px 7px;
      border-radius: 6px;
      margin: 2px 2px;
      white-space: nowrap;
    }
    .tube-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      display: inline-block;
    }

    /* Action Buttons */
    .btn-collect-fast {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      color: #ffffff;
      font-weight: 700;
      font-size: 0.82rem;
      padding: 6px 14px;
      border-radius: 7px;
      border: none;
      transition: all 0.15s ease;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      white-space: nowrap;
    }
    .btn-collect-fast:hover {
      background: linear-gradient(135deg, #059669 0%, #047857 100%);
      color: #ffffff;
      box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
      transform: translateY(-1px);
    }
    .btn-label-print {
      color: #0284c7;
      background: #f0f9ff;
      border: 1px solid #bae6fd;
      font-size: 0.8rem;
      font-weight: 600;
      padding: 6px 10px;
      border-radius: 7px;
      transition: all 0.15s ease;
    }
    .btn-label-print:hover {
      background: #0284c7;
      color: #ffffff;
      border-color: #0284c7;
    }
  
    /* ==========================================================
       NATIVE MOBILE APP RESPONSIVE CARDS (sample_collection)
       ========================================================== */
    @media (max-width: 991.98px) {
      .page-container {
        padding: 0 10px !important;
        margin: 10px auto !important;
      }
      .phleb-header-card {
        padding: 12px 16px !important;
        margin-bottom: 12px !important;
      }
      .phleb-title {
        font-size: 1.15rem !important;
      }
      .phleb-kpi-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 8px !important;
        margin-bottom: 12px !important;
      }
      .kpi-card {
        padding: 10px 12px !important;
      }
      .kpi-val {
        font-size: 1.25rem !important;
      }
      .phleb-filter-card {
        padding: 10px 12px !important;
        margin-bottom: 12px !important;
      }
      .phleb-filter-card .col-md-4,
      .phleb-filter-card .col-md-2,
      .phleb-filter-card .col-auto {
        width: 100% !important;
        flex: 1 1 100% !important;
      }
      .phleb-filter-card .col-auto {
        display: flex !important;
        gap: 8px !important;
      }
      .phleb-filter-card .col-auto button,
      .phleb-filter-card .col-auto a {
        flex: 1 !important;
        justify-content: center !important;
      }

      /* Transform Sample Tables to Mobile Cards */
      .station-table thead {
        display: none !important;
      }
      .station-table, .station-table tbody, .station-table tr {
        display: block !important;
        width: 100% !important;
      }
      .station-table tr {
        background: #ffffff !important;
        border: 1px solid var(--border-color) !important;
        border-radius: 12px !important;
        padding: 14px !important;
        margin-bottom: 12px !important;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04) !important;
      }
      .station-table td {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        padding: 6px 0 !important;
        border: none !important;
        border-bottom: 1px solid var(--border-light) !important;
      }
      .station-table td:last-child {
        border-bottom: none !important;
        padding-top: 10px !important;
        flex-direction: column !important;
        align-items: stretch !important;
      }
      .station-table td::before {
        content: attr(data-label);
        font-weight: 700;
        font-size: 11px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
      }
      .station-table td:last-child::before,
      .station-table td.td-checkbox::before {
        display: none !important;
      }
      .station-table td.td-checkbox {
        justify-content: flex-start !important;
        padding-bottom: 4px !important;
      }
      .station-table td:last-child .d-flex {
        width: 100% !important;
      }
      .station-table td:last-child .d-flex button,
      .station-table td:last-child .d-flex a {
        flex: 1 !important;
        justify-content: center !important;
        padding: 8px 10px !important;
      }
    }

  </style>
</head>
<body>

<?php include_once __DIR__ . '/header.php'; ?>

<div class="page-container">

  <!-- Header Card -->
  <div class="phleb-header-card">
    <div>
      <h1 class="phleb-title">
        <i class="bi bi-droplet-half"></i> Phlebotomy & Sample Collection Station
      </h1>
      <div class="text-muted small mt-1">
        Manage biological specimens, print thermal barcode tube stickers, and hand off collected samples for clinical analysis.
      </div>
    </div>
    <div class="d-flex align-items-center gap-2">
      <a href="bill_list.php" class="btn btn-outline-secondary btn-sm fw-semibold">
        <i class="bi bi-receipt me-1"></i> Invoices
      </a>
      <a href="bill_add.php" class="btn btn-outline-primary btn-sm fw-semibold">
        <i class="bi bi-plus-lg me-1"></i> New Bill
      </a>
      <button onclick="window.location.reload()" class="btn btn-light btn-sm border" title="Refresh list">
        <i class="bi bi-arrow-clockwise"></i>
      </button>
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

  <!-- Metrics Overview Cards -->
  <div class="metrics-grid">
    <div class="metric-card">
      <div class="metric-icon-box" style="background: #fff7ed; color: #ea580c;">
        <i class="bi bi-hourglass-top"></i>
      </div>
      <div>
        <div class="metric-val" style="color: #ea580c;"><?= number_format($m_pending) ?></div>
        <div class="metric-label">Waiting Collection</div>
      </div>
    </div>

    <div class="metric-card">
      <div class="metric-icon-box" style="background: #f0fdf4; color: #16a34a;">
        <i class="bi bi-droplet-fill"></i>
      </div>
      <div>
        <div class="metric-val" style="color: #16a34a;"><?= number_format($m_collected_today) ?></div>
        <div class="metric-label">Collected Today</div>
      </div>
    </div>

    <div class="metric-card">
      <div class="metric-icon-box" style="background: #fefce8; color: #ca8a04;">
        <i class="bi bi-clipboard-pulse"></i>
      </div>
      <div>
        <div class="metric-val" style="color: #ca8a04;"><?= number_format($m_pending_results) ?></div>
        <div class="metric-label">Testing In Progress</div>
      </div>
    </div>

    <div class="metric-card">
      <div class="metric-icon-box" style="background: #f0f9ff; color: #0284c7;">
        <i class="bi bi-check-all"></i>
      </div>
      <div>
        <div class="metric-val" style="color: #0284c7;"><?= number_format($m_completed) ?></div>
        <div class="metric-label">Results Completed</div>
      </div>
    </div>
  </div>

  <!-- Main Workstation Box -->
  <div class="station-card">

    <!-- Tabs Header -->
    <div class="station-tabs-nav">
      <a href="sample_collection.php?tab=pending" class="station-tab-btn <?= $active_tab === 'pending' ? 'active' : '' ?>">
        <i class="bi bi-clock-history text-warning"></i> Pending Collection
        <span class="badge <?= $active_tab === 'pending' ? 'bg-warning text-dark' : 'bg-secondary' ?>"><?= $m_pending ?></span>
      </a>
      <a href="sample_collection.php?tab=collected" class="station-tab-btn <?= $active_tab === 'collected' ? 'active' : '' ?>">
        <i class="bi bi-check2-circle text-success"></i> Collected Specimens
        <span class="badge <?= $active_tab === 'collected' ? 'bg-success' : 'bg-secondary' ?>"><?= $m_collected_today ?></span>
      </a>
    </div>

    <!-- Filter & Search Controls -->
    <div class="station-filter-bar">
      <form method="GET" action="sample_collection.php" class="row g-2 align-items-center">
        <input type="hidden" name="tab" value="<?= htmlspecialchars($active_tab) ?>">

        <div class="col-md-4 col-12">
          <div class="input-group">
            <span class="input-group-text bg-light text-muted"><i class="bi bi-search"></i></span>
            <input type="text" name="q" class="form-control" placeholder="Search by Patient Name, Phone or Bill #..." value="<?= htmlspecialchars($search_q) ?>">
          </div>
        </div>

        <div class="col-md-2 col-6">
          <input type="date" name="start_date" class="form-control" value="<?= htmlspecialchars($start_date) ?>" title="From Date">
        </div>

        <div class="col-md-2 col-6">
          <input type="date" name="end_date" class="form-control" value="<?= htmlspecialchars($end_date) ?>" title="To Date">
        </div>

        <?php if ($active_tab === 'collected'): ?>
          <div class="col-md-2 col-6">
            <select name="result_filter" class="form-select">
              <option value="">All Results Status</option>
              <option value="pending" <?= $res_filter === 'pending' ? 'selected' : '' ?>>Results Pending</option>
              <option value="entered" <?= $res_filter === 'entered' ? 'selected' : '' ?>>Results Entered</option>
            </select>
          </div>
        <?php endif; ?>

        <div class="col-auto d-flex gap-2">
          <button type="submit" class="btn btn-primary btn-sm fw-bold px-3">
            <i class="bi bi-funnel me-1"></i> Filter
          </button>
          <a href="sample_collection.php?tab=<?= htmlspecialchars($active_tab) ?>" class="btn btn-outline-secondary btn-sm" title="Reset Filters">
            <i class="bi bi-arrow-counterclockwise"></i>
          </a>
        </div>
      </form>
    </div>

    <!-- Bulk Collection Bar (Shown when checkboxes checked) -->
    <?php if ($active_tab === 'pending'): ?>
      <form id="bulkForm" method="POST" action="sample_collection.php">
        <input type="hidden" name="action" value="collect_bulk">
        <div id="bulkActionBar" class="bulk-action-bar">
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-check-square-fill text-warning fs-5"></i>
            <span class="fw-bold"><span id="selectedCount">0</span> patient samples selected</span>
          </div>
          <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-success btn-sm fw-bold px-3 shadow-sm">
              <i class="bi bi-droplet-fill me-1"></i> Mark All Selected as Collected
            </button>
            <button type="button" class="btn btn-outline-light btn-sm" onclick="clearAllCheckboxes()">
              Cancel
            </button>
          </div>
        </div>
    <?php endif; ?>

    <!-- TAB 1: PENDING COLLECTION -->
    <?php if ($active_tab === 'pending'): ?>
      <div class="table-container">
        <table class="station-table">
          <thead>
            <tr>
              <th width="3%" class="text-center">
                <input type="checkbox" id="checkAll" onclick="toggleAllCheckboxes(this)">
              </th>
              <th width="10%">Bill / Token</th>
              <th width="22%">Patient Details</th>
              <th width="12%">Registration Date</th>
              <th width="35%">Ordered Tests & Vacutainer Guide</th>
              <th width="18%" class="text-end">Phlebotomy Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($pending_res && $pending_res->num_rows > 0): ?>
              <?php while ($row = $pending_res->fetch_assoc()): ?>
                <?php
                // Fetch tests for this bill
                $bill_id = (int)$row['bill_id'];
                $test_names = [];
                $t_query = $conn->query("
                    SELECT t.test_name FROM bill_tests bt 
                    JOIN lab_tests t ON bt.test_id = t.test_id 
                    WHERE bt.bill_id = $bill_id
                ");
                if ($t_query) {
                    while ($tr = $t_query->fetch_assoc()) $test_names[] = $tr['test_name'];
                }
                $p_query = $conn->query("
                    SELECT p.package_name FROM bill_packages bp 
                    JOIN test_packages p ON bp.package_id = p.package_id 
                    WHERE bp.bill_id = $bill_id
                ");
                if ($p_query) {
                    while ($pr = $p_query->fetch_assoc()) $test_names[] = $pr['package_name'];
                }
                $tests_str = implode(', ', $test_names);
                $tubes = getTubeRecommendations($tests_str);
                ?>
                <tr id="row-<?= $bill_id ?>">
                  <td class="td-checkbox">
                    <label class="d-flex align-items-center gap-2 cursor-pointer">
                      <input type="checkbox" name="selected_bills[]" value="<?= $bill_id ?>" class="sample-checkbox" onchange="updateSelectedCount()">
                      <span class="d-md-none fw-bold small text-secondary">Select for Bulk Collection</span>
                    </label>
                  </td>
                  <td data-label="Bill / Token">
                    <div class="text-end text-md-start">
                      <div class="fw-bold font-monospace text-primary fs-6">#<?= $bill_id ?></div>
                      <a href="print_bill.php?id=<?= $bill_id ?>" target="_blank" class="small text-muted text-decoration-none" title="View receipt">
                        <i class="bi bi-receipt me-1"></i>Receipt
                      </a>
                    </div>
                  </td>
                  <td data-label="Patient Details">
                    <div class="text-end text-md-start">
                      <div class="fw-bold text-dark"><?= htmlspecialchars($row['full_name']) ?></div>
                      <div class="small text-muted">
                        <span class="badge bg-light text-secondary border me-1">
                          <?= htmlspecialchars($row['gender'] ?: 'M') ?>, <?= htmlspecialchars($row['age'] ?: '-') ?> yrs
                        </span>
                        <i class="bi bi-telephone ms-1 me-1"></i><?= htmlspecialchars($row['phone'] ?: 'N/A') ?>
                      </div>
                      <?php if (!empty($row['dr_ref'])): ?>
                        <div class="small text-muted text-truncate" style="max-width: 180px;">
                          <i class="bi bi-person-heart me-1 text-primary"></i>Ref: <?= htmlspecialchars($row['dr_ref']) ?>
                        </div>
                      <?php endif; ?>
                    </div>
                  </td>
                  <td data-label="Order Date">
                    <div class="text-end text-md-start">
                      <div class="fw-semibold"><?= date('d-M-Y', strtotime($row['bill_date'])) ?></div>
                      <span class="badge bg-warning bg-opacity-10 text-warning-emphasis font-monospace" style="font-size:0.72rem;">
                        <i class="bi bi-hourglass-split me-1"></i>Awaiting Draw
                      </span>
                    </div>
                  </td>
                  <td data-label="Tests & Tubes">
                    <!-- Ordered Tests List -->
                    <div class="fw-semibold text-dark small mb-1">
                      <?= htmlspecialchars($tests_str ?: 'Pathology Investigation') ?>
                    </div>
                    <!-- Recommended Tube Badges -->
                    <div>
                      <?php foreach ($tubes as $tb): ?>
                        <span class="tube-tag" style="background: <?= $tb['color'] ?>15; color: <?= $tb['color'] ?>; border: 1px solid <?= $tb['color'] ?>40;">
                          <span class="tube-dot" style="background: <?= $tb['color'] ?>;"></span>
                          <?= htmlspecialchars($tb['tube']) ?> (<?= htmlspecialchars($tb['type']) ?>)
                        </span>
                      <?php endforeach; ?>
                    </div>
                  </td>
                  <td data-label="Action" class="text-end">
                    <div class="d-flex align-items-center justify-content-end gap-2">
                      <!-- 1-Click Fast Collect Button -->
                      <button type="button" class="btn-collect-fast" onclick="markSampleCollected(<?= $bill_id ?>)" title="Mark as Collected">
                        <i class="bi bi-droplet-fill"></i> Collect
                      </button>

                      <!-- Print Tube Label Sticker Button -->
                      <button type="button" class="btn btn-label-print" onclick="printTubeLabel(<?= $bill_id ?>)" title="Print Thermal Barcode Tube Sticker">
                        <i class="bi bi-upc"></i> Label
                      </button>
                    </div>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center py-5">
                  <i class="bi bi-check2-circle fa-3x text-success mb-2 d-block opacity-75"></i>
                  <h6 class="fw-bold text-secondary">All Samples Collected!</h6>
                  <p class="small text-muted mb-0">No pending phlebotomy sample collections waiting in queue.</p>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
      </form>

    <!-- TAB 2: COLLECTED SAMPLES -->
    <?php else: ?>
      <div class="table-container">
        <table class="station-table">
          <thead>
            <tr>
              <th width="10%">Bill / Barcode</th>
              <th width="22%">Patient Details</th>
              <th width="18%">Collected Date & By</th>
              <th width="28%">Ordered Tests</th>
              <th width="10%" class="text-center">Status</th>
              <th width="12%" class="text-end">Next Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($collected_res && $collected_res->num_rows > 0): ?>
              <?php while ($row = $collected_res->fetch_assoc()): ?>
                <?php
                $bill_id = (int)$row['bill_id'];
                $test_names = [];
                $t_query = $conn->query("SELECT t.test_name FROM bill_tests bt JOIN lab_tests t ON bt.test_id = t.test_id WHERE bt.bill_id = $bill_id");
                if ($t_query) {
                    while ($tr = $t_query->fetch_assoc()) $test_names[] = $tr['test_name'];
                }
                $p_query = $conn->query("SELECT p.package_name FROM bill_packages bp JOIN test_packages p ON bp.package_id = p.package_id WHERE bp.bill_id = $bill_id");
                if ($p_query) {
                    while ($pr = $p_query->fetch_assoc()) $test_names[] = $pr['package_name'];
                }
                $tests_str = implode(', ', $test_names);
                $has_results = ((int)$row['result_count']) > 0;
                ?>
                <tr>
                  <td data-label="Bill #">
                    <div class="text-end text-md-start">
                      <div class="fw-bold font-monospace text-primary fs-6">#<?= $bill_id ?></div>
                      <button type="button" class="btn btn-link p-0 text-decoration-none small text-muted" onclick="printTubeLabel(<?= $bill_id ?>)">
                        <i class="bi bi-upc-scan me-1"></i>Barcode
                      </button>
                    </div>
                  </td>
                  <td data-label="Patient">
                    <div class="text-end text-md-start">
                      <div class="fw-bold text-dark"><?= htmlspecialchars($row['full_name']) ?></div>
                      <div class="small text-muted">
                        <?= htmlspecialchars($row['gender'] ?: 'M') ?>, <?= htmlspecialchars($row['age'] ?: '-') ?> yrs &bull; <?= htmlspecialchars($row['phone'] ?: 'N/A') ?>
                      </div>
                    </div>
                  </td>
                  <td data-label="Collected Info">
                    <div class="text-end text-md-start">
                      <div class="fw-bold text-success font-monospace" style="font-size:0.85rem;">
                        <i class="bi bi-check-circle-fill me-1"></i><?= date('d-M-Y H:i', strtotime($row['sample_date'])) ?>
                      </div>
                      <div class="small text-muted">
                        By: <strong><?= htmlspecialchars($row['phlebotomist_name'] ?: ($row['phlebotomist_user'] ?: 'Technician')) ?></strong>
                      </div>
                    </div>
                  </td>
                  <td data-label="Tests">
                    <div class="text-end text-md-start small text-dark fw-semibold">
                      <?= htmlspecialchars($tests_str ?: 'Diagnostic Package') ?>
                    </div>
                  </td>
                  <td data-label="Status" class="text-center">
                    <?php if ($has_results): ?>
                      <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 fw-bold">
                        <i class="bi bi-check-all me-1"></i>Results In
                      </span>
                    <?php else: ?>
                      <span class="badge bg-warning bg-opacity-10 text-warning-emphasis border border-warning border-opacity-25 fw-bold">
                        <i class="bi bi-hourglass-split me-1"></i>Pending Results
                      </span>
                    <?php endif; ?>
                  </td>
                  <td data-label="Next Action" class="text-end">
                    <div class="d-flex align-items-center justify-content-end gap-1">
                      <?php if (!$has_results): ?>
                        <a href="result_entry.php?bill_id=<?= $bill_id ?>" class="btn btn-sm btn-primary fw-bold" title="Enter diagnostic test results">
                          <i class="bi bi-pencil-square me-1"></i> Results
                        </a>
                      <?php else: ?>
                        <a href="result_entry.php?bill_id=<?= $bill_id ?>" class="btn btn-sm btn-outline-primary fw-semibold" title="Edit test results">
                          <i class="bi bi-pencil"></i>
                        </a>
                        <a href="pdf_options.php?bill_id=<?= $bill_id ?>" class="btn btn-sm btn-outline-danger fw-semibold" title="Generate Report PDF">
                          <i class="bi bi-file-earmark-pdf"></i>
                        </a>
                      <?php endif; ?>

                      <!-- Revert button -->
                      <?php if (!$has_results || $current_role === 'admin'): ?>
                        <form method="POST" action="sample_collection.php" style="display:inline;" onsubmit="return confirm('Revert sample #<?= $bill_id ?> back to Pending?')">
                          <input type="hidden" name="action" value="revert_sample">
                          <input type="hidden" name="bill_id" value="<?= $bill_id ?>">
                          <button type="submit" class="btn btn-sm btn-outline-secondary" title="Revert to Pending">
                            <i class="bi bi-arrow-counterclockwise"></i>
                          </button>
                        </form>
                      <?php endif; ?>
                    </div>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center py-5">
                  <i class="bi bi-inbox fa-3x text-muted mb-2 d-block opacity-50"></i>
                  <h6 class="fw-bold text-secondary">No Collected Samples Found</h6>
                  <p class="small text-muted mb-0">No records matched your date or status filters.</p>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>

  </div>

</div>

<!-- Thermal Tube Label Print Modal -->
<div class="modal fade" id="tubeLabelModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
      <div class="modal-header py-2 px-3 bg-light border-bottom">
        <h6 class="modal-title fw-bold mb-0 text-dark"><i class="bi bi-upc me-1 text-primary"></i> Specimen Tube Sticker</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-2 text-center" style="background: #f1f5f9;">
        <iframe id="labelIframe" src="" style="width: 100%; height: 160px; border: none; border-radius: 6px; background: #ffffff;"></iframe>
      </div>
      <div class="modal-footer py-2 px-3 bg-light border-top justify-content-between">
        <button type="button" class="btn btn-secondary btn-sm fw-semibold" data-bs-dismiss="modal">Close</button>
        <div class="d-flex gap-1">
          <a id="labelOpenNewTab" href="#" target="_blank" class="btn btn-outline-secondary btn-sm" title="Open in New Window">
            <i class="bi bi-box-arrow-up-right"></i>
          </a>
          <button type="button" class="btn btn-primary btn-sm fw-bold px-3 shadow-sm" onclick="printStickerFromModal()">
            <i class="bi bi-printer-fill me-1"></i> Print Sticker
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// 1-Click Collect via AJAX without full page reloads
function markSampleCollected(billId) {
  const row = $('#row-' + billId);
  row.css('opacity', '0.5');

  $.ajax({
    url: 'sample_collection.php',
    method: 'POST',
    data: {
      action: 'collect_single',
      bill_id: billId,
      ajax: 1
    },
    dataType: 'json',
    success: function(res) {
      if (res.status === 'success') {
        row.fadeOut(300, function() {
          $(this).remove();
          // Update counters
          updateSelectedCount();
          let currentPending = parseInt($('.metric-val').first().text()) || 0;
          if (currentPending > 0) $('.metric-val').first().text(currentPending - 1);
        });
      } else {
        alert(res.message || 'Error collecting sample');
        row.css('opacity', '1');
      }
    },
    error: function() {
      // Fallback normal form submission
      let f = $('<form method="POST" action="sample_collection.php"><input type="hidden" name="action" value="collect_single"><input type="hidden" name="bill_id" value="' + billId + '"></form>');
      $('body').append(f);
      f.submit();
    }
  });
}

// Print Tube Label Sticker in Modal or Popup
function printTubeLabel(billId) {
  const url = 'sample_collection.php?action=print_label&bill_id=' + billId;
  $('#labelIframe').attr('src', url);
  $('#labelOpenNewTab').attr('href', url);
  const modalEl = document.getElementById('tubeLabelModal');
  const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
  modal.show();
}

function printStickerFromModal() {
  const iframe = document.getElementById('labelIframe');
  if (iframe && iframe.contentWindow) {
    iframe.contentWindow.focus();
    iframe.contentWindow.print();
  }
}

// Bulk Checkbox Handling
function toggleAllCheckboxes(source) {
  $('.sample-checkbox').prop('checked', source.checked);
  updateSelectedCount();
}

function updateSelectedCount() {
  const count = $('.sample-checkbox:checked').length;
  $('#selectedCount').text(count);
  if (count > 0) {
    $('#bulkActionBar').css('display', 'flex');
  } else {
    $('#bulkActionBar').hide();
    $('#checkAll').prop('checked', false);
  }
}

function clearAllCheckboxes() {
  $('.sample-checkbox').prop('checked', false);
  $('#checkAll').prop('checked', false);
  updateSelectedCount();
}
</script>

</body>
</html>
