<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sample Collected - Result Entry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 40px;
        }
        h3 {
            margin-bottom: 25px;
        }
    </style>
</head>
<body>
<div class="container">
    <h3 class="text-center">Sample Collected - Ready for Result Entry</h3>

    <?php
	require_once 'db.php';
    $sql = "
        SELECT b.bill_id, p.full_name,p.gender,p.date_of_birth,p.phone, b.bill_date 
        FROM bills b
        JOIN patients p ON p.patient_id = b.patient_id
        JOIN test_samples ts ON ts.bill_id = b.bill_id
        WHERE ts.status = 'Collected'
        ORDER BY b.bill_date DESC
    ";

    $result = $conn->query($sql);

    if (!$result) {
        echo "<div class='alert alert-danger'>Query error: " . $conn->error . "</div>";
    } elseif ($result->num_rows > 0) {
        echo "<table class='table table-striped table-bordered'>";
        echo "<thead class='table-dark'><tr><th>#</th><th>id</th><th>Bill Date</th><th>Patient Name</th><th>Gender</th><th>DOB</th><th>Phone</th><th>Action</th></tr></thead><tbody>";
        $i = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$i}</td>
				<td>{$row ['bill_id']}</td>
				<td>{$row['bill_date']}</td>
                <td>{$row['full_name']}</td>
                <td>{$row['gender']}</td>
				<td>{$row['date_of_birth']}</td>
				<td>{$row['phone']}</td>
                <td><a href='result_entry.php?bill_id={$row['bill_id']}' class='btn btn-primary btn-sm'>Enter Results</a></td>
            </tr>";
            $i++;
        }
        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-info'>No samples collected yet for result entry.</div>";
    }
    ?>
</div>
</body>
</html>
