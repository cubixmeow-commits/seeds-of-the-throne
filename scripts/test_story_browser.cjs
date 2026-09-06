// Dev-only Playwright check. No production dependency or browser service required.
const { chromium } = require('playwright');
const fs = require('fs');
const path = require('path');
const base = process.env.SEEDS_TEST_URL || 'http://127.0.0.1:8766';
const out = process.env.SEEDS_TEST_OUTPUT || '/tmp/seeds-browser-review';
fs.mkdirSync(out,{recursive:true});
(async()=>{
 const browser=await chromium.launch({headless:true,...(process.env.SEEDS_CHROMIUM ? {executablePath:process.env.SEEDS_CHROMIUM} : {})});
 const page=await browser.newPage();const errors=[];const results=[];
 page.on('pageerror',e=>errors.push(e.message));
 page.on('response',r=>{if(r.url().startsWith(base)&&r.status()>=400)errors.push(`${r.status()} ${r.url()}`)});
 const pages=['index','colonization','ai','characters','faction','timeline','research','archive','workshop','todo','ideas','visuals'].map(p=>`/docs/${p}.html`);
 pages.push('/iainreiddotdev/project-explorer/','/iainreiddotdev/project-explorer/?view=sources','/iainreiddotdev/project-explorer/?view=evidence','/iainreiddotdev/project-explorer/?view=workshop');
 for(const width of [320,1440]){
  await page.setViewportSize({width,height:1000});
  for(const route of pages){
   const response=await page.goto(base+route);await page.waitForTimeout(150);
   if(await page.locator('[data-workshop]').count()) await page.locator('#workshop-answer').waitFor();
   const overflow=await page.evaluate(()=>document.documentElement.scrollWidth>innerWidth+1);
   results.push({width,route,status:response.status(),overflow});
   if(overflow)errors.push(`overflow ${width} ${route}`);
   if(route.includes('view=workshop')) await page.locator('#session').screenshot({path:path.join(out,`${width}-session.png`)});
   if(route==='/iainreiddotdev/project-explorer/') await page.locator('#workbench').screenshot({path:path.join(out,`${width}-workbench.png`)});
   if(['/docs/index.html','/docs/workshop.html','/iainreiddotdev/project-explorer/'].includes(route)) await page.screenshot({path:path.join(out,`${width}-${route.includes('project-explorer')?'explorer':route.split('/').pop()}.png`),fullPage:false});
  }
 }
 await page.setViewportSize({width:320,height:900});await page.goto(base+'/docs/index.html');
 await page.locator('[data-menu-button]').click();if(await page.locator('[data-menu-button]').getAttribute('aria-expanded')!=='true') errors.push('menu failed to open');
 await page.keyboard.press('Escape');if(await page.locator('[data-menu-button]').getAttribute('aria-expanded')!=='false') errors.push('menu failed to close');
 await page.goto(base+'/docs/workshop.html?module=11#session');await page.locator('#workshop-answer').waitFor();
 const answer='Module: 11 · test\nState: DRAFT\n\nAuthor answer: browser verification only <script>bad</script>\n';
 await page.locator('#workshop-answer').fill(answer);await page.reload();await page.locator('#workshop-answer').waitFor();
 if(await page.locator('#workshop-answer').inputValue()!==answer)errors.push('draft did not survive reload');
 await page.locator('#workshop-module').selectOption('12');await page.locator('#workshop-module').selectOption('11');
 if(await page.locator('#workshop-answer').inputValue()!==answer)errors.push('module switch lost draft');
 const download=page.waitForEvent('download');await page.getByRole('button',{name:'Export answer as Markdown',exact:true}).click();const d=await download;const file=path.join(out,d.suggestedFilename());await d.saveAs(file);
 if(fs.readFileSync(file,'utf8')!==answer)errors.push('export content mismatch');
 page.on('dialog',d=>d.accept());await page.locator('#workshop-answer').fill('temporary');await page.locator('#workshop-import').setInputFiles(file);
 await page.waitForTimeout(150);if(await page.locator('#workshop-answer').inputValue()!==answer)errors.push('import mismatch');
 await page.locator('.packet-detail summary').click();if(!await page.getByText('Blocking identity discrepancy',{exact:true}).isVisible())errors.push('packet detail missing');
 await page.evaluate(()=>Object.keys(localStorage).filter(k=>k.startsWith('seeds-workshop-v1:')).forEach(k=>localStorage.removeItem(k)));
 // Explorer source search and traversal rejection.
 await page.goto(base+'/iainreiddotdev/project-explorer/?q=Luminai#archive');
 if(!await page.locator('.explorer-results').count())errors.push('Explorer search missing');
 const invalid=await page.request.get(base+'/iainreiddotdev/project-explorer/?file=../../etc/passwd');
 if(invalid.status()!==404)errors.push('Traversal was not rejected');
 const denied=await browser.newContext();await denied.addInitScript(()=>Object.defineProperty(window,'localStorage',{get(){throw Error('blocked')}}));
 const dp=await denied.newPage();await dp.goto(base+'/docs/workshop.html');await dp.locator('#workshop-answer').waitFor();await dp.locator('#workshop-answer').fill('unsaved');
 if(!await dp.getByText('Browser storage unavailable.',{exact:false}).count())errors.push('storage failure not disclosed');
 await denied.close();
 fs.writeFileSync(path.join(out,'results.json'),JSON.stringify({results,errors},null,2));await browser.close();
 if(errors.length){console.error(errors.join('\n'));process.exit(1);}console.log(`PASS: ${results.length} responsive routes, menus, drafts, export/import, search, traversal, storage failure, no JS errors.`);
})();
