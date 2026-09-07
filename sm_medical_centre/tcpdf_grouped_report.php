<?php
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

// PDF setup
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetMargins(10, 10, 10, true);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

// Patient info
$html = "<table cellpadding='2'>
<tr><td><strong>Name:</strong> {$bill['full_name']}</td>
<td><strong>Age/Gender:</strong> {$age} / {$gender}</td></tr>
<tr><td><strong>Bill No:</strong> {$bill['bill_id']}</td>
<td><strong>Registered Date:</strong> {$bill['bill_date']}</td></tr>
<tr><td><strong>Reported Date:</strong> {$report_date}</td>
<td></td></tr>
</table><br><hr>";

// Fetch group-wise test results
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
while ($row = $results->fetch_assoc()) {
    // Group Header
    if ($current_group !== $row['group_name']) {
        $current_group = $row['group_name'];
        $html .= "<h3 align='center'>{$current_group}</h3>";
    }

    // Test Header
    if ($current_test !== $row['test_name']) {
        $current_test = $row['test_name'];
        $html .= "<br><table border='1' cellpadding='4' cellspacing='0' width='100%'>
        <tr style='background-color:#eee;font-weight:bold;'>
            <td>Test Description</td><td>Result</td><td>Unit</td><td>Ref. Ranges</td>
        </tr>";
    }

    $method = $row['method'] ? "<br><small>Method: {$row['method']}</small>" : '';
    $ref_range = "{$row['male_min']} - {$row['male_max']}";
    $html .= "<tr>
        <td>{$row['param_name']}{$method}</td>
        <td>{$row['result_value']}</td>
        <td>{$row['unit']}</td>
        <td>{$ref_range}</td>
    </tr>";
}
$html .= "</table><br>";

// Fetch notes and interpretations from templates
$template_sql = "SELECT notes, interpretation FROM test_templates WHERE test_id IN 
                (SELECT test_id FROM bill_tests WHERE bill_id = ?)";
$stmt = $conn->prepare($template_sql);
$stmt->bind_param("i", $bill_id);
$stmt->execute();
$template_result = $stmt->get_result();
$notes_all = '';
$interpret_all = '';
while ($tpl = $template_result->fetch_assoc()) {
    $notes_all .= $tpl['notes'] . "<br>";
    $interpret_all .= $tpl['interpretation'] . "<br>";
}

// Add notes
if ($notes_all) {
    $html .= "<br><h4>Notes:</h4><div>{$notes_all}</div>";
}
if ($interpret_all) {
    $html .= "<br><h4>Interpretations:</h4><div>{$interpret_all}</div>";
}

// Add HTML and QR
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->write2DBarcode($qr_link, 'QRCODE,L', 150, $pdf->getY() + 10, 25, 25);
$pdf->Text(150, $pdf->getY() + 36, 'Download Report');

// Signature
$pdf->Ln(30);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 0, "LAB INCHARGE", 0, 1, 'R');
$pdf->Cell(0, 0, "Dr. Signature & Stamp", 0, 1, 'R');

$pdf->Output("report_{$bill_id}.pdf", 'I');
?>
