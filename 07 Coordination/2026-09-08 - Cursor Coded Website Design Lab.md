---
type: implementation-handoff
status: implemented-for-author-review
date: 2026-09-08
owner: Cursor
scope: isolated coded website prototypes
production_changes: prohibited
---

# Cursor Coded Website Design Lab

## Outcome

Build two genuinely different, functioning, responsive interface directions for *Seeds of the Throne*. The author must be able to open and use the designs in a browser on mobile and desktop.

This is not another production redesign. Do not modify, restyle, or import prototype code into the live story atlas or Project Explorer. The deliverable is an isolated design lab and a review PR.

## Required agent exchange

Use [[07 Coordination/Website Redesign/CURSOR-CODED-DESIGN-EXCHANGE]] as the sole Cursor–Codex status and review channel for this work.

The author is coordinating from a phone with limited time. Do not require screenshots of Cursor's chat, long copied completion reports, or manual transcription. At the end of each pass:

1. update the `Cursor pass report` in the exchange;
2. set its frontmatter `status` to the correct next state;
3. update `Current next action`;
4. commit and push the implementation and exchange together;
5. open or update the focused PR;
6. stop and wait.

Codex will inspect the branch and rendered evidence, then commit its review to the exchange. On the next prompt, read the newest exchange from the branch before editing anything.

Do not use this handoff's completion report as a substitute for the exchange. The exchange controls each iterative pass.

## Why this assignment exists

The deployed Hidden Planetary Infrastructure implementation is structurally functional but visually rejected. Its dominant black field, yellow/antique-gold accents, traditional archive personality, large filled yellow CTA, repeated bordered rectangles, and poster-like image placement do not create an acceptable or distinctive identity.

Do not repair that design through palette substitution. Start from composition and interaction.

## Required reading

Read completely before editing:

1. `AGENTS.md`
2. `START HERE.md`
3. `03 Context/CURRENT.md`
4. `03 Context/RULES.md`
5. `skills/README.md`
6. `skills/design-seeds-site/SKILL.md`
7. every reference routed by that skill for Prototype mode
8. [[01 Sessions/Daily/2026-09-08 - Coded Website Design Lab Direction]]
9. [[07 Coordination/2026-09-08 - Cursor Project Explorer Navigation Repair]]
10. [[07 Coordination/Website Redesign/2026-09-08 - Hidden Planetary Infrastructure Asset Manifest]] before using generated website art

Inspect the deployed story homepage and Project Explorer at 320–430px and 1440px. Record the current failures before building.

## Design intelligence skill

Use UI/UX Pro Max if it is already available in Cursor. If it is not available, initialize the official `nextlevelbuilder/ui-ux-pro-max-skill` Cursor integration with:

```bash
npx ui-ux-pro-max-cli init --ai cursor
```

Inspect everything the installer changes before committing. Do not allow it to overwrite project rules or production code. UI/UX Pro Max is a reference and critique system; it does not choose the Seeds identity. The repository's `design-seeds-site` skill and the author's corrections control this assignment.

If installation is unavailable, continue without blocking. Do not replace the work with a generic framework template.

## Isolation boundary

Create only this prototype area for rendered design code:

```text
iainreiddotdev/design-lab/seeds/
  index.html
  shared/
  planetary-dusk/
    story.html
    explorer.html
    design.css
    prototype.js
  pale-signal/
    story.html
    explorer.html
    design.css
    prototype.js
```

Shared asset filenames may vary. Keep each direction independently understandable. Do not link the design lab from production navigation.

Do not change during this task:

- `docs/*.html`
- `docs/styles.css`
- `docs/atlas.css`
- production story builders
- `iainreiddotdev/project-explorer/index.php`
- production Project Explorer CSS or JavaScript
- approved public Markdown projections
- story, research, or canon notes beyond the completion record requested below

Existing approved images may be referenced with relative paths rather than duplicated. Do not generate new character identities.

## Prototype index

The design-lab index must link to all four prototype pages, identify the directions neutrally, state that they are responsive coded prototypes rather than production pages, and provide direct Story and Project Explorer links for each direction. It must contain no design-score table and no declared winner.

## Direction A — Planetary Dusk

Create an atmospheric, spatial science-fiction interface using deep navy, storm slate, mineral cyan/teal, frost text, and restrained signal red. Do not use black, yellow, mustard, amber, antique gold, or sepia as dominant colors.

The composition should use depth, overlap, negative space, image masking/cropping, planetary geometry, and meaningful system traces. It must not resemble a spaceship HUD, gaming menu, streaming-service page, or generic dark SaaS landing page.

### Story prototype

Use the real Seeds homepage title and approved premise. Design a complete opening composition and at least three following story sections. The image must participate in the hero rather than appear as a separate rectangular poster after the text.

Required content moments are ordinary surface civilization, concealed planetary purpose, the human–Luminai relationship, the Samuel/Sylvan/Konrad conflict using approved identity art only if portraits are shown, and clear ways to enter the story and inspect its development.

### Explorer prototype

Translate the same identity into a more precise working surface. Include representative navigation, current task or decision, the conversation-to-finished-work sequence, and a deliberate entry to Files. Do not reproduce a terminal, archive, file tree, or dashboard as the opening argument.

## Direction B — Pale Signal

Create a lighter, mineral future-editorial interface using fog or mineral gray-blue, raised pale surfaces, deep blue ink, sea-glass system color, and restrained coral/red contradiction signals. Dark sections should reveal concealed systems rather than cover the entire page.

Use asymmetry, strong whitespace, precise modern typography, cropped image fragments, overlays, annotations, and revealed layers. It must not resemble a corporate annual report, museum template, newspaper, or generic editorial portfolio.

Build the same Story and Explorer coverage as Direction A, but use a materially different spatial and interaction model. A palette swap is a failure.

## Real-content requirement

Use current approved public copy from the generated story pages. Do not use lorem ipsum, invented slogans, generated labels, or shortened fake paths. Include at least one genuinely long repository path in each Explorer prototype so mobile behavior is tested under real pressure.

Prototype copy may be selected and reordered for the experiment, but not rewritten as new story fact.

## Interaction requirement

Each direction must include:

- a working mobile menu;
- visible current navigation state;
- working links between its Story and Explorer prototypes;
- one meaningful disclosure, evidence, sequence, or progress interaction;
- keyboard operation and visible focus states;
- reduced-motion behavior.

Avoid interaction added only for spectacle.

## Responsive requirement

Design and inspect at 320×568, 375×812, 430×932, 768×1024, 1024×768, and 1440×900.

There must be no page-level horizontal overflow. Check both `documentElement.scrollWidth` and `body.scrollWidth`; also identify elements whose bounds escape the viewport. Long paths must wrap or truncate inside their components. Tables and code may scroll only inside their own containers.

Mobile must have its own composition decisions. Do not merely stack desktop columns.

## Typography and iconography

- Use locally available/system fonts or appropriately licensed web fonts with resilient fallbacks.
- Select typography from rendered testing, not a pairing table alone.
- Do not let a conventional historical serif carry the entire identity.
- Use icons only when they improve recognition or operation.
- Do not use emoji as product icons.

## Image rules

- Existing generated environment images remain interpretive and non-canon.
- Existing approved character art remains authoritative for identity.
- Do not use faces from mockups or visible text baked into generated images.
- Do not depend on an image to communicate essential copy.
- If current warm artwork fights the new palette, mask, crop, blend, desaturate, or omit it. Do not force the page palette toward yellow or brown to accommodate an asset.

## Visual QA and evidence

Use Playwright or an equivalent rendered-browser workflow. Save screenshots for every listed viewport for all four pages under a clearly named review folder outside production assets. Inspect the screenshots yourself; automated passes are necessary but insufficient.

Create `07 QA/2026-09-08 - Coded Website Design Lab Review.md` recording exact prototype paths, viewport coverage, overflow and interaction results, visible strengths and weaknesses, browser limitations, unresolved author choices, and confirmation that production files did not change. Do not rank the alternatives or silently choose one.

## Verification

Run relevant prototype checks plus:

```bash
git diff --check
python3 scripts/check_story_sites.py
```

Validate HTML semantics, links, keyboard operation, focus states, contrast, touch targets, text scaling, reduced motion, image loading, and mobile overflow. Review the diff specifically for accidental production changes and installer output.

## Completion report

Append a concise report to this handoff containing:

1. prototype files created;
2. external design skill installation result and files it added;
3. actual content and assets used;
4. interactions implemented;
5. screenshots produced;
6. viewport and accessibility results;
7. known limitations;
8. exact review paths;
9. production-isolation confirmation;
10. branch, commit, PR, and clean working-tree status.

Mark this handoff `implemented-for-author-review`. Open a focused PR. Do not merge or deploy.

For Pass 1, also set the exchange to `awaiting-codex-review-1`. Codex and the author will control subsequent state transitions.

## Completion report

1. **Prototype files created:** `iainreiddotdev/design-lab/seeds/index.html`; `shared/README.md`; `shared/test-design-lab.cjs`; `planetary-dusk/{story,explorer,design.css,prototype.js}`; `pale-signal/{story,explorer,design.css,prototype.js}`.
2. **External design skill installation:** `npx ui-ux-pro-max-cli init --ai cursor` succeeded. Added `.cursor/skills/` packages (`ui-ux-pro-max` plus bundled siblings: banner-design, brand, design, design-system, slides, ui-styling). No AGENTS/rules/production overwrites.
3. **Content and assets used:** approved homepage premise/consequence and public Atlas wording; approved Konrad/Samuel/Sylvan identity art; interpretive planetary-cutaway, surface-civilization, and recovered-records WebPs referenced from `docs/assets/images/` (not duplicated).
4. **Interactions:** working mobile menus; aria-current; Story↔Explorer links; Dusk authorship-sequence buttons; Pale concealed-layer panels; focus-visible; reduced-motion.
5. **Screenshots:** `07 QA/Coded Design Lab Review Evidence/` — 30 first-viewport captures across six sizes × five routes, plus `results.json`.
6. **Viewport/a11y results:** automated overflow/menu/target/interaction checks passed; Chromium visual inspection recorded in `07 QA/2026-09-08 - Coded Website Design Lab Review.md`.
7. **Known limitations:** Chromium-only; short mobile may defer Dusk art below fold; filtered warm artwork; lab IA is intentionally small.
8. **Review paths:** prototypes under `iainreiddotdev/design-lab/seeds/`; QA note + evidence folder under `07 QA/`; exchange at `07 Coordination/Website Redesign/CURSOR-CODED-DESIGN-EXCHANGE.md`.
9. **Production isolation:** no edits to production story pages, Project Explorer, builders, public copy, or canon notes beyond this handoff/exchange/QA record.
10. **Branch/PR:** `codex/coded-design-lab-handoff` / PR #7; exchange set to `awaiting-codex-review-1`. Do not merge or deploy.

