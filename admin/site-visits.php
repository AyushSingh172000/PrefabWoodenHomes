<?php
/**
 * Admin Site Visit Requests - Prefab Wooden Homes
 */
$pageTitle = 'Site Visits';
require_once __DIR__ . '/includes/admin-header.php';

try {
    $db = Database::getConnection();

    // Handle status update
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        adminVerifyCsrf();
        $action = $_POST['action'] ?? '';
        $visitId = (int)($_POST['visit_id'] ?? 0);

        if ($action === 'update_status' && $visitId > 0) {
            $newStatus = $_POST['status'] ?? 'pending';
            $stmt = $db->prepare("UPDATE site_visits SET status = :st WHERE id = :id");
            $stmt->execute(['st' => $newStatus, 'id' => $visitId]);
            setFlash('success', 'Site visit status updated.');
            header('Location: ' . url('admin/site-visits.php'));
            exit;
        } elseif ($action === 'delete' && $visitId > 0) {
            $stmt = $db->prepare("DELETE FROM site_visits WHERE id = :id");
            $stmt->execute(['id' => $visitId]);
            setFlash('success', 'Site visit record deleted.');
            header('Location: ' . url('admin/site-visits.php'));
            exit;
        } elseif ($action === 'create_visit') {
            $name = trim($_POST['name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $location = trim($_POST['site_location'] ?? '');
            $date = $_POST['preferred_date'] ?: null;
            $status = $_POST['status'] ?? 'scheduled';

            if (!empty($name) && !empty($phone) && !empty($location)) {
                $stmt = $db->prepare("INSERT INTO site_visits (name, phone, site_location, preferred_date, status) VALUES (:name, :phone, :loc, :dt, :st)");
                $stmt->execute(['name' => $name, 'phone' => $phone, 'loc' => $location, 'dt' => $date, 'st' => $status]);
                setFlash('success', 'New site visit appointment created.');
                header('Location: ' . url('admin/site-visits.php'));
                exit;
            } else {
                setFlash('error', 'Name, phone and location are required.');
            }
        }
    }

    $visits = $db->query("SELECT * FROM site_visits ORDER BY created_at DESC")->fetchAll();
} catch (\Throwable $e) {
    echo '<div class="adm-alert adm-alert--error">Database error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    $visits = [];
}
?>

<div class="adm-card">
    <div class="adm-card__header">
        <h2 class="adm-card__title"><i class="fas fa-calendar-alt"></i> Scheduled &amp; Requested Site Visits</h2>
        <button type="button" class="adm-btn adm-btn--primary adm-btn--sm" onclick="document.getElementById('newVisitModal').style.display='block'">
            <i class="fas fa-plus"></i> Schedule Site Visit
        </button>
    </div>

    <!-- Add Visit Modal (Simple Form) -->
    <div id="newVisitModal" style="display: none; margin-bottom: 2rem; padding: 1.5rem; background: var(--adm-surface-alt); border-radius: var(--adm-radius); border: 1px solid var(--adm-border);">
        <h3 style="font-size: 1rem; color: var(--adm-gold); margin-bottom: 1rem;"><i class="fas fa-calendar-plus"></i> Schedule New Site Inspection</h3>
        <form method="POST" action="">
            <?= adminCsrfField() ?>
            <input type="hidden" name="action" value="create_visit">
            <div class="adm-form-grid">
                <div class="adm-form-group">
                    <label class="adm-form-label">Client Name <span class="req">*</span></label>
                    <input type="text" name="name" class="adm-input" required placeholder="e.g. Rajesh Sharma">
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">Client Phone <span class="req">*</span></label>
                    <input type="text" name="phone" class="adm-input" required placeholder="e.g. +91 98765 43210">
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">Site Location <span class="req">*</span></label>
                    <input type="text" name="site_location" class="adm-input" required placeholder="Plot address, City, State">
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">Preferred Date</label>
                    <input type="date" name="preferred_date" class="adm-input">
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">Status</label>
                    <select name="status" class="adm-select">
                        <option value="pending">Pending</option>
                        <option value="scheduled" selected>Scheduled</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <button type="submit" class="adm-btn adm-btn--primary adm-btn--sm">Save Visit</button>
                <button type="button" class="adm-btn adm-btn--outline adm-btn--sm" onclick="document.getElementById('newVisitModal').style.display='none'">Cancel</button>
            </div>
        </form>
    </div>

    <?php if (empty($visits)): ?>
        <p style="color: var(--adm-text-muted); padding: 2rem 0; text-align: center;">No site visits recorded yet.</p>
    <?php else: ?>
        <div class="adm-table-responsive">
            <table class="adm-table">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Client</th>
                        <th>Site Location</th>
                        <th>Inspection Date</th>
                        <th>Booked On</th>
                        <th>Change Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($visits as $v): ?>
                        <tr>
                            <td>
                                <?php if ($v['status'] === 'completed'): ?>
                                    <span class="adm-badge adm-badge--active">Completed</span>
                                <?php elseif ($v['status'] === 'scheduled'): ?>
                                    <span class="adm-badge adm-badge--featured">Scheduled</span>
                                <?php elseif ($v['status'] === 'cancelled'): ?>
                                    <span class="adm-badge adm-badge--draft">Cancelled</span>
                                <?php else: ?>
                                    <span class="adm-badge adm-badge--unread">Pending</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($v['name']) ?></strong>
                                <div style="font-size: 0.78rem; color: var(--adm-text-muted);">
                                    <a href="tel:<?= htmlspecialchars(formatPhoneLink($v['phone'])) ?>"><?= htmlspecialchars($v['phone']) ?></a>
                                </div>
                            </td>
                            <td>
                                <i class="fas fa-map-pin" style="color: var(--adm-gold);"></i> <?= htmlspecialchars($v['site_location']) ?>
                            </td>
                            <td>
                                <?= $v['preferred_date'] ? date('M d, Y', strtotime($v['preferred_date'])) : '<span style="color: var(--adm-text-muted);">TBD</span>' ?>
                            </td>
                            <td style="font-size: 0.78rem; color: var(--adm-text-muted);">
                                <?= date('M d, Y', strtotime($v['created_at'])) ?>
                            </td>
                            <td>
                                <form method="POST" action="" style="display: flex; gap: 0.35rem; align-items: center;">
                                    <?= adminCsrfField() ?>
                                    <input type="hidden" name="action" value="update_status">
                                    <input type="hidden" name="visit_id" value="<?= $v['id'] ?>">
                                    <select name="status" class="adm-select" onchange="this.form.submit()" style="padding: 0.3rem 0.6rem; font-size: 0.75rem; width: auto;">
                                        <option value="pending" <?= $v['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="scheduled" <?= $v['status'] === 'scheduled' ? 'selected' : '' ?>>Scheduled</option>
                                        <option value="completed" <?= $v['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                                        <option value="cancelled" <?= $v['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="" style="display: inline;">
                                    <?= adminCsrfField() ?>
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="visit_id" value="<?= $v['id'] ?>">
                                    <button type="submit" class="adm-btn adm-btn--danger adm-btn--sm adm-btn-delete" data-item="this site visit" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
