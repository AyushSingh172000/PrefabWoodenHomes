<?php
/**
 * Admin Profile & Password Management
 */
require_once __DIR__ . '/includes/auth.php';
requireAdminLogin();

$user = currentAdmin();
$userId = (int)($user['id'] ?? 0);
$error = '';

try {
    $db = Database::getConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        adminVerifyCsrf();
        $action = $_POST['action'] ?? '';

        if ($action === 'update_profile') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');

            if (empty($username) || strlen($username) < 3 || !preg_match('/^[a-zA-Z0-9_.-]+$/', $username)) {
                $error = 'Username must be at least 3 characters and contain only letters, numbers, hyphens, or underscores.';
            } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Please enter a valid email address.';
            } else {
                // Check uniqueness
                $checkStmt = $db->prepare("SELECT id FROM admin_users WHERE (username = :u OR email = :e) AND id != :id LIMIT 1");
                $checkStmt->execute(['u' => $username, 'e' => $email, 'id' => $userId]);
                if ($checkStmt->fetch()) {
                    $error = 'Username or email is already in use by another account.';
                } else {
                    $stmt = $db->prepare("UPDATE admin_users SET username = :u, email = :e WHERE id = :id");
                    $stmt->execute(['u' => $username, 'e' => $email, 'id' => $userId]);
                    $_SESSION['admin_user_name'] = $username;
                    $_SESSION['admin_user_email'] = $email;
                    setFlash('success', 'Profile and username updated successfully.');
                    header('Location: ' . url('admin/profile.php'));
                    exit;
                }
            }
        } elseif ($action === 'change_password') {
            $currentPass = $_POST['current_password'] ?? '';
            $newPass = $_POST['new_password'] ?? '';
            $confirmPass = $_POST['confirm_password'] ?? '';

            $stmt = $db->prepare("SELECT password_hash FROM admin_users WHERE id = :id LIMIT 1");
            $stmt->execute(['id' => $userId]);
            $userRow = $stmt->fetch();

            if (empty($currentPass) || empty($newPass)) {
                $error = 'Please fill in all password fields.';
            } elseif (!$userRow || !password_verify($currentPass, $userRow['password_hash'])) {
                $error = 'Current password is incorrect.';
            } elseif (strlen($newPass) < 6) {
                $error = 'New password must be at least 6 characters long.';
            } elseif ($newPass !== $confirmPass) {
                $error = 'New password and confirmation do not match.';
            } else {
                $newHash = password_hash($newPass, PASSWORD_BCRYPT);
                $stmt = $db->prepare("UPDATE admin_users SET password_hash = :hash WHERE id = :id");
                $stmt->execute(['hash' => $newHash, 'id' => $userId]);
                setFlash('success', 'Password changed successfully.');
                header('Location: ' . url('admin/profile.php'));
                exit;
            }
        }
    }

    $stmt = $db->prepare("SELECT * FROM admin_users WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $userId]);
    $currentUser = $stmt->fetch();

} catch (\Throwable $e) {
    $error = 'Database error: ' . $e->getMessage();
}

$pageTitle = 'My Profile';
require_once __DIR__ . '/includes/admin-header.php';
?>

<?php if (!empty($error)): ?>
    <div class="adm-alert adm-alert--error">
        <i class="fas fa-exclamation-circle"></i>
        <span><?= htmlspecialchars($error) ?></span>
    </div>
<?php endif; ?>

<div class="adm-form-grid" style="grid-template-columns: repeat(auto-fit, minmax(360px, 1fr));">
    <!-- Profile Info -->
    <div class="adm-card">
        <div class="adm-card__header">
            <h2 class="adm-card__title"><i class="fas fa-user-circle"></i> Account Details</h2>
        </div>
        <form method="POST" action="">
            <?= adminCsrfField() ?>
            <input type="hidden" name="action" value="update_profile">

            <div class="adm-form-group">
                <label class="adm-form-label">Username <span class="req">*</span></label>
                <input type="text" name="username" class="adm-input" value="<?= htmlspecialchars($currentUser['username'] ?? '') ?>" required placeholder="e.g. admin">
                <small style="color: var(--adm-text-muted); font-size: 0.75rem;">Used to log into the admin dashboard.</small>
            </div>

            <div class="adm-form-group">
                <label class="adm-form-label">Role</label>
                <span class="adm-badge adm-badge--featured"><?= htmlspecialchars($currentUser['role'] ?? 'editor') ?></span>
            </div>

            <div class="adm-form-group">
                <label class="adm-form-label">Email Address <span class="req">*</span></label>
                <input type="email" name="email" class="adm-input" value="<?= htmlspecialchars($currentUser['email'] ?? '') ?>" required>
            </div>

            <button type="submit" class="adm-btn adm-btn--primary">
                <i class="fas fa-save"></i> Save Profile
            </button>
        </form>
    </div>

    <!-- Password Change -->
    <div class="adm-card">
        <div class="adm-card__header">
            <h2 class="adm-card__title"><i class="fas fa-key"></i> Change Password</h2>
        </div>
        <form method="POST" action="">
            <?= adminCsrfField() ?>
            <input type="hidden" name="action" value="change_password">

            <div class="adm-form-group">
                <label class="adm-form-label">Current Password <span class="req">*</span></label>
                <input type="password" name="current_password" class="adm-input" placeholder="••••••••••••" required>
            </div>

            <div class="adm-form-group">
                <label class="adm-form-label">New Password <span class="req">*</span></label>
                <input type="password" name="new_password" class="adm-input" placeholder="Minimum 6 characters" minlength="6" required>
            </div>

            <div class="adm-form-group">
                <label class="adm-form-label">Confirm New Password <span class="req">*</span></label>
                <input type="password" name="confirm_password" class="adm-input" placeholder="Re-enter new password" minlength="6" required>
            </div>

            <button type="submit" class="adm-btn adm-btn--primary">
                <i class="fas fa-lock"></i> Update Password
            </button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
