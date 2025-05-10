<?php
declare(strict_types=1);

define('BASE_DIR', realpath(__DIR__ . '/../'));
define('APP_DIR', BASE_DIR . '/app');
define('PUBLIC_DIR', BASE_DIR . '/public');
define('VIEWS_DIR', APP_DIR . '/views');
define('MIGRATIONS_DIR', BASE_DIR . '/migrations');
define('STORAGE_DIR', BASE_DIR . '/storage');
define('LOGS_DIR', STORAGE_DIR . '/logs');
define('SESSIONS_DIR', STORAGE_DIR . '/sessions');
define('CACHE_DIR', STORAGE_DIR . '/cache');

// Load .env
$envFile = BASE_DIR . '/.env';
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#') continue;
        [$k,$v] = explode('=', $line, 2) + [null,null];
        if ($k && getenv($k)===false) {
            putenv("$k=$v");
            $_ENV[$k] = $v;
        }
    }
}

// Error logging
ini_set('display_errors', getenv('APP_DEBUG')==='true'?'1':'0');
ini_set('log_errors', '1');
if (!is_dir(LOGS_DIR)) mkdir(LOGS_DIR, 0755, true);
ini_set('error_log', LOGS_DIR.'/app.log');
error_reporting(E_ALL);

// Make storage dirs
foreach ([LOGS_DIR, SESSIONS_DIR, CACHE_DIR] as $d) {
    if (!is_dir($d)) mkdir($d, 0755, true);
}

// URL & assets
define('BASE_URL', rtrim(getenv('BASE_URL')?:'/public','/'));
function url(string $path): string { return BASE_URL.'/'.ltrim($path,'/'); }

// DB creds
define('DB_HOST', getenv('DB_HOST')?:'127.0.0.1');
define('DB_NAME', getenv('DB_NAME')?:'literary_repo');
define('DB_USER', getenv('DB_USER')?:'db_user');
define('DB_PASS', getenv('DB_PASS')?:'db_pass');
define('DB_CHARSET','utf8mb4');

// Sessions
ini_set('session.save_path', SESSIONS_DIR);
session_start();
