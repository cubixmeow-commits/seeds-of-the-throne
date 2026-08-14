# Prompt contract

Every generation request must be cleanly projected for GPT Image 2 and traceable back to vault assets through the separate visual-graph trace.

## Required packet sections

### Identity authority

State which attached files control each character's identity. Say that embedded text in old references is noncanonical and must not be reproduced.

### Identity lock

Include the exact physical, age, silhouette, hair, facial-hair, wardrobe, and color traits from `visual-registry.json`. Use the same wording between generations unless the author deliberately changes the visual record.

### Style lock

Include the named style version, palette, lighting, rendering qualities, symbolic language, and avoid list from the registry.

### Scene variables

Specify only what changes: setting, action, emotion, camera, framing, composition, story moment, and aspect ratio. Distinguish literal objects from symbolic overlays.

### Output use

State whether the result is a character sheet, cinematic key art, website banner, poster background, diagram, or social image. Reserve empty space when typography will be added later.

### Exclusions

Repeat the character drift risks and project-wide avoid list. Ask for no letters, words, captions, logos, or watermarks unless text rendering is the explicit task.

## Reference behavior

- Attach the smallest set that proves identity and style.
- Give identity references priority over composition references.
- Use paired references for the current Samuel and Sylvan system, but tell the model which side belongs to which character.
- If a model supports reference weighting, assign stronger weight to the clearest face reference and moderate weight to broad composition references.
- Keep renderer execution parameters in the execution-plan section rather than mixing them with story, world, style, or composition instructions.

## Iteration behavior

On revision, describe the failed dimension precisely: face drift, age drift, hair drift, silhouette drift, wardrobe drift, palette drift, composition, or unwanted text. Preserve everything that already passed. Do not ask for a complete reinterpretation when a targeted correction is possible.
