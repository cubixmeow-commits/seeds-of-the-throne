---
type: desktop-queue
status: pending-integration
date: 2026-08-13
topics: visual generation, benchmark, prompt architecture
---

# Visual Benchmark Findings — B01–B03

## B01 finding

The first attempts to run the B01–B10 visual benchmark exposed a production-system problem before character continuity could be meaningfully scored. Benchmark/evaluation language caused the image model to render a fictional benchmark report containing invented scores rather than only the requested photograph. All displayed scores are invalid.

## B02 finding — benchmark context contamination persists

The next test produced an actual extreme close-up photograph but still embedded a benchmark header, test identifier, date, descriptive metadata, and labeled evaluation information into the image. B02 is diagnostic only and invalid as benchmark evidence.

A plausible depiction of a named character is not enough to score identity fidelity. Identity scoring should be performed only when generation is demonstrably grounded in the repository's authoritative identity references/packet.

## B03 finding — first clean generation

B03 removed benchmark terminology, scoring language, test identifiers, metadata, and report-layout concepts from the generation instruction. The result was the first clean cinematic image with no benchmark text or typography embedded in the output.

### What worked

- Generation/evaluation separation works when benchmark language is completely removed from the image-generation instruction.
- Full-body action and motion were coherent.
- Hands, arms, stride, coat movement, and overall anatomy were strong enough that `POSE-RIGIDITY` was not observed.
- The image felt substantially more natural and cinematic than the earlier rigid portrait-style generations.
- Motion does not appear to require heavy prompt micromanagement; concise action direction may be preferable.

### What failed or remains unverified

- `IDENTITY-UNVERIFIED` — the output resembles the conversational reconstruction of Sylvan, but the generation was not demonstrably anchored to the repository's authoritative identity-master image. Do not assign a formal identity-fidelity score yet.
- `ENV-GENERIC` — the city defaulted toward familiar dystopian/cyberpunk visual shorthand rather than a uniquely recognizable *Seeds of the Throne* environment.
- `TECH-GENERIC` — background technology/vehicles/architecture were visually effective but not grounded in established Seeds technology packets.
- Wardrobe defaulted toward a generic black neo-noir protagonist. Character identity, wardrobe identity, and world/environment identity need separate reusable packets.

### Architectural conclusion from B03

The current image-generation layer is capable of producing convincing natural cinematic action. The immediate weakness is not raw image quality; it is **grounding that image quality in the unique visual identity of the Seeds world**.

This supports a modular architecture:

`identity packet + wardrobe packet + environment packet + technology packet + story beat + cinematography packet -> clean generation brief`

Each module should be independently improvable. Do not compensate for a generic environment by bloating the character identity prompt.

## Required architecture change

**Generation and evaluation must remain completely separated.** The image model should receive only photographic scene-production information. Benchmark IDs, rubrics, model comparisons, expected findings, and evaluation metadata remain outside generation.

## Revised benchmark flow

1. Retrieve authoritative identity references/packet plus only required canon/environment source material.
2. Select benchmark scenario outside the generation instruction.
3. Assemble a clean scene-only generation brief.
4. Generate one candidate.
5. Inspect the actual image.
6. Score externally.
7. Record failure tags and observations.
8. Change the smallest responsible layer before rerunning.

## Status

- B01: **REJECTED / INVALID DATA** — benchmark report rendered instead of candidate.
- B02: **REJECTED AS BENCHMARK DATA / DIAGNOSTIC ONLY** — candidate contaminated with benchmark typography/metadata.
- B03: **VALID CLEAN GENERATION / DIAGNOSTIC** — motion and anatomy promising; identity unverified; environment and technology generic.
- Continue one candidate at a time.

## Next test direction — profile interaction

The next test should challenge profile/near-profile continuity during natural interaction with another person. Keep the generation brief free of all benchmark terminology and embedded-text requests. The key observations are whether facial identity survives profile geometry, whether the second person contaminates the primary subject's identity, and whether interaction feels naturally blocked rather than staged.

## Integration target

Tonight, fold these findings into:

- `02 Story/Systems/Visual Generation/VISUAL-BENCHMARK-SUITE.md`
- `02 Story/Systems/Visual Generation/PROMPT-SYSTEM.md`
- environment/technology packet design
- wardrobe packet design or character continuity packets
- any future agent-facing generation contract
