<?php
/**
 * Services & Construction Types Manager - Prefab Wooden Homes
 */
require_once __DIR__ . '/includes/auth.php';
requireAdminLogin();

try {
    $db = Database::getConnection();

    // Handle quick status toggle (Must process before any HTML output)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        adminVerifyCsrf();
        $action = $_POST['action'] ?? '';
        $id = (int)($_POST['id'] ?? 0);

        if ($action === 'toggle_active' && $id > 0) {
            $stmt = $db->prepare("UPDATE services SET is_active = NOT is_active WHERE id = :id");
            $stmt->execute(['id' => $id]);
            setFlash('success', 'Service visibility status updated.');
            header('Location: ' . url('admin/services.php'));
            exit;
        }
    }

    $services = $db->query("SELECT * FROM services ORDER BY sort_order ASC, id ASC")->fetchAll();
} catch (\Throwable $e) {
    echo '<div class="adm-alert adm-alert--error">Database error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    $services = [];
}

$pageTitle = 'Services & Construction Types';
require_once __DIR__ . '/includes/admin-header.php';
?>

<div class="adm-card">
    <div class="adm-card__header">
        <div>
            <h2 class="adm-card__title"><i class="fas fa-hammer"></i> Website Services &amp; Construction Types (<?= count($services) ?>)</h2>
            <div style="font-size: 0.8rem; color: var(--adm-text-muted); margin-top: 2px;">
                Manage the wooden home construction types displayed on the homepage bento grid, construction page, and header navigation menu.
            </div>
        </div>
        <a href="<?= url('admin/service-edit.php') ?>" class="adm-btn adm-btn--primary adm-btn--sm">
            <i class="fas fa-plus-circle"></i> Add New Service
        </a>
    </div>

    <?php if (empty($services)): ?>
        <p style="color: var(--adm-text-muted); text-align: center; padding: 2.5rem 0;">No services found.</p>
    <?php else: ?>
        <div class="adm-table-responsive">
            <table class="adm-table">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Service / Construction Type</th>
                        <th>Badge</th>
                        <th>Anchor Slug</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($services as $s): ?>
                        <tr>
                            <td>
                                <img src="<?= htmlspecialchars($s['image'] ?: asset('images/logo.jpeg')) ?>" alt="" class="adm-thumb">
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($s['title']) ?></strong>
                                <div style="font-size: 0.75rem; color: var(--adm-text-muted);">
                                    <?= htmlspecialchars(substr($s['subtitle'] ?: $s['description'], 0, 70)) ?>...
                                </div>
                            </td>
                            <td>
                                <?php if (!empty($s['badge'])): ?>
                                    <span class="adm-badge adm-badge--featured"><?= htmlspecialchars($s['badge']) ?></span>
                                <?php else: ?>
                                    <span style="color: var(--adm-text-muted); font-size: 0.75rem;">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <code style="color: var(--adm-gold); font-size: 0.8rem;">#<?= htmlspecialchars($s['slug']) ?></code>
                            </td>
                            <td style="font-size: 0.85rem;">
                                <?= (int)$s['sort_order'] ?>
                            </td>
                            <td>
                                <form method="POST" action="" style="display: inline;">
                                    <?= adminCsrfField() ?>
                                    <input type="hidden" name="action" value="toggle_active">
                                    <input type="hidden" name="id" value="<?= $s['id'] ?>">
                                    <button type="submit" style="background: none; border: none; cursor: pointer;">
                                        <?php if ($s['is_active']): ?>
                                            <span class="adm-badge adm-badge--active">Active</span>
                                        <?php else: ?>
                                            <span class="adm-badge adm-badge--draft">Hidden</span>
                                        <?php endif; ?>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.4rem;">
                                    <a href="<?= url('admin/service-edit.php?id=' . $s['id']) ?>" class="adm-btn adm-btn--outline adm-btn--sm" title="Edit Service">
                                        <i class="fas fa-pencil-alt"></i> Edit
                                    </a>
                                    <form method="POST" action="<?= url('admin/service-delete.php') ?>" style="display: inline;">
                                        <?= adminCsrfField() ?>
                                        <input type="hidden" name="id" value="<?= $s['id'] ?>">
                                        <button type="submit" class="adm-btn adm-btn--danger adm-btn--sm adm-btn-delete" data-item="service '<?= htmlspecialchars($s['title']) ?>'" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
