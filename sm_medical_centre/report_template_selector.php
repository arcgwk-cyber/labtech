<?php
require_once 'db.php';
$bill_id = $_GET['bill_id'] ?? 0;

// Get bill + patient info
$stmt = $conn->prepare("SELECT b.*, p.full_name FROM bills b JOIN patients p ON p.patient_id = b.patient_id WHERE b.bill_id = ?");
$stmt->bind_param("i", $bill_id);
$stmt->execute();
$bill = $stmt->get_result()->fetch_assoc();


if ($bill_id <= 0 || !$bill) {
	echo "<p style='color:red;'>Bill not found or invalid bill ID.</p>";
    header("Location: bill_status.php?error=invalid_bill");
    exit;
}

// Get tests under this bill
$tests = $conn->query("SELECT DISTINCT ltp.test_id, lt.test_name
  FROM test_results r
  JOIN lab_test_parameters ltp ON r.parameter_id = ltp.parameter_id
  JOIN lab_tests lt ON ltp.test_id = lt.test_id
  WHERE r.bill_id = $bill_id");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Select Template</title>
  <style>
    body { font-family: Arial; padding: 20px; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { padding: 10px; border: 1px solid #ccc; }
    th { background: #f0f0f0; }
    select { width: 100%; padding: 5px; }
    .btn { background: #0077cc; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
  </style>
</head>
<body>
<h2>Generate Report for Bill #<?= $bill_id ?> (<?= htmlspecialchars($bill['full_name']) ?>)</h2>
<form method="GET" action="report_generate_pdf.php">
  <input type="hidden" name="bill_id" value="<?= $bill_id ?>">
  <table>
    <thead>
      <tr><th>Test</th><th>Choose Template</th></tr>
    </thead>
    <tbody>
      <?php while ($row = $tests->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['test_name']) ?></td>
          <td>
            <select name="templates[<?= $row['test_id'] ?>]">
              <?php
              $template_q = $conn->prepare("SELECT template_id, template_name, is_default FROM test_templates WHERE test_id = ?");
              $template_q->bind_param("i", $row['test_id']);
              $template_q->execute();
              $templates = $template_q->get_result();
              while ($tpl = $templates->fetch_assoc()): ?>
                <option value="<?= $tpl['template_id'] ?>" <?= $tpl['is_default'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($tpl['template_name']) ?><?= $tpl['is_default'] ? ' (Default)' : '' ?>
                </option>
              <?php endwhile; ?>
            </select>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <br>
  <button type="submit" class="btn">Generate PDF</button>
</form>
</body>
</html>
