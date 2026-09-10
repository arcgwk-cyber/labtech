<?php
/**
 * Legacy Export PDF Handler
 * Routes legacy export_pdf.php requests directly to download_pdf.php
 */
$bill_id = (int)($_GET['id'] ?? $_GET['bill_id'] ?? 0);
if ($bill_id > 0) {
    header("Location: download_pdf.php?id=" . $bill_id);
    exit;
} else {
    header("Location: dashboard.php");
    exit;
}

