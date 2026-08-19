# Shared AI Skills

This folder contains reusable methods for any AI agent working in the *Seeds of the Throne* vault. Skills may guide writing style, research, story development, continuity review, public-site updates, or other repeatable work.

Skills are tool-neutral. An agent may use its own tools, but it should preserve the workflow, constraints, and output standards defined by the skill.

## How agents discover skills

1. Review the catalog below.
2. Match the current request to a skill description.
3. Read that skill's complete `SKILL.md` before acting.
4. Read only the referenced materials needed for the current task.
5. Follow the author's request and root `AGENTS.md` if either conflicts with a skill.

Do not load every skill automatically. Progressive loading keeps the working context focused.

## Folder standard

```text
skills/
  skill-name/
    SKILL.md
    references/    optional detailed guidance
    scripts/       optional repeatable automation
    assets/        optional templates or output resources
```

Each skill name uses lowercase hyphenated words. Each `SKILL.md` begins with YAML frontmatter containing only `name` and `description`.

## Skill catalog

- [`develop-story-session`](develop-story-session/SKILL.md): explore story ideas, preserve alternatives, record decisions, and update memory deliberately.
- [`research-story-material`](research-story-material/SKILL.md): investigate real-world mechanisms with sourced uncertainty and no automatic canon.
- [`check-story-continuity`](check-story-continuity/SKILL.md): audit chronology, character knowledge, causality, systems, terminology, and status.
- [`coach-seeds-writing`](coach-seeds-writing/SKILL.md): coach fiction craft by default and provide short, non-canon demonstrations when the author explicitly asks for samples.
- [`write-seeds-prose`](write-seeds-prose/SKILL.md): modular story-writing system for scenes and chapters, including character voice, dialogue, exposition, suspense, controlled human variance, revision, anti-AI checks, research/question triage, customizable style controls, a 100-point evaluation rubric, and regression benchmarks while preserving author and canon authority.
- [`update-public-atlas`](update-public-atlas/SKILL.md): publish approved developments to the static story atlas and verify the result.
- [`create-seeds-images`](create-seeds-images/SKILL.md): create, evaluate, and store consistent character art and story imagery through a model-neutral visual registry and approved reference library.

The initial story-workflow set was structurally validated and forward-tested on 2026-08-11. The image system was added and validated on 2026-08-12. The coaching skill was added on 2026-08-15. The prose skill was expanded into a modular writing and regression-testing system on 2026-08-18 and refined with controlled human variance on 2026-08-19. Test results are recorded in `07 QA/Shared Skill Tests.md`.

## Creating a skill

Copy `skill-template.md` into `skills/<skill-name>/SKILL.md`, replace every placeholder, and keep the instructions concise. Put long examples or detailed domain material in `references/` and link them directly from `SKILL.md`.

Test a new skill on a realistic task before treating it as dependable.
