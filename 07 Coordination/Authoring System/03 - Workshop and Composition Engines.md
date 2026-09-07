---
type: engine-design
status: proposed
updated: 2026-09-07
---

# Workshop and Composition Engines

## Shared orchestration contract

Both engines receive a bounded context packet from the runtime and return proposed events or artifacts. Neither directly edits canon. The integrator validates a confirmed result, appends its decision event, rebuilds affected projections, runs selected regressions, and produces the next pickup.

## Workshop Engine

### Purpose

Turn a complicated unfinished story into the next answerable, high-leverage author decision, then preserve and propagate the accepted result.

### Internal roles

1. **Intake interpreter:** preserves raw material and extracts candidate assertions without promoting them.
2. **Story diagnostician:** finds structural, causal, character, system, research, and reader-experience gaps.
3. **Dependency planner:** orders gates so one answer unlocks many others.
4. **Interviewer:** asks one natural question calibrated to the author's energy and chosen mode.
5. **Option designer:** supplies genuinely different possibilities and consequences when requested.
6. **Adversarial tester:** looks for weak logic, erased agency, false stakes, and convenient systems.
7. **Decision recorder:** reflects the answer and obtains explicit acceptance.
8. **Integrator:** creates events, computes blast radius, validates, and updates pickup state.

### Question priority

The initial proposed score is:

`priority = downstream impact + blocking power + author-only judgment + emotional importance + current answerability - fatigue cost - premature-detail risk`

The formula should become configurable and evidence-tested. It must never pretend numerical precision equals creative certainty.

### Workshop packet

Each gate contains:

- plain-language question and why it matters;
- relevant accepted facts and sources;
- contradiction or missing link;
- prerequisites;
- three to five distinct options only when useful;
- consequences and tradeoffs;
- a concrete scene that tests the answer;
- an adversarial question;
- affected records;
- confirmation wording;
- defer/reframe behavior.

### Output

One of: accepted decision event, corrected understanding, deferred gap, rejected proposal, disputed existing decision, or scoped research request. A workshop answer is not complete until propagation and validation succeed.

## Composition Engine

### Purpose

Transform approved story state into effective prose while making every important invention inspectable and returning structural discoveries to the Workshop Engine.

### Pipeline

1. **Readiness gate:** confirm the sequence and scene are stable enough for the requested mode.
2. **Context builder:** retrieve the smallest relevant subgraph, not the entire vault.
3. **Scene architect:** create an inspectable contract with objective, obstacle, turn, choice, resulting state, knowledge, and revelation.
4. **Draft generator:** produce one or more bounded candidates using only allowed facts and visible working assumptions.
5. **Developmental editor:** test purpose, pressure, causality, agency, order, stakes, and emotional movement.
6. **Continuity checker:** test timeline, knowledge, location, objects, abilities, systems, relationships, setup, and payoff.
7. **Narrative-residue critic:** test for over-tidiness, flattened ambiguity, moral simplification, uniform voices, and model-convenient plotting.
8. **Voice and prose editor:** apply narrator/character voice, controlled variance, tracks cleanup, and anti-generic checks.
9. **Line editor and read-aloud check:** improve clarity, rhythm, diction, and auditory flow without changing story state.
10. **Author review:** accept, revise, combine, reject, or reopen a story gate.
11. **Assembler:** promote only approved prose into manuscript order and regenerate exports.

### Draft modes

| Mode | Use | Authority |
|---|---|---|
| Exploratory prototype | test a story possibility | disposable, non-canon |
| Scene candidate | render an approved contract | proposed prose |
| Revision candidate | improve existing prose | proposed replacement |
| Manuscript candidate | passed required checks | awaits author approval |
| Approved manuscript | accepted final text for current version | authoritative prose, still versioned |

### Return-to-workshop triggers

Composition stops and opens a gate when drafting exposes:

- a required motive, rule, relationship, cost, or outcome not approved;
- two accepted facts that cannot coexist;
- a character acting on knowledge they cannot possess;
- suspense that depends on hiding something the POV must naturally notice;
- stakes that vanish under an established capability;
- a scene that cannot produce its required resulting state without coincidence;
- a prose improvement that would materially alter story meaning.

## Context packet contract

Every model call should receive:

- task and mode;
- authority policy;
- approved facts relevant to the task;
- character knowledge at that moment;
- chronology and revelation constraints;
- voice rules and examples;
- forbidden inventions and unresolved gates;
- exact expected output schema.

This replaces “load the whole vault and hope” with bounded, inspectable context.

## Model strategy

Use a capable model for diagnosis, synthesis, structural judgment, and difficult prose. Use cheaper models for bounded transformations only after evaluation proves them reliable. Deterministic checks should run before paying for model review. Model routing is an optimization layer, not part of story authority.

The detailed lean routing and capability ownership plan is [[05 - Prose Capability Matrix and Usage Routing]]. The default scene route uses one draft and at most one automated revision before author review; specialist passes are risk-triggered rather than automatic.

## Failure behavior

- If confidence is low, ask or defer; do not smooth over uncertainty.
- If persistence fails, keep the answer visibly unsaved and provide export.
- If integration partially fails, preserve the accepted event and mark projections stale.
- If a model violates the contract, reject the artifact without altering story state.
- If a new answer has broad impact, show the consequence before reopening dependent work.
