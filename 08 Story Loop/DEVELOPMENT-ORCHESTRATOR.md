---
type: development-system
status: active
updated: 2026-08-21
scope: end-to-end routing for story development
---

# Development Orchestrator

## Purpose

Provide one executable path through the development environment. This document decides which module runs, in what order, what state passes forward, and where the process must stop for the author.

## Default pipeline

`scope -> retrieve -> classify authority -> Gap Analyzer -> choose mode/scale -> diverge cheaply -> shortlist -> optional research -> expand one branch -> Character Factory as needed -> structure packet -> optional development prototype -> relevant critics -> author gate -> approved integration -> next-state record`

Finished-novel drafting is not part of the default pipeline.

## Step 1 — Scope the run

Declare:

- one target;
- current scale: era, arc, sequence, chapter, scene, or prototype;
- classification: close-gap, strengthen-structure, or new-expansion;
- explicit exclusions;
- stop condition;
- token mode: Micro, Standard, Deep, or Cascade.

Default to `close-gap`. Use Cascade only when the author asks to move from broad structure into a representative story sample in one run.

## Step 2 — Retrieve and classify

Build one compact context packet from direct sources. Separate:

- established facts;
- working structure;
- proposed candidates;
- unresolved decisions;
- rejected or superseded material;
- non-canon exploration.

Do not let later prose or a persuasive sample outrank an explicit author decision.

## Step 3 — Analyze gaps

Run [[08 Story Loop/GAP-ANALYZER]]. Select one highest-value gap or one tightly connected cluster. If an author decision blocks the next branch, prepare that decision and stop.

## Step 4 — Choose the route

- **Interactive unresolved mechanism:** use a Brainstorm Packet and question-by-question author gate.
- **Need alternate possibilities:** use [[09 Story Exploration/STORY-GENERATION-LOOP]].
- **Need outside mechanisms:** use [[08 Story Loop/RESEARCH-CREATIVITY-FIT-LOOP]].
- **Need structure at multiple scales:** use [[08 Story Loop/MULTISCALE-DEVELOPMENT-GAUNTLET]].
- **Need cast:** use [[08 Story Loop/CHARACTER-FACTORY]] only after story functions are known.
- **Need scene propulsion/clarity:** use [[08 Story Loop/PROBLEM-SOLVING-STORY-ENGINE]].
- **Need to feel the candidate as story:** use [[08 Story Loop/DEVELOPMENT-PROTOTYPE-STYLE]].
- **Need finished prose:** route separately to the prose workflow only after explicit selection and sufficient structural stability.

Routes may combine, but every module must answer a specific uncertainty.

## Step 5 — Diverge breadth-first

Generate compact alternatives before detailed development.

- Micro: 3 narrow options.
- Standard: 4–6 options; expand the best 2.
- Deep: 5–10 broad options; shortlist 3.
- Cascade: 3–5 broad options; follow only 1 working branch downward.

An AI shortlist is a recommendation, not author approval or canon.

## Step 6 — Research selectively

Research only when the result could change plausibility, mechanism, constraints, or dramatic possibilities. Translate findings through:

`mechanism -> human pressure -> Seeds behavior -> concrete situation -> choice -> consequence`

Label supported fact, extrapolation, premise, and unsupported material. Research cannot resolve a story choice.

## Step 7 — Build downward

Move through only the scales needed:

`era -> arc -> sequence -> chapter -> scene -> prototype`

At each scale record the starting state, objective, opposition, attempts, change, downstream consequence, assumptions, risks, and next-scale target.

Use [[08 Story Loop/Templates/development-chapter-packet]] before a chapter or compressed-chapter prototype.

## Step 8 — Create only the required cast

Generate role candidates first, then Tier C/D packets. Promote only characters who survive testing or receive author approval. Names created inside Story Exploration remain placeholders unless promoted.

## Step 9 — Prototype only when useful

A 500–1,500 word development prototype is appropriate when prose-in-motion can test dialogue, explanation, chemistry, objective clarity, or emotional effect better than an outline.

Every prototype package must state:

- what it tests;
- provisional inventions;
- what worked;
- what failed;
- decisions still required.

Readable does not mean manuscript-ready. Prototype prose never establishes canon.

## Step 10 — Run only relevant critics

Choose from:

- causality;
- character;
- continuity/status;
- systems/permissions;
- Creative Interest;
- Story Fit;
- problem-solving/listener clarity;
- cost/token efficiency.

Critics diagnose their dimensions. They may repair only already-authorized issues.

## Step 11 — Author gate

Return a compact decision packet:

- surviving alternatives;
- consequences and risks;
- new assumptions;
- critic disagreements;
- exact decisions needed;
- recommended next scale.

The author may accept, reject, park, combine, rerun, research, develop further, or promote. Silence is not approval.

## Step 12 — Integrate and record

Only after approval:

- update the relevant Story Unit or compiled note with explicit status;
- update dependencies and open questions;
- record consequential decisions or contradictions in `07 QA/`;
- preserve rejected alternatives when useful;
- record a compact next state rather than the entire reasoning transcript.

Use [[08 Story Loop/Templates/development-run]] for the durable run record.

## Hard stop conditions

Stop before further expansion when:

- a load-bearing author choice is unresolved;
- sources conflict and authority is unclear;
- research is needed to distinguish viable mechanisms;
- a candidate would require canonizing a new system rule;
- the current scale does not support moving downward;
- the token mode's depth limit has been reached;
- the candidate reaches the dedicated Samuel–Konrad hierarchy boundary.

## Current containment boundary

The following are established at the current level: Konrad genuinely controlled his own city; he never considered failure; the later loss occurs in the largest empire's containment environment; Samuel remains an outsider; Samuel's earlier first-primary placement and bounded jurisdiction matter; Konrad later reactivates or migrates machinery there; the migration places it inside Samuel's jurisdiction; and the consequences help destroy the group.

The practical hierarchy, definition of primary, exact lock trigger, technical transfer, precise lie, automatic versus later powers, evidence, reset limits, and destruction chain remain unresolved. Route those questions to the dedicated piece-by-piece brainstorm. Do not use a prototype or exploration run to decide them silently.

## Success condition

The orchestrator succeeds when a broad request such as “develop this part of the Great War” produces a small context packet, prioritized gap, several cheap alternatives, one selectively deepened branch, an optional readable test, focused critic findings, and a real author decision—without context flooding or premature canon.
