<?php
require_once __DIR__ . '/vendor/autoload.php'; // mpdf
include 'db.php';

$bill_id = $_GET['bill_id'];
$mpdf = new \Mpdf\Mpdf();

$html = "<h1>Lab Report - Bill #$bill_id</h1><hr>";
// Fetch patient, tests, and results...

$html .= "<p>Generated report preview</p>";
$mpdf->WriteHTML($html);
$mpdf->Output("report_bill_$bill_id.pdf", "I");
?>