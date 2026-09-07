<?php
require_once("db.php");

$template_id = $_GET['template_id'] ?? 0;

if($template_id > 0) {
    $stmt = $conn->prepare("
        SELECT layout_json 
        FROM report_templates 
        WHERE template_id = ?
    ");
    $stmt->bind_param("i", $template_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $template = $result->fetch_assoc();
    $stmt->close();
    
    if($template && !empty($template['layout_json'])) {
        $layout = json_decode($template['layout_json'], true);
        
        echo '<table class="preview-table">';
        echo '<thead><tr>';
        
        // Table headers
        foreach($layout['columns'] as $col) {
            echo '<th>' . htmlspecialchars($col['label']) . '</th>';
        }
        echo '</tr></thead>';
        
        echo '<tbody>';
        // Sample rows for preview
        $sample_rows = [
            [
                'param_name' => 'Hemoglobin',
                'result' => '14.2',
                'unit' => 'g/dL',
                'reference' => '13.5-17.5',
                'flag' => '<span class="status-badge status-normal">Normal</span>',
                'method' => 'Automated Analyzer'
            ],
            [
                'param_name' => 'Glucose',
                'result' => '110',
                'unit' => 'mg/dL',
                'reference' => '70-100',
                'flag' => '<span class="status-badge status-abnormal">High</span>',
                'method' => 'Enzymatic'
            ]
        ];
        
        foreach($sample_rows as $row) {
            echo '<tr>';
            foreach($layout['columns'] as $col) {
                $key = $col['key'];
                if($key === 'param_name' && isset($layout['method_under_test']) && $layout['method_under_test']) {
                    echo '<td>';
                    echo '<div style="font-weight: bold;">' . htmlspecialchars($row[$key]) . '</div>';
                    if(isset($row['method'])) {
                        $font_size = isset($layout['method_font_size']) ? $layout['method_font_size'] : 'small';
                        $color = isset($layout['method_color']) ? $layout['method_color'] : '#666666';
                        $italic = isset($layout['method_italic']) && $layout['method_italic'] ? 'font-style: italic;' : '';
                        
                        echo '<div class="method-text" style="font-size: ' . $font_size . '; color: ' . $color . '; ' . $italic . '">';
                        echo htmlspecialchars($row['method']);
                        echo '</div>';
                    }
                    echo '</td>';
                } else {
                    $value = $row[$key] ?? '';
                    // Handle flag field specially
                    if($key === 'flag' && isset($row['flag'])) {
                        echo '<td>' . $row['flag'] . '</td>';
                    } else {
                        echo '<td>' . htmlspecialchars($value) . '</td>';
                    }
                }
            }
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        
        // Show layout info
        echo '<div class="mt-3 text-muted">';
        echo '<small>';
        echo 'Columns: ' . count($layout['columns']) . ' | ';
        echo 'Method Display: ' . (isset($layout['method_under_test']) && $layout['method_under_test'] ? 'Enabled' : 'Disabled') . ' | ';
        echo 'Borders: ' . (isset($layout['show_border']) && $layout['show_border'] ? 'Yes' : 'No');
        echo '</small>';
        echo '</div>';
    } else {
        echo '<div class="text-center text-muted p-4">Template preview not available</div>';
    }
} else {
    echo '<div class="text-center text-muted p-4">Select a template to preview</div>';
}
?>