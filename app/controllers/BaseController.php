<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Utils\Logger;

abstract class BaseController {
    protected \mysqli $db;
    protected Logger  $logger;
    public function __construct() {
        require_once BASE_DIR.'/config/db.php';
        $this->db     = get_db();
        require_once BASE_DIR.'/app/utils/Logger.php';
        $this->logger = new Logger(LOGS_DIR.'/app.log');
    }
    protected function render(string $view, array $d=[]): void {
        extract($d);
        ob_start(); require VIEWS_DIR."/{$view}.php";
        $content = ob_get_clean();
        require VIEWS_DIR.'/layout.php';
    }
    protected function redirect(string $p): void {
        header('Location: '.BASE_URL.$p); exit;
    }
    protected function flash(string $t, string $m): void {
        $_SESSION['flash'][$t] = $m;
    }
}
