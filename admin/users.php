<?php
/**
 * Team Users Management - Prefab Wooden Homes
 */
require_once __DIR__ . '/includes/auth.php';
requireAdminLogin();

if (!isSuperAdmin()) {
    $pageTitle = 'Access Denied';
    require_once __DIR__ . '/includes/admin-header.php';
    echo '<div class="adm-alert adm-alert--error">Access denied. Superadmin privileges required.</div>';
    require_once __DIR__ . '/includes/admin-footer.php';
    exit;
}

$error = '';

try {
    $db = Database::getConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        adminVerifyCsrf();
        $action = $_POST['action'] ?? '';

        if ($action === 'create_user') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = in_array($_POST['role'], ['admin', 'editor']) ? $_POST['role'] : 'editor';

            if (empty($username) || empty($email) || empty($password)) {
                $error = 'All fields are required.';
            } elseif (strlen($password) < 6) {
                $error = 'Password must be at least 6 characters.';
            } else {
                $hash = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $db->prepare("INSERT INTO admin_users (username, email, password_hash, role, is_active) VALUES (:u, :e, :p, :r, 1)");
                $stmt->execute(['u' => $username, 'e' => $email, 'p' => $hash, 'r' => $role]);
                setFlash('success', "User '{$username}' added successfully.");
                header('Location: ' . url('admin/users.php'));
                exit;
            }
        } elseif ($action === 'toggle_active') {
            $uid = (int)($_POST['user_id'] ?? 0);
            if ($uid !== (int)$user['id']) {
                $stmt = $db->prepare("UPDATE admin_users SET is_active = NOT is_active WHERE id = :id");
                $stmt->execute(['id' => $uid]);
                setFlash('success', 'User active status updated.');
            } else {
                setFlash('error', 'You cannot deactivate your own account.');
            }
            header('Location: ' . url('admin/users.php'));
            exit;
        } elseif ($action === 'delete_user') {
            $uid = (int)($_POST['user_id'] ?? 0);
            if ($uid !== (int)$user['id']) {
                $stmt = $db->prepare("DELETE FROM admin_users WHERE id = :id");
                $stmt->execute(['id' => $uid]);
                setFlash('success', 'User deleted.');
            } else {
                setFlash('error', 'You cannot delete your own account.');
            }
            header('Location: ' . url('admin/users.php'));
            exit;
        }
    }

    $allUsers = $db->query("SELECT id, username, email, role, is_active, last_login, created_at FROM admin_users ORDER BY id ASC")->fetchAll();
} catch (\Throwable $e) {
    $error = 'Database error: ' . $e->getMessage();
    $allUsers = [];
}

$pageTitle = 'Team Users';
require_once __DIR__ . '/includes/admin-header.php';
?>

<?php if (!empty($error)): ?>
    <div class="adm-alert adm-alert--error">
        <i class="fas fa-exclamation-circle"></i>
        <span><?= htmlspecialchars($error) ?></span>
    </div>
<?php endif; ?>

<div class="adm-card">
    <div class="adm-card__header">
        <h2 class="adm-card__title"><i class="fas fa-users-cog"></i> Admin &amp; Staff Accounts</h2>
        <button type="button" class="adm-btn adm-btn--primary adm-btn--sm" onclick="document.getElementById('newUserForm').style.display='block'">
            <i class="fas fa-user-plus"></i> Add New User
        </button>
    </div>

    <!-- New User Modal Box -->
    <div id="newUserForm" style="display: none; margin-bottom: 2rem; padding: 1.5rem; background: var(--adm-surface-alt); border-radius: var(--adm-radius); border: 1px solid var(--adm-border);">
        <h3 style="font-size: 1rem; color: var(--adm-gold); margin-bottom: 1rem;"><i class="fas fa-user-shield"></i> Create New Team Member</h3>
        <form method="POST" action="">
            <?= adminCsrfField() ?>
            <input type="hidden" name="action" value="create_user">

            <div class="adm-form-grid">
                <div class="adm-form-group">
                    <label class="adm-form-label">Username <span class="req">*</span></label>
                    <input type="text" name="username" class="adm-input" required placeholder="e.g. rajeev">
                </div>

                <div class="adm-form-group">
                    <label class="adm-form-label">Email <span class="req">*</span></label>
                    <input type="email" name="email" class="adm-input" required placeholder="rajeev@prefabwoodenhomes.com">
                </div>

                <div class="adm-form-group">
                    <label class="adm-form-label">Password <span class="req">*</span></label>
                    <input type="password" name="password" class="adm-input" required placeholder="Minimum 6 characters" minlength="6">
                </div>

                <div class="adm-form-group">
                    <label class="adm-form-label">Role</label>
                    <select name="role" class="adm-select">
                        <option value="editor" selected>Editor (Manage content &amp; leads)</option>
                        <option value="admin">Administrator (Full permissions)</option>
                    </select>
                </div>
            </div>

            <div style="display: flex; gap: 0.75rem;">
                <button type="submit" class="adm-btn adm-btn--primary adm-btn--sm">Create User</button>
                <button type="button" class="adm-btn adm-btn--outline adm-btn--sm" onclick="document.getElementById('newUserForm').style.display='none'">Cancel</button>
            </div>
        </form>
    </div>

    <div class="adm-table-responsive">
        <table class="adm-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Last Login</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allUsers as $u): ?>
                    <tr>
                        <td>
                            <strong><?= htmlspecialchars($u['username']) ?></strong>
                            <?php if ($u['id'] == $user['id']): ?>
                                <span style="font-size: 0.7rem; color: var(--adm-gold); margin-left: 4px;">(You)</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td>
                            <span class="adm-badge adm-badge--featured"><?= htmlspecialchars($u['role']) ?></span>
                        </td>
                        <td>
                            <?php if ($u['is_active']): ?>
                                <span class="adm-badge adm-badge--active">Active</span>
                            <?php else: ?>
                                <span class="adm-badge adm-badge--draft">Disabled</span>
                            <?php endif; ?>
                        </td>
                        <td style="font-size: 0.78rem; color: var(--adm-text-muted);">
                            <?= $u['last_login'] ? date('M d, Y h:i A', strtotime($u['last_login'])) : 'Never' ?>
                        </td>
                        <td>
                            <?php if ($u['id'] != $user['id']): ?>
                                <div style="display: flex; gap: 0.35rem;">
                                    <form method="POST" action="" style="display: inline;">
                                        <?= adminCsrfField() ?>
                                        <input type="hidden" name="action" value="toggle_active">
                                        <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                        <button type="submit" class="adm-btn adm-btn--outline adm-btn--sm">
                                            <?= $u['is_active'] ? 'Disable' : 'Enable' ?>
                                        </button>
                                    </form>

                                    <form method="POST" action="" style="display: inline;">
                                        <?= adminCsrfField() ?>
                                        <input type="hidden" name="action" value="delete_user">
                                        <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                        <button type="submit" class="adm-btn adm-btn--danger adm-btn--sm adm-btn-delete" data-item="user '<?= htmlspecialchars($u['username']) ?>'">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <a href="<?= url('admin/profile.php') ?>" class="adm-btn adm-btn--outline adm-btn--sm">Edit Profile</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
