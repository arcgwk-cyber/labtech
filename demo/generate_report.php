<?php
require_once __DIR__ . '/vendor/autoload.php';
include 'db.php'; // Make sure this includes your DB connection

$bill_id = $_GET['bill_id'] ?? 0;

// Fetch report template based on test or package
$template = "";
$stmt = $conn->prepare("SELECT header, interpretation, notes, table_format, group_by FROM test_templates WHERE test_id = ? LIMIT 1");
$stmt->bind_param("i", $bill_id); // You may use another identifier here
$stmt->execute();
$stmt->bind_result($header, $interpretation, $notes, $table_format, $group_by);
$stmt->fetch();
$stmt->close();

// Fetch test results dynamically
$data = [];
$sql = "SELECT t.test_name, p.parameter_name, r.result_value, p.unit, p.ref_range_male, p.method 
        FROM test_result r 
        JOIN lab_test_parameters p ON r.parameter_id = p.id 
        JOIN lab_tests t ON r.test_id = t.id
        WHERE r.bill_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $bill_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
$stmt->close();

// Start building PDF HTML
$html = '<style>
    body { font-family: sans-serif; font-size: 12pt; }
    h1, h2, h3 { margin: 0; padding: 5px 0; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    .method { font-size: 8pt; font-style: italic; color: #555; }
</style>';

$html .= "<div>$header</div>";
$html .= "<h3>Test Report</h3><table><tr><th>Parameter</th><th>Result</th><th>Unit</th><th>Normal Range</th></tr>";

foreach ($data as $row) {
    $html .= "<tr>
        <td>{$row['parameter_name']}</td>
        <td>{$row['result_value']}</td>
        <td>{$row['unit']}</td>
        <td>{$row['ref_range_male']}</td>
    </tr>";
    if (!empty($row['method'])) {
        $html .= "<tr><td colspan='4' class='method'>Method: {$row['method']}</td></tr>";
    }
}

$html .= "</table>";
if (!empty($interpretation)) $html .= "<p><strong>Interpretation:</strong><br>$interpretation</p>";
if (!empty($notes)) $html .= "<p><strong>Notes:</strong><br>$notes</p>";

// Add QR code to download the PDF later
$pdfUrl = "https://yourdomain.com/report_view.php?bill_id=$bill_id"; // Your actual download/view link
$qrImg = "https://api.qrserver.com/v1/create-qr-code/?data=" . urlencode($pdfUrl) . "&size=100x100";
$html .= "<p><strong>Scan to Download:</strong><br><img src='$qrImg' alt='QR Code'></p>";

// Generate PDF
$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output("report_$bill_id.pdf", "I"); // I = inline view, D = download
?>
