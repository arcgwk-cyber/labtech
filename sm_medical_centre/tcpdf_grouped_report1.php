<?php
require_once('tcpdf/tcpdf.php');
require_once('db.php');

$bill_id = $_GET['bill_id'] ?? 0;

// Get patient and bill info
$query = "SELECT p.name, p.age, p.gender, b.bill_id, b.bill_date
          FROM patients p
          JOIN bills b ON p.patient_id = b.patient_id
          WHERE b.bill_id = $bill_id";
$result = mysqli_query($conn, $query);
$patient = mysqli_fetch_assoc($result);

// QR download link
$qr_link = "https://yourdomain.com/report_download.php?bill_id=" . $bill_id;

// Get grouped test results
$test_query = "SELECT g.group_name, tp.param_name, tr.result_value, tp.unit, tp.ref_range, tp.method
               FROM test_results tr
               JOIN test_parameters tp ON tr.parameter_id = tp.parameter_id
               LEFT JOIN parameter_groups g ON tp.group_id = g.group_id
               WHERE tr.bill_id = $bill_id
               ORDER BY g.group_name, tp.param_name";

$test_result = mysqli_query($conn, $test_query);

// Group data
$grouped_data = [];
while ($row = mysqli_fetch_assoc($test_result)) {
    $group = $row['group_name'] ?? 'Other';
    $grouped_data[$group][] = $row;
}

// Create PDF
$pdf = new TCPDF();
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

// Header HTML
$html = <<<EOD
<div style="text-align:center;">
    <img src="https://yourdomain.com/logo.png" height="50" /><br/>
    <h2>ABC Diagnostic Laboratory</h2>
    <small>123 Health Street, City | Phone: +91-1234567890</small><br/><br/>
</div>

<table cellpadding="4" border="1" width="100%">
    <tr>
        <td><b>Patient Name:</b> {$patient['name']}</td>
        <td><b>Age/Gender:</b> {$patient['age']} / {$patient['gender']}</td>
    </tr>
    <tr>
        <td><b>Bill No:</b> {$patient['bill_id']}</td>
        <td><b>Date:</b> {$patient['bill_date']}</td>
    </tr>
</table><br/>
EOD;

// Loop through grouped test results
foreach ($grouped_data as $group => $tests) {
    $html .= "<h3 style='background:#eee;padding:6px;'>{$group}</h3>";
    $html .= <<<EOD
    <table border="1" cellpadding="4" width="100%" style="border-collapse:collapse;">
        <tr style="background-color:#f0f0f0;">
            <th>Test Name</th>
            <th>Result</th>
            <th>Unit</th>
            <th>Reference Range</th>
            <th>Method</th>
        </tr>
    EOD;

    foreach ($tests as $test) {
        $html .= "<tr>
            <td>{$test['param_name']}</td>
            <td>{$test['result_value']}</td>
            <td>{$test['unit']}</td>
            <td>{$test['ref_range']}</td>
            <td>{$test['method']}</td>
        </tr>";
    }
    $html .= "</table><br/>";
}

// Add Notes, QR link, doctor section
$html .= <<<EOD
<p><b>Note:</b> This report is computer-generated and does not require signature.</p>
<p><b>Download Link:</b> <a href="$qr_link">$qr_link</a></p>

<br/><br/>
<div style="text-align:right;">
    <p>Authorized Signatory</p>
    <img src="https://yourdomain.com/signature.png" height="40"/><br/>
    <b>Dr. A. Sharma</b><br/>
    MBBS, MD (Pathology)
</div>

<hr/>
<p style="text-align:center;font-size:8pt;">
    This report is for informational purposes only and should be correlated clinically. Consult your doctor for interpretation.
</p>
EOD;

// Output PDF
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('Lab_Report_' . $bill_id . '.pdf', 'I');
