---
type: desktop-queue
status: pending-integration
date: 2026-08-13
topics: visual generation, benchmark, prompt architecture, Luminai, technology
---

# Visual Benchmark Findings — B01–B04

## B01/B02 — invalid setup tests

B01 rendered a fictional benchmark report instead of a photograph. B02 produced a photograph but embedded benchmark labels and metadata. Both are invalid benchmark evidence. Core lesson: **generation and evaluation must be completely separated.** The image generator receives only a clean photographic scene brief; all benchmark IDs, scoring, findings, and metadata remain external.

## B03 — first clean action generation

The first clean scene-only generation demonstrated strong full-body motion, coherent anatomy, natural coat/body movement, and no obvious pose rigidity. However, identity could not be formally scored because the generation was not demonstrably grounded in the repository's authoritative identity master.

Failures/limitations:
- `IDENTITY-UNVERIFIED`
- `ENV-GENERIC`
- `TECH-GENERIC`
- generic black neo-noir protagonist wardrobe

Architectural conclusion: raw cinematic image quality is already strong; the larger problem is grounding that quality in a unique Seeds visual identity.

Recommended modular assembly:

`identity packet + wardrobe packet + environment packet + technology packet + story beat + cinematography packet -> clean generation brief`

## B04 — profile interaction / Luminai shorthand failure

The clean profile-interaction generation produced coherent profile geometry, matching eye lines, sensible spacing, and no obvious identity bleed between the two figures. The interaction was readable, though somewhat symmetrical/staged.

The major failure was the AI counterpart. With insufficient Luminai-specific visual canon, the model defaulted immediately to conventional science-fiction shorthand: a transparent blue-white holographic woman covered in glowing circuitry/particles inside a generic high-tech corridor.

Tags:
- `TECH-GENERIC` — severe
- `ENV-GENERIC` — moderate
- `IDENTITY-UNVERIFIED`
- `POSE-RIGIDITY` — mild/symmetrical face-off

### B04 conclusion

**Luminai manifestation must be visually defined before large-scale Luminai image generation.** Otherwise models will fill the design vacuum with holograms, transparent bodies, glowing circuitry, generic blue AI imagery, and familiar cyberpunk interfaces.

The visual system should distinguish between what a Luminai *is* in canon and how a particular camera/image is allowed to represent an otherwise perceptual or technologically mediated presence.

# Visual Definition Backlog

These are now explicit design tasks exposed by the benchmark. They should be developed in technology/worldbuilding sessions and integrated into the permanent visual system when resolved.

## Priority 1 — Luminai manifestation

- [ ] Define whether a Luminai normally has any externally visible physical manifestation at all.
- [ ] Define what the paired human actually perceives versus what an outside observer perceives.
- [ ] Define whether manifestation is neural/perceptual, environmental projection, synthetic embodiment, physical matter, or context-dependent combinations.
- [ ] Define the default visual presentation for an image/video audience without falsely implying that every character in-world sees the same thing.
- [ ] Define visual invariants that make one individual's Luminai recognizable across scenes.
- [ ] Define how male/female presentation appears without reducing Luminai to conventional human romantic-partner imagery.
- [ ] Define visual differences between ordinary Luminai and Sylvan's unprecedented advanced integration.
- [ ] Define how Luminai appearance changes with cognition, emotion, danger, synchronization, distance, or system access, if it changes at all.
- [ ] Explicitly prohibit unsupported default shorthand: generic blue hologram, transparent glass body, glowing circuit skin, floating HUD companion.

## Priority 2 — Daemon visual language

- [ ] Define whether Daemons are visible/perceived differently from Luminai.
- [ ] Define whether their appearance reflects the human's cognition, pathology/obsessions, permissions, or operational state.
- [ ] Avoid a simplistic visual equation of Daemon = evil red hologram.
- [ ] Define how remote action by a Daemon can be shown visually without implying physical presence where none exists.

## Priority 3 — Seeds environment identity

- [ ] Define architectural principles for the advanced civilization and colony environments.
- [ ] Define how an overwhelmingly synthetic population changes streets, buildings, transportation, workplaces, and public space.
- [ ] Define materials, infrastructure, scale, maintenance, weather interaction, signage, and lighting logic.
- [ ] Create environment packets for major eras/locations instead of prompting 'futuristic city' or 'high-tech corridor.'
- [ ] Identify visual motifs unique enough that an environment can read as Seeds without a character present.
- [ ] Prevent generic cyberpunk, Blade-Runner-like neon, generic spaceship corridor, and generic holographic-control-room defaults unless story-specific.

## Priority 4 — Technology identity

- [ ] Define how advanced technology is physically integrated into environments rather than displayed as decorative holograms.
- [ ] Define human/environment interfaces and what is visible versus invisible.
- [ ] Define synthetic bodies and how they differ, if at all, from biological humans in externally observable ways.
- [ ] Define moon/orbital command infrastructure visual rules.
- [ ] Define transportation and communications visual language.
- [ ] Define the visual consequences of technology that interfaces mentally and physically with participants.

## Priority 5 — Wardrobe system

- [ ] Create wardrobe packets by character, era, social role, environment, and scene state.
- [ ] Define Sylvan's wardrobe range so models do not default to black neo-noir coats.
- [ ] Separate identity-defining appearance from scene-changeable clothing.
- [ ] Define materials and construction appropriate to each civilization/era.

## Priority 6 — Character identity grounding

- [ ] Ensure benchmark generations explicitly use authoritative repository identity references.
- [ ] Define reference priority when multiple angles/masters exist.
- [ ] Test whether identity remains stable when character names are omitted from clean generation briefs.
- [ ] Establish formal scoring only after reference grounding is verifiable.

## Priority 7 — Interaction/blocking

- [ ] Develop interaction language that produces asymmetric, lived-in behavior rather than face-to-face poster compositions.
- [ ] Test interrupted conversations, shared tasks, walking dialogue, foreground/background separation, unequal eye lines, and physical environment interaction.
- [ ] Establish rules for multi-character identity separation and gaze direction.

## Priority 8 — Relationship/Luminai compositions

- [ ] Define how two humans plus their paired Luminai are represented when relationships form.
- [ ] Define visual cues for consent, privacy boundaries, synchronization, shared context, and relationship-level coordination.
- [ ] Ensure Luminai do not visually read as additional romantic partners unless canon explicitly calls for that interpretation.

## Priority 9 — Prompt/agent architecture

- [ ] Enforce hard separation between generation context and evaluation context.
- [ ] Build clean scene-brief assembler from modular packets.
- [ ] Keep benchmark metadata external to image generation.
- [ ] Add explicit no-text/no-typography constraints when appropriate.
- [ ] Record exact source packets/commit state for reproducibility.
- [ ] Add tool-specific adapters only for demonstrated model-specific failures.

## Current benchmark status

- B01: rejected / invalid data
- B02: rejected as benchmark data / diagnostic only
- B03: valid clean diagnostic; strong motion/anatomy; generic world grounding
- B04: valid clean diagnostic; interaction/profile promising; severe generic-Luminai shorthand exposed

## Next test

B05 should challenge the subject inside a populated crowd with partial occlusion and many unrelated faces. Keep the prompt scene-only. Observe identity loss, accidental duplicates, crowd homogeneity, scale, environment genericity, and whether the subject remains naturally embedded in the scene rather than heroically centered like a poster.

## Integration targets for tonight

- `02 Story/Systems/Visual Generation/VISUAL-BENCHMARK-SUITE.md`
- `02 Story/Systems/Visual Generation/PROMPT-SYSTEM.md`
- Luminai/Daemon technology documentation
- environment packets
- technology packets
- wardrobe packets
- interaction/blocking guidance
- future agent-facing generation contract
