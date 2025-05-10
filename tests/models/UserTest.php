<?php
declare(strict_types=1);

namespace Tests\Models;

use PHPUnit\Framework\TestCase;
use App\Models\User;

final class UserTest extends TestCase
{
    private User $model;
    private \PDO $pdo;

    protected function setUp(): void
    {
        $this->model = new User(/* dummy mysqli */ null);
        $this->pdo   = User::getTestConnection();

        $hash = password_hash('secret', PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("
            INSERT INTO users (username, email, password_hash, role, created_at, updated_at)
            VALUES (:u, :e, :ph, 'author', datetime('now'), datetime('now'))
        ");
        $stmt->execute([
            ':u'  => 'alice',
            ':e'  => 'alice@example.com',
            ':ph' => $hash,
        ]);
    }

    public function testFindByEmailReturnsUser(): void
    {
        $user = $this->model->findByEmail('alice@example.com');
        $this->assertIsArray($user);
        $this->assertSame('alice', $user['username']);
        $this->assertSame('author', $user['role']);
    }

    public function testFindByEmailReturnsNull(): void
    {
        $this->assertNull($this->model->findByEmail('nope@example.com'));
    }

    public function testCreateUser(): void
    {
        $id = $this->model->create('bob', 'bob@example.com', 'hash', 'reader');
        $this->assertGreaterThan(0, $id);

        $fetched = $this->model->findById($id);
        $this->assertSame('bob', $fetched['username']);
    }
}
