document.documentElement.classList.add('js');

const menuButton = document.querySelector('[data-menu-button]');
const siteNav = document.querySelector('[data-site-nav]');

if (menuButton && siteNav) {
  const closeMenu = () => {
    menuButton.setAttribute('aria-expanded', 'false');
    siteNav.removeAttribute('data-open');
    const icon = menuButton.querySelector('[aria-hidden="true"]');
    if (icon) icon.textContent = '+';
  };

  menuButton.addEventListener('click', () => {
    const open = menuButton.getAttribute('aria-expanded') === 'true';
    menuButton.setAttribute('aria-expanded', String(!open));
    siteNav.toggleAttribute('data-open', !open);
    const icon = menuButton.querySelector('[aria-hidden="true"]');
    if (icon) icon.textContent = open ? '+' : '−';
  });

  siteNav.addEventListener('click', (event) => {
    if (event.target.closest('a')) closeMenu();
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && menuButton.getAttribute('aria-expanded') === 'true') {
      closeMenu();
      menuButton.focus();
    }
  });

  window.matchMedia('(min-width: 75.01rem)').addEventListener('change', (event) => {
    if (event.matches) closeMenu();
  });
}
