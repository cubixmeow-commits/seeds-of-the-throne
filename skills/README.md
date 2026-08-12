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

No shared skills have been added yet.

Good first candidates:

- `write-seeds-prose`: voice, style, viewpoint, dialogue, and prose constraints
- `research-story-material`: source quality, note-taking, uncertainty, and translation into invented mechanisms
- `develop-story-session`: explore ideas without silently making them canon
- `check-story-continuity`: compare chronology, characters, systems, and status labels
- `update-public-atlas`: turn selected vault developments into accurate public pages

Add each skill to this catalog when its `SKILL.md` is ready to use.

## Creating a skill

Copy `skill-template.md` into `skills/<skill-name>/SKILL.md`, replace every placeholder, and keep the instructions concise. Put long examples or detailed domain material in `references/` and link them directly from `SKILL.md`.

Test a new skill on a realistic task before treating it as dependable.
