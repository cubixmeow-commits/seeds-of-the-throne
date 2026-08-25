# Public site gauntlet — 2026-08-24

## Design contract

- **Visual thesis:** an editorial science-fiction field guide where darkness is the unknown, warm ivory is the recoverable record, and signal-gold marks paths back to reality.
- **Content hierarchy:** story promise → human conflict → world and cognition → evidence/conspiracy → author-controlled development → live progress.
- **Interaction thesis:** a quiet first-view reveal, one navigable story-path line, and native disclosure for high-spoiler or deep-development material. Motion never carries meaning and is disabled by reduced-motion preference.
- **Public spoiler boundary:** the premise, core cast, dual-purpose colony, Luminai/Daemon contrast, startup collapse, historical conspiracy, and evidence theme are public. Private criminal-history details, sensitive family mechanics, exact endgame disposal and proof mechanisms, unresolved hierarchy mechanics, and unapproved artifact text stay out of promotional pages. Deep structural spoilers require an explicit disclosure action.

## Scorecard

Dimensions are scored 1–5: story clarity, narrative pull, world connectivity, visual thesis, navigation, accessibility, status honesty, and progress integrity.

| Pass | Story | Pull | Connections | Visual | Navigation | A11y | Status | Progress | Total |
|---|---:|---:|---:|---:|---:|---:|---:|---:|---:|
| Baseline | 3 | 2 | 3 | 2 | 2 | 2 | 2 | 4 | 20 / 40 |
| Cycle 1 | 4 | 4 | 4 | 2 | 4 | 3 | 4 | 5 | 30 / 40 |
| Cycle 2 | 4 | 5 | 5 | 5 | 4 | 4 | 5 | 5 | 37 / 40 |
| Cycle 3 | 4 | 5 | 5 | 5 | 5 | 5 | 5 | 5 | 39 / 40 |

## Baseline findings

- The opening copy is atmospheric but long, low contrast, and more abstract than the central dramatic situation.
- Nine equally weighted navigation destinations create label conflict and decision fatigue.
- Dossier grids repeat across pages, making story, world, and development pages feel structurally interchangeable.
- Some pages publicly expose material the synthesis explicitly says not to publish.
- Several established/working/unresolved labels overstate details or combine status categories unclearly.
- The weekly dashboard correctly reads repository Markdown, but its source link is hard-coded to one dated run.
- Mobile navigation depends on JavaScript and the closed state leaves almost no orientation in the first viewport.

## Cycle log

### Cycle 1 — narrative and information architecture

Status: complete.

Goal: make the story exciting before explaining the vault, give every page one job, reduce repeated exposition, and enforce the spoiler boundary.

Delta: rewrote the opening around Sylvan's destroyed company and the hidden maintainer; reduced the primary navigation to stable destination language; removed unsafe promotional details; replaced repeated summaries with distinct world, cognition, character, conspiracy, chronology, development, visual, and progress routes; added explicit status language at the point of uncertainty.

### Cycle 2 — editorial visual system

Status: complete.

Goal: use approved assets as narrative anchors, establish a consistent type/color/spacing system, and replace generic panels with diagrams, rails, dossiers, and full-bleed media.

Delta: established one dark editorial field with signal-gold provenance; made the confrontation image carry the first viewport; gave the world, Luminai, conspiracy, chronology, and development pages different dominant diagrams inside one system; used approved identity masters as character anchors; replaced card mosaics with rails, ledgers, axes, and full-bleed bands.

### Cycle 3 — interaction, accessibility, and integrity

Status: complete.

Goal: harden keyboard/mobile/no-JS behavior, reduced motion, contrast, live dashboard provenance, link integrity, and final cross-page continuity.

Delta: made mobile navigation progressive-enhancement safe; added Escape close and focus return; retained native disclosure semantics; added visible focus treatment, forced-colors support, reduced-motion behavior, 320 px reflow, descriptive links, one H1/main per page, and complete image alt coverage; made the weekly source link follow the live pointer instead of a dated URL; verified all local links/assets and the 27-task live render.

## Final verification

- Desktop: 1440 × 1000 key-page renders reviewed.
- Mobile: 390 × 844 key-page renders reviewed.
- Reflow: every page checked at 320 px; no horizontal overflow remains.
- Keyboard: mobile menu opens, Escape closes, and focus returns to the trigger.
- Live data: 27 completion tasks load from the current pointer, registry, and workflow state with no dashboard error.
- Structure: every page has one `h1`, one `main`, a skip link, consistent primary navigation, and descriptive image alternatives.
- Contrast: primary text/background pairs range from 6.17:1 to 17.47:1 under WCAG contrast calculation.
- Motion: animation is opt-in under `prefers-reduced-motion: no-preference`; reduced-motion mode removes meaningful movement.
- Code: JavaScript syntax, pointer parsing, local file links, local assets, and whitespace checks pass.
