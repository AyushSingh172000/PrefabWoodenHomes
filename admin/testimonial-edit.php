<?php
/**
 * Add / Edit Testimonial - Prefab Wooden Homes
 */
require_once __DIR__ . '/includes/auth.php';
requireAdminLogin();

$testimonialId = (int)($_GET['id'] ?? 0);
$isEditing = $testimonialId > 0;
$pageTitle = $isEditing ? 'Edit Testimonial' : 'Add Testimonial';

$item = [
    'client_name' => '',
    'client_role' => '',
    'testimonial_text' => '',
    'rating' => 5,
    'sort_order' => 0,
    'is_active' => 1
];

$error = '';

try {
    $db = Database::getConnection();

    if ($isEditing) {
        $stmt = $db->prepare("SELECT * FROM testimonials WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $testimonialId]);
        $existing = $stmt->fetch();
        if ($existing) {
            $item = $existing;
        } else {
            setFlash('error', 'Testimonial not found.');
            header('Location: ' . url('admin/testimonials.php'));
            exit;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        adminVerifyCsrf();

        $name = trim($_POST['client_name'] ?? '');
        $role = trim($_POST['client_role'] ?? '');
        $text = trim($_POST['testimonial_text'] ?? '');
        $rating = max(1, min(5, (int)($_POST['rating'] ?? 5)));
        $sortOrder = (int)($_POST['sort_order'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        if (empty($name) || empty($text)) {
            $error = 'Client name and testimonial review text are required.';
        } else {
            if ($isEditing) {
                $stmt = $db->prepare("UPDATE testimonials SET client_name = :name, client_role = :role, testimonial_text = :text, rating = :rating, sort_order = :sort, is_active = :act WHERE id = :id");
                $stmt->execute([
                    'name' => $name, 'role' => $role, 'text' => $text,
                    'rating' => $rating, 'sort' => $sortOrder, 'act' => $isActive,
                    'id' => $testimonialId
                ]);
                setFlash('success', 'Testimonial updated.');
            } else {
                $stmt = $db->prepare("INSERT INTO testimonials (client_name, client_role, testimonial_text, rating, sort_order, is_active) VALUES (:name, :role, :text, :rating, :sort, :act)");
                $stmt->execute([
                    'name' => $name, 'role' => $role, 'text' => $text,
                    'rating' => $rating, 'sort' => $sortOrder, 'act' => $isActive
                ]);
                setFlash('success', 'Testimonial published.');
            }
            header('Location: ' . url('admin/testimonials.php'));
            exit;
        }
    }
} catch (\Throwable $e) {
    $error = 'Database error: ' . $e->getMessage();
}

require_once __DIR__ . '/includes/admin-header.php';
?>

<div style="margin-bottom: 1.5rem;">
    <a href="<?= url('admin/testimonials.php') ?>" class="adm-btn adm-btn--outline adm-btn--sm">
        <i class="fas fa-arrow-left"></i> Back to Testimonials
    </a>
</div>

<?php if (!empty($error)): ?>
    <div class="adm-alert adm-alert--error">
        <i class="fas fa-exclamation-circle"></i>
        <span><?= htmlspecialchars($error) ?></span>
    </div>
<?php endif; ?>

<div class="adm-card">
    <div class="adm-card__header">
        <h2 class="adm-card__title">
            <i class="fas fa-<?= $isEditing ? 'pencil-alt' : 'plus-circle' ?>"></i>
            <?= $isEditing ? 'Edit Review from ' . htmlspecialchars($item['client_name']) : 'Add New Client Review' ?>
        </h2>
    </div>

    <form method="POST" action="">
        <?= adminCsrfField() ?>

        <div class="adm-form-grid">
            <div class="adm-form-group">
                <label for="clientName" class="adm-form-label">Client Name <span class="req">*</span></label>
                <input type="text" id="clientName" name="client_name" class="adm-input" required placeholder="e.g. Vikram Malhotra" value="<?= htmlspecialchars($item['client_name']) ?>">
            </div>

            <div class="adm-form-group">
                <label for="clientRole" class="adm-form-label">Role / Location</label>
                <input type="text" id="clientRole" name="client_role" class="adm-input" placeholder="e.g. Farmhouse Owner, Lonavala" value="<?= htmlspecialchars($item['client_role']) ?>">
            </div>

            <div class="adm-form-group">
                <label for="clientRating" class="adm-form-label">Star Rating (1 to 5)</label>
                <select id="clientRating" name="rating" class="adm-select">
                    <option value="5" <?= (int)$item['rating'] === 5 ? 'selected' : '' ?>>★★★★★ (5 Stars - Exceptional)</option>
                    <option value="4" <?= (int)$item['rating'] === 4 ? 'selected' : '' ?>>★★★★☆ (4 Stars - Great)</option>
                    <option value="3" <?= (int)$item['rating'] === 3 ? 'selected' : '' ?>>★★★☆☆ (3 Stars - Average)</option>
                </select>
            </div>
        </div>

        <div class="adm-form-group">
            <label for="reviewText" class="adm-form-label">Client Testimonial Review <span class="req">*</span></label>
            <textarea id="reviewText" name="testimonial_text" class="adm-textarea" required placeholder="Write the client's verified quote and feedback..."><?= htmlspecialchars($item['testimonial_text']) ?></textarea>
        </div>

        <div class="adm-form-grid" style="align-items: center;">
            <div class="adm-form-group">
                <label class="adm-form-check">
                    <input type="checkbox" name="is_active" value="1" <?= $item['is_active'] ? 'checked' : '' ?>>
                    <span><strong>Active / Visible</strong> on website</span>
                </label>
            </div>

            <div class="adm-form-group">
                <label for="sortOrder" class="adm-form-label">Display Order</label>
                <input type="number" id="sortOrder" name="sort_order" class="adm-input" value="<?= (int)$item['sort_order'] ?>" style="max-width: 120px;">
            </div>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 1.5rem; border-top: 1px solid rgba(212, 175, 55, 0.15); padding-top: 1.5rem;">
            <button type="submit" class="adm-btn adm-btn--primary">
                <i class="fas fa-save"></i> <?= $isEditing ? 'Save Changes' : 'Save Testimonial' ?>
            </button>
            <a href="<?= url('admin/testimonials.php') ?>" class="adm-btn adm-btn--outline">Cancel</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
