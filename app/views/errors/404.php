<?php
$title       = '404 Not Found';
$pageStyles  = ['error.css'];
$pageScripts = [];
ob_start();
?>
<section class="error-page container">
  <h2>404 &mdash; Page Not Found</h2>
  <p>Sorry, the page you’re looking for doesn’t exist. <a href="<?= BASE_URL ?>/">Return home</a>.</p>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
