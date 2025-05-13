<?php
  // Grab and escape the CSP nonce generated in index.php
  $nonce = htmlspecialchars($GLOBALS['csp_nonce'] ?? '', ENT_QUOTES);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="base-url" content="<?= BASE_URL ?>">
    <title><?= htmlspecialchars($title) ?></title>

    <!-- External Stylesheets -->
    <link rel="stylesheet" href="<?= url('css/style.css') ?>">
    <?php foreach ($pageStyles ?? [] as $file): ?>
        <link rel="stylesheet" href="<?= url("css/{$file}") ?>">
    <?php endforeach; ?>
</head>
<body>
    <?php require VIEWS_DIR . '/partials/_header.php'; ?>
    <?php require VIEWS_DIR . '/partials/_nav.php'; ?>

    <main class="container">
        <?php require VIEWS_DIR . '/partials/_flash.php'; ?>
        <?= $content ?>
    </main>

    <?php require VIEWS_DIR . '/partials/_footer.php'; ?>

    <!-- Base URL for JS modules -->
    <script nonce="<?= $nonce ?>">
        const BASE_URL = document
            .querySelector('meta[name="base-url"]')
            .getAttribute('content');
    </script>

    <!-- Main App Script -->
    <script
        type="module"
        src="<?= url('js/app.js') ?>"
        nonce="<?= $nonce ?>">
    </script>

    <!-- Page-specific Scripts -->
    <?php foreach ($pageScripts ?? [] as $file): ?>
        <script
            type="module"
            src="<?= url("js/{$file}") ?>"
            nonce="<?= $nonce ?>">
        </script>
    <?php endforeach; ?>
</body>
</html>
