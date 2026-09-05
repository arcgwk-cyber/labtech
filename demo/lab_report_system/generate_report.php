<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;

$template = file_get_contents('template.html');

// Replace placeholders
$template = str_replace('{{patient_name}}', 'John Doe', $template);
$template = str_replace('{{age}}', '35', $template);
$template = str_replace('{{gender}}', 'Male', $template);
$template = str_replace('{{date}}', date('Y-m-d'), $template);
$template = str_replace('{{doctor_signature}}', 'uploads/signature.png', $template);
$template = str_replace('{{doctor_stamp}}', 'uploads/stamp.png', $template);
$template = str_replace('{{doctor_name}}', 'Dr. A. Kumar', $template);
$template = str_replace('{{doctor_designation}}', 'Pathologist', $template);

// Fake table
$results_table = "
  <div class='group-title'>Liver Enzymes</div>
  <table>
    <tr><th>Parameter</th><th>Value</th><th>Unit</th><th>Reference Range</th><th>Flag</th></tr>
    <tr><td>SGPT</td><td class='highlight'>85</td><td>U/L</td><td>10 - 40</td><td class='highlight'>↑</td></tr>
    <tr><td>SGOT</td><td class='highlight'>70</td><td>U/L</td><td>10 - 40</td><td class='highlight'>↑</td></tr>
  </table>
  <div class='group-title'>Proteins</div>
  <table>
    <tr><td>Albumin</td><td>3.8</td><td>g/dL</td><td>3.4 - 5.4</td><td>✓</td></tr>
  </table>";

$template = str_replace('{{results_table}}', $results_table, $template);

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($template);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("lab_report.pdf");
?>
