<?php
declare(strict_types=1);

namespace App\Models;

use mysqli;

class Reader extends Model
{
    public function getFavorites(int $userId): array
    {
        $stmt = $this->query(
            'SELECT w.id, w.title, w.author_id, u.username AS author_name
             FROM reader_favorites rf
             JOIN works w ON rf.work_id = w.id
             JOIN users u ON w.author_id = u.id
             WHERE rf.reader_id = ?',
            'i',
            [$userId]
        );
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function toggleFavorite(int $userId, int $workId): bool
    {
        // Check existing
        $stmt = $this->query(
            'SELECT 1 FROM reader_favorites WHERE reader_id = ? AND work_id = ?',
            'ii',
            [$userId, $workId]
        );
        if ($stmt->get_result()->num_rows > 0) {
            // remove
            $this->query(
                'DELETE FROM reader_favorites WHERE reader_id = ? AND work_id = ?',
                'ii',
                [$userId, $workId]
            );
            return false;
        } else {
            // add
            $this->query(
                'INSERT INTO reader_favorites (reader_id, work_id) VALUES (?, ?)',
                'ii',
                [$userId, $workId]
            );
            return true;
        }
    }

    public function getFollows(int $userId): array
    {
        $stmt = $this->query(
            'SELECT a.id, u.username
             FROM reader_author_follows raf
             JOIN authors a ON raf.author_id = a.id
             JOIN users u ON a.user_id = u.id
             WHERE raf.reader_id = ?',
            'i',
            [$userId]
        );
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function toggleFollow(int $userId, int $authorId): bool
    {
        $stmt = $this->query(
            'SELECT 1 FROM reader_author_follows WHERE reader_id = ? AND author_id = ?',
            'ii',
            [$userId, $authorId]
        );
        if ($stmt->get_result()->num_rows > 0) {
            $this->query(
                'DELETE FROM reader_author_follows WHERE reader_id = ? AND author_id = ?',
                'ii',
                [$userId, $authorId]
            );
            return false;
        } else {
            $this->query(
                'INSERT INTO reader_author_follows (reader_id, author_id) VALUES (?, ?)',
                'ii',
                [$userId, $authorId]
            );
            return true;
        }
    }
}
