document.documentElement.classList.add('js');

const menuButton = document.querySelector('[data-menu-button]');
const siteNav = document.querySelector('[data-site-nav]');

if (menuButton && siteNav) {
  menuButton.addEventListener('click', () => {
    const open = menuButton.getAttribute('aria-expanded') === 'true';
    menuButton.setAttribute('aria-expanded', String(!open));
    siteNav.toggleAttribute('data-open', !open);
  });
}

document.querySelectorAll('[data-layer-set]').forEach((set) => {
  const buttons = [...set.querySelectorAll('[data-layer-button]')];
  const panels = [...set.querySelectorAll('[data-layer-panel]')];
  buttons.forEach((button) => button.addEventListener('click', () => {
    const target = button.dataset.layerButton;
    buttons.forEach((item) => item.setAttribute('aria-pressed', String(item === button)));
    panels.forEach((panel) => panel.hidden = panel.dataset.layerPanel !== target);
  }));
});

document.querySelectorAll('[data-filter-set]').forEach((set) => {
  const buttons = [...set.querySelectorAll('[data-filter]')];
  const items = [...document.querySelectorAll('[data-status]')];
  buttons.forEach((button) => button.addEventListener('click', () => {
    const target = button.dataset.filter;
    buttons.forEach((item) => item.setAttribute('aria-pressed', String(item === button)));
    items.forEach((item) => item.hidden = target !== 'all' && item.dataset.status !== target);
  }));
});
