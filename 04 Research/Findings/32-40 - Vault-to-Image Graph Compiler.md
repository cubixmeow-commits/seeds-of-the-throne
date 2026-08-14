---
type: research-findings
status: advisory-non-canon
updated: 2026-08-13
source_reports: 32-40
---

# Vault-to-Image Graph Compiler — Synthesis of Reports 32–40

## Finding

The next Visual World Compiler should not retrieve lore and ask a renderer to interpret it. It should resolve a small, source-traceable claim graph into a clean visual packet. Authority, time, relationships, environment, technology, uncertainty, and artifact freshness are separate compiler concerns and should remain separate until projection.

This is an engineering synthesis, not story canon. It does not adopt any unresolved visual design.

## Recommended architecture

```text
vault sources
  → claim extraction and source provenance
  → typed authority graph
  → scene-intent parsing
  → smallest sufficient subgraph
  → conflict, time, place, role, and visibility resolution
  → missing-definition validation
  → clean observable renderer packet
  → GPT Image
  → QA and provenance record
```

The clean renderer packet and the compiler trace are sibling outputs. The renderer receives observable instructions only; QA rules, citations, rejected alternatives, hidden motives, and unresolved branches remain in the trace.

## Ten governing findings

1. **Authority belongs to individual claims.** File dates and file-level labels are insufficient. Each load-bearing claim needs source, status, scope, and provenance.
2. **Conflict is graph data.** Contradiction, supersession, deprecation, and non-combinability should be explicit edges. No general “latest wins” rule is safe.
3. **Image time is an event-resolved state.** Equivalent year, birth-year-plus-age, chronological age, apparent age, rejuvenation state, role, and wardrobe resolve through separate temporal relations.
4. **Relationships require qualified participation.** Direction, interval, public visibility, privacy, and scene role belong on relationship or participation records rather than being flattened into permanent character labels.
5. **Environments are layered.** Geography, culture, era, social layer, site function, weather, condition, and event overlays should resolve over an environment master. Surface civilization and hidden civilization remain distinct layers.
6. **Technology is modeled by capability before appearance.** Access, controller, users, affected populations, state, concealment, and physical consequences can be established while hardware appearance remains undefined.
7. **Retrieval is bounded evidence selection.** Resolve known IDs and graph neighbors first. Semantic retrieval may supply candidate evidence, but cannot promote authority or settle ambiguity. Every selection needs a receipt.
8. **Resolution and projection are separate.** The resolved subgraph retains IDs, provenance, alternatives, and diagnostics. The renderer projection strips those elements and emits only approved observable instructions.
9. **Uncertainty is typed.** Missing identity anchors, contradictory canon, undefined appearance, irrelevant unknowns, and deliberately hidden facts have different severity. A scoped author waiver permits an experiment but never creates canon.
10. **Compilation is incremental.** Claim fingerprints and reverse dependencies should identify stale packets, benchmarks, references, and images after a vault change, with an explainable path from the changed claim.

## Core records for the next version

- `Claim`: subject, predicate, value or object, status, scope, source, provenance, confidence, and temporal qualifiers.
- `Conflict`: participating claims, relation type, severity, and explicit resolution when one exists.
- `Event` or `Interval`: time coordinates, participants, roles, place, and state transitions.
- `RelationshipParticipation`: parties, direction, role, interval, visibility, privacy, and observable consequences.
- `PlaceLayer`: geography, culture, era, social layer, site function, conditions, and inheritance source.
- `Capability`: function, dependencies, access, control, affected entities, state, visibility, and approved visible consequences.
- `SceneIntent`: subjects, action, time, place, purpose, viewpoint, manifestation request, image type, and render style.
- `RetrievalReceipt`: deterministic seeds, traversal rules, semantic candidates, selected evidence, exclusions, and score reasons.
- `ResolutionTrace`: every resolved property, merge decision, graph dependency, source claim, conflict result, and gap.
- `RendererPacket`: identity anchors, appearance state, environment, wardrobe, action, relationships-as-blocking, visible effects, composition mode, image type, render style, and negative constraints.
- `Gap`: category, affected property, severity, dependency frontier, question, and disposition.
- `AuthorWaiver`: exact scene and property scope, permitted invention, expiration, issuer, and non-canon warning.
- `ArtifactDependency`: packet or image fingerprint, upstream claims and resolver version, validity state, and stale reason.

## Resolution rules that should become invariants

- A rejected, obsolete, unresolved, research-only, or generated-image claim cannot silently override established story authority.
- A generic era or place envelope can constrain an image but cannot invent a named character appearance or named location.
- Apparent age never defaults to chronological age when rejuvenation could materially change the image.
- Hidden motives and private history do not enter renderer context unless translated into an approved observable action or expression.
- Established function does not authorize invented hardware.
- `image_type` and `render_style` remain independent fields.
- A blocking missing definition stops production compilation; an exploratory waiver must be explicit, narrow, and temporary.
- Every renderer instruction must be traceable to a resolved graph property or an explicit scene variable.
- A changed upstream claim must either leave an artifact valid or mark it stale; silent uncertainty is not a valid state.

## Recommended development sequence

1. Define claim, qualifier, provenance, conflict, and status schemas.
2. Implement authority resolution and temporal/event resolution.
3. Add qualified relationships, layered places, and capability/visibility models.
4. Parse scene intent and select a bounded subgraph with a retrieval receipt.
5. Separate graph resolution from clean renderer-packet projection.
6. Add typed gap reports and scoped author waivers.
7. Add fingerprints, reverse dependencies, stale-artifact reports, and targeted regression selection.

Each stage should have fixture-based tests before the next layer is allowed to consume it.

## Immediate benchmark scenarios

- Sylvan at multiple equivalent years: chronological age and apparent age resolve independently, with wardrobe constrained by the correct era.
- Sylvan running on a beach while her Luminai manifests: identity, natural motion, place, contemporary surface civilization, and blue person-radiated energy resolve without turning the Luminai into a separate person.
- Samuel during the Great War: role-specific apparent age resolves to approximately forty without rewriting his chronology.
- A concealed advanced system in an ordinary setting: the packet shows approved consequences while withholding undefined hardware.
- A two-character scene with a private adversarial history: blocking reflects only approved observable tension; the history itself never appears in renderer context.
- A changed appearance anchor: only dependent packets, benchmarks, and images become stale, and each stale result explains why.

## Remaining author definitions exposed by the research

- Approved identity and appearance anchors for major characters at load-bearing eras.
- Rejuvenation transition points and the allowed shape of apparent-age change between anchors.
- Environment masters for named Seeds locations, including culture, class, infrastructure, maintenance, and ordinary life.
- A controlled vocabulary for Luminai and daemon manifestation states, intensity, color, concentration, and behavioral effects.
- Technology visibility decisions where capability is known but visible consequence or physical form is not.
- Which unresolved graph gaps may be explored with waivers and which must always block.

## Source reports

- [[04 Research/Full Reports/32 - Canon Authority Conflict and Supersession]]
- [[04 Research/Full Reports/33 - Temporal Event and Appearance Graphs]]
- [[04 Research/Full Reports/34 - Character Relationship and Role Graphs]]
- [[04 Research/Full Reports/35 - Place Culture and Environment Graphs]]
- [[04 Research/Full Reports/36 - Technology Capability and Visibility Graphs]]
- [[04 Research/Full Reports/37 - Scene Requests and Relevant Subgraph Selection]]
- [[04 Research/Full Reports/38 - Graph Resolution and Renderer Packet Projection]]
- [[04 Research/Full Reports/39 - Uncertainty Missing Definitions and Author Waivers]]
- [[04 Research/Full Reports/40 - Incremental Graph Updates and Regression Impact]]

## Decision status

Open. These findings are ready to guide the next implementation pass, but none becomes production behavior until it is implemented and regression-tested.
