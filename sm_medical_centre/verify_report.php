<?php
require_once("db.php");

$code=$_GET['code']??'';

$stmt=$conn->prepare("
SELECT b.bill_id,p.full_name,b.bill_date
FROM bills b
JOIN patients p ON b.patient_id=p.patient_id
WHERE b.report_hash=?
");

$stmt->bind_param("s",$code);
$stmt->execute();
$res=$stmt->get_result();

if($res->num_rows==0){
echo "<h2>Invalid Report</h2>";
}else{
$row=$res->fetch_assoc();
echo "<h2>Verified Report</h2>";
echo "Patient: ".$row['full_name']."<br>";
echo "Bill: ".$row['bill_id']."<br>";
}
