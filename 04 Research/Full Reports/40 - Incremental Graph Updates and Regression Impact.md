---
type: research-report
status: advisory-non-canon
updated: 2026-08-13
research_sequence: 40-of-40
produced_by: OpenAI Codex (Sol)
---

# Incremental Graph Updates and Regression Impact

## Purpose

This report defines how vault changes should invalidate only affected graph nodes, packets, tests, references, and published assets.

## Executive finding

V2 should treat visual compilation as an incremental build system. Source claims are inputs; graph nodes and resolved scenes are intermediate products; clean packets and generated assets are outputs. Dependency traces and content fingerprints determine what is stale.

Build Systems à la Carte shows the value of separating dependency scheduling from the decision about whether something must rebuild. Seeds needs the same separation: graph traversal determines affected artifacts, while fingerprints and policy determine whether they remain valid, require recompilation, require re-rendering, or require author review.

## Artifact dependency chain

```text
vault file
  -> extracted claim
  -> graph node/edge
  -> resolved scene
  -> clean packet
  -> generated candidate
  -> approved reference
  -> public derivative
```

Every arrow should be recorded in the trace. A change at one level propagates only through reachable dependency edges.

## Fingerprints

Store normalized SHA-256 fingerprints for:

- source file content;
- claim content plus restrictive qualifiers and status;
- graph node payload plus eligible claims;
- resolved scene fields;
- clean packet;
- reference-image bytes;
- renderer execution settings;
- generated and public image bytes.

Formatting-only source changes should not invalidate claims if normalized extraction is unchanged. Claim-status or qualifier changes must invalidate dependents even if display text is similar.

## Impact states

- `CURRENT`: dependencies unchanged.
- `RECOMPILE`: graph or resolved packet changed; no image decision yet.
- `RERENDER_RECOMMENDED`: visible instruction changed.
- `REVIEW_REQUIRED`: authority, status, identity reference, or unresolved boundary changed.
- `STALE_REFERENCE`: an approved visual anchor no longer matches current identity/appearance authority.
- `STALE_PUBLIC_ASSET`: published image depends on superseded visual facts.
- `ORPHANED`: dependency was removed or renamed without migration.

Stale does not mean delete. Existing assets remain preserved with an explicit status and dependency explanation.

## Change handling

1. Fingerprint changed source files.
2. Re-extract only their indexed claims.
3. Compare claim IDs, payloads, qualifiers, and status.
4. Traverse reverse dependency edges.
5. Revalidate affected subgraphs.
6. Recompile affected resolved-scene and packet artifacts.
7. Compare renderer-visible packet fields.
8. Mark images and references with impact state.
9. Run only benchmarks attached to affected node/edge types.

## Entity migrations

Renames should preserve stable IDs and add aliases. Splits require explicit mapping from old claim scopes to new entities. Merges retain both source histories. Deletions produce tombstones rather than dangling references. Deprecated nodes remain traceable but renderer-ineligible.

## Media provenance

C2PA's provenance model reinforces that transformations should preserve prior provenance and add new actions. Seeds can adopt the conceptual chain even before embedding Content Credentials: source references, prompt packet, renderer settings, edits, approvals, compression, and publication should remain linked.

## Failure modes

- Rebuilding everything after every prose edit.
- Missing a changed qualifier because only file timestamps are compared.
- Deleting stale approved art instead of preserving its historical status.
- Renaming IDs and breaking packet provenance.
- Reusing an approved reference after identity authority changed.
- Public derivatives remaining “current” after their source image becomes stale.

## V2 requirements

- Add normalized content fingerprints at every artifact layer.
- Build forward and reverse dependency indexes.
- Add impact states and migration/tombstone records.
- Compare renderer-visible fields separately from trace-only changes.
- Select regression tests by affected node and edge types.
- Produce an impact report before re-rendering or publication.

## Sources

- Mokhov, Mitchell, and Peyton Jones, [Build Systems à la Carte](https://www.microsoft.com/en-us/research/publication/build-systems-la-carte/).
- C2PA, [Specifications](https://spec.c2pa.org/specifications/).
- W3C, [PROV-O](https://www.w3.org/TR/prov-o/).
- Seeds of the Throne, current visual storage and approval policies.

## Boundary

This report does not mark any current image stale and performs no deletion or migration.
