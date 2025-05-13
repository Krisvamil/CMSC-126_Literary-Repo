<?php
declare(strict_types=1);

// -----------------------------------------------------------------------------
// 0. ENVIRONMENT SETTINGS (Toggle error reporting via .env or runtime flag)
// -----------------------------------------------------------------------------
$isDev = ($_ENV['APP_ENV'] ?? 'production') === 'development';

ini_set('display_errors', $isDev ? '1' : '0');
ini_set('display_startup_errors', $isDev ? '1' : '0');
error_reporting($isDev ? E_ALL : 0);

// -----------------------------------------------------------------------------
// 1. START SESSION
// -----------------------------------------------------------------------------
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// -----------------------------------------------------------------------------
// 2. FORCE HTTPS EARLY
// -----------------------------------------------------------------------------
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
    header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], true, 301);
    exit;
}

// -----------------------------------------------------------------------------
// 3. CORS HANDLING: Preflight & Simple Requests
// -----------------------------------------------------------------------------
$origin = $_SERVER['HTTP_ORIGIN'] ?? '*';
header("Access-Control-Allow-Origin: {$origin}");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// -----------------------------------------------------------------------------
// 4. GENERATE CSP NONCE & HEADERS
// -----------------------------------------------------------------------------
$nonce = base64_encode(random_bytes(16));
$GLOBALS['csp_nonce'] = $nonce;

$cspDirectives = [
    "default-src 'self';",
    "script-src 'self' 'nonce-{$nonce}';",
    "script-src-elem 'self' 'nonce-{$nonce}';",
    "style-src 'self';",
    "style-src-elem 'self';",
    "img-src 'self' data:;",
    "font-src 'self';",
    "object-src 'none';",
    "frame-ancestors 'none';",
];
header('Content-Security-Policy: ' . implode(' ', $cspDirectives));
header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Cross-Origin-Opener-Policy: same-origin');
header('X-XSS-Protection: 1; mode=block');
header('X-Permitted-Cross-Domain-Policies: none');
header('Content-Type: text/html; charset=utf-8');

// -----------------------------------------------------------------------------
// 5. DISALLOW UNSUPPORTED METHODS
// -----------------------------------------------------------------------------
$method = $_SERVER['REQUEST_METHOD'];
if (in_array($method, ['TRACE', 'TRACK'], true)) {
    http_response_code(405);
    exit;
}

// -----------------------------------------------------------------------------
// 6. BOOTSTRAP APP
// -----------------------------------------------------------------------------
require __DIR__ . '/../vendor/autoload.php';
$config = require __DIR__ . '/../config/config.php';
date_default_timezone_set($config['timezone'] ?? 'UTC');
require __DIR__ . '/../config/db.php';

// -----------------------------------------------------------------------------
// 7. PARSE REQUEST URI
// -----------------------------------------------------------------------------
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestUri = '/' . trim(preg_replace('#^/public#', '', $requestUri), '/');

// -----------------------------------------------------------------------------
// 8. LOAD ROUTES
// -----------------------------------------------------------------------------
$routes = [];
foreach (glob(__DIR__ . '/../app/routes/*.php') as $file) {
    $routes = array_merge($routes, require $file);
}

// -----------------------------------------------------------------------------
// 9. DISPATCH ROUTE
// -----------------------------------------------------------------------------
try {
    $handled = false;

    foreach ($routes as $route) {
        if (
            !isset($route['method'], $route['pattern'], $route['controller'], $route['action'])
        ) {
            continue;
        }

        if (strcasecmp($route['method'], $method) !== 0) {
            continue;
        }

        if (preg_match($route['pattern'], $requestUri, $matches)) {
            array_shift($matches);

            $className = "\\App\\Controllers\\{$route['controller']}";
            if (!class_exists($className)) {
                throw new RuntimeException("Controller not found: {$className}");
            }

            $controller = new $className();

            if (!method_exists($controller, $route['action'])) {
                throw new RuntimeException("Action '{$route['action']}' not found in controller {$className}");
            }

            call_user_func_array([$controller, $route['action']], $matches);
            $handled = true;
            break;
        }
    }

    if (!$handled) {
        http_response_code(404);
        include __DIR__ . '/../app/views/errors/404.php';
    }
} catch (\Throwable $e) {
    http_response_code(500);
    include __DIR__ . '/../app/views/errors/500.php';
}
