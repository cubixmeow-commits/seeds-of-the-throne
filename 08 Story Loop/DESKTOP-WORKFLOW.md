---
type: story-loop-workflow
status: active
version: 0.1
updated: 2026-08-20
---

# Desktop Workflow

This is the manual v0.1 execution path. One session should normally process one Story Unit. Two or three adjacent units may be grouped only when their causal handoff is the actual problem.

## Before the session

1. Read [[START HERE]], [[03 Context/CURRENT|CURRENT]], and [[03 Context/RULES|RULES]].
2. Check repository changes and preserve unrelated work.
3. Open [[STORY-MAP]] and select the highest-value unresolved unit.
4. Classify the run: `close-gap`, `strengthen-structure`, or `new-expansion`.
5. Create a run log from [[08 Story Loop/Templates/run-log]].

## Stage A — retrieve and prepare

1. Open the Story Unit.
2. Retrieve only its listed source notes and immediate dependencies.
3. Update the unit's known facts, constraints, missing decisions, and contradictions without solving them.
4. Prepare a Brainstorm Packet from [[08 Story Loop/Templates/brainstorm-packet]].

### Author Gate A — brainstorm scope

The author confirms or corrects what the unit is meant to accomplish and brainstorms the unresolved questions. Extract statements into:

- accepted decisions;
- working preferences;
- possible ideas;
- rejected ideas;
- still unanswered questions.

Do not treat conversational exploration as blanket approval.

## Stage B — build and attack

1. The Architect creates a proposal from accepted decisions and current sources.
2. Run Character, Causality, Continuity, and Structure critics independently.
3. Record each report with [[08 Story Loop/Templates/critique]].
4. The Integration Editor repairs only authorized issues.
5. Stop after two revision cycles if a load-bearing choice remains.

### Author Gate B — creative decisions

Present only decisions that change story facts or select between viable structures. For each, give:

- the exact decision;
- why it matters now;
- two or three viable options when useful;
- consequences of each option;
- a free author response path.

## Stage C — integration

1. Produce a final candidate Story Unit with all authority labels visible.
2. List affected compiled notes before editing them.
3. Ask for explicit author approval to integrate.
4. Update the Story Unit, affected compiled notes, `07 QA/Decisions.md` when appropriate, and [[STORY-MAP]].
5. Preserve unresolved questions in the unit and context files.

### Author Gate C — integration approval

The author approves the exact decision set and affected-file list. Approval is scoped to that set.

## Stage D — close the run

1. Complete the run log.
2. Add repeated failures to [[08 Story Loop/Evaluations/Failure Modes]].
3. Identify the next highest-value unit from the map.
4. Verify links and repository diff.
5. Commit or publish only when separately authorized.

## First desktop command in plain language

> Open S-002, review its Brainstorm Packet, and ask me the Author Gate A questions without inventing the inciting event.
