document.documentElement.classList.add('js');

const filters = [...document.querySelectorAll('.map-filter')];
const nodes = [...document.querySelectorAll('.map-node')];
const lines = [...document.querySelectorAll('.map-lines .link')];
const detail = document.querySelector('#map-detail-text');

function setFilter(group) {
  filters.forEach((button) => {
    const active = button.dataset.filter === group;
    button.classList.toggle('is-active', active);
    button.setAttribute('aria-pressed', String(active));
  });
  nodes.forEach((node) => node.classList.toggle('is-muted', group !== 'all' && node.dataset.group !== group));
  lines.forEach((line) => line.classList.toggle('is-muted', group !== 'all' && !line.classList.contains(group)));
}

filters.forEach((button) => button.addEventListener('click', () => setFilter(button.dataset.filter)));
nodes.forEach((node) => node.addEventListener('click', () => {
  nodes.forEach((item) => item.classList.remove('is-selected'));
  node.classList.add('is-selected');
  if (detail) detail.textContent = node.dataset.detail;
  setFilter(node.dataset.group);
}));

if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
  const observed = document.querySelectorAll('.reveal');
  const observer = new IntersectionObserver((entries) => entries.forEach((entry) => {
    if (entry.isIntersecting) { entry.target.classList.add('is-visible'); observer.unobserve(entry.target); }
  }), { threshold: 0.15 });
  observed.forEach((item) => observer.observe(item));
}
