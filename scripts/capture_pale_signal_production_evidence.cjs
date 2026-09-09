// Production Pale Signal evidence capture. Dev-only; not a production dependency.
const { chromium, webkit } = require('playwright');
const fs = require('fs');
const path = require('path');

const base = process.env.SEEDS_TEST_URL || 'http://127.0.0.1:8766';
const out = '/workspace/07 QA/Pale Signal Production Evidence';
fs.mkdirSync(out, { recursive: true });

const WIDTHS = [
  { width: 320, height: 568 },
  { width: 375, height: 812 },
  { width: 390, height: 844 },
  { width: 430, height: 932 },
  { width: 768, height: 1024 },
  { width: 1024, height: 768 },
  { width: 1440, height: 900 },
];

const ROUTES = [
  ['story-home', '/docs/index.html'],
  ['story-world', '/docs/colonization.html'],
  ['story-workshop', '/docs/workshop.html'],
  ['pe-overview', '/iainreiddotdev/project-explorer/?view=overview'],
  ['pe-workshop', '/iainreiddotdev/project-explorer/?view=workshop'],
  ['pe-files', '/iainreiddotdev/project-explorer/?view=files&file=README.md'],
];

async function measure(page) {
  return page.evaluate(() => ({
    docOverflow: document.documentElement.scrollWidth > innerWidth + 1,
    bodyOverflow: document.body.scrollWidth > innerWidth + 1,
  }));
}

async function settle(page) {
  await page.waitForTimeout(200);
  await page.evaluate(async () => {
    if (document.fonts && document.fonts.ready) await document.fonts.ready;
  });
  // Guarantee settled paint: no animated opacity on essential copy.
  await page.waitForFunction(() => {
    const copy = document.querySelector('.signal-masthead__copy, .explorer-hero__content, .explorer-route, .workspace-intro, .archive-intro');
    if (!copy) return true;
    const opacity = Number.parseFloat(getComputedStyle(copy).opacity);
    return opacity >= 0.99;
  }, null, { timeout: 3000 }).catch(() => {});
}

async function run(engine, label, routes, widths, { zoom = false, prefix = '' } = {}) {
  const browser = await engine.launch({ headless: true });
  const page = await browser.newPage();
  const errors = [];
  const results = [];
  for (const vp of widths) {
    await page.setViewportSize(vp);
    for (const [name, route] of routes) {
      await page.goto(base + route, { waitUntil: 'domcontentloaded' });
      if (zoom) await page.addStyleTag({ content: 'html { font-size: 200% !important; }' });
      await settle(page);
      const metrics = await measure(page);
      const file = `${prefix}${vp.width}x${vp.height}-${name}${zoom ? '-zoom200' : ''}.png`;
      await page.screenshot({ path: path.join(out, file), fullPage: false });
      results.push({ engine: label, zoom: !!zoom, ...vp, name, route, file, ...metrics });
      if (metrics.docOverflow) errors.push(`${label} doc overflow ${vp.width} ${name}${zoom ? ' zoom' : ''}`);
      if (metrics.bodyOverflow) errors.push(`${label} body overflow ${vp.width} ${name}${zoom ? ' zoom' : ''}`);
    }
  }

  if (!zoom && label === 'chromium') {
    await page.setViewportSize({ width: 375, height: 812 });
    await page.goto(base + '/docs/index.html');
    await settle(page);
    await page.locator('[data-menu-button]').click();
    await page.screenshot({ path: path.join(out, '375x812-story-home-menu.png'), fullPage: false });
    await page.keyboard.press('Escape');

    await page.goto(base + '/iainreiddotdev/project-explorer/?view=overview');
    await settle(page);
    await page.locator('[data-product-nav-button]').click();
    await page.screenshot({ path: path.join(out, '375x812-pe-overview-menu.png'), fullPage: false });
    await page.keyboard.press('Escape');

    // Distinct mobile destinations must differ before scroll (light theme).
    await page.evaluate(() => {
      try { localStorage.setItem('theme', 'light'); } catch (e) {}
      document.documentElement.setAttribute('data-theme', 'light');
    });
    for (const width of [320, 390]) {
      await page.setViewportSize({ width, height: 568 });
      const shots = {};
      for (const [name, route] of [
        ['overview', '/iainreiddotdev/project-explorer/?view=overview'],
        ['workshop', '/iainreiddotdev/project-explorer/?view=workshop'],
        ['files', '/iainreiddotdev/project-explorer/?view=files&file=README.md'],
      ]) {
        await page.goto(base + route, { waitUntil: 'domcontentloaded' });
        await settle(page);
        shots[name] = await page.evaluate(() => ({
          h1: (document.querySelector('h1') || {}).textContent || '',
          chip: (document.querySelector('.explorer-route-chip strong') || {}).textContent || '',
          hasHero: !!document.querySelector('.explorer-hero'),
          hasRoute: !!document.querySelector('.explorer-route'),
          hasWorkshop: !!document.querySelector('[data-workshop], #workshop-view'),
          hasArchive: !!document.querySelector('#archive'),
          theme: document.documentElement.getAttribute('data-theme'),
        }));
        await page.screenshot({ path: path.join(out, `${width}x568-pe-${name}-distinct.png`), fullPage: false });
      }
      if (shots.overview.h1 === shots.workshop.h1 || shots.overview.h1 === shots.files.h1) {
        errors.push(`indistinct h1 at ${width}: overview/workshop/files`);
      }
      if (!shots.overview.hasHero || shots.workshop.hasHero || shots.files.hasHero) {
        errors.push(`hero visibility wrong at ${width}`);
      }
      if (shots.workshop.chip.trim() !== 'Workshop' || shots.files.chip.trim() !== 'Files') {
        errors.push(`route chip missing at ${width}`);
      }
      if (!shots.workshop.hasWorkshop || !shots.files.hasArchive) {
        errors.push(`route content missing at ${width}`);
      }
      results.push({ engine: 'chromium', distinctCheck: width, shots });
    }

    // Closed-menu dark theme on the main field.
    await page.setViewportSize({ width: 375, height: 812 });
    await page.evaluate(() => {
      try { localStorage.setItem('theme', 'dark'); } catch (e) {}
      document.documentElement.setAttribute('data-theme', 'dark');
    });
    await page.goto(base + '/iainreiddotdev/project-explorer/?view=overview', { waitUntil: 'domcontentloaded' });
    await settle(page);
    const contrast = await page.evaluate(() => {
      const wash = getComputedStyle(document.body).getPropertyValue('--archive-wash-top').trim();
      const ink = getComputedStyle(document.querySelector('h1') || document.body).color;
      return {
        wash,
        color: ink,
        menuOpen: document.querySelector('[data-product-nav]')?.hasAttribute('data-open') || false,
      };
    });
    if (contrast.menuOpen) errors.push('dark theme capture still has menu open');
    if (contrast.wash.toLowerCase() === '#e8eef0') errors.push('dark theme still using pale wash');
    await page.screenshot({ path: path.join(out, '375x812-pe-overview-dark-closed.png'), fullPage: false });
    results.push({ engine: 'chromium', name: 'pe-overview-dark-closed', contrast });
  }

  await browser.close();
  return { results, errors };
}

(async () => {
  const a = await run(chromium, 'chromium', ROUTES, WIDTHS);
  const b = await run(chromium, 'chromium-zoom', [
    ['story-home', '/docs/index.html'],
    ['pe-overview', '/iainreiddotdev/project-explorer/?view=overview'],
  ], [
    { width: 320, height: 568 },
    { width: 375, height: 812 },
    { width: 768, height: 1024 },
  ], { zoom: true });
  const c = await run(webkit, 'webkit', [
    ['story-home', '/docs/index.html'],
    ['pe-overview', '/iainreiddotdev/project-explorer/?view=overview'],
    ['pe-files', '/iainreiddotdev/project-explorer/?view=files&file=README.md'],
  ], [
    { width: 320, height: 568 },
    { width: 390, height: 844 },
    { width: 768, height: 1024 },
    { width: 1440, height: 900 },
  ], { prefix: 'webkit-' });

  const results = [...a.results, ...b.results, ...c.results];
  const errors = [...a.errors, ...b.errors, ...c.errors];
  fs.writeFileSync(path.join(out, 'results.json'), JSON.stringify({ results, errors }, null, 2));
  if (errors.length) {
    console.error(errors.join('\n'));
    process.exit(1);
  }
  console.log(`PASS production evidence: ${results.length} captures; no overflow.`);
})();
