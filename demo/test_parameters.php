<?php
/**
 * Test Parameters & Reference Intervals Master
 * - Parameter configuration with Units, Methods, Clinical Interpretation, and Notes
 * - Gender and age-stratified reference intervals (Male, Female, Child) or text ranges
 * - Modern medical studio layout with light placeholders and instant search
 */
include_once 'auth_check.php';
include_once 'db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function get_post($key, $default = null) {
    return isset($_POST[$key]) ? trim($_POST[$key]) : $default;
}

function float_or_null($value) {
    return ($value === '' || $value === null) ? null : floatval($value);
}

// 1. Handle Add
if (isset($_POST['add'])) {
    $conn->begin_transaction();
    try {
        $param_name     = get_post('param_name');
        $category_id    = intval(get_post('category_id'));
        $group_id       = intval(get_post('group_id'));
        $unit           = get_post('unit');
        $method         = get_post('method');
        $interpretation = get_post('interpretation');
        $notes          = get_post('notes');

        if (empty($param_name)) {
            throw new Exception("Parameter name is required.");
        }

        $stmt = $conn->prepare("INSERT INTO test_parameters (param_name, category_id, group_id, unit, method, interpretation, notes) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siissss", $param_name, $category_id, $group_id, $unit, $method, $interpretation, $notes);
        if (!$stmt->execute()) {
            throw new Exception("Error inserting test parameter: " . $stmt->error);
        }
        $parameter_id = $stmt->insert_id;
        $stmt->close();

        // Reference ranges
        $min_m              = float_or_null(get_post('male_min'));
        $max_m              = float_or_null(get_post('male_max'));
        $default_m          = get_post('male_default');
        $min_f              = float_or_null(get_post('female_min'));
        $max_f              = float_or_null(get_post('female_max'));
        $default_f          = get_post('female_default');
        $min_c              = float_or_null(get_post('child_min'));
        $max_c              = float_or_null(get_post('child_max'));
        $default_c          = get_post('child_default');
        $reference_text     = get_post('reference_text');
        $use_reference_text = isset($_POST['use_reference_text']) ? 1 : 0;

        $stmt = $conn->prepare("INSERT INTO parameter_reference_ranges 
            (parameter_id, male_min, male_max, male_default, female_min, female_max, female_default, child_min, child_max, child_default, reference_text, use_reference_text) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "idssdssdsssi",
            $parameter_id,
            $min_m, $max_m, $default_m,
            $min_f, $max_f, $default_f,
            $min_c, $max_c, $default_c,
            $reference_text, $use_reference_text
        );
        if (!$stmt->execute()) {
            throw new Exception("Error inserting reference ranges: " . $stmt->error);
        }
        $stmt->close();
        $conn->commit();

        $_SESSION['alert'] = ['type' => 'success', 'msg' => "Parameter '{$param_name}' created successfully."];
        header("Location: test_parameters.php");
        exit;
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['alert'] = ['type' => 'danger', 'msg' => $e->getMessage()];
    }
}

// 2. Handle Edit Load
$parameter = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $stmt = $conn->prepare("
        SELECT tp.*, c.category_name, g.group_name, 
               r.male_min, r.male_max, r.male_default, 
               r.female_min, r.female_max, r.female_default, 
               r.child_min, r.child_max, r.child_default,
               r.reference_text, r.use_reference_text 
        FROM test_parameters tp
        LEFT JOIN test_categories c ON tp.category_id = c.category_id
        LEFT JOIN test_groups g ON tp.group_id = g.group_id
        LEFT JOIN parameter_reference_ranges r ON tp.parameter_id = r.parameter_id
        WHERE tp.parameter_id = ?
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $parameter = $result->fetch_assoc();
    $stmt->close();
}

// 3. Handle Update
if (isset($_POST['update'])) {
    $id = intval(get_post('parameter_id'));
    $conn->begin_transaction();
    try {
        $param_name     = get_post('param_name');
        $category_id    = intval(get_post('category_id'));
        $group_id       = intval(get_post('group_id'));
        $unit           = get_post('unit');
        $method         = get_post('method');
        $interpretation = get_post('interpretation');
        $notes          = get_post('notes');

        $stmt = $conn->prepare("UPDATE test_parameters SET param_name = ?, category_id = ?, group_id = ?, unit = ?, method = ?, interpretation = ?, notes = ? WHERE parameter_id = ?");
        $stmt->bind_param("siissssi", $param_name, $category_id, $group_id, $unit, $method, $interpretation, $notes, $id);
        if (!$stmt->execute()) {
            throw new Exception("Error updating test parameter: " . $stmt->error);
        }
        $stmt->close();

        // Reference ranges
        $min_m              = float_or_null(get_post('male_min'));
        $max_m              = float_or_null(get_post('male_max'));
        $default_m          = get_post('male_default');
        $min_f              = float_or_null(get_post('female_min'));
        $max_f              = float_or_null(get_post('female_max'));
        $default_f          = get_post('female_default');
        $min_c              = float_or_null(get_post('child_min'));
        $max_c              = float_or_null(get_post('child_max'));
        $default_c          = get_post('child_default');
        $reference_text     = get_post('reference_text');
        $use_reference_text = isset($_POST['use_reference_text']) ? 1 : 0;

        $check_stmt = $conn->prepare("SELECT COUNT(*) FROM parameter_reference_ranges WHERE parameter_id = ?");
        $check_stmt->bind_param("i", $id);
        $check_stmt->execute();
        $check_stmt->bind_result($count);
        $check_stmt->fetch();
        $check_stmt->close();

        if ($count > 0) {
            $stmt = $conn->prepare("UPDATE parameter_reference_ranges SET 
                male_min = ?, male_max = ?, male_default = ?, 
                female_min = ?, female_max = ?, female_default = ?, 
                child_min = ?, child_max = ?, child_default = ?, reference_text = ?, use_reference_text = ?
                WHERE parameter_id = ?");
            $stmt->bind_param("ddssdssdssii",
                $min_m, $max_m, $default_m,
                $min_f, $max_f, $default_f,
                $min_c, $max_c, $default_c,
                $reference_text, $use_reference_text,
                $id
            );
        } else {
            $stmt = $conn->prepare("INSERT INTO parameter_reference_ranges 
                (parameter_id, male_min, male_max, male_default, female_min, female_max, female_default, child_min, child_max, child_default, reference_text, use_reference_text) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("idssdssdsssi",
                $id,
                $min_m, $max_m, $default_m,
                $min_f, $max_f, $default_f,
                $min_c, $max_c, $default_c,
                $reference_text, $use_reference_text
            );
        }

        if (!$stmt->execute()) {
            throw new Exception("Error updating reference ranges: " . $stmt->error);
        }
        $stmt->close();
        $conn->commit();

        $_SESSION['alert'] = ['type' => 'success', 'msg' => "Parameter '{$param_name}' updated successfully."];
        header("Location: test_parameters.php");
        exit;
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['alert'] = ['type' => 'danger', 'msg' => $e->getMessage()];
    }
}

// 4. Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->begin_transaction();
    try {
        $stmt1 = $conn->prepare("DELETE FROM parameter_reference_ranges WHERE parameter_id = ?");
        $stmt1->bind_param("i", $id);
        $stmt1->execute();
        $stmt1->close();

        $stmt2 = $conn->prepare("DELETE FROM test_parameters WHERE parameter_id = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $stmt2->close();

        $conn->commit();
        $_SESSION['alert'] = ['type' => 'danger', 'msg' => "Parameter deleted successfully."];
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['alert'] = ['type' => 'danger', 'msg' => "Error: " . $e->getMessage()];
    }
    header("Location: test_parameters.php");
    exit;
}

// Dropdowns
$categories = $conn->query("SELECT * FROM test_categories ORDER BY category_name");
$groups = $conn->query("SELECT * FROM test_groups ORDER BY group_name");

// Search & Filter
$search       = isset($_GET['search']) ? trim($_GET['search']) : '';
$filter_group = isset($_GET['group']) ? intval($_GET['group']) : 0;
$page         = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit        = 15;
$offset       = ($page - 1) * $limit;

$where = "WHERE 1 ";
$params_list = [];
$types = "";

if ($search !== '') {
    $where .= "AND tp.param_name LIKE ? ";
    $params_list[] = "%$search%";
    $types .= "s";
}
if ($filter_group > 0) {
    $where .= "AND tp.group_id = ? ";
    $params_list[] = $filter_group;
    $types .= "i";
}

$count_sql = "SELECT COUNT(*) FROM test_parameters tp $where";
$count_stmt = $conn->prepare($count_sql);
if ($types) {
    $count_stmt->bind_param($types, ...$params_list);
}
$count_stmt->execute();
$count_stmt->bind_result($total);
$count_stmt->fetch();
$count_stmt->close();

$total_pages = ceil($total / $limit);

$sql = "
    SELECT tp.*, c.category_name, g.group_name,
           r.male_min, r.male_max, r.female_min, r.female_max, r.reference_text, r.use_reference_text
    FROM test_parameters tp
    LEFT JOIN test_categories c ON tp.category_id = c.category_id
    LEFT JOIN test_groups g ON tp.group_id = g.group_id
    LEFT JOIN parameter_reference_ranges r ON tp.parameter_id = r.parameter_id
    $where
    ORDER BY tp.param_name ASC
    LIMIT $limit OFFSET $offset";

$stmt = $conn->prepare($sql);
if ($types) {
    $stmt->bind_param($types, ...$params_list);
}
$stmt->execute();
$params_res = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test Parameters Master | Clinical Laboratory ERP</title>
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
      max-width: 1400px;
      margin: 22px auto;
      padding: 0 18px;
    }

    /* Studio Header */
    .param-header-card {
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
    .param-title {
      font-size: 1.35rem;
      font-weight: 800;
      color: var(--text-main);
      margin: 0;
      display: flex;
      align-items: center;
      gap: 10px;
      letter-spacing: -0.3px;
    }

    /* Studio Cards */
    .studio-card {
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 14px;
      box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.04);
      padding: 22px 24px;
      margin-bottom: 22px;
    }
    .studio-card-title {
      font-size: 1.02rem;
      font-weight: 700;
      color: var(--text-main);
      margin-bottom: 18px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid var(--border-light);
      padding-bottom: 12px;
    }

    /* Form Controls */
    .form-label {
      font-size: 0.74rem;
      font-weight: 700;
      color: #64748b;
      margin-bottom: 5px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      display: block;
    }
    .form-control, .form-select {
      border-radius: 8px;
      border: 1px solid var(--border-color);
      font-size: 0.89rem;
      padding: 8px 12px;
      color: var(--text-main);
      background-color: #ffffff;
    }
    .form-control:focus, .form-select:focus {
      border-color: var(--brand-primary);
      box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.12);
    }

    /* Reference Range Sub-card */
    .ref-range-box {
      background: #f8fafc;
      border: 1px solid var(--border-color);
      border-radius: 10px;
      padding: 16px;
      margin-bottom: 16px;
    }

    /* Table */
    .param-table-wrapper {
      border: 1px solid var(--border-color);
      border-radius: 12px;
      overflow: hidden;
      background: #ffffff;
    }
    .param-table {
      width: 100%;
      border-collapse: collapse;
      margin: 0;
    }
    .param-table th {
      background-color: #f8fafc;
      color: #475569;
      font-size: 0.76rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      padding: 12px 16px;
      border-bottom: 1px solid var(--border-color);
      white-space: nowrap;
    }
    .param-table td {
      padding: 12px 16px;
      vertical-align: middle;
      border-bottom: 1px solid var(--border-light);
      font-size: 0.88rem;
    }
    .param-table tr:last-child td {
      border-bottom: none;
    }
    .param-table tr:hover td {
      background-color: #fafbfc;
    }
  </style>
</head>
<body>

<?php include_once __DIR__ . '/header.php'; ?>

<div class="page-container">

  <!-- Header Card -->
  <div class="param-header-card">
    <div>
      <h1 class="param-title">
        <i class="bi bi-sliders text-primary"></i> Test Parameters Master
      </h1>
      <div class="text-muted small mt-1">
        Configure clinical analyte parameters, measurement units, methodology, and biological reference intervals.
      </div>
    </div>
    <div class="d-flex align-items-center gap-2">
      <a href="lab_test_list.php" class="btn btn-outline-secondary btn-sm fw-semibold">
        <i class="bi bi-clipboard2-pulse me-1"></i> Tests Master
      </a>
      <a href="rate_card.php" class="btn btn-outline-primary btn-sm fw-semibold">
        <i class="bi bi-file-earmark-spreadsheet me-1"></i> Tariff Rate Card
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

  <!-- Add / Edit Parameter Form Card -->
  <div class="studio-card">
    <div class="studio-card-title">
      <span>
        <i class="bi <?= $parameter ? 'bi-pencil-square text-warning' : 'bi-plus-circle-fill text-primary' ?> me-2"></i>
        <?= $parameter ? 'Edit Parameter: ' . htmlspecialchars($parameter['param_name']) : 'Define New Clinical Parameter' ?>
      </span>
      <?php if ($parameter): ?>
        <a href="test_parameters.php" class="btn btn-outline-secondary btn-sm">
          <i class="bi bi-x-lg me-1"></i> Cancel Edit
        </a>
      <?php endif; ?>
    </div>

    <form method="POST" action="test_parameters.php">
      <?php if ($parameter): ?>
        <input type="hidden" name="parameter_id" value="<?= $parameter['parameter_id'] ?>">
      <?php endif; ?>

      <div class="row g-3 mb-3">
        <div class="col-md-4 col-12">
          <label class="form-label">Parameter Name <span class="text-danger">*</span></label>
          <input type="text" name="param_name" class="form-control fw-bold" placeholder="e.g. Hemoglobin, Fasting Blood Sugar, TSH" required value="<?= htmlspecialchars($parameter['param_name'] ?? '') ?>">
        </div>

        <div class="col-md-3 col-6">
          <label class="form-label">Category / Department</label>
          <select name="category_id" class="form-select">
            <option value="">-- Choose Category --</option>
            <?php 
            mysqli_data_seek($categories, 0);
            while ($c = $categories->fetch_assoc()): ?>
              <option value="<?= $c['category_id'] ?>" <?= (isset($parameter['category_id']) && $parameter['category_id'] == $c['category_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($c['category_name']) ?>
              </option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="col-md-3 col-6">
          <label class="form-label">Clinical Group</label>
          <select name="group_id" class="form-select">
            <option value="">-- Choose Group --</option>
            <?php 
            mysqli_data_seek($groups, 0);
            while ($g = $groups->fetch_assoc()): ?>
              <option value="<?= $g['group_id'] ?>" <?= (isset($parameter['group_id']) && $parameter['group_id'] == $g['group_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($g['group_name']) ?>
              </option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="col-md-2 col-6">
          <label class="form-label">Measurement Unit</label>
          <input type="text" name="unit" class="form-control font-monospace" placeholder="e.g. g/dL, mg/dL, µIU/mL, %" value="<?= htmlspecialchars($parameter['unit'] ?? '') ?>">
        </div>

        <div class="col-md-4 col-6">
          <label class="form-label">Assay Method</label>
          <input type="text" name="method" class="form-control" placeholder="e.g. GOD-POD, ECLIA, Cyanmethemoglobin" value="<?= htmlspecialchars($parameter['method'] ?? '') ?>">
        </div>

        <div class="col-md-8 col-12">
          <label class="form-label">Clinical Interpretation</label>
          <input type="text" name="interpretation" class="form-control" placeholder="Brief diagnostic significance for abnormal findings" value="<?= htmlspecialchars($parameter['interpretation'] ?? '') ?>">
        </div>
      </div>

      <!-- Reference Intervals Sub-Card -->
      <div class="ref-range-box">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <span class="small fw-bold text-uppercase text-secondary">
            <i class="bi bi-segmented-nav me-1"></i> Biological Reference Intervals
          </span>
          <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" name="use_reference_text" id="useRefText" value="1" <?= (!empty($parameter['use_reference_text'])) ? 'checked' : '' ?> onchange="toggleRefRangeMode()">
            <label class="form-check-label small fw-semibold" for="useRefText">Use Free Text / Descriptive Range</label>
          </div>
        </div>

        <!-- Numeric Ranges (Male, Female, Child) -->
        <div id="numericRangesRow" class="row g-3" style="<?= (!empty($parameter['use_reference_text'])) ? 'display:none;' : '' ?>">
          <div class="col-md-4 col-12">
            <div class="p-2 border rounded-3 bg-white">
              <span class="small fw-bold text-primary mb-1 d-block"><i class="bi bi-gender-male me-1"></i> Male Reference</span>
              <div class="row g-1">
                <div class="col-6">
                  <input type="number" step="0.01" name="male_min" class="form-control form-control-sm" placeholder="Min" value="<?= htmlspecialchars($parameter['male_min'] ?? '') ?>">
                </div>
                <div class="col-6">
                  <input type="number" step="0.01" name="male_max" class="form-control form-control-sm" placeholder="Max" value="<?= htmlspecialchars($parameter['male_max'] ?? '') ?>">
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4 col-12">
            <div class="p-2 border rounded-3 bg-white">
              <span class="small fw-bold text-danger mb-1 d-block"><i class="bi bi-gender-female me-1"></i> Female Reference</span>
              <div class="row g-1">
                <div class="col-6">
                  <input type="number" step="0.01" name="female_min" class="form-control form-control-sm" placeholder="Min" value="<?= htmlspecialchars($parameter['female_min'] ?? '') ?>">
                </div>
                <div class="col-6">
                  <input type="number" step="0.01" name="female_max" class="form-control form-control-sm" placeholder="Max" value="<?= htmlspecialchars($parameter['female_max'] ?? '') ?>">
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4 col-12">
            <div class="p-2 border rounded-3 bg-white">
              <span class="small fw-bold text-success mb-1 d-block"><i class="bi bi-person me-1"></i> Child / General</span>
              <div class="row g-1">
                <div class="col-6">
                  <input type="number" step="0.01" name="child_min" class="form-control form-control-sm" placeholder="Min" value="<?= htmlspecialchars($parameter['child_min'] ?? '') ?>">
                </div>
                <div class="col-6">
                  <input type="number" step="0.01" name="child_max" class="form-control form-control-sm" placeholder="Max" value="<?= htmlspecialchars($parameter['child_max'] ?? '') ?>">
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Descriptive Text Range -->
        <div id="textRangeRow" class="mt-2" style="<?= (empty($parameter['use_reference_text'])) ? 'display:none;' : '' ?>">
          <label class="form-label">Descriptive Reference String</label>
          <input type="text" name="reference_text" class="form-control" placeholder="e.g. Negative, Non-Reactive, < 1.0 Index, Clear" value="<?= htmlspecialchars($parameter['reference_text'] ?? '') ?>">
        </div>
      </div>

      <div class="d-flex align-items-center gap-2">
        <button type="submit" name="<?= $parameter ? 'update' : 'add' ?>" class="btn btn-primary px-4 fw-bold shadow-sm">
          <i class="bi bi-check2-circle me-1"></i> <?= $parameter ? 'Update Parameter' : 'Save Parameter' ?>
        </button>
        <?php if ($parameter): ?>
          <a href="test_parameters.php" class="btn btn-outline-secondary px-3">Cancel</a>
        <?php endif; ?>
      </div>
    </form>
  </div>

  <!-- All Parameters Table Card -->
  <div class="studio-card">
    <div class="studio-card-title">
      <span><i class="bi bi-list-ul text-primary me-2"></i> All Configured Parameters (<?= $total ?>)</span>
    </div>

    <!-- Filter Form -->
    <form method="GET" action="test_parameters.php" class="row g-2 align-items-center mb-3">
      <div class="col-md-5 col-12">
        <div class="input-group">
          <span class="input-group-text bg-light text-muted"><i class="bi bi-search"></i></span>
          <input type="text" name="search" class="form-control" placeholder="Search by parameter name..." value="<?= htmlspecialchars($search) ?>">
        </div>
      </div>

      <div class="col-md-4 col-12">
        <select name="group" class="form-select">
          <option value="">All Parameter Groups</option>
          <?php 
          mysqli_data_seek($groups, 0);
          while ($g = $groups->fetch_assoc()): ?>
            <option value="<?= $g['group_id'] ?>" <?= ($filter_group == $g['group_id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($g['group_name']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>

      <div class="col-auto d-flex gap-2">
        <button type="submit" class="btn btn-primary btn-sm fw-bold px-3">Filter</button>
        <a href="test_parameters.php" class="btn btn-outline-secondary btn-sm">Reset</a>
      </div>
    </form>

    <div class="param-table-wrapper">
      <table class="param-table">
        <thead>
          <tr>
            <th width="20%">Parameter Name</th>
            <th width="15%">Category & Group</th>
            <th width="10%">Unit</th>
            <th width="35%">Reference Intervals</th>
            <th width="12%">Assay Method</th>
            <th width="8%" class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($params_res && $params_res->num_rows > 0): ?>
            <?php while ($row = $params_res->fetch_assoc()): ?>
              <tr>
                <td>
                  <div class="fw-bold text-dark"><?= htmlspecialchars($row['param_name']) ?></div>
                </td>
                <td>
                  <div class="small fw-semibold text-dark"><?= htmlspecialchars($row['category_name'] ?: 'Pathology') ?></div>
                  <div class="small text-muted"><?= htmlspecialchars($row['group_name'] ?: 'General') ?></div>
                </td>
                <td>
                  <span class="badge bg-light text-secondary border font-monospace">
                    <?= htmlspecialchars($row['unit'] ?: '-') ?>
                  </span>
                </td>
                <td>
                  <?php if (!empty($row['use_reference_text'])): ?>
                    <span class="badge bg-info bg-opacity-10 text-info-emphasis border border-info border-opacity-25 font-monospace">
                      <?= htmlspecialchars($row['reference_text'] ?: 'Descriptive') ?>
                    </span>
                  <?php else: ?>
                    <div class="small font-monospace">
                      <?php if ($row['male_min'] !== null || $row['male_max'] !== null): ?>
                        <span class="text-primary me-2">M: <?= $row['male_min'] ?? '-' ?> - <?= $row['male_max'] ?? '-' ?></span>
                      <?php endif; ?>
                      <?php if ($row['female_min'] !== null || $row['female_max'] !== null): ?>
                        <span class="text-danger me-2">F: <?= $row['female_min'] ?? '-' ?> - <?= $row['female_max'] ?? '-' ?></span>
                      <?php endif; ?>
                    </div>
                  <?php endif; ?>
                </td>
                <td>
                  <span class="small text-muted"><?= htmlspecialchars($row['method'] ?: 'Standard') ?></span>
                </td>
                <td class="text-end">
                  <div class="d-flex align-items-center justify-content-end gap-1">
                    <a href="test_parameters.php?edit=<?= $row['parameter_id'] ?>" class="btn btn-sm btn-outline-warning" title="Edit Parameter">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <a href="test_parameters.php?delete=<?= $row['parameter_id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete parameter \'<?= htmlspecialchars(addslashes($row['param_name'])) ?>\'?')" title="Delete Parameter">
                      <i class="bi bi-trash"></i>
                    </a>
                  </div>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center py-5">
                <i class="bi bi-sliders fa-3x text-muted mb-2 d-block opacity-50"></i>
                <h6 class="fw-bold text-secondary">No Parameters Found</h6>
                <p class="small text-muted mb-0">Use the form above to register laboratory analytes and reference ranges.</p>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
      <nav class="mt-3">
        <ul class="pagination pagination-sm justify-content-center mb-0">
          <?php for ($p = 1; $p <= $total_pages; $p++): ?>
            <li class="page-item <?= ($p == $page) ? 'active' : '' ?>">
              <a class="page-link" href="test_parameters.php?page=<?= $p ?>&search=<?= urlencode($search) ?>&group=<?= $filter_group ?>">
                <?= $p ?>
              </a>
            </li>
          <?php endfor; ?>
        </ul>
      </nav>
    <?php endif; ?>

  </div>

</div>

<!-- Scripts -->
<script>
function toggleRefRangeMode() {
  const isText = document.getElementById('useRefText').checked;
  if (isText) {
    document.getElementById('numericRangesRow').style.display = 'none';
    document.getElementById('textRangeRow').style.display = 'block';
  } else {
    document.getElementById('numericRangesRow').style.display = 'flex';
    document.getElementById('textRangeRow').style.display = 'none';
  }
}
</script>

</body>
</html>
