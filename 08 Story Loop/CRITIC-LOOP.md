---
type: story-loop-protocol
status: active
version: 0.1
updated: 2026-08-20
---

# Critic Loop

The builder and graders are separate roles. Each critic diagnoses only its assigned dimension, cites the Story Unit or vault source it relied on, and returns failures without silently rewriting canon.

## 1. Context Retriever

Collects only the current unit, its direct dependencies, affected character/system notes, and relevant author decisions. It labels conflicts and missing sources. It does not design the answer.

## 2. Brainstorm Preparer

Summarizes what is established, what the unit must accomplish, what must remain open, and the smallest set of high-value questions for the author. It distinguishes decisions from speculation in the author's response.

## 3. Architect

Turns approved brainstorm decisions into one coherent Story Unit proposal. It must reuse existing components, show the causal chain, list alternatives it rejected, and flag every invented bridge as proposed.

## 4. Character Critic

Checks goals, fears, loyalties, knowledge, misbeliefs, agency, and change. It asks whether each important action is believable for this character at this exact point.

## 5. Causality Critic

Attacks every major “because.” It finds missing triggers, convenient coincidences, effects without causes, causes without consequences, and handoffs that are merely chronological.

## 6. Continuity Critic

Checks the proposal against current vault authority, chronology, world rules, technology limits, character knowledge, names, and superseded decisions. It returns citations to the affected notes.

## 7. Structure Critic

Tests whether the unit is necessary, changes the story, escalates or resolves pressure, supports the larger trajectory, and hands off cleanly. Structural theories are diagnostic lenses, not mandatory formulas.

## 8. Integration Editor

Receives the Architect proposal and critic reports. It may repair only issues whose solution is already authorized. Otherwise it creates an Author Decision request. It produces a concise change set and lists every affected vault file before any compiled note is edited.

## 9. Author Gate

Only the author may accept, reject, combine, or defer unresolved creative options. Silence is not approval. Approval of a concept does not approve newly invented implementation details.

## 10. Run Recorder

Records inputs, source notes, outputs, failures, author decisions, changed files, and follow-up work. Repeated failures are added to [[08 Story Loop/Evaluations/Failure Modes]].

## Loop control

Run no more than two revision cycles before returning unresolved design choices to the author. A critic may request research, but research cannot establish canon. Stop a run if its solution requires expanding scope beyond the selected unit and its immediate dependencies.
