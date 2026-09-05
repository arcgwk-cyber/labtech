<?php
require_once("db.php");

$template_id = $_GET['id'];

$template = $conn->query("
SELECT layout_json FROM report_templates 
WHERE template_id=$template_id
")->fetch_assoc();

$layout = json_decode($template['layout_json'], true);

echo "<div style='font-size:".$layout['style']['font_size']."px;'>";

foreach($layout['sections'] as $section){

switch($section){

case "header":
echo "<h3>Patient Name: Demo Patient</h3>";
break;

case "extra_fields":
echo "<p>Passport: A1234567</p>";
break;

case "test_table":
echo "<table border='1' width='100%'>
<tr>";
foreach($layout['columns'] as $col){
echo "<th>".strtoupper($col)."</th>";
}
echo "</tr>
<tr>";
foreach($layout['columns'] as $col){
echo "<td>Demo</td>";
}
echo "</tr></table>";
break;

case "signature":
echo "<img src='sign_stamp/sample.png' style='position:absolute; top:600px; left:400px; width:100px;'>";
break;

case "qr":
echo "<div style='position:absolute; top:600px; left:200px;'>QR</div>";
break;

}
}

echo "</div>";
