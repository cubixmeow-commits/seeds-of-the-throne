---
type: development-system
status: active
updated: 2026-08-21
scope: token-aware recursive development from large structure to story prototype
---

# Multiscale Development Gauntlet

## Purpose

Create a development loop that does more than polish the same text repeatedly.

The Multiscale Development Gauntlet should **build story downward from larger structure to finer structure**, using critics appropriate to each scale, while remaining affordable enough to run frequently.

Primary flow:

`retrieve -> map gap -> generate alternatives -> critique -> select working candidate -> expand one scale -> critique -> expand one scale -> simulate -> author gate`

Use [[08 Story Loop/GAP-ANALYZER]] for the initial map and [[08 Story Loop/DEVELOPMENT-ORCHESTRATOR]] for routing and stop conditions. Record new runs with [[08 Story Loop/Templates/development-run]].

The loop should spend tokens where uncertainty is highest rather than generating large amounts of prose prematurely.

## Core rule

**Do not solve a scene-level problem with novel-scale context, and do not solve an arc-level problem by rewriting paragraphs.**

Every run declares its current scale.

## Scales

### Scale 0 — Era / historical phase

Questions:

- What changes across this period?
- Who holds power at the beginning and end?
- What irreversible events are required?
- What major causal transitions are missing?
- Which characters or institutions carry the period?

Output:

- 3–8 candidate event spines;
- major required characters/functions;
- unresolved dependencies.

### Scale 1 — Arc

Questions:

- What does the central character/institution want?
- What prevents it?
- How does pressure escalate?
- What changes them or their position?
- What is the payoff?

Output:

- 5–12 beat arc;
- character roles;
- setup/payoff links;
- possible variants.

### Scale 2 — Sequence

Questions:

- What concrete problem drives these chapters?
- What attempts are made?
- What changes after each attempt?
- What new information becomes available?

Output:

- 3–7 sequence beats;
- location/participant requirements;
- event dependencies.

### Scale 3 — Chapter

Questions:

- What is the chapter's immediate objective?
- Whose viewpoint best reveals it?
- Which supporting characters are needed?
- What state change ends the chapter?

Output:

- chapter card;
- 3–6 scene functions;
- character packets;
- reveal/turn.

### Scale 4 — Scene

Questions:

- What does the viewpoint character want right now?
- What prevents it?
- What do they try?
- What does the reader learn by watching the attempt?
- What changes?

Output:

- scene skeleton;
- dialogue conflict;
- concrete actions;
- development assumptions.

### Scale 5 — Development prototype

Render the scene or compressed chapter with [[08 Story Loop/DEVELOPMENT-PROTOTYPE-STYLE]].

Output usually 500–1,500 words.

Purpose:

**test the idea as experienced story.**

### Scale 6 — Final prose

Separate later workflow.

Do not enter this scale merely because a prototype is readable.

## Roles

### Context Retriever
Pull only the canon, working material, and unresolved questions needed for the run.

### Gap Mapper
State exactly what is missing at the current scale.

### Divergent Architect
Generate genuinely different candidate solutions.

### Character Builder
Generate only the character depth required for candidates under test.

### Causality Critic
Find missing causal bridges, arbitrary coincidences, and solutions without costs.

### Character Critic
Check decisions against motives, knowledge, status, competence, and pressure.

### Continuity Critic
Compare with established vault material.

### System Critic
Check technology, containment, Luminai, permissions, evidence, institutional mechanics, chronology, etc.

### Creative Interest Critic
Check scene potential, surprise, pressure, reversals, memorable situations, and curiosity.

### Listener/Clarity Critic
Check whether the candidate can eventually become clear readable/audible story.

### Cost Critic
Ask whether a proposed solution requires too many new assumptions, new characters, or new systems compared with its value.

### Integrator
Produces the compact working candidate for the next scale.

### Author Gate
Only the author accepts, rejects, combines, parks, or promotes.

## Token-aware operating modes

### Micro Run — cheapest

Use for one narrow unresolved question.

Budget behavior:

- retrieve compact context;
- generate 3 options;
- run 2–3 relevant critics;
- recommend one next question;
- no prose unless explicitly requested.

### Standard Run

Use for one chapter/sequence problem.

- 4–6 alternatives;
- expand top 2;
- 4–6 critic lenses;
- optional 500–900 word prototype of top candidate.

### Deep Run

Use for major arc or historical phase.

- retrieve larger context packet;
- build 5–10 candidate directions;
- select top 3;
- character requirements;
- full critics;
- mutation/combinations;
- produce one candidate spine and one prototype scene;
- stop for author gate.

### Cascade Run

Use when the author explicitly wants to go from large structure to story sample in one run.

Example:

`Great War gap -> 3 era spines -> select strongest working spine -> 8-beat arc -> choose one sequence -> chapter card -> generate needed supporting characters -> 800-word prototype -> critics -> author gate`

The cascade should follow **one branch downward**, not fully expand every alternative at every scale.

This is crucial for token affordability.

## Token conservation rules

1. **Retrieve narrowly.** Do not dump the entire vault into every pass.
2. **Summarize accepted context once per run.** Critics share the same compact packet.
3. **Generate breadth cheaply, depth selectively.** Five one-paragraph options are cheaper than five scenes.
4. **Expand only survivors.** Weak candidates should die before prose.
5. **Do not ask every critic every question.** Use the critics relevant to the uncertainty.
6. **Record deltas.** Later passes need what changed, not the entire previous reasoning transcript.
7. **Prototype one representative scene.** Do not draft every chapter just to test an arc.
8. **Reuse character packets.** Do not regenerate established supporting characters each pass.
9. **Stop at author decisions.** Do not spend tokens solving branches that depend on an unresolved author choice.
10. **Final prose is expensive.** Keep it out of routine development runs.

## Candidate state format

At each scale maintain a compact state:

### Established inputs
Facts that cannot be contradicted.

### Working assumptions
Temporary supports required by the candidate.

### Current candidate
The structure being tested.

### Open risks
Known weak points.

### Required author decisions
Questions the loop cannot legitimately resolve.

### Next-scale target
Exactly what should be expanded next.

This state is passed forward instead of the full chat history.

## Example cascade — Great War

### Scale 0
Gap: exact Great War story structure weak.

Generate several high-level collapse models.

### Scale 1
Choose one working model:

`early triumph -> overextension -> information distortion -> internal self-attack -> irreversible strategic failure -> defeat -> containment transition`

### Scale 2
Select one sequence, e.g. logistics collapse around a major city.

### Scale 3
Create chapter:

- viewpoint: logistics coordinator or commander;
- objective: preserve final transport corridor;
- conflict: military, political, and dynastic priorities compete;
- Samuel's input: potentially true information delivered at damaging timing;
- end: corridor lost.

### Character Factory
Generate 2–4 people needed for chapter.

### Scale 5
Write 800-word prototype.

### Critics
Ask:

- Did the scene make the institutional failure understandable?
- Did Samuel accelerate rather than magically cause it?
- Did Konrad's ideology create the decision pressure?
- Did the supporting characters feel alive?
- Was the chapter readable by ear?

Then stop.

## Comparative prototype testing

When two mechanisms both look promising, do not debate them forever in outline form.

Generate matched short prototypes.

Example:

**Version A:** Konrad receives bad information because subordinates fear him.

**Version B:** Konrad receives accurate information but interprets it through ideology.

Use the same approximate scene length and objective.

Compare:

- character pressure;
- originality;
- clarity;
- long-range consequences;
- compatibility with canon;
- which version produces more future story.

The author can then judge experienced story rather than abstract description.

## Chapter-building packet

Before generating a development chapter, assemble only:

- chapter function;
- viewpoint;
- immediate objective;
- starting state;
- ending state;
- 2–5 necessary characters;
- relevant canon constraints;
- one central mechanism/reveal;
- unresolved details allowed to remain provisional.

Then prototype.

Reusable form: [[08 Story Loop/Templates/development-chapter-packet]].

## Failure modes

### F1 — Prose treadmill
The system rewrites the same paragraph repeatedly without improving the story.

Countermeasure: move back up one scale and diagnose structure.

### F2 — Context flood
Too much vault content consumes tokens and dilutes relevance.

Countermeasure: build a scoped context packet.

### F3 — Infinite branching
Every idea receives full development.

Countermeasure: breadth first, rank, expand survivors only.

### F4 — Character inflation
Every temporary person receives a novel-length biography.

Countermeasure: use Character Factory tiers.

### F5 — Premature canon
A coherent AI-generated candidate is mistaken for established story.

Countermeasure: explicit author gate after every major run.

### F6 — Premature final prose
Time is spent polishing scenes whose causal structure is still changing.

Countermeasure: development prototype style by default.

### F7 — Critic homogenization
Critics all repeat the same general comments.

Countermeasure: each critic has a narrow failure domain and reports only actionable defects.

### F8 — Token-expensive self-dialogue
Generator and critics restate the entire candidate repeatedly.

Countermeasure: use compact candidate state and delta notes.

## Suggested run output

### Run target

### Current scale

### Context packet

### Gap

### Candidate alternatives

### Shortlist

### Critic findings

### Working candidate

### New characters required

### Next-scale expansion

### Prototype (optional)

### Author gate

### Token-saving notes for next run

## Success condition

The system succeeds when it can take a weakly developed section of Seeds and, without enormous context or premature novel drafting, progressively turn it into:

- a strong causal structure;
- a functioning cast;
- chapter/scene architecture;
- readable development story;
- clear alternatives for author judgment;
- a compact record that can be continued later.
