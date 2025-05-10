<?php if (!empty($_SESSION['flash'])): ?>
  <?php foreach ($_SESSION['flash'] as $type => $message): ?>
    <div class="flash <?= $type ?>">
      <?= htmlspecialchars($message) ?>
    </div>
  <?php endforeach;
    unset($_SESSION['flash']);
  ?>
<?php endif; ?>
