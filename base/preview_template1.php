<?php
include "db.php";

$type = $_GET['type'] ?? 'test'; // 'test' or 'package'
$id = $_GET['id'] ?? 0;

$table = $type === 'package' ? 'package_templates' : 'test_templates';
$source_table = $type === 'package' ? 'package_test_map' : 'lab_tests';

$query = $conn->prepare("SELECT * FROM $table WHERE " . ($type === 'package' ? "package_id" : "test_id") . " = ?");
$query->execute([$id]);
$template = $query->fetch(PDO::FETCH_ASSOC);

if (!$template) {
    echo "No template found.";
    exit;
}

echo "<div style='font-family: Arial, sans-serif; padding: 20px;'>";

echo "<h2 style='text-align:center;'>Lab Report</h2>";
echo "<div style='margin-bottom: 20px;'>" . $template['header'] . "</div>";

// Fetch test parameters
$test_ids = [];

if ($type === 'test') {
    $test_ids[] = $id;
} else {
    $stmt = $conn->prepare("SELECT test_id FROM package_test_map WHERE package_id = ?");
    $stmt->execute([$id]);
    $test_ids = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'test_id');
}

$all_params = [];

foreach ($test_ids as $test_id) {
    $param_stmt = $conn->prepare("
        SELECT p.*, g.group_name
        FROM lab_test_parameter_map m
        JOIN lab_test_parameters p ON m.parameter_id = p.id
        LEFT JOIN parameter_groups g ON p.group_id = g.id
        WHERE m.test_id = ?
        ORDER BY g.group_name, p.parameter_name
    ");
    $param_stmt->execute([$test_id]);
    foreach ($param_stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $all_params[] = $row;
    }
}

// Group by group_name
$group_by = $template['group_by'] ?? 0;
$grouped = [];

if ($group_by) {
    foreach ($all_params as $p) {
        $grouped[$p['group_name'] ?: 'Others'][] = $p;
    }
} else {
    $grouped['Parameters'] = $all_params;
}

foreach ($grouped as $group => $params) {
    echo "<h4 style='margin-top: 30px;'>$group</h4>";
    echo "<table border='1' cellpadding='8' cellspacing='0' width='100%' style='border-collapse: collapse; font-size: 14px;'>";
    echo "<tr style='background: #f0f0f0;'><th>Parameter</th><th>Result</th><th>Unit</th><th>Normal Range</th></tr>";

    foreach ($params as $p) {
        $value = $p['default_value'] ?? '-';
        $unit = $p['unit'] ?? '-';
        $range = $p['min_male'] . ' - ' . $p['max_male'];
        echo "<tr>";
        echo "<td>{$p['parameter_name']}</td>";
        echo "<td>$value</td>";
        echo "<td>$unit</td>";
        echo "<td>$range</td>";
        echo "</tr>";

        // Method
        if (!empty($p['method'])) {
            echo "<tr><td colspan='4' style='font-size: 11px; font-style: italic; color: #555;'>Method: {$p['method']}</td></tr>";
        }
    }
    echo "</table>";
}

echo "<div style='margin-top: 30px;'><strong>Interpretation:</strong><br>" . nl2br($template['interpretation']) . "</div>";
echo "<div style='margin-top: 20px;'><strong>Notes:</strong><br>" . nl2br($template['notes']) . "</div>";

echo "</div>";
?>
