<?php
declare(strict_types=1);

namespace App\Models;

use mysqli;

class Author extends Model
{
    public function getProfile(int $userId): ?array
    {
        $stmt = $this->query(
            'SELECT a.id, a.bio, u.username, u.email
             FROM authors a
             JOIN users u ON a.user_id = u.id
             WHERE a.user_id = ? LIMIT 1',
            'i',
            [$userId]
        );
        return $stmt->get_result()->fetch_assoc() ?: null;
    }

    public function createProfile(int $userId, string $bio): int
    {
        $stmt = $this->query(
            'INSERT INTO authors (user_id, bio) VALUES (?, ?)',
            'is',
            [$userId, $bio]
        );
        return $stmt->insert_id;
    }

    public function updateProfile(int $id, string $bio): bool
    {
        $this->query(
            'UPDATE authors SET bio = ? WHERE id = ?',
            'si',
            [$bio, $id]
        );
        return true;
    }
}
