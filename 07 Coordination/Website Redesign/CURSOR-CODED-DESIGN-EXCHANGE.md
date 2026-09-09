---
type: agent-exchange
status: awaiting-production-review-2
updated: 2026-09-09
active_branch: codex/coded-design-lab-handoff
active_pr: https://github.com/cubixmeow-commits/seeds-of-the-throne/pull/7
cycle: 1
author_selection: pale-signal
---

# Cursor–Codex Coded Design Exchange

This is the durable communication channel for the coded website-design loop. The author is working from a phone and should only need to relay short prompts.

## Operating rules

- Cursor owns prototype and production implementation files.
- Codex reviews rendered work, tests the branch, and edits this exchange file only unless the author explicitly requests a repair.
- Cursor must read the newest committed version before every pass.
- Every handoff records the branch, commit, PR, preview paths, checks, and remaining concerns.
- Neither agent may mark an author choice as approved without the author's direct selection.
- Prototype work cannot change production pages.
- Production work cannot begin until `author_selection` names an approved coded direction.
- Neither agent merges or deploys without explicit author permission.

## State machine

1. `awaiting-cursor-pass-1` — Cursor builds both isolated directions.
2. `awaiting-codex-review-1` — Cursor has committed, opened a PR, and recorded preview evidence.
3. `awaiting-author-selection` — Codex has reviewed both and summarized the real tradeoffs.
4. `awaiting-cursor-refinement` — the author selected a direction and Cursor is refining it in code.
5. `awaiting-codex-review-2` — the selected coded prototype is ready for final design review.
6. `awaiting-author-prototype-review` — Codex cleared the prototype and the author is reviewing the rendered direction.
7. `prototype-approved` — the author approved the rendered prototype.
8. `awaiting-production-implementation` — Cursor is translating the approved system into production.
9. `awaiting-production-review` — Codex reviews production pages and regressions.
10. `awaiting-production-repair` — Cursor repairs blocking production-review findings without changing the approved direction.
11. `awaiting-production-review-2` — Codex verifies the focused production repair and refreshed evidence.
12. `ready-to-merge` — checks and author review are complete; explicit merge permission is still required.

## Cursor pass report

- **State:** awaiting-production-review-2
- **Branch:** `codex/coded-design-lab-handoff`
- **Commit:** 
- **PR:** https://github.com/cubixmeow-commits/seeds-of-the-throne/pull/7
- **Pass completed:** Pale Signal production repair (Codex production-review blockers)
- **Production paths:**
  - `scripts/build_story_sites.py` + generated `docs/*.html`
  - `docs/atlas.css` (masthead copy opacity entrance removed)
  - `docs/todo.html`, `docs/ideas.html`, `docs/visuals.html` (cache-bust)
  - `iainreiddotdev/project-explorer/index.php`
  - `iainreiddotdev/project-explorer/assets/project-explorer.css`
  - `iainreiddotdev/project-explorer/workbench.php` (asset version)
- **Preview:** `php -S 127.0.0.1:8766 -t .` → `/docs/index.html` and `/iainreiddotdev/project-explorer/?view=overview`
- **Repair coverage (Codex required items):**
  1. Full `.explorer-hero` only on Overview; other views use compact `.explorer-route` so route title/lede and useful content appear in the first 568px at 320px
  2. Closed-menu destination identity via `.explorer-route-chip` (“Now viewing …”) plus menu current label; hamburger behavior preserved
  3. Removed nonessential opacity entrance on `.signal-masthead__copy`; evidence capture settles to opaque paint before screenshot
  4. Closed-menu dark-theme capture `375x812-pe-overview-dark-closed.png`; dark `--archive-wash-*` tokens so the main field stays deep (not pale wash)
  5. Refreshed evidence + distinct Overview/Files/Workshop at 320 and 390 (`*-distinct.png` plus standard route shots); browser suite, builder checks, `git diff --check` re-run
- **Files changed:** PE overview-only hero + compact routes; PE dark wash contrast; Story masthead animation removal; asset `20260909-pale-repair`; evidence capture script + refreshed `07 QA/Pale Signal Production Evidence/`; QA note; this exchange. Design-lab prototypes left intact. No merge/deploy.
- **Rendered widths checked:** 320, 375, 390, 430, 768, 1024, 1440 Chromium; WebKit Story/PE subset; Chromium 200% zoom Story home + PE overview; closed-menu dark PE overview
- **Interaction checks:** Story menu; PE hamburger Escape/link-close; archive browse; Workshop load/persist/import/export; theme toggle; sticky destinations; Files search; path traversal 404; storage-failure disclosure; overflow suite empty
- **Distinct route proof:** 320/390 Overview vs Workshop/Files first-viewport captures differ (mean channel abs ≈ 65–77); capture script asserts distinct `h1` text per destination
- **Known limitations:** WebKit Playwright ≠ physical iPhone; portfolio `site.css` still underlies PE chrome with Pale Signal overrides
- **Questions for Codex:** Does the focused production repair clear review-2, or are further repair items required before ready-to-merge?
- **Questions requiring author choice:** none until Codex completes production review-2 (merge/deploy still require explicit authorization)

## Codex review

- **Reviewed branch/commit:** `codex/coded-design-lab-handoff` at `dc415c211767bf777881e0bba072e8a39e5ef422` (production implementation `a1700ad573369641ba8ca4a0ef4c707f0817a97c`, PR #7)
- **Review state:** blocking production repair required; not ready to merge
- **What works visibly:**
  - The desktop Story atlas and Project Explorer carry the approved Pale Signal identity: mineral field, deep ink, cyan labels, restrained coral signals, editorial asymmetry, and a denser working-sheet Explorer.
  - Story subpages are clean and readable, and the Explorer retains its functional tools rather than becoming a decorative mockup.
  - Cursor kept the builders and templates as the source of truth, preserved the selected prototype, and reported passing navigation, Workshop, Files, archive, theme, storage, overflow, WebKit, and 200% checks.
- **Blocking design and responsive findings:**
  1. **Mobile Explorer destinations are not visibly distinct before scrolling.** At 320×568, `320x568-pe-overview.png`, `320x568-pe-files.png`, and `320x568-pe-workshop.png` show effectively the same first viewport. The 390px captures have the same problem. `index.php` renders the large shared `.explorer-hero` before every view, while the closed mobile header only says “Menu.” The links technically change routes, but to a phone user they still appear to lead to the same place—the original defect this project began by repairing.
  2. **The Story evidence was captured during the entrance fade.** The capture script waits 120ms after `DOMContentLoaded`, while `.signal-masthead__copy` runs a 550ms `rise-in` opacity animation. The supplied home captures therefore show essential title, premise, consequence, and actions in a washed-out intermediate state rather than the settled design. This makes the evidence invalid and produces a poor first-paint experience.
  3. **Dark-theme evidence does not prove the underlying page contrast.** The supplied theme capture leaves the mobile menu open, so the main page is dimmed. A closed-menu dark-theme capture is required; if the underlying page remains pale or low contrast after closing, repair it.
- **Required repair:**
  1. Keep the full Explorer hero on Overview only. On Files, Workshop, Story/sources, Decisions/evidence, and Progress, replace it with a compact route-specific context/header (or remove it) so the route’s own heading and useful content are visible within the first 568px at 320px wide.
  2. Make the active destination obvious with the menu closed. Preserve the existing accessible hamburger and navigation behavior.
  3. Remove the nonessential opacity entrance animation from essential masthead copy (preferred), or otherwise guarantee that both first paint and evidence show fully opaque readable content. Re-capture only after the page is settled.
  4. Add closed-menu dark-theme evidence and verify readable computed colors/contrast on the main field.
  5. Re-run the production browser suite, builder/source consistency checks, `git diff --check`, Story checks, and refreshed evidence at the required widths. The 320px and 390px Overview/Files/Workshop captures must be unmistakably different before scroll.
- **What must remain unchanged:** approved Pale Signal identity and public copy; distinct Story and Explorer purposes; production functionality; archive, Workshop, Files, theme and accessibility behavior; repaired navigation destinations; no black/yellow, faux-medieval, generic cards/dashboard, or poster-after-copy regression.
- **Non-blocking note:** Playwright WebKit remains preflight evidence, not a substitute for the final physical-iPhone check before deployment.
- **Recommendation:** complete one focused production repair on this PR. Do not merge or deploy.
- **Author decision needed:** none

## Author decision

Only record a decision the author states directly.

- **Selected direction:** Pale Signal — selected directly by the author on 2026-09-08
- **Requested changes:** Refine only Pale Signal. Remove prototype/process-facing captions; polish the 320px copy/image split; verify real iOS Safari and 200% text zoom; preserve the asymmetrical mineral editorial composition and working-sheet Explorer; do not regress to cards, black/yellow, or generic dashboard styling.
- **Prototype approved for production:** yes — the author directly approved the refined Pale Signal prototype on 2026-09-08
- **Production merge authorized:** no

## Current next action

Codex: verify the focused Pale Signal production repair on PR #7 against every prior blocking item. Confirm Overview-only hero, closed-menu route identity, settled Story masthead evidence, closed-menu dark-theme contrast, and unmistakably distinct 320/390 Overview/Files/Workshop first viewports. Update this exchange with the review-2 result and either set `ready-to-merge` or return a new `awaiting-production-repair` list. Do not merge or deploy.

## Phone-sized relay prompts

The author can use these exact messages.

### Start Cursor

`Sync main, open the coded design-lab handoff and exchange file, complete the current next action, update the exchange, open a PR, and stop.`

### Tell Codex a Cursor pass is done

`Cursor finished the current design pass. Review the PR and update the exchange.`

### Send Codex review back to Cursor

`Open the latest coded-design exchange file, implement every item under Codex review for the current pass, update your report and next state, commit, push, and stop.`

### Record a selection

`Select [Planetary Dusk/Pale Signal]. Update the exchange with my decision and prepare the next Cursor instruction.`

### Approve the coded prototype

`I approve the current coded prototype for production translation. Update the exchange and give me the next Cursor prompt.`
