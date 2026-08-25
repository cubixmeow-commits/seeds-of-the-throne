# Guided Story Completion Workflow — Desktop Handoff

Date: 2026-08-24
Status: Build tonight from desktop
Reference: Continue from the August 24 ChatGPT conversation about the weekly TODO dashboard and story-completion checklist.

## Goal

Create a guided workflow that walks through the Weekly Story Completion TODO from macro story architecture to micro scene-level development, using repeated Story Loop passes rather than treating checklist items as one-shot questions.

The workflow should function as the operating system for finishing *Seeds of the Throne*.

## Core principle

The TODO list supplies the work order. The guided workflow supplies the method.

Never jump directly from an unresolved story problem to polished prose. Every significant item moves through multiple controlled loops:

1. Context assembly
2. Problem definition
3. Breadth generation
4. Adversarial critique
5. Author decision
6. Causal integration
7. Continuity validation
8. Prototype / scene testing when appropriate
9. Second adversarial pass
10. Promotion into working story authority
11. Update TODO and progress dashboard
12. Advance to the next unlocked task

A task may loop backward as many times as needed.

## Macro-to-micro hierarchy

The workflow should move through levels in order and only descend when the upper level is stable enough.

### Level 1 — Story architecture

Resolve the load-bearing causal structure:

- containment hierarchy and primary responsibility
- Sylvan's initiating loss
- Sylvan–Luminai capability and hard limit
- evidence chain and custody
- eighty-year causal spine
- final trap / proof mechanism
- victory cost and aftermath

Output: a complete beginning-to-end causal story that can survive adversarial questioning.

### Level 2 — Era / sequence architecture

Break the story into indispensable sequences and historical phases.

For each sequence establish:

- starting state
- protagonist / antagonist objective
- irreversible event
- evidence created or destroyed
- belief changed
- control gained or lost
- consequence that forces the next sequence

Output: ordered sequence map with no unexplained major transitions.

### Level 3 — Character arc architecture

For each major character, align:

- desire
- false belief / defensive model
- available evidence
- meaningful choices
- escalating cost
- irreversible decisions
- relationship changes
- final state

Characters must retain agency even when manipulated.

Output: character arcs synchronized to the sequence map.

### Level 4 — Evidence / foreshadowing architecture

For every endgame proof or revelation define:

- creator
- creation event
- custody
- authentication
- blind spots
- attempted suppression
- rediscovery
- who can legitimately access it
- who must believe it
- privacy limitations

Then seed those elements earlier.

Output: evidence chain that makes the ending earned rather than convenient.

### Level 5 — Scene architecture

Convert each approved sequence into scene candidates.

Each scene must perform one or more necessary functions:

- change control
- change belief
- create evidence
- destroy evidence
- expose character
- force a choice
- establish a capability or limit
- pay off prior setup

Scenes without causal work should be challenged or removed.

Output: scene map / chapter candidate structure.

### Level 6 — Scene development loops

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
10. only then mark scene architecture stable

Output: development-ready scene packet, not final prose.

### Level 7 — Draft-generation loop

Only after scene structure is stable:

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

## Task-loop state machine

Every TODO item should visibly have one state:

- LOCKED — dependency unresolved
- READY — safe to begin
- CONTEXT — assembling relevant vault material
- BRAINSTORM — generating alternatives
- CRITIC — adversarial testing
- AUTHOR GATE — waiting for author decision
- INTEGRATE — propagating decision through story
- VALIDATE — continuity / causality testing
- PROTOTYPE — testing through scene or artifact
- DONE — definition of done satisfied
- REOPENED — later work exposed a problem

The workflow should automatically show why a locked task is locked and what completing the current task unlocks.

## Definition-of-done rule

A checkbox is not complete merely because an answer exists.

A task becomes DONE only when:

1. the author-approved decision is recorded;
2. downstream affected notes / units are identified;
3. the decision is integrated into the working story;
4. adversarial review finds no blocking causal failure;
5. contradictions / open questions are updated;
6. the Weekly Story Completion TODO is checked off;
7. the public dashboard reflects the new progress.

## Loop types

The guided workflow should be able to invoke different loops depending on the problem.

### Gap Loop

Problem → constraints → 3–5 alternatives → critic → author gate → integration.

### Causality Loop

Event A → why B follows → reverse test from B back to A → remove coincidence → validate.

### Character Agency Loop

What character knows → what character could verify → alternatives available → choice → consequence → accountability test.

### Evidence Loop

Create → preserve → authenticate → access → challenge → reveal → audience threshold.

### System Limit Loop

Capability → permission → resource → blind spot → audit trail → failure mode → exploit test.

### Scene Loop

Required function → multiple executions → prototype → critic → revise → scene packet.

### Prose Loop

Scene packet → prose → adversarial prose critic → voice → variance / anti-AI → continuity → author revision.

## Dashboard / UI concept

The GitHub Pages Weekly TODO page can later become the front end for this workflow.

Suggested display:

- overall story-completion percentage
- current level (Macro / Sequence / Character / Evidence / Scene / Draft)
- current active task
- why this task matters
- dependencies
- what it unlocks
- current loop stage
- definition of done
- completed loops / number of iterations
- author decisions still required
- next three unlocked tasks
- deferred / intentionally open items

The public view can be simpler, while the vault contains the complete working state.

## Progress storage

Keep Markdown as the source of truth.

Possible structure:

`07 Coordination/Story Completion Workflow/`

- `WORKFLOW.md` — workflow rules
- `CURRENT.md` — active task and current loop
- `TASK-REGISTRY.md` — all TODO tasks, dependencies, states, definitions of done
- `DECISION-LOG.md` — approved author gates
- `LOOP-LOG.md` — iterations and critic results
- `UNLOCK-MAP.md` — dependency graph
- `COMPLETION.md` — high-level progress summary

Individual task packets can live under:

`07 Coordination/Story Completion Workflow/Tasks/`

Each task packet should preserve:

- objective
- source TODO item
- dependencies
- context paths
- unresolved question
- brainstorming outputs
- critic outputs
- author decision
- integration targets
- validation results
- status
- completion date

## Critical behavior

The system must resist sideways expansion.

Before adding research, lore, characters, technology, institutions, or scenes, ask:

**Does this directly help satisfy the active task's definition of done?**

If no, record it as a later idea and continue the active loop.

## First workflow task

Start with the current highest-leverage item:

**What operational responsibility or relationship makes one contained criminal the primary rather than merely present?**

Run it through the full macro Gap Loop before moving to Samuel's later lock, acquisition, migration powers, or reset limits.

After that task is integrated and validated, allow the dependency graph to unlock the next appropriate work.

## Tonight's implementation target

When back on desktop:

1. Sync local vault from GitHub.
2. Read this handoff plus `12 Weekly Story Completion Todo.md` and the August 24 chat.
3. Build the Story Completion Workflow folder and templates.
4. Convert the weekly completion TODO into a dependency-aware task registry.
5. Create `CURRENT.md` pointing at the first containment-hierarchy task.
6. Build the first reusable loop packet / task template.
7. Connect task completion back to the weekly TODO.
8. If practical, expose workflow progress through the planned GitHub Pages TODO dashboard.

The objective is not to automate authorship. It is to make it difficult to lose the thread, skip causal work, or prematurely jump into prose while moving steadily from the macro story to finished scenes and eventually the final manuscript.
