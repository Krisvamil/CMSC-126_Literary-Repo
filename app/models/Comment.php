<?php
declare(strict_types=1);

namespace App\Models;

use mysqli;

class Comment extends Model
{
    public function getByWork(int $workId): array
    {
        $stmt = $this->query(
            'SELECT c.id, c.body, c.user_id, u.username, c.created_at
             FROM comments c
             JOIN users u ON c.user_id = u.id
             WHERE c.work_id = ?
             ORDER BY c.created_at ASC',
            'i',
            [$workId]
        );
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function create(int $workId, int $userId, string $body): int
    {
        $stmt = $this->query(
            'INSERT INTO comments (work_id, user_id, body) VALUES (?, ?, ?)',
            'iis',
            [$workId, $userId, $body]
        );
        return $stmt->insert_id;
    }

    public function delete(int $id): bool
    {
        $this->query(
            'DELETE FROM comments WHERE id = ?',
            'i',
            [$id]
        );
        return true;
    }
}
