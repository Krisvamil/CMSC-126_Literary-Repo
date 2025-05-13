<nav class="site-nav">
  <div class="container d-flex justify-between align-center">
    <ul class="d-flex flex-wrap">
      <li>
        <a href="<?= htmlspecialchars(BASE_URL, ENT_QUOTES) ?>/">
          <?= htmlspecialchars('Home', ENT_QUOTES) ?>
        </a>
      </li>
      <?php if (!empty($_SESSION['user'])): ?>
        <li>
          <a href="<?= htmlspecialchars(BASE_URL, ENT_QUOTES) ?>/dashboard">
            <?= htmlspecialchars('Dashboard', ENT_QUOTES) ?>
          </a>
        </li>
        <?php if ($_SESSION['user']['role'] === 'author'): ?>
          <li>
            <a href="<?= htmlspecialchars(BASE_URL, ENT_QUOTES) ?>/authors">
              <?= htmlspecialchars('My Works', ENT_QUOTES) ?>
            </a>
          </li>
        <?php elseif ($_SESSION['user']['role'] === 'reader'): ?>
          <li>
            <a href="<?= htmlspecialchars(BASE_URL, ENT_QUOTES) ?>/readers">
              <?= htmlspecialchars('My Favorites', ENT_QUOTES) ?>
            </a>
          </li>
        <?php endif; ?>
        <li>
          <a href="<?= htmlspecialchars(BASE_URL, ENT_QUOTES) ?>/auth/logout">
            <?= htmlspecialchars('Logout', ENT_QUOTES) ?>
          </a>
        </li>
      <?php else: ?>
        <li>
          <a href="<?= htmlspecialchars(BASE_URL, ENT_QUOTES) ?>/auth/login">
            <?= htmlspecialchars('Login', ENT_QUOTES) ?>
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
