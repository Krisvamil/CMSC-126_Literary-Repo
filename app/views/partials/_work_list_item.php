<article class="work-item d-flex justify-between align-center">
  <div class="work-info">
    <h2>
      <a href="<?= htmlspecialchars(BASE_URL, ENT_QUOTES) ?>/works/<?= (int) $work['id'] ?>">
        <?= htmlspecialchars($work['title'], ENT_QUOTES) ?>
      </a>
    </h2>
    <p>by <?= htmlspecialchars($work['author_name'], ENT_QUOTES) ?></p>
  </div>

  <?php if (
      isset($_SESSION['user'], $_SESSION['user']['role'], $_SESSION['user']['id'])
      && $_SESSION['user']['role'] === 'author'
      && $_SESSION['user']['id'] === $work['author_id']
  ): ?>
    <div class="work-actions">
      <a
        class="btn"
        href="<?= htmlspecialchars(BASE_URL, ENT_QUOTES) ?>/works/edit?id=<?= (int) $work['id'] ?>"
      >
        <?= htmlspecialchars('Edit', ENT_QUOTES) ?>
      </a>

      <form
        action="<?= htmlspecialchars(BASE_URL, ENT_QUOTES) ?>/works/delete"
        method="POST"
        style="display:inline;"
      >
        <input
          type="hidden"
          name="id"
          value="<?= (int) $work['id'] ?>"
        >
        <button class="btn" type="submit">
          <?= htmlspecialchars('Delete', ENT_QUOTES) ?>
        </button>
      </form>
    </div>
  <?php endif; ?>
</article>
