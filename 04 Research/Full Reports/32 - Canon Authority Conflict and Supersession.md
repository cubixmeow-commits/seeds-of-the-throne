---
type: research-report
status: advisory-non-canon
updated: 2026-08-13
research_sequence: 32-of-40
produced_by: OpenAI Codex (Sol)
---

# Canon Authority, Conflict, and Supersession

## Purpose

This report defines how the visual graph should represent competing claims without flattening the vault into one falsely certain version of the story.

## Executive finding

Authority must attach to individual claims, not merely files or nodes. A file can contain established facts, working interpretations, unresolved alternatives, and rejected history at the same time. V2 should therefore introduce a statement layer between source files and visual entities.

A statement is not just `subject -> predicate -> object`. It also needs restrictive qualifiers, status, scope, provenance, and explicit relationships to competing statements. Wikidata's statement model is useful here because qualifiers can restrict when, where, or how universally a statement applies, while references support the statement. W3C PROV supplies the complementary distinction among source entities, activities that transform them, and responsible agents.

## Claim record

```yaml
claim_id: claim:sylvan-birth-equivalent
subject: character:sylvan-elaria
predicate: BORN_IN_EQUIVALENT_YEAR
object: 1985
status: established | authoritative-working | working | proposed | unresolved | rejected | obsolete
scope:
  purpose: chronology
  valid_time: null
  valid_place: surface-civilization
qualifiers: []
source_refs: [timeline]
adopted_by: author-decision-id | null
supersedes: []
conflicts_with: []
visual_effect: resolve-era-by-birth-year-plus-age
renderer_eligible: true
```

The value may be a literal, node ID, interval, or structured object. Restrictive qualifiers are mandatory during resolution; optional notes may be ignored without changing meaning.

## Authority is contextual, not a universal score

The existing authority order remains useful, but it should be applied by claim scope:

1. An explicit author decision governs the decision it actually makes.
2. Compiled story authority governs story facts.
3. Approved visual authority governs identity geometry and approved visual choices, not biography or hidden history.
4. Production rules govern compilation and rendering, not story truth.
5. Working context supplies current development only where no stronger scoped claim exists.
6. Research remains advisory.
7. External documentation governs tool behavior only.

An approved portrait cannot override a timeline. A renderer document cannot decide what a Luminai is. A current-context synthesis cannot silently erase an explicit unresolved alternative.

## Conflict and supersession

V2 should distinguish:

- `SUPERSEDES`: the newer claim explicitly replaces the older claim within the same scope;
- `CONFLICTS_WITH`: both cannot be true under overlapping restrictive qualifiers;
- `ALTERNATIVE_TO`: competing unresolved possibilities;
- `REFINES`: adds precision without changing the earlier claim;
- `DEPRECATED_BY`: old terminology or production behavior remains traceable but unusable;
- `REJECTS`: an author decision explicitly rules out a claim.

Resolution must never use file modification time as story authority. “Latest wins” is allowed only when an explicit supersession edge exists.

## Resolution algorithm

For each required visual property:

1. collect claims matching subject, predicate, scene time, place, role, and purpose;
2. remove rejected and obsolete claims from renderer eligibility but retain them in trace;
3. apply restrictive qualifiers;
4. follow explicit supersession and deprecation edges;
5. group remaining claims by scope and authority class;
6. if one compatible claim remains, resolve it;
7. if multiple compatible claims refine one another, merge only fields declared mergeable;
8. if incompatible claims remain, emit `CONFLICTING DEFINITION` and block;
9. if only proposed or unresolved claims remain, emit `NEEDS DEFINITION` unless a scoped author waiver exists.

## Failure modes

- Treating a whole file as canonical because its frontmatter says `working` or `active`.
- Automatically preferring the newest wording.
- Allowing approved imagery to back-propagate invented biography.
- Combining two alternatives into a third version the author never chose.
- Ignoring temporal or geographic qualifiers.
- Hiding contradictions by lowering confidence rather than reporting them.

## V2 requirements

- Add claim records and claim-level status.
- Add explicit conflict, alternative, refinement, rejection, and supersession edges.
- Require a scope for every claim that can affect imagery.
- Produce a conflict report showing both claims and their source paths.
- Preserve rejected/obsolete claims for audit while excluding them from rendering.
- Add regression tests proving that modification time cannot decide canon.

## Sources

- W3C, [PROV-O: The PROV Ontology](https://www.w3.org/TR/prov-o/).
- Wikidata, [Data model](https://www.wikidata.org/wiki/Help:Data_model).
- Seeds of the Throne, `03 Context/RULES.md` and current graph/source catalog.

## Boundary

This report defines conflict mechanics. It does not resolve any current story question.
