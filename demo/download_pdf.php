<?php
/**
 * Public Diagnostic Report Gateway & Download Handler
 * Scanned via QR code from printed bill or report.
 * Verifies sample collection and result completion before generating/downloading report.
 * Applies saved lab report preferences (or fallback to letterhead image / standard format) via token system.
 */
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once __DIR__ . '/db.php';

if (!function_exists('decodeID')) {
    function decodeID($token, $key = 987654321) {
        return hexdec(strtolower($token)) ^ $key;
    }
}
if (!function_exists('encodeID')) {
    function encodeID($id, $key = 987654321) {
        return strtoupper(dechex($id ^ $key));
    }
}

// 1. Resolve Bill ID from token, bill_id, or id parameter
$bill_id = 0;
if (isset($_GET['token']) && trim($_GET['token']) !== '') {
    $bill_id = decodeID(trim($_GET['token']));
} elseif (isset($_GET['bill_id']) && (int)$_GET['bill_id'] > 0) {
    $bill_id = (int)$_GET['bill_id'];
} elseif (isset($_GET['id']) && (int)$_GET['id'] > 0) {
    $bill_id = (int)$_GET['id'];
}

if ($bill_id <= 0) {
    displayStatusPage([
        'title'   => 'Invalid Report Link',
        'type'    => 'error',
        'badge'   => 'Invalid Request',
        'message' => 'The report verification token or bill number is invalid or has expired. Please check your printed bill or contact the laboratory reception.'
    ]);
    exit;
}

// 2. Query Bill and Patient Information
$stmt = $conn->prepare("
    SELECT b.bill_id, b.bill_date, b.sample_collected, b.result_entered, b.created_at,
           p.full_name, p.gender, p.date_of_birth, p.age, p.phone, p.dr_ref
    FROM bills b
    JOIN patients p ON b.patient_id = p.patient_id
    WHERE b.bill_id = ?
    LIMIT 1
");
$stmt->bind_param("i", $bill_id);
$stmt->execute();
$bill = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$bill) {
    displayStatusPage([
        'title'   => 'Patient Record Not Found',
        'type'    => 'error',
        'badge'   => 'Not Found',
        'message' => "We could not find any active invoice or patient record matching Bill #{$bill_id}."
    ]);
    exit;
}

// 3. Query Test Sample Status
$sample_status = null;
$sample_date = null;
$stmt = $conn->prepare("
    SELECT status, sample_date
    FROM test_samples
    WHERE bill_id = ?
    ORDER BY sample_id DESC
    LIMIT 1
");
if ($stmt) {
    $stmt->bind_param("i", $bill_id);
    $stmt->execute();
    $sres = $stmt->get_result();
    if ($srow = $sres->fetch_assoc()) {
        $sample_status = strtolower(trim($srow['status'] ?? ''));
        $sample_date = $srow['sample_date'];
    }
    $stmt->close();
}

// 4. Query Test Results to verify completion
$has_results = false;
$stmt = $conn->prepare("
    SELECT COUNT(*) as cnt
    FROM test_results
    WHERE bill_id = ? AND result_value IS NOT NULL AND TRIM(result_value) != ''
");
if ($stmt) {
    $stmt->bind_param("i", $bill_id);
    $stmt->execute();
    $rres = $stmt->get_result()->fetch_assoc();
    if ($rres && $rres['cnt'] > 0) {
        $has_results = true;
    }
    $stmt->close();
}

// Completed check: if bills.result_entered == 1, or sample is 'completed', or test_results has rows
$is_completed = ($bill['result_entered'] == 1) || ($sample_status === 'completed') || $has_results;

if ($is_completed) {
    // Forward directly to report_generate_pdf.php
    // report_generate_pdf.php will automatically load saved preferences (or letterhead image fallback)
    $_GET['bill_id'] = $bill_id;
    require __DIR__ . '/report_generate_pdf.php';
    exit;
}

// 5. If not completed yet, show patient-friendly live status tracking page
$sample_collected = ($bill['sample_collected'] == 1) || ($sample_status !== null && $sample_status !== 'pending');
$sample_date_display = $sample_date ? date('d-M-Y h:i A', strtotime($sample_date)) : date('d-M-Y', strtotime($bill['bill_date']));

if (!$sample_collected) {
    displayStatusPage([
        'title'   => 'Sample Collection Pending',
        'type'    => 'pending',
        'badge'   => 'Pending Collection',
        'bill'    => $bill,
        'message' => "Your test sample has not yet been collected or received at the laboratory. Please visit the sample collection room or contact reception."
    ]);
} else {
    displayStatusPage([
        'title'   => 'Analysis Under Process',
        'type'    => 'processing',
        'badge'   => 'In Progress',
        'bill'    => $bill,
        'sample_date' => $sample_date_display,
        'message' => "Your sample was received and is currently undergoing clinical diagnostic analysis. Pathologist verification is in progress. Please check back shortly or refresh this page."
    ]);
}
exit;

// Helper to render responsive, professional status tracker
function displayStatusPage($info) {
    $title   = htmlspecialchars($info['title'] ?? 'Report Status');
    $badge   = htmlspecialchars($info['badge'] ?? 'Status');
    $type    = $info['type'] ?? 'info';
    $message = htmlspecialchars($info['message'] ?? '');
    $bill    = $info['bill'] ?? null;
    $patient_name = $bill ? htmlspecialchars($bill['full_name']) : '';
    $bill_id = $bill ? (int)$bill['bill_id'] : 0;
    $bill_date = $bill ? date('d-M-Y', strtotime($bill['bill_date'])) : '';
    $sample_date = !empty($info['sample_date']) ? htmlspecialchars($info['sample_date']) : '';

    $badge_class = 'bg-secondary';
    $icon = 'bi-hourglass-split';
    $border_color = '#0284c7';

    if ($type === 'processing') {
        $badge_class = 'bg-primary text-white';
        $icon = 'bi-arrow-repeat spin-icon';
        $border_color = '#0284c7';
    } elseif ($type === 'pending') {
        $badge_class = 'bg-warning text-dark';
        $icon = 'bi-clock-history';
        $border_color = '#f59e0b';
    } elseif ($type === 'error') {
        $badge_class = 'bg-danger text-white';
        $icon = 'bi-exclamation-triangle';
        $border_color = '#ef4444';
    }

    global $conn;
    $lab_brand_name = 'Diagnostic Centre';
    $lab_phone_contact = '';
    if (!empty($conn) && !$conn->connect_error) {
        $res = $conn->query("SELECT company_name, phone FROM admin_settings WHERE id = 1 LIMIT 1");
        if ($res && $r = $res->fetch_assoc()) {
            if (!empty($r['company_name']) && $r['company_name'] !== 'Amma Diagnostic Centre') {
                $lab_brand_name = $r['company_name'];
            }
            if (!empty($r['phone'])) {
                $lab_phone_contact = $r['phone'];
            }
        }
    }
    if ($lab_brand_name === 'Diagnostic Centre') {
        $currentDir = basename(__DIR__);
        if ($currentDir !== 'base' && $currentDir !== 'demo') {
            $words = explode('_', str_replace('-', '_', $currentDir));
            $formatted = array_map(function($w) {
                return (strlen($w) <= 3) ? strtoupper($w) : ucfirst($w);
            }, $words);
            $lab_brand_name = implode(' ', $formatted);
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title><?= $title ?> | Diagnostic Portal</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
      <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
      <style>
        body {
          background-color: #f8fafc;
          font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
          min-height: 100vh;
          display: flex;
          align-items: center;
          justify-content: center;
          padding: 20px;
        }
        .portal-card {
          max-width: 540px;
          width: 100%;
          background: #ffffff;
          border-radius: 16px;
          border: 1px solid #e2e8f0;
          box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
          overflow: hidden;
        }
        .portal-header {
          background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
          color: white;
          padding: 24px;
          text-align: center;
        }
        .spin-icon {
          animation: spin 3s linear infinite;
          display: inline-block;
        }
        @keyframes spin {
          0% { transform: rotate(0deg); }
          100% { transform: rotate(360deg); }
        }
        .pulse-badge {
          animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse {
          0%, 100% { opacity: 1; }
          50% { opacity: 0.65; }
        }
      </style>
    </head>
    <body>
      <div class="portal-card">
        <div class="portal-header">
          <i class="bi bi-hospital fs-1 mb-2 d-block"></i>
          <h4 class="fw-bold mb-1"><?= htmlspecialchars($lab_brand_name) ?></h4>
          <p class="small mb-0 opacity-75">Digital Patient Report Verification Portal</p>
        </div>
        
        <div class="p-4">
          <div class="text-center mb-4">
            <div class="d-inline-flex align-items-center justify-content-center p-3 rounded-circle bg-light mb-3" style="width: 70px; height: 70px;">
              <i class="bi <?= $icon ?> fs-2 text-primary"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1"><?= $title ?></h5>
            <span class="badge <?= $badge_class ?> px-3 py-2 rounded-pill font-monospace small pulse-badge">
              <?= $badge ?>
            </span>
          </div>

          <?php if ($bill): ?>
          <div class="bg-light rounded-3 p-3 mb-3 border">
            <div class="row g-2 small">
              <div class="col-6">
                <span class="text-muted d-block">Patient Name</span>
                <strong class="text-dark"><?= $patient_name ?></strong>
              </div>
              <div class="col-6">
                <span class="text-muted d-block">Bill Number</span>
                <strong class="text-primary font-monospace">#<?= $bill_id ?></strong>
              </div>
              <div class="col-6">
                <span class="text-muted d-block">Registration Date</span>
                <span><?= $bill_date ?></span>
              </div>
              <?php if ($sample_date): ?>
              <div class="col-6">
                <span class="text-muted d-block">Sample Collected On</span>
                <span><?= $sample_date ?></span>
              </div>
              <?php endif; ?>
            </div>
          </div>
          <?php endif; ?>

          <div class="alert alert-info border-0 bg-info bg-opacity-10 text-dark small mb-4">
            <i class="bi bi-info-circle me-1 text-info"></i>
            <?= $message ?>
          </div>

          <div class="d-grid gap-2">
            <button onclick="window.location.reload();" class="btn btn-primary py-2 fw-semibold">
              <i class="bi bi-arrow-clockwise me-1"></i> Refresh Status
            </button>
            <?php if (!empty($lab_phone_contact)): ?>
            <a href="tel:<?= htmlspecialchars($lab_phone_contact) ?>" class="btn btn-outline-secondary py-2 small">
              <i class="bi bi-telephone me-1"></i> Contact Laboratory Desk
            </a>
            <?php endif; ?>
          </div>
        </div>

        <div class="card-footer bg-light text-center py-2 text-muted small border-top">
          &copy; <?= date('Y') ?> <?= htmlspecialchars($lab_brand_name) ?> &bull; All Rights Reserved
        </div>
      </div>
    </body>
    </html>
    <?php
}
