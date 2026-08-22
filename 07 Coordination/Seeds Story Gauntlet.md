---
type: coordination-system
status: active
version: 0.2
updated: 2026-08-21
---

# Seeds Story Gauntlet

## Implementation status

Version 0.2 is implemented as a manual, Markdown-first development system under `08 Story Loop/`.

1. Open [[07 Coordination/CURRENT-PICKUP]].
2. Follow [[08 Story Loop/DEVELOPMENT-ORCHESTRATOR]].
3. Use [[08 Story Loop/GAP-ANALYZER]] on the selected unit or area.
4. Choose the smallest useful token mode and current scale.
5. Route to exploration, research, multiscale structure, characters, prototypes, and critics only as needed.
6. Stop at every author gate.
7. Record the run under `08 Story Loop/Runs/`.

The current active author packet is [[08 Story Loop/Brainstorms/Samuel-Konrad Containment Hierarchy - Needs Analysis]]. The next session begins with its first practical-hierarchy question and may not infer later mechanics.

> Build. Attack. Resolve. Integrate. Advance.

## Purpose

Design an author-led agentic loop that systematically finishes *Seeds of the Throne* from the material already in the vault. This is inspired by the current Gauntlet Loop pattern: decompose work, build, send it through independent critics, revise, integrate, and repeat. The fiction version must preserve author authority and must optimize for story completion rather than autonomous invention.

The target is not "make the vault richer." The target is:

> Produce a complete, causal, character-driven story map from beginning to ending, with every unresolved creative decision either explicitly resolved by the author or clearly marked unresolved, then compile that map into sequences, scenes, chapters, and finally prose.

The system should be simple enough to live primarily in Markdown inside the Obsidian vault. Do not introduce a database or elaborate orchestration layer until repeated real use proves that Markdown, links, frontmatter, search, and Git history are insufficient.

## Governing principle

**Author brainstorm -> agents structure -> agents challenge -> agents revise -> agents integrate -> vault updates -> next author brainstorm.**

Agents may identify gaps, retrieve evidence, test causality, surface contradictions, research mechanisms, compare structural options, and propose possibilities. They may not silently invent unresolved story facts or promote research/speculation to canon.

The system is both a story-development process and an experiment in whether repeated, specialized AI critique can produce materially better story structure and prose than a single-pass generation workflow.

## Three-layer architecture

### Layer 1 — Story Skeleton

First convert the existing vault into a linear, incomplete-but-readable skeleton from beginning to ending.

Each story unit receives a stable ID such as `S-001`, `S-002`, `S-003` and records only what is needed to understand its role in the causal chain.

A Story Unit should minimally contain:

- stable ID and title;
- status: missing | partial | working | resolved;
- what happens;
- principal character owner(s);
- character state entering;
- important goals/expectations entering;
- conflict or resistance;
- information revealed or concealed;
- event/action;
- resulting state change;
- consequence / what this enables next;
- dependencies on earlier units;
- downstream nodes blocked by this unit;
- unresolved author questions;
- linked vault evidence.

Example:

```markdown
# S-021 — Samuel Believes Sylvan Is Contained

Status: partial

## Entering State
Samuel believes he has discovered a mechanism for isolating Sylvan.

## Goal
Trap Sylvan inside a controlled simulated environment and humiliate him.

## Conflict
Sylvan understands Samuel's expectations and is manipulating the apparent operation.

## Outcome
Samuel commits further resources and exposes hidden participants.

## State Change
Samuel believes his control has increased.
Actual control has decreased.

## Requires
- obsession mechanism established
- Samuel's earlier use of expectation against contained criminals
- Sylvan's understanding of Samuel

## Missing
- exact entry mechanism
- George's role
- what Samuel sees as proof of success
```

The skeleton pass must classify the existing story as **complete / partial / missing / contradictory / blocked** without filling missing creative answers automatically.

### Layer 2 — Story Development Gauntlet

For an incomplete or weak Story Unit, the system prepares a Brainstorm Packet before asking the author to create anything.

A Brainstorm Packet should contain:

- what is already established;
- why this unit exists;
- what precedes it;
- what must follow it;
- involved characters and their current state;
- relevant world/system rules;
- relevant research;
- contradictions or continuity hazards to avoid;
- exact unresolved questions;
- why resolving this unit matters to overall completion.

The author then provides an unstructured brainstorming session. The system preserves the raw brainstorm and extracts decisions, possibilities, and unresolved questions without treating every speculative sentence as canon.

The first practical Gauntlet should be intentionally small:

1. **Architect** — converts the brainstorm into a coherent Story Unit proposal and places it in the existing causal chain.
2. **Character Critic** — tests whether actions follow from established motives, beliefs, knowledge, fears, expectations, resources, and constraints.
3. **Causality Critic** — attacks every important causal link, easier alternative, coincidence, timing issue, and information path.
4. **Continuity Critic** — checks timeline, established decisions, technology/system limits, character history, and vault authority.
5. **Integrator** — revises from accepted criticism, records what changed, and returns unresolved creative choices to the author.

The builder must not be its own final judge. Critics should be isolated enough that they do not merely rationalize the builder's proposal.

### Layer 3 — Prose Gauntlet

This comes only after enough of the Story Skeleton has been resolved to compile reliable scenes and chapters.

Pipeline:

`scene specification -> draft -> story-function critic -> character/dialogue critic -> continuity critic -> prose/style critic -> AI-pattern critic -> revision -> fresh critic -> final candidate`

Do not use a single vague "is this good?" judge. Each critic must have a narrow, concrete responsibility.

## Story quality and prose quality are separate

A beautiful paragraph can sit on top of a broken story. A strong scene can be written badly. The loop must therefore evaluate story before prose.

### Story-quality checks

- causal;
- character-driven;
- necessary or meaningfully consequential;
- surprising but retrospectively plausible;
- consistent with established knowledge states;
- emotionally motivated;
- advances a larger trajectory;
- produces a meaningful state change;
- establishes or pays off something elsewhere;
- avoids unsupported coincidence or capability growth.

### Prose-quality checks

Develop these experimentally from project-specific examples, but likely include:

- clarity;
- rhythm and sentence-length variation with purpose;
- specificity;
- subtext;
- selective sensory detail;
- distinct dialogue;
- paragraph movement;
- exposition control;
- avoidance of repetitive AI rhetorical templates;
- no explaining after the image or emotional beat has already landed;
- preservation of ambiguity where the story benefits from it;
- Seeds-specific voice and tone.

## Calibration from admired books and audiobooks

The author may provide short excerpts, descriptions, or observations from books/audiobooks whose storytelling worked especially well.

The system should extract transferable craft characteristics rather than imitate a living author's style or reproduce copyrighted text. Possible measurements/observations include:

- scene speed despite low physical action;
- dialogue/exposition balance;
- perspective distance;
- paragraph-length variation;
- concrete action density;
- information withheld;
- placement of description;
- state changes per scene;
- use of subtext;
- setup/payoff spacing;
- narration-to-dialogue transitions.

These observations should become project-specific quality criteria in `QUALITY-BAR.md` and critic instructions.

## Suggested Markdown-first vault structure

Exact placement is a design decision for the desktop session, but the preferred simple shape is:

```text
08 Story Loop/
    README.md
    STORY-MAP.md
    QUALITY-BAR.md

    Units/
        S-001.md
        S-002.md
        S-003.md

    Brainstorms/
        S-002 - Brainstorm 01.md

    Runs/
        S-002/
            run-001-architect.md
            run-002-character-critic.md
            run-003-causality.md
            run-004-continuity.md
            run-005-integrated.md

    Templates/
        story-unit.md
        brainstorm-packet.md
        critique.md

    Evaluations/
        structural-patterns.md
        prose-patterns.md
        failure-modes.md
```

This is a proposed working layout, not yet canonized. Reuse existing `02 Story`, `03 Context`, and `07 QA` rather than duplicating their factual content. The Story Loop should point to authoritative notes rather than copy them unnecessarily.

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

## Recursive scale

The Gauntlet philosophy should operate at different resolutions with different rubrics:

### Novel
Does the complete causal structure work?

### Major era / act
Does this section escalate, transform, and pay off?

### Sequence
Do 2–4 neighboring Story Units form a meaningful progression?

### Scene
Does somebody want something, encounter resistance, and leave in a changed state?

### Chapter
Does the reading experience sustain attention and move the story?

### Paragraph / prose
Does the language meet the Seeds quality bar?

Do not use one universal rubric across all scales.

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

Design one central completion graph, likely under the eventual Story Loop directory, containing the complete causal spine.

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

The system should identify the highest-leverage unresolved node by dependency impact and present that as the next brainstorming target.

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

## Pilot before scale-up

Do not run an untested loop over the entire novel.

Start with two real sections:

1. **A comparatively well-understood section**, likely the Samuel/George obsession and inverted-containment material. This tests whether the loop preserves strong existing decisions and improves organization without damaging them.
2. **A genuinely unresolved structural section**, likely Sylvan's modern inciting event. This tests whether the loop actually helps close a difficult gap rather than merely polish existing material.

Compare results, identify failure modes, revise the loop, and rerun before expanding to the rest of the story.

A third neighboring unit may be added if needed to test sequence-level coherence. Prefer testing 1–3 units at a time rather than the whole story.

## Self-improving workflow

The Gauntlet itself should improve through use.

When a run fails, record the failure in a durable evaluation note rather than simply retrying blindly.

Examples:

- continuity critic missed an information-state violation;
- architect invented a new faction instead of using existing material;
- critic rewarded exposition instead of dramatic presentation;
- prose revision explained an emotion after the image already conveyed it;
- different critics repeated the same generic feedback;
- integrator changed an unresolved idea into established fact.

Convert recurring failures into explicit critic rules, templates, or quality-bar additions.

The project should therefore accumulate a Seeds-specific failure taxonomy and become more reliable over repeated use.

## Operating modes

### Phase 1 — Story completion
`brainstorm -> resolve causal nodes`

### Phase 2 — Sequence completion
`story nodes -> dramatic sequences`

### Phase 3 — Scene completion
`sequence -> scene specifications`

### Phase 4 — Drafting
`scene specification -> prose`

### Phase 5 — Prose gauntlet
`writer -> continuity critic -> Seeds prose critic -> AI-pattern critic -> revision`

The loop should not advance globally to the next phase until the current phase reaches a defined completion threshold, though isolated resolved sections may be used as experimental pilots for later phases.

## Development roadmap

This is a multi-week design-and-use project, not a single-night build.

### v0.1 — Story Unit format + master skeleton
Define the canonical Story Unit and convert 2–3 existing parts of Seeds into units.

### v0.2 — Brainstorm Packet generator
Given an unresolved unit, gather the relevant vault context and produce the questions the author should brainstorm.

### v0.3 — First structural Gauntlet
Architect + Character Critic + Causality Critic + Continuity Critic + Integrator.

### v0.4 — Author gate and decision tracking
Ensure unresolved creative decisions return cleanly to the author and approved decisions can be distinguished from speculation.

### v0.5 — Run history and failure-mode tracking
Preserve Gauntlet outputs and learn from recurring failures.

### v0.6 — Sequence-level evaluation
Evaluate 2–4 neighboring units for escalation, transitions, setup/payoff, and character progression.

### v0.7 — Scene compiler
Convert resolved units/sequences into scene specifications.

### v0.8 — First prose Gauntlet
Generate and refine actual narrative text through specialized critics.

### v0.9 — Calibration
Analyze author-provided examples and observed craft qualities to sharpen the Seeds prose quality bar.

### v1.0 — Repeatable Seeds story-production workflow
Move reliably from incomplete story map -> finished causal structure -> sequence plan -> scene plan -> chapter drafts.

Do not prematurely implement later versions before the earlier versions have survived real use.

## Tonight's desktop objective

Tonight should establish the architecture and start v0.1, not attempt to build the entire system.

Order:

1. Integrate the pending story-development notes from the mobile session into their appropriate existing story locations without overpromoting developmental ideas.
2. Finalize the Story Loop directory/location and authority relationship to `02 Story`, `03 Context`, and `07 QA`.
3. Define the canonical Story Unit schema and template.
4. Begin a first `STORY-MAP.md` from the existing live storyline rather than inventing a replacement outline.
5. Convert 2–3 existing sections into Story Units.
6. Select the two pilot units: one well understood, one structurally unresolved.
7. Define the first five-pass structural Gauntlet and its output files.
8. Stop before overengineering; leave the system runnable manually in Markdown first.

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

## Design questions for tonight and subsequent iterations

1. Exact location and authority level of the master `STORY-MAP.md`.
2. Final Story Unit schema and statuses.
3. How the loop ranks unresolved nodes by leverage/dependency.
4. Which agents are separate fresh-context critics versus one orchestrator with isolated passes.
5. Exact author-gate behavior and how questions are queued for ride-home brainstorming.
6. What an agent may update automatically versus what requires explicit author approval.
7. How the loop uses existing `03 Context/OPEN-QUESTIONS.md`, `07 QA/Questions.md`, `07 QA/Contradictions.md`, and `07 QA/Decisions.md` without duplicating them.
8. Maximum iteration count before a failed node escalates back to the author.
9. Pass/fail rubric for story nodes, sequences, scenes, chapters, and prose.
10. How research findings are attached to nodes without becoming canon.
11. How raw brainstorming is preserved and linked to subsequent decisions.
12. How completion metrics are shown without incentivizing shallow box-checking.
13. What constitutes enough structural completion to begin scene compilation.
14. How adjoining 2–3 unit evaluations should modify local units without destabilizing distant resolved material.
15. How prose examples and audiobook observations are converted into abstract craft criteria rather than imitation.

## Definition of success

The Story Gauntlet succeeds when the complete story can be followed from beginning to ending as an unbroken chain of character-driven causes and consequences, and no blocking creative decision has been silently invented by an agent.

At that point, worldbuilding expansion stops by default and the system compiles the completed story map into sequences and scenes.

The longer-term success condition is stronger: repeated specialized build/critique/revision cycles should measurably improve the usefulness, coherence, and prose quality of generated material over first-pass AI output while preserving the author's creative control.
