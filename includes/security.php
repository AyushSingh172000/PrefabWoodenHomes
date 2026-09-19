<?php
/**
 * Security Functions - Prefab Wooden Homes
 */

/**
 * Generate CSRF token
 */
function generateCSRFToken(): string {
    if (empty($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

/**
 * Validate CSRF token
 */
function validateCSRFToken(string $token): bool {
    if (empty($_SESSION[CSRF_TOKEN_NAME]) || empty($token)) {
        return false;
    }
    $valid = hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
    // Regenerate after validation
    unset($_SESSION[CSRF_TOKEN_NAME]);
    return $valid;
}

/**
 * Sanitize input string
 */
function sanitizeInput(string $input): string {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    return $input;
}

/**
 * Validate email
 */
function validateEmail(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate Indian phone number
 */
function validatePhone(string $phone): bool {
    $phone = preg_replace('/[\s\-\(\)]/', '', $phone);
    return preg_match('/^(\+91|91|0)?[6-9]\d{9}$/', $phone);
}

/**
 * Rate limiting check
 */
function checkRateLimit(string $identifier): bool {
    $key = 'rate_limit_' . md5($identifier);
    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = ['count' => 0, 'start' => time()];
    }
    $data = &$_SESSION[$key];
    // Reset window if expired
    if (time() - $data['start'] > RATE_LIMIT_WINDOW) {
        $data = ['count' => 0, 'start' => time()];
    }
    $data['count']++;
    return $data['count'] <= RATE_LIMIT_MAX;
}

/**
 * Set security headers
 */
function setSecurityHeaders(): void {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://www.google.com https://www.gstatic.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com; font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; img-src 'self' data: https:; frame-src https://www.google.com https://maps.google.com;");
}

/**
 * Get client IP safely
 */
function getClientIP(): string {
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    if (filter_var($ip, FILTER_VALIDATE_IP)) {
        return $ip;
    }
    return '0.0.0.0';
}
