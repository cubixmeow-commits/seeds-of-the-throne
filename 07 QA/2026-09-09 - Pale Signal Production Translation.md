---
type: visual-qa
status: review
date: 2026-09-09
scope: Pale Signal production translation + focused production repair — Story atlas + Project Explorer
---

# Pale Signal Production Review

## Surfaces

- Story atlas: generated `docs/*.html` via `scripts/build_story_sites.py` + `docs/styles.css` + `docs/atlas.css`
- Hand pages: `docs/todo.html`, `docs/ideas.html`, `docs/visuals.html`
- Project Explorer: `iainreiddotdev/project-explorer/` (PHP + `project-explorer.css` + `workbench.css`)

```bash
php -S 127.0.0.1:8766 -t .
# http://127.0.0.1:8766/docs/index.html
# http://127.0.0.1:8766/iainreiddotdev/project-explorer/?view=overview
```

## Production translation

1. Replaced rejected black/gold archive tokens with Pale Signal mineral field, deep ink, cyan labels, coral containment signals, and Futura/Segoe display+UI stacks (compatibility aliases preserved so existing components keep working).
2. Homepage uses asymmetrical `signal-masthead` (copy + clipped infrastructure fragment + story-facing annotation) from the builder, not poster-after-copy.
3. Reading/workshop panels and editorial bands reduced from boxed cards toward rules, whitespace, and tonal fields.
4. Project Explorer remapped to the same identity with denser working-sheet rhythm; evidence caption story-facing; light default / concealed dark theme; menu, archive browse, Workshop, Files, and theme toggle preserved.
5. Asset cache-bust advanced to `20260909-pale-repair` after the production repair pass.

## Production repair (Codex review blockers)

1. Full `.explorer-hero` only on Overview; Files / Workshop / sources / evidence / Progress use compact `.explorer-route` so the route heading and useful content are in the first mobile viewport.
2. Closed-menu active destination via `.explorer-route-chip` (“Now viewing …”) while preserving hamburger open/close behavior.
3. Removed opacity entrance on essential `.signal-masthead__copy`; evidence capture waits for settled opaque paint.
4. Dark theme uses deep `--archive-wash-top/bottom` so the main field is not a pale wash; closed-menu dark capture recorded.
5. Refreshed full evidence set plus explicit 320/390 Overview–Files–Workshop distinct shots.

## Evidence

`07 QA/Pale Signal Production Evidence/` includes Chromium captures at 320/375/390/430/768/1024/1440 for Story home/world/workshop and PE overview/workshop/files; open-menu and theme-toggle shots; closed-menu dark PE overview (`375x812-pe-overview-dark-closed.png`); 320/390 distinct route shots (`*-distinct.png`); Chromium 200% zoom; WebKit Story/PE captures; `results.json` with empty errors (63 captures).

## Automated checks

- `python3 scripts/build_story_sites.py` + `check_story_sites.py`: PASS
- `node scripts/test_story_browser.cjs` (7 widths incl. 390): PASS (235 checks)
- `node scripts/capture_pale_signal_production_evidence.cjs`: PASS (63 captures, 0 errors)
- `git diff --check`: PASS

## Remaining limitations

- Playwright WebKit ≠ physical iPhone Safari; author device check still recommended before deploy
- Portfolio `site.css` still wraps PE chrome; PE overrides carry the Pale Signal identity
- Design-lab prototypes remain for comparison and were not removed

## Production isolation / merge

No merge or deploy. Prototype lab assets left intact. Exchange state: `awaiting-production-review-2`.
