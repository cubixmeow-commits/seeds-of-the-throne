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

  window.matchMedia('(min-width: 72.01rem)').addEventListener('change', (event) => {
    if (event.matches) closeMenu();
  });
}

// The public story pages are static, so load the shared first-party collector
// from the portfolio application. The collector is cookie-free and optional;
// a failed analytics request never affects the story experience.
const analyticsScript = document.createElement('script');
analyticsScript.src = '/devsite/iainreiddotdev/assets/js/analytics.js?v=20260918a';
analyticsScript.async = true;
document.head.appendChild(analyticsScript);
