// authors.js
// Handles “New Work” button navigation and edit forms

import { App } from './app.js';

const AuthorsModule = (() => {
  const init = () => {
    const newBtn = document.getElementById('new-work-btn');
    if (newBtn) {
      newBtn.addEventListener('click', () => {
        window.location.href = `${BASE_URL}/authors/works/create`;
      });
    }

    // Example: confirm before delete
    document.querySelectorAll('.work-actions form').forEach(form => {
      form.addEventListener('submit', e => {
        if (!confirm('Are you sure you want to delete this work?')) {
          e.preventDefault();
        }
      });
    });
  };

  return { init };
})();

document.addEventListener('DOMContentLoaded', () => {
  App.init();
  AuthorsModule.init();
});
