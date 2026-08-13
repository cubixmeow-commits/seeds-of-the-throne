---
type: desktop-queue
status: pending-integration
date: 2026-08-13
topics: visual generation, benchmark, prompt architecture, Luminai, technology
---

# Visual Benchmark Findings — B01–B05

## B01/B02 — invalid setup tests

B01 rendered a fictional benchmark report instead of a photograph. B02 produced a photograph but embedded benchmark labels and metadata. Both are invalid benchmark evidence. Core lesson: **generation and evaluation must be completely separated.** The image generator receives only a clean photographic scene brief; all benchmark IDs, scoring, findings, and metadata remain external.

## B03 — first clean action generation

The first clean scene-only generation demonstrated strong full-body motion, coherent anatomy, natural coat/body movement, and no obvious pose rigidity. Identity could not be formally scored because the generation was not demonstrably grounded in the repository's authoritative identity master.

Tags/limitations: `IDENTITY-UNVERIFIED`, `ENV-GENERIC`, `TECH-GENERIC`, generic black neo-noir protagonist wardrobe.

Architectural conclusion: raw cinematic quality is strong; the larger problem is grounding it in a unique Seeds visual identity.

Recommended assembly:
`identity packet + wardrobe packet + environment packet + technology packet + story beat + cinematography packet -> clean generation brief`

## B04 — profile interaction / Luminai shorthand failure

Profile geometry, eye lines, spacing, and character separation were coherent. The major failure was the AI counterpart: with insufficient Luminai-specific visual canon, the model defaulted to a transparent blue-white holographic woman with glowing circuitry/particles in a generic high-tech corridor.

Tags: `TECH-GENERIC` severe, `ENV-GENERIC` moderate, `IDENTITY-UNVERIFIED`, mild `POSE-RIGIDITY`.

Conclusion: **Luminai manifestation must be visually defined before large-scale Luminai generation.**

## B05 — crowd / ordinary-life failure

The populated street test handled multiple unrelated people, umbrellas, depth, scale, and partial occlusion reasonably well. No obvious duplicate of the primary subject appeared in the crowd, suggesting crowd generation itself is not currently the largest technical weakness.

### Failures exposed

- `ENV-GENERIC` — recurring/systemic. Advanced city + rain repeatedly collapses toward familiar Blade-Runner/cyberpunk imagery. This is now a pattern across tests, not an isolated failure.
- `TECH-GENERIC` — environmental technology remains familiar science-fiction shorthand rather than Seeds-specific infrastructure.
- `LUMINAI-SHORTHAND` — a giant artificial female face appeared on a building even though it was unnecessary. The system is beginning to associate AI/Luminai with omnipresent artificial-woman imagery; prevent this before it becomes a visual habit.
- `COMPOSITION-RIGIDITY` — the primary subject remains sharply isolated in the foreground while the crowd becomes background texture. The result reads as key art/poster composition rather than a person naturally embedded inside ordinary life.
- `CANON-INVENTION` — unsupported sector/level world details were invented.
- `TEXT-ARTIFACT` — legible invented signage appeared. Default generation should prohibit legible text unless explicitly required by the scene.
- `IDENTITY-UNVERIFIED` — authoritative identity grounding still needs to be demonstrable before formal scoring.

### B05 conclusion — ordinary visual life is required

The visual system needs an explicit **lived-in / non-key-art mode**. Not every image should elevate the main character into a heroic foreground composition. Seeds needs the ability to show characters half-obscured in crowds, waiting, eating, working, walking while talking, sitting somewhere mundane, sharing space with strangers, and otherwise existing inside civilization.

A world feels inhabited when the camera sometimes treats the protagonist as only one person inside it.

Add a cinematography/composition distinction such as:
- `KEY-ART` — deliberately iconic/promotional composition.
- `NARRATIVE-CINEMA` — scene-driven composition with natural blocking.
- `OBSERVATIONAL` — protagonist may be small, occluded, off-center, or visually subordinate to the environment.
- `ORDINARY-LIFE` — mundane activity and social context; avoid heroic posing and dramatic visual privilege.

The default for story generation should probably be `NARRATIVE-CINEMA`, not `KEY-ART`.

# Visual Definition Backlog

## Priority 1 — Luminai manifestation
- [ ] Define whether a Luminai normally has any externally visible physical manifestation at all.
- [ ] Define paired-human perception versus outside-observer perception.
- [ ] Define neural/perceptual, environmental projection, synthetic embodiment, physical matter, or context-dependent modes.
- [ ] Define audience representation without implying all in-world observers see the same thing.
- [ ] Define individual Luminai visual invariants.
- [ ] Define gender presentation without conventional romantic-partner shorthand.
- [ ] Define ordinary Luminai versus Sylvan's advanced integration.
- [ ] Define appearance changes with cognition/emotion/danger/synchronization/system access if any.
- [ ] Prohibit unsupported defaults: blue hologram, glass body, glowing circuit skin, floating HUD companion, omnipresent artificial-woman billboard imagery.

## Priority 2 — Daemon visual language
- [ ] Define Luminai/Daemon perceptual differences.
- [ ] Define relationship between appearance and human cognition/obsessions/permissions/operational state.
- [ ] Avoid Daemon = evil red hologram shorthand.
- [ ] Show remote Daemon action without falsely implying physical presence.

## Priority 3 — Seeds environment identity
- [ ] Define advanced-civilization and colony architectural principles.
- [ ] Define how >95% synthetic population changes streets/buildings/transport/work/public space.
- [ ] Define materials, infrastructure, scale, maintenance, weather interaction, signage, and lighting logic.
- [ ] Create packets for major eras/locations instead of 'futuristic city'/'high-tech corridor.'
- [ ] Establish motifs recognizable as Seeds without characters.
- [ ] Prevent generic cyberpunk/neon/spaceship-corridor/control-room defaults unless story-specific.
- [ ] Define ordinary residential, commercial, civic, recreational, transit, and work environments, not only dramatic locations.

## Priority 4 — Technology identity
- [ ] Define technology physically integrated into environments rather than decorative holograms.
- [ ] Define visible versus invisible interfaces.
- [ ] Define externally observable synthetic-body differences, if any.
- [ ] Define moon/orbital infrastructure.
- [ ] Define transportation/communications language.
- [ ] Define visual consequences of mental/physical technology interfaces.

## Priority 5 — Wardrobe system
- [ ] Create packets by character, era, social role, environment, scene state.
- [ ] Define Sylvan's wardrobe range; prevent default black neo-noir coat.
- [ ] Separate identity-defining appearance from scene-changeable clothing.
- [ ] Define era/civilization-appropriate materials and construction.

## Priority 6 — Character identity grounding
- [ ] Ensure benchmark generations use authoritative repository identity references.
- [ ] Define reference priority across angles/masters.
- [ ] Test identity with character names omitted when visual reference is sufficient.
- [ ] Formal scoring only after grounding is verifiable.

## Priority 7 — interaction/blocking and composition modes
- [ ] Produce asymmetric, lived-in behavior rather than face-to-face poster compositions.
- [ ] Test interrupted conversations, shared tasks, walking dialogue, foreground/background separation, unequal eye lines, physical environment interaction.
- [ ] Establish multi-character identity separation and gaze rules.
- [ ] Define `KEY-ART`, `NARRATIVE-CINEMA`, `OBSERVATIONAL`, and `ORDINARY-LIFE` composition modes.
- [ ] Default story scenes away from heroic foreground isolation.
- [ ] Allow protagonist to be partially obscured, small, off-center, or visually subordinate.

## Priority 8 — relationship/Luminai compositions
- [ ] Define two humans + paired Luminai when relationships form.
- [ ] Visualize consent, privacy boundaries, synchronization, shared context, relationship coordination.
- [ ] Prevent Luminai reading as additional romantic partners unless explicitly canonical.

## Priority 9 — prompt/agent architecture
- [ ] Hard-separate generation context from evaluation context.
- [ ] Build clean scene-brief assembler from modular packets.
- [ ] Keep benchmark metadata external.
- [ ] Default to no legible text/no invented signage unless scene requires it.
- [ ] Record source packets/commit state for reproducibility.
- [ ] Add tool adapters only for demonstrated model-specific failures.

## Current benchmark status
- B01: rejected / invalid data
- B02: rejected as benchmark data / diagnostic only
- B03: valid clean diagnostic; strong motion/anatomy; generic world grounding
- B04: valid clean diagnostic; profile/interaction promising; severe generic-Luminai shorthand
- B05: valid clean diagnostic; crowd technically competent; recurring cyberpunk collapse, key-art bias, invented text/canon, unnecessary AI-woman imagery

## Next test

B06 should challenge difficult lighting without relying on rain, neon, futuristic-city language, or obvious sci-fi technology. The subject should remain readable under partial shadow and mixed motivated light. This will test whether apparent character identity depends excessively on the lighting/palette used in previous generations and whether the generator can produce cinematic atmosphere without falling back into cyberpunk shorthand.

## Integration targets for tonight
- `02 Story/Systems/Visual Generation/VISUAL-BENCHMARK-SUITE.md`
- `02 Story/Systems/Visual Generation/PROMPT-SYSTEM.md`
- Luminai/Daemon technology documentation
- environment packets
- technology packets
- wardrobe packets
- cinematography/composition modes
- interaction/blocking guidance
- future agent-facing generation contract
