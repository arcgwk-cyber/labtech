<?php
require_once '../tcpdf/tcpdf.php';
include '../db.php';

if (!isset($_GET['id'])) {
    die("Bill ID missing");
}

$bill_id = (int)$_GET['id'];

// Fetch bill, patient, and test data (reuse your existing query logic)
$bill_sql = "
    SELECT b.*, p.full_name, p.gender, p.date_of_birth, p.phone 
    FROM bills b 
    JOIN patients p ON p.patient_id = b.patient_id 
    WHERE b.bill_id = $bill_id
";
$bill = $conn->query($bill_sql)->fetch_assoc();

// Same logic to get grouped_params as you did before (extract or reuse function)

// --- Initialize TCPDF ---
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Lab Name');
$pdf->SetTitle('Lab Report - ' . $bill['full_name']);
$pdf->SetMargins(15, 20, 15);
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->AddPage();

// Create your report HTML here (simplified example, reuse your report_template.php content but no buttons)
$html = '<h1>Lab Report</h1>';
$html .= '<p><strong>Patient Name:</strong> ' . htmlspecialchars($bill['full_name']) . '</p>';
$html .= '<p><strong>Age:</strong> ' . /* calculate age here */ '</p>';
// add your tests and parameters table here...

// For brevity, include your report HTML generation code here or call a function

$pdf->writeHTML($html, true, false, true, false, '');

// Auto download with a meaningful file name
$pdf->Output('Lab_Report_' . $bill_id . '.pdf', 'D');
