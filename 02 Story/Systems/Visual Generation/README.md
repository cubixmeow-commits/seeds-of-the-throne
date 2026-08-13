---
type: production-system
status: working
updated: 2026-08-13
---

# Visual and Image Generation

This is the reusable visual-production layer for *Seeds of the Throne*. It supplies Grok Imagine, GPT Image, and future image/video tools with story-grounded direction while keeping artwork separate from canon.

The demonstrated Grok workflow can access the GitHub vault and retrieve story and approved visual material before generation. Use that access to ground imagery in the repository rather than treating a short user prompt as the entire brief. Repository access is a workflow capability to verify at the start of a generation session, not permission for the model to invent missing canon.

## Prime rule

**Preserve identity; regenerate the photograph.** A reference image answers “who is this?” It does not require the model to copy the same pose, crop, wardrobe, lighting, or emotional moment.

## Prompt assembly

Build each request from these layers, in order:

1. **Canon anchor** — character, age range, identity traits, relationship, and approved visual reference.
2. **Story beat** — what is happening now, what changed immediately before, and what the subject wants.
3. **Place and era** — location, technology level, weather, season, social context, and environmental evidence.
4. **Action and behavior** — movement, blocking, hands, gaze, posture, interaction, and a specific moment rather than a static pose.
5. **Cinematography** — shot size, camera position, lens feel, depth, foreground obstruction, composition, and aspect ratio.
6. **Light and material** — time of day, motivated sources, color temperature, surfaces, atmosphere, and visual motif.
7. **Continuity constraints** — immutable traits to preserve and scene-variable traits deliberately allowed to change.
8. **Negative constraints** — no duplicate people, plastic skin, frozen posing, accidental text, costume drift, anatomy errors, or generic “AI” styling.

See [[PROMPT-SYSTEM]] for the assembly contract and copyable prompt shape.

## Reusable scene recipe

`[subject + identity anchor] in [place/era], [story beat], [specific action], [emotional state shown through behavior], [environmental storytelling], photographed as [camera language], with [lighting/material language]. Preserve [immutable traits]. Vary [scene variables]. Avoid [negative constraints].`

## Continuity packets

Each major character, environment, and technology should have a compact packet containing:

- immutable identity traits;
- flexible scene traits;
- approved reference images and reference priority;
- wardrobe and prop logic;
- emotional and behavioral range;
- palette and recurring motifs;
- known drift warnings;
- approved generations with date, tool, prompt, and status.

Use [[CHARACTER-IDENTITY-LOCKS]] for the identity hierarchy. World packets follow [[ENVIRONMENTS-AND-TECHNOLOGY]]. Camera and lighting decisions follow [[CINEMATOGRAPHY]].

## Production section

- [[PROMPT-SYSTEM]] — prompt architecture, source priority, and assembly.
- [[CHARACTER-IDENTITY-LOCKS]] — immutable identity, flexible scene traits, multi-character continuity, and drift control.
- [[ENVIRONMENTS-AND-TECHNOLOGY]] — place, era, material, infrastructure, and technology packets.
- [[CINEMATOGRAPHY]] — camera, blocking, motion, light, and natural photographic variation.
- [[SCENE-RECIPES]] — reusable image and sequence recipes grounded in story beats.
- [[VIDEO-VOICE-CONTINUITY]] — shot motion, performance, temporal continuity, and textual voice bibles.
- [[OUTPUT-FORMATS]] — deliverable specifications, metadata, naming, and approval packages.

## Tool workflow

Grok Imagine is useful for vault-grounded rapid visual variation and image-to-video experiments. GPT Image is useful for controlled composition, edits, and continuity passes. Treat both as collaborators, not authorities: compare outputs against the vault, retain successful prompts, and feed only approved visual decisions back into canon.

A generation pass should:

1. retrieve the relevant canon, visual registry entry, and approved identity references;
2. separate immutable identity from scene variables;
3. assemble a scene around action and story change, not portrait description alone;
4. request materially different camera, blocking, wardrobe, light, and environment variants;
5. evaluate identity, story logic, anatomy, environment, and accidental canon separately;
6. retain prompt, model/tool, date, references, settings when visible, and approval state with the output.

For video, lock the character packet first, then specify a short action, camera movement, start/end state, and continuity hazards. For voice, maintain a textual voice bible—age, register, cadence, accent, pitch range, vocabulary, pauses, and emotional tendencies—until a persistent voice workflow is proven.

## Rigidity test

A generation has copied the photograph instead of preserving identity when it unnecessarily repeats the reference's pose, crop, wardrobe color, expression, light direction, background, or composition. Correct by anchoring facial geometry and other immutable traits explicitly while ordering the model to change at least three scene variables. Identity continuity should survive a new photograph.

## Approval states

- **Candidate** — useful experiment, not canon.
- **Continuity pass** — identity and scene logic checked.
- **Approved reference** — may be reused as a visual anchor.
- **Published** — approved for the public atlas or story materials.

Images may interpret canon. They may not settle an unresolved plot question, silently change a character's identity, or turn decorative details into established history.
