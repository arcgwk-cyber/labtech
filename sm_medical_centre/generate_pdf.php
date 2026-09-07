
<?php
require 'vendor/autoload.php';
require 'db.php';

use Dompdf\Dompdf;

function getTemplate($template_id) {
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT html_content FROM templates WHERE template_id = ?");
    $stmt->bind_param("i", $template_id);
    $stmt->execute();
    $stmt->bind_result($html);
    $stmt->fetch();
    $stmt->close();
    return $html;
}

function getPatientResults($patient_id, $test_id) {
    global $mysqli;
    $query = "SELECT tp.param_name, tr.result_value, tp.unit, tp.method,
                     prr.min_value, prr.max_value
              FROM test_results tr
              JOIN test_parameters tp ON tr.parameter_id = tp.parameter_id
              LEFT JOIN parameter_reference_range prr ON tp.parameter_id = prr.parameter_id
              WHERE tr.patient_id = ? AND tr.test_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ii", $patient_id, $test_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $parameters = [];
    while ($row = $result->fetch_assoc()) {
        $flag = '';
        $val = $row['result_value'];
        if (is_numeric($val)) {
            if ($val < $row['min_value']) $flag = 'LOW';
            else if ($val > $row['max_value']) $flag = 'HIGH';
        } else if (in_array(strtoupper($val), ['POSITIVE', 'REACTIVE', 'ABNORMAL'])) {
            $flag = strtoupper($val);
        }
        $row['flag'] = $flag;
        $parameters[] = $row;
    }
    $stmt->close();
    return $parameters;
}

function getDoctorAssets($doctor_id) {
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT signature, stamp FROM doctors WHERE id = ?");
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $stmt->bind_result($sig, $stamp);
    $stmt->fetch();
    $stmt->close();
    return ['signature' => $sig, 'stamp' => $stamp];
}

$patient_id = $_GET['patient_id'];
$test_id = $_GET['test_id'];
$template_id = $_GET['template_id'];
$doctor_id = $_GET['doctor_id'];

$template = getTemplate($template_id);
$parameters = getPatientResults($patient_id, $test_id);
$doctor = getDoctorAssets($doctor_id);

$table = "<table border='1' cellpadding='4'><tr><th>Parameter</th><th>Value</th><th>Unit</th><th>Range</th><th>Flag</th></tr>";
foreach ($parameters as $p) {
    $flagStyle = $p['flag'] ? "font-weight:bold;color:red;" : "";
    $table .= "<tr>
        <td>{$p['param_name']}<br><small>{$p['method']}</small></td>
        <td style='{$flagStyle}'>{$p['result_value']}</td>
        <td>{$p['unit']}</td>
        <td>{$p['min_value']} - {$p['max_value']}</td>
        <td style='{$flagStyle}'>{$p['flag']}</td>
    </tr>";
}
$table .= "</table>";

$template = str_replace('{{results_table}}', $table, $template);
$template = str_replace('{{signature}}', "<img src='uploads/signatures/{$doctor['signature']}' width='120'/>", $template);
$template = str_replace('{{stamp}}', "<img src='uploads/signatures/{$doctor['stamp']}' width='100'/>", $template);

$dompdf = new Dompdf();
$dompdf->loadHtml($template);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("lab_report.pdf", array("Attachment" => false));
?>
