---
name: skill-name
description: State what this skill does and the requests or situations that should trigger it.
---

# Skill title

## Objective

State the outcome this skill should reliably produce.

## Required context

List the minimum vault files or facts the agent must read before acting. Do not tell the agent to scan the entire vault.

## Workflow

1. Start with the first required action.
2. Describe the decision points that matter.
3. Preserve uncertainty and story status where relevant.
4. Verify the result before finishing.

## Output standard

Define the expected artifact, location, structure, tone, or evidence requirements.

## Guardrails

- State what the agent must not infer, change, expose, or publish.
- Keep vault authority and status rules intact.
- Defer to the author's explicit request and root `AGENTS.md`.

## References

Link only the optional references that this skill actually uses, and say when to read each one.
