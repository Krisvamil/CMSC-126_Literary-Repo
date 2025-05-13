<?php
$title      = '500 Internal Server Error';
$pageStyles = ['error.css'];
$pageScripts = ['error.js'];

// Buffer the page-specific HTML
ob_start();
?>
<section class="error-page container">
  <h2>500 &mdash; Something Went Wrong</h2>
  <p>Oops! An unexpected error occurred. Please try again later or <a href="<?= BASE_URL ?>/">go back home</a>.</p>
</section>
<?php
// Get buffered content
$content = ob_get_clean();

// Delegate rendering (and CSP nonce injection) to the main layout
require __DIR__ . '/../layout.php';
