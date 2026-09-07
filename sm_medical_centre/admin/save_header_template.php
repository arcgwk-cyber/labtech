<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$json = json_encode($data['layout']);

$name = "Enterprise Header";

$stmt = $conn->prepare("INSERT INTO report_headers (template_name, layout_json) VALUES (?,?)");
$stmt->bind_param("ss", $name, $json);
$stmt->execute();

echo "OK";
