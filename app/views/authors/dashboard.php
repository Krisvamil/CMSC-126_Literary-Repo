<?php
$title       = 'Author Dashboard';
$pageStyles  = ['authors.css'];
$pageScripts = ['authors.js'];

// Buffer the page content
ob_start();
?>
<section class="authors-dashboard">
    <h1>Your Works & Stats</h1>

    <h2>Your Published Works</h2>
    <ul class="author-works">
        <?php foreach ($works as $work): ?>
            <li><?= htmlspecialchars($work['title'], ENT_QUOTES) ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Statistics</h2>
    <ul class="author-stats">
        <li>Total Works: <?= (int) $stats['total_works'] ?></li>
        <li>Total Comments: <?= (int) $stats['total_comments'] ?></li>
        <li>Followers: <?= (int) $stats['followers'] ?></li>
    </ul>
</section>
<?php
$content = ob_get_clean();

// Hand off to layout.php, which injects the CSP nonce into all <script> tags
require __DIR__ . '/../layout.php';
