<?php
declare(strict_types=1);

// ------------------------------------------------------------------
// 1. Bootstrap Core Config (constants, env vars)
// ------------------------------------------------------------------
$config = require __DIR__ . '/config.php';

// ------------------------------------------------------------------
// 2. Prepare Logging Directory (if needed)
// ------------------------------------------------------------------
if (!is_dir(LOGS_DIR)) {
    mkdir(LOGS_DIR, 0755, true);
}
ini_set('log_errors', '1');
ini_set('error_log', LOGS_DIR . '/app.log');

// ------------------------------------------------------------------
// 3. Enable MySQLi Exceptions & Strict Mode
// ------------------------------------------------------------------
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// ------------------------------------------------------------------
// 4. Initialize and Configure MySQLi
// ------------------------------------------------------------------
try {
    $mysqli = new mysqli(
        DB_HOST,
        DB_USER,
        DB_PASS,
        DB_NAME
    );

    $mysqli->set_charset(DB_CHARSET);
} catch (\mysqli_sql_exception $e) {
    error_log('[DB] Connection failed: ' . $e->getMessage());
    http_response_code(500);
    require VIEWS_DIR . '/errors/500.php';
    exit;
}

// ------------------------------------------------------------------
// 5. Expose Global DB Getter
// ------------------------------------------------------------------
/**
 * Returns global MySQLi connection.
 *
 * @return \mysqli
 */
function get_db(): \mysqli
{
    global $mysqli;
    return $mysqli;
}

// ------------------------------------------------------------------
// 6. (Optional) Auto-run Migrations in Development
// ------------------------------------------------------------------
if (env('APP_ENV', 'production') === 'local') {
    $migrationFile = MIGRATIONS_DIR . '/migrate.php';
    if (is_file($migrationFile)) {
        try {
            include_once $migrationFile;
        } catch (\Throwable $e) {
            error_log('[DB] Migration failed: ' . $e->getMessage());
        }
    }
}
