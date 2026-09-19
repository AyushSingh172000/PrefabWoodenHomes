<?php
/**
 * Admin Dashboard Overview - Prefab Wooden Homes
 */
$pageTitle = 'Dashboard Overview';
require_once __DIR__ . '/includes/admin-header.php';

try {
    $db = Database::getConnection();

    // Stats
    $totalEnquiries = (int)$db->query("SELECT COUNT(*) FROM enquiries")->fetchColumn();
    $unreadEnquiries = (int)$db->query("SELECT COUNT(*) FROM enquiries WHERE is_read = 0")->fetchColumn();
    $totalProjects = (int)$db->query("SELECT COUNT(*) FROM projects WHERE is_active = 1")->fetchColumn();
    $featuredProjects = (int)$db->query("SELECT COUNT(*) FROM projects WHERE is_featured = 1 AND is_active = 1")->fetchColumn();
    $totalTestimonials = (int)$db->query("SELECT COUNT(*) FROM testimonials WHERE is_active = 1")->fetchColumn();
    $pendingVisits = (int)$db->query("SELECT COUNT(*) FROM site_visits WHERE status = 'pending'")->fetchColumn();

    // Recent enquiries
    $recentEnquiriesStmt = $db->query("SELECT * FROM enquiries ORDER BY created_at DESC LIMIT 5");
    $recentEnquiries = $recentEnquiriesStmt->fetchAll();

    // Recent projects
    $recentProjectsStmt = $db->query("SELECT * FROM projects ORDER BY created_at DESC LIMIT 4");
    $recentProjects = $recentProjectsStmt->fetchAll();

} catch (\Throwable $e) {
    echo '<div class="adm-alert adm-alert--error">Database error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    $totalEnquiries = $unreadEnquiries = $totalProjects = $featuredProjects = $totalTestimonials = $pendingVisits = 0;
    $recentEnquiries = $recentProjects = [];
}
?>

<!-- KPI Stats Grid -->
<div class="adm-kpi-grid">
    <div class="adm-kpi">
        <div class="adm-kpi__icon">
            <i class="fas fa-envelope-open-text"></i>
        </div>
        <div class="adm-kpi__content">
            <div class="adm-kpi__value"><?= $totalEnquiries ?></div>
            <div class="adm-kpi__label">
                Total Enquiries 
                <?php if ($unreadEnquiries > 0): ?>
                    <span class="adm-badge adm-badge--unread" style="margin-left: 4px;"><?= $unreadEnquiries ?> new</span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="adm-kpi">
        <div class="adm-kpi__icon">
            <i class="fas fa-home"></i>
        </div>
        <div class="adm-kpi__content">
            <div class="adm-kpi__value"><?= $totalProjects ?></div>
            <div class="adm-kpi__label">Active Projects (<?= $featuredProjects ?> Featured)</div>
        </div>
    </div>

    <div class="adm-kpi">
        <div class="adm-kpi__icon">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div class="adm-kpi__content">
            <div class="adm-kpi__value"><?= $pendingVisits ?></div>
            <div class="adm-kpi__label">Pending Site Visits</div>
        </div>
    </div>

    <div class="adm-kpi">
        <div class="adm-kpi__icon">
            <i class="fas fa-star"></i>
        </div>
        <div class="adm-kpi__content">
            <div class="adm-kpi__value"><?= $totalTestimonials ?></div>
            <div class="adm-kpi__label">Client Testimonials</div>
        </div>
    </div>
</div>

<!-- Quick Actions Bar -->
<div class="adm-card" style="padding: 1.25rem 1.5rem; background: rgba(212, 175, 55, 0.05);">
    <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem;">
        <span style="font-weight: 600; font-size: 0.9rem; color: var(--adm-gold);"><i class="fas fa-bolt"></i> Quick Actions:</span>
        <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
            <a href="<?= url('admin/project-edit.php') ?>" class="adm-btn adm-btn--primary adm-btn--sm">
                <i class="fas fa-plus-circle"></i> Add New Project
            </a>
            <a href="<?= url('admin/testimonial-edit.php') ?>" class="adm-btn adm-btn--outline adm-btn--sm">
                <i class="fas fa-plus"></i> Add Testimonial
            </a>
            <a href="<?= url('admin/enquiries.php') ?>" class="adm-btn adm-btn--outline adm-btn--sm">
                <i class="fas fa-list"></i> View All Leads
            </a>
            <a href="<?= url('admin/settings.php') ?>" class="adm-btn adm-btn--outline adm-btn--sm">
                <i class="fas fa-sliders-h"></i> Contact Settings
            </a>
        </div>
    </div>
</div>

<div class="adm-form-grid" style="grid-template-columns: 1.6fr 1fr; margin-bottom: 2rem;">
    <!-- Recent Enquiries -->
    <div class="adm-card" style="margin-bottom: 0;">
        <div class="adm-card__header">
            <h2 class="adm-card__title"><i class="fas fa-inbox"></i> Recent Inquiries &amp; Leads</h2>
            <a href="<?= url('admin/enquiries.php') ?>" class="adm-btn adm-btn--outline adm-btn--sm">View All (<?= $totalEnquiries ?>)</a>
        </div>

        <?php if (empty($recentEnquiries)): ?>
            <p style="color: var(--adm-text-muted); font-size: 0.9rem; padding: 1rem 0;">No inquiries received yet. When visitors fill out the website quote or contact forms, they will appear here in real time.</p>
        <?php else: ?>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Client Name</th>
                            <th>Project Type</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentEnquiries as $enquiry): ?>
                            <tr>
                                <td>
                                    <?php if ($enquiry['is_replied']): ?>
                                        <span class="adm-badge adm-badge--replied">Replied</span>
                                    <?php elseif ($enquiry['is_read']): ?>
                                        <span class="adm-badge adm-badge--read">Read</span>
                                    <?php else: ?>
                                        <span class="adm-badge adm-badge--unread">New</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars($enquiry['name']) ?></strong>
                                    <div style="font-size: 0.75rem; color: var(--adm-text-muted);">
                                        <?= htmlspecialchars($enquiry['phone'] ?: $enquiry['email']) ?>
                                    </div>
                                </td>
                                <td>
                                    <span style="text-transform: capitalize; font-size: 0.8rem;"><?= htmlspecialchars($enquiry['project_type'] ?: 'General') ?></span>
                                </td>
                                <td style="font-size: 0.78rem; color: var(--adm-text-muted);">
                                    <?= date('M d, Y', strtotime($enquiry['created_at'])) ?>
                                </td>
                                <td>
                                    <a href="<?= url('admin/enquiry-view.php?id=' . $enquiry['id']) ?>" class="adm-btn adm-btn--outline adm-btn--sm">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Active Projects -->
    <div class="adm-card" style="margin-bottom: 0;">
        <div class="adm-card__header">
            <h2 class="adm-card__title"><i class="fas fa-images"></i> Portfolio Projects</h2>
            <a href="<?= url('admin/projects.php') ?>" class="adm-btn adm-btn--outline adm-btn--sm">Manage All</a>
        </div>

        <?php if (empty($recentProjects)): ?>
            <p style="color: var(--adm-text-muted); font-size: 0.9rem; padding: 1rem 0;">No projects added yet.</p>
        <?php else: ?>
            <div style="display: flex; flex-direction: column; gap: 0.85rem;">
                <?php foreach ($recentProjects as $proj): ?>
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.65rem 0.85rem; background: var(--adm-surface-alt); border-radius: var(--adm-radius-sm); border: 1px solid rgba(212, 175, 55, 0.1);">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <img src="<?= htmlspecialchars($proj['image_primary']) ?>" alt="" class="adm-thumb">
                            <div>
                                <div style="font-weight: 600; font-size: 0.85rem;"><?= htmlspecialchars($proj['title']) ?></div>
                                <div style="font-size: 0.72rem; color: var(--adm-gold); text-transform: capitalize;">
                                    <?= htmlspecialchars($proj['project_type']) ?> &bull; <?= htmlspecialchars($proj['location']) ?>
                                </div>
                            </div>
                        </div>
                        <a href="<?= url('admin/project-edit.php?id=' . $proj['id']) ?>" class="adm-btn adm-btn--outline adm-btn--sm" title="Edit Project">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
