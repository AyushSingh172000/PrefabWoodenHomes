<?php
/**
 * Testimonials Manager - Prefab Wooden Homes
 */
$pageTitle = 'Testimonials';
require_once __DIR__ . '/includes/admin-header.php';

try {
    $db = Database::getConnection();

    // Handle quick delete or status toggle
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        adminVerifyCsrf();
        $action = $_POST['action'] ?? '';
        $id = (int)($_POST['id'] ?? 0);

        if ($action === 'toggle_active' && $id > 0) {
            $stmt = $db->prepare("UPDATE testimonials SET is_active = NOT is_active WHERE id = :id");
            $stmt->execute(['id' => $id]);
            setFlash('success', 'Testimonial status updated.');
            header('Location: ' . url('admin/testimonials.php'));
            exit;
        } elseif ($action === 'delete' && $id > 0) {
            $stmt = $db->prepare("DELETE FROM testimonials WHERE id = :id");
            $stmt->execute(['id' => $id]);
            setFlash('success', 'Testimonial deleted.');
            header('Location: ' . url('admin/testimonials.php'));
            exit;
        }
    }

    $testimonials = $db->query("SELECT * FROM testimonials ORDER BY sort_order ASC, created_at DESC")->fetchAll();
} catch (\Throwable $e) {
    echo '<div class="adm-alert adm-alert--error">Database error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    $testimonials = [];
}
?>

<div class="adm-card">
    <div class="adm-card__header">
        <h2 class="adm-card__title"><i class="fas fa-star"></i> Client Testimonials (<?= count($testimonials) ?>)</h2>
        <a href="<?= url('admin/testimonial-edit.php') ?>" class="adm-btn adm-btn--primary adm-btn--sm">
            <i class="fas fa-plus-circle"></i> Add Testimonial
        </a>
    </div>

    <?php if (empty($testimonials)): ?>
        <p style="color: var(--adm-text-muted); text-align: center; padding: 2.5rem 0;">No testimonials found.</p>
    <?php else: ?>
        <div class="adm-table-responsive">
            <table class="adm-table">
                <thead>
                    <tr>
                        <th>Client Name</th>
                        <th>Role / Location</th>
                        <th>Rating</th>
                        <th>Review Snippet</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($testimonials as $t): ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($t['client_name']) ?></strong>
                            </td>
                            <td>
                                <span style="font-size: 0.85rem; color: var(--adm-text-muted);">
                                    <?= htmlspecialchars($t['client_role'] ?: 'Verified Homeowner') ?>
                                </span>
                            </td>
                            <td style="color: var(--adm-gold); font-size: 0.85rem; white-space: nowrap;">
                                <?php for ($i = 0; $i < (int)$t['rating']; $i++): ?>
                                    <i class="fas fa-star"></i>
                                <?php endfor; ?>
                            </td>
                            <td style="max-width: 340px;">
                                <div style="font-size: 0.82rem; color: var(--adm-text-muted); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    "<?= htmlspecialchars($t['testimonial_text']) ?>"
                                </div>
                            </td>
                            <td>
                                <form method="POST" action="" style="display: inline;">
                                    <?= adminCsrfField() ?>
                                    <input type="hidden" name="action" value="toggle_active">
                                    <input type="hidden" name="id" value="<?= $t['id'] ?>">
                                    <button type="submit" style="background: none; border: none; cursor: pointer;">
                                        <?php if ($t['is_active']): ?>
                                            <span class="adm-badge adm-badge--active">Active</span>
                                        <?php else: ?>
                                            <span class="adm-badge adm-badge--draft">Hidden</span>
                                        <?php endif; ?>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.4rem;">
                                    <a href="<?= url('admin/testimonial-edit.php?id=' . $t['id']) ?>" class="adm-btn adm-btn--outline adm-btn--sm">
                                        <i class="fas fa-pencil-alt"></i> Edit
                                    </a>
                                    <form method="POST" action="" style="display: inline;">
                                        <?= adminCsrfField() ?>
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= $t['id'] ?>">
                                        <button type="submit" class="adm-btn adm-btn--danger adm-btn--sm adm-btn-delete" data-item="review from <?= htmlspecialchars($t['client_name']) ?>">
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
