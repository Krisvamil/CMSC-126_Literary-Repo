<?php $title = 'Reader Dashboard'; $pageStyles = ['readers.css']; $pageScripts = ['readers.js']; ?>
<?php ob_start(); ?>

<section class="readers-dashboard">
    <h1>Your Favorites & Following</h1>
    <ul class="favorite-works">
        <?php foreach ($favorites as $work): ?>
            <li><?= htmlspecialchars($work['title']) ?></li>
        <?php endforeach; ?>
    </ul>
</section>

<?php $content = ob_get_clean(); require __DIR__ . '/../layout.php'; ?>
