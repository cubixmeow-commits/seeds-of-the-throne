---
type: visual-qa
status: review
date: 2026-09-08
scope: coded website design lab prototypes — Pass 1B
---

# Coded Website Design Lab Review

## Prototype paths

- Lab index: `iainreiddotdev/design-lab/seeds/index.html`
- Planetary Dusk Story: `iainreiddotdev/design-lab/seeds/planetary-dusk/story.html`
- Planetary Dusk Explorer: `iainreiddotdev/design-lab/seeds/planetary-dusk/explorer.html`
- Pale Signal Story: `iainreiddotdev/design-lab/seeds/pale-signal/story.html`
- Pale Signal Explorer: `iainreiddotdev/design-lab/seeds/pale-signal/explorer.html`

```bash
php -S 127.0.0.1:8766 -t .
# http://127.0.0.1:8766/iainreiddotdev/design-lab/seeds/
```

## Pass 1B changes addressed

1. Removed committed `.cursor/` installer payload from the PR; recorded tool use in reports only; added `.cursor/` to `.gitignore`.
2. Mobile Story openings at 320–430 now keep artwork in the first viewport (Dusk: full-bleed planetary field under gradient copy; Pale: clipped fragment column beside copy).
3. Explorers redesigned away from card stacks: Dusk = continuous vertical-spine thread with orbital evidence; Pale = asymmetrical editorial working sheet with rail + clipped annotation.
4. Most boxed panel borders removed; hierarchy uses spine/rules, tonal fields, type, spacing, and crops.
5. Authored display/label type stacks (condensed/Futura-family display + mono labels) without webfont loading or fantasy serif.
6. Story visual language carried into matching Explorers.
7. Evidence re-captured including open-menu mobile shots; checks re-run.

## Viewport coverage

`07 QA/Coded Design Lab Review Evidence/` includes:

- 320×568, 375×812, 430×932, 768×1024, 1024×768, 1440×900 for index + four prototypes
- open-menu evidence: `375x812-dusk-story-menu.png`, `375x812-pale-story-menu.png`
- `results.json` — automated overflow/menu/interaction pass with empty error list

## Automated checks

- Prototype Playwright suite: PASS (30 viewport captures + menu/sequence/layer/link checks; no overflow)
- `node --check` on both `prototype.js` files: PASS
- `python3 scripts/check_story_sites.py`: PASS
- `git diff --check`: PASS after `.cursor/` removal

## Remaining limitations

- Chromium-only verification; Safari/iOS and exhaustive 200% zoom still unverified
- Short 320×568 Dusk screens may crop the secondary CTA below the fold while keeping art + primary actions visible
- Warm cutaway art remains filtered/desaturated rather than replaced

## Production isolation

No edits to production `docs/` story pages, Project Explorer PHP/CSS/JS, builders, or canon notes beyond coordination/QA/exchange updates.
