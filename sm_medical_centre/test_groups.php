<?php
/**
 * Clinical Test Groups Master
 * - Organize parameters and investigations by clinical group
 * - Modern medical studio design with light placeholders
 */
include_once 'auth_check.php';
include_once 'db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Handle Add Group
if (isset($_POST['add'])) {
    $group = trim($_POST['group_name'] ?? '');
    if (!empty($group)) {
        $stmt = $conn->prepare("INSERT INTO test_groups (group_name) VALUES (?)");
        $stmt->bind_param("s", $group);
        $stmt->execute();
        $stmt->close();
        $_SESSION['alert'] = ['type' => 'success', 'msg' => "Group '{$group}' added successfully."];
    }
    header("Location: test_groups.php");
    exit;
}

// Handle Delete Group
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if ($id > 0) {
        $conn->query("DELETE FROM test_groups WHERE group_id = $id");
        $_SESSION['alert'] = ['type' => 'danger', 'msg' => "Test group deleted successfully."];
    }
    header("Location: test_groups.php");
    exit;
}

// Handle Update Group
if (isset($_POST['update'])) {
    $id = intval($_POST['group_id']);
    $group = trim($_POST['group_name'] ?? '');
    if ($id > 0 && !empty($group)) {
        $stmt = $conn->prepare("UPDATE test_groups SET group_name=? WHERE group_id=?");
        $stmt->bind_param("si", $group, $id);
        $stmt->execute();
        $stmt->close();
        $_SESSION['alert'] = ['type' => 'success', 'msg' => "Group updated successfully."];
    }
    header("Location: test_groups.php");
    exit;
}

// Handle Edit Fetch
$edit_group = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $stmt = $conn->prepare("SELECT * FROM test_groups WHERE group_id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $edit_group = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

// Fetch All Groups with Parameter and Test Counts
$groups = $conn->query("
    SELECT g.*, 
           (SELECT COUNT(*) FROM test_parameters tp WHERE tp.group_id = g.group_id) as param_count,
           (SELECT COUNT(*) FROM lab_tests lt WHERE lt.group_id = g.group_id) as test_count
    FROM test_groups g 
    ORDER BY g.group_name ASC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Clinical Test Groups | Laboratory ERP</title>
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
        <i class="bi bi-diagram-3 text-primary"></i> Test Groups Master
      </h1>
      <div class="text-muted small mt-1">
        Categorize laboratory parameters and sections into clinical report groups.
      </div>
    </div>
    <div class="d-flex align-items-center gap-2">
      <a href="test_categories.php" class="btn btn-outline-secondary btn-sm fw-semibold">
        <i class="bi bi-folder2 me-1"></i> Categories Master
      </a>
      <a href="test_parameters.php" class="btn btn-outline-primary btn-sm fw-semibold">
        <i class="bi bi-sliders me-1"></i> Parameters
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

  <!-- Add / Edit Group Form -->
  <div class="studio-card">
    <h6 class="fw-bold mb-3 text-dark">
      <i class="bi <?= $edit_group ? 'bi-pencil text-warning' : 'bi-plus-circle text-primary' ?> me-2"></i>
      <?= $edit_group ? 'Edit Group #' . $edit_group['group_id'] : 'Create New Test Group' ?>
    </h6>

    <form method="POST" action="test_groups.php">
      <?php if ($edit_group): ?>
        <input type="hidden" name="group_id" value="<?= $edit_group['group_id'] ?>">
      <?php endif; ?>

      <div class="row g-2 align-items-end">
        <div class="col-md-8 col-12">
          <label class="form-label">Group Name <span class="text-danger">*</span></label>
          <input type="text" name="group_name" class="form-control fw-bold" placeholder="e.g. Hematology, Lipid Profile, Liver Function Tests" required value="<?= htmlspecialchars($edit_group['group_name'] ?? '') ?>">
        </div>
        <div class="col-md-4 col-12 d-flex gap-2">
          <button type="submit" name="<?= $edit_group ? 'update' : 'add' ?>" class="btn btn-primary px-4 fw-bold">
            <i class="bi bi-check2-circle me-1"></i> <?= $edit_group ? 'Update Group' : 'Save Group' ?>
          </button>
          <?php if ($edit_group): ?>
            <a href="test_groups.php" class="btn btn-outline-secondary">Cancel</a>
          <?php endif; ?>
        </div>
      </div>
    </form>
  </div>

  <!-- Groups Table -->
  <div class="studio-card">
    <h6 class="fw-bold mb-3 text-dark">
      <i class="bi bi-list-check text-primary me-2"></i> All Active Groups
    </h6>

    <div class="studio-table-wrapper">
      <table class="studio-table">
        <thead>
          <tr>
            <th width="8%">#</th>
            <th width="50%">Group Name</th>
            <th width="22%">Associated Content</th>
            <th width="20%" class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($groups && $groups->num_rows > 0): ?>
            <?php $sn = 1; while ($g = $groups->fetch_assoc()): ?>
              <tr>
                <td class="text-muted font-monospace"><?= $sn++ ?></td>
                <td>
                  <strong class="text-dark"><?= htmlspecialchars($g['group_name']) ?></strong>
                </td>
                <td>
                  <span class="badge bg-light text-secondary border font-monospace me-1">
                    <?= (int)$g['param_count'] ?> Parameters
                  </span>
                  <span class="badge bg-light text-secondary border font-monospace">
                    <?= (int)$g['test_count'] ?> Tests
                  </span>
                </td>
                <td class="text-end">
                  <div class="d-flex align-items-center justify-content-end gap-1">
                    <a href="test_groups.php?edit=<?= $g['group_id'] ?>" class="btn btn-sm btn-outline-warning" title="Edit Group">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <a href="test_groups.php?delete=<?= $g['group_id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete group \'<?= htmlspecialchars(addslashes($g['group_name'])) ?>\'?')" title="Delete Group">
                      <i class="bi bi-trash"></i>
                    </a>
                  </div>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="4" class="text-center py-4 text-muted">No test groups found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

</body>
</html>
