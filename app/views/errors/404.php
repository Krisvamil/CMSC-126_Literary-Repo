<?php
$title       = '404 Not Found';
$pageStyles  = ['error.css'];
$pageScripts = ['error.js'];

// Buffer the page-specific HTML
ob_start();
?>
<section class="error-page container">
  <h2>404 &mdash; Page Not Found</h2>
  <p>Sorry, the page you’re looking for doesn’t exist. <a href="<?= BASE_URL ?>/">Return home</a>.</p>
</section>
<?php
// Get buffered content
$content = ob_get_clean();

// Delegate rendering (and CSP nonce injection) to the main layout
require __DIR__ . '/../layout.php';
