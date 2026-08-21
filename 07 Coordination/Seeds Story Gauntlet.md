---
type: coordination-system
status: highest-priority-design
updated: 2026-08-20
---

# Seeds Story Gauntlet

## Purpose

Design an author-led agentic loop that systematically finishes *Seeds of the Throne* from the material already in the vault. This is inspired by the current Gauntlet Loop pattern: decompose work, build, send it through independent critics, revise, integrate, and repeat. The fiction version must preserve author authority and must optimize for story completion rather than autonomous invention.

The target is not "make the vault richer." The target is:

> Produce a complete, causal, character-driven story map from beginning to ending, with every unresolved creative decision either explicitly resolved by the author or clearly marked unresolved, then compile that map into sequences, scenes, and finally prose.

## Governing principle

**Author brainstorm -> agents structure -> agents challenge -> agents integrate -> vault updates -> next author brainstorm.**

Agents may identify gaps, retrieve evidence, test causality, surface contradictions, research mechanisms, compare structural options, and propose possibilities. They may not silently invent unresolved story facts or promote research/speculation to canon.

## Core loop

1. **Author Input**
   - Accept an unstructured brainstorming session.
   - Preserve the raw idea.
   - Extract new story facts, possible consequences, affected components, and newly created questions.
   - Do not rewrite the brainstorm into prose as the primary action.

2. **Relevant-Vault Retrieval**
   - Retrieve only the characters, systems, events, environments, reveals, timeline notes, QA decisions, and open questions touched by the brainstorm.
   - Respect source authority and status.
   - Prefer modifying existing live story structures over creating duplicate parallel notes.

3. **Story Architect**
   - Ask where the new material belongs in the existing story.
   - Build or extend the causal chain around it.
   - Identify missing arrows between established events.
   - Convert gaps into explicit author-facing questions.
   - Never solve a creative gap merely because a plausible answer is available.

4. **Character Logic Passes**
   - Run major affected characters independently.
   - For each character, evaluate current desire, belief, knowledge, fear, expectation, resources, constraints, and recent state changes.
   - Test whether the proposed action follows from the established character state.
   - If it does not, report a character-logic failure and identify the missing bridge rather than rewriting the character.

5. **Causality Gauntlet**
   - Try to break the proposed development.
   - Ask why this happens now, why it did not happen earlier, what causes the next event, whether coincidence is carrying the plot, whether an easier solution invalidates the conflict, and whether information has a plausible path.
   - Critic identifies failures only; it does not silently repair them.

6. **Continuity Gauntlet**
   - Check timeline, knowledge state, technology limits, character history, world rules, established decisions, and source authority.
   - Detect contradictions and unsupported capability growth.
   - Protect the ordinary surface-world principle and other load-bearing constraints.

7. **Story-Structure Gauntlet**
   - Evaluate whether the material functions as a novel rather than merely as lore.
   - At the sequence level ask: what does the character want, what prevents it, what changes, what new problem results, and why must the reader continue?
   - At the whole-story level use multiple structural theories as diagnostic lenses rather than commandments.
   - Structural models may identify missing functions but must not force Seeds into a generic beat sheet.

8. **Research Agent — only when needed**
   - Activate only for externally groundable questions.
   - Return: supported, plausible extrapolation, premise, unsupported.
   - Research never creates canon by itself.

9. **Integration Agent**
   - Summarize exactly what changed in the cycle.
   - Separate accepted material, unresolved questions, and affected vault files.
   - Update only approved/developmental destinations according to authority rules.
   - Maintain one master completion structure rather than proliferating competing versions.

10. **Author Gate**
   - Stop before unresolved creative questions become story facts.
   - Present the highest-value unresolved decisions to the author for brainstorming.
   - The author's answers seed the next loop.

## Story quality bar

A story component passes the gauntlet when:

- it does not contradict established canon or stronger-authority material;
- major actions follow from character state;
- major events have identifiable causes;
- major events produce meaningful consequences;
- required information has a plausible route between actors;
- technology and story systems do not gain unexplained capabilities;
- unresolved author decisions are not silently filled in;
- the component advances at least one major character or plot trajectory;
- its location in the master storyline is identifiable;
- ordinary surface reality remains credible;
- the eventual reader-facing reveal can be staged without relying on an exposition dump.

## Completion pressure

Every proposed task or new idea should be classified as one of:

1. **CLOSE A GAP** — highest priority.
2. **STRENGTHEN EXISTING STRUCTURE** — second priority.
3. **NEW EXPANSION** — lowest priority until the story map is complete.

The orchestrator should repeatedly ask:

> Does this materially help finish the story?

If not, park it rather than letting the loop expand the universe indefinitely.

## Master artifact: STORY-MAP.md

Design one central completion graph, likely `02 Story/STORY-MAP.md` or a similarly authoritative working location, containing the complete causal spine.

Each node should minimally include:

- stable ID;
- event/sequence label;
- status: missing | partial | working | resolved;
- cause/preconditions;
- principal character owner(s);
- key belief/knowledge state before;
- event/action;
- resulting state change;
- downstream dependency;
- unresolved decisions;
- linked vault evidence.

Example structure:

```text
S01 — Sylvan's ordinary-life opening
status: partial

S02 — Modern inciting event
status: MISSING
blocking: S03, S04

S03 — Sylvan investigates
status: partial

S04 — Witness evidence reaches Sylvan
status: partial
missing: transfer mechanism

...

S21 — Samuel believes Sylvan is trapped
status: partial

S22 — Inverted containment closes
status: working

S23 — Samuel and George expose themselves
status: partial

S24 — Public disclosure
status: incomplete

S25 — Final character states
status: MISSING
```

The system should be able to identify the highest-leverage unresolved node by dependency impact and present that as the next brainstorming target.

## Brainstorm targeting

Instead of asking the author a generic "what should we brainstorm?", the loop should surface one or a small set of highest-value blockers.

Example:

**Current highest-value unresolved node:** S02 — Sylvan's modern inciting event

Why it matters:
- blocks protagonist trajectory;
- blocks narrated opening;
- blocks Witness-evidence sequencing;
- prevents scene planning.

Known constraints:
- ordinary surface reality must be established;
- Sylvan is already succeeding inside the system;
- Luminai development is underway;
- inherited evidence threatens the future he is earning.

The author then brainstorms freely against that target.

## Operating modes

The same philosophy should change resolution as the story matures.

### Phase 1 — Story completion
`brainstorm -> resolve causal nodes`

### Phase 2 — Sequence completion
`story nodes -> dramatic sequences`

### Phase 3 — Scene completion
`sequence -> scene specifications`

### Phase 4 — Drafting
`scene specification -> prose`

### Phase 5 — Prose gauntlet
`writer -> continuity critic -> Seeds prose critic -> anti-AI prose critic -> revision`

The loop should not advance to the next phase until the current phase reaches a defined completion threshold.

## Current Seeds-specific application

The initial Story Gauntlet should operate on the already established completion priorities rather than inventing a new outline from scratch:

- narrated opening;
- Sylvan's modern inciting event and full trajectory;
- Witness-to-Sylvan evidence bridge;
- essential False Victory bridge events;
- George's chronology, beliefs, and role progression;
- Samuel's revenge-to-replacement transition;
- the inverted obsession/expectation/desperation containment trap;
- the symmetry by which Samuel and George's earlier manipulation method becomes their final vulnerability;
- public disclosure trigger;
- cost of victory;
- final character states.

## Design questions for tonight

1. Exact location and authority level of the master `STORY-MAP.md`.
2. Node schema and statuses.
3. How the loop ranks unresolved nodes by leverage/dependency.
4. Which agents are separate fresh-context critics versus one orchestrator with isolated passes.
5. Exact author-gate behavior and how questions are queued for ride-home brainstorming.
6. What an agent may update automatically versus what requires explicit author approval.
7. How the loop uses existing `03 Context/OPEN-QUESTIONS.md`, `07 QA/Questions.md`, `07 QA/Contradictions.md`, and `07 QA/Decisions.md` without duplicating them.
8. Maximum iteration count before a failed node escalates back to the author.
9. Pass/fail rubric for story nodes, sequences, scenes, and prose.
10. How research findings are attached to nodes without becoming canon.
11. How raw brainstorming is preserved and linked to subsequent decisions.
12. How completion metrics are shown without incentivizing shallow box-checking.

## Definition of success

The Story Gauntlet succeeds when the complete story can be followed from beginning to ending as an unbroken chain of character-driven causes and consequences, and no blocking creative decision has been silently invented by an agent.

At that point, worldbuilding expansion stops by default and the system compiles the completed story map into sequences and scenes.
