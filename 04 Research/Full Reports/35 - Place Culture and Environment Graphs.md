---
type: research-report
status: advisory-non-canon
updated: 2026-08-13
research_sequence: 35-of-40
produced_by: OpenAI Codex (Sol)
---

# Place, Culture, and Environment Graphs

## Purpose

This report defines how a location inherits physical, cultural, temporal, and social visual information without turning a generic era envelope into an invented canonical place.

## Executive finding

Environment resolution should combine a stable place hierarchy with temporary scene conditions. GeoSPARQL demonstrates the value of distinguishing spatial objects, geometry, and qualitative/quantitative spatial relations. For Seeds, exact coordinates are usually less important than typed containment, adjacency, access, scale, and cultural/environmental inheritance.

A place node must not be a paragraph of atmosphere. It should identify which larger places and cultural systems it belongs to, what permanent material conditions it has, and which details remain undefined.

## Place hierarchy

```text
planet
  -> civilization layer
    -> polity / culture region
      -> settlement
        -> district
          -> site
            -> room / path / beach segment
```

Useful edges include `LOCATED_IN`, `ADJACENT_TO`, `CONNECTED_BY`, `VISIBLE_FROM`, `ACCESSED_THROUGH`, `PART_OF`, `CULTURALLY_INFLUENCED_BY`, and `HIDES_INFRASTRUCTURE`.

## Environment master

```yaml
environment_id: environment:example-coastal-beach
place_type: beach
parent_place: settlement-or-region-id
status: required-definition
permanent:
  geography: null
  climate: null
  ecology: null
  built_form: null
  material_palette: null
  infrastructure: null
inheritance:
  culture: null
  era_policy: surface-equivalent
  social_range: []
visibility:
  colony_layer: hidden
unresolved: []
source_refs: []
```

The master supplies stable identity. Scene overlays supply weather, season, time of day, crowd density, maintenance condition, event damage, temporary signage, and activity.

## Resolution stack

1. **Geography/ecology:** coast, elevation, vegetation, water, climate, terrain.
2. **Culture/region:** construction habits, public-space norms, material traditions, symbols allowed or forbidden.
3. **Era:** visible technology, transport, media, clothing, and institutional envelope.
4. **Social layer:** class, occupation, public/private access, civic/commercial/domestic use.
5. **Site identity:** stable architecture, proportions, landmarks, circulation, recurring materials.
6. **Scene condition:** weather, time, season, population, damage, maintenance, and temporary objects.

Later layers may refine earlier layers but may not violate them without an explicit exception.

## Surface and hidden civilization

The surface/hidden rule belongs on the environment path, not only in the prompt. A site may conceal, mediate, restrict, or expose colonization infrastructure. Visibility should be observer- and scene-specific. “Advanced civilization exists” is not an environment appearance instruction.

## Cultural translation

Earth references are development envelopes, not cultural templates. A Los Angeles wardrobe or urban reference can constrain climate, class, and period familiarity while Seeds-specific culture remains undefined. V2 must track which visual fields come from Earth analogy and which have author-defined Seeds translations.

## Missing-place frontier

Generation should block when a named or narratively important place lacks load-bearing identity. Exploration may use a generic `place_type + era + geography` envelope only with an explicit noncanonical waiver, and the result cannot become an environment master automatically.

## V2 requirements

- Add hierarchical place nodes and typed spatial edges.
- Separate environment masters from scene-condition overlays.
- Record inherited versus locally defined fields.
- Track Earth-reference fields separately from Seeds-specific translations.
- Attach surface/hidden visibility to place and observer.
- Add environment identity and anachronism benchmarks.

## Sources

- Open Geospatial Consortium, [GeoSPARQL](https://www.ogc.org/standards/geosparql/).
- CIDOC CRM, [spatiotemporal and event-centered model](https://cidoc-crm.org/sites/default/files/Documents/cidoc_crm_version_7.1.3.html).
- Seeds of the Throne, `ERA-SURFACE-CIVILIZATION-REFERENCE.md` and `ENVIRONMENTS-AND-TECHNOLOGY.md`.

## Boundary

This report deliberately does not define the Seeds beach, city, school, or other named environment masters.
