<?php
include 'auth_check.php';
include 'db.php';

$bill_id = (int)$_GET['bill_id'];
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("INSERT INTO samples (bill_id, collected_by, collection_time, status) VALUES (?, ?, NOW(), 'Collected')");
$stmt->bind_param("ii", $bill_id, $user_id);
$stmt->execute();

header("Location: sample_collection.php");
?>