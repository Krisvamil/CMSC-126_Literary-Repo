<?php if (!empty($_SESSION['flash'])): ?>
  <?php foreach ($_SESSION['flash'] as $type => $message): ?>
    <div class="flash <?= htmlspecialchars($type, ENT_QUOTES) ?>">
      <?= htmlspecialchars($message, ENT_QUOTES) ?>
    </div>
  <?php endforeach;
    unset($_SESSION['flash']);
  ?>
<?php endif; ?>

