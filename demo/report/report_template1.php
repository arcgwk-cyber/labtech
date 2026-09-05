<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Lab Report</title>
  <style>
    body { font-family: Arial; margin: 20px; color: #000; }
    .container { border: 1px solid #ccc; padding: 20px; max-width: 850px; margin: auto; }
    .photo { width: 100px; height: 130px; border: 1px solid #000; object-fit: cover; }
    table.header-table { width: 100%; border: 1px solid #000; border-collapse: collapse; margin-bottom: 20px; }
    table.header-table td { border: 0px solid #000; padding: 6px; vertical-align: top; }
    .patient-info-table td { padding: 3px; font-size: 13px; }
    .qrcode { width: 20mm; height: 20mm; background: #eee; text-align: center; font-size: 12px; color: #999; line-height: 20mm; }

    h2 { text-align: center; margin: 20px 0 10px; }

    table.report-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    .report-table th, .report-table td { border: 1px solid #000; padding: 6px; font-size: 13px; }
    .report-table th { background-color: #f0f0f0; }

    .method { font-size: 11px; font-style: italic; color: #555; }

    .interpretation, .note { margin-top: 15px; padding: 10px; border: 1px solid #000; background: #f9f9f9; }

    .signature { text-align: right; margin-top: 50px; }
    .signature img { height: 50px; }
  </style>
</head>
<body>
<div class="container">

  <!-- PATIENT HEADER TABLE -->
  <table class="header-table">
    <tr>
      <!-- PHOTO -->
      <td width="15%" align="center">
        <img src="assets/photos/default.jpg" alt="Photo" class="photo">
      </td>

      <!-- PATIENT INFO -->
      <td width="65%">
        <table class="patient-info-table" border-collapse: collapse;>
          <tr><td><strong>Name</strong></td><td>:</td><td><?= $bill['full_name'] ?></td></tr>
          <tr><td><strong>Age</strong></td><td>:</td><td><?= $bill['age'] ?></td></tr>
          <tr><td><strong>Gender</strong></td><td>:</td><td><?= ucfirst($bill['gender']) ?></td></tr>
          <tr><td><strong>Phone</strong></td><td>:</td><td><?= $bill['phone'] ?></td></tr>
        </table>
      </td>

      <!-- ID / DATE / QR -->
      <td width="20%" align="right">
        <div><strong>ID:</strong> <?= $bill['patient_id'] ?></div>
        <div><strong>Date:</strong> <?= $bill['bill_date'] ?></div>
        <div class="qrcode">QR CODE</div>
      </td>
    </tr>
  </table>

  <!-- TEST DATA TABLES -->
 <?php foreach ($grouped_params as $group => $tests): ?>
  <h2><?= htmlspecialchars($group) ?></h2>

  <?php foreach ($tests as $test_name => $params): ?>
    <h3 style="margin-top: 10px;"><?= htmlspecialchars($test_name) ?></h3>
    <table class="report-table">
      <thead>
        <tr><th>Parameter</th><th>Result</th><th>Unit</th><th>Ref. Range</th></tr>
      </thead>
      <tbody>
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
      </tbody>
    </table>
  <?php endforeach; ?>
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
