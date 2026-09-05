function updateAdminStatus($conn) {
    $row = $conn->query("SELECT * FROM admin_settings WHERE id = 1")->fetch_assoc();

    if (!$row) return;

    $status = $row['status'];
    $expiry = $row['expiry_date'];
    $grace = (int)$row['grace_days'];
    $today = date('Y-m-d');

    if ($status === 'under_maintenance' || $status === 'deactivated') {
        return; // Manual override — no auto change
    }

    if (!$expiry) {
        $conn->query("UPDATE admin_settings SET status = 'active' WHERE id = 1");
        return;
    }

    $grace_limit = date('Y-m-d', strtotime($expiry . " +$grace days"));

    if ($today > $grace_limit) {
        $conn->query("UPDATE admin_settings SET status = 'expired' WHERE id = 1");
    } else {
        $conn->query("UPDATE admin_settings SET status = 'active' WHERE id = 1");
    }
}
