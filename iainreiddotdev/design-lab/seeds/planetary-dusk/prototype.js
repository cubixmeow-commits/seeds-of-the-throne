(function () {
  const menuButton = document.querySelector('[data-menu-button]');
  const nav = document.querySelector('[data-site-nav]');
  if (menuButton && nav) {
    const close = () => {
      nav.removeAttribute('data-open');
      menuButton.setAttribute('aria-expanded', 'false');
    };
    const open = () => {
      nav.setAttribute('data-open', '');
      menuButton.setAttribute('aria-expanded', 'true');
    };
    menuButton.addEventListener('click', () => {
      const expanded = menuButton.getAttribute('aria-expanded') === 'true';
      if (expanded) close();
      else open();
    });
    nav.querySelectorAll('a').forEach((link) => link.addEventListener('click', close));
    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape' && menuButton.getAttribute('aria-expanded') === 'true') {
        close();
        menuButton.focus();
      }
    });
  }

  const steps = document.querySelector('[data-sequence]');
  if (steps) {
    const status = document.querySelector('[data-sequence-status]');
    const buttons = steps.querySelectorAll('[data-step]');
    buttons.forEach((button) => {
      button.addEventListener('click', () => {
        buttons.forEach((node) => node.setAttribute('aria-pressed', 'false'));
        button.setAttribute('aria-pressed', 'true');
        if (status) status.textContent = button.getAttribute('data-step-label') || button.textContent;
      });
    });
  }
})();
