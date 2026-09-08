---
type: visual-qa
status: review
date: 2026-09-08
scope: coded website design lab prototypes
---

# Coded Website Design Lab Review

## Prototype paths

- Lab index: `iainreiddotdev/design-lab/seeds/index.html`
- Planetary Dusk Story: `iainreiddotdev/design-lab/seeds/planetary-dusk/story.html`
- Planetary Dusk Explorer: `iainreiddotdev/design-lab/seeds/planetary-dusk/explorer.html`
- Pale Signal Story: `iainreiddotdev/design-lab/seeds/pale-signal/story.html`
- Pale Signal Explorer: `iainreiddotdev/design-lab/seeds/pale-signal/explorer.html`

Opening locally:

```bash
php -S 127.0.0.1:8766 -t .
# then visit http://127.0.0.1:8766/iainreiddotdev/design-lab/seeds/
```

## Viewport coverage

Screenshots for every required viewport are in `07 QA/Coded Design Lab Review Evidence/`:

- 320×568, 375×812, 430×932, 768×1024, 1024×768, 1440×900
- pages: index, dusk-story, dusk-explorer, pale-story, pale-explorer
- automated results: `results.json`

Automated checks: no `documentElement`/`body` overflow; mobile menus open/Escape/focus restore; ≥44px primary targets; dusk sequence interaction; pale layer reveal; Story↔Explorer links.

## Visual observations

### Planetary Dusk

- Deep navy/slate field with mineral cyan signals; no dominant black+yellow archive treatment.
- Desktop hero places frost copy over a masked planetary cutaway so the image participates in the opening.
- Mobile stacks copy first, then masked art; short 320×568 viewports prioritize premise and actions before imagery.
- Explorer is denser: evidence hero, current decision, stepped authorship chain, and a wrapping long workshop path.

### Pale Signal

- Fog/mineral light field, deep ink type, sea-glass labels, coral contradiction bar.
- Asymmetric masthead with clipped image fragment and HTML annotation; materially different from Dusk’s full-bleed orbital mask.
- Mid-page concealed dark band reveals Luminai / evidence / purpose layers through pressed controls.
- Explorer uses raised pale panels plus a dark premise insert; files entry remains secondary.

## Strengths

- Both directions use approved public copy and approved identity portraits only.
- Story vs Explorer density differs inside each identity.
- Interactions are meaningful (disclosure/sequence/layers), not decorative HUD motion.
- Production story pages and Project Explorer files were not modified.

## Weaknesses / tradeoffs

- On very short mobile heights, Dusk CTAs can sit near the fold edge before the planetary art appears.
- Warm cutaway artwork is hue-shifted/desaturated to avoid dragging pages toward yellow/brown; some residual warmth remains in deep infrastructure glow.
- Prototype navigation is lab-scoped (Story / Explorer / other direction / index), not a full production IA.
- System fonts approximate the intended modern display voice; no webfont lock-in yet.
- UI/UX Pro Max suggested green/amber and OLED-black patterns; those were rejected in favor of Seeds skill tokens.

## Browser limitations

- Verified in headless Chromium only.
- No Safari/iOS device pass in this cycle.
- 200% text zoom was not exhaustively screenshot-audited.

## Unresolved author choices

- Which coded direction should be refined next: Planetary Dusk or Pale Signal?
- Whether either needs a third hybrid pass before production translation.
- Whether warm generated environment art should be further masked/omitted in the selected direction.

## Production isolation confirmation

`git status` shows new files only under:

- `iainreiddotdev/design-lab/`
- `07 QA/Coded Design Lab Review Evidence/`
- `.cursor/` (UI/UX Pro Max installer output)
- coordination/handoff/exchange updates

No changes to `docs/*.html`, production Project Explorer PHP/CSS/JS, or story builders.
