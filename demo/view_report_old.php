<?php
//$conn = new mysqli("localhost", "root", "", "diagnostic_lab_db");
require_once __DIR__ . '/./db.php';

$bill_id = $_GET['id'] ?? 9;

// Fetch bill & patient
$bill_sql = "SELECT b.*, p.full_name, p.gender, p.date_of_birth, p.phone 
             FROM bills b 
             JOIN patients p ON p.patient_id = b.patient_id 
             WHERE b.bill_id = $bill_id";
$bill = $conn->query($bill_sql)->fetch_assoc();
$bill['age'] = date_diff(date_create($bill['date_of_birth']), date_create('today'))->y;

// Fetch tests
$tests = $conn->query("SELECT bt.test_id, lt.test_name 
                       FROM bill_tests bt 
                       JOIN lab_tests lt ON lt.test_id = bt.test_id 
                       WHERE bt.bill_id = $bill_id")->fetch_all(MYSQLI_ASSOC);

// Fetch test parameters & results
$all_params = [];
foreach ($tests as $test) {
    $test_id = $test['test_id'];
    $params_sql = "
        SELECT tp.param_name, tp.unit, tp.method, tr.result_value 
        FROM lab_test_parameters ltp
        JOIN test_parameters tp ON tp.parameter_id = ltp.parameter_id
        LEFT JOIN test_results tr ON tr.parameter_id = tp.parameter_id AND tr.bill_id = $bill_id
        WHERE ltp.test_id = $test_id
    ";
    $all_params[$test['test_name']] = $conn->query($params_sql)->fetch_all(MYSQLI_ASSOC);
}

include 'report_template.php';
