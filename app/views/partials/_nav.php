<nav class="site-nav">
  <div class="container d-flex justify-between align-center">
    <ul class="d-flex flex-wrap">
      <li><a href="<?= BASE_URL ?>/">Home</a></li>
      <?php if (isset($_SESSION['user'])): ?>
        <li><a href="<?= BASE_URL ?>/dashboard">Dashboard</a></li>
        <?php if ($_SESSION['user']['role'] === 'author'): ?>
          <li><a href="<?= BASE_URL ?>/authors">My Works</a></li>
        <?php elseif ($_SESSION['user']['role'] === 'reader'): ?>
          <li><a href="<?= BASE_URL ?>/readers">My Favorites</a></li>
        <?php endif; ?>
        <li><a href="<?= BASE_URL ?>/auth/logout">Logout</a></li>
      <?php else: ?>
        <li><a href="<?= BASE_URL ?>/auth/login">Login</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
