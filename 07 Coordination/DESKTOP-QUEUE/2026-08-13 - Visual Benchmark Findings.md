---
type: desktop-queue
status: pending-integration
date: 2026-08-13
topics: visual generation, benchmark, prompt architecture
---

# Visual Benchmark Findings — B01 Setup Failure

## Finding

The first attempts to run the B01–B10 visual benchmark exposed a production-system problem before character continuity could be meaningfully scored.

When benchmark/evaluation language was included in the image-generation context, the image model interpreted the task as a request to **render the benchmark report itself**. It generated an infographic containing invented model names, scores, findings, and evaluation text instead of producing only the requested cinematic character photograph.

Those generated scores are invalid and must never be treated as benchmark evidence.

## Required architecture change

**Generation and evaluation must be completely separated.**

The image model should receive only the photographic scene brief required to create the candidate image. It should not receive:

- benchmark IDs such as B01–B10 unless operationally unavoidable;
- scoring rubrics;
- requested scores;
- evaluation terminology;
- model-comparison instructions;
- expected strengths or weaknesses;
- report-layout instructions;
- conclusions from previous tests.

The evaluation layer runs only **after** the candidate exists. It inspects the actual output against the benchmark rubric and records the result externally in Markdown/metadata.

## Revised benchmark flow

1. Retrieve identity/canon/environment source material.
2. Internally select the benchmark scenario.
3. Assemble a **clean generation brief containing only scene-production information**.
4. Generate one image candidate.
5. Inspect the actual image.
6. Score it outside the image-generation prompt.
7. Record failure tags and observations.
8. Change the smallest responsible system layer before rerunning.

## B01 clean-generation principle

For neutral continuity, the generation request should simply create a new natural photograph of the established character while preserving identity and deliberately changing pose, clothing, background, lighting, and composition from the identity master. It should contain no request to produce a benchmark, scorecard, report, infographic, labels, or typography.

## Status

- Original benchmark-board outputs: **REJECTED / INVALID DATA**.
- No B01 continuity score should be recorded from those outputs.
- Continue testing one candidate at a time using clean scene-only generation briefs.

## Integration target

Tonight, fold this finding into:

- `02 Story/Systems/Visual Generation/VISUAL-BENCHMARK-SUITE.md`
- `02 Story/Systems/Visual Generation/PROMPT-SYSTEM.md`
- any future agent-facing generation contract

The generation agent and evaluation agent/process should be treated as logically separate stages even when the same underlying model assists with both.