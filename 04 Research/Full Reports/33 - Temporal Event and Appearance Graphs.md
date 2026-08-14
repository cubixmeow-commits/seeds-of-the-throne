---
type: research-report
status: advisory-non-canon
updated: 2026-08-13
research_sequence: 33-of-40
produced_by: OpenAI Codex (Sol)
---

# Temporal, Event, and Appearance Graphs

## Purpose

This report defines how story chronology becomes a coherent visual state when chronological age, apparent age, rejuvenation, role, and surface-equivalent era can diverge.

## Executive finding

V2 should model time with event and interval nodes, not scattered year strings. OWL-Time provides the useful distinction among instants, intervals, duration, temporal position, and interval relations. CIDOC CRM adds an important historical principle: uncertain dates should be represented as bounded spans and events, not false precision.

The image compiler needs two linked clocks:

- **story chronology:** the character's actual sequence of events and chronological age;
- **surface-equivalent chronology:** the visible technological and cultural envelope used for imagery.

Apparent biological age is a state produced by biology and rejuvenation. It is not calculated from chronological age unless a defined appearance transition says so.

## Temporal records

```yaml
temporal_entity:
  id: interval:samuel-great-war-role
  kind: interval | instant | event | condition-state
  reference_system: surface-equivalent | story-absolute | relative-order
  earliest_start: 1939
  latest_start: 1941
  earliest_end: 1945
  latest_end: 1947
  precision: year | decade | approximate
  source_refs: []
```

Useful relationships are `BEFORE`, `AFTER`, `MEETS`, `OVERLAPS`, `DURING`, `CONTAINS`, `STARTS`, `FINISHES`, and `EQUALS`. V2 does not need full OWL reasoning, but it should preserve these semantics.

## Event-centered state changes

Birth, role entry, role exit, rejuvenation treatment, injury, recovery, disguise, and identity-master approval should be modeled as events. Appearance states occupy intervals between events.

```text
birth event -> chronological age calculation
rejuvenation event -> appearance transition
role interval -> wardrobe and behavior eligibility
surface-era interval -> environment and material envelope
scene instant -> intersection of all applicable intervals
```

This prevents a role label from carrying hidden assumptions about age or clothing.

## Resolution order

1. Resolve scene time from an explicit event or year when supplied.
2. Otherwise resolve equivalent year from birth-equivalent year plus chronological age.
3. Select temporal claims whose intervals contain the scene time.
4. Select the character role valid at that time.
5. Resolve chronological age independently.
6. Select an approved appearance state valid for that role/interval.
7. Apply rejuvenation state only from an explicit transition or approved interval.
8. Resolve wardrobe, environment, and technology from equivalent era plus place and role.

Explicit scene events outrank arithmetic inference. Arithmetic can choose an era envelope; it cannot create an appearance.

## Uncertainty and interpolation

Approximate dates should preserve earliest/latest bounds. A decade may be enough to select an era packet but insufficient to distinguish early- from late-decade technology. When that distinction is visually load-bearing, compilation must ask for precision.

Appearance interpolation is prohibited across unapproved rejuvenation transitions. The compiler may say “same identity, later state undefined”; it may not average a youthful and elderly reference into invented canon.

## Contradiction tests

V2 should block when:

- scene time falls outside the selected role interval;
- chronological age conflicts with birth chronology;
- apparent age lacks an appearance or rejuvenation claim;
- wardrobe or visible technology belongs outside the resolved era;
- two mutually exclusive events occupy the same character state;
- equivalent chronology is mistaken for exact Earth history.

## V2 requirements

- Introduce event, interval, and condition-state nodes.
- Add earliest/latest boundaries and precision.
- Separate chronological age, apparent age, role, and rejuvenation state.
- Store temporal reference system explicitly.
- Add temporal intersection and contradiction validation.
- Preserve the current birth-year-plus-age resolver as one inference rule, not the whole timeline model.

## Sources

- W3C/OGC, [Time Ontology in OWL](https://www.w3.org/TR/owl-time/).
- CIDOC CRM, [Formal definition](https://cidoc-crm.org/sites/default/files/Documents/cidoc_crm_version_7.1.3.html).
- Seeds of the Throne, `02 Story/Timeline/Timeline.md`.

## Boundary

This report does not define missing rejuvenation dates or appearance anchors.
