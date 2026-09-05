<?php
include 'auth_check.php';
include 'db.php';
$id = $_GET['id'];
$conn->query("DELETE FROM lab_tests WHERE id = $id");
$conn->query("DELETE FROM lab_test_parameters WHERE test_id = $id");
header("Location: lab_test_list.php");
