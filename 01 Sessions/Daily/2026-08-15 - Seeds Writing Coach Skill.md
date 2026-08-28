---
type: development-session
status: active
date: 2026-08-15
topics: writing craft, shared skills, authorship boundary
---

# Seeds Writing Coach Skill

## Author direction

Implement the recommended writing-skill additions that would strengthen the vault without importing a competing story architecture.

## Decision

Add `coach-seeds-writing` now as a Seeds-specific coaching skill with two explicit modes. Default coaching mode helps the author diagnose fiction-craft problems and return to handwritten work without generating prose, dialogue, plot events, character biographies, or worldbuilding. Opt-in demonstration mode produces short, non-canon samples only when the author explicitly asks to see examples.

Demonstration mode may use relevant vault information for character-in-action, scene fragments, and dialogue examples. Every sample remains exploratory, distinguishes vault facts from proposed connective material, explains the craft technique being demonstrated, and cannot establish canon. Complete scenes, chapters, continuations, and manuscript rewrites remain the responsibility of `write-seeds-prose`.

Keep `write-seeds-prose`, `develop-story-session`, and `check-story-continuity` as separate modes with explicit handoffs. Do not install Story Skills, Author Toolkit, Fiction, or another complete story-bible framework into the live vault.

## Deferred work

Do not create `critique-seeds-prose` yet. Build it after the author has representative handwritten manuscript samples that can serve as the voice authority. Until then, direct prose revision remains available through `write-seeds-prose`, while `coach-seeds-writing` provides diagnostic feedback and explicitly requested craft demonstrations.

## Affected files

- `skills/coach-seeds-writing/SKILL.md`
- `skills/coach-seeds-writing/agents/openai.yaml`
- `skills/README.md`
- `07 QA/Shared Skill Tests.md`
