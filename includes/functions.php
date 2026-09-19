<?php
/**
 * Helper Functions - Prefab Wooden Homes
 */

/**
 * Get dynamic site setting from database with constant fallback
 */
function getSetting(string $key, string $default = ''): string {
    static $settingsCache = null;
    if ($settingsCache === null) {
        $settingsCache = [];
        try {
            require_once __DIR__ . '/../config/database.php';
            $db = Database::getConnection();
            $stmt = $db->query("SELECT setting_key, setting_value FROM site_settings");
            while ($row = $stmt->fetch()) {
                $settingsCache[$row['setting_key']] = $row['setting_value'];
            }
        } catch (\Throwable $e) {
            // DB fallback
        }
    }
    return $settingsCache[$key] ?? $default;
}

/**
 * Return asset URL with dynamic base path
 */
function asset(string $path): string {
    return BASE_PATH . '/assets/' . ltrim($path, '/');
}

/**
 * Return internal page URL with dynamic base path
 */
function url(string $path = ''): string {
    $trimmed = ltrim($path, '/');
    return BASE_PATH . ($trimmed !== '' ? '/' . $trimmed : '/');
}

/**
 * Get active page class for navigation
 */
function isActivePage(string $page): string {
    $currentPage = basename($_SERVER['PHP_SELF'], '.php');
    if ($currentPage === 'index' && $page === 'home') return 'active';
    return ($currentPage === $page) ? 'active' : '';
}

/**
 * Format phone for tel: link
 */
function formatPhoneLink(string $phone): string {
    return preg_replace('/[^\d+]/', '', $phone);
}

/**
 * Generate SEO meta tags
 */
function seoMeta(string $title, string $description, string $keywords = '', string $ogImage = ''): string {
    $siteName = SITE_NAME;
    $siteUrl = SITE_URL;
    $fullTitle = $title . ' | ' . $siteName;
    $ogImg = $ogImage ?: $siteUrl . '/assets/images/og-default.jpg';
    $reqUri = $_SERVER['REQUEST_URI'] ?? '/';
    $schemeHost = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? 'localhost');
    $canonicalUrl = $schemeHost . $reqUri;

    return <<<HTML
    <title>{$fullTitle}</title>
    <meta name="description" content="{$description}">
    <meta name="keywords" content="{$keywords}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{$canonicalUrl}">
    <meta property="og:title" content="{$fullTitle}">
    <meta property="og:description" content="{$description}">
    <meta property="og:image" content="{$ogImg}">
    <meta property="og:url" content="{$canonicalUrl}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{$siteName}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{$fullTitle}">
    <meta name="twitter:description" content="{$description}">
    <meta name="twitter:image" content="{$ogImg}">
HTML;
}

/**
 * Truncate text
 */
function truncateText(string $text, int $length = 150): string {
    if (strlen($text) <= $length) return $text;
    return substr($text, 0, $length) . '...';
}

/**
 * Generate structured data JSON-LD for the business
 */
function businessSchema(): string {
    $schema = [
        "@context" => "https://schema.org",
        "@type" => "HomeAndConstructionBusiness",
        "name" => SITE_NAME,
        "description" => SITE_DESCRIPTION,
        "url" => SITE_URL,
        "telephone" => CONTACT_PHONE_AMAN,
        "email" => CONTACT_EMAIL,
        "address" => [
            "@type" => "PostalAddress",
            "streetAddress" => "206 Fauzi Chowk, Dera Village, Near Fatehpur, Chhatarpur",
            "addressLocality" => "New Delhi",
            "addressRegion" => "Delhi",
            "postalCode" => "110074",
            "addressCountry" => "IN"
        ],
        "founder" => [
            "@type" => "Person",
            "name" => "Aman Jha"
        ],
        "areaServed" => "India",
        "priceRange" => "₹₹₹"
    ];
    return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES) . '</script>';
}
