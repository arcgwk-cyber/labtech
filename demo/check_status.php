function updateAdminStatus($conn) {
    $currentDir = basename(__DIR__);
    $isDemo = ($currentDir === 'demo' || (isset($_GET['demo']) && $_GET['demo'] === '1'));
    $labSlug = $isDemo ? 'demo' : (($currentDir === 'base') ? 'base' : ($conn ? $conn->real_escape_string($currentDir) : $currentDir));

    $res = $conn->query("SELECT * FROM admin_settings WHERE lab_slug = '{$labSlug}' LIMIT 1");
    if (!$res || $res->num_rows === 0) {
        $res = $conn->query("SELECT * FROM admin_settings WHERE id = 1 LIMIT 1");
    }
    $row = $res ? $res->fetch_assoc() : null;

    if (!$row) return;

    $rowId = (int)$row['id'];
    $status = $row['status'];
    $expiry = $row['expiry_date'];
    $grace = (int)($row['grace_days'] ?? 7);
    $today = date('Y-m-d');

    if ($status === 'under_maintenance' || $status === 'deactivated') {
        return; // Manual override — no auto change
    }

    if (!$expiry) {
        $conn->query("UPDATE admin_settings SET status = 'active' WHERE id = {$rowId}");
        return;
    }

    $grace_limit = date('Y-m-d', strtotime($expiry . " +$grace days"));

    if ($today > $grace_limit) {
        $conn->query("UPDATE admin_settings SET status = 'expired' WHERE id = {$rowId}");
    } else {
        $conn->query("UPDATE admin_settings SET status = 'active' WHERE id = {$rowId}");
    }
}
