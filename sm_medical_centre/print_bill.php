<?php
/**
 * Professional Diagnostic Cash Bill & Patient Receipt
 * - Dynamic Lab details from admin_settings with beautiful letterhead
 * - Compact A4 / Half-A4 single-page layout to prevent paper wastage
 * - Native WhatsApp Web (web.whatsapp.com) & Mobile integration (Zero API costs)
 * - Direct "Download Report" button link pointing to download_pdf.php?token={$token}
 * - Offline pure-PHP 2D Barcode generator for instant QR rendering
 */
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/report_helper.php';

// 1. Resolve Bill ID from id, bill_id, or token
$bill_id = 0;
if (isset($_GET['token']) && trim($_GET['token']) !== '') {
    $bill_id = decodeID(trim($_GET['token']));
} elseif (isset($_GET['id']) && (int)$_GET['id'] > 0) {
    $bill_id = (int)$_GET['id'];
} elseif (isset($_GET['bill_id']) && (int)$_GET['bill_id'] > 0) {
    $bill_id = (int)$_GET['bill_id'];
}

if ($bill_id <= 0) {
    die("Invalid Request: Valid Bill ID or token is required.");
}

// 2. Fetch Bill, Patient, and Staff Details
$stmt = $conn->prepare("
    SELECT b.*, p.full_name, p.gender, p.age, p.date_of_birth, p.phone, p.address, p.dr_ref,
           u.username as billed_by_user, u.full_name as billed_by_name
    FROM bills b 
    JOIN patients p ON b.patient_id = p.patient_id 
    LEFT JOIN users u ON b.created_by = u.user_id
    WHERE b.bill_id = ?
    LIMIT 1
");
$stmt->bind_param("i", $bill_id);
$stmt->execute();
$bill = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$bill) {
    die("Invoice record not found for Bill #{$bill_id}.");
}

// 3. Fetch Investigation Tests & Packages
$tests_stmt = $conn->prepare("
    SELECT t.test_name, t.price 
    FROM bill_tests bt 
    JOIN lab_tests t ON bt.test_id = t.test_id 
    WHERE bt.bill_id = ?
");
$tests_stmt->bind_param("i", $bill_id);
$tests_stmt->execute();
$tests = $tests_stmt->get_result();

$packages_stmt = $conn->prepare("
    SELECT p.package_name, p.package_price 
    FROM bill_packages bp 
    JOIN test_packages p ON bp.package_id = p.package_id 
    WHERE bp.bill_id = ?
");
$packages_stmt->bind_param("i", $bill_id);
$packages_stmt->execute();
$packages = $packages_stmt->get_result();

// 4. Dynamic Lab Branding & Information from admin_settings
$currentDir = basename(__DIR__);
$isDemo = ($currentDir === 'demo' || (isset($_GET['demo']) && $_GET['demo'] === '1'));

$lab_name     = $isDemo ? 'Amma Diagnostic Centre' : 'Diagnostic Centre ERP';
$lab_tagline  = 'Accurate | Caring | Instant';
$lab_address  = $isDemo ? 'Gorjee Street, ICHAPURAM-532312, Srikakulam Dist, (A.P)' : '';
$lab_phone    = $isDemo ? '+91 7702271571 / +91 9515680080' : '';
$lab_email    = $isDemo ? 'info@ammadiagnostics.com' : '';
$lab_reg      = $isDemo ? 'Regd. No. 258/2013' : '';

if ($conn && !$conn->connect_error) {
    if ($isDemo) {
        $sres = $conn->query("SELECT * FROM admin_settings WHERE lab_slug = 'demo' LIMIT 1");
        if ($sres && $srow = $sres->fetch_assoc()) {
            if (!empty($srow['company_address'])) $lab_address = trim($srow['company_address']);
            if (!empty($srow['phone']))           $lab_phone   = trim($srow['phone']);
            if (!empty($srow['email']))           $lab_email   = trim($srow['email']);
            if (!empty($srow['reg_no']))          $lab_reg     = trim($srow['reg_no']);
        }
        $lab_name = 'Amma Diagnostic Centre';
    } else {
        $labSlug = $conn->real_escape_string($currentDir);
        $sres = $conn->query("SELECT * FROM admin_settings WHERE lab_slug = '{$labSlug}' LIMIT 1");
        if ($sres && $srow = $sres->fetch_assoc()) {
            if (!empty($srow['company_name']))    $lab_name    = trim($srow['company_name']);
            if (!empty($srow['company_address'])) $lab_address = trim($srow['company_address']);
            if (!empty($srow['phone']))           $lab_phone   = trim($srow['phone']);
            if (!empty($srow['email']))           $lab_email   = trim($srow['email']);
            if (!empty($srow['reg_no']))          $lab_reg     = trim($srow['reg_no']);
        } else {
            $words = explode('_', str_replace('-', '_', $currentDir));
            $formatted = array_map(function($w) {
                return (strlen($w) <= 3) ? strtoupper($w) : ucfirst($w);
            }, $words);
            $lab_name = implode(' ', $formatted);
        }
    }
}

// Dynamic Logo search across standard lab folders
$logo_file = null;
foreach ([
    'qrtemp/logo.png', 'qrtemp/logo.jpg', 'qrtemp/logo.jpeg', 'qrtemp/logo.webp',
    'uploads/logo.png', 'uploads/logo.jpg', 'uploads/logo.jpeg',
    'logo.png', 'logo.jpg'
] as $lp) {
    if (file_exists(__DIR__ . '/' . $lp)) {
        $logo_file = $lp;
        break;
    }
}

// 5. Token & QR Code Generation (Using offline TCPDF barcode or fallback)
$token = encodeID($bill_id);
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'] ?? 'labs.vensaas.com';
$current_dir = rtrim(dirname($_SERVER['PHP_SELF'] ?? '/demo'), '/\\');
$qr_link = "{$protocol}{$host}{$current_dir}/download_pdf.php?token={$token}";

$qr_code_src = '';
if (file_exists(__DIR__ . '/TCPDF/tcpdf_barcodes_2d.php')) {
    try {
        require_once __DIR__ . '/TCPDF/tcpdf_barcodes_2d.php';
        $barcode = new TCPDF2DBarcode($qr_link, 'QRCODE,L');
        $png_data = $barcode->getBarcodePngData(3, 3);
        if ($png_data) {
            $qr_code_src = 'data:image/png;base64,' . base64_encode($png_data);
        }
    } catch (Exception $e) {
        // Fallback below
    }
}
if (empty($qr_code_src)) {
    $qr_code_src = "https://api.qrserver.com/v1/create-qr-code/?size=85x85&data=" . rawurlencode($qr_link);
}

// 6. WhatsApp Message Construction (for web.whatsapp.com and mobile)
$clean_phone = preg_replace('/[^0-9]/', '', $bill['phone'] ?? '');
if (strlen($clean_phone) === 10) {
    $clean_phone = '91' . $clean_phone; // Prepend 91 for standard Indian mobile numbers
}

$payment_status_upper = strtoupper($bill['payment_status'] ?? 'PAID');
$wa_message = "Hello *" . trim($bill['full_name']) . "*,

"
    . "Thank you for visiting *" . $lab_name . "*.
"
    . "Your diagnostic bill receipt has been generated successfully.

"
    . "🧾 *Bill No:* #" . $bill['bill_id'] . "
"
    . "📅 *Date:* " . date('d-M-Y', strtotime($bill['bill_date'])) . "
"
    . "💰 *Total Amount:* ₹" . number_format($bill['total_amount'], 2) . "
"
    . "✅ *Paid Amount:* ₹" . number_format($bill['paid_amount'], 2) . "
"
    . "⚠️ *Balance Due:* ₹" . number_format($bill['balance'], 2) . "
"
    . "📌 *Status:* " . $payment_status_upper . "

"
    . "📄 *Click Below to Track & Download Your Report PDF:*
"
    . $qr_link . "

"
    . "You can view your real-time processing status and download the verified report PDF directly from the link above once results are ready.

"
    . "Warm Regards,
*" . $lab_name . "*
📍 " . $lab_address . "
📞 " . $lab_phone;

// Age and staff label
$patient_age = !empty($bill['age']) ? $bill['age'] : 'N/A';
if ($patient_age === 'N/A' && !empty($bill['date_of_birth'])) {
    $diff = date_diff(date_create($bill['date_of_birth']), date_create());
    $patient_age = $diff->format("%y Y");
}
$gender_display = ucfirst($bill['gender'] ?? 'N/A');
$dr_ref_display = !empty($bill['dr_ref']) ? htmlspecialchars($bill['dr_ref']) : 'Self / Direct';
$billed_by = !empty($bill['billed_by_name']) ? $bill['billed_by_name'] : (!empty($bill['billed_by_user']) ? $bill['billed_by_user'] : 'Reception Staff');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bill #<?= $bill_id ?> - <?= htmlspecialchars($bill['full_name']) ?> | <?= htmlspecialchars($lab_name) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
  
  <style>
    :root {
      --brand-primary: #0284c7;
      --brand-dark: #0369a1;
      --brand-gradient: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
      --surface-border: #cbd5e1;
      --text-dark: #0f172a;
      --text-muted: #64748b;
    }

    body {
      background-color: #f8fafc;
      font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
      color: var(--text-dark);
      margin: 0;
      padding: 16px 10px;
    }

    /* Screen Action Bar */
    .action-toolbar {
      max-width: 800px;
      margin: 0 auto 14px auto;
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      gap: 10px;
    }

    /* Bill Container */
    .bill-box {
      max-width: 800px;
      margin: 0 auto;
      background: #ffffff;
      padding: 20px 24px;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);
      position: relative;
    }

    /* Dynamic Digital Letterhead */
    .digital-header {
      display: flex;
      align-items: center;
      gap: 14px;
      padding-bottom: 6px;
    }
    .logo-container {
      width: 58px;
      height: 58px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 10px;
      padding: 3px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
    }
    .lab-logo-img {
      max-height: 50px;
      max-width: 50px;
      object-fit: contain;
    }
    .lab-title {
      font-size: 1.35rem;
      font-weight: 800;
      color: var(--brand-primary);
      letter-spacing: 0.3px;
      margin: 0 0 2px 0;
      line-height: 1.2;
    }
    .lab-tagline {
      font-size: 0.68rem;
      font-weight: 700;
      color: #334155;
      letter-spacing: 1px;
      text-transform: uppercase;
      margin-bottom: 2px;
    }
    .lab-contacts {
      font-size: 0.73rem;
      color: var(--text-muted);
      line-height: 1.35;
    }

    /* Gradient Divider */
    .header-divider {
      height: 3px;
      background: linear-gradient(90deg, #0284c7 0%, #38bdf8 65%, #e2e8f0 100%);
      margin: 6px 0 10px 0;
      border-radius: 2px;
    }

    /* Spacer for Pre-Printed Stationery */
    .preprinted-spacer {
      display: none;
      height: 38.1mm; /* 1.5 inches */
    }

    /* Receipt Title Row */
    .receipt-title-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 8px;
    }
    .receipt-badge {
      font-size: 0.75rem;
      font-weight: 800;
      letter-spacing: 1.2px;
      background: #f0f9ff;
      color: var(--brand-primary);
      padding: 3px 12px;
      border-radius: 20px;
      border: 1px solid #bae6fd;
      text-transform: uppercase;
    }

    /* Patient Info Grid */
    .info-grid-box {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 6px 12px;
      margin-bottom: 10px;
      font-size: 0.78rem;
    }
    .info-grid-box td {
      padding: 2px 4px;
      vertical-align: top;
    }
    .info-lbl {
      color: #64748b;
      font-weight: 600;
      font-size: 0.74rem;
      white-space: nowrap;
    }
    .info-val {
      color: #0f172a;
      font-weight: 600;
    }

    /* Items Table */
    .items-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 8px;
      font-size: 0.8rem;
    }
    .items-table th {
      background-color: #f1f5f9;
      color: #334155;
      font-weight: 700;
      font-size: 0.74rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      padding: 4px 8px;
      border-top: 1px solid #cbd5e1;
      border-bottom: 1px solid #cbd5e1;
    }
    .items-table td {
      padding: 4px 8px;
      border-bottom: 1px solid #e2e8f0;
    }
    .items-table tfoot th, .items-table tfoot td {
      padding: 3px 8px;
      border-bottom: none;
    }

    /* Bottom Summary & QR Layout */
    .bill-footer-section {
      border-top: 1.5px solid #cbd5e1;
      padding-top: 8px;
      margin-top: 4px;
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 14px;
    }
    .qr-block {
      display: flex;
      align-items: center;
      gap: 10px;
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 6px 10px;
      max-width: 340px;
    }
    .qr-img {
      width: 68px;
      height: 68px;
      border-radius: 4px;
      background: white;
      padding: 2px;
      border: 1px solid #cbd5e1;
    }
    .qr-text-heading {
      font-size: 0.72rem;
      font-weight: 700;
      color: var(--text-dark);
      margin-bottom: 1px;
      line-height: 1.2;
    }
    .qr-text-sub {
      font-size: 0.65rem;
      color: var(--text-muted);
      line-height: 1.2;
      margin-bottom: 3px;
    }

    .signatory-box {
      text-align: right;
      min-width: 170px;
    }
    .signatory-line {
      font-size: 0.8rem;
      color: #94a3b8;
      margin-bottom: 3px;
    }
    .signatory-title {
      font-size: 0.74rem;
      font-weight: 700;
      color: #334155;
    }
    .signatory-sub {
      font-size: 0.68rem;
      color: #64748b;
    }

    /* Terms note */
    .terms-note {
      font-size: 0.64rem;
      color: #94a3b8;
      margin-top: 6px;
      padding-top: 4px;
      border-top: 1px dashed #e2e8f0;
      display: flex;
      justify-content: space-between;
    }

    /* WhatsApp Button styling */
    .btn-whatsapp {
      background-color: #25D366 !important;
      border-color: #25D366 !important;
      color: #ffffff !important;
      font-weight: 700;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }
    .btn-whatsapp:hover {
      background-color: #1ebc59 !important;
      border-color: #1ebc59 !important;
      color: #ffffff !important;
    }

    /* Print Optimization: Ultra Compact Single-Page Fitting */
    @media print {
      @page {
        size: A4 portrait;
        margin: 8mm 10mm 6mm 10mm;
      }
      body {
        background: #ffffff !important;
        color: #000000 !important;
        padding: 0 !important;
        margin: 0 !important;
        font-size: 9pt !important;
      }
      .no-print {
        display: none !important;
      }
      .bill-box {
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
        box-shadow: none !important;
      }
      body.pre-printed-mode .digital-header,
      body.pre-printed-mode .header-divider {
        display: none !important;
      }
      body.pre-printed-mode .preprinted-spacer {
        display: block !important;
        height: 38.1mm !important; /* exactly 1.5 inches */
      }
      table, tr, td, th {
        page-break-inside: avoid !important;
      }
      .qr-block {
        background: transparent !important;
        border: 1px solid #000 !important;
      }
      .info-grid-box {
        background: transparent !important;
        border: 1px solid #000 !important;
      }
      .items-table th {
        background-color: #f1f5f9 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
      }
    }
  </style>
</head>
<body id="billBody">

  <!-- Action Toolbar (Screen Only) -->
  <div class="action-toolbar no-print">
    <div class="d-flex align-items-center gap-2">
      <a href="bill_list.php" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Bills
      </a>
      <span class="fw-bold text-dark font-monospace">Bill #<?= $bill_id ?></span>
      <span class="badge <?= $bill['payment_status'] === 'paid' ? 'bg-success' : ($bill['payment_status'] === 'partial' ? 'bg-warning text-dark' : 'bg-danger') ?>">
        <?= strtoupper($bill['payment_status'] ?? 'PAID') ?>
      </span>
    </div>

    <div class="d-flex align-items-center flex-wrap gap-2">
      <!-- 1. Send via WhatsApp Web / WhatsApp Desktop / Mobile (Zero API) -->
      <button onclick="sendViaWhatsApp()" class="btn btn-sm btn-whatsapp text-white shadow-sm" title="Open WhatsApp Web or Mobile directly with bill details and report download link">
        <i class="bi bi-whatsapp fs-6"></i> WhatsApp Bill
      </button>

      <!-- 2. Download Report Button Link -->
      <a href="<?= $qr_link ?>" target="_blank" class="btn btn-sm btn-primary fw-bold shadow-sm" title="Track results and download official diagnostic report PDF">
        <i class="bi bi-file-earmark-pdf-fill me-1"></i> Download Report
      </a>

      <!-- 3. Print Bill -->
      <button onclick="window.print()" class="btn btn-sm btn-secondary fw-bold shadow-sm">
        <i class="bi bi-printer-fill me-1"></i> Print Bill
      </button>

      <!-- 4. Toggle Pre-Printed Stationery (1.5" blank top) -->
      <button type="button" id="btnHdrToggle" class="btn btn-sm btn-outline-dark" onclick="toggleLetterheadMode()">
        <i class="bi bi-file-earmark-ruled me-1"></i> Pre-Printed (1.5" Blank)
      </button>

      <!-- 5. Enter Results -->
      <a href="result_entry.php?bill_id=<?= $bill_id ?>" class="btn btn-sm btn-outline-primary fw-semibold">
        <i class="bi bi-pencil-square me-1"></i> Results
      </a>
    </div>
  </div>

  <!-- Printable Invoice Box -->
  <div class="bill-box">

    <!-- Pre-printed Stationery Spacer (Active when 1.5" blank mode toggled) -->
    <div class="preprinted-spacer"></div>

    <!-- Dynamic Digital Lab Letterhead (Default) -->
    <div class="digital-header">
      <div class="logo-container">
        <?php if ($logo_file): ?>
          <img src="<?= htmlspecialchars($logo_file) ?>" alt="Logo" class="lab-logo-img">
        <?php else: ?>
          <i class="bi bi-hospital fs-2 text-primary"></i>
        <?php endif; ?>
      </div>

      <div class="flex-grow-1">
        <h1 class="lab-title"><?= htmlspecialchars($lab_name) ?></h1>
        <div class="lab-tagline"><?= htmlspecialchars($lab_tagline) ?></div>
        <div class="lab-contacts">
          <span><i class="bi bi-geo-alt-fill text-danger me-1"></i><?= htmlspecialchars($lab_address) ?></span><br>
          <span><strong>Ph:</strong> <?= htmlspecialchars($lab_phone) ?> &bull; <strong>Email:</strong> <?= htmlspecialchars($lab_email) ?></span>
        </div>
      </div>

      <div class="text-end d-none d-sm-block">
        <span class="badge bg-light text-secondary border font-monospace" style="font-size:0.65rem;">
          <?= htmlspecialchars($lab_reg) ?>
        </span>
        <div class="small text-muted mt-1" style="font-size: 0.65rem;">
          <i class="bi bi-check-circle-fill text-success me-1"></i>NABL / Clinical Standards
        </div>
      </div>
    </div>

    <!-- Brand Divider -->
    <div class="header-divider"></div>

    <!-- Title Row -->
    <div class="receipt-title-row">
      <div class="receipt-badge">
        CASH BILL / INVOICE RECEIPT
      </div>
      <div class="small text-muted font-monospace">
        <strong>GST / Reg:</strong> <?= htmlspecialchars($lab_reg) ?>
      </div>
    </div>

    <!-- Patient & Invoice Details Grid -->
    <div class="info-grid-box">
      <table width="100%">
        <tr>
          <td width="15%" class="info-lbl">Patient Name</td>
          <td width="2%">:</td>
          <td width="38%" class="info-val text-primary" style="font-size:0.85rem;"><?= htmlspecialchars($bill['full_name']) ?></td>
          
          <td width="15%" class="info-lbl">Bill No / ID</td>
          <td width="2%">:</td>
          <td width="28%" class="info-val font-monospace" style="font-size:0.85rem;">#<?= $bill['bill_id'] ?></td>
        </tr>
        <tr>
          <td class="info-lbl">Age / Gender</td>
          <td>:</td>
          <td class="info-val"><?= htmlspecialchars($patient_age) ?> / <?= htmlspecialchars($gender_display) ?></td>
          
          <td class="info-lbl">Bill Date</td>
          <td>:</td>
          <td class="info-val"><?= date('d-M-Y h:i A', strtotime($bill['created_at'] ?: $bill['bill_date'])) ?></td>
        </tr>
        <tr>
          <td class="info-lbl">Contact Phone</td>
          <td>:</td>
          <td class="info-val">
            <?= htmlspecialchars($bill['phone'] ?: 'N/A') ?>
            <?php if (!empty($clean_phone)): ?>
              <a href="javascript:void(0)" onclick="sendViaWhatsApp()" class="no-print text-success ms-1 text-decoration-none" title="Send via WhatsApp Web">
                <i class="bi bi-whatsapp"></i>
              </a>
            <?php endif; ?>
          </td>
          
          <td class="info-lbl">Ref Doctor</td>
          <td>:</td>
          <td class="info-val">Dr. <?= $dr_ref_display ?></td>
        </tr>
        <?php if (!empty($bill['address']) && trim($bill['address']) !== ''): ?>
        <tr>
          <td class="info-lbl">Address</td>
          <td>:</td>
          <td colspan="4" class="info-val text-muted" style="font-weight:normal;"><?= htmlspecialchars($bill['address']) ?></td>
        </tr>
        <?php endif; ?>
      </table>
    </div>

    <!-- Tests & Packages Table -->
    <table class="items-table">
      <thead>
        <tr>
          <th width="8%" class="text-center">#</th>
          <th width="58%">Investigation / Profile Description</th>
          <th width="14%">Type</th>
          <th width="20%" class="text-end">Amount (₹)</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $item_idx = 1;
        $total_items = 0;

        while ($t = $tests->fetch_assoc()):
            $total_items++;
        ?>
          <tr>
            <td class="text-center text-muted"><?= $item_idx++ ?></td>
            <td class="fw-semibold text-dark"><?= htmlspecialchars($t['test_name']) ?></td>
            <td><span class="badge bg-light text-secondary border" style="font-size:0.65rem;">Single Test</span></td>
            <td class="text-end font-monospace"><?= number_format($t['price'], 2) ?></td>
          </tr>
        <?php endwhile; ?>

        <?php
        while ($p = $packages->fetch_assoc()):
            $total_items++;
        ?>
          <tr>
            <td class="text-center text-muted"><?= $item_idx++ ?></td>
            <td class="fw-bold text-primary"><?= htmlspecialchars($p['package_name']) ?></td>
            <td><span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25" style="font-size:0.65rem;">Package</span></td>
            <td class="text-end font-monospace fw-bold"><?= number_format($p['package_price'], 2) ?></td>
          </tr>
        <?php endwhile; ?>

        <?php if ($total_items === 0): ?>
          <tr>
            <td colspan="4" class="text-center text-muted py-2">No investigation items attached to this invoice.</td>
          </tr>
        <?php endif; ?>
      </tbody>

      <!-- Summary Totals -->
      <tfoot>
        <tr>
          <th colspan="3" class="text-end text-muted font-monospace">Total Amount:</th>
          <td class="text-end font-monospace fw-bold fs-6">₹<?= number_format($bill['total_amount'], 2) ?></td>
        </tr>
        <tr>
          <th colspan="3" class="text-end text-muted font-monospace">Paid Amount:</th>
          <td class="text-end font-monospace text-success fw-bold">₹<?= number_format($bill['paid_amount'], 2) ?></td>
        </tr>
        <tr>
          <th colspan="3" class="text-end text-muted font-monospace">Balance Due:</th>
          <td class="text-end font-monospace fw-bold <?= ($bill['balance'] > 0) ? 'text-danger' : 'text-secondary' ?>">
            ₹<?= number_format($bill['balance'], 2) ?>
          </td>
        </tr>
      </tfoot>
    </table>

    <!-- Footer: QR Code & Signatory -->
    <div class="bill-footer-section">
      
      <!-- QR Verification & Download Block -->
      <div class="qr-block">
        <img src="<?= $qr_code_src ?>" alt="Scan to Download Report" class="qr-img">
        <div>
          <div class="qr-text-heading">
            <i class="bi bi-qr-code-scan text-primary me-1"></i> Scan with Phone Camera
          </div>
          <div class="qr-text-sub">
            Track real-time testing status and download your verified Diagnostic Report PDF.
          </div>
          <a href="<?= $qr_link ?>" target="_blank" class="no-print badge bg-primary text-white text-decoration-none py-1 px-2" style="font-size:0.68rem;">
            <i class="bi bi-download me-1"></i> Download Report Online
          </a>
        </div>
      </div>

      <!-- Payment Badge & Signatory -->
      <div class="signatory-box">
        <div class="mb-2">
          <span class="badge <?= $bill['payment_status'] === 'paid' ? 'bg-success' : ($bill['payment_status'] === 'partial' ? 'bg-warning text-dark' : 'bg-danger') ?> px-3 py-1 font-monospace" style="font-size:0.75rem;">
            PAYMENT <?= strtoupper($bill['payment_status'] ?? 'PAID') ?>
          </span>
        </div>
        <div class="signatory-line">___________________________</div>
        <div class="signatory-title">Authorized Signatory</div>
        <div class="signatory-sub">For <?= htmlspecialchars($lab_name) ?></div>
        <div class="signatory-sub text-muted" style="font-size:0.62rem;">Billed By: <?= htmlspecialchars($billed_by) ?></div>
      </div>

    </div>

    <!-- Compact Notice Disclaimers -->
    <div class="terms-note">
      <span>&bull; Computer-generated diagnostic invoice receipt.</span>
      <span>&bull; Real-time reports accessible online 24/7 via QR scan.</span>
      <span>&bull; Thank you for choosing <?= htmlspecialchars($lab_name) ?></span>
    </div>

  </div>

  <!-- WhatsApp Web & Mobile Deep-Link Script (No API Needed) -->
  <script>
  function sendViaWhatsApp() {
    const phone = '<?= $clean_phone ?>';
    const msg = <?= json_encode($wa_message) ?>;

    if (!phone || phone.length < 10) {
      alert('Patient contact phone number is missing or invalid for WhatsApp.');
      return false;
    }

    // Check if user is on mobile browser vs desktop browser
    const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

    let targetUrl = '';
    if (isMobile) {
      // On mobile devices, open WhatsApp app directly
      targetUrl = 'https://api.whatsapp.com/send?phone=' + encodeURIComponent(phone) + '&text=' + encodeURIComponent(msg);
    } else {
      // On desktop, open web.whatsapp.com directly so if logged in, it opens the chat and populates the message instantly!
      targetUrl = 'https://web.whatsapp.com/send?phone=' + encodeURIComponent(phone) + '&text=' + encodeURIComponent(msg);
    }

    window.open(targetUrl, '_blank');
    return false;
  }

  // Quick toggle between Digital Header and Pre-Printed Stationery (1.5" blank top)
  function toggleLetterheadMode() {
    const body = document.getElementById('billBody');
    const btn = document.getElementById('btnHdrToggle');
    const isPreprinted = body.classList.toggle('pre-printed-mode');

    if (isPreprinted) {
      btn.innerHTML = '<i class="bi bi-hospital me-1"></i> Switch to Digital Header';
      btn.classList.replace('btn-outline-dark', 'btn-warning');
    } else {
      btn.innerHTML = '<i class="bi bi-file-earmark-ruled me-1"></i> Pre-Printed (1.5" Blank)';
      btn.classList.replace('btn-warning', 'btn-outline-dark');
    }
  }
  </script>

</body>
</html>
