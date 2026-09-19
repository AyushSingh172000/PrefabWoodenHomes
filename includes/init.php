<?php
/**
 * Core Initialization - Prefab Wooden Homes
 * Loads configuration, security functions, helper functions,
 * sets security headers, and initializes CSRF protection.
 */

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/functions.php';

setSecurityHeaders();
$csrfToken = generateCSRFToken();
