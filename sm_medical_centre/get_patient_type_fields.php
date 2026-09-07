<?php
include 'db.php';

if (isset($_POST['patient_type_id'])) {
    $patient_type_id = (int)$_POST['patient_type_id'];

    // fetch field definitions for the patient type
    $result = $conn->query("SELECT field_id, field_label, field_type 
                            FROM patient_type_fields 
                            WHERE type_id = $patient_type_id");

    while ($row = $result->fetch_assoc()) {
        $fieldId    = (int)$row['field_id'];
        $label      = htmlspecialchars($row['field_label']);
        $inputType  = !empty($row['field_type']) ? $row['field_type'] : 'text';

        echo '<div class="dynamic-field mb-3">';
        echo '  <label class="form-label">' . $label . '</label>';
        echo '  <input type="' . $inputType . '" name="extra[' . $fieldId . ']" class="form-control">';
        echo '</div>';
    }
}
?>
