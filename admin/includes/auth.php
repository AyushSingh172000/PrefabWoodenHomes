<?php
/**
 * Admin Authentication & Session Guard - Prefab Wooden Homes
 */

require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/security.php';
require_once __DIR__ . '/../../includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!ob_get_level()) {
    ob_start();
}

/**
 * Check if current user is logged in
 */
function isUserLoggedIn(): bool {
    return !empty($_SESSION['admin_user_id']) && !empty($_SESSION['admin_user_name']);
}

/**
 * Require login for protected admin pages
 */
function requireAdminLogin(): void {
    if (!isUserLoggedIn()) {
        $_SESSION['admin_redirect'] = $_SERVER['REQUEST_URI'] ?? url('admin/');
        header('Location: ' . url('admin/login.php'));
        exit;
    }
}

/**
 * Get current logged in admin user data
 */
function currentAdmin(): array {
    return [
        'id' => $_SESSION['admin_user_id'] ?? null,
        'username' => $_SESSION['admin_user_name'] ?? 'Admin',
        'email' => $_SESSION['admin_user_email'] ?? '',
        'role' => $_SESSION['admin_user_role'] ?? 'editor'
    ];
}

/**
 * Check if current user has 'admin' role
 */
function isSuperAdmin(): bool {
    return (currentAdmin()['role'] ?? '') === 'admin';
}

/**
 * Set flash alert message
 */
function setFlash(string $type, string $message): void {
    $_SESSION['flash_message'] = [
        'type' => $type, // success, error, warning, info
        'message' => $message
    ];
}

/**
 * Get and clear flash message
 */
function getFlash(): ?array {
    if (!empty($_SESSION['flash_message'])) {
        $msg = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $msg;
    }
    return null;
}

/**
 * Generate CSRF hidden input field for admin forms
 */
function adminCsrfField(): string {
    $token = generateCSRFToken();
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
}

/**
 * Verify CSRF token from POST
 */
function adminVerifyCsrf(): void {
    $token = $_POST['csrf_token'] ?? '';
    if (!validateCSRFToken($token)) {
        setFlash('error', 'Security token expired or invalid. Please try again.');
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? url('admin/')));
        exit;
    }
}

/**
 * Sanitize admin text inputs
 */
function cleanInput(string $val): string {
    return trim(htmlspecialchars($val, ENT_QUOTES, 'UTF-8'));
}
