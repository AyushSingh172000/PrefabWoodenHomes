<?php
/**
 * Admin Logout Handler
 */
require_once __DIR__ . '/includes/auth.php';

$_SESSION = [];
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

// Start new session just to flash logged out message
session_start();
setFlash('success', 'You have been safely signed out.');
header('Location: ' . url('admin/login.php'));
exit;
