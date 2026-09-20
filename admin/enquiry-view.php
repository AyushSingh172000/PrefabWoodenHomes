<?php
/**
 * Single Enquiry Detail & Note Editor - Prefab Wooden Homes
 */
require_once __DIR__ . '/includes/auth.php';
requireAdminLogin();

$enquiryId = (int)($_GET['id'] ?? 0);
if ($enquiryId <= 0) {
    header('Location: ' . url('admin/enquiries.php'));
    exit;
}

try {
    $db = Database::getConnection();

    // Mark as read automatically when viewed
    $readStmt = $db->prepare("UPDATE enquiries SET is_read = 1 WHERE id = :id AND is_read = 0");
    $readStmt->execute(['id' => $enquiryId]);

    // Handle updates (Must process before any HTML output)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        adminVerifyCsrf();
        $action = $_POST['action'] ?? '';

        if ($action === 'update_notes') {
            $notes = trim($_POST['admin_notes'] ?? '');
            $isReplied = isset($_POST['is_replied']) ? 1 : 0;
            $updateStmt = $db->prepare("UPDATE enquiries SET admin_notes = :notes, is_replied = :replied WHERE id = :id");
            $updateStmt->execute([
                'notes' => $notes,
                'replied' => $isReplied,
                'id' => $enquiryId
            ]);
            setFlash('success', 'Enquiry updated successfully.');
            header('Location: ' . url('admin/enquiry-view.php?id=' . $enquiryId));
            exit;
        } elseif ($action === 'delete') {
            $delStmt = $db->prepare("DELETE FROM enquiries WHERE id = :id");
            $delStmt->execute(['id' => $enquiryId]);
            setFlash('success', 'Enquiry deleted.');
            header('Location: ' . url('admin/enquiries.php'));
            exit;
        }
    }

    $stmt = $db->prepare("SELECT * FROM enquiries WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $enquiryId]);
    $enquiry = $stmt->fetch();

    if (!$enquiry) {
        setFlash('error', 'Enquiry not found.');
        header('Location: ' . url('admin/enquiries.php'));
        exit;
    }

} catch (\Throwable $e) {
    $enquiry = null;
    setFlash('error', 'Database error: ' . $e->getMessage());
}

$pageTitle = 'Enquiry Details';
require_once __DIR__ . '/includes/admin-header.php';
?>

<div style="margin-bottom: 1.5rem;">
    <a href="<?= url('admin/enquiries.php') ?>" class="adm-btn adm-btn--outline adm-btn--sm">
        <i class="fas fa-arrow-left"></i> Back to Enquiries
    </a>
</div>

<?php if ($enquiry): ?>
<div class="adm-form-grid" style="grid-template-columns: 1.6fr 1fr; align-items: start;">
    <!-- Lead Message Details -->
    <div class="adm-card">
        <div class="adm-card__header">
            <div>
                <h2 class="adm-card__title"><?= htmlspecialchars($enquiry['name']) ?></h2>
                <div style="font-size: 0.8rem; color: var(--adm-text-muted); margin-top: 2px;">
                    Received on <?= date('F d, Y \a\t h:i A', strtotime($enquiry['created_at'])) ?>
                </div>
            </div>
            <div>
                <?php if ($enquiry['is_replied']): ?>
                    <span class="adm-badge adm-badge--replied">Replied</span>
                <?php else: ?>
                    <span class="adm-badge adm-badge--read">Read</span>
                <?php endif; ?>
            </div>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <div class="adm-form-label" style="text-transform: uppercase; font-size: 0.72rem; letter-spacing: 0.08em; color: var(--adm-gold);">Client Message</div>
            <div style="background: var(--adm-surface-alt); padding: 1.25rem; border-radius: var(--adm-radius-sm); border: 1px solid var(--adm-border); font-size: 0.95rem; white-space: pre-wrap; line-height: 1.7;">
<?= htmlspecialchars($enquiry['message']) ?>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; padding: 1rem 0; border-top: 1px solid rgba(212, 175, 55, 0.1);">
            <div>
                <div style="font-size: 0.72rem; text-transform: uppercase; color: var(--adm-gold); font-weight: 600;">Project Interest</div>
                <div style="font-weight: 600; text-transform: capitalize;"><?= htmlspecialchars($enquiry['project_type'] ?: 'General Consultation') ?></div>
            </div>
            <div>
                <div style="font-size: 0.72rem; text-transform: uppercase; color: var(--adm-gold); font-weight: 600;">Project Location</div>
                <div><?= htmlspecialchars($enquiry['location'] ?: 'Not provided') ?></div>
            </div>
            <div>
                <div style="font-size: 0.72rem; text-transform: uppercase; color: var(--adm-gold); font-weight: 600;">Sender IP Address</div>
                <div style="font-family: monospace; font-size: 0.85rem; color: var(--adm-text-muted);"><?= htmlspecialchars($enquiry['ip_address'] ?: 'Unknown') ?></div>
            </div>
        </div>
    </div>

    <!-- Contact & Status Card -->
    <div>
        <div class="adm-card">
            <div class="adm-card__header">
                <h3 class="adm-card__title"><i class="fas fa-address-book"></i> Client Contact</h3>
            </div>

            <div style="display: flex; flex-direction: column; gap: 0.85rem; margin-bottom: 1.5rem;">
                <div>
                    <div style="font-size: 0.72rem; color: var(--adm-text-muted); text-transform: uppercase;">Email Address</div>
                    <div style="font-size: 0.9rem; font-weight: 600;">
                        <a href="mailto:<?= htmlspecialchars($enquiry['email']) ?>" style="color: var(--adm-gold);"><i class="fas fa-envelope"></i> <?= htmlspecialchars($enquiry['email']) ?></a>
                    </div>
                </div>

                <?php if (!empty($enquiry['phone'])): ?>
                <div>
                    <div style="font-size: 0.72rem; color: var(--adm-text-muted); text-transform: uppercase;">Phone Number</div>
                    <div style="font-size: 0.9rem; font-weight: 600;">
                        <a href="tel:<?= htmlspecialchars(formatPhoneLink($enquiry['phone'])) ?>" style="color: var(--adm-text);"><i class="fas fa-phone"></i> <?= htmlspecialchars($enquiry['phone']) ?></a>
                    </div>
                </div>

                <div style="display: flex; gap: 0.5rem; margin-top: 0.5rem;">
                    <a href="https://wa.me/<?= preg_replace('/[^\d]/', '', $enquiry['phone']) ?>?text=Hello%20<?= urlencode($enquiry['name']) ?>%2C%20thank%20you%20for%20contacting%20Prefab%20Wooden%20Homes." target="_blank" class="adm-btn adm-btn--primary adm-btn--sm" style="flex: 1; justify-content: center; background: #25D366; color: #fff; border-color: #25D366;">
                        <i class="fab fa-whatsapp"></i> WhatsApp Client
                    </a>
                </div>
                <?php endif; ?>
            </div>

            <!-- Notes & Status Form -->
            <form method="POST" action="">
                <?= adminCsrfField() ?>
                <input type="hidden" name="action" value="update_notes">

                <div class="adm-form-group">
                    <label class="adm-form-check">
                        <input type="checkbox" name="is_replied" value="1" <?= $enquiry['is_replied'] ? 'checked' : '' ?>>
                        <span>Mark as Replied / Contacted</span>
                    </label>
                </div>

                <div class="adm-form-group">
                    <label for="adminNotes" class="adm-form-label">Internal Staff Notes</label>
                    <textarea id="adminNotes" name="admin_notes" class="adm-textarea" placeholder="Private internal notes (e.g. Quoted 25 Lakhs for 1500 sq ft, follow up on Friday)..." style="min-height: 100px;"><?= htmlspecialchars($enquiry['admin_notes'] ?? '') ?></textarea>
                </div>

                <button type="submit" class="adm-btn adm-btn--primary adm-btn--sm" style="width: 100%; justify-content: center;">
                    <i class="fas fa-save"></i> Save Notes &amp; Status
                </button>
            </form>

            <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid rgba(231, 76, 60, 0.2);">
                <form method="POST" action="">
                    <?= adminCsrfField() ?>
                    <input type="hidden" name="action" value="delete">
                    <button type="submit" class="adm-btn adm-btn--danger adm-btn--sm adm-btn-delete" data-item="this entire enquiry" style="width: 100%; justify-content: center;">
                        <i class="fas fa-trash"></i> Delete This Enquiry
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
