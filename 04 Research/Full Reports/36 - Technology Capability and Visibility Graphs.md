---
type: research-report
status: advisory-non-canon
updated: 2026-08-13
research_sequence: 36-of-40
produced_by: OpenAI Codex (Sol)
---

# Technology, Capability, and Visibility Graphs

## Purpose

This report defines how advanced systems become visible consequences without forcing every capability into a glowing device or interface.

## Executive finding

Technology should be modeled first by capability, interaction, access, controller, affected entity, operating state, and visible consequence. Appearance is a separate optional layer. The W3C Web of Things model is useful because it separates a thing's metadata from interaction affordances: properties, actions, and events. SysML similarly emphasizes traceability among structure, behavior, requirements, interfaces, and verification.

For Seeds, the decisive addition is observer-specific visibility. A technology may operate, affect a person, or shape an environment while remaining hidden, disguised, mediated through ordinary systems, or perceptible only through consequences.

## Technology records

```yaml
technology_id: technology:example
kind: personal | institutional | environmental | biological | colony-scale
status: working
capabilities: []
properties: []
actions: []
events_emitted: []
controllers: []
authorized_users: []
affected_entities: []
dependencies: []
operating_states: []
failure_states: []
appearance_definition: null
visible_consequences: []
source_refs: []
```

Capabilities state what the system can accomplish. Affordances state how an authorized participant can sense or act through it. Events state what changes can be observed. None of these automatically defines casing, screens, beams, rooms, or symbols.

## Visibility record

```yaml
visibility:
  mode: hidden | consequence-only | disguised | mediated | controlled | explicit
  observers: [participant-or-role]
  conditions: [scene-state]
  perceptible_evidence: []
  forbidden_inferences: []
```

Visibility must be resolved for the scene's observer and camera viewpoint. Audience-only visualizations, diagnostic views, subjective cognition views, and literal in-world visibility are different modes.

## Function-to-image projection

Projection should prefer:

1. physical consequence;
2. changed human behavior;
3. changed environment or access;
4. ordinary mediated interface appropriate to the surface era;
5. explicit advanced hardware only when defined and visible.

For rejuvenation, healthy tissue, movement, recovery, and apparent age are currently defined consequences. A chamber or beam remains undefined. For Luminai/Daemon manifestation, energy around the integrated human is a visual-production representation, not proof of literal observer perception.

## Access and power

The graph should identify who can invoke, interrupt, audit, override, or be affected by a capability. This allows imagery to show control through doors, workflow, human response, environmental changes, or denied access instead of generic command holograms.

## Failure modes

- One visual device invented for a distributed system.
- Blue holograms used as universal positive technology.
- Red fire used as universal corruption.
- Synthetic people shown with metal joints or glowing eyes without established markers.
- Hidden colony infrastructure appearing in ordinary streets.
- Capability and moral authority treated as equivalent.

## V2 requirements

- Add capability, affordance, access, dependency, state, and failure nodes.
- Separate function, consequence, appearance, and visibility.
- Resolve visibility by observer and scene conditions.
- Permit consequence-only imagery when hardware is undefined.
- Block explicit hardware if no appearance definition exists.
- Add technology-shorthand and surface-leakage tests.

## Sources

- W3C, [Web of Things Thing Description 1.1](https://www.w3.org/TR/wot-thing-description/).
- Object Management Group, [SysML 2.0 specification](https://www.omg.org/spec/SysML/2.0).
- Seeds of the Throne, `Advanced Technology Ecology.md` and `ENVIRONMENTS-AND-TECHNOLOGY.md`.

## Boundary

This report does not define new devices, interfaces, rejuvenation procedures, or manifestation visibility canon.
