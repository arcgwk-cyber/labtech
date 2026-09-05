<?php
// pdf_report_generator.php
require('tcpdf/tcpdf.php');
require_once 'db.php';

$bill_id = $_GET['bill_id'] ?? 0;

function getBill($bill_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT b.*, p.* FROM bills b JOIN patients p ON p.patient_id = b.patient_id WHERE b.bill_id = ?");
    $stmt->bind_param("i", $bill_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getTestsForBill($bill_id) {
    global $conn;
    return $conn->query("SELECT DISTINCT t.test_id, t.test_name FROM test_results r JOIN lab_tests t ON t.test_id = r.test_id WHERE r.bill_id = $bill_id");
}

function getTemplateForTest($test_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM test_templates WHERE test_id = ?");
    $stmt->bind_param("i", $test_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getResultsForTest($bill_id, $test_id, $gender) {
    global $conn;
    $stmt = $conn->prepare("SELECT r.*, tp.param_name, tp.unit, tp.method, tp.group_name, rr.male_min, rr.male_max, rr.female_min, rr.female_max
                            FROM test_results r 
                            JOIN test_parameters tp ON tp.parameter_id = r.parameter_id
                            LEFT JOIN parameter_reference_ranges rr ON rr.parameter_id = r.parameter_id
                            WHERE r.bill_id = ? AND r.test_id = ?");
    $stmt->bind_param("ii", $bill_id, $test_id);
    $stmt->execute();
    $results = [];
    while ($row = $stmt->get_result()->fetch_assoc()) {
        $row['ref_min'] = $gender == 'male' ? $row['male_min'] : $row['female_min'];
        $row['ref_max'] = $gender == 'male' ? $row['male_max'] : $row['female_max'];
        $row['ref_range'] = $row['ref_min'] . ' - ' . $row['ref_max'];
        $results[] = $row;
    }
    return $results;
}

function getResultFlag($value, $min, $max) {
    if (!is_numeric($value)) {
        $v = strtolower($value);
        if (in_array($v, ['positive', 'reactive', 'abnormal'])) return ucfirst($v);
        return '';
    }
    if ($value < $min) return '< Min';
    if ($value > $max) return '> Max';
    return '';
}

function renderResultsTable($results, $template, $gender) {
    $html = '<table border="1" cellpadding="4" cellspacing="0" width="100%">';
    $html .= '<thead><tr><th>Parameter</th><th>Result</th><th>Unit</th><th>Reference</th>';
    if ($template['show_method']) $html .= '<th>Method</th>';
    $html .= '</tr></thead><tbody>';

    $group = '';
    foreach ($results as $r) {
        $flag = getResultFlag($r['result_value'], $r['ref_min'], $r['ref_max']);
        $style = $flag ? 'font-weight:bold' : '';

        if ($template['group_by'] && $group !== $r['group_name']) {
            $group = $r['group_name'];
            $html .= '<tr><td colspan="5"><b>' . htmlspecialchars($group) . '</b></td></tr>';
        }

        $html .= "<tr style='$style'>";
        $html .= "<td>{$r['param_name']}</td><td>{$r['result_value']}</td><td>{$r['unit']}</td><td>{$r['ref_range']}</td>";
        if ($template['show_method']) $html .= "<td>{$r['method']}</td>";
        $html .= "</tr>";
    }

    $html .= '</tbody></table>';
    return $html;
}

function generateQRCode($pdf, $text) {
    $style = ['border' => 0, 'vpadding' => 'auto', 'hpadding' => 'auto'];
    $pdf->write2DBarcode($text, 'QRCODE,H', 170, 10, 25, 25, $style, 'N');
}

$bill = getBill($bill_id);
if (!$bill) die("Bill not found");

$pdf = new TCPDF();
$pdf->AddPage();

// Header
$pdf->SetFont('helvetica', '', 10);
$pdf->MultiCell(0, 5, "Patient: {$bill['full_name']}\nGender: {$bill['gender']}\nDOB: {$bill['date_of_birth']}", 0);
generateQRCode($pdf, "Download Report: report.php?bill_id={$bill_id}");

// Report
$tests = getTestsForBill($bill_id);
while ($test = $tests->fetch_assoc()) {
    $template = getTemplateForTest($test['test_id']) ?? ['header_html' => "<h3>{$test['test_name']}</h3>", 'interpretation' => '', 'notes' => '', 'table_format' => 'default', 'group_by' => 0, 'show_method' => 0, 'show_interpretation' => 0, 'show_notes' => 0];
    $results = getResultsForTest($bill_id, $test['test_id'], $bill['gender']);

    $pdf->Ln(5);
    $pdf->writeHTML($template['header_html']);
    $pdf->Ln(2);
    $pdf->writeHTML(renderResultsTable($results, $template, $bill['gender']));

    if ($template['show_interpretation'] && $template['interpretation']) {
        $pdf->Ln(3);
        $pdf->writeHTML("<b>Interpretation:</b><br>" . $template['interpretation']);
    }
    if ($template['show_notes'] && $template['notes']) {
        $pdf->Ln(2);
        $pdf->writeHTML("<b>Notes:</b><br>" . $template['notes']);
    }

    $pdf->AddPage();
}

$pdf->Output("Report_{$bill_id}.pdf", 'I');
