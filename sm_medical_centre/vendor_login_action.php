<?php
session_start();
require 'db.php';

$vendor_userid = $_POST['vendor_userid'];
$password = $_POST['password'];

$stmt = $pdo->prepare("SELECT * FROM vendor_master WHERE vendor_userid = ?");
$stmt->execute([$vendor_userid]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    if ($user['status'] === 'active') {
        $_SESSION['vendor_id'] = $user['vendor_id'];
        $_SESSION['vendor_userid'] = $user['vendor_userid'];
        header("Location: vendor_dashboard.php");
    } else {
        echo "<div class='alert alert-warning'>Account not active or expired.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>Invalid login credentials.</div>";
}
?>
