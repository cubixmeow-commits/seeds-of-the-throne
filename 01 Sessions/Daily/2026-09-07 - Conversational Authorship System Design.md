---
type: session
status: proposed
date: 2026-09-07
topic: conversational authorship system design
authority: product and workflow proposal only
---

# Conversational Authorship System Design

## Author request

Design the beginning of the full system before building it. The system should help a person who has a story but lacks time or extensive writing craft move from conversation to a finished, author-approved manuscript.

## Design result

The proposed system has three cooperating layers:

1. **Conversation layer:** understands natural speech, reflects it accurately, and asks one useful question at a time.
2. **Story runtime:** preserves sources, decisions, dependencies, chronology, revelation, character knowledge, continuity, and exact progress.
3. **Production layer:** uses the Workshop Engine to resolve story gaps and the Composition Engine to create, test, revise, and assemble prose.

The first product proof should be one complete Seeds vertical slice rather than a generic platform: spoken answer → accepted decision → affected-story update → scene contract → scene draft → validation → author review → manuscript candidate.

## Files produced

- [[07 Coordination/Authoring System/README|Authoring System]]
- [[07 Coordination/Authoring System/01 - Product and Author Experience|Product and Author Experience]]
- [[07 Coordination/Authoring System/02 - Story Runtime and Data Model|Story Runtime and Data Model]]
- [[07 Coordination/Authoring System/03 - Workshop and Composition Engines|Workshop and Composition Engines]]
- [[07 Coordination/Authoring System/04 - Audits, Vertical Slice and Roadmap|Audits, Vertical Slice and Roadmap]]

## Authority note

The author has established the market direction, founder problem, two-engine destination, and goal of finished prose. Architecture, schemas, scoring formulas, phases, and interface details in the linked documents remain proposed until reviewed.
