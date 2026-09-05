<?php
require 'vendor/autoload.php'; // for mPDF
require 'db.php';

$bill_id = $_GET['bill_id'] ?? 1;

// Step 1: Fetch test result data
$query = $conn->prepare("SELECT * FROM test_result WHERE bill_id = ?");
$query->bind_param("i", $bill_id);
$query->execute();
$result = $query->get_result();

$test_data = [];
$row = $result->fetch_assoc();

if (!$row) {
    die("No data found for Bill ID: $bill_id");
}

// Store patient info and test values
$data = [
    'lab_name' => 'Sunrise Diagnostics',
    'patient_name' => $row['patient_name'],
    'age' => $row['age'],
    'gender' => $row['gender'],
    'report_date' => $row['report_date'],
    'interpretation' => $row['interpretation'] ?? '',
    'notes' => $row['notes'] ?? ''
];

mysqli_data_seek($result, 0); // reset pointer
$test_table_rows = '';
while ($row = $result->fetch_assoc()) {
    $param = $row['parameter'];
    $data_key = strtolower(str_replace([' ', '(', ')'], '_', $param));
    $data[$data_key] = $row['value'];

    $range = $row['min_value'] . '–' . $row['max_value'];
    $test_table_rows .= "<tr>
        <td>{$row['parameter']}</td>
        <td>{$row['value']}</td>
        <td>{$row['unit']}</td>
        <td>$range</td>
    </tr>";
}

// Step 2: Fetch template
$test_id = $_GET['test_id'] ?? 1;
$tpl_stmt = $conn->prepare("SELECT header, interpretation, notes FROM test_templates WHERE test_id = ?");
$tpl_stmt->bind_param("i", $test_id);
$tpl_stmt->execute();
$tpl_result = $tpl_stmt->get_result();
$template = $tpl_result->fetch_assoc();

$html = $template['header'] ?? '';
$html .= "
    <p>Patient Name: {{patient_name}}<br>
    Age: {{age}} Gender: {{gender}}<br>
    Report Date: {{report_date}}</p>

    <table border='1' cellspacing='0' cellpadding='6' width='100%'>
        <thead><tr><th>Parameter</th><th>Result</th><th>Unit</th><th>Reference Range</th></tr></thead>
        <tbody>$test_table_rows</tbody>
    </table>

    <p><strong>Interpretation:</strong> {{interpretation}}</p>
    <p><strong>Notes:</strong> {{notes}}</p>
    <p><em>Method: UV Method</em></p>
";

// Step 3: Replace placeholders
foreach ($data as $key => $value) {
    $html = str_replace('{{' . $key . '}}', $value, $html);
}

// Step 4: Generate PDF with QR code
$mpdf = new \Mpdf\Mpdf();
$download_url = "https://yourdomain.com/reports/report_$bill_id.pdf";
$qr_code = '<img src="https://api.qrserver.com/v1/create-qr-code/?data=' . urlencode($download_url) . '&size=100x100" width="100">';

$html .= "<br><hr><p><strong>Scan to Download:</strong><br>$qr_code</p>";

$mpdf->WriteHTML($html);
$pdfPath = __DIR__ . "/reports/report_$bill_id.pdf";
$mpdf->Output($pdfPath, \Mpdf\Output\Destination::FILE);

// Step 5: Download file or redirect
header('Content-Type: application/pdf');
header("Content-Disposition: inline; filename=report_$bill_id.pdf");
readfile($pdfPath);
exit;
?>
