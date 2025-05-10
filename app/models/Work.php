<?php
declare(strict_types=1);

namespace App\Models;

use mysqli;

class Work extends Model
{
    public function getAll(): array
    {
        $stmt = $this->query('
            SELECT w.id, w.title, w.body, w.author_id, u.username AS author_name
            FROM works w
            JOIN users u ON w.author_id = u.id
            ORDER BY w.created_at DESC
        ');
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->query(
            'SELECT id, title, body, author_id FROM works WHERE id = ? LIMIT 1',
            'i',
            [$id]
        );
        return $stmt->get_result()->fetch_assoc() ?: null;
    }

    public function create(int $authorId, string $title, string $body): int
    {
        $stmt = $this->query(
            'INSERT INTO works (author_id, title, body) VALUES (?, ?, ?)',
            'iss',
            [$authorId, $title, $body]
        );
        return $stmt->insert_id;
    }

    public function update(int $id, string $title, string $body): bool
    {
        $this->query(
            'UPDATE works SET title = ?, body = ? WHERE id = ?',
            'sii',
            [$title, $body, $id]
        );
        return true;
    }

    public function delete(int $id): bool
    {
        $this->query(
            'DELETE FROM works WHERE id = ?',
            'i',
            [$id]
        );
        return true;
    }
}
