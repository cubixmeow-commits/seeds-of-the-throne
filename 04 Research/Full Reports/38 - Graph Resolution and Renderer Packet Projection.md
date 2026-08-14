---
type: research-report
status: advisory-non-canon
updated: 2026-08-13
research_sequence: 38-of-40
produced_by: OpenAI Codex (Sol)
---

# Graph Resolution and Renderer Packet Projection

## Purpose

This report defines the compiler boundary between a validated visual subgraph and the clean GPT Image 2 packet.

## Executive finding

Graph resolution and prompt projection should be two separate phases with separately validated outputs. Resolution produces a complete scene model with source-bearing claims. Projection converts only renderer-relevant, observable values into concise image instructions.

JSON Schema is appropriate for structural validation of the graph, resolved-scene record, source trace, and packet manifest. SHACL provides a useful conceptual model for graph constraints and severity-bearing validation results. W3C PROV supports tracing the resolved scene and generated image as entities derived through compilation and rendering activities.

## Resolution pipeline

```text
scene intent
  -> required node set
  -> claim collection
  -> qualifier filtering
  -> conflict/supersession resolution
  -> temporal intersection
  -> inheritance and override
  -> visibility filtering
  -> completeness validation
  -> resolved scene model
  -> renderer projection
```

No renderer wording should be generated before completeness validation passes.

## Resolved scene model

The model should contain typed fields, not prose:

- participants and identity references;
- appearance states and chronological/apparent ages;
- time, era, place, and environment overlays;
- wardrobe resolution;
- action and relationship participation;
- technology capabilities and visible consequences;
- manifestation and viewpoint;
- image type, composition, camera, style, and output settings;
- negative constraints;
- claim IDs supporting every field.

## Merge semantics

Each field needs one declared merge behavior:

- `replace`: scene-specific value replaces inherited default;
- `append`: compatible constraints accumulate;
- `intersect`: allowed ranges narrow;
- `prohibit`: inherited value may not appear;
- `select-one`: exactly one eligible value must resolve;
- `derived`: computed from explicit inputs;
- `unresolved`: blocks or requires waiver.

Free-form dictionary merging is forbidden because it can silently combine alternatives.

## Projection rules

Renderer projection should:

1. preserve identity-reference paths and purpose labels;
2. translate structured values into concrete observable language;
3. retain unresolved epistemic boundaries only as prohibitions against invention;
4. remove claim IDs, file paths other than required image attachments, citations, confidence, QA, and alternatives;
5. keep execution parameters in a separate execution-plan section;
6. produce a packet fingerprint linked to the resolved-scene fingerprint.

The trace should map packet section and field back to resolved fields, claim IDs, graph nodes, and vault sources. This mapping remains external.

## Validation severities

- `BLOCK`: no packet emitted.
- `WARN`: packet emitted with external diagnostic.
- `INFO`: provenance or optimization note.

Severity does not alter story status. A warning is not permission to invent.

## Failure modes

- Graph IDs or QA language appearing in the image.
- Prompt prose generated before conflicts are checked.
- Undeclared merge behavior.
- Negative constraints contradicting positive instructions.
- File citations replacing actual visual detail.
- Trace and packet fingerprints becoming unsynchronized.

## V2 requirements

- Define JSON Schemas for claims, graph, scene intent, resolved scene, trace, and packet manifest.
- Implement an explicit resolution DAG and merge policy registry.
- Validate resolved scene before projection.
- Add field-level trace links and fingerprints.
- Keep clean packet, execution plan, retrieval receipt, and QA as distinct artifacts.
- Add tests proving diagnostic content cannot reach renderer projection.

## Sources

- JSON Schema, [Specification 2020-12](https://json-schema.org/specification).
- W3C, [Shapes Constraint Language](https://www.w3.org/TR/shacl/).
- W3C, [PROV-O](https://www.w3.org/TR/prov-o/).
- Seeds of the Throne, `PROMPT-SYSTEM.md` and `VISUAL-WORLD-COMPILER.md`.

## Boundary

This report specifies the v2 compiler architecture but does not implement it.
