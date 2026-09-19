<?php
/**
 * Add / Edit Construction Service - Prefab Wooden Homes
 */
require_once __DIR__ . '/includes/auth.php';
requireAdminLogin();

$serviceId = (int)($_GET['id'] ?? 0);
$isEditing = $serviceId > 0;
$pageTitle = $isEditing ? 'Edit Service' : 'Add New Service';

$item = [
    'title' => '',
    'slug' => '',
    'badge' => '',
    'subtitle' => '',
    'description' => '',
    'features' => '',
    'image' => '',
    'sort_order' => 0,
    'is_active' => 1
];

$error = '';

try {
    $db = Database::getConnection();

    if ($isEditing) {
        $stmt = $db->prepare("SELECT * FROM services WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $serviceId]);
        $existing = $stmt->fetch();
        if ($existing) {
            $item = $existing;
        } else {
            setFlash('error', 'Service not found.');
            header('Location: ' . url('admin/services.php'));
            exit;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        adminVerifyCsrf();

        $title = trim($_POST['title'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $badge = trim($_POST['badge'] ?? '');
        $subtitle = trim($_POST['subtitle'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $features = trim($_POST['features'] ?? '');
        $imageUrl = trim($_POST['image_url'] ?? '');
        $sortOrder = (int)($_POST['sort_order'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        if (empty($slug)) {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));
        }

        // Image upload handling
        $image = $imageUrl ?: ($item['image'] ?? '');
        if (!empty($_FILES['image_file']['name']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['image_file'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            if (in_array($ext, $allowed)) {
                $dir = __DIR__ . '/../assets/images/services/';
                if (!is_dir($dir)) {
                    mkdir($dir, 0755, true);
                }
                $filename = 'service_' . time() . '_' . preg_replace('/[^a-z0-9_-]/i', '', pathinfo($file['name'], PATHINFO_FILENAME)) . '.' . $ext;
                if (move_uploaded_file($file['tmp_name'], $dir . $filename)) {
                    $image = asset('images/services/' . $filename);
                }
            } else {
                $error = 'Invalid image file type. Allowed: JPG, PNG, WebP.';
            }
        }

        if (empty($title) || empty($description)) {
            $error = 'Service title and description are required.';
        }

        if (empty($error)) {
            if ($isEditing) {
                $sql = "UPDATE services SET 
                        title = :title, slug = :slug, badge = :badge,
                        subtitle = :sub, description = :desc, features = :feat,
                        image = :img, sort_order = :sort, is_active = :act
                        WHERE id = :id";
                $stmt = $db->prepare($sql);
                $stmt->execute([
                    'title' => $title, 'slug' => $slug, 'badge' => $badge,
                    'sub' => $subtitle, 'desc' => $description, 'feat' => $features,
                    'img' => $image, 'sort' => $sortOrder, 'act' => $isActive,
                    'id' => $serviceId
                ]);
                setFlash('success', 'Service updated successfully.');
            } else {
                $sql = "INSERT INTO services 
                        (title, slug, badge, subtitle, description, features, image, sort_order, is_active)
                        VALUES 
                        (:title, :slug, :badge, :sub, :desc, :feat, :img, :sort, :act)";
                $stmt = $db->prepare($sql);
                $stmt->execute([
                    'title' => $title, 'slug' => $slug, 'badge' => $badge,
                    'sub' => $subtitle, 'desc' => $description, 'feat' => $features,
                    'img' => $image, 'sort' => $sortOrder, 'act' => $isActive
                ]);
                setFlash('success', 'New construction service created.');
            }
            header('Location: ' . url('admin/services.php'));
            exit;
        }
    }
} catch (\Throwable $e) {
    $error = 'Database error: ' . $e->getMessage();
}

require_once __DIR__ . '/includes/admin-header.php';
?>

<div style="margin-bottom: 1.5rem;">
    <a href="<?= url('admin/services.php') ?>" class="adm-btn adm-btn--outline adm-btn--sm">
        <i class="fas fa-arrow-left"></i> Back to Services
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
            <?= $isEditing ? 'Edit Service: ' . htmlspecialchars($item['title']) : 'Add New Construction Service' ?>
        </h2>
    </div>

    <form method="POST" action="" enctype="multipart/form-data">
        <?= adminCsrfField() ?>

        <div class="adm-form-grid">
            <div class="adm-form-group">
                <label for="serviceTitle" class="adm-form-label">Service / Construction Title <span class="req">*</span></label>
                <input type="text" id="serviceTitle" name="title" class="adm-input" required placeholder="e.g. Wooden Tree Houses" value="<?= htmlspecialchars($item['title']) ?>">
            </div>

            <div class="adm-form-group">
                <label for="serviceSlug" class="adm-form-label">Anchor Slug (e.g. tree-houses)</label>
                <input type="text" id="serviceSlug" name="slug" class="adm-input" placeholder="e.g. tree-houses" value="<?= htmlspecialchars($item['slug']) ?>">
                <small style="color: var(--adm-text-muted); font-size: 0.75rem;">Used for page anchors like #tree-houses.</small>
            </div>
        </div>

        <div class="adm-form-grid">
            <div class="adm-form-group">
                <label for="serviceBadge" class="adm-form-label">Badge Tagline</label>
                <input type="text" id="serviceBadge" name="badge" class="adm-input" placeholder="e.g. Turnkey Precision, Canopy Experience" value="<?= htmlspecialchars($item['badge'] ?? '') ?>">
            </div>

            <div class="adm-form-group">
                <label for="serviceSubtitle" class="adm-form-label">Short Tagline / Subtitle</label>
                <input type="text" id="serviceSubtitle" name="subtitle" class="adm-input" placeholder="1-sentence overview for cards &amp; grids" value="<?= htmlspecialchars($item['subtitle'] ?? '') ?>">
            </div>
        </div>

        <!-- Image Upload & Preview -->
        <div class="adm-form-grid" style="border-top: 1px solid rgba(212, 175, 55, 0.1); padding-top: 1.25rem;">
            <div class="adm-form-group">
                <label for="serviceImageInput" class="adm-form-label">Upload Service Photo (WebP, JPG, PNG)</label>
                <input type="file" id="serviceImageInput" name="image_file" class="adm-input" accept="image/*">
            </div>

            <div class="adm-form-group">
                <label for="serviceImageUrl" class="adm-form-label">Or Image URL</label>
                <input type="text" id="serviceImageUrl" name="image_url" class="adm-input" placeholder="https://..." value="<?= htmlspecialchars($item['image'] ?? '') ?>">
            </div>
        </div>

        <?php if (!empty($item['image'])): ?>
            <div style="margin-bottom: 1.5rem;">
                <div class="adm-form-label">Current Photo:</div>
                <img id="serviceImagePreview" src="<?= htmlspecialchars($item['image']) ?>" alt="Preview" style="max-width: 240px; height: 160px; object-fit: cover; border-radius: var(--adm-radius-sm); border: 1.5px solid var(--adm-gold);">
            </div>
        <?php else: ?>
            <div style="margin-bottom: 1.5rem;">
                <img id="serviceImagePreview" src="" alt="Preview" style="display: none; max-width: 240px; height: 160px; object-fit: cover; border-radius: var(--adm-radius-sm); border: 1.5px solid var(--adm-gold);">
            </div>
        <?php endif; ?>

        <div class="adm-form-group">
            <label for="serviceDesc" class="adm-form-label">Full Description <span class="req">*</span></label>
            <textarea id="serviceDesc" name="description" class="adm-textarea" required placeholder="Detailed description of the construction type, engineering process, suitability, and materials..."><?= htmlspecialchars($item['description']) ?></textarea>
        </div>

        <div class="adm-form-group">
            <label for="serviceFeatures" class="adm-form-label">Key Features &amp; Bullet Points (Enter one feature per line)</label>
            <textarea id="serviceFeatures" name="features" class="adm-textarea" style="min-height: 110px;" placeholder="Factory-built precision with on-site assembly&#10;Move-in ready in 8–12 weeks&#10;Fully customisable floor plans&#10;100% Termite Treated"><?= htmlspecialchars($item['features'] ?? '') ?></textarea>
        </div>

        <div class="adm-form-grid" style="align-items: center;">
            <div class="adm-form-group">
                <label class="adm-form-check">
                    <input type="checkbox" name="is_active" value="1" <?= $item['is_active'] ? 'checked' : '' ?>>
                    <span><strong>Active / Published</strong> (Visible on homepage &amp; construction page)</span>
                </label>
            </div>

            <div class="adm-form-group">
                <label for="sortOrder" class="adm-form-label">Display Order</label>
                <input type="number" id="sortOrder" name="sort_order" class="adm-input" value="<?= (int)$item['sort_order'] ?>" style="max-width: 120px;">
            </div>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 1.5rem; border-top: 1px solid rgba(212, 175, 55, 0.15); padding-top: 1.5rem;">
            <button type="submit" class="adm-btn adm-btn--primary">
                <i class="fas fa-save"></i> <?= $isEditing ? 'Save Changes' : 'Publish Service' ?>
            </button>
            <a href="<?= url('admin/services.php') ?>" class="adm-btn adm-btn--outline">Cancel</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
