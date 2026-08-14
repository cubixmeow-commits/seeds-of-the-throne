---
type: research-report
status: advisory-non-canon
updated: 2026-08-13
research_sequence: 37-of-40
produced_by: OpenAI Codex (Sol)
---

# Scene Requests and Relevant Subgraph Selection

## Purpose

This report defines how a short user request becomes the smallest sufficient vault subgraph without giving semantic retrieval authority over canon.

## Executive finding

V2 should use a hybrid retrieval sequence: deterministic resolution first, bounded graph traversal second, semantic/keyword retrieval only for missing candidates, and explicit validation last. The output of retrieval is evidence to inspect, not truth to accept.

Official OpenAI file-search documentation supports semantic and keyword search over uploaded files, metadata filters, result-count limits, and optional inclusion of raw search results. These capabilities are suitable for a future vault adapter because a retrieval receipt can be preserved. The GraphRAG literature supports graph-guided organization for questions that depend on relationships or corpus-wide synthesis, but Seeds should not use an LLM-generated graph as the authority graph.

## Scene-intent record

```yaml
request_id: request-id
subjects: [character ids or unresolved mentions]
action: concrete physical action
story_beat: change immediately before/during scene
time: explicit year | event | age | unresolved
place: environment id | place type | unresolved
purpose: image_type
composition: composition_mode
render_style: render_style
viewpoint: literal | subjective | diagnostic | audience-only
manifestation: none | luminai | daemon | unresolved
advanced_visibility: none | subtle | controlled | explicit
```

Parsing must preserve unknowns. It should not convert “beach” into a particular Seeds coastline or infer that blue energy is literally visible to bystanders.

## Retrieval sequence

1. **Normalize explicit identifiers:** exact character, role, event, place, manifestation, and mode IDs.
2. **Resolve aliases:** only from an approved alias table with obsolete-term warnings.
3. **Traverse required edges:** identity to appearance, time, wardrobe, environment, manifestation, style, and renderer.
4. **Evaluate graph frontier:** identify missing required nodes or claims.
5. **Search only for candidate evidence:** query eligible vault source classes with metadata filters.
6. **Return retrieval receipt:** include query, filters, ranked results, excerpts or claim IDs, and exclusions.
7. **Validate authority and conflicts:** retrieved text cannot bypass Reports 32 and 39.
8. **Compile or block.**

## Metadata filters

Useful filters include source class, story/production scope, entity IDs, time range, status, updated date, and renderer eligibility. Research, rejected material, recovery notes, and QA findings should be excluded by default and included only for explicit diagnostic purposes.

## Context budget

The renderer should receive normalized resolved fields, not retrieved passages. Retrieval depth should be bounded by dependency needs. More lore can reduce image quality by introducing irrelevant costumes, symbols, unresolved alternatives, and text leakage.

## Retrieval receipt

The receipt belongs beside source trace and should record:

- parsed request;
- deterministic matches;
- aliases applied;
- edges traversed;
- retrieval queries and filters;
- candidate results considered;
- selected claims;
- excluded claims with reasons;
- unresolved frontier.

## Failure modes

- Semantic similarity selecting obsolete or rejected material.
- Whole-vault prompting.
- Retrieval scores treated as confidence in canon.
- Search results hidden from audit.
- A generated GraphRAG summary replacing source claims.
- Low result limits hiding necessary evidence without a gap warning.

## V2 requirements

- Add a typed scene-intent parser.
- Add deterministic alias and ID resolution.
- Add required-edge traversal and graph-frontier reporting.
- Design an optional filtered file-search adapter with included results.
- Persist retrieval receipts outside renderer context.
- Benchmark exact-ID, alias, ambiguous-name, missing-place, and conflicting-claim requests.

## Sources

- OpenAI, [File search](https://developers.openai.com/api/docs/guides/tools-file-search).
- Edge et al., [From Local to Global: A Graph RAG Approach to Query-Focused Summarization](https://arxiv.org/abs/2404.16130).
- Seeds of the Throne, current visual entity graph and `PROMPT-SYSTEM.md`.

## Boundary

No external vector store or API-backed retrieval adapter is implemented by this report.
