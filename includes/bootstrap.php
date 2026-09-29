<?php
declare(strict_types=1);

define('ROOT', dirname(__DIR__));
define('INC', ROOT . '/includes');
define('DATA', ROOT . '/data');

require INC . '/config.php';
require INC . '/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
    ]);
}

header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('X-Frame-Options: SAMEORIGIN');

define('BASE_URL', detect_base_url());
