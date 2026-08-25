---
type: coordination-system
status: active
version: 1.0
updated: 2026-08-24
---

# Story Completion Workflow

This is the persistent execution layer between [[07 Coordination/Weekly Synthesis/README|Weekly Story Synthesis]] and the [[08 Story Loop/README|Story Loop]]. It advances the whole story through repeated horizontal passes without allowing workflow state to become story authority.

## Governing rule

Prefer the entire story at coherent partial resolution over one branch at full detail while the rest remains unmapped.

The sweep order is:

`Macro Shape -> Causal Architecture -> Character/Agency -> Systems/Evidence -> Sequence Integration -> Scene Mapping -> Scene Development -> Draft`

Every active task receives the current sweep before any task descends to the next depth. A whole-story cross-check closes each sweep.

## Sources of truth

- [[07 Coordination/Weekly Synthesis/Runs/2026-08-23/12 Weekly Story Completion Todo|Weekly Story Completion TODO]] owns the public completion checkboxes.
- [[TASK-REGISTRY]] owns task IDs, depth, phase, and validation state.
- [[UNLOCK-MAP]] owns typed dependencies and reverse-impact paths.
- [[CURRENT]] owns the active sweep and current task.
- `07 QA/Decisions.md`, `Contradictions.md`, and `Questions.md` remain the durable authority/QA records.

No dashboard, task state, packet, prototype, or generated draft establishes canon.

## State model

Depth is one of:

`UNTOUCHED`, `MACRO-MAPPED`, `CAUSAL-MAPPED`, `AGENCY-MAPPED`, `SYSTEM-EVIDENCE-MAPPED`, `SEQUENCE-INTEGRATED`, `SCENE-MAPPED`, `SCENE-DEVELOPED`, `DRAFTED`, `DONE`, `REOPENED`.

Loop phase is tracked separately:

`CONTEXT`, `BRAINSTORM`, `CRITIC`, `AUTHOR-GATE`, `INTEGRATE`, `VALIDATE`, `IDLE`.

Validation is one of `NOT-RUN`, `PASS`, `PASS-WITH-NOTES`, or `BLOCKED`.

## Per-task pass

1. Open the task's source TODO and registry row.
2. Retrieve only authority-classified context needed for the current sweep.
3. Use the applicable template without descending below the sweep.
4. Record alternatives as proposed and stop for any load-bearing author choice.
5. Record dependency changes and possible downstream effects.
6. Run the sweep-appropriate critics.
7. Update the task packet, registry state, and loop log.
8. Move to the next task at the same depth.

## Sweep close

After every active task has been visited:

1. run `Templates/whole-story-cross-check.md`;
2. trace every approved change through [[UNLOCK-MAP]];
3. run the selected checks in [[REGRESSION-SUITE]];
4. reopen affected tasks rather than concealing invalidation;
5. record the result in [[SWEEP-LOG]];
6. advance [[CURRENT]] only when no blocking issue remains.

## Definition of done

A task is `DONE` only when an explicit author-approved decision is recorded, affected notes are integrated with authority labels, blast radius is traced, required regression checks pass, QA records are current, sequence/scene setup and payoff are represented, the weekly checkbox is checked, and the public dashboard reflects the source Markdown.

An answer alone is not completion.

## Expansion stop

Before adding lore, research, characters, technology, institutions, or scene detail, ask whether it is required to clarify the current task at the current sweep. If not, record it as deferred and continue horizontally.
