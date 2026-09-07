<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Lab Report</title>
  <style>
    body { font-family: Arial; margin: 20px; color: #000; }
    .container { border: 1px solid #ccc; padding: 40px; max-width: 850px; margin: auto; }
    .photo { width: 110px; height: 130px; border: 1px solid #000; object-fit: cover; }
    table.header-table { width: 100%; border: 1px solid #000; border-collapse: collapse; margin-bottom: 20px; }
    table.header-table td { border: 0px solid #000; padding: 6px; vertical-align: top; }
    .patient-info-table td { padding: 3px; font-size: 13px; }
    .qrcode { width: 25mm; height: 25mm; background: #eee; text-align: center; font-size: 12px; color: #999; line-height: 20mm; }

    h2 { text-align: center; margin: 20px 0 10px; }

    table.report-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    .report-table th, .report-table td { border: 1px solid #000; padding: 6px; font-size: 13px; }
    .report-table th { background-color: #f0f0f0; }

    .method { font-size: 11px; font-style: italic; color: #555; }

    .interpretation, .note { margin-top: 15px; padding: 10px; border: 1px solid #000; background: #f9f9f9; }

    .signature { text-align: right; margin-top: 50px; }
    .signature img { height: 50px; }
	.btn {
  padding: 8px 16px;
  font-size: 14px;
  border-radius: 4px;
  text-decoration: none;
  display: inline-block;
  cursor: pointer;
}
.btn-secondary { background: #6c757d; color: #fff; }
.btn-primary { background: #007bff; color: #fff; }
.btn-success { background: #28a745; color: #fff; }
.btn:hover { opacity: 0.9; }
@media print {
  /* Hide buttons on print */
  .action-buttons {
    display: none !important;
  }
}
@media print, screen {
  .action-buttons {
    display: block;
  }
}

@media dompdf {
  .action-buttons {
    display: none !important;
  }
}

  </style>
</head>
<body>
<div class="container">

  <!-- PATIENT HEADER TABLE -->
  <table class="header-table">
    <tr>
      <!-- PHOTO -->
      <td width="20%" align="center">
        <img src="assets/photos/default.jpg" alt="Photo" class="photo">
      </td>

      <!-- PATIENT INFO -->
      <td width="60%">
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
    <?php
      $value = trim($p['result_value'] ?? '');
      $isBold = false;

      // Check abnormal flags
      if (in_array(strtolower($value), ['abnormal', 'reactive', 'positive'])) {
          $isBold = true;
      }

      // Check numeric range
      $min = $max = null;
      if (preg_match('/([\d.]+)\s*-\s*([\d.]+)/', $p['ref_range'], $matches)) {
          $min = floatval($matches[1]);
          $max = floatval($matches[2]);
          if (is_numeric($value)) {
              $numeric_value = floatval($value);
              if ($numeric_value < $min || $numeric_value > $max) {
                  $isBold = true;
              }
          }
      }

      $display_result = $isBold ? "<strong>" . htmlspecialchars($value) . "</strong>" : htmlspecialchars($value);
    ?>
    <tr>
      <td>
        <?= htmlspecialchars($p['param_name']) ?>
        <?php if (!empty($p['method'])): ?>
          <div class="method">Method: <?= htmlspecialchars($p['method']) ?></div>
        <?php endif; ?>
      </td>
      <td><?= $display_result ?></td>
      <td><?= htmlspecialchars($p['unit']) ?></td>
      <td><?= htmlspecialchars($p['ref_range']) ?></td>
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
<!-- ACTION BUTTONS -->
<div class="action-buttons" style="margin-top: 30px; text-align: center;">
  <a href="/dclab/test_entry_list.php" class="btn btn-secondary" style="margin-right: 10px;">← Back to List</a>
  <button onclick="window.print();" class="btn btn-primary" style="margin-right: 10px;">🖨️ Print</button>
  <a href="export_pdf.php?id=<?= $bill['bill_id'] ?>" class="btn btn-success">⬇️ Download PDF</a>
  
</div>


</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
async function downloadPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('p', 'pt', 'a4');

    // Clone content
    const content = document.querySelector('.container').cloneNode(true);
    const wrapper = document.createElement('div');
    wrapper.style.padding = '20px';
    wrapper.appendChild(content);

    // Style adjustments
    content.style.fontSize = '12px';

    // Use html2canvas for image conversion
    const canvas = await html2canvas(wrapper);
    const imgData = canvas.toDataURL('image/png');

    const imgProps = doc.getImageProperties(imgData);
    const pdfWidth = doc.internal.pageSize.getWidth();
    const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

    doc.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
    doc.save("lab_report_<?= $bill['bill_id'] ?>.pdf");
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

</body>
</html>
