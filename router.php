<?php
// Local development only: php -S localhost:8000 router.php
// Mirrors the rules in .htaccess.

$path = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/');

if (preg_match('#^/(includes|data|storage)(/|$)#', $path)) {
    http_response_code(403);
    exit;
}
if ($path !== '/' && is_file(__DIR__ . $path)) {
    return false;
}
if (preg_match('#^/locations/([a-z0-9-]+)/suites/([a-z0-9-]+)/?$#', $path, $match)) {
    $_GET['location'] = $match[1];
    $_GET['suite'] = $match[2];
    require __DIR__ . '/suite.php';
    return true;
}
if (preg_match('#^/locations/([a-z0-9-]+)/?$#', $path, $match)) {
    $_GET['slug'] = $match[1];
    require __DIR__ . '/location.php';
    return true;
}
$page = trim($path, '/') ?: 'index';
require preg_match('#^[a-z0-9-]+$#', $page) && $page !== 'router' && is_file(__DIR__ . "/$page.php")
    ? __DIR__ . "/$page.php"
    : __DIR__ . '/404.php';
