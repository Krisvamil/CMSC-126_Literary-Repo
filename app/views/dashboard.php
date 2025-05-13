<?php
$title       = 'Dashboard';
$pageStyles  = ['dashboard.css'];
$pageScripts = ['dashboard.js'];

// Buffer the page content
ob_start();
?>
<section class="dashboard">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['user']['username'] ?? 'User', ENT_QUOTES) ?></h1>
    <p>This is your main dashboard. Use the navigation to explore.</p>
</section>
<?php
$content = ob_get_clean();

// Hand off to layout.php, which injects the CSP nonce into all <script> tags
require __DIR__ . '/layout.php';
