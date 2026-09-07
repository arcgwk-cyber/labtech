<?php
/**
 * Diagnostic Report Helper
 * Handles token generation/decoding, per-bill report preference persistence (DB + JSON file cache),
 * and multi-tiered preference hierarchy resolution.
 */

if (!function_exists('decodeID')) {
    function decodeID($token, $key = 987654321) {
        if (empty($token)) return 0;
        return hexdec(strtolower(trim($token))) ^ $key;
    }
}

if (!function_exists('encodeID')) {
    function encodeID($id, $key = 987654321) {
        return strtoupper(dechex(((int)$id) ^ $key));
    }
}

if (!function_exists('getLetterheadImageFile')) {
    function getLetterheadImageFile() {
        $candidates = [
            __DIR__ . '/letterhead.jpg',
            __DIR__ . '/letterhead.png',
            __DIR__ . '/letterhead.jpeg',
            __DIR__ . '/letterhead.webp',
            __DIR__ . '/qrtemp/letterhead.jpg',
            __DIR__ . '/qrtemp/letterhead.png',
            __DIR__ . '/qrtemp/letterhead.jpeg',
            __DIR__ . '/qrtemp/letterhead.webp',
            __DIR__ . '/uploads/letterhead.jpg',
            __DIR__ . '/uploads/letterhead.png',
            __DIR__ . '/uploads/letterhead.jpeg',
            __DIR__ . '/uploads/letterhead.webp'
        ];
        if (basename(__DIR__) === 'demo') {
            $candidates[] = __DIR__ . '/ammaletterhead.jpg';
        }
        foreach ($candidates as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }
        return null;
    }
}

if (!function_exists('getBillReportOptions')) {
    function getBillReportOptions($bill_id, $conn) {
        $bill_id = (int)$bill_id;
        if ($bill_id <= 0) return null;

        $options = null;

        // 1. Try reading from Database
        if ($conn) {
            $stmt = @$conn->prepare("SELECT style, header_mode, include_method, include_notes, include_interpretation, pagebreak_per_test, include_signature FROM bill_report_options WHERE bill_id = ? LIMIT 1");
            if ($stmt) {
                $stmt->bind_param("i", $bill_id);
                $stmt->execute();
                $res = $stmt->get_result();
                if ($row = $res->fetch_assoc()) {
                    $options = [
                        'style'                  => $row['style'],
                        'header_mode'            => $row['header_mode'],
                        'include_method'         => (bool)$row['include_method'],
                        'include_notes'          => (bool)$row['include_notes'],
                        'include_interpretation' => (bool)$row['include_interpretation'],
                        'pagebreak_per_test'     => (bool)$row['pagebreak_per_test'],
                        'include_signature'      => (bool)$row['include_signature']
                    ];
                }
                $stmt->close();
            }
        }

        // 2. Fallback to file storage if not in DB
        if ($options === null) {
            $file = __DIR__ . '/report_options/bill_' . $bill_id . '.json';
            if (file_exists($file)) {
                $decoded = json_decode(file_get_contents($file), true);
                if (is_array($decoded)) {
                    $options = $decoded;
                }
            }
        }

        return $options;
    }
}

if (!function_exists('saveBillReportOptions')) {
    function saveBillReportOptions($bill_id, $options, $conn) {
        $bill_id = (int)$bill_id;
        if ($bill_id <= 0 || !is_array($options)) return false;

        $style      = $options['style'] ?? 'clinical';
        $hmode      = $options['header_mode'] ?? 'printed';
        $imethod    = !empty($options['include_method']) ? 1 : 0;
        $inotes     = !empty($options['include_notes']) ? 1 : 0;
        $iinterp    = !empty($options['include_interpretation']) ? 1 : 0;
        $ipagebreak = !empty($options['pagebreak_per_test']) ? 1 : 0;
        $isig       = !empty($options['include_signature']) ? 1 : 0;

        // 1. Save to DB table
        if ($conn) {
            @$conn->query("
                CREATE TABLE IF NOT EXISTS `bill_report_options` (
                  `bill_id` int(11) NOT NULL PRIMARY KEY,
                  `style` varchar(32) DEFAULT 'clinical',
                  `header_mode` varchar(32) DEFAULT 'printed',
                  `include_method` tinyint(1) DEFAULT 0,
                  `include_notes` tinyint(1) DEFAULT 1,
                  `include_interpretation` tinyint(1) DEFAULT 1,
                  `pagebreak_per_test` tinyint(1) DEFAULT 0,
                  `include_signature` tinyint(1) DEFAULT 1,
                  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
            ");

            $stmt = @$conn->prepare("
                INSERT INTO bill_report_options (bill_id, style, header_mode, include_method, include_notes, include_interpretation, pagebreak_per_test, include_signature)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                  style = VALUES(style),
                  header_mode = VALUES(header_mode),
                  include_method = VALUES(include_method),
                  include_notes = VALUES(include_notes),
                  include_interpretation = VALUES(include_interpretation),
                  pagebreak_per_test = VALUES(pagebreak_per_test),
                  include_signature = VALUES(include_signature)
            ");
            if ($stmt) {
                $stmt->bind_param("issiiiii", $bill_id, $style, $hmode, $imethod, $inotes, $iinterp, $ipagebreak, $isig);
                $stmt->execute();
                $stmt->close();
            }
        }

        // 2. Also save to filesystem cache for high-availability
        $dir = __DIR__ . '/report_options';
        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }
        @file_put_contents($dir . '/bill_' . $bill_id . '.json', json_encode($options, JSON_PRETTY_PRINT));
        return true;
    }
}

if (!function_exists('getEffectiveReportOptions')) {
    function getEffectiveReportOptions($bill_id, $conn, $url_params = []) {
        $letterhead_image = getLetterheadImageFile();
        $fallback_header = ($letterhead_image !== null) ? 'letterhead_image' : 'printed';

        // Tier 4: Base fallback defaults
        $options = [
            'style'                  => 'clinical',
            'header_mode'            => $fallback_header,
            'include_method'         => false,
            'include_notes'          => true,
            'include_interpretation' => true,
            'pagebreak_per_test'     => false,
            'include_signature'      => true
        ];

        // Tier 3: Lab global default preferences (report_preferences.json)
        $pref_file = __DIR__ . '/report_preferences.json';
        if (file_exists($pref_file)) {
            $saved = json_decode(file_get_contents($pref_file), true);
            if (is_array($saved)) {
                $options = array_merge($options, $saved);
            }
        }

        // Tier 2: Specific custom options saved for THIS bill_id
        if ($bill_id > 0) {
            $bill_opts = getBillReportOptions($bill_id, $conn);
            if (is_array($bill_opts) && !empty($bill_opts)) {
                $options = array_merge($options, $bill_opts);
            }
        }

        // Tier 1: Explicit URL query parameters (e.g. while previewing/testing in pdf_options.php with applied=1)
        if (!empty($url_params['applied'])) {
            if (isset($url_params['style'])) $options['style'] = $url_params['style'];
            if (isset($url_params['header_mode'])) $options['header_mode'] = $url_params['header_mode'];
            if (isset($url_params['include_method'])) $options['include_method'] = (bool)$url_params['include_method'];
            if (isset($url_params['include_notes'])) $options['include_notes'] = (bool)$url_params['include_notes'];
            if (isset($url_params['include_interpretation'])) $options['include_interpretation'] = (bool)$url_params['include_interpretation'];
            if (isset($url_params['pagebreak_per_test'])) $options['pagebreak_per_test'] = (bool)$url_params['pagebreak_per_test'];
            if (isset($url_params['include_signature'])) $options['include_signature'] = (bool)$url_params['include_signature'];
        }

        return $options;
    }
}
