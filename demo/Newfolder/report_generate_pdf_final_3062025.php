<?php
if (ob_get_length()) ob_clean();
require_once(__DIR__.'/TCPDF/tcpdf.php');
require_once('db.php');

$bill_id = $_GET['bill_id'] ?? 0;
if (!$bill_id) die('Bill ID is required.');

$include_method = isset($_GET['include_method']);
$include_notes = isset($_GET['include_notes']);
$include_interpretation = isset($_GET['include_interpretation']);
$pagebreak_per_test = isset($_GET['pagebreak_per_test']);

// Fetch bill and patient data
$bill_sql = "SELECT b.*, p.full_name, p.gender, p.date_of_birth FROM bills b 
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

function generatePatientHTML($bill, $age, $gender, $report_date) {
    return <<<EOD
<table width="100%" cellpadding="2" cellspacing="0" style="font-family: Helvetica, Arial, sans-serif;" >
    <tr>
        <td width="12%"><strong>Name</strong></td>
        <td width="2%" align="center">:</td>
        <td width="42%">{$bill['full_name']}</td>
        <td width="19%" style="text-align:left;"><strong>Bill No.</strong></td>
        <td width="2%" align="center" style="text-align:right;">:</td>
        <td width="20%" style="text-align:left;">{$bill['bill_id']}</td>
    </tr>
    <tr>
        <td width="12%"><strong>Age/Gender</strong></td>
        <td width="2%" align="center">:</td>
        <td width="42%">{$age} / {$gender}</td>
        <td width="19%" style="text-align:left;"><strong>Registered Date</strong></td>
        <td width="2%" align="center" style="text-align:right;">:</td>
        <td width="20%" style="text-align:left;">{$bill['bill_date']}</td>
    </tr>
    <tr>
        <td width="12%"><strong>Referred By</strong></td>
        <td width="2%" align="center">:</td>
        <td width="42%">Dr.</td>
        <td width="19%" style="text-align:left;"><strong>Reported Date</strong></td>
        <td width="2%" align="center" style="text-align:left;">:</td>
        <td width="20%" style="text-align:left;">{$report_date}</td>
    </tr>
</table>
<br>
<div style="border-top:1px solid #000; margin:5px 0;"></div>
<br>
EOD;
}
function getGroupHeader($groupName) {
    $groupName = strtoupper($groupName); 
    return <<<EOD
<table border="1" width="100%" cellpadding="4" cellspacing="0" style="font-family: 'Times New Roman', Times, serif; font-size: 11px;">


    <tr style="background-color:#d9d9d9; font-weight:bold;">
        <td colspan="4" align="center">{$groupName}</td>
    </tr>
</table>
<br>
EOD;
}


function getTestHeader() {
   return <<<EOD
<table width="100%" cellpadding="4" cellspacing="0" style="
    font-family: 'Times New Roman', Times, serif;
    font-size: 11px;
    border-bottom: 2px solid black;
    border-collapse: collapse;
    border-top: none;
    border-left: none;
    border-right: none;
">
    <tr style="background-color:#f2f2f2; font-weight:bold;">
        <td style="border: none;">TEST DESCRIPTION</td>
        <td style="border: none;">RESULT</td>
        <td style="border: none;">UNIT</td>
        <td style="border: none;">REFERENCE RANGE</td>
    </tr>
</table>
<br>
EOD;
}

function appendTestNotesAndSignature($test_id, $qr_link, $pdf, $include_notes, $include_interpretation) {
    global $conn;

    // Step 1: Fetch notes & interpretation
    $sql = "SELECT notes, interpretations FROM lab_tests WHERE test_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $test_id);
    $stmt->execute();
    $stmt->bind_result($notes, $interpretation);
    $stmt->fetch();
    $stmt->close();

    // Step 2: Clean HTML for interpretation
    $interpretation = preg_replace('/<figure[^>]*>/', '', $interpretation);
    $interpretation = str_replace('</figure>', '', $interpretation);
    $interpretation = str_replace('<table', '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse:collapse;"', $interpretation);
    $interpretation = str_replace('<td', '<td style="border:1px solid #000;"', $interpretation);
    $interpretation = str_replace('<th', '<th style="border:1px solid #000;"', $interpretation);

    // Step 3: Write notes/interpretation
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

    // Step 4: Save current page
    $currentPage = $pdf->getPage();

    // Step 5: Save Y and jump to bottom
    $pdf->setPage($currentPage);
    $pdf->Ln(30 * $pdf->getFontSize());
    $bottomY = $pdf->getPageHeight() - 50;
    if ($pdf->GetY() > $bottomY - 0) {
        // Not enough space, add new page
        $pdf->AddPage();
        $bottomY = $pdf->getPageHeight() - 50;
    }

    // Step 6: QR & Signature at bottom
    $pdf->SetY($bottomY);
    $y = $pdf->GetY();

    $pdf->write2DBarcode($qr_link, 'QRCODE,L', 90, $y, 20, 20);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->SetXY(120, $y + 5);
    $pdf->Cell(60, 5, "Authorized Signatory", 0, 1, 'R');
    $pdf->SetXY(120, $y + 11);
    $pdf->Cell(60, 5, "Dr. Signature & Stamp", 0, 1, 'R');
}


function calculateRefRange1($row, $gender, $age_years) {
    $ref_range = '';
    $min = $max = null;

    if (!empty($row['use_reference_text']) && !empty($row['reference_text'])) {
        $ref_range = $row['reference_text'];
    } else {
        if ($age_years <= 12 && is_numeric($row['child_min']) && is_numeric($row['child_max'])) {
            $min = $row['child_min'];
            $max = $row['child_max'];
            $ref_range = "{$min} - {$max}";
        } elseif (strtolower($gender) == 'female' && is_numeric($row['female_min']) && is_numeric($row['female_max'])) {
            $min = $row['female_min'];
            $max = $row['female_max'];
            $ref_range = "{$min} - {$max}";
        } elseif (is_numeric($row['male_min']) && is_numeric($row['male_max'])) {
            $min = $row['male_min'];
            $max = $row['male_max'];
            $ref_range = "{$min} - {$max}";
        }
    }

    return [$ref_range, $min, $max];
}

function calculateRefRange($row, $gender, $age_years) {
    $ref_range = '';
    $min = $max = null;

    // Determine min/max regardless of use_reference_text
    if ($age_years <= 12 && is_numeric($row['child_min']) && is_numeric($row['child_max'])) {
        $min = $row['child_min'];
        $max = $row['child_max'];
    } elseif (strtolower($gender) == 'female' && is_numeric($row['female_min']) && is_numeric($row['female_max'])) {
        $min = $row['female_min'];
        $max = $row['female_max'];
    } elseif (is_numeric($row['male_min']) && is_numeric($row['male_max'])) {
        $min = $row['male_min'];
        $max = $row['male_max'];
    }

    // Assign display reference range
    if (!empty($row['use_reference_text']) && !empty($row['reference_text'])) {
        $ref_range = $row['reference_text'];
    } elseif (isset($min) && isset($max)) {
        $ref_range = "{$min} - {$max}";
    }

    return [$ref_range, $min, $max];
}

function getResultDisplay($row, $min, $max, $gender, $bill) {
    $highlight = false;
    $value = $row['result_value'];
    $keywords = ['abnormal', 'positive', 'reactive'];

    // Check keyword-based highlighting
    foreach ($keywords as $word) {
        if (stripos($value, $word) !== false) {
            $highlight = true;
            break;
        }
    }

    // Check numeric out-of-range
    if (!$highlight && is_numeric($value) && isset($min) && isset($max)) {
        $val = floatval($value);
        if ($val < $min || $val > $max) {
            $highlight = true;
        }
    }

    return $highlight
        ? '<span style="color:red; font-weight:bold;">' . htmlspecialchars($value) . '</span>'
        : htmlspecialchars($value);
}

function getResultDisplay1($row, $min, $max, $gender, $bill) {
    $highlight = false;
    $keywords = ['abnormal', 'positive', 'reactive'];
    foreach ($keywords as $word) {
        if (stripos($row['result_value'], $word) !== false) {
            $highlight = true;
            break;
        }
    }

    if (!$highlight && is_numeric($row['result_value']) && isset($min) && isset($max)) {
        $val = floatval($row['result_value']);
        if ($val < $min || $val > $max) {
            $highlight = true;
        }
    }

    return $highlight ? "<strong>{$row['result_value']}</strong>" : $row['result_value'];
}

$age = calculateAge($bill['date_of_birth']);
$gender = ucfirst($bill['gender']);
$report_date = date("d-M-Y h:i A");
$qr_link = "http://labs.kesug.com/demo/download_pdf.php?bill_id={$bill_id}";

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetMargins(10, 10, 10, true);
$pdf->SetFont('helvetica', '', 10);

$sql = "SELECT g.group_name, t.test_id, t.test_name, ltp.param_order,
       tp.param_name, tp.unit, r.result_value, tp.method,
       rr.male_min, rr.male_max, rr.female_min, rr.female_max,
       rr.child_min, rr.child_max, rr.reference_text, rr.use_reference_text
FROM test_results r
JOIN test_parameters tp ON r.parameter_id = tp.parameter_id
JOIN lab_test_parameters ltp ON tp.parameter_id = ltp.parameter_id AND r.test_id = ltp.test_id
JOIN lab_tests t ON ltp.test_id = t.test_id
LEFT JOIN test_groups g ON t.group_id = g.group_id
LEFT JOIN parameter_reference_ranges rr ON tp.parameter_id = rr.parameter_id
WHERE r.bill_id = ?
AND r.result_id = (
    SELECT MAX(r2.result_id) FROM test_results r2
    WHERE r2.bill_id = r.bill_id AND r2.test_id = r.test_id AND r2.parameter_id = r.parameter_id
)
ORDER BY g.group_name, t.test_name, ltp.param_order;";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $bill_id);
$stmt->execute();
$results = $stmt->get_result();

$current_group = '';
$current_test = '';
$printed_combos = [];
$html = '';
$last_test_id = 0;
$age_years = (int)date_diff(date_create($bill['date_of_birth']), date_create())->format('%y');

$printed_combos = [];

if ($pagebreak_per_test) {
    while ($row = $results->fetch_assoc()) {
        $combo_key = $row['group_name'] . '|' . $row['test_name'];

        // When encountering a new test
        if (!in_array($combo_key, $printed_combos)) {
            // If HTML exists, write it to PDF and add notes/signature
            if (!empty($html)) {
                $html .= "</table><br>";
                $pdf->writeHTML($html, true, false, true, false, '');
                appendTestNotesAndSignature($last_test_id, $qr_link, $pdf, $include_notes, $include_interpretation, $conn);
            }

            // Start a new page and initialize new test block
            $pdf->AddPage();
            $html = generatePatientHTML($bill, $age, $gender, $report_date);
            $group_name = $row['group_name'] ?: 'General Tests';
            $html .= getGroupHeader($group_name);
            $html .= getTestHeader();
            $html .= "<br><tr><td colspan='4' style='border:1px solid #000;'><strong>" . htmlspecialchars($row['test_name']) . "</strong></td></tr>";

            $printed_combos[] = $combo_key;
            $last_test_id = $row['test_id'];
        }

        list($ref_range, $min, $max) = calculateRefRange($row, $gender, $age_years);
        $result_display = getResultDisplay($row, $min, $max, $gender, $bill);
        $method = ($include_method && $row['method']) ? "<br><small>Method: " . htmlspecialchars($row['method']) . "</small>" : '';

        $html .= <<<EOD
<tr>
    <td style="padding: 6px 4px; line-height: 1.6; font-family: 'Times New Roman', Times, serif; font-size: 11px; ">{$row['param_name']}{$method}</td>
    <td style="padding: 6px 4px; line-height: 1.6; font-family: 'Times New Roman', Times, serif; font-size: 11px; ">{$result_display}</td>
    <td style="padding: 6px 4px; line-height: 1.6; font-family: 'Times New Roman', Times, serif; font-size: 11px; ">{$row['unit']}</td>
    <td style="padding: 6px 4px; line-height: 1.6; font-family: 'Times New Roman', Times, serif; font-size: 11px; ">{$ref_range}</td>
</tr>
EOD;
    }

    // Final flush
    if (!empty($html)) {
        $html .= "</table><br>";
        $pdf->writeHTML($html, true, false, true, false, '');
        appendTestNotesAndSignature($last_test_id, $qr_link, $pdf, $include_notes, $include_interpretation, $conn);
    }

} else {
    // No page break — all results in one page
    $pdf->AddPage();
    $html = generatePatientHTML($bill, $age, $gender, $report_date);
    $grouped_results = [];

    while ($row = $results->fetch_assoc()) {
        $group_name = $row['group_name'] ?: 'General Tests';
        $grouped_results[$group_name][$row['test_id'] . '|' . $row['test_name']][] = $row;
        $last_test_id = $row['test_id'];
    }

    foreach ($grouped_results as $group => $tests) {
        $html .= getGroupHeader($group);
        $html .= getTestHeader();

        foreach ($tests as $test_key => $params) {
            [, $test_name] = explode('|', $test_key);
            $html .= '<br>';
            $html .= '<tr><td colspan="4" style="border:1px solid #ccc; font-family: \'Times New Roman\', Times, serif; font-size: 11px; padding: 6px 4px;"><strong>' . htmlspecialchars($test_name) . '</strong></td></tr>';

            foreach ($params as $row) {
                list($ref_range, $min, $max) = calculateRefRange($row, $gender, $age_years);
                $result_display = getResultDisplay($row, $min, $max, $gender, $bill);
                $method = ($include_method && $row['method']) ? "<br><small>Method: " . htmlspecialchars($row['method']) . "</small>" : '';

                $html .= <<<EOD
<tr>
    <td style="padding: 6px 4px; line-height: 1.6; font-family: 'Times New Roman', Times, serif; font-size: 11px; ">{$row['param_name']}{$method}</td>
    <td style="padding: 6px 4px; line-height: 1.6; font-family: 'Times New Roman', Times, serif; font-size: 11px; ">{$result_display}</td>
    <td style="padding: 6px 4px; line-height: 1.6; font-family: 'Times New Roman', Times, serif; font-size: 11px; ">{$row['unit']}</td>
    <td style="padding: 6px 4px; line-height: 1.6; font-family: 'Times New Roman', Times, serif; font-size: 9px; ">{$ref_range}</td>
</tr>
EOD;
            }
        }

        $html .= "</table><br>";
    }

    $pdf->writeHTML($html, true, false, true, false, '');
    appendTestNotesAndSignature($last_test_id, $qr_link, $pdf, $include_notes, $include_interpretation, $conn);
}

$pdf->Output("Report_{$bill_id}.pdf", 'I');

?>
