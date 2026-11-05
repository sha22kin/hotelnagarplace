<?php
/**
 * Local development router that mirrors the cPanel setup, where the project
 * root (not public/) is the web root and assets are linked as /public/...
 *
 *   php -S 127.0.0.1:8000 -t . bootstrap/dev-router.php
 *
 * Not used in production (the bootstrap/ folder is blocked by .htaccess).
 */
$root = dirname(__DIR__);
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/');

// Same protection as the root .htaccess.
if (preg_match('#^/(\.|app/|bootstrap/|config/|database/|resources/|routes/|storage/|tests/|vendor/|node_modules/)#', $uri)
    || preg_match('#(^|/)\.(?!well-known/)#', $uri)) {
    http_response_code(403);
    exit('Forbidden');
}

// Static files under /public/... (or directly under public/) are served as-is.
if ($uri !== '/' && str_starts_with($uri, '/public/') && is_file($root.$uri)) {
    return false;
}
if ($uri !== '/' && is_file($root.'/public'.$uri) && !str_ends_with($uri, '.php')) {
    $file = $root.'/public'.$uri;
    $types = ['css' => 'text/css', 'js' => 'application/javascript', 'png' => 'image/png', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'gif' => 'image/gif', 'webp' => 'image/webp', 'svg' => 'image/svg+xml', 'ico' => 'image/x-icon', 'woff2' => 'font/woff2', 'woff' => 'font/woff', 'txt' => 'text/plain'];
    header('Content-Type: '.($types[strtolower(pathinfo($file, PATHINFO_EXTENSION))] ?? 'application/octet-stream'));
    readfile($file);
    return true;
}

$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = $root.'/index.php';
require $root.'/public/index.php';
