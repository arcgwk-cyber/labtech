<?php
// Only allow CLI execution or cron with secure secret
$isCli = (php_sapi_name() === 'cli');
$cronKey = $_GET['cron_key'] ?? $_SERVER['HTTP_X_CRON_KEY'] ?? '';
$validKey = getenv('CRON_SECRET_KEY') ?: 'VenSaas_Cron_Key_2026';

if (!$isCli && !hash_equals($validKey, $cronKey)) {
    http_response_code(403);
    die("Access Denied: Cron or CLI authorization required.");
}

require 'db.php';

// Deactivate vendors whose due date is before today
$updated = $pdo->exec("UPDATE vendor_master SET status = 'inactive' WHERE due_date < CURDATE() AND status = 'active'");

echo date("Y-m-d H:i:s") . " - Deactivated $updated expired vendors.\n";
?>