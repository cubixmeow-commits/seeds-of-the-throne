---
type: research-report
status: advisory-non-canon
updated: 2026-08-13
research_sequence: 39-of-40
produced_by: OpenAI Codex (Sol)
---

# Uncertainty, Missing Definitions, and Author Waivers

## Purpose

This report defines how the compiler responds when the graph is incomplete, ambiguous, contested, deliberately hidden, or more precise than the vault permits.

## Executive finding

“Unknown” is not one state. V2 needs typed gaps because each demands different behavior. An undefined costume is different from two conflicting birth dates; a deliberately hidden device is different from a device whose appearance has never been designed.

Validation systems such as SHACL distinguish validation results and severity. Seeds should use a small project-specific severity model while preserving semantic cause. A waiver can permit one exploratory render but must never mutate the graph, settle canon, or authorize reuse.

## Gap taxonomy

- `ABSENT`: required node or claim does not exist.
- `UNDERSPECIFIED`: entity exists but lacks a required field.
- `AMBIGUOUS`: request maps to multiple entities or meanings.
- `CONFLICTING`: incompatible eligible claims remain.
- `UNRESOLVED_ALTERNATIVES`: the vault intentionally preserves options.
- `OUT_OF_RANGE`: time, role, place, or capability falls outside defined coverage.
- `UNAPPROVED_VISUAL`: story fact exists but lacks an approved visual anchor.
- `DELIBERATELY_HIDDEN`: fact exists but is not visible from this viewpoint.
- `NONVISUAL`: fact is true but has no authorized visual projection.
- `STALE`: dependency changed after a packet or asset was produced.

## Severity and behavior

```text
BLOCK  -> no clean packet
WARN   -> packet allowed; diagnostic remains external
INFO   -> trace/provenance note
```

Identity, appearance, named environment, visible technology design, contradictory canon, and accidental relationship canon are normally blocking. Exact non-load-bearing background clutter may be waivable for exploration.

## Waiver record

```yaml
waiver_id: waiver-id
gap_id: gap-id
authorized_by: author
purpose: exploratory-image-only
allowed_invention: generic noncanonical beach background
forbidden_invention: named geography, culture, landmarks, technology
scope:
  request_id: request-id
  image_count: 1
expires: after-request
reusable_as_reference: false
changes_canon: false
created: date
```

Waivers should be explicit, narrow, temporary, and attached to one gap. “Use your best judgment” is too broad for load-bearing world facts.

## Questions from the graph frontier

A missing-definition report should ask the smallest author question that unlocks compilation. It should include:

- missing or conflicting field;
- why the field matters visually;
- nodes and claims already resolved;
- two or three genuinely distinct options only when supported by research or existing development;
- what can be safely waived;
- which downstream packets or benchmarks will become unblocked.

## Open-world caution

Absence of a claim does not prove a negative. If the vault does not mention visible synthetic markers, the compiler must not infer that markers exist—or that they definitely do not. Explicit negative claims should be modeled separately and scoped by time/place.

## Failure modes

- Numeric confidence hiding a semantic conflict.
- Waiver becoming reusable visual authority.
- Deliberately hidden information reported as missing.
- Nonvisual truths forced into symbols.
- Generated detail copied back as a definition.
- One broad waiver silently covering future images.

## V2 requirements

- Add typed gap records and severity.
- Add scoped, expiring waiver records.
- Distinguish unknown, unresolved, hidden, nonvisual, and stale.
- Generate minimal author questions from the unresolved frontier.
- Prevent waived outputs from becoming approved references without a separate author decision.
- Add tests for every gap category.

## Sources

- W3C, [Shapes Constraint Language](https://www.w3.org/TR/shacl/).
- W3C, [PROV-O](https://www.w3.org/TR/prov-o/).
- Wikidata, [restrictive qualifiers and explicit negation limitations](https://www.wikidata.org/wiki/Help:Data_model).
- Seeds of the Throne, `03 Context/RULES.md` and current missing-definition policy.

## Boundary

This report does not waive any currently unresolved Seeds definition.
