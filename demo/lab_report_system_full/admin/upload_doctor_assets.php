
<?php
require '../db.php';

$name = $_POST['name'];
$sig_name = basename($_FILES['signature']['name']);
$stamp_name = basename($_FILES['stamp']['name']);

move_uploaded_file($_FILES['signature']['tmp_name'], "../uploads/signatures/" . $sig_name);
move_uploaded_file($_FILES['stamp']['tmp_name'], "../uploads/signatures/" . $stamp_name);

$stmt = $mysqli->prepare("INSERT INTO doctors (name, signature, stamp) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $sig_name, $stamp_name);
$stmt->execute();

echo "Doctor uploaded successfully.";
?>
