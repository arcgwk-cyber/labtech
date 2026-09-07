<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/TCPDF/tcpdf.php');
require_once(__DIR__ . '/db.php');

require_once(__DIR__ . '/report_helper.php');

// 1. Resolve Bill ID from token, bill_id, or id
$bill_id = 0;
if (isset($_GET['token']) && trim($_GET['token']) !== '') {
    $bill_id = decodeID(trim($_GET['token']));
} elseif (isset($_GET['bill_id']) && (int)$_GET['bill_id'] > 0) {
    $bill_id = (int)$_GET['bill_id'];
} elseif (isset($_GET['id']) && (int)$_GET['id'] > 0) {
    $bill_id = (int)$_GET['id'];
}
if (!$bill_id) die('Bill ID or valid token is required.');

// 2. Load effective options with 4-tier hierarchy:
// Tier 1: Explicit URL query parameters (if &applied=1 passed from live studio/preview)
// Tier 2: Custom options saved specifically for THIS bill ($bill_id)
// Tier 3: Lab global default preferences (report_preferences.json)
// Tier 4: Base fallback (letterhead background image if present on disk, standard clinical style)
$opts = getEffectiveReportOptions($bill_id, $conn, $_GET);

$report_style           = $opts['style'];
$header_mode            = $opts['header_mode'];
$include_method         = (bool)$opts['include_method'];
$include_notes          = (bool)$opts['include_notes'];
$include_interpretation = (bool)$opts['include_interpretation'];
$pagebreak_per_test     = (bool)$opts['pagebreak_per_test'];
$include_signature      = (bool)$opts['include_signature'];

$letterhead_image_file  = getLetterheadImageFile();

// If explicit options were passed from pdf_options.php studio when printing/downloading/customizing,
// automatically persist them specifically for this bill so that scanning the QR code from the bill later will use these exact options!
if (!empty($_GET['applied'])) {
    saveBillReportOptions($bill_id, [
        'style'                  => $report_style,
        'header_mode'            => $header_mode,
        'include_method'         => $include_method,
        'include_notes'          => $include_notes,
        'include_interpretation' => $include_interpretation,
        'pagebreak_per_test'     => $pagebreak_per_test,
        'include_signature'      => $include_signature
    ], $conn);
}

$preview_mode  = isset($_GET['preview']);
$download_mode = isset($_GET['download']);
$print_mode    = isset($_GET['print']);

// --- Get Bill & Patient Data ---
$stmt = $conn->prepare("
    SELECT b.*, p.full_name, p.gender, p.date_of_birth, p.age, p.address, p.dr_ref, p.phone
    FROM bills b
    JOIN patients p ON b.patient_id = p.patient_id
    WHERE b.bill_id = ?");
$stmt->bind_param("i", $bill_id);
$stmt->execute();
$bill = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$bill) die("Invalid Bill ID.");

function calculateAge($dob) {
    if (empty($dob)) return "N/A";
    $diff = date_diff(date_create($dob), date_create());
    return $diff->format("%y Y");
}

function getLabHeaderHTML($conn) {
    $currentDir = basename(__DIR__);
    $isDemo = ($currentDir === 'demo' || (isset($_GET['demo']) && $_GET['demo'] === '1'));

    $lab_name = $isDemo ? "Amma Diagnostic Centre" : "Diagnostic Centre ERP";
    $lab_addr = $isDemo ? "Gorjee Street, ICHAPURAM-532312, Srikakulam Dist, (A.P)" : "Diagnostic Laboratory";

    if ($conn && !$conn->connect_error) {
        if ($isDemo) {
            $res = $conn->query("SELECT company_name, company_address FROM admin_settings WHERE lab_slug = 'demo' LIMIT 1");
            if ($res && $row = $res->fetch_assoc()) {
                if (!empty($row['company_address'])) $lab_addr = $row['company_address'];
            }
            $lab_name = "Amma Diagnostic Centre";
        } else {
            $labSlug = $conn->real_escape_string($currentDir);
            $res = $conn->query("SELECT company_name, company_address FROM admin_settings WHERE lab_slug = '{$labSlug}' LIMIT 1");
            if ($res && $row = $res->fetch_assoc()) {
                $lab_name = !empty($row['company_name']) ? $row['company_name'] : $lab_name;
                $lab_addr = !empty($row['company_address']) ? $row['company_address'] : $lab_addr;
            } else {
                $words = explode('_', str_replace('-', '_', $currentDir));
                $formatted = array_map(function($w) {
                    return (strlen($w) <= 3) ? strtoupper($w) : ucfirst($w);
                }, $words);
                $lab_name = implode(' ', $formatted);
            }
        }
    }

    $logo_file = null;
    foreach ([
        'qrtemp/logo.png', 'qrtemp/logo.jpg', 'qrtemp/logo.jpeg', 'qrtemp/logo.webp',
        'uploads/logo.png', 'uploads/logo.jpg', 'uploads/logo.jpeg',
        'logo.png', 'logo.jpg', 'assets/amma_logo.png'
    ] as $p) {
        if (file_exists(__DIR__ . '/' . $p)) {
            $logo_file = __DIR__ . '/' . $p;
            break;
        }
    }

    $logo_td = '';
    $text_w = '100%';
    if ($logo_file) {
        $logo_td = '<td width="15%" valign="middle"><img src="' . $logo_file . '" height="38"></td>';
        $text_w = '85%';
    }

    return <<<EOD
<table width="100%" cellpadding="1" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; border-bottom: 2px solid #0284c7; padding-bottom: 4px; margin-bottom: 6px;">
    <tr>
        {$logo_td}
        <td width="{$text_w}" align="left" valign="middle">
            <span style="font-size: 15px; font-weight: bold; color: #0284c7;">{$lab_name}</span><br>
            <span style="font-size: 8px; font-weight: bold; color: #334155;">COMPUTERIZED CLINICAL & DIAGNOSTIC LABORATORY</span><br>
            <span style="font-size: 7.5px; color: #64748b;">{$lab_addr}</span>
        </td>
    </tr>
</table>
<div style="margin-bottom: 3px;"></div>
EOD;
}

function generatePatientHTML($bill, $age, $gender, $dr_ref, $report_date, $style) {
    $formatted_bill_date = date('d-M-Y', strtotime($bill['bill_date']));
    $dr_label = !empty($dr_ref) ? htmlspecialchars($dr_ref) : 'Self / Direct';

    if ($style === 'modern') {
        return <<<EOD
<table width="100%" cellpadding="3" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; font-size: 9.5px; border-bottom: 2px solid #0f172a; padding-bottom: 6px;">
    <tr>
        <td width="18%"><strong>Patient Name</strong></td>
        <td width="2%">:</td>
        <td width="38%" style="font-size: 11px; font-weight: bold; color: #0f172a;">{$bill['full_name']}</td>
        <td width="14%"><strong>Bill No / PID</strong></td>
        <td width="2%">:</td>
        <td width="26%" style="font-weight: bold; color: #0284c7;">#{$bill['bill_id']}</td>
    </tr>
    <tr>
        <td><strong>Age / Gender</strong></td>
        <td>:</td>
        <td>{$age} / {$gender}</td>
        <td><strong>Register Date</strong></td>
        <td>:</td>
        <td>{$formatted_bill_date}</td>
    </tr>
    <tr>
        <td><strong>Referred Doctor</strong></td>
        <td>:</td>
        <td>Dr. {$dr_label}</td>
        <td><strong>Report Date</strong></td>
        <td>:</td>
        <td>{$report_date}</td>
    </tr>
</table>
EOD;
    } elseif ($style === 'compact') {
        return <<<EOD
<table width="100%" cellpadding="2" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; font-size: 8.5px; border: 1px solid #cbd5e1; background-color: #f8fafc;">
    <tr>
        <td width="18%"><strong>Patient:</strong> {$bill['full_name']}</td>
        <td width="18%"><strong>Age/Sex:</strong> {$age}/{$gender}</td>
        <td width="22%"><strong>Ref By:</strong> Dr. {$dr_label}</td>
        <td width="20%"><strong>Bill #:</strong> #{$bill['bill_id']}</td>
        <td width="22%"><strong>Date:</strong> {$report_date}</td>
    </tr>
</table>
EOD;
    } else {
        // Clinical NABL standard (default) & letterhead
        return <<<EOD
<table width="100%" cellpadding="3" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; font-size: 9.5px; border: 1px solid #0284c7; background-color: #f0f9ff;">
    <tr>
        <td width="18%"><strong>Patient Name</strong></td>
        <td width="2%">:</td>
        <td width="38%" style="font-size: 10.5px; font-weight: bold; color: #0369a1;">{$bill['full_name']}</td>
        <td width="14%"><strong>Bill No</strong></td>
        <td width="2%">:</td>
        <td width="26%" style="font-weight: bold; color: #0f172a;">#{$bill['bill_id']}</td>
    </tr>
    <tr>
        <td><strong>Age / Gender</strong></td>
        <td>:</td>
        <td>{$age} / {$gender}</td>
        <td><strong>Registered</strong></td>
        <td>:</td>
        <td>{$formatted_bill_date}</td>
    </tr>
    <tr>
        <td><strong>Referred By</strong></td>
        <td>:</td>
        <td>Dr. {$dr_label}</td>
        <td><strong>Reported</strong></td>
        <td>:</td>
        <td>{$report_date}</td>
    </tr>
</table>
EOD;
    }
}

function getTestHeader($style) {
    if ($style === 'modern') {
        return <<<EOD
<table width="100%" cellpadding="4" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; font-size: 10px; border-bottom: 2px solid #0f172a; border-collapse: collapse;">
    <tr style="background-color:#0f172a; color:#ffffff; font-weight:bold;">
        <td width="42%">TEST</td>
        <td width="18%">RESULT</td>
        <td width="15%">UNIT</td>
        <td width="25%">REFERENCE RANGE</td>
    </tr>
</table>
EOD;
    } elseif ($style === 'compact') {
        return <<<EOD
<table width="100%" cellpadding="2" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; font-size: 8.5px; border-top: 1px solid #000; border-bottom: 1px solid #000; border-collapse: collapse;">
    <tr style="background-color:#e2e8f0; font-weight:bold;">
        <td width="42%">TEST</td>
        <td width="18%">RESULT</td>
        <td width="15%">UNIT</td>
        <td width="25%">REFERENCE RANGE</td>
    </tr>
</table>
EOD;
    } else {
        // Clinical standard & letterhead
        return <<<EOD
<table width="100%" cellpadding="4" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; font-size: 10px; border-top: 1px solid #0284c7; border-bottom: 1px solid #0284c7; border-collapse: collapse;">
    <tr style="background-color:#0284c7; color:#ffffff; font-weight:bold;">
        <td width="42%">TEST</td>
        <td width="18%">RESULT</td>
        <td width="15%">UNIT</td>
        <td width="25%">REFERENCE RANGE</td>
    </tr>
</table>
EOD;
    }
}

function calculateRefRange($row, $gender, $age_years) {
    $ref_range = '';
    $min = $max = null;

    if (!empty($row['use_reference_text']) && !empty($row['reference_text'])) {
        $ref_range = $row['reference_text'];
    } elseif ($age_years < 12 && (!empty($row['child_min']) || !empty($row['child_max']))) {
        $ref_range = "{$row['child_min']} - {$row['child_max']}";
        $min = is_numeric($row['child_min']) ? floatval($row['child_min']) : null;
        $max = is_numeric($row['child_max']) ? floatval($row['child_max']) : null;
    } elseif ($gender === 'female' && (!empty($row['female_min']) || !empty($row['female_max']))) {
        $ref_range = "{$row['female_min']} - {$row['female_max']}";
        $min = is_numeric($row['female_min']) ? floatval($row['female_min']) : null;
        $max = is_numeric($row['female_max']) ? floatval($row['female_max']) : null;
    } elseif (!empty($row['male_min']) || !empty($row['male_max'])) {
        $ref_range = "{$row['male_min']} - {$row['male_max']}";
        $min = is_numeric($row['male_min']) ? floatval($row['male_min']) : null;
        $max = is_numeric($row['male_max']) ? floatval($row['male_max']) : null;
    }

    return [$ref_range, $min, $max];
}

function getResultDisplay($row, $min, $max) {
    $value = $row['result_value'] ?? '';
    if ($value === '') return '<span style="color:#94a3b8;">Not Tested</span>';

    $highlight = false;
    $val_lower = strtolower(trim($value));

    if (in_array($val_lower, ['positive', 'reactive', 'high', 'present', 'detected', 'abnormal'])) {
        $highlight = true;
    }

    if (!$highlight && is_numeric($value) && $min !== null && $max !== null) {
        $val = floatval($value);
        if ($val < $min || $val > $max) {
            $highlight = true;
        }
    }

    return $highlight ? '<strong style="color:#dc2626; font-size:10.5px;">' . htmlspecialchars($value) . ' *</strong>' : '<strong>' . htmlspecialchars($value) . '</strong>';
}

function renderTestNotesAndInterpretation($test_id, $pdf, $include_notes, $include_interpretation) {
    global $conn;
    if (!$include_notes && !$include_interpretation) return;

    $stmt = $conn->prepare("SELECT notes, interpretations FROM lab_tests WHERE test_id = ? LIMIT 1");
    if (!$stmt) return;
    $stmt->bind_param("i", $test_id);
    $stmt->execute();
    $stmt->bind_result($notes, $interpretation);
    $stmt->fetch();
    $stmt->close();

    $html = '';
    if ($include_notes && !empty($notes) && trim($notes) !== '') {
        $html .= '<div style="font-size:8.5px; color:#475569; margin-top:4px;"><strong>Clinical Notes:</strong> ' . htmlspecialchars($notes) . '</div>';
    }
    if ($include_interpretation && !empty($interpretation) && trim($interpretation) !== '') {
        $clean_interp = strip_tags($interpretation, '<br><b><strong><ul><li><p>');
        $html .= '<div style="font-size:8.5px; color:#334155; margin-top:4px; background-color:#f8fafc; padding:4px; border-left:3px solid #0284c7;"><strong>Interpretation:</strong> ' . $clean_interp . '</div>';
    }

    if (!empty($html)) {
        $pdf->writeHTML($html, true, false, true, false, '');
    }
}

function renderReportFooterSignature($pdf, $qr_link, $include_signature) {
    global $conn;
    if (!$include_signature) return;

    // Fetch active doctor from sign_master
    $doctor_name = "N Srinivas Rao";
    $doctor_role = "Doctor";
    $doctor_qual = "";
    $signature_image = "nsrsign.png";
    $stamp_image = "reddy.png";

    $sq = $conn->query("SELECT Name, role, qualification, signimage, stampimage FROM sign_master WHERE status = 'active' LIMIT 1");
    if ($sq && $srow = $sq->fetch_assoc()) {
        $doctor_name = $srow['Name'] ?: $doctor_name;
        $doctor_role = $srow['role'] ?? 'Doctor';
        $doctor_qual = $srow['qualification'] ?? '';
        $signature_image = $srow['signimage'] ?: $signature_image;
        $stamp_image = $srow['stampimage'] ?: $stamp_image;
    }

    // Check which images exist on disk
    $has_sig = false;
    $sigPath = '';
    if (!empty($signature_image)) {
        $sigPath = __DIR__ . '/sign_stamp/' . $signature_image;
        if (file_exists($sigPath)) {
            $has_sig = true;
        }
    }

    $has_stamp = false;
    $stampPath = '';
    if (!empty($stamp_image)) {
        $stampPath = __DIR__ . '/sign_stamp/' . $stamp_image;
        if (file_exists($stampPath)) {
            $has_stamp = true;
        }
    }

    // Dynamic height calculation based on available elements
    $requiredHeight = ($has_sig && $has_stamp) ? 46 : 34;
    $curY = $pdf->GetY();
    $pageHeight = $pdf->getPageHeight();

    if ($curY + $requiredHeight > $pageHeight - 12) {
        $pdf->AddPage();
        $curY = $pdf->GetY();
    }

    $footerY = max($curY + 4, $pageHeight - $requiredHeight - 2);

    // Temporarily turn OFF auto page break so drawing bottom elements NEVER adds extra pages!
    $pdf->SetAutoPageBreak(false);

    $is_doc = ($doctor_role === 'Doctor');
    if (!empty($doctor_name)) {
        if ($is_doc && !preg_match('/^(Dr|Doctor)\b/i', $doctor_name)) {
            $doc_label = "Dr. " . $doctor_name;
        } else {
            $doc_label = $doctor_name;
        }
    } else {
        $doc_label = "Authorized Signatory";
    }

    // Designation and qualification line
    $designation_parts = [];
    if (!empty($doctor_qual)) {
        $designation_parts[] = $doctor_qual;
    }
    if ($doctor_role === 'Doctor') {
        $designation_parts[] = "Consultant Pathologist";
    } elseif (!empty($doctor_role)) {
        $designation_parts[] = $doctor_role;
    } else {
        $designation_parts[] = "Consultant Pathologist";
    }
    $designation_label = implode(" | ", $designation_parts);

    if ($has_sig && $has_stamp) {
        // Mode 1: Both Signature & Stamp available -> Show Signature on top and Stamp directly underneath!
        // (Stamp image already contains doctor name, degrees & registration number, so duplicate text is omitted)
        $pdf->Image($sigPath, 148, $footerY + 2, 42, 16, '', '', '', false, 300, '', false, false, 0);
        $pdf->Image($stampPath, 152, $footerY + 15, 34, 19, '', '', '', false, 300, '', false, false, 0);
        $baseY = $footerY + 34;

        // QR code on the bottom left aligned with the stamp baseline
        $qrY = $baseY - 20;
        $pdf->write2DBarcode($qr_link, 'QRCODE,L', 12, $qrY, 18, 18);
        $pdf->SetFont('helvetica', '', 7);
        $pdf->SetXY(12, $baseY - 1);
        $pdf->Cell(25, 4, "Scan to Verify", 0, 0, 'L');

    } elseif ($has_sig && !$has_stamp) {
        // Mode 2: Signature available, Stamp not available -> Show Signature + Doctor Details
        $pdf->Image($sigPath, 148, $footerY + 2, 42, 16, '', '', '', false, 300, '', false, false, 0);
        $nameY = $footerY + 20;

        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetXY(130, $nameY);
        $pdf->Cell(65, 4, $doc_label, 0, 1, 'R');
        $pdf->SetFont('helvetica', '', 8);
        $pdf->SetXY(130, $nameY + 4);
        $pdf->Cell(65, 4, $designation_label, 0, 1, 'R');

        // QR code aligned with doctor text
        $qrY = $nameY - 16;
        $pdf->write2DBarcode($qr_link, 'QRCODE,L', 12, $qrY, 18, 18);
        $pdf->SetFont('helvetica', '', 7);
        $pdf->SetXY(12, $nameY + 3);
        $pdf->Cell(25, 4, "Scan to Verify", 0, 0, 'L');

    } else {
        // Mode 3: Images not available -> Dynamically print signatory line + Doctor Details
        $nameY = $footerY + 18;

        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetTextColor(100, 116, 139);
        $pdf->SetXY(130, $nameY - 4);
        $pdf->Cell(65, 4, "________________________", 0, 1, 'R');

        $pdf->SetTextColor(15, 23, 42);
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetXY(130, $nameY + 2);
        $pdf->Cell(65, 4, $doc_label, 0, 1, 'R');
        $pdf->SetFont('helvetica', '', 8);
        $pdf->SetXY(130, $nameY + 6);
        $pdf->Cell(65, 4, $designation_label, 0, 1, 'R');

        // QR code aligned with doctor text
        $qrY = $nameY - 14;
        $pdf->write2DBarcode($qr_link, 'QRCODE,L', 12, $qrY, 18, 18);
        $pdf->SetFont('helvetica', '', 7);
        $pdf->SetXY(12, $nameY + 5);
        $pdf->Cell(25, 4, "Scan to Verify", 0, 0, 'L');
    }

    // Re-enable auto page break
    $pdf->SetAutoPageBreak(true, 25);
}

// --- Custom TCPDF class supporting full-page letterhead background image ---
if (!class_exists('LabReportTCPDF')) {
    class LabReportTCPDF extends TCPDF {
        public $letterhead_image_path = null;

        public function Header() {
            if (!empty($this->letterhead_image_path) && file_exists($this->letterhead_image_path)) {
                $auto_page_break = $this->AutoPageBreak;
                $bMargin = $this->getBreakMargin();
                $this->SetAutoPageBreak(false, 0);
                $this->Image($this->letterhead_image_path, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
                $this->SetAutoPageBreak($auto_page_break, $bMargin);
                $this->setPageMark();
            }
        }
    }
}

// --- Initialize PDF ---
$pdf = new LabReportTCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Header & Margins setup based on header_mode:
// 1. letterhead_image: Background letterhead image (letterhead.jpg / ammaletterhead.jpg)
// 2. blank_1_5: Top margin is exactly 1.5 inches = 38.1 mm (for pre-printed stationery)
// 3. printed: Top margin 12mm with Lab Logo & Address letterhead
// 4. plain: Top margin 12mm with plain page
if ($header_mode === 'letterhead_image' && $letterhead_image_file) {
    $pdf->letterhead_image_path = $letterhead_image_file;
    $pdf->setPrintHeader(true);
    $pdf->setPrintFooter(false);
    $top_margin = 42.0; // 42mm leaves clear space below letterhead banner
    $bottom_margin = 28.0; // Leaves space above footer
    $show_lab_header = false;
} elseif ($header_mode === 'blank_1_5') {
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $top_margin = 38.1; // 1.5 inches
    $bottom_margin = 25.0;
    $show_lab_header = false;
} elseif ($header_mode === 'printed') {
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $top_margin = 12.0;
    $bottom_margin = 25.0;
    $show_lab_header = true;
} else {
    // plain
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $top_margin = ($report_style === 'compact') ? 10.0 : 12.0;
    $bottom_margin = 25.0;
    $show_lab_header = false;
}

$side_margin = ($report_style === 'compact') ? 8.0 : 12.0;
$pdf->SetMargins($side_margin, $top_margin, $side_margin, true);
$pdf->SetAutoPageBreak(true, $bottom_margin);
$pdf->SetFont('helvetica', '', 10);

$age = !empty($bill['age']) ? $bill['age'] : calculateAge($bill['date_of_birth']);
$dr_ref = !empty($bill['dr_ref']) ? $bill['dr_ref'] : '';
$gender = ucfirst($bill['gender'] ?? '');
$report_date = date("d-M-Y h:i A");

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'] ?? 'labs.vensaas.com';
$current_dir = rtrim(dirname($_SERVER['PHP_SELF'] ?? '/demo'), '/\\');
$token = encodeID($bill_id);
$qr_link = "{$protocol}{$host}{$current_dir}/download_pdf.php?token={$token}";
$age_years = (int)date_diff(date_create($bill['date_of_birth'] ?? 'now'), date_create())->format('%y');

// Fetch test results
$stmt = $conn->prepare("
    SELECT g.group_name, t.test_id, t.test_name, ltp.param_order, ltp.section_name, tp.param_name, tp.unit, tp.method,
           r.result_value, rr.child_min, rr.child_max, rr.female_min, rr.female_max, rr.male_min, rr.male_max, rr.use_reference_text, rr.reference_text
    FROM test_results r
    JOIN test_parameters tp ON r.parameter_id = tp.parameter_id
    JOIN lab_test_parameters ltp ON tp.parameter_id = ltp.parameter_id
    JOIN lab_tests t ON ltp.test_id = t.test_id
    LEFT JOIN test_groups g ON t.group_id = g.group_id
    LEFT JOIN parameter_reference_ranges rr ON tp.parameter_id = rr.parameter_id
    WHERE r.bill_id = ? AND r.test_id = t.test_id
    ORDER BY g.group_name, t.test_name, ltp.param_order
");
$stmt->bind_param("i", $bill_id);
$stmt->execute();
$results = $stmt->get_result();

$grouped_results = [];

while ($row = $results->fetch_assoc()) {
    $group_name = $row['group_name'] ?: 'Clinical Pathology';
    $test_key = $row['test_id'] . '|' . $row['test_name'];
    $section_key = $row['section_name'] ?: '';
    $grouped_results[$group_name][$test_key][$section_key][] = $row;
}
$stmt->close();

// Fallback if no test results recorded yet
if (empty($grouped_results)) {
    $bq = $conn->query("SELECT t.test_id, t.test_name, g.group_name FROM bill_tests bt JOIN lab_tests t ON bt.test_id = t.test_id LEFT JOIN test_groups g ON t.group_id = g.group_id WHERE bt.bill_id = {$bill_id}");
    if ($bq) {
        while ($brow = $bq->fetch_assoc()) {
            $g = $brow['group_name'] ?: 'General Tests';
            $tk = $brow['test_id'] . '|' . $brow['test_name'];
            $grouped_results[$g][$tk][''] = [];
        }
    }
}

// Cell padding & font size per style
$cell_padding = ($report_style === 'compact') ? 'padding:2px 4px;' : 'padding:4px 6px;';
$font_size = ($report_style === 'compact') ? 'font-size:8.5px;' : 'font-size:9.5px;';
$border_color = ($report_style === 'modern') ? '#e2e8f0' : '#cbd5e1';

// Lab Letterhead HTML (if printed mode)
$lab_header_block = $show_lab_header ? getLabHeaderHTML($conn) : '';

if ($pagebreak_per_test) {
    // Mode A: Test-wise Page Break (Each major test on fresh page)
    foreach ($grouped_results as $group => $tests) {
        foreach ($tests as $test_key => $sections) {
            [$curr_test_id, $test_name] = explode('|', $test_key);
            $pdf->AddPage();

            $html = $lab_header_block;
            $html .= generatePatientHTML($bill, $age, $gender, $dr_ref, $report_date, $report_style);
            $html .= '<div style="margin-top:6px; margin-bottom:4px; font-size:11px; font-weight:bold; color:#0f172a; text-align:center; border-bottom:1px solid #cbd5e1; padding-bottom:3px;">' . strtoupper(htmlspecialchars($test_name)) . '</div>';
            $html .= getTestHeader($report_style);

            $html .= '<table width="100%" cellpadding="3" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; ' . $font_size . ' border-collapse: collapse;">';
            $row_idx = 0;
            foreach ($sections as $section => $params) {
                if ($section) {
                    $html .= '<tr><td colspan="4" style="background-color:#f1f5f9; font-weight:bold; padding:4px; border-bottom:1px solid #cbd5e1;"><u>' . htmlspecialchars($section) . '</u></td></tr>';
                }
                foreach ($params as $row) {
                    list($ref_range, $min, $max) = calculateRefRange($row, strtolower($gender), $age_years);
                    $result_display = getResultDisplay($row, $min, $max);
                    $method = ($include_method && !empty($row['method'])) ? '<br><span style="color:#64748b; font-size:7.5px;">Method: ' . htmlspecialchars($row['method']) . '</span>' : '';
                    $bg = ($report_style === 'modern' && $row_idx % 2 === 1) ? 'background-color:#f8fafc;' : '';

                    $html .= '<tr style="' . $bg . ' border-bottom:1px solid ' . $border_color . ';">
                        <td width="42%" style="' . $cell_padding . '">' . htmlspecialchars($row['param_name']) . $method . '</td>
                        <td width="18%" style="' . $cell_padding . '">' . $result_display . '</td>
                        <td width="15%" style="' . $cell_padding . '">' . htmlspecialchars($row['unit']) . '</td>
                        <td width="25%" style="' . $cell_padding . ' color:#334155;">' . htmlspecialchars($ref_range) . '</td>
                    </tr>';
                    $row_idx++;
                }
            }
            $html .= '</table>';
            $pdf->writeHTML($html, true, false, true, false, '');

            // Notes for this specific test
            renderTestNotesAndInterpretation($curr_test_id, $pdf, $include_notes, $include_interpretation);

            // Signature footer for this test's page
            renderReportFooterSignature($pdf, $qr_link, $include_signature);
        }
    }
} else {
    // Mode B: Standard Continuous Flow (No page breaks between tests)
    $pdf->AddPage();
    $html = $lab_header_block;
    $html .= generatePatientHTML($bill, $age, $gender, $dr_ref, $report_date, $report_style);
    $html .= '<div style="margin-top:5px; margin-bottom:5px;"></div>';

    foreach ($grouped_results as $group => $tests) {
        $html .= '<div style="background-color:#f1f5f9; border-left:3px solid #0284c7; padding:3px 8px; font-weight:bold; font-size:10px; color:#0f172a; margin-top:6px; margin-bottom:3px;">' . strtoupper(htmlspecialchars($group)) . '</div>';
        
        foreach ($tests as $test_key => $sections) {
            [$curr_test_id, $test_name] = explode('|', $test_key);
            $html .= '<div style="font-weight:bold; font-size:10.5px; color:#0369a1; padding:2px 0; margin-top:2px;">' . strtoupper(htmlspecialchars($test_name)) . '</div>';
            $html .= getTestHeader($report_style);

            $html .= '<table width="100%" cellpadding="3" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif; ' . $font_size . ' border-collapse: collapse;">';
            $row_idx = 0;
            foreach ($sections as $section => $params) {
                if ($section) {
                    $html .= '<tr><td colspan="4" style="background-color:#f8fafc; font-weight:bold; padding:3px; border-bottom:1px solid #cbd5e1;"><u>' . htmlspecialchars($section) . '</u></td></tr>';
                }
                foreach ($params as $row) {
                    list($ref_range, $min, $max) = calculateRefRange($row, strtolower($gender), $age_years);
                    $result_display = getResultDisplay($row, $min, $max);
                    $method = ($include_method && !empty($row['method'])) ? '<br><span style="color:#64748b; font-size:7.5px;">Method: ' . htmlspecialchars($row['method']) . '</span>' : '';
                    $bg = ($report_style === 'modern' && $row_idx % 2 === 1) ? 'background-color:#f8fafc;' : '';

                    $html .= '<tr style="' . $bg . ' border-bottom:1px solid ' . $border_color . ';">
                        <td width="42%" style="' . $cell_padding . '">' . htmlspecialchars($row['param_name']) . $method . '</td>
                        <td width="18%" style="' . $cell_padding . '">' . $result_display . '</td>
                        <td width="15%" style="' . $cell_padding . '">' . htmlspecialchars($row['unit']) . '</td>
                        <td width="25%" style="' . $cell_padding . ' color:#334155;">' . htmlspecialchars($ref_range) . '</td>
                    </tr>';
                    $row_idx++;
                }
            }
            $html .= '</table>';
        }
    }

    $pdf->writeHTML($html, true, false, true, false, '');

    // Render signature block once at the end of the entire report
    renderReportFooterSignature($pdf, $qr_link, $include_signature);
}

// Auto-trigger browser print dialog if requested
if ($print_mode) {
    $pdf->IncludeJS("print();");
}

ob_end_clean();

if ($download_mode) {
    $pdf->Output("diagnostic_report_{$bill_id}.pdf", 'D');
} else {
    $pdf->Output("diagnostic_report_{$bill_id}.pdf", 'I');
}
