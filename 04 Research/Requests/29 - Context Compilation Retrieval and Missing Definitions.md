---
type: research-request
status: open
updated: 2026-08-13
research_sequence: 29-of-30
---

# Research Request — Context Compilation, Retrieval, and Missing Definitions

## Story question

What is the smallest clean generation context that preserves canon and intent while preventing QA language, obsolete facts, unresolved questions, and irrelevant lore from contaminating the image?

## Scope

Research retrieval and context-engineering methods, structured intermediate representations, conflict resolution, source authority, dependency graphs, uncertainty representation, and missing-definition detection. Keep external QA entirely outside renderer context.

## Required output

- Source-authority and freshness rules
- Entity/edge dependency schema and packet precedence
- Clean-context budget and relevance policy
- Typed missing-definition report with blocking versus waivable gaps
- Traceability record showing which vault facts produced each renderer instruction

## Development gate

No compiler-generated fact may lack a traceable source or explicit author waiver; QA findings remain external metadata.
