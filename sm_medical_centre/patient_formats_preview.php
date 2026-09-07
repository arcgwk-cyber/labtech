<?php
require_once 'TCPDF/tcpdf.php';

$template_html = $_POST['template_html'] ?? '';

if (!$template_html) die('No template to preview');

// Replace placeholders with sample values
$placeholders = [
    '{{patient_name}}'=>'John Doe',
    '{{patient_age}}'=>'35',
    '{{patient_sex}}'=>'Male',
    '{{patient_phone}}'=>'1234567890',
    '{{patient_email}}'=>'john@example.com',
    '{{reg_no}}'=>'REG12345',
    '{{extra_fields}}'=>'Father: Mr. Smith<br>Passport: A1234567',
    '{{patient_photo}}'=>'<img src="https://via.placeholder.com/120" width="120">',
    '{{qr_code}}'=>'<img src="https://via.placeholder.com/100" width="100">'
];

$html = strtr($template_html, $placeholders);

// --- TCPDF ---
$pdf = new TCPDF('P','mm','A4',true,'UTF-8',false);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetMargins(10,10,10);
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();
$pdf->SetFont('helvetica','',10);
$pdf->writeHTML($html,true,false,true,false,'');
$pdf->Output('preview.pdf','I'); // output inline to browser
