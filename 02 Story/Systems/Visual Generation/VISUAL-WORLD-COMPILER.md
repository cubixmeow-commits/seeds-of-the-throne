---
type: production-system
status: working
updated: 2026-08-13
---

# Visual World Compiler

The compiler turns a short scene request into a reproducible, vault-grounded generation packet. Version 2 also maintains a feedback-driven scene workspace so accepted image properties survive targeted revisions. It is a worldbuilding completeness test as well as a prompt builder.

## Pipeline

`vault canon -> visual entity graph -> resolved scene card -> clean generation brief -> GPT Image 2 -> candidate -> author review -> revision locks and visible deltas -> GPT Image 2 -> explicit promotion -> vault`

The renderer receives only the clean generation brief and approved reference images. Benchmark IDs, scores, findings, rejection reasons, and QA metadata remain outside the renderer context. This separation is mandatory because B01 and B02 showed that evaluation language can become visible image content.

## Visual entity graph

The machine-readable graph lives in `skills/create-seeds-images/references/visual-registry.json` and uses the existing visual registry as its source of truth.

- `identity` resolves an authoritative character record and reference priority.
- `appearance_timeline` resolves role, era, apparent biological age, rejuvenation stage, stable traits, and transformable traits. Chronological age and apparent age are separate fields.
- `era_packet` resolves a surface-civilization envelope. Sylvan's birth-equivalent year is approximately 1985; when a scene gives birth-equivalent year plus age, the compiler resolves the surrounding era from that sum.
- `environment_master` resolves place, social layer, materials, population, infrastructure, and unresolved visual facts.
- `manifestation_packet` resolves Luminai or Daemon energy behavior without creating a second person.
- `wardrobe_profile` resolves clothing from character, equivalent year, age, role, activity, weather, and social position.
- `rejuvenation_system` separates normalized societal treatment from the apparent-age state produced for a particular role.
- `technology_packet` describes function and consequence before appearance.
- `story_beat` supplies the concrete change and physical behavior.
- `composition_mode` controls whether the image is iconic, scene-driven, observed, or ordinary life.
- `image_type` describes what the image is for. `render_style` describes how it is rendered. They must never be conflated.

### Typed graph and source catalog

Report 31 adds the first implemented vault-to-image graph layer. It does not copy character or world facts into a second database. Each graph node contains a stable ID, type, status, `payload_ref` pointing to the existing registry value, and `source_refs` pointing to a source catalog.

The source catalog distinguishes author decisions, compiled story authority, approved visual authority, production rules, working context, research, and external operational documentation. Renderer documentation may authorize renderer behavior but can never establish a story fact. Research may inform a later author decision but cannot directly override story or visual authority.

The compiler deterministically selects the smallest currently supported subgraph from character, resolved appearance, wardrobe, era, environment, manifestation, rejuvenation, composition, style, and renderer nodes. The clean packet receives only the resolved visible instructions. `--trace` writes the selected nodes, payload pointers, source files, authority classes, and traversed edges to stderr so the trace cannot leak into generated imagery.

The current graph is an explicit production index, not arbitrary Markdown ingestion. Reports 32–40 are complete and define the deeper claim-level architecture. Version 2 begins with the author-facing scene, candidate, review, and revision loop; conflict resolution, full temporal intervals, relationship edges, named-place inheritance, semantic retrieval, typed waivers, and repository-wide incremental rebuilding remain later implementation layers.

## Feedback-driven scene workspaces

`visual_scene_workspace.py` persists disposable local workspaces under `.visual-workspaces/`. Each workspace stores a resolved scene card, role-limited references, renderer packet, source trace, candidate checksums, immutable reviews, revision locks, and clean edit or regeneration directives. See [[FEEDBACK-DRIVEN-SCENES]].

Feedback is scene-local by default. Passing dimensions become revision locks; requested changes unlock only their affected layers. Structural identity, age, action, environment, camera, and composition changes regenerate from authoritative references. Local manifestation, expression, lighting, wardrobe-detail, and treatment changes may edit a candidate.

Candidate images never acquire identity, world, or canon authority by being attractive, repeatedly used, or preserved in a revision. Promotion remains an explicit separate action.

## Surface versus hidden civilization

An advanced underlying civilization does not make every visible scene futuristic. The resolved era and surface layer control ordinary visible life. Colonization infrastructure remains hidden, mediated, disguised, or restricted unless the scene explicitly authorizes `subtle`, `controlled`, or `explicit` visibility.

## Composition modes

- `KEY-ART` — iconic promotional framing.
- `NARRATIVE-CINEMA` — default story mode; a specific dramatic instant and natural blocking.
- `OBSERVATIONAL` — the camera may subordinate, occlude, or place the protagonist at the edge of ordinary life.
- `ORDINARY-LIFE` — mundane activity and social context without heroic visual privilege.

## Missing-definition behavior

If a request depends on an undefined school, environment, wardrobe rule, technology, or appearance state, the compiler emits only a `NEEDS DEFINITION` report and exits without a generation packet. An author may explicitly waive a detail for a non-load-bearing exploratory image, but the waiver is recorded outside the renderer.

Luminai/Daemon manifestation, Sylvan's wardrobe reference, and the societal basis of rejuvenation are now defined. Current high-priority definitions remain Seeds-specific ordinary environments, visible technology packets, in-world observability of cognition energy, exact rejuvenation procedures and limits, and approved anchor states between long-lived appearances.

The first v2 environment overlay is `coastal-public-beach`: a generic unnamed Southern-California-development-reference envelope layered over surface civilization. It is sufficient for exploratory scenes but cannot establish a named Seeds location.

## Authoritative manifestation and wardrobe rules

Luminai and Daemon manifestation is energy radiating from the integrated person, concentrated around the head/brain and chest. It never creates a separate humanoid figure. Luminai energy is coherent and uses the established gold/communication-blue grammar; Daemon energy uses the same embodied structure in constricted, recursive, or fractured form with the established crimson/ember grammar. Whether this energy is literally visible in-world remains open.

Sylvan's ordinary wardrobe uses middle-class urban Los Angeles and broader United States clothing from 1985 through the present as a development reference, resolved by era, age, role, activity, and weather, then translated into the invented culture without real brands or locations. The black structured identity-master coat is not his everyday default.

## Renderer boundary

The current renderer is OpenAI GPT Image 2 only. No Grok, Gemini, or other renderer adapter is included in v1. Generated images remain candidates until external identity, scene, environment, text, anatomy, and accidental-canon QA is complete.

Report 21 established the renderer execution contract from current official documentation. Successful packets now declare generation intent, API or tool route, output size, quality, format, compression when relevant, background, automatic high-fidelity reference handling, and provenance requirements. One-shot generation and edits resolve to the Image API; iterative edits resolve to the Responses API unless the active in-app tool is explicitly recorded. These execution settings remain separate from `image_type`, `composition_mode`, and `render_style`.

Because GPT Image 2 still has documented recurring-character and precise-composition limitations, multiple references are treated as labeled evidence rather than a guarantee. Result records must preserve the original clean brief, revised prompt when available, model alias and observed version, route, reference checksums, output controls, request date, and result status.

```bash
python3 skills/create-seeds-images/scripts/build_prompt_packet.py \
  --character sylvan-elaria \
  --scene "Sylvan discovers authenticated evidence of Samuel's Great War activity" \
  --image-type observational-scene \
  --render-style cinematic-photorealism \
  --composition OBSERVATIONAL \
  --birth-year 1985 --age 40 --location surface-civilization \
  --manifestation luminai --trace
```
