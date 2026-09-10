<?php
/**
 * Legacy Report Generation Redirect
 * Routes legacy generate_report.php requests to the production download_pdf gateway
 */
$bill_id = (int)($_GET['bill_id'] ?? $_GET['id'] ?? 0);
if ($bill_id > 0) {
    header("Location: download_pdf.php?bill_id=" . $bill_id);
    exit;
} else {
    header("Location: dashboard.php");
    exit;
}

