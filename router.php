<?php
/**
 * Local Development Router for PHP Built-in Server
 * Emulates Apache .htaccess rewrite rules
 */

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = __DIR__ . $uri;

// 1. If it's an existing file or directory, let PHP built-in server serve it directly
if ($uri !== '/' && file_exists($path) && !is_dir($path)) {
    return false;
}

// 2. Homepage
if ($uri === '/' || $uri === '/index.php') {
    require __DIR__ . '/index.php';
    exit;
}

// 3. Clean page rewrites
$cleanRoutes = [
    '/about'          => '/pages/about.php',
    '/construction'   => '/pages/construction.php',
    '/projects'       => '/pages/projects.php',
    '/process'        => '/pages/process.php',
    '/why-wooden'     => '/pages/why-wooden.php',
    '/faq'            => '/pages/faq.php',
    '/contact'        => '/pages/contact.php',
    '/submit-enquiry' => '/pages/submit-enquiry.php',
];

if (isset($cleanRoutes[$uri])) {
    require __DIR__ . $cleanRoutes[$uri];
    exit;
}

// 4. Direct PHP file under pages
if (preg_match('#^/pages/([a-zA-Z0-9_-]+)\.php$#', $uri, $matches)) {
    $target = __DIR__ . '/pages/' . $matches[1] . '.php';
    if (file_exists($target)) {
        require $target;
        exit;
    }
}

// 5. 404 Fallback
http_response_code(404);
if (file_exists(__DIR__ . '/pages/404.php')) {
    require __DIR__ . '/pages/404.php';
} else {
    echo "404 Not Found";
}
exit;
