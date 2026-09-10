---
type: cursor-implementation-handoff
status: completed
updated: 2026-09-10
source: "[[07 QA/2026-09-10 - Vault Functionality Assessment]]"
scope: Project Explorer Vault Overview and navigation only
---

# Cursor Handoff — Build the Vault Overview

## Read first

1. `AGENTS.md`
2. `START HERE.md`
3. `03 Context/CURRENT.md`
4. `03 Context/RULES.md`
5. `07 QA/2026-09-10 - Vault Functionality Assessment.md`
6. `skills/design-seeds-site/SKILL.md`
7. `skills/design-seeds-site/references/visual-identity-boundaries.md`
8. `skills/design-seeds-site/references/visual-qa.md`
9. `iainreiddotdev/project-explorer/index.php`
10. `iainreiddotdev/project-explorer/workbench.php`
11. `iainreiddotdev/project-explorer/assets/project-explorer.css`
12. `iainreiddotdev/project-explorer/assets/workbench.css`

## Outcome

Create a plain-language Vault Overview inside the existing Project Explorer.

A person who knows nothing about the repository should understand, within one screen:

- what the vault is;
- what it remembers;
- how an idea moves through it;
- what already works;
- what still needs to be built;
- where to look next.

The overview must represent the **vault's functionality**, not summarize the story.

## Core message

Use this meaning in simpler page copy:

> The vault turns conversations into organized story memory. It preserves sources, separates decisions from suggestions, finds missing connections, supports research and workshops, prepares scenes and prose, checks continuity, and publishes selected material without surrendering author control.

Do not lead with repository language, engine names, schemas, IDs, graphs, or implementation terms.

## Page structure

### 1. Immediate introduction

Heading direction:

> See the whole story-development system at a glance.

Short explanation:

> Hundreds of notes work together as one system. The vault remembers where ideas came from, what the author decided, what remains uncertain, and what should happen next.

Add one compact status line:

- working now;
- needs repair;
- planned next.

### 2. The simple flow

Show six understandable stages:

1. **Capture** — conversations, mobile notes, and raw ideas are preserved.
2. **Understand** — current context and compiled notes explain what the project means now.
3. **Decide** — workshops ask one important question and preserve the author's answer.
4. **Develop** — research, alternatives, story structure, and focused tests strengthen the work.
5. **Create** — scene plans, prose, images, and manuscript material are produced for review.
6. **Share** — selected material becomes the story site, Project Explorer, and public posts.

This should be the main visual relationship. It may be cards, a vertical path, or a compact responsive flow. On mobile, it must read naturally without horizontal scrolling.

### 3. What lives where

Translate the numbered folders into human jobs:

| Plain label | Vault area | What it does |
|---|---|---|
| New material | `00 Inbox`, `01 Sessions` | preserves incoming ideas and development history |
| Story memory | `02 Story`, `03 Context` | maintains detailed knowledge and a smaller resume briefing |
| Research | `04 Research` | separates questions, reports, and usable findings |
| Public work | `05 Public` | holds reviewed material prepared for readers |
| Drafts | `06 Draft` | holds scenes and manuscript candidates |
| Decisions and direction | `07 QA`, `07 Coordination` | records choices, contradictions, current work, handoffs, and verification |
| Development tools | `08 Story Loop`, `09 Story Exploration` | diagnoses gaps and tests possibilities |
| Reusable methods | `skills`, `scripts` | provides repeatable writing, research, image, website, and validation methods |

Show the plain label first. Paths are secondary detail.

### 4. Honest capability status

Use three groups.

#### Working well

- idea and session capture;
- human-readable story memory;
- author authority and decision boundaries;
- research separation;
- workshop design;
- decisions, contradictions, and open questions;
- visual identity and image controls;
- Markdown ownership and Git history;
- searchable file access.

#### Needs repair or consolidation

- one trustworthy current-state view;
- current workshop/site build agreement;
- automatic pre-merge checks;
- normalized statuses and stable record IDs;
- decision propagation and stale-file detection;
- weekly cycle freshness;
- legacy folder boundaries;
- clean deployment separation.

#### Planned next

- durable conversational answer integration;
- automatic dependency and blast-radius reports;
- complete scene-to-manuscript production;
- manuscript assembly and export;
- reliable mobile save, resume, and synchronization.

Do not present planned functions as if they already work.

### 5. The next build order

Show a short sequence:

1. Make builds and checks reliable.
2. Create one trustworthy current state.
3. Normalize the Markdown records for one small vertical slice.
4. Connect accepted decisions to every affected file.
5. Prove one complete path from conversation to approved manuscript material.
6. Expand only after that path works.

### 6. Direct links

Provide plain-language links to:

- `07 QA/2026-09-10 - Vault Functionality Assessment.md` — full assessment;
- `START HERE.md` — how the vault works;
- `07 Coordination/CURRENT-PICKUP.md` — current resume point;
- `07 QA/Decisions.md` — accepted decisions;
- `07 QA/Contradictions.md` — unresolved conflicts;
- `07 Coordination/Story Completion Workflow/Reassessment Workshop/README.md` — current workshop;
- `08 Story Loop/README.md` — development tools;
- `07 Coordination/Authoring System/README.md` — planned complete authorship system;
- the existing Files view — full archive.

Use Project Explorer file URLs rather than raw filesystem paths in the rendered interface.

## Make the link impossible to miss

Add **Explore the vault** as a prominent action in the Project Explorer's opening area, beside the existing primary actions.

Also add **Vault** to the Project Explorer navigation.

Navigation must preserve the unified homepage behavior repaired in PR #9:

- do not remove the hero, progress, archive, or other major homepage sections when Vault is selected;
- do not turn the Project Explorer into disconnected pages;
- the Vault link may scroll to `#vault-overview` on the homepage;
- from any query-based Explorer state, it must return to the same unified homepage and land on `#vault-overview`;
- mobile menu open/close behavior must continue to target `[data-product-nav-icon]` explicitly.

Recommended destination:

`?view=overview#vault-overview`

The overview section itself should have:

`id="vault-overview"`

## Implementation boundaries

- Extend the approved Pale Signal design. Do not redesign the site.
- Keep the current Project Explorer as one continuous page.
- Mobile is the primary layout.
- Use semantic HTML and existing design tokens.
- Do not introduce a framework, database, or author-maintained JSON sidecar.
- Do not expose private material or story spoilers beyond the Explorer's existing public boundary.
- Do not claim that mobile workshop drafts write to the vault.
- Do not claim that decision propagation, manuscript assembly, or synchronization is implemented.
- Keep technical detail behind optional disclosure or source links.
- Prefer a new focused include such as `vault-overview.php` over making `workbench.php` substantially harder to maintain.
- Dynamic document counts may come from the existing Markdown inventory; do not hard-code the audit's 603-document count as permanent copy.

## Reliability work required before visual review

The overview must not be built on top of knowingly broken projection checks.

1. Update `scripts/check_story_sites.py` to validate the current ten-module reassessment format instead of the retired twenty-module format.
2. Make the validator and builder share one workshop contract or derive expectations from the active source.
3. Rebuild generated site outputs with `scripts/build_story_sites.py`.
4. Confirm `scripts/check_story_sites.py` passes.
5. Run PHP syntax checks on every `.php` file.
6. Run JavaScript syntax checks on the affected scripts.
7. Run `git diff --check`.

Do not hand-edit generated pages or JSON.

## Visual requirements

- A new visitor should understand the first screen without opening a file.
- Avoid giant headings and oversized empty spacing.
- Avoid dense dashboards, tiny metadata, and developer-console aesthetics.
- The six-stage flow must remain clear at 320, 375, 390, 430, 768, 1024, and 1440 pixel widths.
- No horizontal page overflow at 100% or 200% text scaling.
- Status must not depend on color alone.
- Navigation must remain keyboard accessible and usable with JavaScript disabled wherever a normal link can provide the fallback.
- The page should feel like a simple map of a powerful system, not documentation for operating one.

## Acceptance tests

- Project Explorer loads without PHP warnings or parse errors.
- **Explore the vault** is visible near the top of the homepage.
- **Vault** is present in desktop and mobile navigation.
- Both links land on `#vault-overview`.
- Selecting Vault does not hide the rest of the unified homepage.
- The mobile navigation button opens, closes, updates its label/icon, and closes on Escape and link selection.
- The overview explains Capture → Understand → Decide → Develop → Create → Share.
- Working, repair-needed, and planned capabilities are visibly distinct.
- All direct links resolve through the Project Explorer.
- The full assessment is one click away.
- Generated outputs are rebuilt rather than hand-edited.
- Site validation, PHP syntax, JavaScript syntax, and `git diff --check` pass.
- No `error_log`, test output, screenshots, local-storage drafts, or temporary files are committed.

## Cursor completion report

When finished, update this file with:

- files changed;
- exact validation commands and results;
- screenshots reviewed by viewport;
- any content or feature intentionally deferred;
- confirmation that no generated file was edited by hand;
- final commit SHA.

Stop and report rather than merging if PHP syntax cannot be checked or any required validation fails.

## Completion report — 2026-09-10

### Files changed

- `scripts/workshop_contract.py` (new shared reassessment-workshop contract)
- `scripts/check_story_sites.py`
- `scripts/build_story_sites.py`
- `scripts/README.md`
- `scripts/test_story_browser.cjs`
- `iainreiddotdev/project-explorer/vault-overview.php` (new)
- `iainreiddotdev/project-explorer/index.php`
- `iainreiddotdev/project-explorer/assets/project-explorer.css`
- `iainreiddotdev/project-explorer/assets/project-explorer.js`
- `iainreiddotdev/includes/repository-explorer.php`
- Generated projections rebuilt by `scripts/build_story_sites.py` (`docs/*.html`, `docs/assets/story-*.json`)
- `07 Coordination/DESKTOP-QUEUE.md`
- this handoff

### Validation commands and results

- `python3 scripts/build_story_sites.py` — `Built 8 atlas pages, 10 modules, 27 projections.`
- `python3 scripts/check_story_sites.py` — `PASS: local HTML links/assets/anchors; generated hashes; 10 current source-linked reassessment modules; curated canon checks.`
- PHP syntax: `php -l` on every `.php` file in the repository — no syntax errors. PHP 8.5.8 CLI.
- `node --check iainreiddotdev/project-explorer/assets/project-explorer.js`
- `node --check docs/workshop.js`
- `node --check scripts/test_story_browser.cjs`
- `node --check iainreiddotdev/assets/js/site.js`
- All JavaScript syntax checks passed.
- `git diff --check` — clean.
- `curl` of `?view=overview` and `?view=workshop` with `display_errors=1` — HTTP 200, no PHP warnings, notices, or parse errors.
- `node scripts/test_story_browser.cjs` — `PASS: 243 responsive checks across 320/375/390/430/768/1024/1440px; distinct PE destinations; hamburger; archive browse; Research/Visuals/Archive selected states; workshop persistence; search state; no JS errors.`

### Screenshots reviewed by viewport

Screenshots were reviewed locally and were not committed.

| Width | Reviewed | Result |
| --- | --- | --- |
| 320×568 | Hero first screen | Compact image, menu, and theme control fit. **Explore the vault** is one short scroll below the title on this short viewport. |
| 320 | Vault overview, open menu | Six-stage flow stacks; status labels are readable without color; **Vault** is in the menu with a current-state bar; menu icon switches to ✕. |
| 375 | Hero CTAs | **Explore the vault** is the filled primary action beside the existing homepage actions. |
| 390 | Vault overview | Same stacked map; no horizontal overflow. |
| 430 | Vault overview | Same stacked map; sticky header clears the section heading. |
| 768 | Vault overview | Two-column flow; status cards remain stacked; no page overflow. |
| 1024 | Vault overview | Desktop nav includes **Vault**; three status cards and a 3×2 flow; hero, progress, and archive remain on the page. |
| 1440 | Hero and Vault overview | **Explore the vault** sits with the other opening actions; **Vault** is a normal nav item; landing on `#vault-overview` marks Vault current. |

### Intentionally deferred

- Continuous-integration / automatic pre-merge gates were not added.
- One generated current-state record, decision blast-radius reports, manuscript assembly/export, and durable mobile save/resume remain planned, not implemented.
- The overview does not claim that workshop drafts write to the vault.
- Story copy, Pale Signal identity, and unrelated Explorer destinations were left in place.

### Generated files

No generated HTML or JSON was edited by hand. All `docs/` projection updates came from `python3 scripts/build_story_sites.py`.

### Final commit SHA

`e1107ae8937086f9ab0b8f75a7e5d2349e256da5`
