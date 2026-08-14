---
type: production-template
status: working
updated: 2026-08-13
---

# Prompt System

## Compiler contract

The compiler must resolve identity, appearance state, era, surface layer, environment, technology, composition, image type, and render style before assembling a generation brief. `image_type` describes the purpose of the image; `render_style` describes its visual treatment. They are independent fields. The renderer receives the clean brief only. QA context is external.

Required resolution order: `identity -> appearance timeline -> era packet -> environment master -> technology packet -> story beat -> composition mode -> clean brief`.

If a load-bearing visual fact is missing, emit `NEEDS DEFINITION` rather than inventing it. See [[VISUAL-WORLD-COMPILER]].

## Source priority

When sources disagree, use this order:

1. explicit current author instruction;
2. established or working compiled story note with its status preserved;
3. approved visual-registry identity master;
4. approved supporting references;
5. scene-specific creative variation;
6. model invention only where the prompt explicitly permits it.

Do not let an attractive generated image override text canon or let an old composition override a current identity master.

## Assembly architecture

Build the prompt as a production packet rather than one ornamental paragraph:

1. **Retrieval brief** — files or story facts the model should retrieve from the vault.
2. **Identity lock** — immutable human geometry and reference priority.
3. **Narrative instant** — the change happening in this frame and what each subject wants.
4. **Physical behavior** — movement, weight, gaze, hands, interaction, and incomplete action.
5. **World packet** — era, place, materials, technology function, population, and environmental consequence.
6. **Composition mode** — `KEY-ART`, `NARRATIVE-CINEMA`, `OBSERVATIONAL`, or `ORDINARY-LIFE`; default story mode is `NARRATIVE-CINEMA`.
7. **Camera packet** — shot, lens feel, camera relation, depth, obstruction, motion, and composition.
8. **Light and color** — motivated sources, palette roles, atmosphere, and exposure logic.
9. **Continuity contract** — preserve, deliberately vary, and forbid.
10. **Output contract** — aspect ratio, frame count, duration if video, text policy, and metadata to retain.

The world packet must state the surface/hidden civilization decision explicitly. Advanced underlying infrastructure is not visible by default.

## Copyable template

**Identity:** [name, age range, role, immutable face/body traits, reference priority]

**Scene:** [location, era, time, weather, immediate story beat]

**Behavior:** [action, blocking, gaze, hands, posture, interaction, emotional state shown physically]

**World evidence:** [technology, architecture, objects, people, distance, signs of the larger system]

**Camera:** [shot size, angle, lens feel, foreground, depth, composition, aspect ratio]

**Light/material:** [motivated light sources, color temperature, texture, atmosphere, motif]

**Continuity:** Preserve [immutable traits]. Vary [pose, wardrobe, expression, camera, lighting, background] as appropriate to this scene.

**Avoid:** [duplicate subjects, frozen reference pose, generic fashion shoot, plastic skin, malformed hands, unreadable text, accidental logos, costume/anatomy drift, over-symmetry].

**Output:** [still/sequence/video, aspect ratio, framing safety, text policy, required variants, metadata].

## Variation contract

For reference-led generations, state both sides:

- **Preserve:** facial geometry, age, body proportions, stable marks, and approved identity traits.
- **Regenerate:** pose, camera, crop, wardrobe, expression, action, light, palette balance, environment, and composition unless the scene requires one of them.

Require at least three deliberate changes from the reference photograph. A useful line is: **Use the reference to identify the person, not to reconstruct the source image. Preserve identity; regenerate the photograph.**

## Example: Sylvan discovers a new capability

Use Sylvan's approved identity master only as an identity anchor. Show him in an unfamiliar moon-infrastructure observation room at dawn, turning away from the display rather than posing for it, one hand resting on a real console while a second authenticated evidence stream appears in the glass. His expression is restrained surprise; the activity of his extended Luminai mind is suggested by a warm gold pattern integrated into his reflection and the responsive environment, never by a separate humanoid companion. Use a medium-wide cinematic frame, a slightly off-axis camera, foreground structure, deep environmental perspective, practical dawn light, cool mineral surfaces, and restrained antique gold. Preserve Sylvan's facial geometry, dark hair, beard, and calm physical presence; vary his clothing, stance, camera position, and lighting from the reference. Avoid poster composition, centered portrait posing, duplicate faces, a female AI figure, decorative text, and arbitrary new canon.

## Example: Samuel under containment

Use Samuel's approved identity master only for identity. Show him mid-step in a failing command chamber as authenticated evidence severs the red authority network and containment officers enter from the side. His hands are empty and his body is trying to retain authority while the room visibly stops obeying him. Use a wide cinematic frame with practical emergency light, reflective black surfaces, crimson fragments, and a single antique-gold provenance line crossing the depth of field. Preserve age, facial structure, and crown-like authority cues; vary pose, camera, blocking, and environmental damage. Avoid a static villain portrait, repeated officers, readable interface text, and implying that the exact room is locked canon.
