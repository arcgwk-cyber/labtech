<?php
include 'db.php';

function getClientId($conn) {
    $sql = "SELECT id FROM admin_settings LIMIT 1"; // Assuming 'id' is the client_id
    $result = $conn->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        return $row['id'];
    }
    return null;
}
?>