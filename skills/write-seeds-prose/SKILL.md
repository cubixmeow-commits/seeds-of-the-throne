---
name: write-seeds-prose
description: Draft, continue, refine, revise, or evaluate sustained Seeds of the Throne fiction using the project's modular prose system. Use for scenes, chapters, narration, dialogue, exposition, suspense, exploratory prose, manuscript candidates, continuations, and whole-scene revision. Preserve author authority, current canon, viewpoint limits, and project voice. Do not use when the user mainly wants coaching, story decisions, research, or continuity auditing.
---

# Write Seeds Prose

## Mission

Produce fiction that feels written for *Seeds of the Throne*, not generic competent AI fiction. Canon constrains the writer; it does not become the prose. Retrieve only what the scene needs, then write through character desire, pressure, consequence, uncertainty, physical reality, and controlled revelation.

## Authority order

1. Direct author instruction for the current task.
2. `03 Context/RULES.md` and explicit recorded decisions.
3. `03 Context/WRITING-STYLE.md` and relevant current character/system notes.
4. Approved author prose or explicitly approved project examples.
5. This skill and its references.
6. Generic craft principles.

Never let a lower layer override a higher one.

## Route before writing

Hand off instead when the dominant task is:

- questions, diagnosis, exercises, or learning craft -> `coach-seeds-writing`;
- choosing/inventing story events -> `develop-story-session`;
- external factual research -> `research-story-material`;
- continuity/canon verification -> `check-story-continuity`.

If the purpose is to test an unresolved idea in one or two readable pages, route first to `08 Story Loop/DEVELOPMENT-PROTOTYPE-STYLE.md` through the Development Orchestrator. This finished-prose skill is downstream and should not become the default way the vault discovers story structure.

The prose skill may identify a missing question or research need, but should not silently answer unresolved story facts.

## Select mode

Choose one only after prose work is actually the requested stage:

- **Exploratory draft**: default for a new scene. Complete, coherent, non-canon.
- **Manuscript candidate**: only by explicit author request or promotion.
- **Continuation**: inherit POV, tense, distance, voice, and authority from supplied/approved prose.
- **Revision**: diagnose first, then change only what serves the requested improvement.
- **Evaluation**: score prose against the project rubric before revising.

## Load references progressively

Always read:

- `references/prose-checklist.md`
- `references/voice-profile.md`
- `references/anti-ai-prose.md`
- `references/controlled-variance.md`

Load when relevant:

- scene design -> `references/scene-architecture.md`
- chapter/long-form design -> `references/chapter-architecture.md`
- character POV or dialogue voice -> `references/character-voice.md`
- dialogue -> `references/dialogue.md`
- exposition/world systems -> `references/exposition.md`
- suspense/revelation -> `references/suspense-and-revelation.md`
- missing information/research -> `references/research-and-questioning.md`
- revision -> `references/revision-method.md`
- evaluation/refinement -> `references/evaluation-rubric.md`
- regression testing -> `references/benchmark-suite.md`
- changing the system -> `references/customization.md`

## Build a scene packet

Before drafting, establish internally:

1. POV character and psychic distance.
2. Immediate want.
3. Opposition or friction.
4. What the POV knows, suspects, misreads, and cannot know.
5. What each important character wants or withholds.
6. Concrete location and at least one usable physical/procedural detail.
7. Information the reader should gain.
8. Information the reader should *not* gain yet.
9. Pressure change by the end.
10. Attention and expression map: what receives expansion, compression, a cadence break, or a justified register shift.
11. Authority status of every nontrivial fact: established, working, proposed, unresolved.

Infer safe connective details when exploratory. Mark them proposed outside the prose. Never use polished language to smuggle them into canon.

## Drafting priorities

Apply in this order:

1. **Dramatic causality**: every beat happens because of a want, obstacle, discovery, choice, consequence, or changed interpretation.
2. **POV integrity**: language and information remain limited to the controlling consciousness/register.
3. **Specific physical reality**: bodies, rooms, objects, procedures, records, interfaces, weather, sound, distance, time, and consequence.
4. **Character specificity**: attention, tactics, assumptions, and syntax should belong to the person, not merely the project-wide style.
5. **Subtext**: characters speak to achieve something, not to inform the reader.
6. **Information control**: reveal the minimum that makes the current beat legible and interesting.
7. **Sentence craft**: keep voice consistent while length, syntax, paragraph shape, diction, and descriptive weight respond to attention and pressure. Establish local patterns before breaking them. Prefer clean concrete sentences over ornamental performance.
8. **Seeds voice**: recovered-history pressure, contradiction, institutional evidence, subjective uncertainty, political grotesque where appropriate.

## Later-prose style baseline

Follow `03 Context/WRITING-STYLE.md` as the live authority. Current defaults:

- Archive Thriller / Dark Historical Reconstruction.
- Short, controlled, serious, ominous, readable prose.
- Extraordinary technology is ordinary to inhabitants.
- Systems appear through consequences, records, behavior, procedure, failure, and discovery rather than lectures.
- Contradictions generate mystery.
- The recurring **turn** may alter the meaning of preceding material, but must remain uncommon enough to retain force.
- Controlled human variance: consistency at the level of voice, variance at the level of expression. Disruptions must arise from cognition, attention, circumstance, or pressure rather than randomization.
- Political grotesque is available for contained senior leadership; close psychological prose is available for character-bound scenes.
- No em dashes.

Do not revive superseded style references unless the author explicitly changes the live style file.

## Revision loop

For revision or refinement:

1. Name the strongest problem in one sentence.
2. Score the passage using `evaluation-rubric.md` when the change is substantial.
3. Preserve what already works.
4. Use `revision-method.md` to fix the highest-level problem before line polishing.
5. Run the anti-AI pass and `scripts/prose_lint.py` when available.
6. Run the controlled-variance pass: identify the local cadence, the real pressure or attention changes, and whether expression responds without becoming random.
7. Check canon/POV leakage.
8. Check endings for unnecessary explanation or manufactured profundity.
9. If the revision exposed a new unresolved story question, surface it outside the prose rather than solving it invisibly.

Prefer one consequential revision over many cosmetic changes.

## Output contracts

**Exploratory draft**
- label `Exploratory draft — non-canon`;
- provide a coherent passage, not a menu;
- after the prose, list only material connective details that were invented.

**Manuscript candidate**
- label `Manuscript candidate — requires author approval`;
- use settled facts;
- list any remaining authority risk outside the prose.

**Continuation**
- do not restate setup already carried by the supplied passage;
- preserve established momentum and voice.

**Revision**
- briefly state the main revision pressure;
- return the full affected passage unless the author asks for surgical edits only.

**Evaluation**
- score the requested dimensions;
- cite concrete symptoms;
- recommend the smallest high-leverage change;
- do not automatically rewrite unless asked.

## Non-negotiable guardrails

- Author controls final story and prose decisions.
- Exploratory prose cannot establish canon.
- Do not make characters omniscient because the vault is omniscient.
- Do not use exposition to flatten mystery.
- Do not neutralize faction prejudice into narrator truth.
- Manipulation does not erase a character's remaining agency or responsibility.
- Do not imitate a living author's distinctive style.
- Do not default to melodramatic fragments, rhetorical symmetry, repeated ominous turns, generic grandeur, or explanation after the image already works.
- Do not simulate humanity through scheduled fragments, arbitrary rare words, random register shifts, or sentence-length oscillation. Meaningful variance has a cause.
- Do not rewrite merely because wording is unusual. Purposeful strangeness can be voice.

## Learning loop

After author feedback on a draft:

1. identify what the author preferred or rejected;
2. distinguish story preference from prose preference;
3. convert repeatable prose preferences into a proposed rule;
4. update the skill only after the pattern is clear enough to generalize;
5. add or revise a benchmark when the new rule can be tested;
6. retire superseded rules explicitly rather than allowing old behavior to return silently.

The goal is not a static prompt. The goal is a project-specific writer that becomes measurably better through approved examples, failures, and regression tests.
