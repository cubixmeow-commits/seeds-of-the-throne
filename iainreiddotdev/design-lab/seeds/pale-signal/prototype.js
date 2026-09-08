(function () {
  const menuButton = document.querySelector('[data-menu-button]');
  const nav = document.querySelector('[data-site-nav]');
  if (menuButton && nav) {
    const close = () => {
      nav.removeAttribute('data-open');
      menuButton.setAttribute('aria-expanded', 'false');
    };
    menuButton.addEventListener('click', () => {
      const open = menuButton.getAttribute('aria-expanded') === 'true';
      if (open) close();
      else {
        nav.setAttribute('data-open', '');
        menuButton.setAttribute('aria-expanded', 'true');
      }
    });
    nav.querySelectorAll('a').forEach((link) => link.addEventListener('click', close));
    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape' && menuButton.getAttribute('aria-expanded') === 'true') {
        close();
        menuButton.focus();
      }
    });
  }

  const layerButtons = document.querySelectorAll('[data-layer]');
  const panels = document.querySelectorAll('[data-layer-panel]');
  if (layerButtons.length && panels.length) {
    layerButtons.forEach((button) => {
      button.addEventListener('click', () => {
        const id = button.getAttribute('data-layer');
        layerButtons.forEach((node) => node.setAttribute('aria-pressed', 'false'));
        button.setAttribute('aria-pressed', 'true');
        panels.forEach((panel) => {
          panel.hidden = panel.getAttribute('data-layer-panel') !== id;
        });
      });
    });
  }
})();
