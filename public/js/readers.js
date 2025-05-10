// readers.js
// Toggles favorites and follows via AJAX (fetch API)

import { App } from './app.js';

const ReadersModule = (() => {
  const init = () => {
    document.querySelectorAll('.favorite-toggle').forEach(btn => {
      btn.addEventListener('click', () => {
        const workId = btn.dataset.workId;
        fetch(`${BASE_URL}/readers/favorite`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ workId })
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            btn.textContent = data.favorited ? 'Unfavorite' : 'Favorite';
          }
        });
      });
    });

    document.querySelectorAll('.follow-toggle').forEach(btn => {
      btn.addEventListener('click', () => {
        const authorId = btn.dataset.authorId;
        fetch(`${BASE_URL}/readers/follow`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ authorId })
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            btn.textContent = data.following ? 'Unfollow' : 'Follow';
          }
        });
      });
    });
  };

  return { init };
})();

document.addEventListener('DOMContentLoaded', () => {
  App.init();
  ReadersModule.init();
});
