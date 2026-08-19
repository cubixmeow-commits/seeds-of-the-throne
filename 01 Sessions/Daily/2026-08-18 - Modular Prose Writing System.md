---
type: session
status: active
date: 2026-08-18
topic: modular prose writing system
---

# Modular Prose Writing System

## Author direction

The author wants prose quality to become a primary development focus. Research, questions, coaching, continuity, and other methods should support the writing rather than replace it. The writing system should be complete, customizable, testable, and refined through actual use.

## Current style authority preserved

The existing `03 Context/WRITING-STYLE.md` remains the style authority. Archive Thriller / Dark Historical Reconstruction is the active development register. The retired Jurassic Park-style exposition register was not restored.

## Implementation

`skills/write-seeds-prose/` was expanded from a relatively compact drafting workflow into a modular prose system.

Core additions:

- explicit authority order and routing between writing, coaching, story development, research, and continuity;
- scene packets for POV, wants, friction, knowledge states, physical detail, reveal ceilings, pressure change, and fact authority;
- scene architecture;
- chapter architecture;
- project voice profile;
- character voice method;
- dialogue craft;
- exposition/world-system craft;
- suspense, foreshadowing, and revelation control;
- research and question triage;
- dedicated revision method;
- anti-AI prose regression guidance;
- customizable 1–5 style controls and per-scene overrides;
- 100-point prose evaluation rubric with critical authority gates;
- ten-scenario benchmark suite;
- deterministic mechanical prose linter and regression tests;
- learning loop for converting repeated author feedback into tested active rules rather than immediately globalizing one reaction.

## Initial testing and refinement

The first deterministic test set checked:

1. clean prose remains unflagged;
2. em dashes fail the mechanical gate;
3. repeated `not X, but Y` constructions warn;
4. repeated three-word sentence openings warn;
5. clusters of one-sentence narrative paragraphs warn.

A manual smoke test then used two representative non-canon scene shapes: a close-POV George anomaly and a Samuel/Konrad political-grotesque dialogue scene.

### Failure discovered

The original one-sentence-paragraph heuristic flagged both otherwise healthy smoke tests because dialogue is naturally formatted as short standalone paragraphs.

### Refinement

The linter was changed to exclude dialogue-leading paragraphs from the one-sentence narrative-cluster heuristic. A sixth regression test was added specifically to protect dialogue formatting from that false positive.

After the refinement, both representative smoke tests produced zero mechanical flags and the six deterministic regression cases behaved as intended.

## Next refinement source

The architecture is now complete enough for real use. The highest-value next improvements should come from actual prose sessions and explicit author reactions. Repeated preferences should be captured through the rule lifecycle in `references/customization.md` and added to the benchmark suite when they can be tested.

Full fresh-agent forward testing across all ten prose benchmarks remains useful as a later QA pass, but should not block using the system now.
