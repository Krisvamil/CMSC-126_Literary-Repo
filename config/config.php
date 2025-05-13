<?php
declare(strict_types=1);

// -----------------------------------------------------------------------------
// 0. DIRECTORY CONSTANTS
// -----------------------------------------------------------------------------
define('BASE_DIR',        realpath(__DIR__ . '/../'));
define('APP_DIR',         BASE_DIR . '/app');
define('PUBLIC_DIR',      BASE_DIR . '/public');
define('VIEWS_DIR',       APP_DIR . '/views');
define('MIGRATIONS_DIR',  BASE_DIR . '/migrations');
define('STORAGE_DIR',     BASE_DIR . '/storage');
define('LOGS_DIR',        STORAGE_DIR . '/logs');
define('SESSIONS_DIR',    STORAGE_DIR . '/sessions');
define('CACHE_DIR',       STORAGE_DIR . '/cache');

// -----------------------------------------------------------------------------
// 1. LOAD .env FILE INTO $_ENV + putenv
// -----------------------------------------------------------------------------
$envFile = BASE_DIR . '/.env';
if (is_readable($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) continue;

        [$k, $v] = explode('=', $line, 2) + [null, null];
        if ($k && $v !== null && getenv($k) === false) {
            $v = trim($v, "\"'"); // Strip quotes
            putenv("$k=$v");
            $_ENV[$k] = $v;
            $_SERVER[$k] = $v;
        }
    }
}

// -----------------------------------------------------------------------------
// 2. ENV HELPER FUNCTION
// -----------------------------------------------------------------------------
function env(string $key, $default = null): mixed {
    return $_ENV[$key] ?? getenv($key) ?: $default;
}

// -----------------------------------------------------------------------------
// 3. ERROR LOGGING CONFIG
// -----------------------------------------------------------------------------
$isDebug = env('APP_DEBUG', 'false') === 'true';
ini_set('display_errors', $isDebug ? '1' : '0');
ini_set('log_errors', '1');
ini_set('error_log', LOGS_DIR . '/app.log');
error_reporting($isDebug ? E_ALL : 0);

// -----------------------------------------------------------------------------
// 4. ENSURE STORAGE PATHS EXIST
// -----------------------------------------------------------------------------
foreach ([LOGS_DIR, SESSIONS_DIR, CACHE_DIR] as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// -----------------------------------------------------------------------------
// 5. BASE URL HELPER
// -----------------------------------------------------------------------------
define('BASE_URL', rtrim(env('BASE_URL', '/public'), '/'));
function url(string $path): string {
    return BASE_URL . '/' . ltrim($path, '/');
}

// -----------------------------------------------------------------------------
// 6. DATABASE CONSTANTS
// -----------------------------------------------------------------------------
define('DB_HOST',    env('DB_HOST', '127.0.0.1'));
define('DB_NAME',    env('DB_NAME', 'literary_repo'));
define('DB_USER',    env('DB_USER', 'root'));
define('DB_PASS',    env('DB_PASS', ''));
define('DB_CHARSET', env('DB_CHARSET', 'utf8mb4'));

// -----------------------------------------------------------------------------
// 7. RETURN CONFIG ARRAY
// -----------------------------------------------------------------------------
return [
    // Database
    'db_host'    => DB_HOST,
    'db_name'    => DB_NAME,
    'db_user'    => DB_USER,
    'db_pass'    => DB_PASS,
    'db_charset' => DB_CHARSET,

    // URL
    'base_url'   => BASE_URL,

    // Timezone
    'timezone'   => env('APP_TIMEZONE', 'UTC'),
];
