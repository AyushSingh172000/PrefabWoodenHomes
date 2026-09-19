<?php
/**
 * Admin Login Page - Prefab Wooden Homes
 */
require_once __DIR__ . '/includes/auth.php';

if (isUserLoggedIn()) {
    header('Location: ' . url('admin/index.php'));
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $csrf = $_POST['csrf_token'] ?? '';

    if (!validateCSRFToken($csrf)) {
        $error = 'Session expired. Please try again.';
    } elseif (empty($usernameOrEmail) || empty($password)) {
        $error = 'Please enter both username and password.';
    } else {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT * FROM admin_users WHERE (username = :uname OR email = :uemail) AND is_active = 1 LIMIT 1");
            $stmt->execute(['uname' => $usernameOrEmail, 'uemail' => $usernameOrEmail]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                // Successful login
                session_regenerate_id(true);
                $_SESSION['admin_user_id'] = $user['id'];
                $_SESSION['admin_user_name'] = $user['username'];
                $_SESSION['admin_user_email'] = $user['email'];
                $_SESSION['admin_user_role'] = $user['role'];

                // Update last login
                $updateStmt = $db->prepare("UPDATE admin_users SET last_login = NOW() WHERE id = :id");
                $updateStmt->execute(['id' => $user['id']]);

                $redirect = $_SESSION['admin_redirect'] ?? url('admin/index.php');
                unset($_SESSION['admin_redirect']);
                header('Location: ' . $redirect);
                exit;
            } else {
                $error = 'Invalid username/email or password.';
            }
        } catch (\Throwable $e) {
            $error = 'Database connection error. Please try again later.';
        }
    }
}

$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Prefab Wooden Homes</title>
    <link rel="icon" type="image/png" href="<?= htmlspecialchars(getSetting('site_favicon', asset('images/favicon.png'))) ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= url('admin/assets/css/admin.css') ?>">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at 50% 30%, #0E221B 0%, #06100C 100%);
            padding: 1.5rem;
        }
        .adm-login-card {
            width: 100%;
            max-width: 420px;
            background: rgba(14, 34, 27, 0.9);
            border: 1px solid var(--adm-border);
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.6), 0 0 40px var(--adm-gold-glow);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        .adm-login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .adm-login-logo {
            height: 60px;
            width: auto;
            max-width: 160px;
            border-radius: 12px;
            object-fit: contain;
            filter: drop-shadow(0 4px 16px rgba(0, 0, 0, 0.55)) drop-shadow(0 0 14px rgba(212, 175, 55, 0.3));
            margin-bottom: 1rem;
            transition: transform 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
        }
        .adm-login-logo:hover {
            transform: scale(1.05);
        }
        .adm-login-title {
            font-family: var(--font-serif);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--adm-text);
        }
        .adm-login-subtitle {
            font-size: 0.8rem;
            color: var(--adm-gold);
            text-transform: uppercase;
            letter-spacing: 0.12em;
            margin-top: 0.25rem;
        }
        .adm-credentials-hint {
            margin-top: 1.5rem;
            padding: 0.85rem;
            background: rgba(212, 175, 55, 0.08);
            border: 1px dashed rgba(212, 175, 55, 0.3);
            border-radius: var(--adm-radius-sm);
            font-size: 0.78rem;
            color: var(--adm-gold-light);
            text-align: center;
        }
    </style>
</head>
<body>

<div class="adm-login-card">
    <div class="adm-login-header">
        <img src="<?= htmlspecialchars(getSetting('site_logo', asset('images/logo.jpeg'))) ?>" alt="<?= htmlspecialchars(getSetting('site_name', SITE_NAME)) ?> Logo" class="adm-login-logo">
        <h2 class="adm-login-title">Prefab Wooden Homes</h2>
        <div class="adm-login-subtitle">Executive Admin Console</div>
    </div>

    <?php if (!empty($error)): ?>
        <div class="adm-alert adm-alert--error">
            <i class="fas fa-exclamation-circle"></i>
            <span><?= htmlspecialchars($error) ?></span>
        </div>
    <?php endif; ?>

    <?php if ($flash): ?>
        <div class="adm-alert adm-alert--<?= $flash['type'] === 'success' ? 'success' : 'error' ?>">
            <i class="fas fa-check-circle"></i>
            <span><?= htmlspecialchars($flash['message']) ?></span>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <?= adminCsrfField() ?>
        
        <div class="adm-form-group">
            <label for="username" class="adm-form-label">Username or Email</label>
            <input type="text" id="username" name="username" class="adm-input" placeholder="admin or aman@prefabwoodenhomes.com" required autofocus value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
        </div>

        <div class="adm-form-group">
            <label for="password" class="adm-form-label">Password</label>
            <input type="password" id="password" name="password" class="adm-input" placeholder="••••••••••••" required>
        </div>

        <button type="submit" class="adm-btn adm-btn--primary" style="width: 100%; justify-content: center; padding: 0.85rem;">
            <i class="fas fa-sign-in-alt"></i> Sign In to Dashboard
        </button>
    </form>

    <div class="adm-credentials-hint">
        <i class="fas fa-shield-alt"></i> Default Login: <strong>admin</strong> / <strong>Admin@123</strong>
    </div>
</div>

</body>
</html>
