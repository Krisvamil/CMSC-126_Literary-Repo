<?php
declare(strict_types=1);

// Bootstrapping
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/db.php';

// Load routes
$routes = [];
foreach (glob(APP_DIR . '/routes/*.php') as $file) {
    $map = require $file;
    $routes = array_merge($routes, $map);
}

// Dispatch
$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$key    = $_SERVER['REQUEST_METHOD'] . ' ' . $uri;

if (isset($routes[$key])) {
    [$controllerClass, $action] = $routes[$key];
    /** @var \App\Controllers\BaseController $controller */
    $controller = new $controllerClass();
    $controller->{$action}();
} else {
    http_response_code(404);
    require VIEWS_DIR . '/errors/404.php';
}
