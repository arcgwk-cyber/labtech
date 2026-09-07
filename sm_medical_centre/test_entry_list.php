<?php
include 'auth_check.php';
include 'db.php';

// Fetch bills that have pending test samples
$sql = "
  SELECT 
    b.bill_id, b.bill_date,
    p.full_name, p.gender, p.date_of_birth,
    ts.status
  FROM test_samples ts
  JOIN bills b ON b.bill_id = ts.bill_id
  JOIN patients p ON p.patient_id = b.patient_id
  WHERE ts.status = 'Collected'
  ORDER BY b.bill_date DESC
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Pending Test Entries</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }

    .container {
      max-width: 1000px;
      margin-top: 40px;
    }

    .card {
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .card-header {
      background: #0d6efd;
      color: white;
      font-weight: bold;
      font-size: 1.1rem;
    }

    .table th,
    .table td {
      vertical-align: middle;
      font-size: clamp(0.75rem, 1vw, 0.95rem);
    }

    .btn-sm {
      font-size: 0.8rem;
      padding: 4px 10px;
    }

    @media (max-width: 768px) {
      .table-responsive {
        overflow-x: auto;
      }

      .card-header {
        font-size: 1rem;
        text-align: center;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <div class="card-header">🧪 Smaples Collected Result Pending</div>
      <div class="card-body">
        <?php if ($result->num_rows > 0): ?>
          <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-center">
              <thead class="table-light">
                <tr>
                  <th>Bill ID</th>
                  <th>Patient Name</th>
                  <th>Gender</th>
                  <th>Bill Date</th>
                  <th>Action</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
              <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td><?= $row['bill_id'] ?></td>
                  <td><?= htmlspecialchars($row['full_name']) ?></td>
                  <td><?= ucfirst($row['gender']) ?></td>
                  <td><?= $row['bill_date'] ?></td>
                  <td>
                      <a href="result_entry.php?bill_id=<?= $row['bill_id'] ?>" class="btn btn-sm btn-primary">
                      Enter Results
                    </a>
                  </td>
                  <td>
                    <span class="badge bg-warning text-dark"><?= $row['status'] ?></span>
                  </td>
                </tr>
              <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="alert alert-info text-center">
            No pending test samples found.
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
