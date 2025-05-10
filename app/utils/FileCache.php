<?php
declare(strict_types=1);
namespace App\Utils;

class FileCache {
    private string $dir; private int $ttl;
    public function __construct(string $dir, int $ttl=3600) {
        $this->dir = rtrim($dir,'/'); $this->ttl = $ttl;
    }
    private function path(string $k): string {
        return "{$this->dir}/".preg_replace('/[^A-Za-z0-9_\-]/','_',$k).".cache";
    }
    public function set(string $k, mixed $v, ?int $t=null): void {
        $e = time() + ($t ?? $this->ttl);
        file_put_contents($this->path($k), serialize(['exp'=>$e,'d'=>$v]), LOCK_EX);
    }
    public function get(string $k): mixed {
        $f = $this->path($k);
        if (!is_file($f)) return null;
        $item = @unserialize(file_get_contents($f), ['allowed_classes'=>false]);
        if (!$item || $item['exp']<time()) { @unlink($f); return null; }
        return $item['d'];
    }
    public function delete(string $k): void { @unlink($this->path($k)); }
    public function clear(): void {
        foreach (glob("{$this->dir}/*.cache") as $f) @unlink($f);
    }
}
