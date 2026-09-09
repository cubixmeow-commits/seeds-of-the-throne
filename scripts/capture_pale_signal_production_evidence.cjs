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
      await page.waitForTimeout(120);
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
    await page.locator('[data-menu-button]').click();
    await page.screenshot({ path: path.join(out, '375x812-story-home-menu.png'), fullPage: false });
    await page.keyboard.press('Escape');
    await page.goto(base + '/iainreiddotdev/project-explorer/?view=overview');
    await page.locator('[data-product-nav-button]').click();
    await page.screenshot({ path: path.join(out, '375x812-pe-overview-menu.png'), fullPage: false });
    await page.locator('#theme-toggle').click();
    await page.screenshot({ path: path.join(out, '375x812-pe-overview-theme-toggle.png'), fullPage: false });
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
