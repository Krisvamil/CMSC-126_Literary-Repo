<?php
$scripts = ['/js/readers.js'];
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
            <li><a href="<?= url('/authors/' . $author['id']) ?>"><?= htmlspecialchars($author['name']) ?></a></li>
        <?php endforeach; ?>
    </ul>
</section>
<?php
$content = ob_get_clean();
$title = 'Reader Dashboard';
require __DIR__ . '/../../layout.php';
