// Design-lab prototype verification. Not a production dependency.
const { chromium, webkit } = require('playwright');
const fs = require('fs');
const path = require('path');

const base = process.env.SEEDS_TEST_URL || 'http://127.0.0.1:8766';
const out = '/workspace/07 QA/Coded Design Lab Review Evidence';
fs.mkdirSync(out, { recursive: true });

const VIEWPORTS = [
  { width: 320, height: 568 },
  { width: 375, height: 812 },
  { width: 430, height: 932 },
  { width: 768, height: 1024 },
  { width: 1024, height: 768 },
  { width: 1440, height: 900 },
];

const PAGES = [
  ['index', '/iainreiddotdev/design-lab/seeds/index.html'],
  ['dusk-story', '/iainreiddotdev/design-lab/seeds/planetary-dusk/story.html'],
  ['dusk-explorer', '/iainreiddotdev/design-lab/seeds/planetary-dusk/explorer.html'],
  ['pale-story', '/iainreiddotdev/design-lab/seeds/pale-signal/story.html'],
  ['pale-explorer', '/iainreiddotdev/design-lab/seeds/pale-signal/explorer.html'],
];

const PALE_PAGES = PAGES.filter(([name]) => name.startsWith('pale-'));

async function measure(page) {
  return page.evaluate(() => {
    const docOverflow = document.documentElement.scrollWidth > innerWidth + 1;
    const bodyOverflow = document.body.scrollWidth > innerWidth + 1;
    const escapees = Array.from(document.querySelectorAll('body *')).filter((el) => {
      const style = getComputedStyle(el);
      if (style.display === 'none' || style.visibility === 'hidden') return false;
      let ancestor = el.parentElement;
      while (ancestor && ancestor !== document.body) {
        const overflow = getComputedStyle(ancestor).overflow + getComputedStyle(ancestor).overflowX;
        if (overflow.includes('hidden') || overflow.includes('clip')) return false;
        ancestor = ancestor.parentElement;
      }
      const box = el.getBoundingClientRect();
      return box.width > 0 && (box.right > innerWidth + 1 || box.left < -1);
    }).slice(0, 5).map((el) => el.tagName + '.' + (el.className || '').toString().slice(0, 40));
    return {
      docOverflow,
      bodyOverflow,
      escapees,
      h1: (document.querySelector('h1') || {}).textContent || '',
    };
  });
}

async function runSuite(browserType, label, pages, viewports, { zoom = false, filePrefix = '' } = {}) {
  const browser = await browserType.launch({ headless: true });
  const page = await browser.newPage();
  const errors = [];
  const results = [];

  page.on('pageerror', (e) => errors.push(`${label} pageerror ${e.message}`));
  page.on('response', (r) => {
    if (r.url().startsWith(base) && r.status() >= 400) errors.push(`${label} ${r.status()} ${r.url()}`);
  });

  for (const vp of viewports) {
    await page.setViewportSize(vp);
    for (const [name, route] of pages) {
      const response = await page.goto(base + route, { waitUntil: 'domcontentloaded' });
      if (zoom) {
        await page.addStyleTag({ content: 'html { font-size: 200% !important; }' });
        await page.waitForTimeout(80);
      } else {
        await page.waitForTimeout(160);
      }
      const metrics = await measure(page);
      const file = `${filePrefix}${vp.width}x${vp.height}-${name}${zoom ? '-zoom200' : ''}.png`;
      await page.screenshot({ path: path.join(out, file), fullPage: false });
      results.push({ engine: label, zoom: !!zoom, ...vp, name, route, status: response.status(), file, ...metrics });
      if (metrics.docOverflow) errors.push(`${label} doc overflow ${vp.width} ${name}${zoom ? ' zoom200' : ''}`);
      if (metrics.bodyOverflow) errors.push(`${label} body overflow ${vp.width} ${name}${zoom ? ' zoom200' : ''}`);
      if (metrics.escapees.length) errors.push(`${label} escapees ${vp.width} ${name}${zoom ? ' zoom200' : ''}: ${metrics.escapees.join('|')}`);
    }

    if (!zoom && vp.width <= 430) {
      for (const [, route] of pages.filter(([n]) => n.includes('story') || n === 'index')) {
        if (!route.includes('pale-signal') && !route.includes('planetary-dusk')) continue;
        await page.goto(base + route, { waitUntil: 'domcontentloaded' });
        const toggle = page.locator('[data-menu-button]');
        if (await toggle.count() === 0) continue;
        await toggle.click();
        if (await toggle.getAttribute('aria-expanded') !== 'true') errors.push(`${label} menu open fail ${vp.width} ${route}`);
        await page.keyboard.press('Escape');
        if (await toggle.getAttribute('aria-expanded') !== 'false') errors.push(`${label} menu escape fail ${vp.width} ${route}`);
        const target = await page.evaluate(() => {
          const nodes = Array.from(document.querySelectorAll('[data-menu-button], .button, .btn'))
            .filter((n) => {
              const s = getComputedStyle(n);
              const b = n.getBoundingClientRect();
              return s.display !== 'none' && b.height > 0;
            });
          return Math.min(...nodes.map((n) => {
            const b = n.getBoundingClientRect();
            return Math.min(b.width, b.height);
          }));
        });
        if (target < 44) errors.push(`${label} touch target ${target}px at ${vp.width} ${route}`);
      }
    }
  }

  await browser.close();
  return { results, errors };
}

(async () => {
  const chromiumPass = await runSuite(chromium, 'chromium', PAGES, VIEWPORTS);

  // Open-menu mobile evidence (Chromium).
  {
    const browser = await chromium.launch({ headless: true });
    const page = await browser.newPage();
    for (const [name, route] of [
      ['dusk-story-menu', '/iainreiddotdev/design-lab/seeds/planetary-dusk/story.html'],
      ['pale-story-menu', '/iainreiddotdev/design-lab/seeds/pale-signal/story.html'],
    ]) {
      await page.setViewportSize({ width: 375, height: 812 });
      await page.goto(base + route, { waitUntil: 'domcontentloaded' });
      await page.locator('[data-menu-button]').click();
      await page.waitForTimeout(120);
      await page.screenshot({ path: path.join(out, `375x812-${name}.png`), fullPage: false });
      await page.keyboard.press('Escape');
    }

    await page.setViewportSize({ width: 1440, height: 900 });
    await page.goto(base + '/iainreiddotdev/design-lab/seeds/planetary-dusk/explorer.html');
    await page.locator('[data-step]').nth(2).click();
    const duskStatus = await page.locator('[data-sequence-status]').textContent();
    if (!(duskStatus || '').includes('Propagation')) chromiumPass.errors.push('dusk sequence interaction failed');

    await page.goto(base + '/iainreiddotdev/design-lab/seeds/pale-signal/story.html');
    await page.locator('[data-layer="evidence"]').click();
    if (await page.locator('[data-layer-panel="evidence"]').isHidden()) chromiumPass.errors.push('pale layer reveal failed');

    await page.goto(base + '/iainreiddotdev/design-lab/seeds/planetary-dusk/story.html');
    await page.locator('main a[href="explorer.html"]').first().click();
    if (!page.url().includes('planetary-dusk/explorer.html')) chromiumPass.errors.push('dusk story→explorer link failed');

    await page.goto(base + '/iainreiddotdev/design-lab/seeds/pale-signal/explorer.html');
    await page.locator('main a[href="story.html"]').first().click();
    if (!page.url().includes('pale-signal/story.html')) chromiumPass.errors.push('pale explorer→story link failed');
    await browser.close();
  }

  const zoomPass = await runSuite(
    chromium,
    'chromium-zoom200',
    PALE_PAGES,
    [
      { width: 320, height: 568 },
      { width: 375, height: 812 },
      { width: 768, height: 1024 },
    ],
    { zoom: true },
  );

  const webkitPass = await runSuite(
    webkit,
    'webkit',
    PALE_PAGES,
    [
      { width: 320, height: 568 },
      { width: 375, height: 812 },
      { width: 390, height: 844 },
      { width: 430, height: 932 },
      { width: 768, height: 1024 },
      { width: 1440, height: 900 },
    ],
    { filePrefix: 'webkit-' },
  );

  // WebKit open-menu + 200% zoom for Pale Story.
  {
    const browser = await webkit.launch({ headless: true });
    const page = await browser.newPage();
    const errors = webkitPass.errors;
    await page.setViewportSize({ width: 390, height: 844 });
    await page.goto(base + '/iainreiddotdev/design-lab/seeds/pale-signal/story.html', { waitUntil: 'domcontentloaded' });
    await page.locator('[data-menu-button]').click();
    if (await page.locator('[data-menu-button]').getAttribute('aria-expanded') !== 'true') {
      errors.push('webkit menu open fail pale story');
    }
    await page.screenshot({ path: path.join(out, 'webkit-390x844-pale-story-menu.png'), fullPage: false });
    await page.keyboard.press('Escape');

    await page.setViewportSize({ width: 375, height: 812 });
    await page.goto(base + '/iainreiddotdev/design-lab/seeds/pale-signal/story.html', { waitUntil: 'domcontentloaded' });
    await page.addStyleTag({ content: 'html { font-size: 200% !important; }' });
    await page.waitForTimeout(100);
    const zoomMetrics = await measure(page);
    await page.screenshot({ path: path.join(out, 'webkit-375x812-pale-story-zoom200.png'), fullPage: false });
    if (zoomMetrics.docOverflow) errors.push('webkit doc overflow pale-story zoom200');
    if (zoomMetrics.bodyOverflow) errors.push('webkit body overflow pale-story zoom200');
    if (zoomMetrics.escapees.length) errors.push(`webkit escapees pale-story zoom200: ${zoomMetrics.escapees.join('|')}`);

    await page.goto(base + '/iainreiddotdev/design-lab/seeds/pale-signal/explorer.html', { waitUntil: 'domcontentloaded' });
    await page.addStyleTag({ content: 'html { font-size: 200% !important; }' });
    await page.waitForTimeout(100);
    const zoomExplorer = await measure(page);
    await page.screenshot({ path: path.join(out, 'webkit-375x812-pale-explorer-zoom200.png'), fullPage: false });
    if (zoomExplorer.docOverflow) errors.push('webkit doc overflow pale-explorer zoom200');
    if (zoomExplorer.bodyOverflow) errors.push('webkit body overflow pale-explorer zoom200');
    if (zoomExplorer.escapees.length) errors.push(`webkit escapees pale-explorer zoom200: ${zoomExplorer.escapees.join('|')}`);
    await browser.close();
  }

  const results = [...chromiumPass.results, ...zoomPass.results, ...webkitPass.results];
  const errors = [...chromiumPass.errors, ...zoomPass.errors, ...webkitPass.errors];
  fs.writeFileSync(path.join(out, 'results.json'), JSON.stringify({ results, errors }, null, 2));
  if (errors.length) {
    console.error(errors.join('\n'));
    process.exit(1);
  }
  console.log(`PASS: ${results.length} screenshots across chromium/webkit/zoom200; menus; interactions; no overflow.`);
})();
