<?php
declare(strict_types=1);

namespace App\Models;

use mysqli;

class User extends Model
{
    public function findById(int $id): ?array
    {
        $stmt = $this->query(
            'SELECT id, username, email, role FROM users WHERE id = ? LIMIT 1',
            'i',
            [$id]
        );
        $result = $stmt->get_result()->fetch_assoc();
        return $result ?: null;
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->query(
            'SELECT id, username, email, password_hash, role FROM users WHERE email = ? LIMIT 1',
            's',
            [$email]
        );
        $row = $stmt->get_result()->fetch_assoc();
        return $row ?: null;
    }

    public function create(string $username, string $email, string $passwordHash, string $role): int
    {
        $stmt = $this->query(
            'INSERT INTO users (username, email, password_hash, role) VALUES (?, ?, ?, ?)',
            'ssss',
            [$username, $email, $passwordHash, $role]
        );
        return $stmt->insert_id;
    }
}
