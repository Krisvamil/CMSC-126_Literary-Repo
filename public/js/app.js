// public/js/app.js
// Revealing Module Pattern for global behaviors

const App = (() => {
  // Highlight the current <nav> link
  function highlightActiveNav() {
    const currentPath = window.location.pathname.replace(/\/+$/, '');
    document.querySelectorAll('nav a').forEach(link => {
      const linkPath = new URL(link.href).pathname;
      link.classList.toggle('active', linkPath === currentPath);
    });
  }

  // Delegate clicks for [data-action] buttons
  function bindActions() {
    document.body.addEventListener('click', (evt) => {
      const btn = evt.target.closest('[data-action]');
      if (!btn) return;
      const action = btn.dataset.action;
      if (App.Actions[action]) {
        App.Actions[action](btn);
      }
    });
  }

  return {
    init() {
      highlightActiveNav();
      bindActions();
    },
    Actions: {
      // Example: <button data-action="showModal" data-target="myModal">
      showModal(btn) {
        const id = btn.dataset.target;
        document.getElementById(id).classList.add('visible');
      },
      // Add more actions here…
    }
  };
})();

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', App.init);
