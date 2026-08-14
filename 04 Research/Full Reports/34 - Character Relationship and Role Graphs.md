---
type: research-report
status: advisory-non-canon
updated: 2026-08-13
research_sequence: 34-of-40
produced_by: OpenAI Codex (Sol)
---

# Character, Relationship, and Role Graphs

## Purpose

This report defines how enduring relationships and temporary scene roles become observable behavior and blocking without exposing private or unresolved story knowledge.

## Executive finding

Relationships need qualified records rather than bare edges such as `SYLVAN -> OPPOSES -> SAMUEL`. A relationship may change over time, be asymmetric, be unknown to one participant, remain hidden from observers, or contain unresolved motives. Roles are even more contextual: “investigator,” “parent,” “commander,” “prisoner,” and “witness” may apply only during one event.

The graph should therefore reify relationships and scene roles as records with participants, direction, interval, knowledge, visibility, status, and allowed visual consequences. Wikidata's qualifiers/references and CIDOC CRM's event-centered participation model both support this approach.

## Relationship record

```yaml
relationship_id: relationship:sylvan-samuel-opposition
type: adversarial | familial | romantic | political | institutional | cognition-partner
participants:
  - entity: character:sylvan-elaria
    role: investigator
  - entity: character:samuel-franklin
    role: concealed-controller
direction: asymmetric
valid_time: interval-id
knowledge:
  sylvan-elaria: partial | aware | unaware
  samuel-franklin: aware
visibility: private | public | concealed | inferred
status: working
source_refs: []
visual_projection: []
```

The `visual_projection` must contain only author-approved observable consequences, not narrative explanations.

## Relationship versus scene role

An enduring relationship answers “what connects these people?” A scene-role edge answers “what is each person doing here?” The latter should attach to a scene/event node:

```text
scene -> HAS_PARTICIPANT -> character
participation -> PERFORMS_ROLE -> investigator
participation -> HAS_ACTION -> running / watching / withholding evidence
participation -> KNOWS -> bounded scene fact
```

This permits the same two characters to be blocked differently in confrontation, surveillance, negotiation, or memory.

## Projection into imagery

Only observable fields should reach the renderer:

- distance and orientation;
- gaze and eyeline;
- touch or avoidance;
- who initiates or follows motion;
- who controls access, exits, objects, or attention;
- interruption, concealment, protection, deference, or resistance;
- whether the relationship is publicly legible in this scene.

Hidden parentage, secret allegiance, private attraction, or an unresolved betrayal must not become visible shorthand unless a scene action establishes it.

## Multi-character identity assignment

Each visible body needs one participation record and one identity node. Reference attachments must be labeled by participant. If the renderer cannot reliably preserve all identities, the compiler should reduce crowd detail, move minor people into non-identifying depth, or block the image rather than merge identities.

## Privacy and cognition partners

Luminai integration should not be represented as a separate romantic or social participant. A manifestation node modifies the integrated human's presentation. Relationship synchronization, private knowledge, and shared cognition require explicit visibility permission before projection.

## Failure modes

- Bare relationship labels converted into melodramatic poses.
- Unresolved romance rendered as established intimacy.
- Secret control expressed through supernatural puppeteering without story cause.
- Every participant facing the camera in a lineup.
- Identities or roles merging across references.
- Private knowledge becoming visible interface text.

## V2 requirements

- Add qualified relationship and participation records.
- Separate enduring relationships from event-specific roles.
- Add per-participant knowledge and scene visibility.
- Require an observable `visual_projection` allowlist.
- Map each rendered body to exactly one participation and identity.
- Add relationship privacy and accidental-canon tests.

## Sources

- Wikidata, [Data model and restrictive qualifiers](https://www.wikidata.org/wiki/Help:Data_model).
- CIDOC CRM, [Formal definition and event-centered historical relations](https://cidoc-crm.org/sites/default/files/Documents/cidoc_crm_version_7.1.3.html).
- Seeds of the Throne, `03 Context/CAST.md` and relationship-development files.

## Boundary

No new relationship, role, or private knowledge is established by this report.
