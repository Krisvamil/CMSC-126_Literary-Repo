<article class="work-item d-flex justify-between align-center">
  <div class="work-info">
    <h2><a href="<?= BASE_URL ?>/works/<?= $work['id'] ?>"><?= htmlspecialchars($work['title']) ?></a></h2>
    <p>by <?= htmlspecialchars($work['author_name']) ?></p>
  </div>
  <?php if ($_SESSION['user']['role'] === 'author' && $_SESSION['user']['id'] === $work['author_id']): ?>
    <div class="work-actions">
      <a class="btn" href="<?= BASE_URL ?>/works/edit?id=<?= $work['id'] ?>">Edit</a>
      <form action="<?= BASE_URL ?>/works/delete" method="POST" style="display:inline;">
        <input type="hidden" name="id" value="<?= $work['id'] ?>">
        <button class="btn" type="submit">Delete</button>
      </form>
    </div>
  <?php endif; ?>
</article>
