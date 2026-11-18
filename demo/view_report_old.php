<?php
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/db.php';

$bill_id = (int)($_GET['id'] ?? 0);
if ($bill_id <= 0) {
    die("Invalid Bill ID.");
}

// Fetch bill & patient
$bill_stmt = $conn->prepare("SELECT b.*, p.full_name, p.gender, p.date_of_birth, p.phone 
                             FROM bills b 
                             JOIN patients p ON p.patient_id = b.patient_id 
                             WHERE b.bill_id = ?");
$bill_stmt->bind_param("i", $bill_id);
$bill_stmt->execute();
$bill = $bill_stmt->get_result()->fetch_assoc();
$bill_stmt->close();

if (!$bill) {
    die("Bill record not found.");
}

$bill['age'] = date_diff(date_create($bill['date_of_birth']), date_create('today'))->y;

// Fetch tests
$tests_stmt = $conn->prepare("SELECT bt.test_id, lt.test_name 
                              FROM bill_tests bt 
                              JOIN lab_tests lt ON lt.test_id = bt.test_id 
                              WHERE bt.bill_id = ?");
$tests_stmt->bind_param("i", $bill_id);
$tests_stmt->execute();
$tests = $tests_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$tests_stmt->close();

// Fetch test parameters & results
$all_params = [];
$params_stmt = $conn->prepare("
    SELECT tp.param_name, tp.unit, tp.method, tr.result_value 
    FROM lab_test_parameters ltp
    JOIN test_parameters tp ON tp.parameter_id = ltp.parameter_id
    LEFT JOIN test_results tr ON tr.parameter_id = tp.parameter_id AND tr.bill_id = ?
    WHERE ltp.test_id = ?
");

foreach ($tests as $test) {
    $test_id = (int)$test['test_id'];
    $params_stmt->bind_param("ii", $bill_id, $test_id);
    $params_stmt->execute();
    $all_params[$test['test_name']] = $params_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
$params_stmt->close();

include 'report_template.php';
