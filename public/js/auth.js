// auth.js
// Focuses the first input on the login/register forms

const AuthModule = (() => {
  const init = () => {
    const firstInput = document.querySelector('.auth-container input');
    if (firstInput) {
      firstInput.focus();
    }
  };

  return { init };
})();

document.addEventListener('DOMContentLoaded', AuthModule.init);
