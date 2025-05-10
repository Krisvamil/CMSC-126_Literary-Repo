// error.js
// Could add retry logic or link focus

const ErrorModule = (() => {
  const init = () => {
    const homeLink = document.querySelector('.error-page a');
    if (homeLink) {
      homeLink.focus();
    }
  };

  return { init };
})();

document.addEventListener('DOMContentLoaded', ErrorModule.init);
