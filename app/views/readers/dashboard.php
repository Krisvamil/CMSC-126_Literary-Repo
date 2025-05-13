<?php
$title       = 'Reader Dashboard';
$pageStyles  = ['readers.css'];
$pageScripts = ['readers.js'];

// Buffer the page-specific HTML
ob_start();
?>
<h2>Reader Dashboard</h2>
<section>
    <h3>Favorites</h3>
    <ul class="work-list">
        <?php foreach ($favorites as $work): ?>
            <?php require __DIR__ . '/../partials/_work_list_item.php'; ?>
        <?php endforeach; ?>
    </ul>
</section>
<section>
    <h3>Following</h3>
    <ul class="author-list">
        <?php foreach ($following as $author): ?>
            <li>
                <a href="<?= url('/authors/' . $author['id']) ?>">
                    <?= htmlspecialchars($author['name'], ENT_QUOTES) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<?php
// Get the buffered content
$content = ob_get_clean();

// Delegate rendering (and CSP nonce injection) to the main layout
require __DIR__ . '/../../layout.php';
