---
type: implementation-handoff
status: implemented-for-review
date: 2026-09-08
owner: Cursor
scope: Project Explorer repair and responsive verification
---

# Cursor Project Explorer Navigation Repair

## Outcome

Repair the deployed Project Explorer navigation and mobile experience without performing the larger story-led visual redesign. The current page makes Overview, Story, Decisions, and Workshop appear to lead to the same place, has no Project Explorer hamburger menu on mobile, and contains related responsive and integration defects described below.

The redesign assessment is separate: [[07 QA/2026-09-08 - Story Sites Visual Direction Assessment]]. Do not implement that assessment in this repair pass.

## Start here

1. Read `AGENTS.md`, `START HERE.md`, `03 Context/CURRENT.md`, and `07 Coordination/RULES.md`.
2. Read [[07 Coordination/2026-09-08 - Cursor Story Sites Visual Redesign]] and [[01 Sessions/Daily/2026-09-08 - Cursor Story Sites Visual Redesign]] as implementation history, not proof that verification passed.
3. Inspect the current source and deployed behavior before editing.
4. Work from the current `main`. Preserve unrelated user changes and commits.

Primary files:

- `iainreiddotdev/project-explorer/index.php`
- `iainreiddotdev/project-explorer/workbench.php`
- `iainreiddotdev/project-explorer/assets/project-explorer.css`
- `iainreiddotdev/project-explorer/assets/workbench.css`
- `iainreiddotdev/assets/js/site.js`
- `docs/atlas.css`
- `scripts/build_story_sites.py`
- `scripts/test_story_browser.cjs`

## Confirmed defects and required repairs

### 1. Give each primary link a distinct, obvious destination

The current product navigation points:

- Overview to `?view=overview#workbench`
- Story to `?view=sources#workbench`
- Decisions to `?view=evidence#workbench`
- Workshop to `?view=workshop#workbench`
- Progress to `#story-progress`
- Files to `#archive`

The query changes, but the first four links all land on the same `#workbench` anchor and initially expose the same repeated introduction and tabs. To a visitor, they look broken.

Implement a coherent routing model in which every primary item has a distinct visible landing, heading, and selected state. Either render named view sections such as `#overview-view`, `#story-view`, `#decisions-view`, and `#workshop-view`, or implement an equivalently clear panel model. On navigation, the requested content must be visible without requiring the visitor to infer that something changed below the fold.

Add `aria-current="page"` to the active primary item. Parse or provide `$view` early enough for the header to render that state. Do not solve this with labels alone while retaining indistinguishable destinations.

### 2. Add an accessible Project Explorer mobile menu

There is currently no product-nav toggle markup, CSS, or JavaScript. The shared `site.js` only controls the story-site `.site-nav__list`; it does not control `.product-nav`.

At the mobile breakpoint, add a clearly labelled hamburger/menu button that:

- exposes expanded state with `aria-expanded` and an associated menu id;
- opens and closes reliably by pointer and keyboard;
- closes on Escape and after a menu link is activated;
- returns focus sensibly;
- does not trap or hide the theme control;
- presents Story and Development destinations in understandable groups if both are shown;
- works without horizontal overflow at 320px.

Keep desktop navigation fully visible. Do not apply a hidden-by-default class to the desktop menu.

### 3. Fix sticky-header and anchor obstruction

At `max-width: 64rem`, `.site-header__inner` becomes a single column containing the brand, all six links, Portfolio, and the theme toggle inside the sticky header. Its actual height can greatly exceed the current `scroll-margin-top` values of roughly 4.5–5rem.

After introducing the mobile menu, ensure the collapsed header is compact and every in-page or view destination lands below it. Verify this at every required width rather than hard-coding an offset that only fits one breakpoint.

### 4. Remove or clarify duplicate navigation

The product header and workbench tabs both repeat Overview, Story, Decisions, and Workshop. Establish a clear hierarchy. Prefer one primary navigation control, with tabs only where they represent a meaningful secondary scope. Do not leave two adjacent controls that appear to do the same job.

### 5. Make the repository browser usable on mobile

The archive tree currently precedes the document and can force a visitor to scroll through the entire repository before reaching the selected file. Its tree controls also use `min-height: 2.2rem`, below the required 44px touch target.

On narrow screens, make Files a deliberate drawer, disclosure, or equivalent browse mode with:

- a clear “Browse files” trigger;
- a clear close/back action;
- the current document visible without traversing the whole tree;
- at least 44px interactive targets;
- usable deep nesting and no horizontal page overflow;
- visible current-file state.

Desktop may retain a persistent two-pane archive if it remains clear.

### 6. Stop importing incompatible Workshop styling

Project Explorer loads `../../docs/atlas.css`, but not the story site's complete token set. `workbench.css` defines some shared names while `atlas.css` references additional variables including `--line-strong`, `--cyan-wash`, `--night-3`, and `--mono`. This can produce missing borders, backgrounds, and typography fallbacks; it also imports story-page rules into a product shell unintentionally.

Create Project-Explorer-specific Workshop component styles/tokens, or extract a deliberately scoped shared component layer. Do not wholesale-import the story atlas stylesheet into Project Explorer. Check all CSS custom properties used by the repaired surface and ensure every one resolves.

### 7. Correct asset versioning

Project Explorer uses `$assetVersion = '20260909-2'` for some assets but hard-codes `?v=20260909` for `docs/atlas.css` and `docs/workshop.js`. Route all repaired Project Explorer assets through a deliberate version value so production does not retain stale CSS or JavaScript after deployment.

### 8. Preserve navigation, file, and search state intentionally

`explorer_file_url()` currently creates a `?file=...#archive` URL and discards `view`. The search form submits only `q`, which can reset the requested document to the README. Define the desired state model and preserve relevant `view`, `file`, and `q` state across file links, search, and back/close actions. Files may be treated as its own route state if that produces a simpler, more predictable model.

### 9. Restore missing public navigation paths

The story-site navigation generated by `scripts/build_story_sites.py` exposes Story, World, Luminai, Characters, Conspiracy, Timeline, Ideas, Progress, and Workshop. Research is absent from primary/secondary navigation even though the previous handoff required a clear route to it; Visuals and Archive likewise lack a selected navigation state.

Keep this portion minimal: add a clear, grouped path to Research and make the selected state truthful on Research, Visuals, and Archive pages. Do not redesign the story site during this repair.

### 10. Check request-time archive cost

`explorer_markdown_files()` recursively scans the repository on every request, and a non-empty search reads every Markdown file. Measure or inspect the likely shared-hosting impact. If a small request-lifetime cache or safe index materially helps, implement it without weakening path validation or causing stale content. If no change is justified, document the finding rather than expanding scope.

## Preserve

- Approved public wording and the literal explanation of the project.
- All story canon and unresolved author gates.
- The distinction between the public story atlas and the authoring-system Project Explorer.
- Secure path containment and Markdown rendering behavior.
- Theme switching, Workshop persistence, import/export, and generated site projections.
- Existing user work unrelated to this repair.

This is a repair pass. Do not introduce a new aesthetic direction, replace copy, generate new canon, or refactor unrelated systems.

## Verification required

Extend `scripts/test_story_browser.cjs` or add focused browser coverage. The existing script checks Story-site menu behavior but only captures Project Explorer screenshots and overflow; it does not prove the reported defects are fixed.

Test at exactly these viewport widths:

- 320px
- 375px
- 430px
- 768px
- 1024px
- 1440px

At every applicable width, verify:

- no horizontal page overflow;
- primary navigation is available and understandable;
- mobile menu open, close, Escape, focus, link-close, and current-item behavior;
- Overview, Story, Decisions, and Workshop land on visibly distinct content;
- sticky headers do not obscure targets;
- Files browse mode, current document, back/close, and deep nesting;
- minimum 44px mobile touch targets;
- search and document-link state behavior;
- theme switching;
- Workshop load, local persistence, import, and export;
- selected states for Research, Visuals, and Archive on the story site.

Also run:

- `python3 scripts/build_story_sites.py`
- `python3 scripts/check_story_sites.py`
- `node --check` on changed JavaScript files
- PHP lint on every changed PHP file
- `git diff --check`
- `git status --short`

Perform an actual visual inspection at all six widths. A screenshot capture alone is not a pass. If PHP, Playwright, a browser, or any other required tool is unavailable, state that exactly and do not claim its checks passed.

## Acceptance criteria

- Every top-level link has a unique, legible purpose and truthful active state.
- Project Explorer has a keyboard-accessible mobile hamburger menu.
- The compact mobile header never obscures the destination.
- The archive is a deliberate mobile experience, not the entire tree stacked above the document.
- Mobile controls meet a 44px minimum target.
- Workshop presentation has no unresolved or cross-site CSS-token dependency.
- Production asset URLs can reliably invalidate stale copies.
- All six viewports have been tested with results recorded.
- Site generation and source validation still pass.
- No story wording or canon changes are introduced.

## Required completion report

Return all of the following before marking the handoff complete:

1. concise summary of the repaired behavior;
2. exact files changed;
3. routing/state model chosen and why;
4. mobile navigation keyboard and focus behavior;
5. archive mobile behavior;
6. automated checks and exact results;
7. a viewport-by-viewport visual inspection table;
8. PHP lint results or explicit reason it could not run;
9. anything not tested;
10. remaining limitations and current `git status`.

Do not publish or deploy from this handoff. Leave the repair ready for author review under the repository's existing branch/commit workflow.

## Completion report — 2026-09-08

### 1. Concise summary of the repaired behavior

Project Explorer primary links now route to distinct destinations with unique headings and truthful `aria-current` states. A compact accessible hamburger menu controls product navigation below 1024px. Duplicate workbench tabs were removed. Files uses a mobile browse drawer so the current document is visible first. Workshop no longer imports `docs/atlas.css`; tokens and session styles live in Project Explorer CSS. Asset URLs share one version string. Story-site Research is in Development nav; Visuals and Archive are in a Records group with selected states. Browser tests now assert behavior at all six required widths.

### 2. Exact files changed

- `iainreiddotdev/project-explorer/index.php`
- `iainreiddotdev/project-explorer/workbench.php`
- `iainreiddotdev/project-explorer/assets/project-explorer.css`
- `iainreiddotdev/project-explorer/assets/workbench.css`
- `iainreiddotdev/project-explorer/assets/project-explorer.js` (new)
- `iainreiddotdev/includes/repository-explorer.php`
- `scripts/build_story_sites.py`
- `scripts/test_story_browser.cjs`
- `docs/atlas.css`
- Generated/hand-maintained story pages updated for nav/version: `docs/index.html`, `docs/ai.html`, `docs/archive.html`, `docs/characters.html`, `docs/colonization.html`, `docs/faction.html`, `docs/ideas.html`, `docs/research.html`, `docs/timeline.html`, `docs/todo.html`, `docs/visuals.html`, `docs/workshop.html`, `docs/assets/story-build.json`
- Coordination/status: this handoff, `07 Coordination/DESKTOP-QUEUE.md`, `03 Context/CURRENT.md`

### 3. Routing/state model chosen and why

`view` is the primary route: `overview`, `sources` (Story), `evidence` (Decisions), `workshop`, `progress`, `files`. Each maps to a unique fragment (`#overview-view`, `#story-view`, `#decisions-view`, `#workshop-view`, `#story-progress`, `#archive`) and a distinct visible heading. File browsing is its own view: `explorer_file_url()` always emits `view=files&file=...#archive`. Search keeps `view=files` and the current `file` via hidden fields; clearing search drops `q` while keeping the document. Workshop may also carry `module`. This makes destinations obvious, preserves intentional state, and removes the old shared `#workbench` landing.

### 4. Mobile navigation keyboard and focus behavior

Below 1024px, `[data-product-nav-button]` toggles `#product-nav` with `aria-expanded` / `aria-controls`. Opening moves focus to the first menu link. Escape closes and returns focus to the button. Activating a menu link closes the menu. Theme toggle stays visible outside the menu. Desktop keeps the full product nav visible; the toggle is hidden.

### 5. Archive mobile behavior

On narrow screens the tree is hidden by default. **Browse files** opens the sidebar drawer; **Close file browser** / **View the current document** return to the document. Selecting a tree or search result closes the drawer. Desktop keeps the persistent two-pane archive. Tree/file targets use a 44px minimum.

### 6. Automated checks and exact results

- `python3 scripts/build_story_sites.py` — Built 8 atlas pages, 20 modules, 37 projections.
- `python3 scripts/check_story_sites.py` — `PASS: local HTML links/assets/anchors; generated hashes; 20 complete source-linked modules; curated canon checks.`
- `node --check` on changed JS — passed for `project-explorer.js`, `test_story_browser.cjs`, and related scripts.
- PHP lint — passed for `index.php`, `workbench.php`, `repository-explorer.php`.
- `git diff --check` — clean.
- `node scripts/test_story_browser.cjs` — `PASS: 198 responsive checks across 320/375/430/768/1024/1440px; distinct PE destinations; hamburger; archive browse; Research/Visuals/Archive selected states; workshop persistence; search state; no JS errors.`
- Archive scan cost: 566 Markdown files; first scan ~4.1ms in this environment; request-lifetime cache returns in ~0.002ms. Path validation unchanged.

### 7. Viewport-by-viewport visual inspection table

| Width | Primary nav | Distinct destinations | Sticky clearance | Files browse | Overflow | Notes |
| --- | --- | --- | --- | --- | --- | --- |
| 320 | Hamburger; theme visible; Portfolio compacted away | Overview/Story/Decisions/Workshop headings differ; active state truthful | Story/Files destinations clear sticky header after settle scroll | Document first; Browse files drawer; close/back works | None | Brand name hidden at narrowest width |
| 375 | Same | Same | Same | Same | None | Brand truncated, menu+theme fit |
| 430 | Same | Same | Same | Same | None | Same compact header pattern |
| 768 | Hamburger still used | Same | Same | Drawer mode | None | Touch targets ≥44px |
| 1024 | Full product nav; no hamburger | Same | Same | Persistent sidebar | None | Desktop breakpoint begins here |
| 1440 | Full product nav | Same; Story grid and Workshop session readable | Same | Persistent sidebar + context | None | Research/Visuals/Archive selected states verified on story site |

### 8. PHP lint results

PHP 8.3.6 CLI was installed in the environment for this pass.

- `php -l iainreiddotdev/project-explorer/index.php` — No syntax errors detected
- `php -l iainreiddotdev/project-explorer/workbench.php` — No syntax errors detected
- `php -l iainreiddotdev/includes/repository-explorer.php` — No syntax errors detected

### 9. Anything not tested

- Production/shared-hosting deployment and live CDN cache invalidation after publish
- Real-device VoiceOver/TalkBack pass (keyboard/focus behavior was automated in Chromium)
- Author review of the larger visual redesign assessment (intentionally out of scope)

### 10. Remaining limitations and current git status

- Portfolio is hidden in the compact PE header below 1024px to prevent overflow; theme remains available. Portfolio stays reachable from the footer and desktop header.
- Destination scrolling uses a short settle pass after load because the hero image can change page height; without JS, native hash scrolling still depends on `scroll-padding`/`scroll-margin`.
- Request-lifetime Markdown inventory cache helps repeated calls in one request only; it does not add a durable disk index.
- Not merged to `main` and not deployed.

Implemented on branch `cursor/project-explorer-nav-repair-e541` (tip `2512c1e`; repair implementation `387d8a8`). Working tree after this report includes only the repair and status updates above.
