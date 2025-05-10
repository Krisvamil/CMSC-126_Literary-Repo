<?php
declare(strict_types=1);

use mysqli, mysqli_sql_exception;

require_once __DIR__.'/config.php';

mysqli_report(MYSQLI_REPORT_ERROR|MYSQLI_REPORT_STRICT);

try {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $mysqli->set_charset(DB_CHARSET);
} catch (mysqli_sql_exception $e) {
    error_log('DB Connection Error: '.$e->getMessage());
    http_response_code(500);
    require VIEWS_DIR.'/errors/500.php';
    exit;
}

function get_db(): mysqli { global $mysqli; return $mysqli; }
