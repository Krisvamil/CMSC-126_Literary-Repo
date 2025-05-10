<?php
declare(strict_types=1);

namespace App\Models;

use mysqli;
use PDO;
use Exception;

abstract class Model
{
    protected ?mysqli $db;            // allow null
    private static ?PDO $testPdo = null;

    public function __construct(?mysqli $db = null)
    {
        $this->db = $db;
    }

    public static function setTestConnection(PDO $pdo): void
    {
        self::$testPdo = $pdo;
    }

    public static function getTestConnection(): ?PDO
    {
        return self::$testPdo;
    }

    protected function query(string $sql, string $types = '', array $params = []): mixed
    {
        if (self::$testPdo) {
            // Use PDO in tests
            $stmt = self::$testPdo->prepare($sql);
            if ($types) {
                $pos = 1;
                foreach (str_split($types) as $t) {
                    $stmt->bindValue(
                        $pos++,
                        array_shift($params),
                        $t === 'i' ? PDO::PARAM_INT : PDO::PARAM_STR
                    );
                }
            }
            $stmt->execute();
            return $stmt;
        }

        // Production: require a real mysqli
        if (!$this->db) {
            throw new Exception('No mysqli connection available');
        }

        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            throw new Exception('MySQL prepare failed: ' . $this->db->error);
        }
        if ($types) {
            $stmt->bind_param($types, ...$params);
        }
        if (!$stmt->execute()) {
            throw new Exception('MySQL execute failed: ' . $stmt->error);
        }
        return $stmt;
    }
}
