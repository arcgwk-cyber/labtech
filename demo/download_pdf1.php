<?php
ob_clean();
require_once(__DIR__.'/TCPDF/tcpdf.php');
require_once('db.php');

$bill_id = $_GET['bill_id'] ?? 0;
if (!$bill_id) die('Bill ID is required.');

$include_method = isset($_GET['include_method']);
$include_notes = isset($_GET['include_notes']);
$include_interpretation = isset($_GET['include_interpretation']);
$pagebreak_per_test = isset($_GET['pagebreak_per_test']);

// Get bill + patient data
$stmt = $conn->prepare("
    SELECT b.*, p.full_name, p.gender, p.date_of_birth, p.address
    FROM bills b
    JOIN patients p ON b.patient_id = p.patient_id
    WHERE b.bill_id = ?");
$stmt->bind_param("i", $bill_id);
$stmt->execute();
$bill = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$bill) die('Invalid bill ID');

function calculateAge($dob) {
    $diff = date_diff(date_create($dob), date_create());
    return $diff->format("%y Y");
}

function generatePatientHTML($bill, $age, $gender, $report_date) {
    return <<<EOD
<table width="100%" cellpadding="2" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif;">
    <tr>
        <td width="12%"><strong>Name</strong></td>
        <td width="2%">:</td>
        <td width="42%">{$bill['full_name']}</td>
        <td width="19%"><strong>Bill No.</strong></td>
        <td width="2%">:</td>
        <td width="20%">{$bill['bill_id']}</td>
    </tr>
    <tr>
        <td><strong>Age/Gender</strong></td>
        <td>:</td>
        <td>{$age} / {$gender}</td>
        <td><strong>Registered Date</strong></td>
        <td>:</td>
        <td>{$bill['bill_date']}</td>
    </tr>
    <tr>
        <td><strong>Referred By</strong></td>
        <td>:</td>
        <td>Dr.</td>
        <td><strong>Reported Date</strong></td>
        <td>:</td>
        <td>{$report_date}</td>
    </tr>
</table><br><div style="border-top:1px solid #000; margin:5px 0;"></div><br>
EOD;
}

function getGroupHeader($groupName) {
    $groupName = strtoupper($groupName);
    return <<<EOD
<table border="1" width="100%" cellpadding="6" cellspacing="0" style="font-family: 'Times New Roman', Times, serif; font-size: 11px;">
    <tr style="background-color:#d9d9d9; font-weight:bold;">
        <td colspan="4" align="center">{$groupName}</td>
    </tr>
</table><br>
EOD;
}

function getTestHeader() {
    return <<<EOD
<table width="100%" cellpadding="2" cellspacing="0" style="font-family: 'Times New Roman', Times, serif; font-size: 11px;">
    <tr style="background-color:#f2f2f2; font-weight:bold;">
        <td border="1">TEST DESCRIPTION</td>
        <td border="1">RESULT</td>
        <td border="1">UNIT</td>
        <td border="1">REFERENCE RANGE</td>
    </tr>
EOD;
}

function appendTestNotesAndSignature($test_id, $qr_link, $pdf, $include_notes, $include_interpretation) {
    global $conn;

    $sql = "SELECT notes, interpretations FROM lab_tests WHERE test_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $test_id);
    $stmt->execute();
    $stmt->bind_result($notes, $interpretation);
    $stmt->fetch();
    $stmt->close();

    $interpretation = preg_replace('/<figure[^>]*>/', '', $interpretation);
    $interpretation = str_replace(['</figure>', '<table', '<td', '<th'], ['', '<table border="1" cellpadding="4" cellspacing="0" style="border-collapse:collapse;"', '<td style="border:1px solid #000;"', '<th style="border:1px solid #000;"'], $interpretation);

    $html = '';
    if ($include_notes && $notes) {
        $html .= "<h4>Notes:</h4>{$notes}";
    }
    if ($include_interpretation && $interpretation) {
        $html .= "<h4>Interpretation:</h4>{$interpretation}";
    }

    if (!empty($html)) {
        $pdf->writeHTML($html, true, false, true, false, '');
    }

    $currentPage = $pdf->getPage();
    $pdf->setPage($currentPage);
    $bottomY = $pdf->getPageHeight() - 50;
    if ($pdf->GetY() > $bottomY - 25) {
        $pdf->AddPage();
        $bottomY = $pdf->getPageHeight() - 50;
    }

    $pdf->SetY($bottomY);
    $y = $pdf->GetY();

    $pdf->write2DBarcode($qr_link, 'QRCODE,L', 90, $y, 20, 20);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->SetXY(120, $y + 5);
    $pdf->Cell(60, 5, "Authorized Signatory", 0, 1, 'R');
    $pdf->SetXY(120, $y + 11);
    $pdf->Cell(60, 5, "Dr. Signature & Stamp", 0, 1, 'R');
}

// Custom PDF class with background letterhead
class MYPDF extends TCPDF {
    public function Header() {
        $this->Image(__DIR__.'/letterhead.jpg', 0, 0, 240, 300, '', '', '', false, 300, '', false, false, 0);
    }
}

$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->setPrintHeader(true);
$pdf->setPrintFooter(false);
$pdf->SetMargins(10, 25.4, 10, true); // 1 inch top margin
$pdf->SetFont('helvetica', '', 10);

$age = calculateAge($bill['date_of_birth']);
$gender = ucfirst($bill['gender']);
$report_date = date("d-M-Y h:i A");
$qr_link = "http://labs.kesug.com/demo/download_pdf.php?bill_id={$bill_id}";

$stmt = $conn->prepare("
    SELECT g.group_name, t.test_id, t.test_name, ltp.param_order, tp.param_name, tp.unit,
           r.result_value, tp.method, rr.male_min, rr.male_max
    FROM test_results r
    JOIN test_parameters tp ON r.parameter_id = tp.parameter_id
    JOIN lab_test_parameters ltp ON tp.parameter_id = ltp.parameter_id
    JOIN lab_tests t ON ltp.test_id = t.test_id
    LEFT JOIN test_groups g ON t.group_id = g.group_id
    LEFT JOIN parameter_reference_ranges rr ON tp.parameter_id = rr.parameter_id
    WHERE r.bill_id = ? and t.test_id = r.test_id
    ORDER BY g.group_name, t.test_name, ltp.param_order");
$stmt->bind_param("i", $bill_id);
$stmt->execute();
$results = $stmt->get_result();

$current_group = '';
$current_test = '';
$printed_combos = [];
$html = '';
$last_test_id = 0;

if ($pagebreak_per_test) {
    $pdf->AddPage();
    while ($row = $results->fetch_assoc()) {
        $combo_key = $row['group_name'] . '|' . $row['test_name'];
        if (!in_array($combo_key, $printed_combos)) {
            if (!empty($html)) {
                $html .= "</table><br>";
                $pdf->writeHTML($html, true, false, true, false, '');
                appendTestNotesAndSignature($last_test_id, $qr_link, $pdf, $include_notes, $include_interpretation);
                $pdf->AddPage();
            }

            $html = generatePatientHTML($bill, $age, $gender, $report_date);
            $group_name = $row['group_name'] ?: 'General Tests';
            $html .= getGroupHeader($group_name);
            $html .= getTestHeader();
            $html .= "<strong>{$row['test_name']}</strong><br><br>";
            $last_test_id = $row['test_id'];
            $printed_combos[] = $combo_key;
        }

        $method = ($include_method && $row['method']) ? "<br><small>Method: {$row['method']}</small>" : '';
        $ref_range = (is_numeric($row['male_min']) && is_numeric($row['male_max'])) ? "{$row['male_min']} - {$row['male_max']}" : '';
        $highlight = false;
        foreach (['abnormal', 'positive', 'reactive'] as $word) {
            if (stripos($row['result_value'], $word) !== false) $highlight = true;
        }
        if (!$highlight && is_numeric($row['result_value']) && is_numeric($row['male_min']) && is_numeric($row['male_max'])) {
            $val = floatval($row['result_value']);
            if ($val < $row['male_min'] || $val > $row['male_max']) $highlight = true;
        }

        $result_display = $highlight ? "<strong>{$row['result_value']}</strong>" : $row['result_value'];

        $html .= <<<EOD
<tr>
    <td>{$row['param_name']}{$method}</td>
    <td>{$result_display}</td>
    <td>{$row['unit']}</td>
    <td>{$ref_range}</td>
</tr>
EOD;
    }
    if (!empty($html)) {
        $html .= "</table><br>";
        $pdf->writeHTML($html, true, false, true, false, '');
        appendTestNotesAndSignature($last_test_id, $qr_link, $pdf, $include_notes, $include_interpretation);
    }
} else {
    $pdf->AddPage();
    $html .= generatePatientHTML($bill, $age, $gender, $report_date);
    $grouped_results = [];

    while ($row = $results->fetch_assoc()) {
        $group_name = $row['group_name'] ?: 'General Tests';
        $test_key = $row['test_id'] . '|' . $row['test_name'];
        $grouped_results[$group_name][$test_key][] = $row;
        $last_test_id = $row['test_id'];
    }

    foreach ($grouped_results as $group => $tests) {
        $html .= getGroupHeader($group);
        $html .= getTestHeader();
        foreach ($tests as $test_key => $params) {
            [$test_id, $test_name] = explode('|', $test_key);
            $html .= "<strong>{$test_name}</strong><br><br>";
            foreach ($params as $row) {
                $method = ($include_method && $row['method']) ? "<br><small>Method: {$row['method']}</small>" : '';
                $ref_range = (is_numeric($row['male_min']) && is_numeric($row['male_max'])) ? "{$row['male_min']} - {$row['male_max']}" : '';
                $highlight = false;
                foreach (['abnormal', 'positive', 'reactive'] as $word) {
                    if (stripos($row['result_value'], $word) !== false) $highlight = true;
                }
                if (!$highlight && is_numeric($row['result_value']) && is_numeric($row['male_min']) && is_numeric($row['male_max'])) {
                    $val = floatval($row['result_value']);
                    if ($val < $row['male_min'] || $val > $row['male_max']) $highlight = true;
                }
                $result_display = $highlight ? "<strong>{$row['result_value']}</strong>" : $row['result_value'];
                $html .= <<<EOD
<tr>
    <td>{$row['param_name']}{$method}</td>
    <td>{$result_display}</td>
    <td>{$row['unit']}</td>
    <td>{$ref_range}</td>
</tr>
EOD;
            }
        }
        $html .= "</table><br>";
    }
    $pdf->writeHTML($html, true, false, true, false, '');
    appendTestNotesAndSignature($last_test_id, $qr_link, $pdf, $include_notes, $include_interpretation);
}

$pdf->Output("report_{$bill_id}.pdf", 'I');
