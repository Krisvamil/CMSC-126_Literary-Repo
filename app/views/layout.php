<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="base-url" content="<?=BASE_URL?>">
  <title><?=htmlspecialchars($title)?></title>
  <link rel="stylesheet" href="<?=url('css/style.css')?>">
<?php foreach($pageStyles??[] as $f):?>
  <link rel="stylesheet" href="<?=url("css/{$f}")?>">
<?php endforeach;?>
</head>
  
<body>
<?php require VIEWS_DIR.'/partials/_header.php'; ?>
<?php require VIEWS_DIR.'/partials/_nav.php'; ?>
  <main class="container">
    <?php require VIEWS_DIR.'/partials/_flash.php'; ?><?= $content ?>
  </main>
<?php require VIEWS_DIR.'/partials/_footer.php'; ?>
  <script>const BASE_URL=document.querySelector('meta[name="base-url"]').getAttribute('content');</script>
  <script type="module" src="<?=url('js/app.js')?>"></script>
<?php foreach($pageScripts??[] as $f):?>
   <script type="module" src="<?=url("js/{$f}")?>"></script>
<?php endforeach;?>
</body>
</html>
