// Design-lab prototype verification. Not a production dependency.
const { chromium } = require('playwright');
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

(async () => {
  const browser = await chromium.launch({ headless: true });
  const page = await browser.newPage();
  const errors = [];
  const results = [];

  page.on('pageerror', (e) => errors.push(`pageerror ${e.message}`));
  page.on('response', (r) => {
    if (r.url().startsWith(base) && r.status() >= 400) errors.push(`${r.status()} ${r.url()}`);
  });

  for (const vp of VIEWPORTS) {
    await page.setViewportSize(vp);
    for (const [name, route] of PAGES) {
      const response = await page.goto(base + route, { waitUntil: 'domcontentloaded' });
      await page.waitForTimeout(160);
      const metrics = await page.evaluate(() => {
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
      const file = `${vp.width}x${vp.height}-${name}.png`;
      await page.screenshot({ path: path.join(out, file), fullPage: false });
      results.push({ ...vp, name, route, status: response.status(), file, ...metrics });
      if (metrics.docOverflow) errors.push(`doc overflow ${vp.width} ${name}`);
      if (metrics.bodyOverflow) errors.push(`body overflow ${vp.width} ${name}`);
      if (metrics.escapees.length) errors.push(`escapees ${vp.width} ${name}: ${metrics.escapees.join('|')}`);
    }

    if (vp.width <= 430) {
      for (const route of [
        '/iainreiddotdev/design-lab/seeds/planetary-dusk/story.html',
        '/iainreiddotdev/design-lab/seeds/pale-signal/story.html',
      ]) {
        await page.goto(base + route, { waitUntil: 'domcontentloaded' });
        const toggle = page.locator('[data-menu-button]');
        await toggle.click();
        if (await toggle.getAttribute('aria-expanded') !== 'true') errors.push(`menu open fail ${vp.width} ${route}`);
        await page.keyboard.press('Escape');
        if (await toggle.getAttribute('aria-expanded') !== 'false') errors.push(`menu escape fail ${vp.width} ${route}`);
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
        if (target < 44) errors.push(`touch target ${target}px at ${vp.width} ${route}`);
      }
    }
  }

  // Open-menu mobile evidence.
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
  if (!(duskStatus || '').includes('Propagation')) errors.push('dusk sequence interaction failed');

  await page.goto(base + '/iainreiddotdev/design-lab/seeds/pale-signal/story.html');
  await page.locator('[data-layer="evidence"]').click();
  if (await page.locator('[data-layer-panel="evidence"]').isHidden()) errors.push('pale layer reveal failed');

  await page.goto(base + '/iainreiddotdev/design-lab/seeds/planetary-dusk/story.html');
  await page.locator('main a[href="explorer.html"]').first().click();
  if (!page.url().includes('planetary-dusk/explorer.html')) errors.push('dusk story→explorer link failed');

  await page.goto(base + '/iainreiddotdev/design-lab/seeds/pale-signal/explorer.html');
  await page.locator('main a[href="story.html"]').first().click();
  if (!page.url().includes('pale-signal/story.html')) errors.push('pale explorer→story link failed');

  fs.writeFileSync(path.join(out, 'results.json'), JSON.stringify({ results, errors }, null, 2));
  await browser.close();
  if (errors.length) {
    console.error(errors.join('\n'));
    process.exit(1);
  }
  console.log(`PASS: ${results.length} screenshots; menus; sequence/layer interactions; no overflow.`);
})();
