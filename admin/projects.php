<?php
/**
 * Projects Portfolio Manager - Prefab Wooden Homes
 */
$pageTitle = 'Projects Portfolio';
require_once __DIR__ . '/includes/admin-header.php';

try {
    $db = Database::getConnection();

    // Toggle featured or active quickly
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        adminVerifyCsrf();
        $action = $_POST['action'] ?? '';
        $projId = (int)($_POST['project_id'] ?? 0);

        if ($projId > 0) {
            if ($action === 'toggle_active') {
                $stmt = $db->prepare("UPDATE projects SET is_active = NOT is_active WHERE id = :id");
                $stmt->execute(['id' => $projId]);
                setFlash('success', 'Project status toggled.');
            } elseif ($action === 'toggle_featured') {
                $stmt = $db->prepare("UPDATE projects SET is_featured = NOT is_featured WHERE id = :id");
                $stmt->execute(['id' => $projId]);
                setFlash('success', 'Project featured flag updated.');
            }
            header('Location: ' . url('admin/projects.php'));
            exit;
        }
    }

    $projects = $db->query("SELECT * FROM projects ORDER BY sort_order ASC, created_at DESC")->fetchAll();
} catch (\Throwable $e) {
    echo '<div class="adm-alert adm-alert--error">Database error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    $projects = [];
}
?>

<div class="adm-card">
    <div class="adm-card__header">
        <h2 class="adm-card__title"><i class="fas fa-home"></i> Portfolio Projects (<?= count($projects) ?>)</h2>
        <a href="<?= url('admin/project-edit.php') ?>" class="adm-btn adm-btn--primary adm-btn--sm">
            <i class="fas fa-plus-circle"></i> Add New Project
        </a>
    </div>

    <?php if (empty($projects)): ?>
        <p style="color: var(--adm-text-muted); text-align: center; padding: 2.5rem 0;">No projects added yet.</p>
    <?php else: ?>
        <div class="adm-table-responsive">
            <table class="adm-table">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Project Name</th>
                        <th>Category</th>
                        <th>Location &amp; Area</th>
                        <th>Featured</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $p): ?>
                        <tr>
                            <td>
                                <img src="<?= htmlspecialchars($p['image_primary'] ?: asset('images/logo.jpeg')) ?>" alt="" class="adm-thumb">
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($p['title']) ?></strong>
                                <div style="font-size: 0.75rem; color: var(--adm-text-muted);">
                                    /<?= htmlspecialchars($p['slug']) ?>
                                </div>
                            </td>
                            <td>
                                <span style="text-transform: capitalize; font-weight: 600; font-size: 0.82rem; color: var(--adm-gold);">
                                    <?= htmlspecialchars($p['project_type']) ?>
                                </span>
                            </td>
                            <td>
                                <div style="font-size: 0.85rem;"><?= htmlspecialchars($p['location'] ?: '—') ?></div>
                                <div style="font-size: 0.75rem; color: var(--adm-text-muted);"><?= htmlspecialchars($p['built_area'] ?: '—') ?></div>
                            </td>
                            <td>
                                <form method="POST" action="" style="display: inline;">
                                    <?= adminCsrfField() ?>
                                    <input type="hidden" name="action" value="toggle_featured">
                                    <input type="hidden" name="project_id" value="<?= $p['id'] ?>">
                                    <button type="submit" style="background: none; border: none; cursor: pointer;">
                                        <?php if ($p['is_featured']): ?>
                                            <span class="adm-badge adm-badge--featured"><i class="fas fa-star"></i> Featured</span>
                                        <?php else: ?>
                                            <span class="adm-badge adm-badge--draft">Standard</span>
                                        <?php endif; ?>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="" style="display: inline;">
                                    <?= adminCsrfField() ?>
                                    <input type="hidden" name="action" value="toggle_active">
                                    <input type="hidden" name="project_id" value="<?= $p['id'] ?>">
                                    <button type="submit" style="background: none; border: none; cursor: pointer;">
                                        <?php if ($p['is_active']): ?>
                                            <span class="adm-badge adm-badge--active">Active</span>
                                        <?php else: ?>
                                            <span class="adm-badge adm-badge--draft">Draft</span>
                                        <?php endif; ?>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.4rem;">
                                    <a href="<?= url('admin/project-edit.php?id=' . $p['id']) ?>" class="adm-btn adm-btn--outline adm-btn--sm" title="Edit Project">
                                        <i class="fas fa-pencil-alt"></i> Edit
                                    </a>
                                    <form method="POST" action="<?= url('admin/project-delete.php') ?>" style="display: inline;">
                                        <?= adminCsrfField() ?>
                                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                        <button type="submit" class="adm-btn adm-btn--danger adm-btn--sm adm-btn-delete" data-item="project '<?= htmlspecialchars($p['title']) ?>'" title="Delete">
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
