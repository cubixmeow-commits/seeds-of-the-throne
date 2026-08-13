---
type: production-system
status: working
updated: 2026-08-12
---

# Visual and Image Generation

This is the reusable visual-production layer for *Seeds of the Throne*. It supplies Grok Imagine, GPT Image, and future image/video tools with story-grounded direction while keeping artwork separate from canon.

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

## Tool workflow

Grok Imagine is useful for rapid visual variation and image-to-video experiments. GPT Image is useful for controlled composition, edits, and continuity passes. Treat both as collaborators, not authorities: compare outputs against the vault, retain successful prompts, and feed only approved visual decisions back into canon.

For video, lock the character packet first, then specify a short action, camera movement, start/end state, and continuity hazards. For voice, maintain a textual voice bible—age, register, cadence, accent, pitch range, vocabulary, pauses, and emotional tendencies—until a persistent voice workflow is proven.

## Approval states

- **Candidate** — useful experiment, not canon.
- **Continuity pass** — identity and scene logic checked.
- **Approved reference** — may be reused as a visual anchor.
- **Published** — approved for the public atlas or story materials.

Images may interpret canon. They may not settle an unresolved plot question, silently change a character's identity, or turn decorative details into established history.
