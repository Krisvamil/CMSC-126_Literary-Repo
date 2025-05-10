<?php
$title       = '500 Internal Server Error';
$pageStyles  = ['error.css'];
$pageScripts = [];
ob_start();
?>
<section class="error-page container">
  <h2>500 &mdash; Something Went Wrong</h2>
  <p>Oops! An unexpected error occurred. Please try again later or <a href="<?= BASE_URL ?>/">go back home</a>.</p>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
