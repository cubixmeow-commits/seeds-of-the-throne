---
type: dependency-map
status: active
updated: 2026-08-24
authority: workflow-only
---

# Unlock and Impact Map

These edges describe development order and review reach, not established story causality.

## Edge types

- `BLOCKS`: downstream task cannot be validated without the source.
- `INFORMS`: downstream task may proceed provisionally but must be reviewed after the source changes.
- `EVIDENCES`: source record or packet supports a later proof path.
- `SETS-UP`: source must be represented before a later payoff.
- `STATE-IN`: upstream sequence/scene output is a required downstream input.

## Initial dependency graph

```text
SC-001 BLOCKS SC-002
SC-002 INFORMS SC-003, SC-014
SC-004 BLOCKS SC-005; SETS-UP SC-006
SC-007 BLOCKS SC-008, SC-009; SETS-UP SC-010
SC-011 EVIDENCES SC-013; SETS-UP SC-026
SC-012 BLOCKS SC-013
SC-014 INFORMS SC-015, SC-022
SC-015 BLOCKS SC-016; SETS-UP SC-026
SC-018 INFORMS SC-019, SC-025
SC-021 INFORMS SC-022, SC-024
SC-013, SC-022 EVIDENCES SC-023
SC-005, SC-009, SC-021 INFORMS SC-024
SC-010, SC-013, SC-015, SC-019, SC-022, SC-023, SC-025 INFORMS SC-026
SC-016, SC-023, SC-024, SC-026 BLOCKS SC-027
```

## Decision propagation

For every accepted, revised, or rejected decision:

1. Give it the existing QA decision ID or add a dated decision record.
2. Record the changed node, old status, new status, and authority source.
3. Traverse outgoing edges and list every reachable task, Story Unit, context note, evidence record, sequence, scene, and draft.
4. Classify each affected artifact:
   - `VALID` — reviewed; no change needed;
   - `REVIEW` — possibly affected;
   - `STALE` — its assumptions no longer hold;
   - `BLOCKED` — cannot be repaired without an author decision;
   - `SUPERSEDED` — retained for history but no longer current.
5. Add newly discovered typed edges before continuing.
6. Select regression checks from [[REGRESSION-SUITE]].
7. Reopen any task whose deepest completed layer no longer passes.
8. Record the trace in [[LOOP-LOG]] and update [[COMPLETION]].

## Blast-radius record

```yaml
change_id:
authority_source:
changed_node:
change_summary:
direct_edges:
reachable_tasks:
affected_story_units:
affected_evidence:
affected_sequences:
affected_scenes:
affected_drafts:
new_questions:
regression_checks:
result:
```

Do not silently edit affected story claims merely to make the trace pass.
