<?php
/**
 * Admin Enquiries & Lead Manager - Prefab Wooden Homes
 */
$pageTitle = 'Enquiries & Leads';
require_once __DIR__ . '/includes/admin-header.php';

$filterStatus = $_GET['status'] ?? 'all';
$searchQuery = trim($_GET['q'] ?? '');

// Handle CSV Export
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    try {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT id, name, email, phone, project_type, location, message, is_read, is_replied, admin_notes, created_at FROM enquiries ORDER BY created_at DESC");
        $rows = $stmt->fetchAll();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=prefab-wooden-homes-leads-' . date('Y-m-d') . '.csv');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Name', 'Email', 'Phone', 'Project Type', 'Location', 'Message', 'Is Read', 'Is Replied', 'Admin Notes', 'Date']);
        foreach ($rows as $r) {
            fputcsv($output, [
                $r['id'], $r['name'], $r['email'], $r['phone'], $r['project_type'],
                $r['location'], $r['message'], $r['is_read'] ? 'Yes' : 'No',
                $r['is_replied'] ? 'Yes' : 'No', $r['admin_notes'], $r['created_at']
            ]);
        }
        fclose($output);
        exit;
    } catch (\Throwable $e) {
        setFlash('error', 'CSV export failed: ' . $e->getMessage());
    }
}

// Handle quick status changes or deletions via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    adminVerifyCsrf();
    $action = $_POST['action'] ?? '';
    $enquiryId = (int)($_POST['enquiry_id'] ?? 0);

    if ($enquiryId > 0) {
        try {
            $db = Database::getConnection();
            if ($action === 'mark_read') {
                $stmt = $db->prepare("UPDATE enquiries SET is_read = 1 WHERE id = :id");
                $stmt->execute(['id' => $enquiryId]);
                setFlash('success', 'Enquiry marked as read.');
            } elseif ($action === 'mark_replied') {
                $stmt = $db->prepare("UPDATE enquiries SET is_read = 1, is_replied = 1 WHERE id = :id");
                $stmt->execute(['id' => $enquiryId]);
                setFlash('success', 'Enquiry marked as replied.');
            } elseif ($action === 'delete') {
                $stmt = $db->prepare("DELETE FROM enquiries WHERE id = :id");
                $stmt->execute(['id' => $enquiryId]);
                setFlash('success', 'Enquiry deleted.');
            }
            header('Location: ' . url('admin/enquiries.php?status=' . urlencode($filterStatus)));
            exit;
        } catch (\Throwable $e) {
            setFlash('error', 'Operation failed: ' . $e->getMessage());
        }
    }
}

// Fetch enquiries with filters
try {
    $db = Database::getConnection();
    $sql = "SELECT * FROM enquiries WHERE 1=1";
    $params = [];

    if ($filterStatus === 'unread') {
        $sql .= " AND is_read = 0";
    } elseif ($filterStatus === 'read') {
        $sql .= " AND is_read = 1 AND is_replied = 0";
    } elseif ($filterStatus === 'replied') {
        $sql .= " AND is_replied = 1";
    }

    if (!empty($searchQuery)) {
        $sql .= " AND (name LIKE :q OR email LIKE :q OR phone LIKE :q OR location LIKE :q OR message LIKE :q)";
        $params['q'] = '%' . $searchQuery . '%';
    }

    $sql .= " ORDER BY created_at DESC";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $enquiries = $stmt->fetchAll();

    // Counts for tabs
    $counts = [
        'all' => (int)$db->query("SELECT COUNT(*) FROM enquiries")->fetchColumn(),
        'unread' => (int)$db->query("SELECT COUNT(*) FROM enquiries WHERE is_read = 0")->fetchColumn(),
        'read' => (int)$db->query("SELECT COUNT(*) FROM enquiries WHERE is_read = 1 AND is_replied = 0")->fetchColumn(),
        'replied' => (int)$db->query("SELECT COUNT(*) FROM enquiries WHERE is_replied = 1")->fetchColumn(),
    ];
} catch (\Throwable $e) {
    echo '<div class="adm-alert adm-alert--error">Database error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    $enquiries = [];
    $counts = ['all' => 0, 'unread' => 0, 'read' => 0, 'replied' => 0];
}
?>

<div class="adm-card">
    <div class="adm-card__header">
        <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
            <a href="<?= url('admin/enquiries.php?status=all') ?>" class="adm-btn <?= $filterStatus === 'all' ? 'adm-btn--primary' : 'adm-btn--outline' ?> adm-btn--sm">
                All (<?= $counts['all'] ?>)
            </a>
            <a href="<?= url('admin/enquiries.php?status=unread') ?>" class="adm-btn <?= $filterStatus === 'unread' ? 'adm-btn--primary' : 'adm-btn--outline' ?> adm-btn--sm">
                Unread (<?= $counts['unread'] ?>)
            </a>
            <a href="<?= url('admin/enquiries.php?status=read') ?>" class="adm-btn <?= $filterStatus === 'read' ? 'adm-btn--primary' : 'adm-btn--outline' ?> adm-btn--sm">
                Read (<?= $counts['read'] ?>)
            </a>
            <a href="<?= url('admin/enquiries.php?status=replied') ?>" class="adm-btn <?= $filterStatus === 'replied' ? 'adm-btn--primary' : 'adm-btn--outline' ?> adm-btn--sm">
                Replied (<?= $counts['replied'] ?>)
            </a>
        </div>

        <div style="display: flex; align-items: center; gap: 0.75rem; flex-shrink: 0;">
            <a href="<?= url('admin/enquiries.php?export=csv') ?>" class="adm-btn adm-btn--outline adm-btn--sm" title="Download all leads as spreadsheet">
                <i class="fas fa-file-csv"></i> Export CSV
            </a>
        </div>
    </div>

    <!-- Search Bar -->
    <form method="GET" action="" style="margin-bottom: 1.5rem; display: flex; gap: 0.75rem; flex-wrap: wrap;">
        <input type="hidden" name="status" value="<?= htmlspecialchars($filterStatus) ?>">
        <input type="text" name="q" class="adm-input" placeholder="Search by name, email, phone, location or message keyword..." value="<?= htmlspecialchars($searchQuery) ?>" style="max-width: 500px; flex: 1 1 240px;">
        <button type="submit" class="adm-btn adm-btn--primary adm-btn--sm">
            <i class="fas fa-search"></i> Search
        </button>
        <?php if (!empty($searchQuery)): ?>
            <a href="<?= url('admin/enquiries.php?status=' . urlencode($filterStatus)) ?>" class="adm-btn adm-btn--outline adm-btn--sm">Clear</a>
        <?php endif; ?>
    </form>

    <?php if (empty($enquiries)): ?>
        <p style="color: var(--adm-text-muted); font-size: 0.95rem; text-align: center; padding: 2.5rem 0;">
            No enquiries found matching your filter.
        </p>
    <?php else: ?>
        <div class="adm-table-responsive">
            <table class="adm-table">
                <thead>
                    <tr>
                        <th style="min-width: 80px;">Status</th>
                        <th style="min-width: 190px;">Client Details</th>
                        <th style="min-width: 160px;">Interest / Location</th>
                        <th style="min-width: 240px;">Message Preview</th>
                        <th style="min-width: 120px;">Received On</th>
                        <th style="min-width: 120px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($enquiries as $e): ?>
                        <tr>
                            <td>
                                <?php if ($e['is_replied']): ?>
                                    <span class="adm-badge adm-badge--replied">Replied</span>
                                <?php elseif ($e['is_read']): ?>
                                    <span class="adm-badge adm-badge--read">Read</span>
                                <?php else: ?>
                                    <span class="adm-badge adm-badge--unread">New</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($e['name']) ?></strong>
                                <div style="font-size: 0.78rem; color: var(--adm-text-muted);">
                                    <a href="mailto:<?= htmlspecialchars($e['email']) ?>" style="color: var(--adm-gold);"><?= htmlspecialchars($e['email']) ?></a>
                                </div>
                                <?php if (!empty($e['phone'])): ?>
                                    <div style="font-size: 0.78rem; color: var(--adm-text-muted);">
                                        <a href="tel:<?= htmlspecialchars(formatPhoneLink($e['phone'])) ?>"><?= htmlspecialchars($e['phone']) ?></a>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div style="font-weight: 600; text-transform: capitalize; font-size: 0.85rem; color: var(--adm-text);">
                                    <?= htmlspecialchars($e['project_type'] ?: 'General Consultation') ?>
                                </div>
                                <div style="font-size: 0.75rem; color: var(--adm-text-muted);">
                                    <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($e['location'] ?: 'Not specified') ?>
                                </div>
                            </td>
                            <td style="max-width: 320px;">
                                <div style="font-size: 0.82rem; color: var(--adm-text-muted); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    <?= htmlspecialchars($e['message']) ?>
                                </div>
                                <?php if (!empty($e['admin_notes'])): ?>
                                    <div style="font-size: 0.72rem; color: var(--adm-gold); margin-top: 2px;">
                                        <i class="fas fa-sticky-note"></i> Note: <?= htmlspecialchars(substr($e['admin_notes'], 0, 50)) ?>...
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td style="font-size: 0.78rem; color: var(--adm-text-muted); white-space: nowrap;">
                                <?= date('M d, Y', strtotime($e['created_at'])) ?><br>
                                <small><?= date('h:i A', strtotime($e['created_at'])) ?></small>
                            </td>
                            <td style="white-space: nowrap;">
                                <div style="display: flex; gap: 0.35rem; align-items: center;">
                                    <a href="<?= url('admin/enquiry-view.php?id=' . $e['id']) ?>" class="adm-btn adm-btn--outline adm-btn--sm" title="View Full Details">
                                        <i class="fas fa-eye"></i> View
                                    </a>

                                    <form method="POST" action="" style="display: inline;">
                                        <?= adminCsrfField() ?>
                                        <input type="hidden" name="enquiry_id" value="<?= $e['id'] ?>">
                                        <?php if (!$e['is_read']): ?>
                                            <button type="submit" name="action" value="mark_read" class="adm-btn adm-btn--outline adm-btn--sm" title="Mark as Read">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        <?php endif; ?>
                                        <button type="submit" name="action" value="delete" class="adm-btn adm-btn--danger adm-btn--sm adm-btn-delete" data-item="enquiry from <?= htmlspecialchars($e['name']) ?>" title="Delete Enquiry">
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
