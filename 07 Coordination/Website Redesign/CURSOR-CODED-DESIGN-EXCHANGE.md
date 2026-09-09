---
type: agent-exchange
status: ready-to-merge
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
- **Commit:** `f0df8bd77ad78906fc051632efa35095b73c090a` (tip `fa1ba5c` pins this SHA)
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

- **Reviewed branch/commit:** `codex/coded-design-lab-handoff` at `a0f18021176379f57b43873df490f3d7fc2f208c` (focused repair `f0df8bd77ad78906fc051632efa35095b73c090a`, PR #7)
- **Review state:** production review-2 passed; ready for the author's explicit merge decision
- **Verified repair results:**
  1. **Mobile destinations are now visibly distinct.** At both 320px and 390px, Overview retains the full image-led Explorer introduction, Files opens with “Story files” and its browser, and Workshop opens with “Story workshop” and the active workshop controls. Route-specific headings and useful content appear before scroll.
  2. **Closed-menu route identity is clear.** The compact “Now viewing” row and current destination inside the Menu control expose Overview, Files, Workshop, and the other routes without opening navigation. The accessible hamburger behavior remains intact.
  3. **Story first paint is repaired.** The essential masthead opacity animation was removed, and the refreshed 320px/390px captures show fully opaque title, premise, consequence, and actions.
  4. **Dark theme is proven with the menu closed.** The refreshed 375×812 capture uses a deep mineral field with readable pale text. Evidence records `#1a2c38` for the dark wash, `rgb(230, 238, 242)` for heading text, and confirms the menu is closed.
  5. **The approved direction remains intact.** The repair preserves Pale Signal's mineral field, deep ink, cyan system labels, restrained coral signal, asymmetrical Story composition, and denser Explorer working-sheet character.
- **Evidence inspected:** refreshed 320×568 and 390×844 Story/Explorer screenshots, the dedicated distinct-route captures, closed-menu dark capture, and 200% view. No page-level overflow or obscured destination was visible.
- **Implementation reviewed:** Overview-only hero conditional, compact route metadata for Sources/Decisions/Workshop/Progress/Files, active route labels, dark wash tokens, settled evidence capture, and generated Story cache-bust/source consistency.
- **Verification:** `git diff --check` passed; `python3 scripts/check_story_sites.py` passed; refreshed evidence contains 63 results with zero errors. Cursor reports the full browser suite passed across 320/375/390/430/768/1024/1440 plus the WebKit subset.
- **Blocking design problems:** none
- **Blocking responsive or functional problems:** none found
- **Non-blocking deployment note:** perform the planned physical-iPhone check after deployment; Playwright WebKit remains preflight evidence.
- **What must remain unchanged:** approved Pale Signal identity and public copy; distinct Story and Explorer purposes; navigation, archive, Workshop, Files, theme and accessibility behavior; no black/yellow, faux-medieval, generic cards/dashboard, or poster-after-copy regression.
- **Recommendation:** merge PR #7 only after the author explicitly authorizes it. Deployment remains a separate author action.
- **Author decision needed:** authorize the PR #7 merge or request another correction

## Author decision

Only record a decision the author states directly.

- **Selected direction:** Pale Signal — selected directly by the author on 2026-09-08
- **Requested changes:** Refine only Pale Signal. Remove prototype/process-facing captions; polish the 320px copy/image split; verify real iOS Safari and 200% text zoom; preserve the asymmetrical mineral editorial composition and working-sheet Explorer; do not regress to cards, black/yellow, or generic dashboard styling.
- **Prototype approved for production:** yes — the author directly approved the refined Pale Signal prototype on 2026-09-08
- **Production merge authorized:** no

## Current next action

Author: review the production-review-2 result and either explicitly authorize merging PR #7 into `main` or request another correction. Do not deploy automatically. If merge is authorized, merge the reviewed PR without adding new implementation changes, verify `main` contains the repair commit, and stop for the author's Namecheap deployment.

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
