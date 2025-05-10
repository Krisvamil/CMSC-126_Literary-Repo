<?php
declare(strict_types=1);
namespace App\Utils;

class Logger {
    private string $file;
    public function __construct(string $file) { $this->file = $file; }
    private function write(string $lvl, string $msg): void {
        $line = '['.date('Y-m-d H:i:s')."] {$lvl}: {$msg}\n";
        file_put_contents($this->file,$line,FILE_APPEND|LOCK_EX);
    }
    public function info(string $m): void  { $this->write('INFO',$m); }
    public function error(string $m): void { $this->write('ERROR',$m); }
}
