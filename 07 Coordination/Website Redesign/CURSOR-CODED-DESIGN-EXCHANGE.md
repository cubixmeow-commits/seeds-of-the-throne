---
type: agent-exchange
status: awaiting-author-selection
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

- **State:** awaiting-codex-review-1b
- **Branch:** `codex/coded-design-lab-handoff`
- **Commit:** `7c36e7845abd5a9d5af4e2d316ad8b94b99d222a`
- **PR:** https://github.com/cubixmeow-commits/seeds-of-the-throne/pull/7
- **Pass completed:** Pass 1B — Codex-required refinements
- **Prototype paths:**
  - `iainreiddotdev/design-lab/seeds/index.html`
  - `iainreiddotdev/design-lab/seeds/planetary-dusk/story.html`
  - `iainreiddotdev/design-lab/seeds/planetary-dusk/explorer.html`
  - `iainreiddotdev/design-lab/seeds/pale-signal/story.html`
  - `iainreiddotdev/design-lab/seeds/pale-signal/explorer.html`
- **Preview URL or opening instructions:** `php -S 127.0.0.1:8766 -t .` then open `http://127.0.0.1:8766/iainreiddotdev/design-lab/seeds/`
- **Files changed:** Pass 1B design-lab CSS/HTML/Explorer redesigns; evidence recapture + open-menu shots; QA note; exchange; `.gitignore` adds `.cursor/`; **removed** all committed `.cursor/` installer output. No production page edits.
- **Rendered widths checked:** 320×568, 375×812, 430×932, 768×1024, 1024×768, 1440×900 for index + four prototypes; plus `375x812-*-story-menu.png` open-menu evidence
- **Interaction checks:** mobile menus open/Escape/focus return; dusk sequence buttons; pale layer reveal; Story↔Explorer main links; long paths wrap; focus-visible; reduced-motion; overflow suite empty
- **Pass 1B requirement coverage:**
  1. `.cursor/` removed from PR; tool noted in report only
  2. Mobile Story openings keep artwork in first viewport (no bordered copy card → poster stack)
  3. Explorers redesigned: Dusk vertical-spine thread; Pale asymmetrical editorial sheet
  4. Borders/boxed panels sharply reduced
  5. Authored display/label typography without fantasy serif or webfont deps
  6. Story visual language carried into each Explorer
  7. Evidence + checks refreshed
- **Known limitations:** Chromium-only; Safari/iOS and exhaustive 200% zoom still unverified; short 320 Dusk may crop secondary CTA
- **Questions for Codex:** Are mobile openings and Explorer spatial models now comparable enough for author selection?
- **Questions requiring author choice:** none until Codex clears Pass 1B

## Codex review

- **Reviewed branch/commit:** `codex/coded-design-lab-handoff` at `77d7c0d0b2c1388a2470bd734216d06351c40b8a` (Pass 1B implementation `7c36e7845abd5a9d5af4e2d316ad8b94b99d222a`, PR #7)
- **Review state:** Pass 1B clears the design gate; ready for direct author selection
- **What works visibly:**
  - Both mobile Story openings now preserve their actual spatial concept. Planetary Dusk uses a full-bleed planetary field beneath a controlled gradient; Pale Signal uses a deliberately narrow, clipped infrastructure fragment beside the copy. Artwork is present at 320px rather than deferred below a completed text block.
  - The Explorer directions are now materially different. Dusk reads as one continuous current-thread spine with orbital evidence and sequential work; Pale reads as an asymmetrical editorial working sheet with a rail, clipped evidence, and open typographic sections.
  - Most generic containers are gone. Hierarchy now comes from spatial flow, crop, tonal fields, alignment, rules, labels, and type rather than repeated cards.
  - The color systems are coherent and avoid the rejected black/yellow archive treatment. The lighter Pale field is especially legible and gives the project a recognizable non-dashboard identity.
  - Mobile menus are visually integrated, and the supplied Chromium evidence reports no body/document overflow or escaping elements at all six required widths. Playwright, story-site, JavaScript syntax, and `git diff --check` are reported passing.
  - The committed third-party `.cursor/` payload has been removed. PR #7 is reduced from 226 files / about 90,000 added lines to 57 files / about 2,556 added lines. Production surfaces remain unchanged.
- **Blocking design problems:** none before author selection
- **Blocking responsive or functional problems:** none found in the supplied rendered evidence. Safari/iOS and exhaustive 200% zoom remain required before prototype approval and production translation.
- **Required next changes after the author selects a direction:**
  1. Refine only the selected system; do not blend the two into a compromise theme.
  2. Replace prototype/process-facing captions such as “Essential copy stays in HTML” and “Annotations stay in HTML” with concise story-facing evidence language or remove them. Do not expose implementation commentary in the production experience.
  3. Polish the selected 320px composition. For Dusk, maintain text contrast over the detailed image and ensure the secondary action remains intentionally reachable. For Pale, protect the narrow copy/image split from feeling cramped.
  4. Test the selected direction in real iOS Safari and at 200% text zoom; repair any crop, menu, wrapping, or control failures.
  5. Continue carrying the selected Story language into Explorer without turning Explorer back into a card dashboard.
- **What must remain unchanged:** production pages until prototype approval; truthful Story versus Project Explorer destinations; source-aligned copy; no black/yellow archive palette; no faux-medieval styling; no generic card-grid regression; accessible navigation and controls; prototype isolation.
- **Recommendation to the author:** select **Pale Signal**. Its light mineral field, clipped vertical infrastructure, asymmetrical editorial rhythm, and working-sheet Explorer create the strongest shared identity across both surfaces. It also moves furthest from the rejected dark archive site. Planetary Dusk is a credible alternative if atmosphere and cinematic immersion matter more than daylight readability, but it remains predominantly dark and its Explorer is less distinctive.
- **Author decision needed:** choose **Pale Signal** or **Planetary Dusk** for one selected-direction refinement pass. This is a direction choice, not yet approval for production.

## Author decision

Only record a decision the author states directly.

- **Selected direction:** pending
- **Requested changes:** pending
- **Prototype approved for production:** no
- **Production merge authorized:** no

## Current next action

Author: choose `Pale Signal` or `Planetary Dusk`. Codex will record the direct selection and prepare the next Cursor refinement instruction. Do not merge or begin production implementation.

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

