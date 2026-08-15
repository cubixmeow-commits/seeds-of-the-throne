---
type: research-report
status: complete
date: 2026-08-15
topic: Codex writing skills, fiction skills, skill creation
produced_by: GPT
---

# Writing Skills for Codex and *Seeds of the Throne*

## Executive finding

There is no fiction-writing skill in OpenAI's current curated downloadable catalog. The strongest prebuilt options are community Agent Skills on GitHub, and the best match for this project is not a complete autonomous novel-writing system. It is a selective combination of:

1. an assistive **story-coaching skill** that protects human authorship;
2. a **voice-preserving prose revision skill** for critique and polishing; and
3. the three Seeds-specific skills already in the vault for canon, continuity, and project workflow.

The recommended approach is to review and adapt two community skills—`story-coach` and `better-writing`—instead of installing an entire external story framework. Full frameworks such as Story Skills or Fiction are useful sources of methods, but their project structures and assumptions would overlap with the mature Seeds vault and could create competing sources of truth.

## What OpenAI officially supports

OpenAI describes skills as folders containing a required `SKILL.md` plus optional scripts, references, assets, and interface metadata. Skills can activate explicitly or when a request matches their description. Codex can discover repo-level skills from `.agents/skills`, user-level skills from `~/.agents/skills`, and bundled system skills. OpenAI recommends one focused job per skill, concise instructions, explicit inputs and outputs, and testing the trigger description against realistic prompts. [OpenAI: Build skills](https://learn.chatgpt.com/docs/build-skills)

OpenAI also recommends turning a successful conversation, writing example, checklist, or repeatable workflow into a skill and improving it through actual use. [OpenAI: Save workflows as skills](https://learn.chatgpt.com/use-cases/reusable-codex-skills)

The live OpenAI curated catalog was checked on August 15, 2026. It contains document, research, presentation, development, deployment, and application skills, but no dedicated fiction or creative-writing skill. The documented installer can also download a skill directly from a GitHub repository. The experimental catalog path was unavailable during this check.

## What the Seeds vault already has

The project already contains three strong, project-specific skills:

- `write-seeds-prose` separates manuscript prose, exploratory scenes, development prose, and public copy; preserves viewpoint limits and uncertainty; prevents prose from silently establishing canon; and encodes current style boundaries such as avoiding em dashes.
- `develop-story-session` protects author authority, records ideas chronologically, preserves alternatives, and promotes only intentional material into compiled story notes.
- `check-story-continuity` audits chronology, knowledge, causality, terminology, system rules, and canon status without erasing visible contradictions.

These are more relevant to Seeds than most downloadable alternatives. Their current location, `vault/skills/`, makes them a vault-managed shared library loaded through `AGENTS.md`; it is not one of Codex's standard automatic discovery directories. If explicit `$skill-name` invocation is desired, reviewed copies or symlinks can be placed under the repository's `.agents/skills/` directory while preserving the vault copies as the project authority.

## Best prebuilt candidates

### 1. `story-coach` — strongest fit for learning to write

Repository: [jwynia/agent-skills — story-coach](https://github.com/jwynia/agent-skills/blob/main/skills/creative/fiction/core/story-coach/SKILL.md)

This MIT-licensed skill deliberately refuses to write story prose, dialogue, scenes, outlines, backstory, or lore. It diagnoses where the writer is stuck, asks focused questions, explains only the framework needed, offers approaches rather than finished content, and returns the writer to the page with a concrete prompt.

Why it fits Seeds:

- It matches the author's intention to write the final fiction by hand.
- It supports learning craft rather than outsourcing authorship.
- It complements `develop-story-session` without trying to replace the vault.
- Its strict coaching boundary is clear enough to avoid accidental mode drift.

Adjustment needed: replace its generic output-folder rules with the Seeds session-note workflow and remove dependencies on companion skills unless those are separately reviewed.

### 2. `better-writing` — strongest fit for voice-preserving revision

Repository: [forjd/better-writing](https://github.com/forjd/better-writing)

This MIT-licensed skill drafts, reviews, and rewrites prose with an emphasis on preserving a supplied voice sample, avoiding invented specifics, and detecting clusters of generic AI-writing patterns without treating every stylistic quirk as an error. It includes references and regression fixtures rather than relying only on a long prompt.

Why it fits Seeds:

- It treats the author's writing sample as the style authority.
- It can improve X posts, public project writing, treatments, and later manuscript revisions.
- Its “specificity without invention” rule aligns with the vault's canon discipline.
- It is less likely than generic “humanizer” skills to flatten deliberate voice.

Adjustment needed: use it as an explicit revision pass, not as an automatic rewrite layer. Seeds-specific rules—no em dashes, viewpoint limits, incomplete character knowledge, register separation, and no new canon—must outrank it.

### 3. Story Skills — best source for structure and deterministic continuity ideas

Repository: [danjdewhurst/story-skills](https://github.com/danjdewhurst/story-skills)

This MIT-licensed Codex-compatible bundle includes story initialization, character management, worldbuilding, plot structure, chapter writing, revision/continuity, and deterministic maintenance tools. It has a particularly interesting continuity engine for checking deaths, promises and payoffs, unresolved questions, scene casts, and durable object or knowledge state.

Why it is useful:

- It is explicitly packaged for Codex and the open Agent Skills format.
- Its deterministic continuity concepts could improve the future Seeds knowledge graph.
- Individual skills can be selected instead of installing the entire bundle.

Why not install it wholesale into Seeds:

- It creates its own story bible, registries, timeline, chapter schema, and continuity state.
- Seeds already has a richer authority model, visible contradictions, status labels, compiled notes, daily sessions, and QA records.
- Running its initialization or migration tools against the vault could create a parallel architecture or mechanical rewrites.

Recommended use: study or selectively adapt `chapter-writing` and continuity ideas in a test copy. Do not run its initialization, migration, removal, or autonomous drafting workflows against the live vault without a file-by-file integration plan.

### 4. Author Toolkit — useful editorial reference, significant overlap

Repository: [rhavekost/author-toolkit](https://github.com/rhavekost/author-toolkit)

This MIT-licensed collection offers a fiction workshop with developmental, line-editing, character, continuity, and brainstorming modes, plus prose-mechanics and AI-pattern audits. Its Story Bible and session-continuity approach resembles Seeds.

It is a reasonable source for editorial rubrics, especially sentence variance and prose mechanics, but it overlaps heavily with the project's existing skills. It was packaged primarily as a Claude plugin, so each skill would need compatibility review before Codex installation.

### 5. Fiction — capable full pipeline, but too invasive for the current vault

Repository: [howells/fiction](https://github.com/howells/fiction)

This MIT-licensed system includes Codex plugin metadata and supports planning, outlining, character development, chapter writing, review, critique, editing, synopsis, publishing preparation, and EPUB generation.

It is better suited to beginning a new convention-driven novel project than joining an existing vault with its own mature structure. Its assumptions about project files, commands, autonomous chapter drafting, and editorial workflow would require substantial reconciliation.

## Recommended Seeds skill architecture

Keep the current three project skills as the authority layer and add two narrow modes:

1. **`coach-seeds-writing`** — adapt `story-coach` to ask questions, diagnose craft problems, and return the author to handwritten work. It never drafts prose.
2. **`critique-seeds-prose`** — adapt the strongest parts of `better-writing` to diagnose or revise author-provided prose while preserving voice, facts, register, and canon boundaries.
3. **`write-seeds-prose`** — retain for explicitly requested exploratory drafts, scenes, dialogue, and revisions.

This separation prevents a request such as “help me with this scene” from unpredictably switching between coaching, critique, and ghostwriting.

## How to build a strong custom writing skill

### 1. Define one job and its boundaries

Start with concrete requests that should trigger the skill and nearby requests that should not. For example:

- Trigger: “Help me discover why this scene is dead.”
- Trigger: “Coach me through Sylvan's first confrontation.”
- Do not trigger: “Draft three versions of the confrontation.”
- Do not trigger: “Update the story treatment.”

The `description` field controls implicit activation, so it should contain both the job and the boundary.

### 2. Use the author's work as the reference

Provide a small set of the author's own passages representing different successful registers:

- handwritten manuscript prose;
- dialogue;
- exploratory scene work;
- treatment/development prose;
- public X or website prose.

Label why each sample works. A skill learns more from a few approved examples plus explicit observations than from a large, undifferentiated manuscript dump.

### 3. Keep the main instructions short

The `SKILL.md` should contain the trigger, workflow, authority rules, required inputs, output shape, and guardrails. Longer material belongs in targeted references such as:

- `references/voice-profile.md`
- `references/scene-diagnosis.md`
- `references/dialogue-checklist.md`
- `references/revision-patterns.md`
- `references/approved-examples.md`

Scripts should be reserved for deterministic checks—word counts, repeated phrases, sentence-length distribution, dialogue ratios, or link validation—not subjective aesthetic judgment.

### 4. Encode project authority explicitly

Every Seeds writing skill should state:

- the author controls story and prose decisions;
- current context and recorded decisions outrank generic craft advice;
- unresolved details remain unresolved;
- exploratory prose cannot establish canon;
- character knowledge must remain limited;
- legitimate civilization and criminal-faction themes must not be flattened together;
- a third-party skill cannot rename, reorganize, or migrate vault files without explicit permission.

### 5. Test triggers and outputs

Use a compact evaluation set containing:

- requests that should trigger coaching;
- requests that should trigger drafting;
- requests that should trigger continuity review instead;
- clean author prose that should remain untouched;
- weak prose with known issues;
- passages containing unresolved canon that must not be silently completed.

The skill succeeds only if it improves the target behavior without flattening voice or crossing authority boundaries.

### 6. Install at the correct scope

- Put Seeds-only skills in the repository's `.agents/skills/` directory.
- Put broadly useful skills such as `better-writing` in `~/.agents/skills/` if they should apply across projects.
- Keep third-party skills as reviewed, pinned copies rather than automatically tracking an upstream repository.

## Installation and security guidance

Community skills are untrusted code and instructions until reviewed. A skill may contain scripts, tool dependencies, file-writing rules, or broad triggers. Before installation:

1. inspect every `SKILL.md` and any referenced scripts;
2. confirm the license;
3. check whether it writes files, runs package managers, accesses the network, or changes project structure;
4. remove irrelevant companion-skill dependencies;
5. narrow its trigger description;
6. install into a test location first;
7. pin the reviewed revision in the vault or record the source commit.

For Seeds, selective adaptation is safer and more useful than installing a large bundle unchanged.

## Final recommendation

Do not replace the existing Seeds skills. Build a small, coherent writing suite around them:

1. adapt `story-coach` into `coach-seeds-writing`;
2. adapt `better-writing` into `critique-seeds-prose`;
3. keep `write-seeds-prose`, `develop-story-session`, and `check-story-continuity` as the project-specific core;
4. study Story Skills' deterministic continuity engine later as a possible input to the knowledge-graph work;
5. avoid installing a full autonomous novel-writing framework into the live vault.

This gives the author three intentional modes—**coach me, critique me, or draft with me**—while preserving the vault's canon discipline and the author's plan to write the final fiction personally.

## Implementation note — 2026-08-15

The author adopted the coaching recommendation with one deliberate extension: `coach-seeds-writing` now includes an explicit demonstration mode. Default coaching remains prose-free. When the author specifically asks to see samples or examples, the skill may generate one to three short, non-canon demonstrations grounded in relevant vault material, explain the craft technique and tradeoff in each, and identify all invented connective details as proposed. Complete scenes, chapters, continuations, and manuscript rewrites remain separate work for `write-seeds-prose`.
