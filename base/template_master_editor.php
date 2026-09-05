<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Template Editor - Lab Report</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .template-preview {
      border: 1px solid #ccc;
      padding: 20px;
      min-height: 300px;
      background-color: #f9f9f9;
      font-family: Arial, sans-serif;
    }
    textarea.code-editor {
      font-family: monospace;
      min-height: 300px;
    }
  </style>
</head>
<body>
  <div class="container py-4">
    <h2 class="mb-4">📝 Lab Report Template Editor</h2>

    <form method="POST" action="save_template.php">
      <div class="mb-3">
        <label for="template_name" class="form-label">Template Name</label>
        <input type="text" class="form-control" id="template_name" name="template_name" required>
      </div>

      <div class="mb-3">
        <label for="test_name" class="form-label">Associated Test/Package</label>
        <input type="text" class="form-control" id="test_name" name="test_name" placeholder="e.g. CBC, LFT, Basic Panel">
      </div>

      <div class="mb-3">
        <label for="template_html" class="form-label">HTML Template Code</label>
        <textarea class="form-control code-editor" id="template_html" name="template_html" required>
<!-- Example Template -->
<h4>{{patient_name}} - {{gender}} ({{age}})</h4>
<p>Report Date: {{report_date}}</p>

<h5>{{test_name}}</h5>
<table class="table table-bordered">
  <thead><tr><th>Group</th><th>Parameter</th><th>Result</th><th>Unit</th><th>Range</th></tr></thead>
  <tbody>
    {{test_results}}
  </tbody>
</table>

<p>Doctor: {{doctor_name}}</p>
<img src="{{signature}}" style="height: 80px">
<img src="{{stamp}}" style="height: 80px">
<p><img src="{{qr_code}}" width="100"></p>
        </textarea>
      </div>

      <button type="submit" class="btn btn-primary">💾 Save Template</button>
    </form>

    <hr>

    <h4 class="mt-4">Live Preview</h4>
    <div class="template-preview mt-3" id="live_preview"></div>
  </div>

  <script>
    const editor = document.getElementById('template_html');
    const preview = document.getElementById('live_preview');

    editor.addEventListener('input', () => {
      preview.innerHTML = editor.value
        .replace(/{{patient_name}}/g, 'John Doe')
        .replace(/{{gender}}/g, 'Male')
        .replace(/{{age}}/g, '35')
        .replace(/{{report_date}}/g, '2025-05-26')
        .replace(/{{test_name}}/g, 'Complete Blood Count')
        .replace(/{{test_results}}/g, `
          <tr><td>Hematology</td><td>Hemoglobin<br><small>Method: Cyanmethemoglobin</small></td><td><strong style='color:red'>8.5</strong></td><td>g/dL</td><td>13.0-17.0</td></tr>
          <tr><td>Hematology</td><td>WBC Count</td><td>6,500</td><td>cells/cmm</td><td>4,000 - 11,000</td></tr>
        `)
        .replace(/{{doctor_name}}/g, 'Dr. A. Kumar')
        .replace(/{{signature}}/g, 'doctor-signature.png')
        .replace(/{{stamp}}/g, 'hospital-stamp.png')
        .replace(/{{qr_code}}/g, 'qr-download.png');
    });

    // Trigger preview at start
    editor.dispatchEvent(new Event('input'));
  </script>
</body>
</html>
