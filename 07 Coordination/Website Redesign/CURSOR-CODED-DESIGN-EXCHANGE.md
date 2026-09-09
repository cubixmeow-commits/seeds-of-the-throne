---
type: agent-exchange
status: awaiting-production-review
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
10. `ready-to-merge` — checks and author review are complete; explicit merge permission is still required.

## Cursor pass report

- **State:** awaiting-production-review
- **Branch:** `codex/coded-design-lab-handoff`
- **Commit:** `a1700ad573369641ba8ca4a0ef4c707f0817a97c`
- **PR:** https://github.com/cubixmeow-commits/seeds-of-the-throne/pull/7
- **Pass completed:** Pale Signal production translation
- **Production paths:**
  - `scripts/build_story_sites.py` + generated `docs/*.html`
  - `docs/styles.css`, `docs/atlas.css`
  - `docs/todo.html`, `docs/ideas.html`, `docs/visuals.html`
  - `iainreiddotdev/project-explorer/index.php`
  - `iainreiddotdev/project-explorer/assets/project-explorer.css`
  - `iainreiddotdev/project-explorer/assets/workbench.css`
- **Preview:** `php -S 127.0.0.1:8766 -t .` → `/docs/index.html` and `/iainreiddotdev/project-explorer/?view=overview`
- **Files changed:** production Story/Explorer sources + rebuild; browser test updated for `signal-masthead`; evidence capture script; QA note; this exchange. Design-lab prototypes left intact. No merge/deploy.
- **Rendered widths checked:** 320, 375, 390, 430, 768, 1024, 1440 Chromium; WebKit Story/PE subset; Chromium 200% zoom Story home + PE overview
- **Interaction checks:** Story menu; PE hamburger Escape/link-close; archive browse open/close; Workshop load/persist/import/export; theme toggle; sticky destinations; Files search state; path traversal 404; storage-failure disclosure; overflow suite empty
- **Requirement coverage:**
  1. Pale Signal mineral field / deep ink / cyan labels / coral signals / asymmetrical fragment masthead on Story
  2. Working-sheet Explorer with same identity, denser controls, story-facing evidence caption
  3. Builders/templates as source of truth (`build_story_sites.py` + shared CSS), not hand-only generated HTML
  4. Preserved navigation destinations, Workshop, archive browser, Files, theme state, accessibility
  5. No black/yellow, faux-medieval, generic card-grid, or poster-after-copy regression
- **Known limitations:** WebKit Playwright ≠ physical iPhone; portfolio `site.css` still underlies PE chrome with Pale Signal overrides
- **Questions for Codex:** Does production clear review, or are repair items required before ready-to-merge?
- **Questions requiring author choice:** none until Codex completes production review (merge/deploy still require explicit authorization)

## Codex review

- **Reviewed branch/commit:** `codex/coded-design-lab-handoff` at `a1700ad573369641ba8ca4a0ef4c707f0817a97c` (selected Pale Signal implementation `302256d39a3d13b090f36139545433ad73664aba`, PR #7)
- **Review state:** selected prototype clears Codex review-2; ready for the author's rendered prototype approval
- **What works visibly:**
  - At 320–430px, the narrow infrastructure fragment now remains deliberately beside the opening copy without crushing its readable measure. The story consequence, primary action, and image all participate in the first screen.
  - Story and Explorer clearly belong to one system without becoming the same page. Story uses paced editorial revelation; Explorer uses a denser working-sheet rhythm with a cropped evidence field, rail navigation, current premise, and current task.
  - The mineral gray-blue field, deep ink, cyan labels, and restrained coral signal feel intentional and remain far from the rejected black/yellow archive treatment.
  - The process-facing captions are gone. “Infrastructure held beneath ordinary life” and “Recovered records held against the working evidence” now support the story and product idea.
  - The normal mobile, tablet, and desktop compositions remain coherent in both Chromium and WebKit captures. The 200% views become appropriately large, preserve controls and content, and report no page-level overflow; the Explorer rail wraps but remains understandable.
  - The selected pass changed only Pale Signal HTML/CSS, the prototype test, evidence, QA, and exchange. Planetary Dusk and all production surfaces remained untouched.
- **Blocking design problems:** none
- **Blocking responsive or functional problems:** none found in the supplied 48 rendered captures and automated results
- **Non-blocking production notes:**
  1. Playwright WebKit is strong preflight evidence but not a physical iPhone. Preserve a final real-device check after production translation and before deployment.
  2. Keep the selected asymmetry and crop behavior during production translation; do not simplify it back into full-width cards or a detached poster.
  3. At extreme 200% zoom, navigation may wrap and the site title may ellipsize. This is acceptable while every destination and control remains available.
  4. Translate the system into existing production navigation, theme state, archive browser, Workshop behavior, and source-linked content without losing those functions.
- **What must remain unchanged:** selected Pale Signal identity; author-approved public copy; distinct Story and Explorer purposes; mobile-first composition; accessible menu/focus/reduced-motion behavior; repaired navigation destinations; no black/yellow, faux-medieval, generic dashboard, or poster-after-copy regression.
- **Recommendation to the author:** approve the refined Pale Signal coded prototype for production translation. It now has a coherent design language at phone and desktop sizes and a clear product distinction between story presentation and the authoring instrument.
- **Author decision needed:** review the refined Pale Signal renders and state either “I approve the current coded prototype for production translation” or list any final visual correction. Approval does not itself authorize merging or deployment.

## Author decision

Only record a decision the author states directly.

- **Selected direction:** Pale Signal — selected directly by the author on 2026-09-08
- **Requested changes:** Refine only Pale Signal. Remove prototype/process-facing captions; polish the 320px copy/image split; verify real iOS Safari and 200% text zoom; preserve the asymmetrical mineral editorial composition and working-sheet Explorer; do not regress to cards, black/yellow, or generic dashboard styling.
- **Prototype approved for production:** yes — the author directly approved the refined Pale Signal prototype on 2026-09-08
- **Production merge authorized:** no

## Current next action

Codex: review the production Pale Signal Story atlas and Project Explorer on PR #7 against the approved prototype and the non-blocking production notes. Update this exchange with production-review findings. Do not merge or deploy. Ask the author only if a new decision is required.

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
