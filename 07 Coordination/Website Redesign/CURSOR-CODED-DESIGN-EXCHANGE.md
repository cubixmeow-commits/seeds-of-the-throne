---
type: agent-exchange
status: awaiting-codex-review-1
updated: 2026-09-08
active_branch: codex/coded-design-lab-handoff
active_pr: https://github.com/cubixmeow-commits/seeds-of-the-throne/pull/7
cycle: 1
author_selection: pending
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
6. `prototype-approved` — the author approved the rendered prototype.
7. `awaiting-production-implementation` — Cursor is translating the approved system into production.
8. `awaiting-production-review` — Codex reviews production pages and regressions.
9. `ready-to-merge` — checks and author review are complete; explicit merge permission is still required.

## Cursor pass report

- **State:** awaiting-codex-review-1
- **Branch:** `codex/coded-design-lab-handoff`
- **Commit:** (filled after push; visual Pass 1 on this branch)
- **PR:** https://github.com/cubixmeow-commits/seeds-of-the-throne/pull/7
- **Pass completed:** Pass 1 — both coded directions with Story + Project Explorer prototypes
- **Prototype paths:**
  - `iainreiddotdev/design-lab/seeds/index.html`
  - `iainreiddotdev/design-lab/seeds/planetary-dusk/story.html`
  - `iainreiddotdev/design-lab/seeds/planetary-dusk/explorer.html`
  - `iainreiddotdev/design-lab/seeds/pale-signal/story.html`
  - `iainreiddotdev/design-lab/seeds/pale-signal/explorer.html`
- **Preview URL or opening instructions:** `php -S 127.0.0.1:8766 -t .` then open `http://127.0.0.1:8766/iainreiddotdev/design-lab/seeds/`
- **Files changed:** isolated design-lab prototypes; QA evidence + review note; UI/UX Pro Max installer under `.cursor/`; this exchange; handoff completion report. No production `docs/` or Project Explorer edits.
- **Rendered widths checked:** 320×568, 375×812, 430×932, 768×1024, 1024×768, 1440×900 for index + all four prototypes; screenshots in `07 QA/Coded Design Lab Review Evidence/`
- **Interaction checks:** mobile menus (open/Escape/focus return); dusk authorship-sequence buttons; pale concealed-layer reveal; Story↔Explorer links; long workshop paths wrap; focus styles present; reduced-motion disables nonessential transforms
- **Known limitations:** Chromium-only automated pass; short mobile viewports can push Dusk imagery below the first screen; warm cutaway art is filtered rather than replaced; lab nav is not full production IA
- **Questions for Codex:** Do the two spatial models read as materially different under real content pressure? Any blocking overflow/contrast/hierarchy issues before author selection?
- **Questions requiring author choice:** Which direction should be refined next—Planetary Dusk or Pale Signal? Any must-fix composition notes before Pass 2?

## Codex review

Codex replaces the contents of this section after reviewing Cursor's newest committed pass.

- **Reviewed branch/commit:** not yet reviewed
- **Review state:** pending
- **What works visibly:**
- **Blocking design problems:**
- **Blocking responsive or functional problems:**
- **Required next changes, in priority order:**
- **What must remain unchanged:**
- **Recommendation to the author:**
- **Author decision needed:**

## Author decision

Only record a decision the author states directly.

- **Selected direction:** pending
- **Requested changes:** pending
- **Prototype approved for production:** no
- **Production merge authorized:** no

## Current next action

Codex: review PR #7 and the rendered prototypes at the listed widths, update the Codex review section, set status to `awaiting-author-selection` (or return blocking fixes to Cursor), and stop.

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
