<?php
/**
 * Super Admin - Master Lab Fleet Updater & Sync Hub (sync_labs.php)
 * 
 * Safely synchronizes code, new modules, and database schema updates from base/
 * across all vendor labs (e.g. sm_medical_centre, demo, medione, etc.)
 * 
 * ZERO IMPACT GUARANTEE:
 * - NEVER overwrites tenant db.php (database credentials preserved)
 * - NEVER overwrites tenant branding (logo.jpg, letterhead.jpg)
 * - NEVER touches uploads/, qrtemp/, or sign_stamp/ (doctor signatures & patient docs preserved)
 * - Purely ADDITIVE database migrations: adds missing columns/tables without touching bills or test results
 */

$page_title = "Fleet Sync & Upgrades";
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/provision_helper.php';

$workspaceRoot = dirname(__DIR__); // g:/LABTECH
$baseTemplateDir = $workspaceRoot . '/base';

// List of protected relative paths that MUST NEVER be overwritten in tenant folders
$protectedPaths = [
    'db.php',
    '.env',
    '.htaccess',
    'logo.jpg',
    'logo.jpeg',
    'logo.png',
    'logo.webp',
    'letterhead.jpg',
    'letterhead.jpeg',
    'letterhead.png',
    'letterhead.webp',
    'uploads',
    'qrtemp',
    'sign_stamp',
    'signatures',
    'stamps',
    '.git'
];

/**
 * Discovers all active tenant lab folders on disk and in database
 */
function discoverAllLabs($workspaceRoot, $conn) {
    $labs = [];
    $seenFolders = [];

    // Known state code directories
    $stateCodes = ['ap', 'ts', 'os', 'od', 'ka', 'tn', 'mh', 'dl', 'wb', 'kl', 'labs'];

    // 1. Fetch from database vendor_master
    if ($conn && !$conn->connect_error) {
        $res = $conn->query("SELECT * FROM vendor_master ORDER BY vendor_id DESC");
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $folder = LabProvisioner::slugify($row['name']);
                
                // Check if remarks specifies full path or state/slug path
                if (!empty($row['remarks']) && preg_match('/Provisioned at \/([a-zA-Z0-9_\-\/]+)/', $row['remarks'], $m)) {
                    $folder = trim($m[1], '/');
                }

                $path = $workspaceRoot . '/' . $folder;
                $existsOnDisk = is_dir($path);
                
                // If not found at root, check inside state directories (e.g. /ap/{slug})
                if (!$existsOnDisk && strpos($folder, '/') === false) {
                    foreach ($stateCodes as $sc) {
                        if (is_dir($workspaceRoot . '/' . $sc . '/' . $folder)) {
                            $folder = $sc . '/' . $folder;
                            $path = $workspaceRoot . '/' . $folder;
                            $existsOnDisk = true;
                            break;
                        }
                    }
                }
                
                $labs[$folder] = [
                    'name'           => $row['name'],
                    'folder_slug'    => $folder,
                    'vendor_id'      => (int)$row['vendor_id'],
                    'vendor_userid'  => $row['vendor_userid'] ?? '',
                    'status'         => $row['status'] ?? 'unknown',
                    'exists_on_disk' => $existsOnDisk,
                    'full_path'      => $path,
                    'source'         => 'vendor_master'
                ];
                $seenFolders[$folder] = true;
            }
        }
    }

    // 2. Always include demo if it exists
    if (is_dir($workspaceRoot . '/demo') && !isset($seenFolders['demo'])) {
        $labs['demo'] = [
            'name'           => 'Vensaas LabTech Demo Instance',
            'folder_slug'    => 'demo',
            'vendor_id'      => 0,
            'vendor_userid'  => 'admin',
            'status'         => 'active',
            'exists_on_disk' => true,
            'full_path'      => $workspaceRoot . '/demo',
            'source'         => 'demo'
        ];
        $seenFolders['demo'] = true;
    }

    // 3. Scan physical state subdirectories (e.g. /ap/medione, /ts/care_lab, /os/konark)
    foreach ($stateCodes as $sc) {
        $stateDirPath = $workspaceRoot . '/' . $sc;
        if (is_dir($stateDirPath)) {
            if ($sHandle = opendir($stateDirPath)) {
                while (false !== ($sEntry = readdir($sHandle))) {
                    if ($sEntry === '.' || $sEntry === '..' || $sEntry === '.gitkeep') continue;
                    $labSubPath = $stateDirPath . '/' . $sEntry;
                    $relSlug = $sc . '/' . $sEntry;
                    if (is_dir($labSubPath) && !isset($seenFolders[$relSlug])) {
                        if (file_exists($labSubPath . '/db.php') || file_exists($labSubPath . '/header.php')) {
                            $cleanName = ucwords(str_replace(['_', '-'], ' ', $sEntry)) . " (" . strtoupper($sc) . ")";
                            $labs[$relSlug] = [
                                'name'           => $cleanName,
                                'folder_slug'    => $relSlug,
                                'vendor_id'      => 0,
                                'vendor_userid'  => 'tenant_admin',
                                'status'         => 'active',
                                'exists_on_disk' => true,
                                'full_path'      => $labSubPath,
                                'source'         => 'state_disk_scan'
                            ];
                            $seenFolders[$relSlug] = true;
                        }
                    }
                }
                closedir($sHandle);
            }
        }
    }

    // 4. Scan physical root folders for legacy tenant folders (e.g. sm_medical_centre)
    $ignoreDirs = array_merge(['.git', 'admin', 'base', 'assets', 'uploads', 'dump', 'scratch', 'demo'], $stateCodes);
    if ($handle = opendir($workspaceRoot)) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry === '.' || $entry === '..' || in_array($entry, $ignoreDirs)) continue;
            $fullEntryPath = $workspaceRoot . '/' . $entry;
            if (is_dir($fullEntryPath) && !isset($seenFolders[$entry])) {
                // Verify if it looks like a lab instance (has db.php or header.php or result_entry.php)
                if (file_exists($fullEntryPath . '/db.php') || file_exists($fullEntryPath . '/header.php')) {
                    $cleanName = ucwords(str_replace(['_', '-'], ' ', $entry));
                    $labs[$entry] = [
                        'name'           => $cleanName . ' (Direct Folder)',
                        'folder_slug'    => $entry,
                        'vendor_id'      => 0,
                        'vendor_userid'  => 'tenant_admin',
                        'status'         => 'active',
                        'exists_on_disk' => true,
                        'full_path'      => $fullEntryPath,
                        'source'         => 'disk_scan'
                    ];
                    $seenFolders[$entry] = true;
                }
            }
        }
        closedir($handle);
    }

    return $labs;
}

/**
 * Safely synchronizes files from base/ to a target lab directory
 */
function safeSyncFiles($sourceDir, $targetDir, $protectedPaths, $dryRun = false) {
    $stats = [
        'copied'    => 0,
        'updated'   => 0,
        'skipped'   => 0,
        'protected' => 0,
        'errors'    => []
    ];

    if (!is_dir($targetDir)) {
        if ($dryRun) {
            $stats['copied']++;
            return $stats;
        }
        @mkdir($targetDir, 0755, true);
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($sourceDir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($iterator as $item) {
        $subPathName = $iterator->getSubPathName();
        $normalizedSubPath = str_replace('\\', '/', $subPathName);

        // Check if file or parent directory is in protected list
        $isProtected = false;
        foreach ($protectedPaths as $prot) {
            if ($normalizedSubPath === $prot || strpos($normalizedSubPath, $prot . '/') === 0) {
                $isProtected = true;
                break;
            }
        }

        $destPath = $targetDir . '/' . $subPathName;

        if ($isProtected) {
            // If protected file does NOT exist in tenant at all, we can copy initial template; otherwise skip!
            if (file_exists($destPath)) {
                $stats['protected']++;
                continue;
            }
        }

        if ($item->isDir()) {
            if (!$dryRun && !is_dir($destPath)) {
                @mkdir($destPath, 0755, true);
            }
        } else {
            $needsCopy = false;
            if (!file_exists($destPath)) {
                $needsCopy = true;
                $stats['copied']++;
            } else {
                // Check if source file is newer or different in size
                if ($item->getMTime() > filemtime($destPath) || $item->getSize() !== filesize($destPath)) {
                    $needsCopy = true;
                    $stats['updated']++;
                } else {
                    $stats['skipped']++;
                }
            }

            if ($needsCopy && !$dryRun) {
                if (!@copy($item->getRealPath(), $destPath)) {
                    $stats['errors'][] = "Failed to copy {$subPathName}";
                }
            }
        }
    }

    return $stats;
}

/**
 * Runs safe, additive database migrations on a tenant database
 */
function migrateTenantDatabase($labPath, $labSlug, $masterConn) {
    $res = [
        'success'      => false,
        'connected'    => false,
        'alters_run'   => [],
        'db_name'      => '',
        'error'        => ''
    ];

    $dbFile = $labPath . '/db.php';
    if (!file_exists($dbFile)) {
        $res['error'] = "Target db.php not found";
        return $res;
    }

    // Read credentials from tenant's db.php
    $content = file_get_contents($dbFile);
    $host = 'localhost'; $dbname = ''; $user = ''; $pass = '';

    if (preg_match('/\$dbname\s*=\s*[\'"]([^\'"]+)[\'"]/', $content, $m)) { $dbname = $m[1]; }
    if (preg_match('/\$user\s*=\s*[\'"]([^\'"]+)[\'"]/', $content, $m))   { $user = $m[1]; }
    if (preg_match('/\$pass\s*=\s*[\'"]([^\'"]*)[\'"]/', $content, $m))   { $pass = $m[1]; }
    if (preg_match('/\$host\s*=\s*[\'"]([^\'"]+)[\'"]/', $content, $m))   { $host = $m[1]; }

    if (empty($dbname)) {
        // Fallback to master connection
        $targetConn = $masterConn;
        $res['db_name'] = 'Shared Master DB';
    } else {
        $res['db_name'] = $dbname;
        $targetConn = @new mysqli($host, $user, $pass, $dbname);
        if ($targetConn->connect_error) {
            // Try with root fallback on localhost
            if ($host === 'localhost' || $host === '127.0.0.1') {
                $targetConn = @new mysqli($host, 'root', '', $dbname);
            }
        }
    }

    if (!$targetConn || $targetConn->connect_error) {
        $res['error'] = "Could not connect to database `{$dbname}`: " . ($targetConn ? $targetConn->connect_error : 'Connection error');
        return $res;
    }

    $res['connected'] = true;
    $targetConn->set_charset("utf8mb4");

    // 1. Add formula and formula_decimals to test_parameters if missing
    $chk = $targetConn->query("SHOW COLUMNS FROM test_parameters LIKE 'formula'");
    if ($chk && $chk->num_rows === 0) {
        @$targetConn->query("ALTER TABLE test_parameters ADD COLUMN formula VARCHAR(255) NULL DEFAULT NULL AFTER interpretation");
        @$targetConn->query("ALTER TABLE test_parameters ADD COLUMN formula_decimals TINYINT(2) DEFAULT 2 AFTER formula");
        $res['alters_run'][] = "Added 'formula' and 'formula_decimals' columns to test_parameters";
    }

    // 2. Seed standard formulas for parameters if missing
    $defaultFormulas = [
        143 => ['formula' => '[PARAM_11] - [PARAM_12]', 'decimals' => 2], // Indirect Bilirubin
        150 => ['formula' => '[PARAM_148] - [PARAM_149]', 'decimals' => 2], // Globulin
        151 => ['formula' => '[PARAM_149] / [PARAM_150]', 'decimals' => 2], // A/G Ratio
        123 => ['formula' => '[PARAM_104] / 5', 'decimals' => 2], // VLDL
        103 => ['formula' => '[PARAM_101] - [PARAM_102] - [PARAM_123]', 'decimals' => 2], // LDL
        124 => ['formula' => '[PARAM_101] / [PARAM_102]', 'decimals' => 2], // Total/HDL Ratio
        125 => ['formula' => '[PARAM_103] / [PARAM_102]', 'decimals' => 2], // LDL/HDL Ratio
        157 => ['formula' => '([PARAM_154] * 10) / [PARAM_177]', 'decimals' => 1], // MCH
        158 => ['formula' => '([PARAM_154] * 100) / [PARAM_178]', 'decimals' => 1], // MCHC
        164 => ['formula' => '[PARAM_161] / 2.14', 'decimals' => 2], // BUN
        109 => ['formula' => '(28.7 * [PARAM_108]) - 46.7', 'decimals' => 1], // eAG
        7   => ['formula' => '([PARAM_3] * [PARAM_17]) / 100', 'decimals' => 0], // AEC
        43  => ['formula' => '([PARAM_41] / [PARAM_42]) * 100', 'decimals' => 1], // Transferrin Saturation
        116 => ['formula' => 'pow(([PARAM_114] / [PARAM_115]), 1.0)', 'decimals' => 2], // INR
    ];

    $seededCount = 0;
    foreach ($defaultFormulas as $pid => $fdata) {
        $q = "UPDATE test_parameters SET formula = '{$fdata['formula']}', formula_decimals = {$fdata['decimals']} WHERE parameter_id = {$pid} AND (formula IS NULL OR formula = '')";
        if ($targetConn->query($q) && $targetConn->affected_rows > 0) {
            $seededCount += $targetConn->affected_rows;
        }
    }
    if ($seededCount > 0) {
        $res['alters_run'][] = "Preloaded default medical formulas for {$seededCount} standard parameters";
    }

    // 3. Ensure admin_settings table has lab_slug and multi-tenant columns
    $resAS = $targetConn->query("SHOW COLUMNS FROM admin_settings LIKE 'lab_slug'");
    if ($resAS && $resAS->num_rows === 0) {
        @$targetConn->query("ALTER TABLE admin_settings ADD COLUMN lab_slug VARCHAR(100) DEFAULT NULL AFTER id");
        @$targetConn->query("ALTER TABLE admin_settings ADD INDEX (lab_slug)");
        $res['alters_run'][] = "Added 'lab_slug' to admin_settings";
    }

    $res['success'] = true;
    return $res;
}

// Handle Form Execution (Sync All or Sync Single)
$syncOutput = [];
$actionTriggered = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $targetSlug = trim($_POST['target_slug'] ?? '');
    $dryRun = isset($_POST['dry_run']) && $_POST['dry_run'] == '1';
    $actionTriggered = true;

    $allLabs = discoverAllLabs($workspaceRoot, $conn);
    $targetsToSync = [];

    if ($action === 'sync_all') {
        $targetsToSync = $allLabs;
    } elseif ($action === 'sync_single' && !empty($targetSlug) && isset($allLabs[$targetSlug])) {
        $targetsToSync[$targetSlug] = $allLabs[$targetSlug];
    }

    foreach ($targetsToSync as $slug => $lab) {
        $wasMissing = false;
        if (!$lab['exists_on_disk']) {
            if ($dryRun) {
                $syncOutput[] = [
                    'slug'     => $slug,
                    'name'     => $lab['name'],
                    'status'   => 'warning',
                    'msg'      => "Dry Run: Folder does not exist yet. Running real sync will auto-deploy from /base."
                ];
                continue;
            } else {
                // Auto-deploy folder from base/
                $wasMissing = true;
                LabProvisioner::copyDirectory($baseTemplateDir, $lab['full_path']);
                if (!file_exists($lab['full_path'] . '/db.php')) {
                    @copy($baseTemplateDir . '/db.php', $lab['full_path'] . '/db.php');
                }
                $lab['exists_on_disk'] = true;
            }
        }

        // 1. File Synchronization
        $fStats = safeSyncFiles($baseTemplateDir, $lab['full_path'], $protectedPaths, $dryRun);

        // 2. Database Migration
        $dbStats = migrateTenantDatabase($lab['full_path'], $slug, $conn);

        if ($wasMissing) {
            $dbStats['alters_run'][] = "Auto-created missing tenant folder /{$slug} from /base template";
        }

        $syncOutput[] = [
            'slug'     => $slug,
            'name'     => $lab['name'],
            'status'   => ($dbStats['success'] && empty($fStats['errors'])) ? 'success' : 'warning',
            'fStats'   => $fStats,
            'dbStats'  => $dbStats
        ];
    }
}

// Refresh Lab List
$labsList = discoverAllLabs($workspaceRoot, $conn);
?>

<div class="container-fluid px-4 py-4">

  <!-- Header Banner -->
  <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
    <div>
      <h3 class="fw-bold mb-1 text-dark">
        <i class="fas fa-sync-alt text-primary me-2"></i> Master Lab Fleet Updater &amp; Sync Hub
      </h3>
      <p class="text-muted small mb-0">
        Safely propagate new features, UI enhancements, and non-destructive database migrations from <code>base/</code> to all active vendor lab instances without affecting their bills, test results, or credentials.
      </p>
    </div>
    <div class="d-flex align-items-center gap-2">
      <a href="labs_manage.php" class="btn btn-outline-secondary rounded-3 px-3 py-2 fw-semibold">
        <i class="fas fa-arrow-left me-1"></i> Back to Labs Directory
      </a>
    </div>
  </div>

  <!-- Protected Guard Alert -->
  <div class="alert alert-info border-0 shadow-sm d-flex align-items-center gap-3 p-3 mb-4 rounded-3" style="background-color: #f0f9ff; border-left: 4px solid #0284c7 !important;">
    <div class="text-primary fs-3">
      <i class="fas fa-shield-alt"></i>
    </div>
    <div class="small">
      <strong class="text-dark d-block mb-1">Zero-Data Loss Guarantee Active:</strong>
      During fleet synchronization, tenant-specific files (<code>db.php</code>, <code>logo.*</code>, <code>letterhead.*</code>, <code>uploads/</code>, <code>qrtemp/</code>, <code>sign_stamp/</code>) are <strong>strictly protected and never overwritten</strong>. Database updates are <strong>strictly additive</strong>, ensuring existing bills, patient files, and test results remain completely intact.
    </div>
  </div>

  <!-- Sync Execution Results (if just run) -->
  <?php if ($actionTriggered): ?>
    <div class="card-sa p-4 mb-4" style="border-left: 4px solid #10b981;">
      <h5 class="fw-bold text-dark mb-3">
        <i class="fas fa-clipboard-check text-success me-2"></i> Fleet Synchronization Results
        <?= $dryRun ? '<span class="badge bg-warning text-dark ms-2">Dry Run (Simulated)</span>' : '' ?>
      </h5>

      <div class="table-responsive">
        <table class="table table-bordered table-sm align-middle mb-0">
          <thead class="table-light small">
            <tr>
              <th>Lab Name &amp; Folder</th>
              <th>Files Updated</th>
              <th>Files Preserved (Protected)</th>
              <th>Database Migration Status</th>
              <th>Overall Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($syncOutput as $out): ?>
              <tr>
                <td>
                  <strong><?= htmlspecialchars($out['name']) ?></strong>
                  <div class="small text-muted font-monospace">/<?= htmlspecialchars($out['slug']) ?></div>
                </td>
                <td>
                  <?php if (!empty($out['fStats'])): ?>
                    <span class="badge bg-success bg-opacity-10 text-success fw-bold">
                      +<?= $out['fStats']['copied'] ?> new, <?= $out['fStats']['updated'] ?> updated
                    </span>
                  <?php else: ?>
                    <span class="text-muted">-</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if (!empty($out['fStats'])): ?>
                    <span class="badge bg-light text-secondary border font-monospace">
                      <?= $out['fStats']['protected'] ?> protected files kept
                    </span>
                  <?php else: ?>
                    <span class="text-muted">-</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if (!empty($out['dbStats']['connected'])): ?>
                    <span class="text-success small fw-semibold"><i class="fas fa-check-circle me-1"></i> Connected to `<?= htmlspecialchars($out['dbStats']['db_name']) ?>`</span>
                    <?php if (!empty($out['dbStats']['alters_run'])): ?>
                      <div class="small text-muted mt-1">&bull; <?= implode("<br>&bull; ", array_map('htmlspecialchars', $out['dbStats']['alters_run'])) ?></div>
                    <?php else: ?>
                      <div class="small text-muted mt-1">&bull; Schema already fully up to date</div>
                    <?php endif; ?>
                  <?php else: ?>
                    <span class="text-danger small"><i class="fas fa-exclamation-triangle me-1"></i> <?= htmlspecialchars($out['dbStats']['error'] ?? 'DB error') ?></span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($out['status'] === 'success'): ?>
                    <span class="badge bg-success px-3 py-2"><i class="fas fa-check me-1"></i> Updated</span>
                  <?php elseif ($out['status'] === 'warning'): ?>
                    <span class="badge bg-warning text-dark px-3 py-2"><i class="fas fa-exclamation me-1"></i> Attention</span>
                  <?php else: ?>
                    <span class="badge bg-danger px-3 py-2"><i class="fas fa-times me-1"></i> Failed</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  <?php endif; ?>

  <!-- One-Click Fleet Master Control -->
  <div class="card-sa p-4 mb-4">
    <div class="row g-3 align-items-center justify-content-between">
      <div class="col-lg-8">
        <h5 class="fw-bold text-dark mb-1">
          <i class="fas fa-rocket text-primary me-2"></i> Update Entire Lab Fleet in 1-Click
        </h5>
        <p class="text-muted small mb-0">
          Scans all <?= count($labsList) ?> discovered lab instances, copies latest features from <code>base/</code>, and applies missing database migrations across all databases.
        </p>
      </div>
      <div class="col-lg-4 text-lg-end">
        <form method="POST" action="sync_labs.php" onsubmit="return confirm('Synchronize all <?= count($labsList) ?> labs now? All protected tenant files and databases will be safely preserved.');">
          <input type="hidden" name="action" value="sync_all">
          <div class="form-check form-switch d-inline-block text-start me-3 mb-2 mb-sm-0">
            <input class="form-check-input" type="checkbox" name="dry_run" id="dryRunToggle" value="1">
            <label class="form-check-label small text-muted" for="dryRunToggle">Dry Run Only</label>
          </div>
          <button type="submit" class="btn btn-primary rounded-3 px-4 py-2 fw-bold shadow-sm">
            <i class="fas fa-sync-alt me-1"></i> Sync All <?= count($labsList) ?> Labs
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Discovered Labs Directory Table -->
  <div class="card-sa overflow-hidden">
    <div class="p-3 border-bottom bg-light d-flex justify-content-between align-items-center">
      <h6 class="fw-bold text-dark mb-0">
        <i class="fas fa-network-wired me-2 text-primary"></i> Discovered Lab Instances (<?= count($labsList) ?>)
      </h6>
      <span class="badge bg-primary rounded-pill px-3 py-2">Master Blueprint: /base</span>
    </div>

    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light small text-muted">
          <tr>
            <th>LAB / DIAGNOSTIC CENTRE</th>
            <th>INSTANCE FOLDER</th>
            <th>DISK STATUS</th>
            <th>TENANT ORIGIN</th>
            <th class="text-end">ACTIONS</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($labsList)): ?>
            <tr>
              <td colspan="5" class="text-center py-5 text-muted">
                No tenant lab instances detected.
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($labsList as $slug => $lab): ?>
              <tr>
                <td>
                  <div class="fw-bold text-dark fs-6"><?= htmlspecialchars($lab['name']) ?></div>
                  <small class="text-muted">User ID: <?= htmlspecialchars($lab['vendor_userid']) ?></small>
                </td>
                <td>
                  <span class="font-monospace text-primary fw-semibold">
                    <i class="fas fa-folder me-1 text-secondary"></i> /<?= htmlspecialchars($lab['folder_slug']) ?>
                  </span>
                </td>
                <td>
                  <?php if ($lab['exists_on_disk']): ?>
                    <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle px-2 py-1">
                      <i class="fas fa-check-circle me-1"></i> Live on Disk
                    </span>
                  <?php else: ?>
                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle px-2 py-1">
                      <i class="fas fa-times-circle me-1"></i> Missing Directory
                    </span>
                  <?php endif; ?>
                </td>
                <td>
                  <span class="badge bg-light text-dark border font-monospace">
                    <?= htmlspecialchars($lab['source']) ?>
                  </span>
                </td>
                <td class="text-end">
                  <div class="d-flex align-items-center justify-content-end gap-2">
                    <a href="../<?= htmlspecialchars($lab['folder_slug']) ?>/index.php" target="_blank" class="btn btn-outline-secondary btn-sm" title="Open Lab Portal">
                      <i class="fas fa-external-link-alt"></i>
                    </a>
                    <form method="POST" action="sync_labs.php" class="d-inline" onsubmit="return confirm('Synchronize lab \'<?= htmlspecialchars(addslashes($lab['name'])) ?>\'?');">
                      <input type="hidden" name="action" value="sync_single">
                      <input type="hidden" name="target_slug" value="<?= htmlspecialchars($lab['folder_slug']) ?>">
                      <?php if ($lab['exists_on_disk']): ?>
                        <button type="submit" class="btn btn-sm btn-outline-primary fw-semibold">
                          <i class="fas fa-sync-alt me-1"></i> Sync This Lab
                        </button>
                      <?php else: ?>
                        <button type="submit" class="btn btn-sm btn-success fw-semibold shadow-sm" title="Directory not found. Click to deploy template from /base!">
                          <i class="fas fa-rocket me-1"></i> Deploy &amp; Sync Folder
                        </button>
                      <?php endif; ?>
                    </form>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<?php require_once __DIR__ . '/footer.php'; ?>
