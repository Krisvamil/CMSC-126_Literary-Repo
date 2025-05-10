<?php
declare(strict_types=1);

namespace Tests\Controllers;

use PHPUnit\Framework\TestCase;
use App\Controllers\AuthController;
use App\Models\User;

final class AuthControllerTest extends TestCase
{
    private AuthController $ctrl;
    private \PDO           $pdo;

    protected function setUp(): void
    {
        $this->ctrl = new AuthController();
        $this->pdo  = User::getTestConnection();

        // Seed test user
        $hash = password_hash('pw', PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("
            INSERT INTO users (username, email, password_hash, role, created_at, updated_at)
            VALUES ('u', 'u@u.com', :ph, 'reader', datetime('now'), datetime('now'))
        ");
        $stmt->execute([':ph' => $hash]);

        $_POST = ['email' => 'u@u.com', 'password' => 'pw'];
        $_SESSION = [];
        ob_start();
    }

    protected function tearDown(): void
    {
        ob_end_clean();
        $_POST = $_SESSION = [];
    }

    public function testLoginSuccessSetsSession(): void
    {
        $this->ctrl->login();
        $this->assertArrayHasKey('user', $_SESSION);
        $this->assertSame('u', $_SESSION['user']['username']);
    }

    public function testLoginFailureRendersForm(): void
    {
        $_POST['password'] = 'wrong';
        $this->ctrl->login();
        $output = ob_get_clean();
        $this->assertStringContainsString('<form', $output);
        $this->assertStringContainsString('Invalid email or password', $output);
    }
}
