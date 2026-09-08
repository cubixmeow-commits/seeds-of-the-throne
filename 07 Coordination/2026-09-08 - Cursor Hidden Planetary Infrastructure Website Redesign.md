---
type: implementation-handoff
status: ready
date: 2026-09-08
owner: Cursor
scope: story atlas and Project Explorer visual redesign
selected_direction: Hidden Planetary Infrastructure
---

# Cursor Hidden Planetary Infrastructure Website Redesign

## Mission

Redesign the public *Seeds of the Throne* story atlas and Project Explorer around the author-selected **Hidden Planetary Infrastructure** direction.

The site should visually express a real, inhabited surface civilization above a concealed planet-scale system. The story site presents a recovered history under scrutiny. Project Explorer is the calmer instrument that shows how conversations, evidence, decisions, workshops, and revisions become finished story work.

This is a visual, layout, and interaction redesign. Preserve the approved content and all repaired functionality. Do not invent story facts or replace literal explanations with slogans.

## Required reading

Read before editing:

1. `AGENTS.md`
2. `START HERE.md`
3. `03 Context/CURRENT.md`
4. `03 Context/RULES.md`
5. [[01 Sessions/Daily/2026-09-08 - Hidden Planetary Infrastructure Website Direction]]
6. [[07 QA/2026-09-08 - Story Sites Visual Direction Assessment]]
7. [[07 Coordination/Website Redesign/2026-09-08 - Hidden Planetary Infrastructure Asset Manifest]]
8. [[07 Coordination/2026-09-08 - Cursor Project Explorer Navigation Repair]]
9. `skills/create-seeds-images/SKILL.md` and `skills/create-seeds-images/references/visual-registry.json` before using any character image

Inspect the current deployed pages and source before changing them. The navigation repair was merged as PR #4 and deployed successfully. Preserve it.

## Author-selected reference

Primary mockup:

`07 Coordination/Website Redesign/Assets/Web/hidden-planetary-infrastructure-selected-mockup-v1.webp`

Use it for visual hierarchy, responsive composition, palette, and the surface/hidden-system reveal. Do not copy its generated prose, faces, labels, navigation omissions, or literal mechanisms.

Production-oriented artwork:

- `07 Coordination/Website Redesign/Assets/Web/planetary-cutaway-hero-desktop-v1.webp`
- `07 Coordination/Website Redesign/Assets/Web/planetary-cutaway-hero-mobile-v1.webp`
- `07 Coordination/Website Redesign/Assets/Web/surface-civilization-editorial-v1.webp`
- `07 Coordination/Website Redesign/Assets/Web/recovered-records-evidence-v1.webp`

Copy only the WebP files that the implementation actually uses into `docs/assets/images/` with stable names. Keep the source package untouched.

Existing approved character art remains authoritative. The generated mockup contains non-authoritative faces. Never use them.

## Design thesis

**A recovered history tested against a living planetary system.**

The design must hold four truths at once:

1. The surface civilization is real, ordinary, historically accumulated, and consequential.
2. An extraordinary distributed infrastructure exists underneath it.
3. public history, sealed records, and observable outcomes do not always agree;
4. the central conflict is about whether leaders use people as material or preserve their agency and judgment.

The site is not a spaceship interface, fantasy kingdom page, generic black SaaS dashboard, or sepia archive theme.

## Responsibilities of the two surfaces

### Story atlas: reader invitation

The `docs/` site should:

- explain the premise in plain language within the first screen;
- feel cinematic, human, editorial, and mysterious;
- organize discovery around world, people, concealed history, and consequence;
- use images as evidence and world experience, not wallpaper;
- keep development labels available without making the story read like project management.

### Project Explorer: authoring instrument

Project Explorer should:

- demonstrate conversation → organized evidence → missing question → author decision → propagation → scene plan → prose/revision;
- remain denser, quieter, and more task-oriented than the story atlas;
- preserve distinct destinations, active states, mobile menu behavior, file browser, search state, Workshop persistence/import/export, and theme switching from PR #4;
- make the repository a secondary evidence layer rather than the product's opening argument.

## Story-site information architecture

Keep the navigation groups introduced by the repair:

- **Story:** Story, World, Luminai, Characters, Conspiracy, Timeline.
- **Development:** Ideas, Progress, Workshop, Research.
- **Records:** Visuals, Archive.

Project Explorer remains the clear “how it is being built” destination. Every page must have a truthful `aria-current="page"` state. The mobile menu must preserve groups and remain keyboard accessible.

Do not remove Research, Visuals, Archive, or the repaired navigation state in pursuit of visual simplicity.

## Homepage specification

### First screen

The first screen must include:

- compact site header;
- “Seeds of the Throne”;
- the current approved literal explanation of the colonization planet, Luminai relationship, cultivation purpose, and criminal containment;
- a short consequence or discovery turn drawn from already approved public copy;
- “Enter the story”;
- “See how it is being built”;
- responsive planetary-cutaway artwork integrated with the composition.

Use `<picture>` so mobile receives the portrait artwork and desktop receives the landscape artwork. The title and explanation must remain HTML. At 320–430px, do not place long copy over visually busy infrastructure. A controlled dark field or gradient may separate the copy from the art.

Do not repeat the current pattern of a complete text block followed by an unrelated rectangular poster. The artwork and explanation should compose one opening.

### Narrative sequence beneath the hero

Build a controlled editorial sequence, not a uniform card wall:

1. **The world everyone knew** — ordinary life, institutions, accumulated history, and real agency. Use the surface-civilization image.
2. **The system underneath** — colonization infrastructure, Luminai development, cultivation, coordination, and containment. Use selected details from the cutaway without asserting the depicted rooms are literal.
3. **Competing uses of power** — introduce Konrad's public domination, Samuel's private capture, and Sylvan's reality/correction/consent alternative. Use approved character art only.
4. **The record does not agree** — public history versus sealed evidence, rival explanations, and consequences. Use the recovered-records image.
5. **Book One begins near the end** — express reader discovery order without disclosing protected outcomes.
6. **Two ways forward** — follow the story or inspect how the story is being built.

The section names above are structural descriptions, not mandatory public headlines. Reuse approved public wording wherever possible.

## Page-specific visual mechanisms

### World

- Use layered surface/understructure composition.
- Give ordinary institutions, homes, labor, transport, and culture real visual weight.
- Do not imply the population is fake, staged, or unknowingly standing inside visible machinery.
- Mark interpretive diagrams as interpretive.

### Luminai

- Focus on relationship, judgment, mutual correction, and different integration generations.
- Luminai manifestation, when used, is energy integrated around the person's head/chest and environment, not a separate robot, face, avatar, orb, or romantic companion.
- Use antique gold for constructive integration and clear blue only for active coordination.

### Characters

- Replace the feel of a generic equal-card gallery with a readable power/relationship composition.
- Preserve identity locks for Samuel, Sylvan, and Konrad.
- Konrad must remain the approved broad, square-faced, clean-shaven, close-cropped iron-gray figure.
- Make visual hierarchy express different methods of power without declaring unresolved events.

### Conspiracy

- Use the recovered-records visual language most strongly here.
- Separate claim, source, discrepancy, rival explanation, and consequence.
- Repetition is not proof. The interface must not visually certify a pattern merely because lines connect it.

### Timeline

- Show chronological history and reader discovery order as two related axes.
- Keep the mobile version readable without a horizontally overflowing desktop diagram.
- Do not lock the unresolved later-book order.

### Ideas

- Preserve the functional two-pane/filter behavior.
- Reduce dashboard-like card repetition.
- Present proposals as an editorial notebook or evidence workspace with unmistakable proposed/unresolved status.

### Progress

- Show progress toward a finished story, not only repository activity.
- Preserve honest incomplete states and current author gates.
- Do not manufacture completion percentages or imply the manuscript is further advanced than its sources.

### Workshop

- Preserve the repaired Project Explorer styling isolation and the current session behavior.
- Make the active question the dominant mobile task.
- Keep module browsing secondary and collapsible.
- Preserve local storage, import, export, and error disclosure.

### Research

- Visually distinguish real evidence, fictional extension, and unresolved boundary.
- Keep primary-source links and cautious language.
- Do not let styling make advisory research appear canonical.

### Visuals and Archive

- Visuals should feel like a curated evidence room, not an undifferentiated gallery.
- Archive should explain source authority and development status before exposing raw files.
- Keep selected nav states from PR #4.

## Project Explorer redesign

### Primary views

Keep the repaired route model:

| View | Required purpose |
|---|---|
| Overview | Explain the authorship system and show the production chain |
| Story | Show organized story understanding and its reviewed sources |
| Decisions | Show author gates, evidence, accepted choices, propagation, and consequences |
| Workshop | Ask one high-leverage question at a time |
| Progress | Show movement toward finished work |
| Files | Inspect supporting source material without dominating the product |

### Visual relationship to the story site

- Reuse palette roles, type families, fine provenance lines, and evidence language.
- Use flatter surfaces, less cinematic imagery, tighter spacing, and clearer controls.
- Let warm paper/ivory identify human-authored records.
- Let near-black identify the system frame.
- Let gold identify evidence and accepted paths.
- Let cyan identify coordination and inspectable system flow.
- Let crimson identify unresolved conflict, capture, or contradiction only when semantically true.

### Mobile task order

1. current view and purpose;
2. current question/decision/progress;
3. next useful action;
4. supporting evidence;
5. repository browser behind the existing deliberate browse control.

Do not return the repository tree above the current document. Do not remove the mobile hamburger or 44px targets.

## Visual system

### Color roles

Use semantic variables rather than scattering literal colors:

```css
--void: #050504;
--charcoal: #14110e;
--paper: #d4be98;
--ivory: #f3eee4;
--gold: #c28a32;
--gold-bright: #f1cf68;
--system-blue: #67aee8;
--living-green: #71c987;
--fracture-red: #8e0b0b;
--ember-red: #c7241c;
```

These are role anchors from the visual system, not permission to use every color on every screen. Red and cyan should be rare enough to retain meaning.

### Typography

- Serif for story turns, names, recovered-document headings, and historical weight.
- Sans serif for literal explanations, navigation, controls, and sustained reading.
- Monospace for dates, provenance, status, references, permissions, and evidence labels.
- Keep the main title powerful but smaller than the previous oversized redesign.
- Maintain comfortable line lengths and body sizes at every viewport.

Use locally safe/system-hosted fonts or the existing approved font-loading strategy. Do not introduce a fragile third-party dependency.

### Shape and borders

- Use precise thin rules, bounded fields, occasional interrupted lines, and layered edges.
- Avoid rounded SaaS cards as the universal component.
- Reserve modest rounding for actual controls if useful; editorial records and system panels may remain square or nearly square.
- Avoid ornamental frames that resemble fantasy menus.

### Image treatment

- Prefer purposeful full-width or split editorial compositions over small repeated thumbnails.
- Do not put text directly into generated images.
- Use CSS overlays and real HTML annotations.
- Preserve intrinsic ratios and focal points.
- Existing character images must retain their approved crop and identity.
- Captions must distinguish approved appearance from interpretive scene symbolism.

### Motion

Allow only restrained motion that reveals meaning:

- surface-to-understructure layer reveal;
- evidence alignment;
- active provenance path;
- before/after interpretation;
- menu/drawer transitions.

Respect `prefers-reduced-motion`. Avoid constant glow, pulsing, scanning lines, parallax that interferes with reading, and decorative HUD motion.

## Responsive requirements

Mobile is a designed composition, not desktop source order stacked vertically.

Test at:

- 320px
- 375px
- 430px
- 768px
- 1024px
- 1440px

At 320–430px:

- title, literal explanation, and at least one primary action must appear coherently before the page becomes visually overwhelming;
- use the portrait hero source;
- prevent text from sitting on the detailed red containment region;
- keep the menu, theme control, and active state available;
- use at least 44px touch targets;
- keep all diagrams and timelines within the viewport;
- avoid repeated full-height panels that make the page feel endless.

At desktop:

- use the landscape hero with the protected left copy field;
- keep the header compact;
- avoid a hero so tall that no narrative transition is visible;
- use controlled asymmetry without sacrificing scan order or keyboard order.

## Content and canon boundaries

- Preserve current approved public copy unless a tiny connective edit is required for layout; report every copy change.
- A slogan cannot replace the literal premise.
- Do not use generated mockup wording as source copy.
- Do not invent names, quotations, archive identifiers, cities, institutions, maps, evidence, timelines, or mechanisms.
- Do not imply that the surface civilization is a shallow fake or simulation.
- Do not resolve the exact command-moon architecture, hidden-system topology, evidence construction, Luminai hardware, containment permissions, or later-book order.
- Do not promote artwork into the visual registry as canonical character or environment authority.
- Preserve status labels and source-authority distinctions.

## Implementation strategy

1. Establish shared semantic tokens and base typography.
2. Implement the responsive header/navigation without regressing PR #4.
3. Rebuild the story homepage around the selected mockup and supplied art.
4. Apply the page-specific mechanisms through the source generator and hand-maintained pages.
5. Redesign Project Explorer as the related working instrument.
6. Rebuild generated outputs from source.
7. Run automated and visual verification.
8. Fix every regression before writing the completion report.

Prefer a small number of coherent components and source-driven templates. Do not hand-edit generated pages in ways that will be overwritten by `scripts/build_story_sites.py`.

## Accessibility and performance

- Preserve semantic headings and one logical `h1` per page.
- Keep skip links.
- Maintain visible focus states in every theme.
- Maintain truthful `aria-current`, `aria-expanded`, and menu/drawer relationships.
- Ensure text contrast over images under light and dark/system themes.
- Do not communicate status by color alone.
- Use descriptive alt text and empty alt only for genuinely decorative fragments.
- Use responsive images and lazy loading below the fold.
- Do not add a heavy animation or UI framework.
- Keep public derivatives within the image budget; the provided WebPs are already approximately 188–305 KB.
- Prevent layout shift with dimensions/aspect ratios.
- Preserve progressive behavior when JavaScript fails.

## Verification

Extend `scripts/test_story_browser.cjs` rather than weakening the repaired assertions.

Verify at all six widths:

- no horizontal overflow;
- story and Project Explorer menus open/close by pointer and keyboard;
- Escape and focus return;
- active states remain truthful;
- all story/development/records destinations remain reachable;
- Project Explorer routes remain visibly distinct;
- sticky headers do not obscure destinations;
- archive drawer and file selection remain usable;
- 44px mobile targets;
- image source selection and no layout shift;
- heading hierarchy;
- theme switching;
- Workshop load, persistence, module switching, import, and export;
- search/file/view state;
- no missing assets, console errors, or 4xx responses.

Run:

- `python3 scripts/build_story_sites.py`
- `python3 scripts/check_story_sites.py`
- `python3 skills/create-seeds-images/scripts/validate_visual_system.py`
- `node --check` for every changed JavaScript file
- PHP lint for every changed PHP file
- `node scripts/test_story_browser.cjs`
- `git diff --check`
- `git status --short`

Perform real visual inspection, not only screenshot creation, at all six widths for:

- story homepage;
- World;
- Luminai;
- Characters;
- Conspiracy;
- Timeline;
- Ideas;
- Progress;
- Workshop;
- Research;
- Visuals;
- Archive;
- all six Project Explorer views.

## Acceptance criteria

- A first-time visitor can explain what the story is, why the planet matters, and where to go next after the first screen.
- The homepage could only belong to *Seeds of the Throne*.
- The surface civilization feels real and worth protecting.
- The hidden infrastructure feels consequential without becoming a generic sci-fi interface.
- Recovered evidence changes interpretation rather than functioning as decoration.
- Story pages feel editorial and cinematic; Project Explorer feels precise and useful.
- Approved character identity is preserved.
- Current copy and story status remain accurate.
- PR #4 functionality and accessibility remain intact.
- Mobile layouts are deliberately composed.
- The build, source checks, visual-system validation, JavaScript checks, PHP lint, and browser tests pass.

## Required completion report

Before marking this handoff implemented-for-review, add a completion report to this file containing:

1. visual and structural summary;
2. exact files changed;
3. assets used and final public paths;
4. any copy changes, quoted exactly;
5. source/template strategy;
6. preserved PR #4 behavior;
7. automated checks and exact results;
8. viewport-by-viewport visual inspection table;
9. accessibility and performance findings;
10. anything not tested;
11. remaining limitations;
12. branch, implementation commit, and clean working-tree status.

Do not merge to `main` or deploy. Leave a focused PR ready for author review.
