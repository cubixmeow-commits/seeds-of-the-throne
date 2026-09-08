---
type: agent-exchange
status: awaiting-cursor-pass-1
updated: 2026-09-08
active_branch: unset
active_pr: unset
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

Cursor replaces the contents of this section at the end of each pass.

- **State:** not started
- **Branch:**
- **Commit:**
- **PR:**
- **Pass completed:**
- **Prototype paths:**
- **Preview URL or opening instructions:**
- **Files changed:**
- **Rendered widths checked:**
- **Interaction checks:**
- **Known limitations:**
- **Questions for Codex:**
- **Questions requiring author choice:**

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

Cursor: complete Pass 1 from [[07 Coordination/2026-09-08 - Cursor Coded Website Design Lab]], then update this file, commit everything, open a review PR, and stop.

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

