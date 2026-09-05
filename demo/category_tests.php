<?php
include('db.php');
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "Access denied.";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Category-wise Tests</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include_once __DIR__ . '/header.php'; ?>

<div class="container py-3">
  <h4 class="mb-3">Tests by Category</h4>
  <?php
  $categories = mysqli_query($conn, "SELECT * FROM test_categories ORDER BY category_name");
  while ($cat = mysqli_fetch_assoc($categories)) {
      echo "<h5 class='mt-4 text-primary'>{$cat['category_name']}</h5>";
      $tests = mysqli_query($conn, "SELECT * FROM lab_tests WHERE category_id = {$cat['category_id']} ORDER BY test_name");
      echo "<ul class='list-group'>";
      while ($test = mysqli_fetch_assoc($tests)) {
          echo "<li class='list-group-item d-flex justify-content-between'>
                  {$test['test_name']} <span class='badge bg-secondary'>₹ {$test['price']}</span>
                </li>";
      }
      echo "</ul>";
  }
  ?>
</div>
</body>
</html>
