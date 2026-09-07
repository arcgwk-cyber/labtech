<?php
echo "<h2>Common Issues Check</h2>";

// 1. Check PHP version
echo "1. PHP Version: " . phpversion() . "<br>";

// 2. Check if JSON extension is loaded
echo "2. JSON extension: " . (extension_loaded('json') ? '✓ Loaded' : '✗ Missing') . "<br>";

// 3. Check if mysqli is loaded
echo "3. MySQLi extension: " . (extension_loaded('mysqli') ? '✓ Loaded' : '✗ Missing') . "<br>";

// 4. Check file permissions
echo "4. File permissions (save_hardcoded_template.php): ";
if (file_exists('save_hardcoded_template.php')) {
    echo "✓ Exists, Permissions: " . substr(sprintf('%o', fileperms('save_hardcoded_template.php')), -4);
} else {
    echo "✗ Missing";
}
echo "<br>";

// 5. Check db.php
echo "5. db.php: ";
if (file_exists('db.php')) {
    // Try to include it
    try {
        require_once 'db.php';
        echo "✓ Exists and includes successfully";
    } catch (Exception $e) {
        echo "✗ Error including: " . $e->getMessage();
    }
} else {
    echo "✗ Missing";
}
echo "<br>";

// 6. Check output buffering
echo "6. Output buffering: " . (ob_get_level() > 0 ? 'Active' : 'Inactive') . "<br>";

// 7. Test JSON encoding
echo "7. JSON encoding test: ";
$test_array = ['test' => 'data'];
$json = json_encode($test_array);
if ($json) {
    echo "✓ Works: " . $json;
} else {
    echo "✗ Failed: " . json_last_error_msg();
}
echo "<br>";

// 8. Test file_get_contents
echo "8. file_get_contents test: ";
$test_content = file_get_contents(__FILE__);
if ($test_content !== false) {
    echo "✓ Works (read " . strlen($test_content) . " bytes)";
} else {
    echo "✗ Failed";
}
?>