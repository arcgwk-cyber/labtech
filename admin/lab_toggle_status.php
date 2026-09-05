<?php
/**
 * 1-Click Activate / Deactivate Lab Access
 */
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/db.php';

$vendor_id = (int)($_GET['id'] ?? 0);
$csrf      = $_GET['csrf'] ?? '';

if ($vendor_id > 0 && $csrf === md5($vendor_id . 'sa_salt')) {
    if ($conn && !$conn->connect_error) {
        $stmt = $conn->prepare("SELECT status, name FROM vendor_master WHERE vendor_id = ?");
        $stmt->bind_param("i", $vendor_id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($row) {
            $new_status = ($row['status'] === 'active') ? 'inactive' : 'active';
            $up_stmt = $conn->prepare("UPDATE vendor_master SET status = ? WHERE vendor_id = ?");
            $up_stmt->bind_param("si", $new_status, $vendor_id);
            $up_stmt->execute();
            $up_stmt->close();
        }
    }
}

$ref = $_SERVER['HTTP_REFERER'] ?? 'labs_manage.php';
header("Location: " . $ref);
exit;
