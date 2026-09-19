<?php
/**
 * Admin Sidebar Navigation
 */

// Count unread enquiries & pending site visits
$unreadCount = 0;
$pendingVisitsCount = 0;
try {
    $db = Database::getConnection();
    $stmt = $db->query("SELECT COUNT(*) FROM enquiries WHERE is_read = 0");
    $unreadCount = (int)$stmt->fetchColumn();

    $stmt2 = $db->query("SELECT COUNT(*) FROM site_visits WHERE status = 'pending'");
    $pendingVisitsCount = (int)$stmt2->fetchColumn();
} catch (\Throwable $e) {
    // Graceful fallback
}

$currentPage = basename($_SERVER['PHP_SELF'], '.php');
$user = currentAdmin();
?>
<aside class="adm-sidebar" id="admSidebar">
    <div class="adm-brand">
        <img src="<?= asset('images/logo.jpeg') ?>" alt="<?= SITE_NAME ?> Logo" class="adm-brand__logo">
        <div class="adm-brand__text">
            Prefab Wooden
            <span>Admin Console</span>
        </div>
    </div>

    <nav class="adm-nav">
        <div class="adm-nav__label">Overview</div>
        <a href="<?= url('admin/index.php') ?>" class="adm-nav__link <?= $currentPage === 'index' ? 'active' : '' ?>">
            <span class="adm-nav__link-content">
                <i class="fas fa-th-large"></i> Dashboard
            </span>
        </a>

        <div class="adm-nav__label">Lead Generation</div>
        <a href="<?= url('admin/enquiries.php') ?>" class="adm-nav__link <?= in_array($currentPage, ['enquiries', 'enquiry-view']) ? 'active' : '' ?>">
            <span class="adm-nav__link-content">
                <i class="fas fa-envelope-open-text"></i> Enquiries &amp; Leads
            </span>
            <?php if ($unreadCount > 0): ?>
                <span class="adm-nav__badge adm-nav__badge--danger"><?= $unreadCount ?></span>
            <?php endif; ?>
        </a>

        <a href="<?= url('admin/site-visits.php') ?>" class="adm-nav__link <?= $currentPage === 'site-visits' ? 'active' : '' ?>">
            <span class="adm-nav__link-content">
                <i class="fas fa-calendar-check"></i> Site Visits
            </span>
            <?php if ($pendingVisitsCount > 0): ?>
                <span class="adm-nav__badge"><?= $pendingVisitsCount ?></span>
            <?php endif; ?>
        </a>

        <div class="adm-nav__label">Content Management</div>
        <a href="<?= url('admin/projects.php') ?>" class="adm-nav__link <?= in_array($currentPage, ['projects', 'project-edit']) ? 'active' : '' ?>">
            <span class="adm-nav__link-content">
                <i class="fas fa-home"></i> Projects Portfolio
            </span>
        </a>

        <a href="<?= url('admin/testimonials.php') ?>" class="adm-nav__link <?= in_array($currentPage, ['testimonials', 'testimonial-edit']) ? 'active' : '' ?>">
            <span class="adm-nav__link-content">
                <i class="fas fa-star"></i> Testimonials
            </span>
        </a>

        <div class="adm-nav__label">System &amp; Settings</div>
        <a href="<?= url('admin/settings.php') ?>" class="adm-nav__link <?= $currentPage === 'settings' ? 'active' : '' ?>">
            <span class="adm-nav__link-content">
                <i class="fas fa-sliders-h"></i> Site Settings
            </span>
        </a>

        <?php if (isSuperAdmin()): ?>
        <a href="<?= url('admin/users.php') ?>" class="adm-nav__link <?= $currentPage === 'users' ? 'active' : '' ?>">
            <span class="adm-nav__link-content">
                <i class="fas fa-users-cog"></i> Team Users
            </span>
        </a>
        <?php endif; ?>

        <a href="<?= url('admin/profile.php') ?>" class="adm-nav__link <?= $currentPage === 'profile' ? 'active' : '' ?>">
            <span class="adm-nav__link-content">
                <i class="fas fa-user-shield"></i> My Profile
            </span>
        </a>
    </nav>

    <div class="adm-sidebar__footer">
        <div class="adm-user-mini">
            <div class="adm-user-mini__avatar">
                <?= strtoupper(substr($user['username'], 0, 1)) ?>
            </div>
            <div>
                <div class="adm-user-mini__name"><?= htmlspecialchars($user['username']) ?></div>
                <div class="adm-user-mini__role"><?= htmlspecialchars($user['role']) ?></div>
            </div>
        </div>
        <a href="<?= url('admin/logout.php') ?>" title="Log Out" style="color: var(--adm-text-muted); font-size: 1.1rem;">
            <i class="fas fa-sign-out-alt"></i>
        </a>
    </div>
</aside>
