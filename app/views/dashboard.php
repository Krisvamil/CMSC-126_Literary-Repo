<?php $title = 'Dashboard'; $pageStyles = ['dashboard.css']; $pageScripts = ['dashboard.js']; ?>
<?php ob_start(); ?>

<section class="dashboard">
    <h1>Welcome, <?= $_SESSION['user']['username'] ?? 'User' ?></h1>
    <p>This is your main dashboard. Use the navigation to explore.</p>
</section>

<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>
