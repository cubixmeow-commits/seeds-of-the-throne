---
type: session
status: established
date: 2026-09-07
topic: authoring system persistence architecture
authority: explicit author decision
---

# Markdown-Only Authoring System Decision

## Author decision

Keep the conversational authorship system Markdown-based. The Project Explorer will provide the interface for browsing and understanding the system. JSON would make the underlying system harder for the author to browse directly.

## Interpretation

- Markdown is the durable, inspectable source for decisions, entities, events, gaps, sequences, scene contracts, drafts, workflow state, and provenance.
- Do not require the author to inspect, edit, or maintain JSON sidecars.
- Project Explorer should read or compile directly from Markdown and present useful views over it.
- Deterministic tools may hold indexes in memory or create disposable build output when technically necessary, but those artifacts must be completely rebuildable, must not become authority, and must not become a parallel project database.
- Prefer Markdown frontmatter, links, headings, and stable IDs for structured records.

## Consequence

The previously proposed event-sourced Markdown/JSON hybrid is rejected. The revised architecture is an event-sourced Markdown vault with generated interfaces and deterministic Markdown validation.
