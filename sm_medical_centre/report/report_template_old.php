<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Lab Report</title>
  <style>
    body { font-family: Arial; margin: 20px; }
    .container { border: 1px solid #ccc; padding: 20px; max-width: 850px; margin: auto; }
    .header { display: flex; justify-content: space-between; }
    .photo { width: 90px; height: 110px; border: 1px solid #000; object-fit: cover; }
    .patient-info { flex: 1; padding: 0 20px; }
    .report-meta { text-align: right; }
    .qrcode { margin-top: 10px; width: 40mm; height: 40mm; background: #eee; line-height: 40mm; text-align: center; font-size: 12px; color: #999; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #000; padding: 6px; text-align: left; font-size: 13px; }
    th { background-color: #f0f0f0; }
    .method { font-size: 11px; font-style: italic; color: #555; }
    .interpretation, .note { margin-top: 15px; padding: 10px; border: 1px solid #000; background: #f9f9f9; }
    .signature { text-align: right; margin-top: 50px; }
    .signature img { height: 50px; }
  </style>
</head>
<body>
<div class="container">

  <div class="header">
    <img src="assets/photos/default.jpg" class="photo" alt="Patient">
    <div class="patient-info">
      <table>
        <tr><td><strong>Name</strong></td><td>:</td><td><?= $bill['full_name'] ?></td></tr>
        <tr><td><strong>Age</strong></td><td>:</td><td><?= $bill['age'] ?></td></tr>
        <tr><td><strong>Gender</strong></td><td>:</td><td><?= ucfirst($bill['gender']) ?></td></tr>
        <tr><td><strong>Phone</strong></td><td>:</td><td><?= $bill['phone'] ?></td></tr>
      </table>
    </div>
    <div class="report-meta">
      <div><strong>ID:</strong> <?= $bill['patient_id'] ?></div>
      <div><strong>Date:</strong> <?= $bill['bill_date'] ?></div>
      <div class="qrcode">QR CODE</div>
    </div>
  </div>

  <?php foreach ($all_params as $test_name => $params): ?>
  <h2 style="text-align:center;"><?= htmlspecialchars($test_name) ?></h2>
  <table>
    <tr><th>Parameter</th><th>Result</th><th>Unit</th><th>Ref. Range</th></tr>
    <?php foreach ($params as $p): ?>
      <tr>
        <td>
          <?= htmlspecialchars($p['param_name']) ?>
          <?php if (!empty($p['method'])): ?>
            <div class="method">Method: <?= htmlspecialchars($p['method']) ?></div>
          <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($p['result_value'] ?? '-') ?></td>
        <td><?= htmlspecialchars($p['unit']) ?></td>
        <td><?= $p['ref_range'] ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php endforeach; ?>

  <div class="interpretation"><strong>Interpretation:</strong><br>Auto-generated or from template if exists.</div>
  <div class="note"><strong>Note:</strong> Default note or package-specific notes.</div>
  <div class="signature">
    <strong>Doctor's Signature</strong><br>
    <img src="assets/signatures/default.png" alt="Signature">
  </div>
</div>
</body>
</html>
