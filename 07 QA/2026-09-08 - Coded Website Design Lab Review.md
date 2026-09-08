---
type: visual-qa
status: review
date: 2026-09-08
scope: coded website design lab — Pale Signal selected-direction refinement
---

# Coded Website Design Lab Review

## Prototype paths

- Lab index: `iainreiddotdev/design-lab/seeds/index.html`
- Planetary Dusk Story: `iainreiddotdev/design-lab/seeds/planetary-dusk/story.html` (unselected comparison; unchanged this pass)
- Planetary Dusk Explorer: `iainreiddotdev/design-lab/seeds/planetary-dusk/explorer.html` (unchanged)
- Pale Signal Story: `iainreiddotdev/design-lab/seeds/pale-signal/story.html`
- Pale Signal Explorer: `iainreiddotdev/design-lab/seeds/pale-signal/explorer.html`

```bash
php -S 127.0.0.1:8766 -t .
# http://127.0.0.1:8766/iainreiddotdev/design-lab/seeds/pale-signal/story.html
```

## Selected-direction refinement (Pale Signal)

1. Process-facing captions removed/replaced with story-facing evidence language; lab footers/CTAs de-prototyped without losing destinations.
2. 320px Story split polished: copy track widened, fragment mins in px (zoom-stable), mobile annotation spans under the full masthead.
3. Zoom/WebKit repairs: topbar ellipsis + grid `min-width: 0`, rem-inflating column tracks replaced for structural chrome.
4. Playwright suite extended for Pale WebKit captures and 200% text-zoom overflow checks.
5. Planetary Dusk left intact; no card/dashboard or black/yellow regression.

## Viewport coverage

`07 QA/Coded Design Lab Review Evidence/` includes:

- Chromium 320×568, 375×812, 430×932, 768×1024, 1024×768, 1440×900 for index + four prototypes
- open-menu evidence: `375x812-*-story-menu.png`, `webkit-390x844-pale-story-menu.png`
- Pale 200% zoom: `*-pale-*-zoom200.png` (Chromium + WebKit)
- Pale WebKit suite: `webkit-*-pale-*.png`
- `results.json` — chromium + webkit + zoom200; empty error list

## Automated checks

- Prototype Playwright suite: PASS (48 captures across chromium/webkit/zoom200; menus; sequence/layer/link; no overflow)
- `node --check` on Pale `prototype.js`: PASS
- `python3 scripts/check_story_sites.py`: PASS
- `git diff --check`: PASS

## Remaining limitations

- WebKit verification uses Playwright’s Safari engine on Linux, not a physical iPhone Safari session
- Author visual approval still required before production translation
- Planetary Dusk remains available as unselected comparison only

## Production isolation

No edits to production `docs/` story pages, Project Explorer PHP/CSS/JS, builders, or canon notes beyond coordination/QA/exchange updates.
