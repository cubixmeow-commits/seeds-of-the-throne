---
type: agent-exchange
status: awaiting-codex-review-2
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
6. `prototype-approved` — the author approved the rendered prototype.
7. `awaiting-production-implementation` — Cursor is translating the approved system into production.
8. `awaiting-production-review` — Codex reviews production pages and regressions.
9. `ready-to-merge` — checks and author review are complete; explicit merge permission is still required.

## Cursor pass report

- **State:** awaiting-codex-review-2
- **Branch:** `codex/coded-design-lab-handoff`
- **Commit:** `a22d21997cad9cb190a1a23bfb77cf5a84cb8915`
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

- **Selected direction:** Pale Signal — selected directly by the author on 2026-09-08
- **Requested changes:** Refine only Pale Signal. Remove prototype/process-facing captions; polish the 320px copy/image split; verify real iOS Safari and 200% text zoom; preserve the asymmetrical mineral editorial composition and working-sheet Explorer; do not regress to cards, black/yellow, or generic dashboard styling.
- **Prototype approved for production:** no
- **Production merge authorized:** no

## Current next action

Codex: review PR #7 Pale Signal refinement against the selection requirements and prior Pass 1B review notes. Update this exchange with review-2 findings. Do not merge, deploy, or change production pages. Ask the author only if a new decision is required.

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
