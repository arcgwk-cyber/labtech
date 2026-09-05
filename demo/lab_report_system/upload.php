<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $designation = $_POST['designation'];

  $sig_name = 'uploads/signature.png';
  $stamp_name = 'uploads/stamp.png';
  move_uploaded_file($_FILES['signature']['tmp_name'], $sig_name);
  move_uploaded_file($_FILES['stamp']['tmp_name'], $stamp_name);

  $pdo = new PDO('mysql:host=localhost;dbname=lab', 'root', '');
  $stmt = $pdo->prepare("INSERT INTO doctors (name, designation, signature_path, stamp_path) VALUES (?, ?, ?, ?)");
  $stmt->execute([$name, $designation, $sig_name, $stamp_name]);

  echo "Uploaded successfully.";
}
?>
