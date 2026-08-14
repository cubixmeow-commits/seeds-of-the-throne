---
type: production-system
status: working
updated: 2026-08-13
---

# Feedback-Driven Scene Workspaces

Visual World Compiler v2 stores each active generation as a local scene workspace so author feedback can change the smallest relevant layer without losing successful choices.

## Record model

- **Scene** — request, resolved appearance, era, environment, manifestation controls, output purpose, reference assignments, and current revision locks.
- **Candidate** — external image path and checksum, renderer, parent candidate, source revision, and source-state fingerprints.
- **Review** — original author feedback plus parsed preserve/change categories, scope, promotion state, and canon effect.
- **Revision** — edit-versus-regenerate decision, preserved categories, clean visible change directives, and role-limited references.

Disposable scene workspaces live under `.visual-workspaces/`, which is ignored by Git. Generated candidates remain outside the repository until the author explicitly approves one. Durable visual authority remains in `skills/create-seeds-images/references/visual-registry.json` and approved source images remain under `skills/create-seeds-images/assets/approved-images/`.

## Feedback contract

Natural language is the primary interface. A useful response names both what passed and what should change:

> Keep Sylvan's identity, the beach light, and the clothing. Change the standing pose into a natural running stride, lower the camera, and make the blue Luminai tighter around his head and chest with fewer sparks.

The workspace converts this into:

- preserve locks: identity, environment, lighting, wardrobe;
- change set: action/anatomy, camera, manifestation;
- scope: scene unless explicitly widened;
- promotion: none unless explicitly requested;
- revision route: regenerate because movement and camera are structural.

Preserve locks apply to later revisions until the author changes them. A candidate reference controls only the categories the author preserved. It never becomes identity or canon authority by implication.

## Revision routing

- Identity, apparent age, action/anatomy, environment, camera, or composition changes trigger a new generation from authoritative references.
- Local manifestation, expression, wardrobe-detail, lighting, or render-treatment changes may edit the current candidate.
- When categories are mixed, structural regeneration wins.

The clean renderer directive contains approved visible instructions only. Scores, failure labels, author-evaluation language, source traces, and promotion metadata remain outside renderer context.

## Reference roles

Every image must be assigned one or more limited roles: `identity`, `appearance`, `wardrobe`, `movement`, `environment`, `composition`, or `edit-source`. Author-supplied scene references are scene-local by default. Registry identity masters remain authoritative for identity geometry.

## Commands

Create and resolve a scene:

```bash
python3 skills/create-seeds-images/scripts/visual_scene_workspace.py create \
  --scene-id sylvan-beach-running-v2 \
  --request "Sylvan runs naturally along a public beach while his Luminai manifests in clear blue" \
  --character sylvan-elaria \
  --birth-year 1985 --age 40 \
  --location surface-civilization \
  --environment-overlay coastal-public-beach \
  --manifestation luminai --manifestation-color blue \
  --render-style cinematic-photorealism
```

Register a generated candidate without copying it into Git:

```bash
python3 skills/create-seeds-images/scripts/visual_scene_workspace.py add-candidate \
  --scene-id sylvan-beach-running-v2 \
  --image /absolute/path/to/candidate.png
```

Record conversational feedback and compile a revision:

```bash
python3 skills/create-seeds-images/scripts/visual_scene_workspace.py review \
  --scene-id sylvan-beach-running-v2 \
  --candidate-id candidate-001 \
  --feedback "Keep the face and beach. Make the running stride natural and reduce the blue energy loops."

python3 skills/create-seeds-images/scripts/visual_scene_workspace.py revise \
  --scene-id sylvan-beach-running-v2
```

Use explicit `--keep` or `--change` category options when natural-language interpretation needs correction. Re-running a review creates a new immutable review record rather than overwriting the earlier interpretation.

## Promotion boundary

Feedback defaults to scene scope. `scene-local`, `reusable-guidance`, and `approved-reference` still have no story-canon effect. Proposed world definitions and canon decisions require a separate author decision and permanent-vault integration. Repetition alone never promotes a preference.
