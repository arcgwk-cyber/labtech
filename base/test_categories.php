<?php
/**
 * Clinical Departments & Test Categories Master
 * - High-level laboratory department classification (Biochemistry, Hematology, Microbiology, etc.)
 * - Modern medical studio design with light placeholders
 */
include_once 'auth_check.php';
include_once 'db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Handle Add Category
if (isset($_POST['add'])) {
    $name = trim($_POST['category_name'] ?? '');
    if (!empty($name)) {
        $stmt = $conn->prepare("INSERT INTO test_categories (category_name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->close();
        $_SESSION['alert'] = ['type' => 'success', 'msg' => "Category '{$name}' created successfully."];
    }
    header("Location: test_categories.php");
    exit;
}

// Handle Delete Category
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if ($id > 0) {
        $conn->query("DELETE FROM test_categories WHERE category_id = $id");
        $_SESSION['alert'] = ['type' => 'danger', 'msg' => "Category deleted successfully."];
    }
    header("Location: test_categories.php");
    exit;
}

// Handle Update Category
if (isset($_POST['update'])) {
    $id = intval($_POST['category_id']);
    $name = trim($_POST['category_name'] ?? '');
    if ($id > 0 && !empty($name)) {
        $stmt = $conn->prepare("UPDATE test_categories SET category_name=? WHERE category_id=?");
        $stmt->bind_param("si", $name, $id);
        $stmt->execute();
        $stmt->close();
        $_SESSION['alert'] = ['type' => 'success', 'msg' => "Category updated successfully."];
    }
    header("Location: test_categories.php");
    exit;
}

// Handle Edit Fetch
$edit_category = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $stmt = $conn->prepare("SELECT * FROM test_categories WHERE category_id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $edit_category = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

// Fetch all categories with Test Counts
$categories = $conn->query("
    SELECT c.*, 
           (SELECT COUNT(*) FROM lab_tests lt WHERE lt.category_id = c.category_id) as test_count,
           (SELECT COUNT(*) FROM test_parameters tp WHERE tp.category_id = c.category_id) as param_count
    FROM test_categories c 
    ORDER BY c.category_name ASC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Clinical Departments & Categories | Laboratory ERP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --brand-primary: #0284c7;
      --brand-dark: #0369a1;
      --surface-bg: #f8fafc;
      --border-color: #e2e8f0;
      --border-light: #f1f5f9;
      --text-main: #0f172a;
      --text-muted: #64748b;
      --placeholder-color: #94a3b8;
    }

    body {
      background-color: var(--surface-bg);
      font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
      color: var(--text-main);
      margin: 0;
      padding-bottom: 60px;
    }

    /* Universal Light Placeholders */
    ::placeholder {
      color: var(--placeholder-color) !important;
      opacity: 0.75 !important;
      font-weight: 400 !important;
    }
    ::-webkit-input-placeholder {
      color: var(--placeholder-color) !important;
      opacity: 0.75 !important;
      font-weight: 400 !important;
    }
    :-moz-placeholder {
      color: var(--placeholder-color) !important;
      opacity: 0.75 !important;
      font-weight: 400 !important;
    }
    ::-moz-placeholder {
      color: var(--placeholder-color) !important;
      opacity: 0.75 !important;
      font-weight: 400 !important;
    }
    :-ms-input-placeholder {
      color: var(--placeholder-color) !important;
      opacity: 0.75 !important;
      font-weight: 400 !important;
    }
    .form-control::placeholder {
      color: var(--placeholder-color) !important;
      opacity: 0.75 !important;
      font-size: 0.85rem !important;
    }

    .page-container {
      max-width: 1000px;
      margin: 22px auto;
      padding: 0 18px;
    }

    /* Studio Header */
    .studio-header-card {
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 14px;
      padding: 18px 24px;
      box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.04);
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 22px;
      flex-wrap: wrap;
      gap: 12px;
    }
    .studio-title {
      font-size: 1.35rem;
      font-weight: 800;
      color: var(--text-main);
      margin: 0;
      display: flex;
      align-items: center;
      gap: 10px;
      letter-spacing: -0.3px;
    }

    /* Form Card */
    .studio-card {
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 14px;
      box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.04);
      padding: 22px 24px;
      margin-bottom: 22px;
    }
    .form-label {
      font-size: 0.74rem;
      font-weight: 700;
      color: #64748b;
      margin-bottom: 5px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      display: block;
    }
    .form-control {
      border-radius: 8px;
      border: 1px solid var(--border-color);
      font-size: 0.89rem;
      padding: 9px 13px;
      color: var(--text-main);
    }
    .form-control:focus {
      border-color: var(--brand-primary);
      box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.12);
    }

    /* Table */
    .studio-table-wrapper {
      border: 1px solid var(--border-color);
      border-radius: 12px;
      overflow: hidden;
      background: #ffffff;
    }
    .studio-table {
      width: 100%;
      border-collapse: collapse;
      margin: 0;
    }
    .studio-table th {
      background-color: #f8fafc;
      color: #475569;
      font-size: 0.76rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      padding: 12px 16px;
      border-bottom: 1px solid var(--border-color);
    }
    .studio-table td {
      padding: 12px 16px;
      vertical-align: middle;
      border-bottom: 1px solid var(--border-light);
      font-size: 0.88rem;
    }
    .studio-table tr:last-child td {
      border-bottom: none;
    }
    .studio-table tr:hover td {
      background-color: #fafbfc;
    }
  </style>
</head>
<body>

<?php include_once __DIR__ . '/header.php'; ?>

<div class="page-container">

  <!-- Header Card -->
  <div class="studio-header-card">
    <div>
      <h1 class="studio-title">
        <i class="bi bi-folder2-open text-primary"></i> Clinical Departments & Categories
      </h1>
      <div class="text-muted small mt-1">
        Organize diagnostic test profiles across hospital and clinical laboratory departments.
      </div>
    </div>
    <div class="d-flex align-items-center gap-2">
      <a href="test_groups.php" class="btn btn-outline-secondary btn-sm fw-semibold">
        <i class="bi bi-diagram-3 me-1"></i> Groups Master
      </a>
      <a href="lab_test_list.php" class="btn btn-outline-primary btn-sm fw-semibold">
        <i class="bi bi-clipboard2-pulse me-1"></i> Tests Master
      </a>
    </div>
  </div>

  <!-- Session Alerts -->
  <?php if (!empty($_SESSION['alert'])): ?>
    <div class="alert alert-<?= htmlspecialchars($_SESSION['alert']['type'] ?? 'info') ?> alert-dismissible fade show shadow-sm" role="alert">
      <i class="bi bi-info-circle-fill me-2"></i><?= htmlspecialchars($_SESSION['alert']['msg'] ?? '') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['alert']); ?>
  <?php endif; ?>

  <!-- Add / Edit Category Form -->
  <div class="studio-card">
    <h6 class="fw-bold mb-3 text-dark">
      <i class="bi <?= $edit_category ? 'bi-pencil text-warning' : 'bi-plus-circle text-primary' ?> me-2"></i>
      <?= $edit_category ? 'Edit Category #' . $edit_category['category_id'] : 'Create New Clinical Department / Category' ?>
    </h6>

    <form method="POST" action="test_categories.php">
      <?php if ($edit_category): ?>
        <input type="hidden" name="category_id" value="<?= $edit_category['category_id'] ?>">
      <?php endif; ?>

      <div class="row g-2 align-items-end">
        <div class="col-md-8 col-12">
          <label class="form-label">Category Name <span class="text-danger">*</span></label>
          <input type="text" name="category_name" class="form-control fw-bold" placeholder="e.g. Clinical Biochemistry, Hematology, Serology & Immunology" required value="<?= htmlspecialchars($edit_category['category_name'] ?? '') ?>">
        </div>
        <div class="col-md-4 col-12 d-flex gap-2">
          <button type="submit" name="<?= $edit_category ? 'update' : 'add' ?>" class="btn btn-primary px-4 fw-bold">
            <i class="bi bi-check2-circle me-1"></i> <?= $edit_category ? 'Update Category' : 'Save Category' ?>
          </button>
          <?php if ($edit_category): ?>
            <a href="test_categories.php" class="btn btn-outline-secondary">Cancel</a>
          <?php endif; ?>
        </div>
      </div>
    </form>
  </div>

  <!-- Categories Table -->
  <div class="studio-card">
    <h6 class="fw-bold mb-3 text-dark">
      <i class="bi bi-folder2 text-primary me-2"></i> All Configured Categories
    </h6>

    <div class="studio-table-wrapper">
      <table class="studio-table">
        <thead>
          <tr>
            <th width="8%">#</th>
            <th width="50%">Department / Category Name</th>
            <th width="22%">Associated Content</th>
            <th width="20%" class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($categories && $categories->num_rows > 0): ?>
            <?php $sn = 1; while ($c = $categories->fetch_assoc()): ?>
              <tr>
                <td class="text-muted font-monospace"><?= $sn++ ?></td>
                <td>
                  <strong class="text-dark"><?= htmlspecialchars($c['category_name']) ?></strong>
                </td>
                <td>
                  <span class="badge bg-light text-secondary border font-monospace me-1">
                    <?= (int)$c['test_count'] ?> Tests
                  </span>
                  <span class="badge bg-light text-secondary border font-monospace">
                    <?= (int)$c['param_count'] ?> Parameters
                  </span>
                </td>
                <td class="text-end">
                  <div class="d-flex align-items-center justify-content-end gap-1">
                    <a href="test_categories.php?edit=<?= $c['category_id'] ?>" class="btn btn-sm btn-outline-warning" title="Edit Category">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <a href="test_categories.php?delete=<?= $c['category_id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete category \'<?= htmlspecialchars(addslashes($c['category_name'])) ?>\'?')" title="Delete Category">
                      <i class="bi bi-trash"></i>
                    </a>
                  </div>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="4" class="text-center py-4 text-muted">No test categories found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

</body>
</html>
