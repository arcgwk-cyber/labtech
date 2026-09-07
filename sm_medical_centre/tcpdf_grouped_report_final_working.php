<?php
ob_clean();
require_once('tcpdf/tcpdf.php');
require_once('db.php');

$bill_id = $_GET['bill_id'] ?? 0;
if (!$bill_id) {
    die('Bill ID is required.');
}

// Fetch bill and patient data
$bill_sql = "SELECT b.*, p.full_name, p.gender, p.date_of_birth, p.address 
             FROM bills b 
             JOIN patients p ON b.patient_id = p.patient_id 
             WHERE b.bill_id = ?";
$stmt = $conn->prepare($bill_sql);
$stmt->bind_param("i", $bill_id);
$stmt->execute();
$bill = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$bill) die('Invalid bill ID');

function calculateAge($dob) {
    $diff = date_diff(date_create($dob), date_create());
    return $diff->format("%y Y");
}

$age = calculateAge($bill['date_of_birth']);
$gender = ucfirst($bill['gender']);
$report_date = date("d-M-Y h:i A");
$qr_link = "http://yourdomain.com/reports/download.php?bill_id={$bill_id}";

function generatePatientHTML($bill, $age, $gender, $report_date) {
    return <<<EOD
<table width="100%" cellpadding="4" cellspacing="0">
    <tr>
        <td><strong>Name:</strong> {$bill['full_name']}</td>
        <td align="right"><strong>Bill No:</strong> {$bill['bill_id']}</td>
    </tr>
    <tr>
        <td><strong>Age/Gender:</strong> {$age} / {$gender}</td>
        <td align="right"><strong>Date:</strong> {$bill['bill_date']}</td>
    </tr>
    <tr>
        <td><strong>Referred By:</strong> Dr.</td>
        <td align="right"><strong>Reported Date:</strong> {$report_date}</td>
    </tr>
</table>
<br>
<div style="border-top:1px solid #000; margin:5px 0;"></div>
<br>
EOD;
}

function appendNotesInterpretationSignature($test_id, $qr_link, $pdf, $conn) {
    $note_sql = "SELECT notes, interpretation FROM test_templates WHERE test_id = ?";
    $note_stmt = $conn->prepare($note_sql);
    $note_stmt->bind_param("i", $test_id);
    $note_stmt->execute();
    $note_result = $note_stmt->get_result()->fetch_assoc();
    $note_stmt->close();

    $notes = $note_result['notes'] ?? '';
    $interpret = $note_result['interpretation'] ?? '';

    $html = '';
    if ($notes) {
        $html .= "<h4>Notes:</h4><div style='font-style:italic;'>{$notes}</div>";
    }
    if ($interpret) {
        $html .= "<h4>Interpretations:</h4><div style='font-style:italic;'>{$interpret}</div>";
    }
    if ($html) {
        $pdf->writeHTML($html, true, false, true, false, '');
    }

    $pdf->SetY($pdf->GetY() + 10);
    $y = $pdf->GetY();
    $pdf->write2DBarcode($qr_link, 'QRCODE,L', 90, $y, 20, 20);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->SetXY(140, $y + 5);
    $pdf->Cell(60, 5, "Authorized Signatory", 0, 1, 'R');
    $pdf->SetXY(140, $y + 11);
    $pdf->Cell(60, 5, "Dr. Signature & Stamp", 0, 1, 'R');
}


// Initialize TCPDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetMargins(10, 10, 10, true);
$pdf->SetFont('helvetica', '', 10);
$pdf->AddPage(); // ✅ fix: start first page before writing anything
// Fetch test results
$group_sql = "SELECT g.group_name, t.test_id, t.test_name, tp.param_name, tp.unit,
                     r.result_value, tp.method, rr.male_min, rr.male_max
              FROM test_results r
              JOIN test_parameters tp ON r.parameter_id = tp.parameter_id
              JOIN lab_test_parameters ltp ON tp.parameter_id = ltp.parameter_id
              JOIN lab_tests t ON ltp.test_id = t.test_id
              LEFT JOIN test_groups g ON t.group_id = g.group_id
              LEFT JOIN parameter_reference_ranges rr ON tp.parameter_id = rr.parameter_id
              WHERE r.bill_id = ?
              ORDER BY g.group_name, t.test_name, tp.param_name";

$stmt = $conn->prepare($group_sql);
$stmt->bind_param("i", $bill_id);
$stmt->execute();
$results = $stmt->get_result();

$current_group = '';
$current_test = '';
$html = '';

function getGroupHeader($groupName) {
    return <<<EOD
<table border="1" width="100%" cellpadding="6" cellspacing="0">
    <tr style="background-color:#d9d9d9; font-weight:bold;">
        <td colspan="4" align="center">{$groupName}</td>
    </tr>
</table>
<br>
EOD;
}

function getTestHeader() {
    return <<<EOD
<table width="100%" cellpadding="4" cellspacing="0">
    <tr style="background-color:#f2f2f2; font-weight:bold;">
        <td border="1">Test Description</td>
        <td border="1">Result</td>
        <td border="1">Unit</td>
        <td border="1">Ref. Ranges</td>
    </tr>
EOD;
}

while ($row = $results->fetch_assoc()) {
    if ($current_test !== $row['test_name']) {
        if ($current_test !== '') {
            $html .= "</table><br>";
            $pdf->writeHTML($html, true, false, true, false, '');
            appendNotesInterpretationSignature($current_test_id, $qr_link, $pdf, $conn);
            $pdf->AddPage();
        }

        $html = '';
        $current_group = $row['group_name'] ?: 'General Tests';
        $current_test = $row['test_name'];
        $current_test_id = $row['test_id'];

        $html .= generatePatientHTML($bill, $age, $gender, $report_date);
        $html .= getGroupHeader($current_group);
        $html .= getTestHeader();
    }

    $method = $row['method'] ? "<br><small>Method: {$row['method']}</small>" : '';

    $ref_range = '';
    if (is_numeric($row['male_min']) && is_numeric($row['male_max'])) {
        $ref_range = "{$row['male_min']} - {$row['male_max']}";
    }

    $highlight = false;
    $keywords = ['abnormal', 'positive', 'reactive'];
    foreach ($keywords as $word) {
        if (stripos($row['result_value'], $word) !== false) {
            $highlight = true;
            break;
        }
    }
    if (!$highlight && is_numeric($row['result_value']) && is_numeric($row['male_min']) && is_numeric($row['male_max'])) {
        $val = floatval($row['result_value']);
        if ($val < $row['male_min'] || $val > $row['male_max']) {
            $highlight = true;
        }
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

// Final output for the last test
if ($html) {
    $html .= "</table><br>";
    $pdf->writeHTML($html, true, false, true, false, '');
    appendNotesInterpretationSignature($current_test_id, $qr_link, $pdf, $conn);
}

$pdf->Output("report_{$bill_id}.pdf", 'I');
?>
