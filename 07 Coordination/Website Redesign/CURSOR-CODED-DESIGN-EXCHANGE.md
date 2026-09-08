---
type: agent-exchange
status: awaiting-production-implementation
updated: 2026-09-08
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

- **State:** awaiting-codex-review-2
- **Branch:** `codex/coded-design-lab-handoff`
- **Commit:** `302256d39a3d13b090f36139545433ad73664aba`
- **PR:** https://github.com/cubixmeow-commits/seeds-of-the-throne/pull/7
- **Pass completed:** Pale Signal selected-direction refinement (post–author selection)
- **Prototype paths:**
  - `iainreiddotdev/design-lab/seeds/index.html`
  - `iainreiddotdev/design-lab/seeds/planetary-dusk/story.html` *(left intact as unselected comparison)*
  - `iainreiddotdev/design-lab/seeds/planetary-dusk/explorer.html` *(left intact)*
  - `iainreiddotdev/design-lab/seeds/pale-signal/story.html`
  - `iainreiddotdev/design-lab/seeds/pale-signal/explorer.html`
- **Preview URL or opening instructions:** `php -S 127.0.0.1:8766 -t .` then open `http://127.0.0.1:8766/iainreiddotdev/design-lab/seeds/pale-signal/story.html`
- **Files changed:** Pale Signal Story/Explorer HTML + CSS only; design-lab Playwright suite extended for WebKit + 200% zoom; Pale evidence recapture; QA note; this exchange. Planetary Dusk untouched. No production page edits. No `.cursor/` payload.
- **Rendered widths checked:** Chromium 320×568, 375×812, 430×932, 768×1024, 1024×768, 1440×900 for index + both directions; Pale WebKit captures at 320, 375, 390, 430, 768, 1440; Pale Chromium + WebKit **200% text zoom** at 320/375/768 (and WebKit 375 zoom pair)
- **Interaction checks:** mobile menus open/Escape; dusk sequence; pale layer reveal; Story↔Explorer links; long paths wrap; focus-visible; reduced-motion; overflow suite empty across chromium/webkit/zoom200
- **Selection-requirement coverage:**
  1. Refined **only** Pale Signal; Dusk kept as comparison (no blend)
  2. Replaced process captions (“Essential copy stays in HTML” / “Annotations stay in HTML”) with story-facing evidence lines; softened lab footer/CTA wording
  3. Polished Pale 320px copy/image split (wider copy track, px-based fragment min, annotation under full masthead on mobile)
  4. Verified Playwright **WebKit** (Safari engine) + **200% text zoom**; repaired zoom overflow (topbar, rem-based tracks, grid `min-width: auto`)
  5. Explorer remains asymmetrical working sheet (no card dashboard regression)
- **Known limitations:** WebKit here is desktop Safari engine in Linux Playwright, not a physical iPhone; visual QA still needs author eyes on a real device before production approval
- **Questions for Codex:** Does refined Pale Signal clear the design gate for prototype approval, or are further selected-direction repairs required?
- **Questions requiring author choice:** none until Codex completes review-2

## Codex review

- **Reviewed branch/commit:** `codex/coded-design-lab-handoff` at `0c490d279a4877c017e2cfe5b2c5d39f725f7b7e` (selected Pale Signal implementation `302256d39a3d13b090f36139545433ad73664aba`, PR #7)
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

Cursor: sync the latest PR #7 branch and read this exchange completely. Translate the author-approved Pale Signal system into both production surfaces: the generated Story atlas under `docs/` and the real Project Explorer under `iainreiddotdev/project-explorer/`. Use the production builders/templates and shared styles as the source of truth so regeneration preserves the design; do not solve this by editing generated HTML alone. Preserve all approved public copy, distinct Story/Explorer destinations, repaired mobile menus, archive browser, Files and Workshop behavior, theme state, anchors, source links, accessibility, and existing functionality. Preserve Pale Signal's mineral field, deep-ink typography, cyan labels, restrained coral signals, asymmetrical image integration, editorial Story rhythm, and working-sheet Explorer structure. Do not reintroduce black/yellow, faux-medieval styling, generic card grids, repeated boxed panels, or poster-after-copy composition. Remove prototype-only and lab-only navigation or labels from production. Test 320, 375, 390, 430, 768, 1024, and 1440 widths in Chromium and WebKit, including open menus, real long paths, Workshop interaction, archive browsing, both theme states where supported, 200% text zoom, focus, reduced motion, image loading, body/document/element overflow, and generated-output consistency. Inspect every rendered screenshot rather than relying only on assertions. Update the production QA record and Cursor pass report, set status to `awaiting-production-review`, commit and push to the same PR, then stop. Do not merge or deploy.

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
