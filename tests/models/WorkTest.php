<?php
declare(strict_types=1);

namespace Tests\Models;

use PHPUnit\Framework\TestCase;
use App\Models\Work;
use App\Models\User;

final class WorkTest extends TestCase
{
    private Work $model;
    private \PDO $pdo;

    protected function setUp(): void
    {
        // Seed an author in users table
        $this->pdo = User::getTestConnection();
        $hash = password_hash('pw', PASSWORD_BCRYPT);
        $this->pdo->exec("
            INSERT INTO users (username, email, password_hash, role, created_at, updated_at)
            VALUES ('auth','a@a.com','{$hash}','author', datetime('now'), datetime('now'));
        ");

        $this->model = new Work(/* dummy mysqli */ null);
    }

    public function testCreateAndFind(): void
    {
        $id = $this->model->create(1, 'My Title', 'My Body');
        $this->assertGreaterThan(0, $id);

        $fetched = $this->model->find($id);
        $this->assertSame('My Title', $fetched['title']);
        $this->assertSame('My Body', $fetched['body']);
    }

    public function testGetAllIncludesAuthorName(): void
    {
        $this->model->create(1, 'T1', 'B1');
        $all = $this->model->getAll();
        $this->assertNotEmpty($all);
        $this->assertArrayHasKey('author_name', $all[0]);
    }
}
