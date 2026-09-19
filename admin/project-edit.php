<?php
/**
 * Add / Edit Project - Prefab Wooden Homes
 */
require_once __DIR__ . '/includes/admin-header.php';

$projectId = (int)($_GET['id'] ?? 0);
$isEditing = $projectId > 0;
$pageTitle = $isEditing ? 'Edit Project' : 'Add New Project';

$project = [
    'title' => '',
    'slug' => '',
    'project_type' => 'cottage',
    'location' => '',
    'built_area' => '',
    'description' => '',
    'image_primary' => '',
    'is_featured' => 0,
    'sort_order' => 0,
    'is_active' => 1
];

$error = '';

try {
    $db = Database::getConnection();

    if ($isEditing) {
        $stmt = $db->prepare("SELECT * FROM projects WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $projectId]);
        $existing = $stmt->fetch();
        if ($existing) {
            $project = $existing;
        } else {
            setFlash('error', 'Project not found.');
            header('Location: ' . url('admin/projects.php'));
            exit;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        adminVerifyCsrf();

        $title = trim($_POST['title'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $projectType = trim($_POST['project_type'] ?? 'cottage');
        $location = trim($_POST['location'] ?? '');
        $builtArea = trim($_POST['built_area'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $imageUrl = trim($_POST['image_primary_url'] ?? '');
        $isFeatured = isset($_POST['is_featured']) ? 1 : 0;
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        $sortOrder = (int)($_POST['sort_order'] ?? 0);

        // Generate slug if empty
        if (empty($slug)) {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));
        }

        // Handle File Upload if provided
        $imagePrimary = $imageUrl ?: ($project['image_primary'] ?? '');

        if (!empty($_FILES['image_file']['name']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['image_file'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];

            if (!in_array($ext, $allowed)) {
                $error = 'Invalid image file type. Allowed: JPG, PNG, WebP.';
            } elseif ($file['size'] > 5 * 1024 * 1024) {
                $error = 'Image file exceeds 5MB limit.';
            } else {
                $uploadDir = __DIR__ . '/../assets/images/projects/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $newFilename = 'project-' . time() . '-' . preg_replace('/[^a-z0-9_-]/i', '', pathinfo($file['name'], PATHINFO_FILENAME)) . '.' . $ext;
                $destPath = $uploadDir . $newFilename;

                if (move_uploaded_file($file['tmp_name'], $destPath)) {
                    $imagePrimary = asset('images/projects/' . $newFilename);
                } else {
                    $error = 'Failed to save uploaded image to server.';
                }
            }
        }

        if (empty($title)) {
            $error = 'Project title is required.';
        }

        if (empty($error)) {
            if ($isEditing) {
                $sql = "UPDATE projects SET 
                        title = :title, slug = :slug, project_type = :type,
                        location = :loc, built_area = :area, description = :desc,
                        image_primary = :img, is_featured = :feat, is_active = :act,
                        sort_order = :sort
                        WHERE id = :id";
                $stmt = $db->prepare($sql);
                $stmt->execute([
                    'title' => $title, 'slug' => $slug, 'type' => $projectType,
                    'loc' => $location, 'area' => $builtArea, 'desc' => $description,
                    'img' => $imagePrimary, 'feat' => $isFeatured, 'act' => $isActive,
                    'sort' => $sortOrder, 'id' => $projectId
                ]);
                setFlash('success', 'Project updated successfully.');
            } else {
                $sql = "INSERT INTO projects 
                        (title, slug, project_type, location, built_area, description, image_primary, is_featured, is_active, sort_order)
                        VALUES 
                        (:title, :slug, :type, :loc, :area, :desc, :img, :feat, :act, :sort)";
                $stmt = $db->prepare($sql);
                $stmt->execute([
                    'title' => $title, 'slug' => $slug, 'type' => $projectType,
                    'loc' => $location, 'area' => $builtArea, 'desc' => $description,
                    'img' => $imagePrimary, 'feat' => $isFeatured, 'act' => $isActive,
                    'sort' => $sortOrder
                ]);
                setFlash('success', 'New project added successfully.');
            }
            header('Location: ' . url('admin/projects.php'));
            exit;
        }
    }
} catch (\Throwable $e) {
    $error = 'Database error: ' . $e->getMessage();
}
?>

<div style="margin-bottom: 1.5rem;">
    <a href="<?= url('admin/projects.php') ?>" class="adm-btn adm-btn--outline adm-btn--sm">
        <i class="fas fa-arrow-left"></i> Back to Projects
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
            <?= $isEditing ? 'Edit Project: ' . htmlspecialchars($project['title']) : 'Add New Portfolio Project' ?>
        </h2>
    </div>

    <form method="POST" action="" enctype="multipart/form-data">
        <?= adminCsrfField() ?>

        <div class="adm-form-grid">
            <div class="adm-form-group">
                <label for="projectTitle" class="adm-form-label">Project Title <span class="req">*</span></label>
                <input type="text" id="projectTitle" name="title" class="adm-input" required placeholder="e.g. Mountain Resort Cottage" value="<?= htmlspecialchars($project['title']) ?>">
            </div>

            <div class="adm-form-group">
                <label for="projectSlug" class="adm-form-label">URL Slug</label>
                <input type="text" id="projectSlug" name="slug" class="adm-input" placeholder="e.g. mountain-resort-cottage" value="<?= htmlspecialchars($project['slug']) ?>">
                <small style="color: var(--adm-text-muted); font-size: 0.75rem;">Leave blank to auto-generate from title.</small>
            </div>
        </div>

        <div class="adm-form-grid">
            <div class="adm-form-group">
                <label for="projectType" class="adm-form-label">Project Category <span class="req">*</span></label>
                <select id="projectType" name="project_type" class="adm-select" required>
                    <?php
                    $categories = [
                        'prefab-houses' => 'Prefab Wooden House',
                        'cottage' => 'Wooden Cottage / Cabin',
                        'farmhouse' => 'Wooden Farmhouse',
                        'villa' => 'Luxury Timber Villa',
                        'resort' => 'Resort Cottage',
                        'treehouse' => 'Wooden Tree House',
                        'stilt-houses' => 'Wooden Stilt House',
                        'aframe' => 'A-Frame Cabin',
                        'gazebo' => 'Gazebo / Pergola'
                    ];
                    foreach ($categories as $val => $label):
                    ?>
                        <option value="<?= $val ?>" <?= $project['project_type'] === $val ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="adm-form-group">
                <label for="projectLocation" class="adm-form-label">Location (City, State)</label>
                <input type="text" id="projectLocation" name="location" class="adm-input" placeholder="e.g. Manali, Himachal Pradesh" value="<?= htmlspecialchars($project['location'] ?? '') ?>">
            </div>

            <div class="adm-form-group">
                <label for="builtArea" class="adm-form-label">Built-Up Area</label>
                <input type="text" id="builtArea" name="built_area" class="adm-input" placeholder="e.g. 1,800 sq ft" value="<?= htmlspecialchars($project['built_area'] ?? '') ?>">
            </div>
        </div>

        <!-- Image Selection -->
        <div class="adm-form-grid" style="border-top: 1px solid rgba(212, 175, 55, 0.1); padding-top: 1.25rem;">
            <div class="adm-form-group">
                <label for="projectImageInput" class="adm-form-label">Upload Project Photo (WebP, JPG, PNG up to 5MB)</label>
                <input type="file" id="projectImageInput" name="image_file" class="adm-input" accept="image/*">
            </div>

            <div class="adm-form-group">
                <label for="projectImageUrl" class="adm-form-label">Or Image URL (Unsplash or external link)</label>
                <input type="text" id="projectImageUrl" name="image_primary_url" class="adm-input" placeholder="https://..." value="<?= htmlspecialchars($project['image_primary'] ?? '') ?>">
            </div>
        </div>

        <?php if (!empty($project['image_primary'])): ?>
            <div style="margin-bottom: 1.5rem;">
                <div class="adm-form-label">Current / Preview Image:</div>
                <img id="projectImagePreview" src="<?= htmlspecialchars($project['image_primary']) ?>" alt="Preview" style="max-width: 240px; height: 160px; object-fit: cover; border-radius: var(--adm-radius-sm); border: 1.5px solid var(--adm-gold);">
            </div>
        <?php else: ?>
            <div style="margin-bottom: 1.5rem;">
                <img id="projectImagePreview" src="" alt="Preview" style="display: none; max-width: 240px; height: 160px; object-fit: cover; border-radius: var(--adm-radius-sm); border: 1.5px solid var(--adm-gold);">
            </div>
        <?php endif; ?>

        <div class="adm-form-group">
            <label for="projectDesc" class="adm-form-label">Project Description</label>
            <textarea id="projectDesc" name="description" class="adm-textarea" placeholder="Detailed architectural description, timber types used, client requirements, insulation and finishes..."><?= htmlspecialchars($project['description'] ?? '') ?></textarea>
        </div>

        <div class="adm-form-grid" style="align-items: center;">
            <div class="adm-form-group">
                <label class="adm-form-check">
                    <input type="checkbox" name="is_featured" value="1" <?= $project['is_featured'] ? 'checked' : '' ?>>
                    <span><strong>Featured Project</strong> (Highlight on Homepage portfolio)</span>
                </label>
            </div>

            <div class="adm-form-group">
                <label class="adm-form-check">
                    <input type="checkbox" name="is_active" value="1" <?= $project['is_active'] ? 'checked' : '' ?>>
                    <span><strong>Active / Published</strong> (Visible to website visitors)</span>
                </label>
            </div>

            <div class="adm-form-group">
                <label for="sortOrder" class="adm-form-label">Display Order</label>
                <input type="number" id="sortOrder" name="sort_order" class="adm-input" value="<?= (int)$project['sort_order'] ?>" style="max-width: 120px;">
            </div>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 1.5rem; border-top: 1px solid rgba(212, 175, 55, 0.15); padding-top: 1.5rem;">
            <button type="submit" class="adm-btn adm-btn--primary">
                <i class="fas fa-save"></i> <?= $isEditing ? 'Save Changes' : 'Publish Project' ?>
            </button>
            <a href="<?= url('admin/projects.php') ?>" class="adm-btn adm-btn--outline">Cancel</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
