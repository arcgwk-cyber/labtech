<?php
require_once __DIR__ . '/../db.php';

$bill_id = $_GET['id'] ?? 1;

// Fetch bill and patient info
$bill_sql = "
    SELECT b.*, p.full_name, p.gender, p.date_of_birth, p.phone 
    FROM bills b 
    JOIN patients p ON p.patient_id = b.patient_id 
    WHERE b.bill_id = $bill_id
";
$bill = $conn->query($bill_sql)->fetch_assoc();
$bill['age'] = date_diff(date_create($bill['date_of_birth']), date_create('today'))->y;

// Gender and age for reference logic
$gender = strtolower($bill['gender']);
$is_child = $bill['age'] < 15;

// Grouped test parameters
$grouped_params = [];

// Fetch all tests under the bill
$tests = $conn->query("
    SELECT bt.test_id, lt.test_name, tg.group_name 
    FROM bill_tests bt
    JOIN lab_tests lt ON lt.test_id = bt.test_id 
    LEFT JOIN test_groups tg ON lt.group_id = tg.group_id 
    WHERE bt.bill_id = $bill_id
")->fetch_all(MYSQLI_ASSOC);

// For each test, fetch parameters with results and ref ranges
foreach ($tests as $test) {
    $test_id = $test['test_id'];
    $group_name = $test['group_name'] ?: 'Other';
    $test_name = $test['test_name'];

    $param_sql = "
        SELECT 
            tp.param_name,
            tp.unit,
            tp.method,
            tr.result_value,
            rr.male_min, rr.male_max, rr.female_min, rr.female_max,
            rr.child_min, rr.child_max,
            rr.reference_text, rr.use_reference_text
        FROM lab_test_parameters ltp
        JOIN test_parameters tp ON tp.parameter_id = ltp.parameter_id
        LEFT JOIN test_results tr ON tr.parameter_id = tp.parameter_id AND tr.bill_id = $bill_id
        LEFT JOIN parameter_reference_ranges rr ON rr.parameter_id = tp.parameter_id
        WHERE ltp.test_id = $test_id
    ";

    $params = $conn->query($param_sql)->fetch_all(MYSQLI_ASSOC);

    // Assign reference based on use_reference_text toggle
    foreach ($params as &$row) {
        if (!empty($row['use_reference_text']) && !empty($row['reference_text'])) {
            // Show reference text if flag is on
            $row['ref_range'] = htmlspecialchars($row['reference_text']);
        } else {
            // Fall back to numeric range
            if ($is_child && $row['child_min'] !== null) {
                $row['ref_range'] = "{$row['child_min']} - {$row['child_max']}";
            } elseif ($gender === 'male' && $row['male_min'] !== null) {
                $row['ref_range'] = "{$row['male_min']} - {$row['male_max']}";
            } elseif ($gender === 'female' && $row['female_min'] !== null) {
                $row['ref_range'] = "{$row['female_min']} - {$row['female_max']}";
            } else {
                $row['ref_range'] = "-";
            }
        }
    }

    // Group by test group name
    $grouped_params[$group_name][$test_name] = $params;
}

// Load the report template to render the data
include 'report_template.php';
