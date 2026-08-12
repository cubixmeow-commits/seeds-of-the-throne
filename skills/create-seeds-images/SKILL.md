---
name: create-seeds-images
description: Create consistent Seeds of the Throne character art, cinematic key art, posters, diagrams, and website imagery from the vault's canonical visual registry and approved reference images. Use when an agent needs to generate, revise, evaluate, approve, store, or recreate story images across Gemini, ChatGPT, Claude, or another image-capable system while preserving character identity, the dark red-and-gold visual language, current terminology, and separation between visual interpretation and story canon.
---

# Create Seeds Images

Use the vault as the portable source of truth. Treat prompts and generated images as reproducible project assets, not as facts about the story.

## Load the required context

1. Read root `AGENTS.md`, `03 Context/CURRENT.md`, and `03 Context/RULES.md`.
2. Read `references/visual-registry.json`. This is the canonical machine-readable visual registry.
3. Read `references/prompt-contract.md` before preparing a generation request.
4. Read `references/consistency-scorecard.md` before approving or storing an output.
5. Read `references/identity-master-approval.md` when Samuel or Sylvan is present.
6. Read only the story notes needed for the requested scene. Never infer new canon from an image.

## Build a prompt packet

Run:

```bash
python3 skills/create-seeds-images/scripts/build_prompt_packet.py \
  --character samuel-franklin \
  --character sylvan-elaria \
  --scene "Samuel and Sylvan confront one another across a fractured reality interface" \
  --purpose "cinematic website key art" \
  --aspect-ratio "16:9"
```

Attach every reference image listed in the packet to the image model. The plain-text packet is model-neutral and may be pasted into Gemini or any other capable system.

Preserve this order:

1. identity authority and attached references;
2. locked character traits;
3. locked project style;
4. scene, action, emotion, and composition;
5. output purpose and aspect ratio;
6. exclusions and continuity warnings.

Keep character identity instructions stable. Change scene variables, not facial anatomy. Generate typography separately whenever practical.

## Generate and evaluate

Use an image generator that accepts reference images. Tell it that the references control identity and the prompt controls the new scene.

Generate a small comparison set. Evaluate each output with `references/consistency-scorecard.md`. Reject an image when either character scores below 4 for identity, when Samuel and Sylvan become visually interchangeable, or when obsolete text from a reference appears.

Do not promote the most attractive image automatically. Prefer the image that best preserves identity, silhouette, age, wardrobe language, palette, and story function.

## Store approved work

Keep original source files. Do not overwrite an approved image.

For a newly approved character image:

1. Place it under `assets/approved-images/<character-id>/` with a stable descriptive filename.
2. Add it to that character's `references` list in `references/visual-registry.json`.
3. Record status as `canonical`, `supporting`, `candidate`, or `deprecated`.
4. Record the date, generator, source prompt or prompt-packet path, intended use, and SHA-256 checksum.
5. Run `python3 skills/create-seeds-images/scripts/validate_visual_system.py`.
6. Record a dated development note if the image establishes a deliberate new visual decision.

Never use an unapproved generated image as the sole identity reference for later work. Promotion must be deliberate so drift does not become self-reinforcing.

## Storage and delivery

Read `references/storage-policy.md` before adding approved images or public derivatives.

Keep two deliberately different layers:

- `assets/approved-images/` stores approved source images used for reproduction, editing, or future prompting.
- `docs/assets/images/` stores compressed display derivatives used by GitHub Pages.

Prepare both layers and print registry-ready metadata with:

```bash
python3 skills/create-seeds-images/scripts/prepare_approved_image.py \
  --source /path/to/approved.png \
  --character samuel-franklin \
  --slug samuel-scene-name-v1
```

Do not place rejected generations in the repository. Preserve a candidate only when the author requests it or when it documents a useful comparison. Never overwrite a source image or recompress a compressed derivative repeatedly.

Record approved narrative sequences in `references/visual-registry.json` under `story_sequences`. Sequence order is storytelling information, not character identity authority.

## Add a character

Use `references/character-record-template.md`. Establish a minimum identity set before producing complex group scenes:

1. exact straight-on front view;
2. strict 90-degree side profile;
3. front three-quarter identity portrait.

Add a neutral full-body view and expression study when the character enters active visual production. Keep lighting, apparent age, grooming, and wardrobe stable across angles.

Add the character only after the author approves the identity. Until then, mark all images `candidate`.

## Guardrails

- The older crowned man in the current references is **Samuel Franklin**. The younger dark-haired man is **Sylvan Elaria**.
- Some current references contain obsolete labels such as George or Lumina. Ignore all embedded text and metadata as story authority. Use the files only for visual identity, wardrobe, palette, lighting, and composition.
- Use **Luminai**, never Lumina, for the current term.
- Do not use em dashes in public-facing image copy.
- Do not identify the characters as real people or imitate a named living artist.
- Do not let image generation resolve an open question, alter lineage, invent a costume as canon, or change a character's age without author approval.
- Create artwork without text first when possible. Add exact titles and captions in HTML or a layout tool afterward.
- Treat front and strict-profile masters as required identity geometry. Do not substitute two different three-quarter views.
