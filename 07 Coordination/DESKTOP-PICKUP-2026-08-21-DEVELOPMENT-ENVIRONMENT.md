---
type: coordination-handoff
status: active
updated: 2026-08-21
scope: development environment completion
---

# Desktop Pickup — Development Environment Completion

## Author direction

The project is currently a **story-development environment**, not primarily a finished-novel drafting environment.

The current finished-novel prose system is valuable but is downstream of the work now required.

The immediate goal is to build a complete, efficient environment that can take author ideas and vault canon, identify underdeveloped portions of the story, generate multiple possible structures and timelines, create the characters those structures need, simulate the ideas in short readable story form, critique them, and allow the author to choose what works.

## Major conceptual shift

Old implicit flow:

`idea -> polished prose -> refine prose`

Preferred development flow:

`idea -> retrieve canon -> identify gap -> generate alternatives -> build structure -> build required cast -> simulate as readable story -> critique -> compare -> author decision -> integrate -> repeat at finer scale -> final prose much later`

## New modules added

Read:

- [[08 Story Loop/DEVELOPMENT-ENVIRONMENT-ARCHITECTURE]]
- [[08 Story Loop/DEVELOPMENT-PROTOTYPE-STYLE]]
- [[08 Story Loop/CHARACTER-FACTORY]]
- [[08 Story Loop/MULTISCALE-DEVELOPMENT-GAUNTLET]]
- [[08 Story Loop/PROBLEM-SOLVING-STORY-ENGINE]]
- [[09 Story Exploration/STORY-GENERATION-LOOP]]

## Development prototype style

Use a highly readable, fast, conversational science-fiction development mode influenced by general strengths observed in long-form accessible SF such as Expeditionary Force:

- complex world / simple scene;
- immediate concrete objectives;
- problem-solving;
- visible reasoning;
- conversational exposition;
- clear character attitudes;
- temporary characters who become memorable quickly;
- humor/personality under pressure;
- solution -> consequence escalation;
- easy audiobook legibility;
- clear state change at the end.

This is NOT a request to imitate Craig Alanson's exact prose voice, distinctive phrasing, recurring jokes, or character voices.

Prototype prose is disposable.

Its purpose is to let the author **experience an idea as story** before committing to it.

Default prototype length: approximately 500–1,500 words.

## Character strategy

The story can sustain a very large cast across the colonization process, Great War, containment, and modern arc without treating every character as a major protagonist.

Use tiers:

- Tier A — anchor characters;
- Tier B — arc characters;
- Tier C — recurring support;
- Tier D — scene characters.

Temporary character formula:

`role + immediate want + competence + contradiction + pressure + small human detail + relationship to viewpoint + consequence`

Deepen only characters who prove valuable during story testing.

## Multiscale Gauntlet objective

The desired Gauntlet is not:

`draft text -> critic -> rewrite -> critic -> rewrite`

It is:

`large gap -> candidate structures -> critic -> chosen working branch -> expand one scale -> critic -> required characters -> chapter/scene design -> readable prototype -> critic -> author gate`

Scales:

0. Era / historical phase
1. Arc
2. Sequence
3. Chapter
4. Scene
5. Development prototype
6. Final prose (later workflow)

Critics should operate at the appropriate scale.

## Token affordability requirement

The loop must be usable frequently without exhausting context/token budget.

Preserve these rules:

- narrow retrieval;
- one compact context packet per run;
- breadth cheaply, depth selectively;
- kill weak alternatives before prose;
- only relevant critics;
- pass deltas/state forward rather than entire reasoning transcripts;
- prototype one representative scene instead of drafting an entire arc;
- reuse character packets;
- stop on author decisions;
- final prose stays out of routine development runs.

### Preferred Cascade Run

For important gaps:

`retrieve -> identify gap -> 3–5 broad candidates -> shortlist -> expand one branch -> create required characters -> chapter/scene card -> 500–1,000 word prototype -> critics -> author gate`

This can test a surprisingly large story idea without fully drafting it.

## Story Exploration Lab expansion

The existing non-canon Story Exploration Lab should become the primary source of alternate candidate material.

It should be able to inspect a story period and produce:

- alternate timelines;
- missing events;
- new supporting characters;
- possible relationships;
- institutional conflicts;
- reversals;
- chapter engines;
- scene opportunities;
- research questions;
- long-range consequences.

Then the Multiscale Development Gauntlet evaluates the strongest candidates.

## Research integration

The development system should make it easy to inject inspiration from:

- software development before AI;
- software development after AI;
- distributed systems;
- security / exploit logic;
- history;
- warfare;
- logistics;
- institutions;
- psychology;
- politics;
- emerging technology;
- everyday observations;
- other storytelling structures.

Use:

`research concept -> human problem -> Seeds translation -> scene opportunity -> later payoff`

The purpose is not technical display. The purpose is new story material.

## X integration

Development output should also support X.

Readable prototypes and development concepts can be compressed into:

- short development posts;
- long X posts;
- behind-the-story explanations;
- concept teasers;
- illustrated story fragments.

X style should favor development clarity and intriguing reversals rather than final-novel prose density.

## What remains to build / integrate

### Priority 1 — wire modules together

1. Update Story Exploration Lab templates to call Character Factory and Prototype Style when requested.
2. Add the multiscale run state to Story Gauntlet templates.
3. Add development-prototype output as an explicit option in brainstorm runs.
4. Add comparison mode for testing two versions of the same mechanism.
5. Add token-budget mode selection: Micro / Standard / Deep / Cascade.

### Priority 2 — gap analyzer

Build a reusable process that scans a chosen era/arc and outputs:

- established structure;
- unresolved questions;
- missing causal bridges;
- missing character functions;
- missing events;
- systems that need demonstration;
- candidate development priorities.

This should become the front end for Story Exploration runs.

### Priority 3 — development chapter packet

Create a reusable chapter card containing:

- chapter function;
- viewpoint;
- immediate objective;
- starting state;
- ending state;
- necessary characters;
- relevant constraints;
- central reveal/mechanism;
- permitted provisional inventions.

Then generate a development prototype.

### Priority 4 — test the full pipeline

Use one underdeveloped Great War section as the first serious test.

Suggested run:

1. retrieve current Great War canon;
2. run gap analysis;
3. generate 3–5 plausible event spines;
4. select one working candidate only for testing;
5. generate the required supporting cast using Character Factory;
6. select one chapter-worthy event;
7. build chapter card;
8. generate 700–1,000 word development prototype;
9. run causality, character, continuity, creative-interest, and listener-clarity critics;
10. compare results with outline-only version;
11. author decides whether any element deserves further development.

Nothing from the test becomes canon automatically.

## Long-range objective

The system should eventually make it possible to point at something as broad as:

> Develop the Great War.

and proceed systematically:

`known history -> gaps -> multiple war structures -> major cast -> event timeline -> sequences -> chapters -> temporary supporting characters -> dialogue/story prototypes -> critics -> author selection`

Or point at something narrow such as:

> Test two ways Konrad could misunderstand Samuel's containment offer.

and cheaply produce two readable scenes for comparison.

## Success definition

The development environment is working when it becomes more useful to ask:

**"Show me what this idea feels like as a story."**

than to prematurely ask:

**"Write the finished chapter."**

The author should be able to test many ideas cheaply, discard weak ones without attachment, deepen the surprising ones, and gradually convert a very large body of canon and research into an enjoyable long-form story structure.
