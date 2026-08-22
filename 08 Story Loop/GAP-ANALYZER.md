---
type: development-system
status: active
updated: 2026-08-21
scope: story-development gap detection and prioritization
---

# Gap Analyzer

## Purpose

Turn a chosen era, arc, sequence, chapter, scene, character cluster, or mechanism into a prioritized development queue without silently solving the missing story.

The Gap Analyzer is the front end of the development environment. It answers:

**What is known, what is missing, why does the missing part matter, and what is the cheapest useful next run?**

## Input contract

Every analysis declares:

- scope and current scale;
- target question or desired end state;
- direct vault sources;
- established facts;
- working assumptions;
- unresolved questions;
- explicit exclusions and hard constraints;
- downstream units or decisions affected.

Retrieve narrowly. A gap report is not a vault summary.

## Authority pass

Before diagnosing gaps, classify each relevant claim:

- **ESTABLISHED** — explicit author decision or current recorded decision;
- **WORKING** — current scaffold that may change;
- **PROPOSED** — candidate awaiting author judgment;
- **UNRESOLVED** — deliberately open;
- **REJECTED / SUPERSEDED** — retained for history but unavailable as a current premise;
- **NON-CANON EXPLORATION** — inspiration only.

If sources disagree, report the status conflict. Do not choose the more convenient version.

## Gap classes

Check only classes relevant to the scope.

1. **Causal bridge** — an effect lacks a sufficient prior cause, authorization, trigger, or handoff.
2. **Character function** — a necessary decision lacks a plausible person, motive, knowledge state, competence, or cost.
3. **Chronology** — order, duration, age, simultaneity, or travel is missing or incompatible.
4. **System rule** — capability, permission, containment, evidence, Luminai/Daemon, or institutional behavior is undefined.
5. **Demonstration** — a rule exists but has no concrete situation that teaches it through action.
6. **Viewpoint / audience access** — an important event has no character through whom it can be experienced.
7. **Escalation / state change** — events repeat without changing pressure, knowledge, power, relationship, or available choices.
8. **Evidence / revelation** — a conclusion lacks an authentic record, observation path, or believable interpreter.
9. **Creative interest** — the structure is necessary but remains abstract, generic, repetitive, or exposition-bound.
10. **Research opportunity** — outside knowledge could materially improve mechanism, variety, plausibility, or scene potential.
11. **Status / authority** — a proposal is presented too strongly, an explicit decision is missing, or a resolved point is still listed as open.
12. **Handoff** — the ending state does not cause or enable the next scale or Story Unit.

Absence of decorative detail is not a gap. A gap matters only when it blocks understanding, choice, causality, testing, or downstream construction.

## Prioritization

Use this order:

`blocking dependency -> author decision -> causal bridge -> system/knowledge constraint -> character function -> viewpoint/evidence -> demonstration -> creative-interest upgrade -> optional expansion`

For each gap assign:

- **Impact:** blocking / significant / minor;
- **Authority needed:** author decision / research / structural generation / continuity repair / prototype test;
- **Dependency reach:** which later units or scales it blocks;
- **Cheapest useful test:** Micro / Standard / Deep / Cascade;
- **Stop condition:** what result would make the next step legitimate.

Do not rank a gap highly merely because it is interesting.

## Output format

### Scope

### Source and authority packet

### What already works

### Gap register

| ID | Class | Missing link | Why it matters | Impact | Authority needed | Blocks | Cheapest next action |
|---|---|---|---|---|---|---|---|

### Priority queue

List no more than five active priorities. Name one highest-value next target.

### Research questions

Only questions whose answers could materially change candidates.

### Character functions required

Roles only; do not generate biographies yet.

### Prototype opportunities

Name representative scenes that could expose whether a mechanism works. A prototype is optional, not an automatic output.

### Author decisions required

State each decision narrowly and stop before dependent expansion.

### Recommended run

Choose a mode and scale, define the candidate count, critic lenses, maximum prototype scope, and stop condition.

## Breadth-first rule

Analyze the whole selected scope cheaply before expanding one branch. Do not draft scenes while a blocking era- or arc-level gap remains. Do not research every gap; research only where the result could change the story.

## Status-safe rule

The analyzer may reveal that an open question is load-bearing. It may not answer that question merely to complete the report. In particular, use [[08 Story Loop/Brainstorms/Samuel-Konrad Containment Hierarchy - Needs Analysis]] as the boundary for the unresolved containment mechanics.

## Success condition

A successful gap analysis leaves the author with a small, ordered queue and a clearly bounded next run—not a larger pile of lore.
