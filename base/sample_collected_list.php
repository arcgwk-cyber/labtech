<?php
/**
 * Collected Samples Worklist
 * Redirects seamlessly to the modern Phlebotomy & Sample Collection Workstation (Collected Tab)
 * Preserves all search, date ranges, and status filters.
 */
include_once 'auth_check.php';

$params = $_GET;
$params['tab'] = 'collected';

if (isset($params['result_status'])) {
    if ($params['result_status'] === 'entered') {
        $params['result_filter'] = 'entered';
    } elseif ($params['result_status'] === 'not_entered') {
        $params['result_filter'] = 'pending';
    }
    unset($params['result_status']);
}

$target = 'sample_collection.php?' . http_build_query($params);
header("Location: " . $target);
exit;
