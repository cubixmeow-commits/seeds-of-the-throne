---
type: cursor-implementation-handoff
status: ready-for-implementation
date: 2026-09-08
scope: docs story site and Project Explorer
content_policy: approved copy locked
---

# Cursor handoff: redesign both Seeds of the Throne websites

## Task

Perform a substantial visual and layout redesign of both existing website surfaces:

- the story site under `docs/`;
- Project Explorer under `iainreiddotdev/project-explorer/`.

This is an implementation task. Inspect the repository, change the actual files, rebuild generated pages, test the result, and leave a clear handoff.

The current wording has just been rewritten and approved. Preserve its meaning and use it as the content foundation. This task is about visual design, page structure, typography, spacing, navigation, responsive behavior, and presentation.

## Read before editing

Read these files completely:

1. `AGENTS.md`
2. `03 Context/CURRENT.md`
3. `03 Context/RULES.md`
4. `skills/update-public-atlas/SKILL.md`
5. `skills/update-public-atlas/references/public-writing-style.md`
6. `scripts/README.md`
7. `01 Sessions/Daily/2026-09-08 - Public Website Voice and Purpose Correction.md`
8. `07 QA/Decisions.md`, especially the September 8 public-voice decision

Inspect the current pages, styles, scripts, generators, approved images, and git status before changing anything. Preserve all existing local work. Do not reset, discard, or overwrite unrelated changes.

## Content lock

The approved public writing style is locked for this visual redesign.

- Do not replace explanations with slogans.
- Do not reintroduce internal terms such as `pointer`, `packet`, `registry`, `runtime`, `author gate`, `corrected story`, or `source-linked brainstorming` as primary copy.
- Do not remove the literal explanation of what the story, Project Explorer, Ideas page, Progress page, or Workshop does.
- Do not silently shorten copy because the design cannot accommodate it. Change the design.
- Small corrections for grammar, accessibility, or duplicated labels are allowed only when they preserve meaning. List every copy change in the handoff.

## Central design concept: the advanced containment archive

The sites should look like they belong to *Seeds of the Throne*.

The story presents an apparently historical civilization built and managed by extremely advanced technology. The visual system should express both layers:

- **Historical surface:** archival records, old institutions, portraits, maps, evidence, inherited power, and reconstructed history.
- **Advanced system underneath:** precise grids, encoded patterns, restrained interface signals, Luminai communication, observation, containment, and hidden control.

The result should feel cinematic, intelligent, mysterious, and functional. It should not look like a generic fantasy site, generic cyberpunk dashboard, luxury fashion magazine, or ordinary SaaS template.

## Current visual problems to solve

The current implementation has several visible failures:

- headings become so large that one sentence occupies most of the screen;
- editorial serif typography is used at display scale too often;
- large areas of empty brown or sepia space reduce usable information density;
- the gold source sections look detached from the darker story world;
- technical repository material is given the same visual importance as the story or tool being explained;
- the Ideas page looks like internal project machinery placed directly on a public page;
- Project Explorer combines a full-screen cinematic hero with a separate dark workbench and a pale repository archive without feeling like one product;
- navigation contains too many equal choices and weak visual grouping;
- desktop layouts waste space while some content still feels crowded;
- mobile rules reduce sizes, but do not create a deliberate mobile information hierarchy.

Do not solve these problems with a few font-size overrides. Redesign the page hierarchy and reusable layout system.

## Shared visual system

Both sites should clearly belong to the same project while serving different purposes.

### Color roles

Use a restrained palette with semantic meaning:

- near-black and charcoal for the main environment;
- warm ivory for primary text;
- muted stone or cool gray for secondary text;
- antique gold for established history, evidence, and important navigation;
- cool cyan or restrained teal for Luminai systems, communication, and constructive technology;
- restrained crimson for Samuel, Daemon influence, coercion, criminal control, and warnings;
- muted green for accepted decisions, completed work, and stable progress.

Avoid large mustard-yellow surfaces, heavy purple, bright neon, excessive gradients, and constant glow. Color must communicate status or meaning rather than decorate every element.

### Texture and atmosphere

Use subtle visual details that connect to the story:

- fine coordinate grids;
- map lines or orbital arcs;
- understated circuitry;
- document rules and archive marks;
- encoded numbers or pattern fragments;
- evidence stamps and status markers;
- soft image grain where it improves cinematic consistency.

Keep these effects quiet. They must not reduce readability or make the pages resemble a game HUD.

### Typography limits

The heading scale must be substantially reduced.

- primary page title: approximately `48px` to `64px` on large desktop, `38px` to `48px` on tablet, and `32px` to `40px` on mobile;
- major section heading: approximately `28px` to `40px` desktop and `24px` to `32px` mobile;
- card or panel heading: approximately `18px` to `24px`;
- body text: generally `16px` to `18px` with comfortable line height;
- labels and metadata: generally `12px` to `14px`.

Do not use `7rem`, `8rem`, or viewport-scaled headings that dominate an entire screen. Do not use a huge heading to create importance when layout, image, contrast, or grouping can do the job better.

Use the serif display face selectively for the story title, character names, or major narrative moments. Use a highly readable sans-serif for explanations, navigation, controls, cards, and development tools. Use monospace only for dates, status, source paths, identifiers, and technical metadata.

### Layout and spacing

- Use a practical maximum content width around `1200px` to `1400px`.
- Use deliberate density. Visitors should see a meaningful heading, explanation, and next action in the first screen.
- Reduce excessive vertical padding. Typical desktop sections should usually use approximately `64px` to `96px`; mobile sections approximately `36px` to `56px`.
- Keep readable prose near `60ch` to `75ch`.
- Use cards only when each card represents a real object or action. Avoid card grids as the default layout for everything.
- Create clear section rhythm through background shifts, image placement, rules, and grouping instead of enormous whitespace.
- Rounded corners should be restrained. The world should feel engineered and archival, not soft and playful.

## Site 1: Docs should present the story

The `docs/` site is for readers. It should make the story understandable and interesting before showing how it is developed.

### Overall layout

- Create a consistent story-atlas shell across the generated pages and the manually maintained Ideas, Progress, and Visuals pages.
- Use cinematic approved artwork where it adds real story context.
- Keep page heroes compact enough that the opening explanation and at least one next action are visible without excessive scrolling.
- Use visual chapter markers, character portraits, timelines, maps, or diagrams to carry atmosphere so the text does not need enormous display treatment.
- Make established story information the strongest visual layer.
- Keep development status, research boundaries, sources, and unanswered questions visible but quieter.
- Create a clear path through Story, World, Luminai, Characters, Conspiracy, Timeline, and then the development pages.

### Story homepage

- Keep the approved literal explanation of *Seeds of the Throne*.
- Use the approved Samuel, Konrad, and Sylvan key art as the main visual unless inspection shows a stronger approved story asset.
- Use a compact split hero or layered cinematic hero rather than a full screen occupied by one heading.
- Give visitors two obvious paths: enter the story and see how it is being developed.
- Present the core subjects as a readable sequence rather than a generic collection of cards.

### Story topic pages

- Give World, Luminai, Characters, Conspiracy, Timeline, and Research a shared page grammar.
- Use moderate page titles, short introductions, and clear sections.
- Use approved portraits without cropping or changing locked faces.
- Make tables and timelines responsive and readable at `320px`.
- Use diagrams only when relationships or chronology are easier to understand visually.

## Ideas page: rebuild it as an Idea Lab

The current Ideas page needs the largest change. It should become a useful decision workspace rather than a long public dump of internal project structure.

### Desktop structure

1. **Compact introduction**
   - Keep the approved explanation of what the page contains.
   - Place total ideas, awaiting review, and research questions in one restrained summary row.
   - Do not use a giant title or a large empty hero.

2. **Filter and search controls**
   - Place status filters in one clear toolbar.
   - Add search only if it operates on the already loaded idea data and can be implemented reliably.
   - Filters and search must have proper labels, keyboard support, and visible active states.

3. **Two-pane decision workspace**
   - Left side: compact, scannable list of ideas.
   - Right side: selected idea detail.
   - Keep the selected detail visible while the list scrolls when screen height permits.
   - Each list item should show title, idea family or story area, and review status without excessive decoration.

4. **Selected idea detail**
   Present the fields in this human order:
   - what the idea is;
   - what supports it;
   - what it could add to the story;
   - the character choice or event it creates;
   - how it might appear in a scene;
   - what could go wrong;
   - what the author needs to decide.

   Status color should be helpful but never the only status indicator.

5. **Research section**
   - Place supporting information and research still needed below the decision workspace.
   - Use compact expandable rows or a readable ledger.
   - Distinguish completed research from suggested research.

6. **Original notes**
   - Place links to the original Markdown notes in a quiet final section.
   - Do not turn implementation details into a large promotional panel.

### Mobile structure

- Stack the introduction, summary, and filters.
- Show the idea list first.
- Selecting an idea should open a clear full-width detail state, dialog, or route-like view with an obvious Back action.
- Do not force a narrow two-column layout.
- Keep controls at least `44px` high.
- Preserve selection and filter state when returning to the list.

## Progress page

- Present the current completion count and stage near the top without a giant hero.
- Explain the development stages with a compact stepper or timeline.
- Group major story problems into understandable sections.
- Make completed, active, and later work visually distinct.
- Keep source-note links quiet and secondary.
- Do not expose pointer, registry, runtime, or workflow terminology in the visible interface.

## Workshop page

- Begin with the approved literal explanation of how the workshop works.
- Put the topic selector, current question, possible answers, consequence comparison, and draft field into a focused working area.
- Make the current question visually dominant without making it enormous.
- Separate the short working view from deeper source notes and adversarial tests.
- Preserve local saving, import, export, and all existing functional behavior.
- Never create a Save control that implies the answer was written to the vault.
- Use clear persistence language: browser draft, exported Markdown, and author-approved vault decision are different states.

## Archive / how the story is developed

- Present the process in plain language as a short visual sequence:
  `conversation → organized notes → missing question → author decision → connected updates → scene plan → prose → revision`.
- Explain confirmed, working, proposed, unresolved, and historical information with a compact status key.
- Keep the original sources available without making repository terminology the main experience.

## Site 2: Project Explorer should present the authoring system

Project Explorer is the practical interface for understanding how the vault works. It should feel related to the story site but more precise, dense, and tool-oriented.

### Overall layout

- Replace the disconnected mixture of cinematic hero, dark workbench, and pale archive with one coherent design system.
- Keep the approved explanation that years of conversations and thousands of ideas are being organized into characters, a world, a timeline, and a finished series.
- Shorten the full-screen hero. A cinematic image may remain, but the next useful interface should be visible quickly.
- Use a compact product header with clear access to Overview, Story, Decisions, Workshop, Progress, and Files.
- The repository browser remains available but should look like a deeper evidence/archive tool, not the primary identity of the product.
- Preserve light and dark appearance functionality if it remains visually coherent. Dark may be the primary story presentation, but both modes must be readable.

### Overview

- Show the authoring sequence in direct language:
  1. the author explains the story;
  2. the system organizes the information;
  3. the workshop finds and asks about missing parts;
  4. accepted answers update connected notes;
  5. the completed structure supports scenes and prose.
- Use one strong process visualization or ordered sequence rather than several unrelated cards.
- Show Seeds of the Throne as the working example beneath the explanation.

### Development views

- Make tabs or navigation look integrated with the application shell.
- Keep evidence, decisions, and sources readable for nontechnical visitors.
- Display technical paths and identifiers only as secondary metadata.
- Give the workshop enough width and focus to function as a real tool.
- Make progress useful at a glance and avoid oversized headings.

### Repository browser

- Preserve search, folder navigation, Markdown rendering, traversal protection, and direct GitHub links.
- Use a restrained three-part desktop layout when space permits: navigation, document, and optional metadata/context.
- On mobile, use a drawer or stacked navigation with a clear way back to the current document.
- Do not let the repository browser inherit giant editorial headings from rendered Markdown.
- Keep Markdown headings readable and proportional to the document pane.

## Approved visual assets

Inspect and reuse approved assets already in `docs/assets/images/`, including:

- `konrad-controlled-by-samuel-key-art-v1.webp`
- `sylvan-elaria-identity-master-v1.jpg`
- `samuel-franklin-identity-master-v1.jpg`
- `konrad-fitzgerald-identity-anchor-v1.webp`
- `samuel-sylvan-confrontation.jpg`
- `remote-war-gold.jpg`
- `remote-war-red.jpg`
- `disclosure-poster.jpg`
- the approved Samuel arrest images

Do not replace approved faces, change identity anchors, or treat scene symbolism as character approval. Do not generate new images during this task unless the author separately authorizes it.

## Technical implementation requirements

- Keep the project framework-free unless the current repository already uses a required dependency.
- Preserve GitHub Pages compatibility for `docs/`.
- Preserve the shared-hosting PHP structure for Project Explorer.
- Treat `05 Public/Atlas/*.md` and `scripts/build_story_sites.py` as the source for generated Atlas pages. Do not make durable edits only to generated HTML.
- `docs/ideas.html`, `docs/todo.html`, and `docs/visuals.html` retain manual interactive structures; inspect `scripts/README.md` before changing them.
- Consolidate design tokens and reusable components where practical without forcing both sites into identical layouts.
- Remove obsolete CSS after the new system replaces it. Do not leave multiple competing style systems or emergency overrides.
- Update cache-busting versions for changed CSS and JavaScript.
- Preserve current JavaScript behavior and PHP security checks.
- Do not change story canon during this redesign.
- Do not push, publish, or deploy unless the author explicitly authorizes it after review.

## Responsive and accessibility requirements

Verify at minimum:

- `320px`, `375px`, `430px`, `768px`, `1024px`, and `1440px` widths;
- no horizontal overflow;
- usable navigation at every width;
- minimum `44px` interactive targets on mobile;
- visible keyboard focus;
- correct headings and landmarks;
- sufficient color contrast;
- status never communicated by color alone;
- reduced-motion support;
- useful alt text and preserved approved-image meaning;
- readable tables, diagrams, workshop controls, and repository documents;
- no content hidden only because JavaScript fails.

## Required verification

Run the documented checks and any relevant additional checks:

```sh
python3 scripts/build_story_sites.py
python3 scripts/check_story_sites.py
git diff --check
node --check docs/app.js
node --check docs/ideas.js
node --check docs/todo.js
node --check docs/workshop.js
```

Run PHP syntax checks on changed PHP files. Start the local sites and visually inspect all changed pages on desktop and mobile. Test navigation, Ideas filtering and selection, Progress loading, Workshop selection and draft persistence, Project Explorer views, repository search, document rendering, and theme switching.

If a browser, PHP, or other required test is unavailable, say exactly which check could not run. Do not mark it passed.

## Acceptance criteria

The redesign is complete only when:

- both sites visibly belong to the same *Seeds of the Throne* world;
- the Story site feels cinematic and reader-facing;
- Project Explorer feels like a practical authoring interface;
- no normal heading overwhelms an entire screen;
- the Ideas page functions as a clear decision workspace;
- the approved public copy remains understandable to a first-time visitor;
- internal repository terminology does not dominate public explanations;
- the sites work at `320px` without horizontal overflow;
- all existing functional behavior still works;
- approved portraits and identity locks remain unchanged;
- generated pages match their sources;
- the final diff contains only intentional redesign files.

## Cursor handoff response

When finished, report:

1. the final visual direction;
2. every major layout change on the Story site;
3. every major layout change in Project Explorer;
4. the Ideas-page interaction and mobile behavior;
5. any copy changed and why;
6. files changed;
7. tests run and results;
8. checks that could not run;
9. remaining limitations;
10. the exact commit status.

Leave the work ready for review. Do not push or deploy without explicit approval.
