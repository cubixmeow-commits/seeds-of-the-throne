---
type: desktop-queue
status: pending-integration
date: 2026-08-13
topics: visual generation, benchmark, prompt architecture
---

# Visual Benchmark Findings — B01/B02 Setup Failures

## B01 finding

The first attempts to run the B01–B10 visual benchmark exposed a production-system problem before character continuity could be meaningfully scored.

When benchmark/evaluation language was included in the image-generation context, the image model interpreted the task as a request to **render the benchmark report itself**. It generated an infographic containing invented model names, scores, findings, and evaluation text instead of producing only the requested cinematic character photograph.

Those generated scores are invalid and must never be treated as benchmark evidence.

## B02 finding — benchmark context contamination persists

The next test produced an actual extreme close-up photograph, but still embedded a benchmark header, test identifier, date, descriptive metadata, and labeled evaluation information directly into the generated image.

This strengthens the original finding: simply intending to separate generation and evaluation is insufficient if benchmark terminology remains in the generation context. The production system must enforce a hard boundary between the two stages.

B02 is therefore also **invalid as benchmark evidence**. It can be retained only as a diagnostic example of prompt/context contamination.

A secondary observation is that a plausible depiction of a named character is not enough to score identity fidelity. Identity scoring should be performed only when the generation is explicitly grounded in the repository's authoritative identity references/packet. Conversational reconstruction of the character is not a valid substitute for the identity master.

## Required architecture change

**Generation and evaluation must be completely separated.**

The image model should receive only the photographic scene brief required to create the candidate image. It should not receive:

- benchmark IDs such as B01–B10;
- character benchmark labels;
- scoring rubrics;
- requested scores;
- evaluation terminology;
- model-comparison instructions;
- expected strengths or weaknesses;
- report-layout instructions;
- conclusions from previous tests;
- instructions to render metadata or typography.

The evaluation layer runs only **after** the candidate exists. It inspects the actual output against the benchmark rubric and records the result externally in Markdown/metadata.

## Revised benchmark flow

1. Retrieve the authoritative identity references/packet plus only required canon/environment source material.
2. Internally select the benchmark scenario outside the image-generation instruction.
3. Assemble a **clean generation brief containing only scene-production information**.
4. Ideally omit the character's name when the attached/reference identity is sufficient; treat the identity reference as the visual authority.
5. Generate one image candidate with no benchmark text or report layout.
6. Inspect the actual image.
7. Score it outside the image-generation prompt.
8. Record failure tags and observations.
9. Change the smallest responsible system layer before rerunning.

## Clean-generation principle for subsequent tests

The generation request should describe only what a cinematographer/photographer needs to create the scene: subject identity reference, action, environment, physical behavior, camera, lens feel, composition, light, material, mood, and explicit no-text/no-typography constraints where useful.

The image generator does **not** need to know that it is being benchmarked.

For the next test, remove the character name, benchmark terminology, scoring language, test identifier, metadata, and textual-layout concepts from the generation instruction. Associate the resulting image with the benchmark externally after generation.

## Status

- B01 benchmark-board outputs: **REJECTED / INVALID DATA**.
- B02 labeled close-up output: **REJECTED AS BENCHMARK DATA / DIAGNOSTIC ONLY**.
- No B01 or B02 continuity score should be recorded from these outputs.
- Continue testing one candidate at a time using clean scene-only generation briefs.

## Integration target

Tonight, fold these findings into:

- `02 Story/Systems/Visual Generation/VISUAL-BENCHMARK-SUITE.md`
- `02 Story/Systems/Visual Generation/PROMPT-SYSTEM.md`
- any future agent-facing generation contract

The generation agent and evaluation agent/process should be treated as logically separate stages even when the same underlying model assists with both.