<?php
/**
 * Super Admin Google Analytics & Marketing Hub
 * Live GTM Configuration, Conversion Tracking & Campaign Overview
 */
$page_title = "Google Analytics & Marketing";
require_once __DIR__ . '/header.php';

// Fetch quick marketing and lead metrics from database
$total_leads = 0;
$active_labs = 0;
$pending_trials = 0;
$recent_signups = [];

if ($conn && !$conn->connect_error) {
    // Total Labs / Leads
    $res = $conn->query("SELECT COUNT(*) AS cnt FROM vendor_master");
    if ($res) {
        $total_leads = (int)($res->fetch_assoc()['cnt'] ?? 0);
    }

    // Active
    $res = $conn->query("SELECT COUNT(*) AS cnt FROM vendor_master WHERE status = 'active'");
    if ($res) {
        $active_labs = (int)($res->fetch_assoc()['cnt'] ?? 0);
    }

    // Pending
    $res = $conn->query("SELECT COUNT(*) AS cnt FROM vendor_master WHERE status = 'pending'");
    if ($res) {
        $pending_trials = (int)($res->fetch_assoc()['cnt'] ?? 0);
    }

    // Recent 5 Signups
    $res = $conn->query("SELECT vendor_id, name, vendor_userid, phone, email, city, status, created_at 
                         FROM vendor_master ORDER BY vendor_id DESC LIMIT 5");
    if ($res) {
        while ($r = $res->fetch_assoc()) {
            $recent_signups[] = $r;
        }
    }
}
?>

<div class="container-fluid px-4 py-4">

  <!-- Page Header -->
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h2 class="fw-bold mb-0 text-dark">Google Analytics & Marketing Hub</h2>
        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 small fw-bold">
          <i class="fas fa-check-circle me-1"></i> GTM Active
        </span>
      </div>
      <p class="text-muted small mb-0">Monitor traffic tracking, conversion events, SEO performance, and Google Analytics integration.</p>
    </div>
    
    <div class="d-flex align-items-center gap-2">
      <a href="https://analytics.google.com/" target="_blank" class="btn btn-outline-primary btn-sm fw-semibold rounded-3">
        <i class="fas fa-external-link-alt me-1"></i> Open Google Analytics
      </a>
      <a href="https://tagmanager.google.com/" target="_blank" class="btn btn-primary btn-sm fw-semibold rounded-3">
        <i class="fas fa-tags me-1"></i> Open Tag Manager
      </a>
    </div>
  </div>

  <!-- Key Metrics Row -->
  <div class="row g-3 mb-4">
    <div class="col-xl-3 col-sm-6">
      <div class="card border-0 shadow-sm rounded-3 p-3 h-100 bg-white">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <div class="text-muted small fw-semibold text-uppercase">GTM Container ID</div>
            <div class="fs-4 fw-bold font-monospace text-primary mt-1">GTM-KB5QT3K2</div>
            <div class="small text-success mt-1"><i class="fas fa-circle fa-xs me-1"></i> Installed on Landing & Brochure</div>
          </div>
          <div class="p-3 bg-primary-subtle text-primary rounded-3">
            <i class="fas fa-tag fa-2x"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6">
      <div class="card border-0 shadow-sm rounded-3 p-3 h-100 bg-white">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <div class="text-muted small fw-semibold text-uppercase">Current SaaS Pricing</div>
            <div class="fs-4 fw-bold text-dark mt-1">₹999 <span class="fs-6 text-muted fw-normal">/ Year</span></div>
            <div class="small text-muted mt-1">~₹83/month (Special Annual Offer)</div>
          </div>
          <div class="p-3 bg-warning-subtle text-warning rounded-3">
            <i class="fas fa-bolt fa-2x"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6">
      <div class="card border-0 shadow-sm rounded-3 p-3 h-100 bg-white">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <div class="text-muted small fw-semibold text-uppercase">Total Registered Labs</div>
            <div class="fs-4 fw-bold text-dark mt-1"><?= $total_leads ?></div>
            <div class="small text-primary mt-1"><i class="fas fa-hospital me-1"></i> <?= $active_labs ?> Active Clinical Portals</div>
          </div>
          <div class="p-3 bg-info-subtle text-info rounded-3">
            <i class="fas fa-users fa-2x"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6">
      <div class="card border-0 shadow-sm rounded-3 p-3 h-100 bg-white">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <div class="text-muted small fw-semibold text-uppercase">Pending Trial Leads</div>
            <div class="fs-4 fw-bold text-warning mt-1"><?= $pending_trials ?></div>
            <div class="small text-muted mt-1"><a href="labs_pending.php" class="text-decoration-none">Review New Sign-ups &rarr;</a></div>
          </div>
          <div class="p-3 bg-danger-subtle text-danger rounded-3">
            <i class="fas fa-user-clock fa-2x"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Google & Marketing Tools Quick Launcher -->
  <div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-header bg-white border-bottom py-3">
      <h5 class="fw-bold mb-0 text-dark"><i class="fab fa-google text-danger me-2"></i> Official Marketing & Analytics Tools</h5>
    </div>
    <div class="card-body p-4">
      <div class="row g-3">
        <div class="col-md-3 col-sm-6">
          <div class="p-3 border rounded-3 bg-light h-100 d-flex flex-column justify-content-between">
            <div>
              <div class="d-flex align-items-center gap-2 mb-2">
                <i class="fas fa-chart-line fa-lg text-warning"></i>
                <h6 class="fw-bold mb-0">Google Analytics 4</h6>
              </div>
              <p class="small text-muted mb-3">View live visitors, traffic sources, bounce rate, geography, and campaign conversions.</p>
            </div>
            <a href="https://analytics.google.com/" target="_blank" class="btn btn-outline-dark btn-sm fw-semibold w-100">
              Open GA4 Console <i class="fas fa-arrow-right ms-1"></i>
            </a>
          </div>
        </div>

        <div class="col-md-3 col-sm-6">
          <div class="p-3 border rounded-3 bg-light h-100 d-flex flex-column justify-content-between">
            <div>
              <div class="d-flex align-items-center gap-2 mb-2">
                <i class="fas fa-tags fa-lg text-primary"></i>
                <h6 class="fw-bold mb-0">Google Tag Manager</h6>
              </div>
              <p class="small text-muted mb-3">Manage container <code>GTM-KB5QT3K2</code>, trigger custom events, and publish GA4 tags.</p>
            </div>
            <a href="https://tagmanager.google.com/" target="_blank" class="btn btn-outline-primary btn-sm fw-semibold w-100">
              Manage Tags <i class="fas fa-arrow-right ms-1"></i>
            </a>
          </div>
        </div>

        <div class="col-md-3 col-sm-6">
          <div class="p-3 border rounded-3 bg-light h-100 d-flex flex-column justify-content-between">
            <div>
              <div class="d-flex align-items-center gap-2 mb-2">
                <i class="fas fa-search fa-lg text-success"></i>
                <h6 class="fw-bold mb-0">Search Console</h6>
              </div>
              <p class="small text-muted mb-3">Submit your sitemap, monitor organic Google rankings, and check indexed URL health.</p>
            </div>
            <a href="https://search.google.com/search-console" target="_blank" class="btn btn-outline-success btn-sm fw-semibold w-100">
              Search Console <i class="fas fa-arrow-right ms-1"></i>
            </a>
          </div>
        </div>

        <div class="col-md-3 col-sm-6">
          <div class="p-3 border rounded-3 bg-light h-100 d-flex flex-column justify-content-between">
            <div>
              <div class="d-flex align-items-center gap-2 mb-2">
                <i class="fas fa-robot fa-lg text-info"></i>
                <h6 class="fw-bold mb-0">AI Crawlers (GEO)</h6>
              </div>
              <p class="small text-muted mb-3"><code>llms.txt</code> active for ChatGPT Search, Perplexity, Claude, and Google AI Overviews.</p>
            </div>
            <a href="../llms.txt" target="_blank" class="btn btn-outline-info btn-sm fw-semibold w-100">
              View llms.txt <i class="fas fa-external-link-alt ms-1"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4">
    <!-- Active Conversion Tracking Events -->
    <div class="col-lg-7">
      <div class="card border-0 shadow-sm rounded-3 h-100">
        <div class="card-header bg-white border-bottom py-3">
          <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-bullseye text-primary me-2"></i> Tracked Conversion Events (Google Tag Manager)</h5>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light small text-uppercase">
                <tr>
                  <th>Event Name</th>
                  <th>Category</th>
                  <th>Trigger Action</th>
                  <th>Conversion Value</th>
                </tr>
              </thead>
              <tbody class="small">
                <tr>
                  <td><code class="text-primary fw-bold">sign_up</code></td>
                  <td><span class="badge bg-success-subtle text-success border">Conversion</span></td>
                  <td>User registers new lab on <code>register.php</code></td>
                  <td><strong class="text-success">High (Lead)</strong></td>
                </tr>
                <tr>
                  <td><code class="text-primary fw-bold">demo_click</code></td>
                  <td><span class="badge bg-info-subtle text-info border">Engagement</span></td>
                  <td>User clicks "Launch Live Demo"</td>
                  <td><strong>Medium (Intent)</strong></td>
                </tr>
                <tr>
                  <td><code class="text-primary fw-bold">whatsapp_inquiry</code></td>
                  <td><span class="badge bg-success-subtle text-success border">Lead</span></td>
                  <td>User clicks "Chat on WhatsApp"</td>
                  <td><strong class="text-success">High (Direct Inquiry)</strong></td>
                </tr>
                <tr>
                  <td><code class="text-primary fw-bold">trial_cta_click</code></td>
                  <td><span class="badge bg-primary-subtle text-primary border">Conversion</span></td>
                  <td>User clicks "Start Free Cloud Trial"</td>
                  <td><strong>Medium (Signup Intent)</strong></td>
                </tr>
                <tr>
                  <td><code class="text-primary fw-bold">pricing_select_plan</code></td>
                  <td><span class="badge bg-warning-subtle text-warning border">Commercial</span></td>
                  <td>User selects ₹999/yr Cloud Plan</td>
                  <td><strong>High (Pricing Intent)</strong></td>
                </tr>
                <tr>
                  <td><code class="text-primary fw-bold">brochure_print</code></td>
                  <td><span class="badge bg-info-subtle text-info border">Engagement</span></td>
                  <td>User clicks "Print / Save PDF" on brochure</td>
                  <td><strong>Medium (Brochure Save)</strong></td>
                </tr>
                <tr>
                  <td><code class="text-primary fw-bold">brochure_share</code></td>
                  <td><span class="badge bg-secondary-subtle text-secondary border">Social</span></td>
                  <td>User shares brochure on WhatsApp</td>
                  <td><strong>Medium (Viral Share)</strong></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer bg-light py-2 small text-muted">
          <i class="fas fa-info-circle me-1"></i> In Google Analytics 4, mark <code>sign_up</code> and <code>whatsapp_inquiry</code> as <strong>Key Events (Conversions)</strong>.
        </div>
      </div>
    </div>

    <!-- Live SEO & Asset Status -->
    <div class="col-lg-5">
      <div class="card border-0 shadow-sm rounded-3 h-100">
        <div class="card-header bg-white border-bottom py-3">
          <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-shield-alt text-success me-2"></i> SEO & Marketing Health Check</h5>
        </div>
        <div class="card-body p-3">
          <ul class="list-group list-group-flush small">
            <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-1">
              <div>
                <strong>Google Tag Manager Tag</strong>
                <div class="text-muted" style="font-size: 0.75rem;">Embedded on index.php, brochure.php, register.php</div>
              </div>
              <span class="badge bg-success">Verified Active</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-1">
              <div>
                <strong>Schema.org JSON-LD (Rich Snippets)</strong>
                <div class="text-muted" style="font-size: 0.75rem;">SoftwareApplication, FAQPage, Organization, Offers</div>
              </div>
              <span class="badge bg-success">Valid 2.0</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-1">
              <div>
                <strong>XML Sitemap</strong>
                <div class="text-muted" style="font-size: 0.75rem;"><a href="../sitemap.xml" target="_blank">labs.vensaas.com/sitemap.xml</a></div>
              </div>
              <span class="badge bg-primary">Ready to Submit</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-1">
              <div>
                <strong>Robots Directives</strong>
                <div class="text-muted" style="font-size: 0.75rem;"><a href="../robots.txt" target="_blank">labs.vensaas.com/robots.txt</a></div>
              </div>
              <span class="badge bg-success">Optimized</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-1">
              <div>
                <strong>AI Generative Engine Optimization (GEO)</strong>
                <div class="text-muted" style="font-size: 0.75rem;"><a href="../llms.txt" target="_blank">labs.vensaas.com/llms.txt</a></div>
              </div>
              <span class="badge bg-info text-dark">AI Crawlers Allowed</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-1">
              <div>
                <strong>Social Media Open Graph & Cards</strong>
                <div class="text-muted" style="font-size: 0.75rem;">WhatsApp, Facebook, Twitter preview cards configured</div>
              </div>
              <span class="badge bg-success">512px HD Icon</span>
            </li>
          </ul>

          <div class="alert alert-info py-2 px-3 small mt-3 mb-0 rounded-3">
            <i class="fas fa-lightbulb me-1"></i> <strong>Pro-Tip:</strong> To test your live tag, open <a href="../index.php" target="_blank" class="fw-bold">your website</a> and watch the visitor count update in Google Analytics <strong>Realtime Overview</strong>.
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Trial Registrations (Lead Ingestion) -->
  <div class="card border-0 shadow-sm rounded-3 mt-4">
    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
      <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-user-plus text-primary me-2"></i> Recent Inbound Leads / Registrations</h5>
      <a href="labs_manage.php" class="btn btn-sm btn-outline-secondary">View All Labs Directory</a>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light small text-uppercase">
            <tr>
              <th>ID</th>
              <th>Laboratory Name</th>
              <th>Username</th>
              <th>Phone / WhatsApp</th>
              <th>Email</th>
              <th>City</th>
              <th>Status</th>
              <th>Registered At</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody class="small">
            <?php if (empty($recent_signups)): ?>
              <tr>
                <td colspan="9" class="text-center py-4 text-muted">No inbound registrations recorded yet.</td>
              </tr>
            <?php else: ?>
              <?php foreach ($recent_signups as $lead): ?>
                <tr>
                  <td><strong>#<?= (int)$lead['vendor_id'] ?></strong></td>
                  <td><strong><?= htmlspecialchars($lead['name']) ?></strong></td>
                  <td><code><?= htmlspecialchars($lead['vendor_userid']) ?></code></td>
                  <td>
                    <?php if (!empty($lead['phone'])): ?>
                      <a href="https://wa.me/<?= preg_replace('/\D/', '', $lead['phone']) ?>" target="_blank" class="text-success text-decoration-none">
                        <i class="fab fa-whatsapp me-1"></i> <?= htmlspecialchars($lead['phone']) ?>
                      </a>
                    <?php else: ?>
                      <span class="text-muted">—</span>
                    <?php endif; ?>
                  </td>
                  <td><?= htmlspecialchars($lead['email'] ?? '—') ?></td>
                  <td><?= htmlspecialchars($lead['city'] ?? '—') ?></td>
                  <td>
                    <?php if ($lead['status'] === 'active'): ?>
                      <span class="badge bg-success">Active</span>
                    <?php elseif ($lead['status'] === 'pending'): ?>
                      <span class="badge bg-warning text-dark">Pending</span>
                    <?php else: ?>
                      <span class="badge bg-secondary"><?= htmlspecialchars($lead['status']) ?></span>
                    <?php endif; ?>
                  </td>
                  <td class="text-muted"><?= htmlspecialchars(substr($lead['created_at'] ?? '', 0, 10)) ?></td>
                  <td class="text-end">
                    <a href="lab_edit.php?id=<?= (int)$lead['vendor_id'] ?>" class="btn btn-sm btn-outline-primary">Inspect</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<?php require_once __DIR__ . '/footer.php'; ?>
