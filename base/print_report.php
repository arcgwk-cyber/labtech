<?php
/**
 * Print Report Redirect Handler
 * Safely redirects legacy print requests to the official PDF options / report viewer
 */
$bill_id = (int)($_GET['bill_id'] ?? $_GET['id'] ?? 0);
if ($bill_id > 0) {
    header("Location: pdf_options.php?bill_id=" . $bill_id);
    exit;
} else {
    header("Location: dashboard.php");
    exit;
}