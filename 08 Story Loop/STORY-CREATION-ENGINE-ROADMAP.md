---
type: development-system-roadmap
status: active
version: 1.0
updated: 2026-08-24
authority: workflow-only
---

# Story Creation Engine Roadmap

## Current assessment

Seeds already functions as a strong human-in-the-loop story-development engine. Canon/authority management, persistent story memory, gap analysis, divergent development, criticism, research separation, multiscale structure, and author gates are operating. The remaining work is the production layer that repeatedly turns architecture into validated sequence, scene, and manuscript state.

The target is not “ask an AI to write the next thing.” It is:

> Advance the story by one author-approved, validated state transition while preserving the whole-story graph.

Final fiction remains human-authored and author-controlled.

## Seven-layer architecture

| Layer | Responsibility | Current state | Next proof |
|---|---|---|---|
| 1. Story database | characters, systems, events, chronology, artifacts, relationships | strong and active | stable links for every load-bearing sequence input |
| 2. Authority engine | status vocabulary and author gates | strong and active | regression proves no lower-authority source silently wins |
| 3. Planning engine | synthesis, gap ranking, task state, dependencies | v1 execution layer implemented | complete the first horizontal macro sweep |
| 4. Development engine | brainstorm, research, critics, prototype, integration | strong and exercised | run registry tasks through repeated author-gated loops |
| 5. Structural engine | macro, causality, agency, systems/evidence, sequences, scenes | workflow and packets implemented | produce a coherent whole-story sequence registry |
| 6. Generation engine | stable scene packet to draft, critique, revision, promotion | contract implemented; not exercised | take one stable scene through the full draft pipeline |
| 7. Validation/runtime | propagation, blast radius, regression, reopening, dashboard | v1 Markdown runtime implemented | validate a real decision change and trace affected artifacts |

## Roadmap phases

### Phase A — Stateful planning runtime (implemented 2026-08-24)

- 27-task registry with independent depth, phase, and validation fields
- typed dependency/unlock map
- current-sweep and completion state
- blast-radius and reopening protocol
- story regression selection contract
- public weekly TODO dashboard sourced from Markdown

Exit test: the system can answer what is active, what depth each task has reached, what blocks or informs it, and what must be reviewed after a decision changes.

### Phase B — Complete Macro Shape horizontally

- run all 27 tasks through the macro template
- preserve candidates where the author has not decided
- record story function, entering/resulting state, and cross-task reach
- run the first whole-story cross-check
- repair or reopen before causal work

Exit test: one Macro Story Completion Map explains how every active TODO relates to beginning, middle, and ending without pretending unresolved mechanics are solved.

### Phase C — Causal, agency, and systems/evidence sweeps

- forward/reverse causality for every task
- knowledge, verification, choice, cost, and responsibility maps
- actor/channel/permission/resource/limit/audit/failure contracts
- evidence creation/custody/authentication/reveal paths
- regression after each complete horizontal sweep

Exit test: large transitions work without coincidence, omnipotence, impossible knowledge, or erased agency.

### Phase D — Sequence runtime

- assign stable sequence IDs
- create a packet for every indispensable sequence
- connect each resulting state to the next entering state
- attach setup/payoff and evidence edges
- run chronology, knowledge, causality, agency, systems, and transition regression

Exit test: the beginning-to-end sequence chain contains no unexplained load-bearing transition.

### Phase E — Scene runtime

- create the minimum necessary scenes horizontally across all sequences
- give each scene explicit inputs, objective, obstacle, attempt, turn, choice, outputs, and next dependency
- develop disposable prototypes only after the whole scene map exists
- stabilize packets only after cross-sequence validation

Exit test: every required state change is owned by a scene and every scene changes at least one necessary state.

### Phase F — Draft pipeline

- retrieve approved context from the scene's relevant subgraph
- author or generate an explicitly provisional draft as requested
- run prose, voice, continuity, anti-AI/variance, and audiobook checks
- stop for author revision and approval
- promote only approved prose into ordered manuscript state
- propagate resulting state downstream

Exit test: one scene can move repeatably from stable packet to approved manuscript material without changing canon by accident.

### Phase G — Mechanical validation and automation

- validate task IDs, states, links, and dependency targets
- calculate reverse dependency reach and stale artifacts
- select regression checks by edge/artifact type
- generate dashboard data from Markdown without duplicated task content
- add fixtures for authority, chronology, knowledge, evidence, and propagation

Exit test: a changed decision yields an explainable affected-node report, selected regressions, reopened work, and a clean state after repair.

## Non-goals

- autonomous canon decisions;
- silent contradiction cleanup;
- automatic conversion of research, prototypes, generated images, or prose into truth;
- polishing one branch while the rest remains unresolved;
- replacing the author's handwritten final-fiction process.

## Operating links

- [[07 Coordination/Story Completion Workflow/WORKFLOW|Story Completion Workflow]]
- [[DEVELOPMENT-ORCHESTRATOR]]
- [[MULTISCALE-DEVELOPMENT-GAUNTLET]]
- [[Templates/sequence-packet]]
- [[Templates/scene-packet]]
- [[Templates/draft-pipeline-run]]
