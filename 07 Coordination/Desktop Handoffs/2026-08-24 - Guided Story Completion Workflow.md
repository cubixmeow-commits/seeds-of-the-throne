# Guided Story Completion Workflow — Desktop Handoff

Date: 2026-08-24
Status: Build tonight from desktop
Reference: Continue from the August 24 ChatGPT conversation about the weekly TODO dashboard and story-completion checklist.

## Goal

Create a guided workflow that walks through the Weekly Story Completion TODO from macro story architecture to micro scene-level development, using repeated Story Loop passes rather than treating checklist items as one-shot questions.

The workflow should function as the operating system for finishing *Seeds of the Throne*.

## Core principle

The TODO list supplies the work order. The guided workflow supplies the method.

The workflow must NOT take one TODO item from macro concept all the way to scene/prose completion before touching the others.

Instead, it should move horizontally across the entire active TODO list at one level of abstraction, then make another complete pass at the next level of detail.

This lets the whole story take shape together and makes cross-item dependencies, contradictions, opportunities, and thematic echoes visible before any one branch becomes overdeveloped.

## Horizontal sweep model

Think of the workflow as concentric passes across every important TODO item.

### Sweep 1 — Macro shape across all items

For every active TODO item, answer only:

- What story function does this solve?
- What changes because of it?
- Who is affected?
- What must be true before it?
- What must be true after it?
- What major dependencies connect it to other TODO items?
- What are 2–4 broad candidate directions?
- What remains unknown?

Do not fully resolve any one item unless a small author decision is required to keep the sweep coherent.

Output: a complete high-level map of how every major unresolved story problem fits into the beginning-to-end story.

### Sweep 2 — Causal architecture across all items

Return to every item and define:

- cause
- decision
- consequence
- irreversible change
- evidence created or destroyed
- control gained or lost
- belief changed
- next event forced by it

Run forward and reverse causality checks.

Output: the major causal bridges become visible across the entire story at once.

### Sweep 3 — Character and agency across all items

For every item ask:

- what each involved character knows
- what they could independently verify
- what choices are actually available
- why they choose as they do
- what it costs them
- how responsibility is preserved under manipulation
- what relationship changes

Output: character agency is synchronized across the whole plot rather than patched scene by scene.

### Sweep 4 — Systems, limits, and evidence across all items

For every relevant item define:

- actor
- channel
- permission
- resource
- blind spot
- audit trail
- failure mode
- evidence creator
- custody
- authentication
- access
- challenge
- reveal threshold

Output: technologies, Luminai, surveillance, environments, containment, and evidence operate consistently across the story.

### Sweep 5 — Sequence architecture across all items

Only after the prior sweeps are coherent, convert the story into indispensable sequences.

For each sequence establish:

- starting state
- objective
- opposition
- irreversible event
- evidence change
- belief change
- control change
- consequence that forces the next sequence

Output: an ordered sequence map with no unexplained major transitions.

### Sweep 6 — Scene architecture across all sequences

Now move horizontally through all sequences and identify the minimum necessary scenes.

Each scene must perform one or more necessary functions:

- change control
- change belief
- create evidence
- destroy evidence
- expose character
- force a choice
- establish a capability or limit
- pay off prior setup

Do not polish scenes yet.

Output: a complete scene/chapter candidate map for the whole novel.

### Sweep 7 — Scene development loops

Only after the whole scene map exists should individual scenes receive deeper loops.

For each scene:

1. establish required inputs and outputs
2. brainstorm several materially different executions
3. choose one direction
4. generate a disposable development prototype
5. run adversarial critic
6. test character agency
7. test continuity and knowledge boundaries
8. test setup/payoff
9. revise concept if necessary
10. mark scene architecture stable only when it fits the larger whole

Output: development-ready scene packets, not final prose.

### Sweep 8 — Draft-generation loop

Only after the scene structure is stable across the whole manuscript:

1. retrieve approved context
2. write prose using the Seeds prose skill
3. adversarial prose critic
4. anti-AI / variance pass
5. character-voice pass
6. continuity pass
7. author review
8. revise
9. promote approved draft

Final fiction remains author-controlled.

## Why horizontal passes matter

The purpose is not efficiency at the level of an individual task. The purpose is coherence at the level of the whole story.

A deep solution to one TODO item can become wrong once another part of the story is clarified. Horizontal passes reduce that waste.

Each sweep should expose:

- contradictions between TODO items
- shared causal mechanisms
- duplicated story functions
- missing setup/payoff relationships
- character arcs that intersect
- evidence that can serve more than one plot function
- opportunities to simplify the story

The workflow should prefer a coherent whole at 60% detail over one branch at 100% while the rest remains at 10%.

## Per-item loop inside each sweep

Each TODO item can still use mini-loops, but only to the depth appropriate for the current sweep.

A typical mini-loop:

1. Context assembly
2. Problem definition
3. Breadth generation
4. Adversarial critique
5. provisional author direction
6. record dependencies and consequences
7. move to the next TODO item

Do not fully integrate and close the task yet unless the current sweep requires that decision.

After all active items have been visited, run a whole-story cross-check before beginning the next sweep.

## Whole-story cross-check after every sweep

At the end of each pass, review the entire story and ask:

- Does the beginning still cause the middle?
- Does the middle still cause the ending?
- Are Samuel, Konrad, George, Sylvan, Orzai, and the Witness all acting from understandable information and motives?
- Are any solutions dependent on coincidence or hidden omnipotence?
- Did resolving one item invalidate another?
- Can any two mechanisms be combined into one stronger mechanism?
- Did new unanswered questions appear?
- What should be reopened before descending to more detail?

Only then begin the next level.

## Macro TODO set for the first sweep

The first horizontal pass should cover the entire current completion set, including at minimum:

1. primary contained criminal / operational responsibility
2. Sylvan startup sabotage and initiating loss
3. Sylvan–Luminai unprecedented capability and hard limit
4. employment-environment terminal rule and bounded transfer
5. Witness identity, role, artifact, custody, and transfer
6. Konrad-to-Samuel migration / false reassurance / hierarchy
7. Samuel surveillance boundaries
8. George's independent verification and refusal points
9. relative chronology anchors
10. public disclosure audience, threshold, privacy, and cost
11. cultivation safeguards and ethical distinction
12. indispensable eighty-year middle milestones
13. Orzai's independent professional refusal
14. Great War defeat and Konrad escalation
15. victory cost and final character states
16. viewpoint architecture

The purpose of Sweep 1 is not to solve all sixteen. It is to see how all sixteen fit together.

## Task-loop state model

Because work now happens by sweep, task state should track both task status and depth.

Suggested states:

- UNTOUCHED
- MACRO-MAPPED
- CAUSAL-MAPPED
- AGENCY-MAPPED
- SYSTEM/EVIDENCE-MAPPED
- SEQUENCE-INTEGRATED
- SCENE-MAPPED
- SCENE-DEVELOPED
- DRAFTED
- DONE
- REOPENED

A separate field can track whether the current pass is:

- CONTEXT
- BRAINSTORM
- CRITIC
- AUTHOR GATE
- INTEGRATE
- VALIDATE

This prevents the dashboard from implying that an item is simply “done” when it is actually only solved at one level of detail.

## Definition-of-done rule

A checkbox is not complete merely because an answer exists.

A task becomes fully DONE only when:

1. the author-approved decision is recorded;
2. downstream affected notes / units are identified;
3. the decision is integrated into the working story;
4. adversarial review finds no blocking causal failure;
5. contradictions / open questions are updated;
6. the item is represented in the sequence and scene architecture;
7. required setup/payoff and evidence are mapped;
8. the Weekly Story Completion TODO is checked off;
9. the public dashboard reflects the new progress.

Before that, the dashboard should show the deepest completed sweep rather than a binary finished state.

## Loop types

The guided workflow should be able to invoke different loops depending on the problem.

### Gap Loop

Problem → constraints → 3–5 alternatives → critic → provisional direction → dependency record.

### Causality Loop

Event A → why B follows → reverse test from B back to A → remove coincidence → validate.

### Character Agency Loop

What character knows → what character could verify → alternatives available → choice → consequence → accountability test.

### Evidence Loop

Create → preserve → authenticate → access → challenge → reveal → audience threshold.

### System Limit Loop

Capability → permission → resource → blind spot → audit trail → failure mode → exploit test.

### Sequence Loop

Starting state → objective → conflict → irreversible event → consequence → next sequence.

### Scene Loop

Required function → multiple executions → prototype → critic → revise → scene packet.

### Prose Loop

Scene packet → prose → adversarial prose critic → voice → variance / anti-AI → continuity → author revision.

## Dashboard / UI concept

The GitHub Pages Weekly TODO page can later become the front end for this workflow.

It should emphasize horizontal progress through the story.

Suggested display:

- overall story-completion percentage
- current sweep: Macro / Causal / Agency / Systems-Evidence / Sequence / Scene / Draft
- progress through current sweep: e.g. 11 of 16 items macro-mapped
- every TODO item in a grid or list with its deepest completed level
- active item within the current sweep
- unresolved dependencies discovered during the pass
- whole-story issues to revisit before next sweep
- author decisions still required
- deferred / intentionally open items

This makes it possible to visually watch the whole novel gain resolution layer by layer.

## Progress storage

Keep Markdown as the source of truth.

Possible structure:

`07 Coordination/Story Completion Workflow/`

- `WORKFLOW.md` — workflow rules and horizontal-sweep model
- `CURRENT.md` — current sweep and current item within it
- `TASK-REGISTRY.md` — all TODO items and deepest completed level
- `SWEEP-LOG.md` — summary of each complete horizontal pass
- `DECISION-LOG.md` — approved author gates
- `LOOP-LOG.md` — individual item iterations and critic results
- `UNLOCK-MAP.md` — dependency graph
- `COMPLETION.md` — high-level progress summary

Individual task packets can live under:

`07 Coordination/Story Completion Workflow/Tasks/`

Each task packet should preserve:

- objective
- source TODO item
- dependencies
- context paths
- macro model
- causal model
- agency model
- systems/evidence model
- sequence integration
- scene integration
- brainstorming outputs
- critic outputs
- author decisions
- unresolved questions
- deepest completed sweep

## Critical behavior

The system must resist both sideways expansion and premature depth.

Before adding research, lore, characters, technology, institutions, or scenes, ask:

**Does this directly help the current sweep clarify this TODO item's relationship to the whole story?**

If no, record it as a later idea and continue.

Likewise, if a macro pass starts turning into detailed scene construction, stop and record the promising detail for the appropriate later sweep.

## First workflow execution

Do NOT start by taking the containment hierarchy task all the way through the system.

Instead:

1. begin Sweep 1: Macro Shape;
2. visit the primary-contained-criminal question first;
3. establish only its macro function, dependencies, candidate directions, and unknowns;
4. move to Sylvan's initiating loss;
5. continue through every major TODO item;
6. complete a whole-story macro review;
7. only then begin Sweep 2.

The first major deliverable should therefore be a **Macro Story Completion Map** containing every TODO item in one coherent view.

## Tonight's implementation target

When back on desktop:

1. Sync local vault from GitHub.
2. Read this handoff plus `12 Weekly Story Completion Todo.md` and the August 24 chat.
3. Build the Story Completion Workflow folder and templates.
4. Convert the weekly completion TODO into the horizontal task registry.
5. Create `CURRENT.md` with `Current Sweep: Macro Shape` and the first TODO item.
6. Build a reusable per-item macro-pass template.
7. Build `SWEEP-LOG.md` and a whole-story cross-check template.
8. Run the macro sweep across every major TODO item before deepening any one item.
9. Connect each item's deepest completed level back to the weekly TODO/dashboard.
10. If practical, expose sweep progress through the planned GitHub Pages TODO dashboard.

The objective is not to finish one problem at a time. It is to progressively increase the resolution of the entire story until the whole novel moves together from architecture to sequences to scenes to final prose.
