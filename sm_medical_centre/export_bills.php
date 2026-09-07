<?php
include 'auth_check.php';
require_once 'db.php';

$search        = trim($_GET['search'] ?? '');
$sample_filter = trim($_GET['sample'] ?? '');
$start_date    = trim($_GET['start_date'] ?? '');
$end_date      = trim($_GET['end_date'] ?? '');

$query = "SELECT b.*, p.full_name, p.phone, s.status as sample_status 
          FROM bills b
          JOIN patients p ON b.patient_id = p.patient_id
          LEFT JOIN test_samples s ON b.bill_id = s.bill_id
          WHERE 1=1";

if ($search !== '') {
    $searchEsc = mysqli_real_escape_string($conn, $search);
    $query .= " AND (p.full_name LIKE '%$searchEsc%' OR p.phone LIKE '%$searchEsc%' OR CAST(b.bill_id AS CHAR) LIKE '%$searchEsc%')";
}

if ($sample_filter && $sample_filter != 'all') {
    $query .= " AND s.status = '" . mysqli_real_escape_string($conn, $sample_filter) . "'";
}

if ($start_date && $end_date) {
    $query .= " AND b.bill_date BETWEEN '" . mysqli_real_escape_string($conn, $start_date) . "' AND '" . mysqli_real_escape_string($conn, $end_date) . "'";
}

$query .= " GROUP BY b.bill_id ORDER BY b.bill_id DESC";
$result = mysqli_query($conn, $query);

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=bill_list_" . date('Ymd_His') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

// Column headers
echo "Bill ID\tDate\tPatient Name\tPhone\tTotal Amount\tPaid Amount\tPayment Status\tSample Status\n";

// Data rows
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo $row['bill_id'] . "\t" .
             $row['bill_date'] . "\t" .
             $row['full_name'] . "\t" .
             ($row['phone'] ?? '') . "\t" .
             $row['total_amount'] . "\t" .
             ($row['paid_amount'] ?? 0) . "\t" .
             ucfirst($row['payment_status'] ?? 'Unpaid') . "\t" .
             ucfirst($row['sample_status'] ?? 'Pending') . "\n";
    }
}
exit;
