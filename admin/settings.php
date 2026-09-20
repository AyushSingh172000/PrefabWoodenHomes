<?php
/**
 * Global Site Settings, Branding & Contact Info - Prefab Wooden Homes
 */
require_once __DIR__ . '/includes/auth.php';
requireAdminLogin();

$error = '';

try {
    $db = Database::getConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        adminVerifyCsrf();

        $settings = $_POST['settings'] ?? [];
        $brandingDir = __DIR__ . '/../assets/images/branding/';
        if (!is_dir($brandingDir)) {
            mkdir($brandingDir, 0755, true);
        }

        // 1. Handle Logo Upload
        if (!empty($_FILES['logo_file']['name']) && $_FILES['logo_file']['error'] === UPLOAD_ERR_OK) {
            $logoFile = $_FILES['logo_file'];
            $ext = strtolower(pathinfo($logoFile['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
            if (in_array($ext, $allowed)) {
                $filename = 'logo_' . time() . '.' . $ext;
                if (move_uploaded_file($logoFile['tmp_name'], $brandingDir . $filename)) {
                    $settings['site_logo'] = asset('images/branding/' . $filename);
                } else {
                    $error = 'Failed to save uploaded logo to server. Please check folder permissions.';
                }
            } else {
                $error = 'Invalid logo format. Allowed: PNG, JPG, WebP, SVG.';
            }
        }

        // 2. Handle Favicon Upload
        if (!empty($_FILES['favicon_file']['name']) && $_FILES['favicon_file']['error'] === UPLOAD_ERR_OK) {
            $favFile = $_FILES['favicon_file'];
            $ext = strtolower(pathinfo($favFile['name'], PATHINFO_EXTENSION));
            $allowed = ['png', 'ico', 'webp', 'jpg', 'jpeg'];
            if (in_array($ext, $allowed)) {
                $filename = 'favicon_' . time() . '.' . $ext;
                if (move_uploaded_file($favFile['tmp_name'], $brandingDir . $filename)) {
                    $settings['site_favicon'] = asset('images/branding/' . $filename);
                } else {
                    $error = 'Failed to save uploaded favicon to server. Please check folder permissions.';
                }
            } else {
                $error = 'Invalid favicon format. Allowed: PNG, ICO, WebP.';
            }
        }

        if (empty($error)) {
            $checkStmt = $db->prepare("SELECT id FROM site_settings WHERE setting_key = :k LIMIT 1");
            $updateStmt = $db->prepare("UPDATE site_settings SET setting_value = :v WHERE setting_key = :k");
            $insertStmt = $db->prepare("INSERT INTO site_settings (setting_key, setting_value, label, setting_group) VALUES (:k, :v, :lbl, 'general')");

            foreach ($settings as $k => $v) {
                $val = trim((string)$v);
                $checkStmt->execute([':k' => $k]);
                if ($checkStmt->fetch()) {
                    $updateStmt->execute([':v' => $val, ':k' => $k]);
                } else {
                    $lbl = ucwords(str_replace('_', ' ', (string)$k));
                    $insertStmt->execute([':k' => $k, ':v' => $val, ':lbl' => $lbl]);
                }
            }

            setFlash('success', 'Site settings, branding & marketing copy updated successfully.');
            header('Location: ' . url('admin/settings.php'));
            exit;
        }
    }

} catch (\Throwable $e) {
    $error = 'Database error: ' . $e->getMessage();
}

$currentLogo = getSetting('site_logo', asset('images/logo.jpeg'));
$currentFavicon = getSetting('site_favicon', asset('images/favicon.png'));

$pageTitle = 'Site Settings & Branding';
require_once __DIR__ . '/includes/admin-header.php';
?>

<div class="adm-card">
    <div class="adm-card__header">
        <div>
            <h2 class="adm-card__title"><i class="fas fa-sliders-h"></i> Website Configuration &amp; Branding</h2>
            <div style="font-size: 0.8rem; color: var(--adm-text-muted); margin-top: 2px;">
                Update logo, favicon, hero copy, contact details, and social links. Changes reflect live on the website immediately.
            </div>
        </div>
    </div>

    <?php if (!empty($error)): ?>
        <div class="adm-alert adm-alert--error">
            <i class="fas fa-exclamation-circle"></i>
            <span><?= htmlspecialchars($error) ?></span>
        </div>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data">
        <?= adminCsrfField() ?>

        <!-- 1. Visual Branding (Logo & Favicon) -->
        <div style="margin-bottom: 2.5rem;">
            <h3 style="font-size: 1.05rem; color: var(--adm-gold); margin-bottom: 1.25rem; border-bottom: 1px solid rgba(212, 175, 55, 0.2); padding-bottom: 0.5rem;">
                <i class="fas fa-palette"></i> Brand Identity &amp; Logos
            </h3>

            <div class="adm-form-grid" style="grid-template-columns: 1fr 1fr; align-items: start;">
                <!-- Website Logo -->
                <div style="background: var(--adm-surface-alt); padding: 1.25rem; border-radius: var(--adm-radius); border: 1px solid var(--adm-border);">
                    <label class="adm-form-label"><i class="fas fa-image"></i> Website Header &amp; Footer Logo</label>
                    <div style="display: flex; align-items: center; gap: 1.25rem; margin-bottom: 1rem;">
                        <img src="<?= htmlspecialchars($currentLogo) ?>" alt="Current Logo" style="height: 58px; width: auto; max-width: 140px; border-radius: 10px; object-fit: contain; border: 1.5px solid var(--adm-gold); background: rgba(0,0,0,0.35); padding: 4px; box-shadow: 0 0 15px var(--adm-gold-glow);">
                        <div>
                            <div style="font-size: 0.82rem; font-weight: 600;">Current Logo Active</div>
                            <div style="font-size: 0.72rem; color: var(--adm-text-muted); word-break: break-all;"><?= htmlspecialchars($currentLogo) ?></div>
                        </div>
                    </div>
                    <div class="adm-form-group" style="margin-bottom: 0.75rem;">
                        <label class="adm-form-label" style="font-size: 0.78rem;">Upload New Logo (PNG, JPG, SVG, WebP)</label>
                        <input type="file" name="logo_file" class="adm-input" accept="image/*">
                    </div>
                    <div class="adm-form-group" style="margin-bottom: 0;">
                        <label class="adm-form-label" style="font-size: 0.78rem;">Or Enter Logo URL / Path</label>
                        <input type="text" name="settings[site_logo]" class="adm-input" value="<?= htmlspecialchars($currentLogo) ?>" placeholder="/assets/images/logo.jpeg or https://...">
                    </div>
                </div>

                <!-- Favicon -->
                <div style="background: var(--adm-surface-alt); padding: 1.25rem; border-radius: var(--adm-radius); border: 1px solid var(--adm-border);">
                    <label class="adm-form-label"><i class="fas fa-bookmark"></i> Browser Tab Favicon Icon</label>
                    <div style="display: flex; align-items: center; gap: 1.25rem; margin-bottom: 1rem;">
                        <img src="<?= htmlspecialchars($currentFavicon) ?>" alt="Current Favicon" style="width: 42px; height: 42px; border-radius: 8px; object-fit: contain; border: 1.5px solid var(--adm-gold); background: #000; padding: 4px;">
                        <div>
                            <div style="font-size: 0.82rem; font-weight: 600;">Current Browser Tab Icon</div>
                            <div style="font-size: 0.72rem; color: var(--adm-text-muted); word-break: break-all;"><?= htmlspecialchars($currentFavicon) ?></div>
                        </div>
                    </div>
                    <div class="adm-form-group" style="margin-bottom: 0.75rem;">
                        <label class="adm-form-label" style="font-size: 0.78rem;">Upload New Favicon (PNG, ICO, WebP)</label>
                        <input type="file" name="favicon_file" class="adm-input" accept="image/x-icon,image/png,image/webp">
                    </div>
                    <div class="adm-form-group" style="margin-bottom: 0;">
                        <label class="adm-form-label" style="font-size: 0.78rem;">Or Enter Favicon URL / Path</label>
                        <input type="text" name="settings[site_favicon]" class="adm-input" value="<?= htmlspecialchars($currentFavicon) ?>" placeholder="/assets/images/favicon.png">
                    </div>
                </div>
            </div>

            <div class="adm-form-grid" style="margin-top: 1.25rem;">
                <div class="adm-form-group">
                    <label class="adm-form-label">Brand / Company Name</label>
                    <input type="text" name="settings[site_name]" class="adm-input" value="<?= htmlspecialchars(getSetting('site_name', SITE_NAME)) ?>">
                </div>

                <div class="adm-form-group">
                    <label class="adm-form-label">Brand Tagline</label>
                    <input type="text" name="settings[site_tagline]" class="adm-input" value="<?= htmlspecialchars(getSetting('site_tagline', SITE_TAGLINE)) ?>">
                </div>
            </div>
        </div>

        <!-- 2. Homepage Hero Marketing Copy -->
        <div style="margin-bottom: 2.5rem;">
            <h3 style="font-size: 1.05rem; color: var(--adm-gold); margin-bottom: 1.25rem; border-bottom: 1px solid rgba(212, 175, 55, 0.2); padding-bottom: 0.5rem;">
                <i class="fas fa-bullhorn"></i> Homepage Hero &amp; Marketing Pitch
            </h3>

            <div class="adm-form-grid">
                <div class="adm-form-group">
                    <label class="adm-form-label">Main Hero Headline (Use Enter/Newline for line break)</label>
                    <textarea name="settings[hero_title]" class="adm-textarea" style="min-height: 80px; font-weight: 600; font-size: 1rem;"><?= htmlspecialchars(getSetting('hero_title', "Build Your Dream\nWooden Home")) ?></textarea>
                </div>

                <div class="adm-form-group">
                    <label class="adm-form-label">Years of Experience Badge</label>
                    <input type="text" name="settings[experience_years]" class="adm-input" value="<?= htmlspecialchars(getSetting('experience_years', '15+')) ?>" placeholder="15+">
                    <small style="color: var(--adm-text-muted); font-size: 0.75rem;">Shown in the golden hero badge and stats strip.</small>
                </div>
            </div>

            <div class="adm-form-group">
                <label class="adm-form-label">Hero Subtitle / Value Proposition</label>
                <textarea name="settings[hero_subtitle]" class="adm-textarea" style="min-height: 90px;"><?= htmlspecialchars(getSetting('hero_subtitle', 'Custom-designed, premium wooden homes engineered for comfort, durability and timeless beauty. From concept to handover, we manage every detail.')) ?></textarea>
            </div>
        </div>

        <!-- 3. Contact Numbers & WhatsApp -->
        <div style="margin-bottom: 2.5rem;">
            <h3 style="font-size: 1.05rem; color: var(--adm-gold); margin-bottom: 1.25rem; border-bottom: 1px solid rgba(212, 175, 55, 0.2); padding-bottom: 0.5rem;">
                <i class="fas fa-phone-alt"></i> Phone Numbers &amp; WhatsApp
            </h3>
            <div class="adm-form-grid">
                <div class="adm-form-group">
                    <label class="adm-form-label">Founder Phone (Aman Jha)</label>
                    <input type="text" name="settings[contact_phone_aman]" class="adm-input" value="<?= htmlspecialchars(getSetting('contact_phone_aman', CONTACT_PHONE_AMAN)) ?>">
                </div>

                <div class="adm-form-group">
                    <label class="adm-form-label">Sales Phone (Rajeev Jha)</label>
                    <input type="text" name="settings[contact_phone_rajeev]" class="adm-input" value="<?= htmlspecialchars(getSetting('contact_phone_rajeev', CONTACT_PHONE_RAJEEV)) ?>">
                </div>

                <div class="adm-form-group">
                    <label class="adm-form-label">WhatsApp Number (country code without +)</label>
                    <input type="text" name="settings[contact_whatsapp]" class="adm-input" value="<?= htmlspecialchars(getSetting('contact_whatsapp', CONTACT_WHATSAPP)) ?>" placeholder="e.g. 919810433120">
                    <small style="color: var(--adm-text-muted); font-size: 0.75rem;">Used for all 1-click WhatsApp buttons &amp; floating chat widget.</small>
                </div>
            </div>
        </div>

        <!-- 4. Emails & Office -->
        <div style="margin-bottom: 2.5rem;">
            <h3 style="font-size: 1.05rem; color: var(--adm-gold); margin-bottom: 1.25rem; border-bottom: 1px solid rgba(212, 175, 55, 0.2); padding-bottom: 0.5rem;">
                <i class="fas fa-envelope"></i> Email &amp; Office Location
            </h3>
            <div class="adm-form-grid">
                <div class="adm-form-group">
                    <label class="adm-form-label">Sales &amp; Customer Email</label>
                    <input type="email" name="settings[contact_email]" class="adm-input" value="<?= htmlspecialchars(getSetting('contact_email', CONTACT_EMAIL)) ?>">
                </div>

                <div class="adm-form-group">
                    <label class="adm-form-label">Founder Email</label>
                    <input type="email" name="settings[contact_email_founder]" class="adm-input" value="<?= htmlspecialchars(getSetting('contact_email_founder', CONTACT_EMAIL_FOUNDER)) ?>">
                </div>

                <div class="adm-form-group">
                    <label class="adm-form-label">Office Working Hours</label>
                    <input type="text" name="settings[office_hours]" class="adm-input" value="<?= htmlspecialchars(getSetting('office_hours', 'Mon – Sat: 9:30 AM – 7:00 PM')) ?>">
                </div>
            </div>

            <div class="adm-form-group">
                <label class="adm-form-label">Physical Office Address</label>
                <textarea name="settings[contact_address]" class="adm-textarea" style="min-height: 80px;"><?= htmlspecialchars(getSetting('contact_address', CONTACT_ADDRESS)) ?></textarea>
            </div>
        </div>

        <!-- 5. Social Media Links -->
        <div style="margin-bottom: 2rem;">
            <h3 style="font-size: 1.05rem; color: var(--adm-gold); margin-bottom: 1.25rem; border-bottom: 1px solid rgba(212, 175, 55, 0.2); padding-bottom: 0.5rem;">
                <i class="fas fa-share-alt"></i> Social Media Profiles
            </h3>
            <div class="adm-form-grid">
                <div class="adm-form-group">
                    <label class="adm-form-label"><i class="fab fa-facebook-f"></i> Facebook Page URL</label>
                    <input type="url" name="settings[social_facebook]" class="adm-input" value="<?= htmlspecialchars(getSetting('social_facebook', SOCIAL_FACEBOOK)) ?>">
                </div>

                <div class="adm-form-group">
                    <label class="adm-form-label"><i class="fab fa-instagram"></i> Instagram Profile URL</label>
                    <input type="url" name="settings[social_instagram]" class="adm-input" value="<?= htmlspecialchars(getSetting('social_instagram', SOCIAL_INSTAGRAM)) ?>">
                </div>

                <div class="adm-form-group">
                    <label class="adm-form-label"><i class="fab fa-youtube"></i> YouTube Channel URL</label>
                    <input type="url" name="settings[social_youtube]" class="adm-input" value="<?= htmlspecialchars(getSetting('social_youtube', SOCIAL_YOUTUBE)) ?>">
                </div>

                <!-- <div class="adm-form-group">
                    <label class="adm-form-label"><i class="fab fa-twitter"></i> Twitter / X Profile URL</label>
                    <input type="url" name="settings[social_twitter]" class="adm-input" value="<?= htmlspecialchars(getSetting('social_twitter', SOCIAL_TWITTER)) ?>">
                </div> -->
            </div>
        </div>

        <button type="submit" class="adm-btn adm-btn--primary adm-btn--lg">
            <i class="fas fa-save"></i> Save All Site Settings &amp; Branding
        </button>
    </form>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
