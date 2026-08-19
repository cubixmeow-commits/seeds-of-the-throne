---
type: development-note
status: pending
created: 2026-08-19
source: Grok assessment + ChatGPT review
---

# Prose Skill — Priority Under Load

## Why this note exists

The current `write-seeds-prose` skill is strong enough that its main risk is no longer lack of rigor. The emerging risk is **too much rigor being applied at once**.

Grok's assessment identified the system as unusually strong in authority control, anti-AI diagnostics, controlled variance, scene preparation, output modes, learning loops, and project-specific style. The most important limitation it identified was the possibility of over-constraint: if every rule is treated as equal and active at the same time, prose can become careful, correct, and slightly airless.

This should be the next refinement target.

## Core idea

Do not substantially simplify the prose skill. Make it **more hierarchical**.

The model should know which priorities dominate when rules compete, and which constraints are allowed to lose in service of a stronger scene.

### Proposed hierarchy

1. **Scene truth first**
   - POV integrity
   - immediate want
   - friction
   - knowledge boundaries
   - dramatic causality

2. **Voice second**
   - does the passage sound like *Seeds of the Throne*?
   - preserve the active Archive Thriller / Dark Historical Reconstruction register
   - maintain character-specific voice where applicable

3. **Image and consequence third**
   - physical specificity
   - meaningful detail
   - implication
   - pressure change
   - reveal systems through consequences rather than explanation

4. **Controlled variance fourth**
   - break statistical equilibrium only where attention, cognition, memory, pressure, personality, or emotion motivates it
   - maintain consistency at the level of voice and variance at the level of expression

5. **Anti-AI cleanup last**
   - remove explanation after the image has landed
   - remove generic grandeur
   - remove rhetorical templates and other recurring AI tells
   - fix mechanical regularity
   - do not let cleanup flatten strong prose

## Principle to add: When Rules Compete

A future version of the skill should contain a short explicit section such as **Priority Under Load** or **When Rules Compete**.

Candidate rule:

> The prose rules are not equal-weight compliance checks. When constraints conflict, preserve scene truth, POV integrity, dramatic causality, and voice before surface-level stylistic rules. A strong sentence may violate a lower-priority preference if the violation is motivated by character, attention, pressure, or the needs of the scene. Do not flatten effective prose merely to satisfy the checklist.

This should prevent the model from mentally checking fifteen equal-weight requirements while drafting.

## Controlled variance remains a core strength

The controlled-human-variance system appears to close an important loophole in ordinary "humanize this prose" instructions.

The goal is **not** to replace smooth AI regularity with performative irregularity.

Avoid:
- scheduled sentence fragments
- random odd words
- arbitrary register changes
- artificial sentence-length oscillation
- visible attempts to "sound human"

Prefer irregularity caused by:
- attention
- memory
- emotional pressure
- cognition
- personality
- hesitation
- concealment
- decision

The governing principle remains:

> **Consistency at the level of voice. Variance at the level of expression.**

## Tomorrow's build target

Refine the `write-seeds-prose` skill so that:

- its existing rigor remains intact
- rule priority is explicit
- drafting and evaluation are separated more clearly
- lower-priority constraints can yield when they would damage a scene
- anti-AI rules function primarily as diagnosis and revision tools rather than simultaneous drafting burdens
- regression tests verify that hierarchy reduces stiffness without reintroducing generic AI prose

The goal is not fewer standards. The goal is **better arbitration between standards**.
