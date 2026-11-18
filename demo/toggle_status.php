<?php
// toggle_status.php
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/csrf.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrfToken();
    $bill_id = intval($_POST['bill_id'] ?? 0);
    $field = $_POST['field'] ?? '';

    // Only allow valid fields
    $allowed_fields = ['sample_collected', 'result_entered'];
    if (!in_array($field, $allowed_fields)) {
        die("Invalid field");
    }

    // Fetch current value
    $stmt = $conn->prepare("SELECT $field FROM bills WHERE bill_id = ?");
    $stmt->bind_param("i", $bill_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $new_value = $row[$field] ? 0 : 1;

        $update = $conn->prepare("UPDATE bills SET $field = ? WHERE bill_id = ?");
        $update->bind_param("ii", $new_value, $bill_id);
        $update->execute();
    }
}

// Safe Redirect back (Prevent Open Redirect)
$ref = 'bill_list.php';
if (!empty($_SERVER['HTTP_REFERER'])) {
    $parts = parse_url($_SERVER['HTTP_REFERER']);
    $refHost = $parts['host'] ?? '';
    $currentHost = $_SERVER['HTTP_HOST'] ?? '';
    if (empty($refHost) || strcasecmp($refHost, $currentHost) === 0) {
        $ref = $_SERVER['HTTP_REFERER'];
    }
}
header("Location: " . $ref);
exit;
