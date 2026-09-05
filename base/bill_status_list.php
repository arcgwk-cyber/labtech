<?php
// bill_status_list.php
include 'auth_check.php';
require_once 'db.php';

// Filter values
$sample_filter = $_GET['sample'] ?? '';
$result_filter = $_GET['result'] ?? '';
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';
$page = max(1, intval($_GET['page'] ?? 1));
$limit = 10;
$offset = ($page - 1) * $limit;

// Build query
$where = [];
if ($sample_filter !== '') $where[] = "b.sample_collected = " . (int)$sample_filter;
if ($result_filter !== '') $where[] = "b.result_entered = " . (int)$result_filter;
if ($start_date) $where[] = "DATE(b.created_at) >= '" . $conn->real_escape_string($start_date) . "'";
if ($end_date) $where[] = "DATE(b.created_at) <= '" . $conn->real_escape_string($end_date) . "'";

$where_sql = $where ? "WHERE " . implode(" AND ", $where) : "";

$total_rows = $conn->query("SELECT COUNT(*) as total FROM bills b JOIN patients p ON p.patient_id = b.patient_id $where_sql")->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

$query = "
SELECT b.bill_id, b.sample_collected, b.result_entered, b.created_at, p.full_name, p.gender, p.date_of_birth
FROM bills b
JOIN patients p ON p.patient_id = b.patient_id
$where_sql
ORDER BY b.created_at DESC
LIMIT $limit OFFSET $offset";

$result = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Bill Status List</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 40px; background: #f4f7fa; }
    h2 { text-align: center; color: #333; }
    form.filters { margin-bottom: 20px; text-align: center; }
    form.filters input, form.filters select { margin: 0 5px; padding: 5px; }
    table { width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); }
    th, td { padding: 12px 15px; border-bottom: 1px solid #ddd; text-align: left; }
    th { background-color: #0077cc; color: #fff; text-transform: uppercase; letter-spacing: 0.05em; }
    .status-label { font-weight: bold; padding: 4px 10px; border-radius: 20px; font-size: 13px; display: inline-block; }
    .done { background-color: #d4edda; color: #155724; }
    .pending { background-color: #f8d7da; color: #721c24; }
    .print-button { display: inline-block; padding: 6px 12px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px; font-size: 13px; }
    .print-button:hover { background-color: #218838; }
    .pagination { text-align: center; margin-top: 20px; }
    .pagination a { padding: 6px 12px; margin: 0 3px; background: #eee; color: #333; text-decoration: none; border-radius: 4px; }
    .pagination a.active { background: #0077cc; color: white; font-weight: bold; }
  </style>
</head>
<body>
<?php include_once __DIR__ . '/header.php'; ?>

<h2>Bill Status Overview</h2>
<form method="get" class="filters">
  <label>Sample:</label>
  <select name="sample">
    <option value="">All</option>
    <option value="1" <?= $sample_filter === '1' ? 'selected' : '' ?>>Collected</option>
    <option value="0" <?= $sample_filter === '0' ? 'selected' : '' ?>>Pending</option>
  </select>
  <label>Result:</label>
  <select name="result">
    <option value="">All</option>
    <option value="1" <?= $result_filter === '1' ? 'selected' : '' ?>>Completed</option>
    <option value="0" <?= $result_filter === '0' ? 'selected' : '' ?>>Pending</option>
  </select>
  <label>From:</label><input type="date" name="start_date" value="<?= htmlspecialchars($start_date) ?>">
  <label>To:</label><input type="date" name="end_date" value="<?= htmlspecialchars($end_date) ?>">
  <button type="submit">Filter</button>
</form>

<table>
  <thead>
    <tr>
      <th>Bill ID</th>
      <th>Patient</th>
      <th>Gender</th>
      <th>DOB</th>
      <th>Sample Status</th>
      <th>Result Status</th>
      <th>Date</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row['bill_id'] ?></td>
        <td><?= htmlspecialchars($row['full_name']) ?></td>
        <td><?= $row['gender'] ?></td>
        <td><?= $row['date_of_birth'] ?></td>
        <td><form method="post" action="toggle_status.php" style="display:inline">
          <input type="hidden" name="bill_id" value="<?= $row['bill_id'] ?>">
          <input type="hidden" name="field" value="sample_collected">
          <button type="submit" class="status-label <?= $row['sample_collected'] ? 'done' : 'pending' ?>">
            <?= $row['sample_collected'] ? 'Collected' : 'Pending' ?>
          </button>
        </form></td>
        <td><form method="post" action="toggle_status.php" style="display:inline">
          <input type="hidden" name="bill_id" value="<?= $row['bill_id'] ?>">
          <input type="hidden" name="field" value="result_entered">
          <button type="submit" class="status-label <?= $row['result_entered'] ? 'done' : 'pending' ?>">
            <?= $row['result_entered'] ? 'Completed' : 'Pending' ?>
          </button>
        </form></td>
        <td><?= date("d M Y", strtotime($row['created_at'])) ?></td>
        <td>
          <?php if ($row['result_entered']): ?>
            <a href="pdf_report_generator.php?bill_id=<?= $row['bill_id'] ?>" target="_blank" class="print-button">Print Report</a>
          <?php else: ?>
            <em>Awaiting Results</em>
          <?php endif; ?>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<div class="pagination">
  <?php for ($i = 1; $i <= $total_pages; $i++): ?>
    <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>" class="<?= $i == $page ? 'active' : '' ?>"> <?= $i ?> </a>
  <?php endfor; ?>
</div>
</body>
</html>
