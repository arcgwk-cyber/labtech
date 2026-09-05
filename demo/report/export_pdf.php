<?php
// Include the database connection
include '../db.php'; // Adjust the path to where your db.php is located

// Include Composer autoload file for DomPDF
require_once __DIR__ . '/../dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Include necessary files to retrieve data (for example, bill data and test results)
include '../auth_check.php'; // If necessary
$bill_id = $_GET['id']; // Assuming you pass the bill_id via URL

// Example for getting the report data, adjust based on your database
$patient_stmt = $conn->prepare("
    SELECT p.full_name, p.gender, p.date_of_birth, b.bill_date
    FROM bills b
    JOIN patients p ON b.patient_id = p.patient_id
    WHERE b.bill_id = ?
");
$patient_stmt->bind_param("i", $bill_id);
$patient_stmt->execute();
$patient_result = $patient_stmt->get_result();
$patient = $patient_result->fetch_assoc();
$patient_stmt->close();

// Getting test data (adjust according to your actual structure)
$grouped_params = []; // Sample data structure for tests (replace with real data)

ob_start(); // Start output buffering to capture the HTML content

include 'view_report.php';  // Include the report template (HTML layout)
$html = ob_get_clean(); // Capture the content into a variable

// Initialize DomPDF and set options
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$dompdf = new Dompdf($options);

// Load the HTML content
$dompdf->loadHtml($html);

// Set paper size (A4)
$dompdf->setPaper('A4', 'portrait');

// Render the PDF (this is the step that converts the HTML to PDF)
$dompdf->render();

// Output the PDF
$dompdf->stream("report_$bill_id.pdf", array("Attachment" => true));  // Automatically download the PDF
exit; // Stop further script execution after the download
?>
