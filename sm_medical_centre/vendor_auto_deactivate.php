<?php
require 'db.php';

// Deactivate vendors whose due date is before today
$updated = $pdo->exec("UPDATE vendor_master SET status = 'inactive' WHERE due_date < CURDATE() AND status = 'active'");

echo date("Y-m-d H:i:s") . " - Deactivated $updated expired vendors.\n";
?>