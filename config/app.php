<?php
/**
 * Application Configuration - Prefab Wooden Homes
 */

// Detect local environment
$httpHost = $_SERVER['HTTP_HOST'] ?? '';
$isLocal = in_array($httpHost, ['localhost', '127.0.0.1', 'localhost:8000', 'localhost:8080']) || str_starts_with($httpHost, 'localhost:');
$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);

// Environment
define('APP_ENV', $isLocal ? 'development' : 'production');
define('APP_DEBUG', $isLocal);

// Auto-detect base path (subfolder relative to DOCUMENT_ROOT, or empty string at root)
$docRoot = isset($_SERVER['DOCUMENT_ROOT']) ? rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '/') : '';
$rootDir = rtrim(str_replace('\\', '/', realpath(__DIR__ . '/..')), '/');
$basePath = '';
if (!empty($docRoot) && str_starts_with($rootDir, $docRoot)) {
    $basePath = substr($rootDir, strlen($docRoot));
}
define('BASE_PATH', rtrim($basePath, '/'));

// Site Info
define('SITE_NAME', 'Prefab Wooden Homes');
$defaultSiteUrl = $isLocal ? (($isHttps ? 'https://' : 'http://') . ($httpHost ?: 'localhost') . BASE_PATH) : 'https://prefabwoodenhomes.com';
define('SITE_URL', $defaultSiteUrl);
define('SITE_TAGLINE', 'Design • Manufacture • Construct');
define('SITE_DESCRIPTION', 'Premium custom-designed wooden homes engineered for comfort, durability and timeless beauty. 15+ years of experience in prefab wooden house construction across India.');

// Contact Info
define('CONTACT_PHONE_AMAN', '+91 98104 33120');
define('CONTACT_PHONE_RAJEEV', '+91 95404 89349');
define('CONTACT_EMAIL', 'sales@prefabwoodenhomes.com');
define('CONTACT_EMAIL_FOUNDER', 'aman@prefabwoodenhomes.com');
define('CONTACT_WHATSAPP', '919810433120');
define('CONTACT_ADDRESS', '206 Fauzi Chowk, Dera Village, Near Fatehpur, Chhatarpur, New Delhi - 110074');

// Social Media
define('SOCIAL_FACEBOOK', 'https://www.facebook.com/prefabwoodenhomes/');
define('SOCIAL_INSTAGRAM', 'https://www.instagram.com/prefabwoodenhomes/');
define('SOCIAL_YOUTUBE', 'https://www.youtube.com/channel/UCFWuLZvWxsbdPaR2N35682w');
define('SOCIAL_TWITTER', 'https://twitter.com/');

// Security
define('CSRF_TOKEN_NAME', 'csrf_token');
define('RATE_LIMIT_MAX', 5);       // Max form submissions
define('RATE_LIMIT_WINDOW', 3600); // Per hour

// reCAPTCHA (replace with real keys)
define('RECAPTCHA_SITE_KEY', 'YOUR_RECAPTCHA_SITE_KEY');
define('RECAPTCHA_SECRET_KEY', 'YOUR_RECAPTCHA_SECRET_KEY');

// Upload limits
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'webp', 'pdf']);

// Error handling
if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/../logs/error.log');
}

// Timezone
date_default_timezone_set('Asia/Kolkata');

// Session security
ini_set('session.cookie_httponly', 1);
if ($isHttps) {
    ini_set('session.cookie_secure', 1);
}
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_samesite', 'Lax');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
