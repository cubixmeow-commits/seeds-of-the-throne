// Dev-only Playwright check. No production dependency or browser service required.
const { chromium } = require('playwright');
const fs = require('fs');
const path = require('path');
const base = process.env.SEEDS_TEST_URL || 'http://127.0.0.1:8766';
const out = process.env.SEEDS_TEST_OUTPUT || '/tmp/seeds-browser-review';
fs.mkdirSync(out, { recursive: true });

const VIEWPORTS = [320, 375, 390, 430, 768, 1024, 1440];
const STORY_PAGES = ['index', 'colonization', 'ai', 'characters', 'faction', 'timeline', 'research', 'archive', 'workshop', 'todo', 'ideas', 'visuals']
  .map((p) => `/docs/${p}.html`);

(async () => {
  const browser = await chromium.launch({
    headless: true,
    ...(process.env.SEEDS_CHROMIUM ? { executablePath: process.env.SEEDS_CHROMIUM } : {}),
  });
  const page = await browser.newPage();
  const errors = [];
  const results = [];
  page.on('pageerror', (e) => errors.push(e.message));
  page.on('response', (r) => {
    if (r.url().startsWith(base) && r.status() >= 400) errors.push(`${r.status()} ${r.url()}`);
  });

  const push = (entry) => results.push(entry);

  const assertNoOverflow = async (width, route) => {
    const dimensions = await page.evaluate(() => ({
      viewport: innerWidth,
      documentWidth: document.documentElement.scrollWidth,
      bodyWidth: document.body.scrollWidth,
    }));
    const overflow = Math.max(dimensions.documentWidth, dimensions.bodyWidth) > dimensions.viewport + 1;
    push({ width, route, overflow, ...dimensions });
    if (overflow) {
      errors.push(`overflow ${width} ${route}: viewport ${dimensions.viewport}, document ${dimensions.documentWidth}, body ${dimensions.bodyWidth}`);
    }
  };

  const minTargetPx = async (selector) => page.evaluate((sel) => {
    const nodes = Array.from(document.querySelectorAll(sel)).filter((node) => {
      const style = getComputedStyle(node);
      const box = node.getBoundingClientRect();
      return style.display !== 'none' && style.visibility !== 'hidden' && box.height > 0 && box.width > 0;
    });
    if (!nodes.length) return null;
    return Math.min(...nodes.map((node) => {
      const box = node.getBoundingClientRect();
      return Math.min(box.height, box.width);
    }));
  }, selector);

  // Responsive route sweep across every required width.
  for (const width of VIEWPORTS) {
    await page.setViewportSize({ width, height: 1000 });
    for (const route of STORY_PAGES) {
      const response = await page.goto(base + route, { waitUntil: 'domcontentloaded' });
      await page.waitForTimeout(120);
      if (await page.locator('[data-workshop]').count()) {
        await page.locator('#workshop-answer').waitFor({ timeout: 15000 });
      }
      push({ width, route, status: response.status() });
      await assertNoOverflow(width, route);
      if (['/docs/research.html', '/docs/visuals.html', '/docs/archive.html'].includes(route)) {
        const current = await page.locator('.site-nav a[aria-current="page"]').first().textContent();
        const expected = route.includes('research') ? 'Research' : route.includes('visuals') ? 'Visuals' : 'Archive';
        if ((current || '').trim() !== expected) errors.push(`${route} missing selected state for ${expected} at ${width}`);
        if (!(await page.locator('.site-nav a[href="research.html"]').count())) {
          errors.push(`${route} missing Research nav path at ${width}`);
        }
      }
    }

    for (const [route, label, heading] of [
      ['/iainreiddotdev/project-explorer/?view=overview', 'Overview', 'See how the authoring system turns ordinary language into finished story work.'],
      ['/iainreiddotdev/project-explorer/?view=sources', 'Story', 'Open the public story pages and the reviewed Markdown behind them.'],
      ['/iainreiddotdev/project-explorer/?view=evidence', 'Decisions', 'Trace assessments, research boundaries, contradictions, and accepted decisions.'],
      ['/iainreiddotdev/project-explorer/?view=workshop', 'Workshop', 'Build the missing path through Book One.'],
    ]) {
      const response = await page.goto(base + route, { waitUntil: 'domcontentloaded' });
      await page.waitForTimeout(150);
      if (route.includes('workshop')) {
        await page.locator('#workshop-answer').waitFor({ timeout: 15000 }).catch(() => errors.push(`workshop failed to load at ${width}`));
      }
      push({ width, route, status: response.status() });
      await assertNoOverflow(width, route);
      const active = await page.locator('.product-nav a[aria-current="page"]').textContent();
      if ((active || '').trim() !== label) errors.push(`active state ${label} missing at ${width}`);
      const title = await page.locator('#workbench-title').textContent();
      if ((title || '').trim() !== heading) errors.push(`distinct heading for ${label} missing at ${width}`);
      if (await page.locator('link[href*="docs/atlas.css"]').count()) {
        errors.push(`atlas.css still imported into Project Explorer at ${width}`);
      }
      if (width <= 768) {
        const toggle = page.locator('[data-product-nav-button]');
        if (!(await toggle.count())) errors.push(`hamburger missing at ${width}`);
        else {
          await toggle.click();
          if (await toggle.getAttribute('aria-expanded') !== 'true') errors.push(`menu failed to open at ${width}`);
          await page.keyboard.press('Escape');
          if (await toggle.getAttribute('aria-expanded') !== 'false') errors.push(`menu Escape failed at ${width}`);
          await toggle.click();
          await page.locator('.product-nav a', { hasText: 'Progress' }).click();
          if (await toggle.getAttribute('aria-expanded') !== 'false') errors.push(`menu link-close failed at ${width}`);
        }
        // Re-open menu so nav links are measurable, then check browse/theme controls.
        await page.goto(base + route, { waitUntil: 'domcontentloaded' });
        await page.locator('[data-product-nav-button]').click();
        const target = await minTargetPx('.product-nav[data-open] a, .explorer-browse-toggle, .product-nav__toggle, .theme-toggle');
        if (target !== null && target < 44) errors.push(`touch target ${target}px < 44 at ${width}`);
      } else if (await page.locator('[data-product-nav-button]').isVisible()) {
        errors.push(`hamburger visible on desktop width ${width}`);
      }
    }

    await page.goto(base + '/iainreiddotdev/project-explorer/?view=files&file=README.md#archive', { waitUntil: 'domcontentloaded' });
    await assertNoOverflow(width, 'files');
    if ((await page.locator('.product-nav a[aria-current="page"]').textContent() || '').trim() !== 'Files') {
      errors.push(`Files active state missing at ${width}`);
    }
    if (width <= 768) {
      if (!(await page.locator('[data-archive-open]').isVisible())) errors.push(`Browse files control missing at ${width}`);
      if (await page.locator('[data-archive-panel]').isVisible()) errors.push(`file tree visible before browse at ${width}`);
      await page.locator('[data-archive-open]').click();
      if (!(await page.locator('[data-archive-panel]').isVisible())) errors.push(`file browser failed to open at ${width}`);
      if (await page.locator('#archive-document').isVisible()) errors.push(`document still visible while browsing at ${width}`);
      await page.locator('[data-archive-close]').first().click();
      if (!(await page.locator('#archive-document').isVisible())) errors.push(`document not restored after close at ${width}`);
    } else if (!(await page.locator('[data-archive-panel]').isVisible())) {
      errors.push(`desktop archive sidebar hidden at ${width}`);
    }

    // Sticky header must not cover the destination heading after navigation.
    await page.goto(base + '/iainreiddotdev/project-explorer/?view=sources#story-view', { waitUntil: 'load' });
    await page.waitForTimeout(1100);
    const covered = await page.evaluate(() => {
      const header = document.querySelector('#site-header');
      const title = document.querySelector('#workbench-title');
      if (!header || !title) return true;
      const headerBottom = header.getBoundingClientRect().bottom;
      const titleTop = title.getBoundingClientRect().top;
      return titleTop < headerBottom - 1;
    });
    if (covered) errors.push(`sticky header covers Story destination at ${width}`);

    await page.goto(base + '/iainreiddotdev/project-explorer/?view=files&file=README.md#archive', { waitUntil: 'load' });
    await page.waitForTimeout(1100);
    const archiveCovered = await page.evaluate(() => {
      const header = document.querySelector('#site-header');
      const title = document.querySelector('#archive-title');
      if (!header || !title) return true;
      const headerBottom = header.getBoundingClientRect().bottom;
      const box = title.getBoundingClientRect();
      return box.top < headerBottom - 1 || box.top > innerHeight;
    });
    if (archiveCovered) errors.push(`sticky header covers Files destination at ${width}`);

    if ([320, 1440].includes(width)) {
      await page.screenshot({ path: path.join(out, `${width}-explorer.png`), fullPage: false });
    }
  }

  // Story-site menu behavior.
  await page.setViewportSize({ width: 320, height: 900 });
  await page.goto(base + '/docs/index.html');
  await page.locator('[data-menu-button]').click();
  if (await page.locator('[data-menu-button]').getAttribute('aria-expanded') !== 'true') errors.push('story menu failed to open');
  await page.keyboard.press('Escape');
  if (await page.locator('[data-menu-button]').getAttribute('aria-expanded') !== 'false') errors.push('story menu failed to close');

  // Homepage Pale Signal masthead composition.
  for (const width of [320, 430, 1024, 1440]) {
    await page.setViewportSize({ width, height: 1000 });
    await page.goto(base + '/docs/index.html', { waitUntil: 'domcontentloaded' });
    const hero = await page.evaluate(() => {
      const picture = document.querySelector('.signal-masthead picture');
      const img = document.querySelector('.signal-masthead picture img');
      const source = document.querySelector('.signal-masthead picture source');
      const h1 = document.querySelectorAll('h1');
      const cls = document.body.className;
      const shift = img ? (!img.getAttribute('width') || !img.getAttribute('height')) : true;
      const current = img ? (img.currentSrc || img.src) : '';
      return {
        hasPicture: !!picture,
        hasSource: !!source,
        sourceMedia: source ? source.getAttribute('media') : null,
        sourceSrc: source ? source.getAttribute('srcset') : null,
        imgSrc: img ? img.getAttribute('src') : null,
        currentSrc: current,
        h1Count: h1.length,
        pageHome: cls.includes('page-home'),
        missingDims: shift,
        hasAnnotation: !!document.querySelector('.signal-annotation'),
      };
    });
    if (!hero.hasPicture || !hero.hasSource) errors.push(`homepage picture missing at ${width}`);
    if (!hero.pageHome) errors.push(`homepage missing page-home at ${width}`);
    if (hero.h1Count !== 1) errors.push(`homepage h1 count ${hero.h1Count} at ${width}`);
    if (hero.missingDims) errors.push(`homepage hero missing intrinsic dimensions at ${width}`);
    if (!hero.hasAnnotation) errors.push(`homepage missing signal annotation at ${width}`);
    if (!hero.imgSrc || !hero.imgSrc.includes('planetary-cutaway-hero-desktop-v1.webp')) {
      errors.push(`homepage desktop hero src missing at ${width}`);
    }
    if (!hero.sourceSrc || !hero.sourceSrc.includes('planetary-cutaway-hero-mobile-v1.webp')) {
      errors.push(`homepage mobile source missing at ${width}`);
    }
    if (width <= 430 && hero.currentSrc && !hero.currentSrc.includes('mobile')) {
      errors.push(`homepage did not select mobile hero at ${width}: ${hero.currentSrc}`);
    }
    if (width >= 1024 && hero.currentSrc && !hero.currentSrc.includes('desktop')) {
      errors.push(`homepage did not select desktop hero at ${width}: ${hero.currentSrc}`);
    }
    const bands = await page.locator('.editorial-band').count();
    if (bands < 4) errors.push(`homepage editorial bands incomplete at ${width}`);
    await assertNoOverflow(width, '/docs/index.html#pale-signal');
  }

  // Project Explorer quieter hero evidence image.
  await page.setViewportSize({ width: 1024, height: 900 });
  await page.goto(base + '/iainreiddotdev/project-explorer/?view=overview');
  const peHero = await page.locator('.explorer-hero__image').getAttribute('src');
  if (!peHero || !peHero.includes('recovered-records-evidence-v1.webp')) {
    errors.push('Project Explorer hero is not the quieter evidence image');
  }
  if (await page.locator('.explorer-hero__image[src*="konrad-controlled"]').count()) {
    errors.push('Project Explorer still uses cinematic key-art hero');
  }

  // Vault Overview is a homepage section, not a disconnected page.
  for (const width of VIEWPORTS) {
    await page.setViewportSize({ width, height: 1000 });
    await page.goto(base + `/iainreiddotdev/project-explorer/?view=overview&w=${width}#vault-overview`, { waitUntil: 'load' });
    await page.waitForTimeout(1100);
    await assertNoOverflow(width, 'vault-overview');
    const covered = await page.evaluate(() => {
      const header = document.querySelector('#site-header');
      const target = document.querySelector('#vault-overview');
      if (!header || !target) return true;
      return target.getBoundingClientRect().top < header.getBoundingClientRect().bottom - 1;
    });
    if (covered) errors.push(`sticky header covers Vault overview at ${width}`);
    if (!(await page.locator('#vault-overview').count())) errors.push(`vault overview missing at ${width}`);
    if (!(await page.getByRole('link', { name: 'Explore the vault', exact: true }).count())) {
      errors.push(`Explore the vault missing at ${width}`);
    }
    const vaultNav = page.locator('.product-nav a[data-explorer-nav="vault"]');
    if (!(await vaultNav.count())) errors.push(`Vault nav missing at ${width}`);
    const vaultHref = await vaultNav.getAttribute('href');
    const exploreHref = await page.getByRole('link', { name: 'Explore the vault', exact: true }).getAttribute('href');
    if (!vaultHref || !vaultHref.includes('view=overview') || !vaultHref.includes('vault-overview')) {
      errors.push(`Vault nav destination wrong at ${width}: ${vaultHref}`);
    }
    if (!exploreHref || !exploreHref.includes('vault-overview')) {
      errors.push(`Explore the vault destination wrong at ${width}: ${exploreHref}`);
    }
    const stages = await page.locator('#vault-overview .vault-overview__flow h3').allTextContents();
    if (stages.map((s) => s.trim()).join(' → ') !== 'Capture → Understand → Decide → Develop → Create → Share') {
      errors.push(`vault flow labels wrong at ${width}: ${stages.join(' → ')}`);
    }
    for (const label of ['Working well', 'Needs repair', 'Planned next']) {
      if (!(await page.locator('#vault-overview').getByText(label, { exact: true }).count())) {
        errors.push(`${label} missing from vault overview at ${width}`);
      }
    }
    if (!(await page.locator('#vault-overview').getByText('Not built yet', { exact: true }).count())) {
      errors.push(`planned-not-built label missing at ${width}`);
    }
    for (const section of ['#explorer-title', '#overview-view', '#story-progress', '#archive']) {
      if (!(await page.locator(section).count())) errors.push(`unified homepage lost ${section} at ${width} on Vault`);
    }
    if (width <= 768) {
      const toggle = page.locator('[data-product-nav-button]');
      await toggle.click();
      const icon = await page.locator('[data-product-nav-icon]').textContent();
      if ((icon || '').trim() !== '✕') errors.push(`menu icon did not switch on open at ${width}`);
      await page.locator('.product-nav a[data-explorer-nav="vault"]').click();
      if (await toggle.getAttribute('aria-expanded') !== 'false') errors.push(`Vault menu link-close failed at ${width}`);
    }
  }

  await page.setViewportSize({ width: 375, height: 812 });
  await page.goto(base + '/iainreiddotdev/project-explorer/?view=files&file=README.md#archive', { waitUntil: 'domcontentloaded' });
  await page.locator('[data-product-nav-button]').click().catch(() => {});
  await page.locator('.product-nav a[data-explorer-nav="vault"]').click();
  await page.waitForTimeout(400);
  if (!page.url().includes('view=overview') || !page.url().includes('vault-overview')) {
    errors.push(`Vault link did not return to homepage from files: ${page.url()}`);
  }
  if (!(await page.locator('#vault-overview').isVisible())) errors.push('Vault overview not visible after returning from files');

  await page.setViewportSize({ width: 320, height: 568 });
  await page.goto(base + '/iainreiddotdev/project-explorer/?view=overview#vault-overview', { waitUntil: 'load' });
  await page.addStyleTag({ content: 'html { font-size: 200% !important; }' });
  await page.waitForTimeout(200);
  await assertNoOverflow(320, 'vault-overview-zoom200');

  // Workshop persistence/import/export on Project Explorer.
  await page.goto(base + '/iainreiddotdev/project-explorer/?view=workshop&module=BA-01#session');
  await page.locator('#workshop-answer').waitFor();
  const answer = 'Module: BA-01 · test\nState: DRAFT\n\nAuthor answer: browser verification only <script>bad</script>\n';
  await page.locator('#workshop-answer').fill(answer);
  await page.reload();
  await page.locator('#workshop-answer').waitFor();
  if (await page.locator('#workshop-answer').inputValue() !== answer) errors.push('explorer draft did not survive reload');
  await page.locator('#workshop-module').selectOption('BA-02');
  await page.locator('#workshop-module').selectOption('BA-01');
  if (await page.locator('#workshop-answer').inputValue() !== answer) errors.push('explorer module switch lost draft');
  const download = page.waitForEvent('download');
  await page.getByRole('button', { name: 'Export answer as Markdown', exact: true }).click();
  const d = await download;
  const file = path.join(out, d.suggestedFilename());
  await d.saveAs(file);
  if (fs.readFileSync(file, 'utf8') !== answer) errors.push('explorer export content mismatch');
  page.on('dialog', (dlg) => dlg.accept());
  await page.locator('#workshop-answer').fill('temporary');
  await page.locator('#workshop-import').setInputFiles(file);
  await page.waitForTimeout(150);
  if (await page.locator('#workshop-answer').inputValue() !== answer) errors.push('explorer import mismatch');
  await page.evaluate(() => Object.keys(localStorage).filter((k) => k.startsWith('seeds-book-one-architecture-workshop-v1:') || k.startsWith('seeds-reassessment-workshop-v1:') || k.startsWith('seeds-workshop-v1:')).forEach((k) => localStorage.removeItem(k)));

  // Theme toggle remains available beside the hamburger.
  await page.setViewportSize({ width: 375, height: 900 });
  await page.goto(base + '/iainreiddotdev/project-explorer/?view=overview');
  if (!(await page.locator('#theme-toggle').isVisible())) errors.push('theme toggle hidden on mobile');
  await page.locator('#theme-toggle').click();
  const theme = await page.evaluate(() => document.documentElement.getAttribute('data-theme'));
  if (theme !== 'light' && theme !== 'dark') errors.push('theme toggle did not set appearance');

  // Search preserves files view and requested document.
  await page.goto(base + '/iainreiddotdev/project-explorer/?view=files&file=README.md&q=Luminai#archive');
  if (!(await page.locator('.explorer-results').count())) errors.push('Explorer search missing');
  const searchUrl = page.url();
  if (!searchUrl.includes('view=files') || !searchUrl.includes('file=README.md')) {
    errors.push('search URL dropped view/file state');
  }
  const fileLink = page.locator('.explorer-results a').first();
  if (await fileLink.count()) {
    const href = await fileLink.getAttribute('href');
    if (!href || !href.includes('view=files') || !href.includes('file=')) {
      errors.push('result link missing files state');
    }
  }

  const invalid = await page.request.get(base + '/iainreiddotdev/project-explorer/?file=../../etc/passwd');
  if (invalid.status() !== 404) errors.push('Traversal was not rejected');

  const denied = await browser.newContext();
  await denied.addInitScript(() => Object.defineProperty(window, 'localStorage', { get() { throw Error('blocked'); } }));
  const dp = await denied.newPage();
  await dp.goto(base + '/docs/workshop.html');
  await dp.locator('#workshop-answer').waitFor();
  await dp.locator('#workshop-answer').fill('unsaved');
  if (!(await dp.getByText('Browser storage unavailable.', { exact: false }).count())) {
    errors.push('storage failure not disclosed');
  }
  await denied.close();

  fs.writeFileSync(path.join(out, 'results.json'), JSON.stringify({ results, errors }, null, 2));
  await browser.close();
  if (errors.length) {
    console.error(errors.join('\n'));
    process.exit(1);
  }
  console.log(`PASS: ${results.length} responsive checks across ${VIEWPORTS.join('/')}px; distinct PE destinations; hamburger; archive browse; Research/Visuals/Archive selected states; workshop persistence; search state; no JS errors.`);
})();
