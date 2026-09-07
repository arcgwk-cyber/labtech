<?php
/**
 * AJAX Rate Card Update Handler
 * Supports:
 *   1. Single test or package rate update (in-place inline editing)
 *   2. Bulk tariff adjustments (percentage increase/decrease or flat rate adjustments)
 */
include_once 'auth_check.php';
include_once 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$action = $_POST['action'] ?? 'update_single';

// ============================================================================
// 1. SINGLE RATE UPDATE (TEST OR PACKAGE)
// ============================================================================
if ($action === 'update_single') {
    $type = trim($_POST['type'] ?? 'test'); // 'test' or 'package'
    $id = (int)($_POST['id'] ?? 0);
    $price = isset($_POST['price']) ? (float)$_POST['price'] : -1;

    if ($id <= 0 || $price < 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid ID or rate amount. Rate must be 0 or greater.']);
        exit;
    }

    try {
        if ($type === 'package') {
            $stmt = $conn->prepare("UPDATE test_packages SET package_price = ? WHERE package_id = ?");
            $stmt->bind_param("di", $price, $id);
            $stmt->execute();
            $stmt->close();

            echo json_encode([
                'success' => true,
                'type' => 'package',
                'id' => $id,
                'price' => $price,
                'formatted_price' => number_format($price, 2),
                'message' => 'Package tariff updated to ₹' . number_format($price, 2)
            ]);
            exit;
        } else {
            // Default: individual test
            $stmt = $conn->prepare("UPDATE lab_tests SET price = ? WHERE test_id = ?");
            $stmt->bind_param("di", $price, $id);
            $stmt->execute();
            $stmt->close();

            echo json_encode([
                'success' => true,
                'type' => 'test',
                'id' => $id,
                'price' => $price,
                'formatted_price' => number_format($price, 2),
                'message' => 'Test tariff updated to ₹' . number_format($price, 2)
            ]);
            exit;
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        exit;
    }
}

// ============================================================================
// 2. BULK TARIFF ADJUSTMENT (ALL OR BY DEPARTMENT)
// ============================================================================
if ($action === 'bulk_adjust') {
    $category_id = (int)($_POST['category_id'] ?? 0); // 0 = all categories
    $adjust_type = trim($_POST['adjust_type'] ?? 'percent_add'); // percent_add, percent_sub, flat_add, flat_sub
    $adjust_val = (float)($_POST['adjust_value'] ?? 0);
    $round_to = (int)($_POST['round_to'] ?? 0); // 0, 5, or 10

    if ($adjust_val <= 0) {
        echo json_encode(['success' => false, 'message' => 'Adjustment value must be greater than 0.']);
        exit;
    }

    try {
        $where = ($category_id > 0) ? "WHERE category_id = {$category_id}" : "";
        $query = "SELECT test_id, price FROM lab_tests {$where}";
        $res = $conn->query($query);

        if (!$res || $res->num_rows === 0) {
            echo json_encode(['success' => false, 'message' => 'No tests found matching the selected scope.']);
            exit;
        }

        $tests = $res->fetch_all(MYSQLI_ASSOC);
        $updated_count = 0;
        $updated_items = [];

        $conn->begin_transaction();

        $stmt = $conn->prepare("UPDATE lab_tests SET price = ? WHERE test_id = ?");

        foreach ($tests as $t) {
            $curr = (float)$t['price'];
            $new = $curr;

            if ($adjust_type === 'percent_add') {
                $new = $curr + ($curr * ($adjust_val / 100));
            } elseif ($adjust_type === 'percent_sub') {
                $new = max(0, $curr - ($curr * ($adjust_val / 100)));
            } elseif ($adjust_type === 'flat_add') {
                $new = $curr + $adjust_val;
            } elseif ($adjust_type === 'flat_sub') {
                $new = max(0, $curr - $adjust_val);
            }

            // Optional rounding
            if ($round_to === 5) {
                $new = round($new / 5) * 5;
            } elseif ($round_to === 10) {
                $new = round($new / 10) * 10;
            } else {
                $new = round($new, 2);
            }

            $tid = (int)$t['test_id'];
            $stmt->bind_param("di", $new, $tid);
            $stmt->execute();
            $updated_count++;
            $updated_items[$tid] = number_format($new, 2, '.', '');
        }

        $stmt->close();
        $conn->commit();

        echo json_encode([
            'success' => true,
            'updated_count' => $updated_count,
            'updated_items' => $updated_items,
            'message' => "Successfully adjusted rates for {$updated_count} tests."
        ]);
        exit;

    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Bulk adjustment failed: ' . $e->getMessage()]);
        exit;
    }
}

echo json_encode(['success' => false, 'message' => 'Unknown action']);
exit;