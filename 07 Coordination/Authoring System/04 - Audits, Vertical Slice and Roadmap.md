---
type: implementation-roadmap
status: proposed
updated: 2026-09-07
authority: product and workflow proposal only
---

# Audits, Vertical Slice and Roadmap

## Current-system assessment

| Capability | Current state | Needed change |
|---|---|---|
| Persistent story memory | strong | add stable Markdown identity and Markdown-derived projections |
| Authority and author gates | strong in policy | make state transitions and conflicts deterministic |
| Workshop design | strong and story-specific | connect accepted answers directly to propagation and completion |
| Decision propagation | careful but manual | compute blast radius and stale artifacts |
| Continuity | extensive methods | add structured chronology, knowledge, promise, and state checks |
| Scene planning | well specified | exercise a full scene contract on real story material |
| Prose generation | sophisticated skill, lightly production-tested | validate full scene-to-approved-prose pipeline |
| Manuscript | no substantive scenes yet | establish ordered scene/chapter registry and approval states |
| Author interface | powerful but administrative | one conversational front door and progressive disclosure |
| Project Explorer | useful public, story-specific view | make system behavior, provenance, and progress its purpose |
| Docs site | story atlas | evolve toward reader-facing story presentation with spoiler control |

## Immediate reconciliation

Before new runtime work:

1. Preserve the twenty workshop modules and accepted answers.
2. Convert accepted answers into decision events with stable IDs and source links.
3. Reconcile `CURRENT`, `TASK-REGISTRY`, and stale `COMPLETION` state.
4. Map each accepted workshop result to affected Story Completion tasks instead of claiming that no task advanced.
5. Supersede the old product claim that final fiction must remain human-written; retain author control and approval.
6. Keep the horizontal development logic internally, but stop exposing 27 tasks × 8 depths as the default author experience.
7. Preserve old workflow documents as versioned history rather than silently rewriting what happened.

## External-method adoption audit

This is a preliminary design decision, not a final legal or technical dependency approval.

| Source | Useful capability | Decision | Reason |
|---|---|---|---|
| Compound Writing | conversational router, interview, voice/style split, development/line edit separation, residue passes, save ritual | adapt patterns | excellent front-door and editing UX; nonfiction gravity and licensing artifact require caution |
| Story Skills | deterministic schemas, registries, links, continuity, promises/payoffs, character/object/knowledge state | evaluate for reuse | closest match to the missing runtime; MIT license observed in audit |
| Novel Writer English | constitution-to-draft workflow, context sharding, pre-write and consistency checks | learn/adapt | strong procedural coverage; must fit Seeds authority model rather than create another workflow |
| Jwynia Agent Skills | story sense, zoom levels, chapter drafting, revision frameworks | selectively adapt | useful craft specialists; verify license per skill before reuse |
| SkillMedev collection | scene, structure, revision, ghostwriting patterns | learn selectively | broad catalog; quality and overlap require individual evaluation |
| Zoe story skill | compact story workflow ideas | learn only | no clear license found in preliminary audit |

Commercial tools should be evaluated for user expectations—bibles, planning, drafting, canvas, continuity, and export—not copied. The differentiation is a durable conversational decision system that can explain how an answer changes the whole story and carry that state into controlled prose.

## Four audits to complete before broad implementation

1. **Author-problem audit:** interview AI-embracing and craft-light creators; rank failure points from idea capture through finishing and exporting.
2. **Open-source capability/licensing audit:** inspect exact versions, licenses, schemas, scripts, tests, and integration cost of candidate skills.
3. **Competitor journey audit:** test how current products handle onboarding, long context, voice, continuity, decision history, revision, ownership, and export.
4. **Seeds workflow audit:** trace every accepted workshop answer through canon, tasks, website projections, scene readiness, and pickup state.

Record observed behavior separately from marketing claims and inferred design lessons.

## First vertical slice

Use the author-approved Book One outcome-presentation confrontation near Samuel's final exposure. Samuel attempts to offer Sylvan a customized version of the bargain that trapped Konrad while Konrad's inner circle can compare his claims with reality. The slice should exercise history, misinformation, character knowledge, Sylvan's decisive control, Samuel's attempted manipulation, and a visible change in the inner circle.

Required path:

`existing source → one unresolved gate → author answer → reflected confirmation → decision event → blast radius → updated story projection → scene contract → draft candidate → continuity and narrative-residue checks → author review → manuscript candidate → Project Explorer demonstration`

### Acceptance tests

- The author answers in ordinary language without editing files.
- Raw answer and normalized interpretation are both preserved.
- No propagation occurs before confirmation.
- A changed answer identifies every dependent artifact.
- The scene packet contains no unmarked invention.
- A character cannot use unavailable knowledge.
- Chronology and revelation order remain separate.
- A rejected draft changes no story truth.
- A drafting-discovered gap returns to one workshop question.
- The author can stop and resume with no reconstruction work.
- Exported Markdown is complete and understandable without the interface.
- Project Explorer accurately demonstrates the chain without exposing private material.

## Phased roadmap

### Phase 0 — Reconcile and measure

Normalize current workflow state, assign stable IDs to the selected slice, define baseline author-attention and defect measures, and choose the exact scene.

Exit: the repository can state one trustworthy current position.

### Phase 1 — Deterministic Markdown story kernel

Implement Markdown templates/frontmatter rules, event validation, dependency indexing, projections, status transitions, and blast-radius reporting for the vertical slice only. Do not introduce author-maintained JSON sidecars.

Exit: one accepted decision updates explainable state without manual duplication.

### Phase 2 — Conversational Workshop Engine

Implement intake preservation, reflection, answer modes, one-question prioritization, acceptance, deferral, correction, and batch integration.

Exit: the author completes one consequential gate entirely through conversation.

### Phase 3 — Composition Engine slice

Implement bounded context, scene contract, candidate drafting, development/continuity/narrative/prose passes, author review, and manuscript promotion for one scene.

Exit: one scene reaches approved or clearly rejected manuscript state without accidental canon change.

### Phase 4 — Author experience and projections

Add reliable save/resume/export, mobile-first workshop, desktop deep view, Project Explorer trace, and reader-site manuscript projection.

Exit: the slice is demonstrable end to end on both surfaces.

### Phase 5 — Expand across Seeds

Migrate remaining decisions and entities, generate sequence/scene registries, process the manuscript horizontally, and measure failure patterns.

Exit: multiple chapters can move through the same repeatable system.

### Phase 6 — Generalize cautiously

Extract story-agnostic schemas and installable skills only after Seeds reveals which assumptions are genuinely reusable. Add memoir/nonfiction controls as a separate profile.

Exit: a second creator can begin a distinct project without inheriting Seeds-specific structure or language.

## First five design sessions

1. **Reconciliation session:** connect the twenty workshop decisions to actual task and canon state. It repairs the largest demonstrated failure.
2. **Vertical-slice selection:** choose one scene and enumerate its exact records. It bounds every later design decision.
3. **Decision/event schema session:** approve statuses, IDs, supersession, provenance, and blast radius. Every engine depends on this contract.
4. **Author conversation session:** prototype the resume → ask → reflect → confirm loop with real voice input. It tests the product promise before software scale.
5. **Scene-to-prose session:** run the selected scene manually through the proposed pipeline and record every friction point. It prevents automating an unproven workflow.

## Explicit non-goals for the first build

- a general-purpose writing platform;
- autonomous canon decisions;
- bulk novel generation;
- a complex database or cloud service;
- live multi-user collaboration;
- fake synchronization or browser-only saving presented as durable;
- replacing the existing vault before the vertical slice proves the migration path.

## Decision gates before implementation

1. Set the approved vertical-slice scene's exact beginning and ending state.
2. Decide whether accepted spoken answers require a separate confirmation every time or may use a configurable trusted mode.
3. Approve the minimum Markdown record types and authority lifecycle.
4. Choose whether Project Explorer remains public during early development or receives a private development mode.

Ask these one at a time during actual workshop use.
