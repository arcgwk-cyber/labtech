
<?php
require '../db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $test_name = $_POST['test_name'];
    $html = $_POST['html_content'];
    $stmt = $mysqli->prepare("INSERT INTO templates (test_name, html_content) VALUES (?, ?)");
    $stmt->bind_param("ss", $test_name, $html);
    $stmt->execute();
    echo "Template Saved!";
}
?>

<h2>Create/Edit Report Template</h2>
<form method="post">
    Test/Package Name: <input type="text" name="test_name" required><br><br>
    HTML Content:<br>
    <textarea name="html_content" rows="20" cols="100">
<html>
<body>
<h2>Lab Report</h2>
{{results_table}}
<br><br>
Doctor Signature: {{signature}}<br>
Doctor Stamp: {{stamp}}<br>
</body>
</html>
    </textarea><br><br>
    <button type="submit">Save Template</button>
</form>
