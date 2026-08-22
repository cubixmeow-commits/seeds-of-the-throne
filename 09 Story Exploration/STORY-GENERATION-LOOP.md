---
type: workflow
status: active
updated: 2026-08-21
scope: non-canon generative exploration
---

# Story Generation Loop

## Purpose

Generate multiple possible stories from the current Seeds of the Throne vault for inspiration, without contaminating canon.

The system should behave more like a creative search engine than a single-answer generator.

## Loop

### 1. Retrieve

Pull only the story material relevant to the exploration target:

- established facts
- active character motives
- system rules
- current chronology
- unresolved questions
- accepted thematic patterns
- recent brainstorm decisions

Label every retrieved item as one of:

- ESTABLISHED
- WORKING
- UNRESOLVED
- PROPOSED

### 2. Constrain

Before generating, state the hard constraints that candidate stories may not violate unless the run is explicitly marked as a counterfactual experiment.

Examples:

- Konrad never considered failure before the Great War defeat.
- Samuel remains an outsider in Konrad's eyes during the relevant period.
- A bounded system cannot become magical omnipotence.
- Luminai are extended cognition, not separate companion persons.

### 3. Choose exploration target

Every run should have a narrow creative question, such as:

- What are five ways Samuel could trick Konrad into reactivating the Fitzgerald machinery?
- What might the Great War defeat look like from Konrad's point of view?
- What scenes could reveal the hierarchy lock without exposition?
- What are alternate ways George's failed takeover could create later consequences?

### 4. Diverge

Generate **5–12 genuinely different candidate directions**.

Do not produce cosmetic variations of the same idea.

Force diversity across dimensions such as:

- mechanism
- character motive
- scale
- emotional effect
- point of view
- timing
- public/private consequence
- irony
- mystery
- institutional vs personal conflict

At least one candidate should be conservative and strongly grounded in existing structure.
At least one should be unexpectedly ambitious.
At least one should exploit an existing unresolved question.

### 5. Expand strongest candidates

Select the most promising 3–5 and expand each into:

- premise
- causal chain
- character pressure
- key scene/reveal
- why it is interesting
- what existing material it uses
- what new assumptions it requires
- likely downstream consequences

### 6. Adversarial critic pass

Run separate critic lenses rather than letting the generator grade itself casually.

#### Causality Critic
Does each event produce the next, or are there invisible jumps?

#### Character Critic
Would these people actually make these decisions given what is currently established?

#### Continuity Critic
What existing facts does the candidate conflict with?

#### System Critic
Does the candidate violate containment, technology, Luminai, authority, evidence, or permission rules?

#### Creative Interest Critic
Does it create curiosity, pressure, surprise, memorable scenes, reversals, or setup/payoff?

#### Distinctiveness Critic
Is this actually a different direction, or only a rewrite of another candidate?

### 7. Rank without canonizing

Score surviving candidates 1–5 on:

- Story Fit
- Character Pressure
- Causal Strength
- Creative Interest
- Scene Potential
- Payoff Potential
- Required New Assumptions (reverse score: fewer is better)

Do not declare a winner as canon.

Suggested statuses:

- HIGH-INTEREST CANDIDATE
- WORTH DEVELOPING
- INTERESTING BUT COSTLY
- NEEDS AUTHOR DECISION
- WEAK
- REJECT

### 8. Mutation round

For the top 2–3 candidates, generate one mutation each by combining the strongest feature of one candidate with a different candidate or established story mechanism.

The mutation must still pass the critic loop.

This prevents the system from prematurely converging on the first competent idea.

### 9. Archive

Save the run with:

- exact exploration question
- retrieved constraints
- all major candidates
- critic findings
- ranked shortlist
- mutations
- unanswered questions
- explicit `NON-CANON` warning

### 10. Author Promotion Gate

Stop.

The AI may recommend candidates, but it may not integrate them into the story.

The author chooses whether to:

- reject
- park
- rerun
- combine
- brainstorm interactively
- send candidate into `08 Story Loop/`

Only selected material enters the main story-development process.

## Two useful modes

### Mode A — Targeted Inspiration

Start from one unresolved story problem and generate possible solutions.

Use when the author is actively brainstorming a specific mechanism.

### Mode B — Story Miner

Retrieve a broader cluster of existing material and ask:

**What compelling story developments are latent in these facts but have not yet been developed?**

Use this to discover connections, reversals, scenes, and consequences already implied by the vault.

## Anti-contamination rule

Every output created by this loop must begin with:

> **NON-CANON STORY EXPLORATION — inspiration only. Nothing below is established unless promoted by the author through the main Story Loop.**

## Success condition

A successful run does not need to solve the story problem.

It succeeds if it gives the author several genuinely useful possibilities, reveals hidden consequences in existing material, or identifies a better question for the next brainstorm.
