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

## Desktop reconciliation and second linter refinement

The desktop vault was safely fast-forwarded from `55b408c` to `413225d` after confirming that the local branch was clean, had no unique commits, and was exactly thirty commits behind `origin/main`. The August 18 modular prose work and the separate technology/awakening development were already present upstream, so no chat-only story material needed promotion.

Review of the linter and benchmark suite found two reproducible mechanical gaps:

1. repeated `It wasn’t X. It was Y.` constructions using a typographic apostrophe escaped the existing detector;
2. the one-sentence-paragraph heuristic measured a global ratio, so scattered short paragraphs could be mislabeled as a cluster even when longer paragraphs broke the cadence.

The contrast detector now accepts straight and typographic apostrophes. The paragraph warning now measures the longest consecutive run of one-sentence narrative paragraphs and resets across dialogue or multi-sentence paragraphs. Regression coverage increased from six to eight cases, including a smart-apostrophe positive case and a scattered-short-paragraph negative case.

The test file now uses standard `unittest` discovery so a normal discovery run cannot silently report zero tests. All eight cases pass, the scripts compile, whitespace validation passes, and the official skill validator reports the skill as valid.

This refinement changes no story facts, style authority, or canon status. Archive Thriller / Dark Historical Reconstruction remains active, and Jurassic Park-style exposition remains retired.
