<?php
include 'db.php';

$username = 'admin';
$password = 'admin123';
$role = 'admin';
$status = 'active';

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (username, password_hash, role, status) VALUES (?, ?, ?, ?)");

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ssss", $username, $hash, $role, $status);

if ($stmt->execute()) {
    echo "Test user inserted successfully.";
} else {
    echo "Execution failed: " . $stmt->error;
}
?>
