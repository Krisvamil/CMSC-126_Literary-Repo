<?php
declare(strict_types=1);

namespace Tests\Views;

use PHPUnit\Framework\TestCase;

final class DashboardViewTest extends TestCase
{
    public function testDashboardRendersUsernameAndCss(): void
    {
        $_SESSION['user'] = ['username' => 'charlie'];
        ob_start();
        require __DIR__ . '/../../app/views/dashboard.php';
        $html = ob_get_clean();

        $this->assertStringContainsString('Welcome, charlie', $html);
        $this->assertMatchesRegularExpression('/dashboard\.css/', $html);
    }
}
