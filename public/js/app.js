// app.js
// Revealing Module for global behaviors

const App = (() => {
  const highlightActiveNav = () => {
    const path = window.location.pathname.replace(/\/+$/, '');
    document.querySelectorAll('nav a').forEach(link => {
      const href = new URL(link.href).pathname;
      if (href === path) {
        link.classList.add('active');
      }
    });
  };

  return {
    init: () => {
      highlightActiveNav();
      // any other global init can go here
    }
  };
})();

document.addEventListener('DOMContentLoaded', App.init);
