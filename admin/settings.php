<?php
/**
 * Global Site Settings & Contact Info - Prefab Wooden Homes
 */
$pageTitle = 'Site Settings';
require_once __DIR__ . '/includes/admin-header.php';

$error = '';

try {
    $db = Database::getConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        adminVerifyCsrf();

        $settings = $_POST['settings'] ?? [];
        $updateStmt = $db->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (:k, :v) ON DUPLICATE KEY UPDATE setting_value = :v");

        foreach ($settings as $k => $v) {
            $updateStmt->execute(['k' => $k, 'v' => trim($v)]);
        }

        setFlash('success', 'Site settings updated successfully. The live website now reflects your new contact details.');
        header('Location: ' . url('admin/settings.php'));
        exit;
    }

    $allSettings = $db->query("SELECT * FROM site_settings ORDER BY setting_group ASC, id ASC")->fetchAll();
    $grouped = [];
    foreach ($allSettings as $s) {
        $grouped[$s['setting_group']][] = $s;
    }

} catch (\Throwable $e) {
    $error = 'Database error: ' . $e->getMessage();
    $grouped = [];
}
?>

<div class="adm-card">
    <div class="adm-card__header">
        <div>
            <h2 class="adm-card__title"><i class="fas fa-sliders-h"></i> Website Global Configuration</h2>
            <div style="font-size: 0.8rem; color: var(--adm-text-muted); margin-top: 2px;">
                Changes made here immediately update header, footer, contact pages, and floating WhatsApp buttons across the entire website.
            </div>
        </div>
    </div>

    <?php if (!empty($error)): ?>
        <div class="adm-alert adm-alert--error">
            <i class="fas fa-exclamation-circle"></i>
            <span><?= htmlspecialchars($error) ?></span>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <?= adminCsrfField() ?>

        <!-- Contact Numbers & WhatsApp -->
        <div style="margin-bottom: 2rem;">
            <h3 style="font-size: 1rem; color: var(--adm-gold); margin-bottom: 1rem; border-bottom: 1px solid rgba(212, 175, 55, 0.15); padding-bottom: 0.5rem;">
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
                    <small style="color: var(--adm-text-muted); font-size: 0.75rem;">Used for all 1-click WhatsApp buttons &amp; floating widget.</small>
                </div>
            </div>
        </div>

        <!-- Emails & Office -->
        <div style="margin-bottom: 2rem;">
            <h3 style="font-size: 1rem; color: var(--adm-gold); margin-bottom: 1rem; border-bottom: 1px solid rgba(212, 175, 55, 0.15); padding-bottom: 0.5rem;">
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

        <!-- Social Media Links -->
        <div style="margin-bottom: 2rem;">
            <h3 style="font-size: 1rem; color: var(--adm-gold); margin-bottom: 1rem; border-bottom: 1px solid rgba(212, 175, 55, 0.15); padding-bottom: 0.5rem;">
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

                <div class="adm-form-group">
                    <label class="adm-form-label"><i class="fab fa-twitter"></i> Twitter / X Profile URL</label>
                    <input type="url" name="settings[social_twitter]" class="adm-input" value="<?= htmlspecialchars(getSetting('social_twitter', SOCIAL_TWITTER)) ?>">
                </div>
            </div>
        </div>

        <button type="submit" class="adm-btn adm-btn--primary">
            <i class="fas fa-save"></i> Save All Site Settings
        </button>
    </form>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
