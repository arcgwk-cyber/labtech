<?php
$mysqli = new mysqli('localhost','root','','diagnostic_lab_db');
?>
<?php
$host = 'localhost';
$user = 'root';
$pass = ''; // update if your MySQL password is not blank
$dbname = 'diagnostic_lab_db'; // or whatever your DB name is

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
