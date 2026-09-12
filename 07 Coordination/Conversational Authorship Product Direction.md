---
type: product-direction
status: established
updated: 2026-09-12
scope: vault functionality, workshop engine, composition engine, project explorer
source: "[[01 Sessions/Daily/2026-09-07 - Conversational Authorship Product Direction]]"
---

# Conversational Authorship Product Direction

## Founder problem

The author wants to finish *Seeds of the Throne* but does not have time to manually write and maintain every part of it. Build the system to solve that concrete problem first: preserve the author's story, judgment, corrections, and approval while taking on as much of the time-intensive story-development and manuscript-production work as can be performed reliably.

The broader market hypothesis is that many other people can tell and guide a compelling story but lack the time, craft training, organization, or production capacity to complete a book alone.

## Direction

Build the vault into a conversational authorship system for **story-rich, craft-light creators**. A user should be able to tell a story naturally, answer one useful question at a time, guide important decisions, and move from raw material to a completed manuscript without first mastering professional writing terminology.

> You already have the story. We help you discover it, develop it, and turn it into a finished book.

The working analogy is vibe coding for authorship: ordinary-language intent and iterative judgment on the surface; story craft, state management, continuity, drafting, revision, and production discipline underneath.

## Initial user

Start with imaginative non-writers creating fiction from worlds, characters, fragments, recordings, role-playing histories, notes, or unfinished manuscripts. Preserve an architecture that can later support memoir and family history with stronger factual, consent, privacy, and uncertainty controls.

## Product boundary

The system must eventually support the complete path:

`natural intake → reflected understanding → dependency diagnosis → author gates → accepted story model → scene contracts → controlled prose → structural and line revision → continuity → manuscript export`

Finished prose is in scope. Premature prose is not the default method for discovering unresolved story structure.

## Governing requirements

- Never begin from a blank-page demand when conversational intake is possible.
- Keep source, system understanding, and proposed story use separate.
- Ask one high-leverage author-gate question at a time.
- Support free answer, decision help, inspiration, deferral, and correction.
- Propagate only author-accepted decisions.
- Show concrete story progress, not invented completion percentages.
- Require inspectable scene contracts for load-bearing prose.
- Use **Voice Key** to learn authorial selection from natural conversation, creative choices, corrections, positive examples, and dislikes. Prioritize how the user presents information over imitation of raw speech.
- Separate prose residue from deeper narrative residue.
- Return newly exposed structural gaps from Composition to Workshop.
- Preserve provenance, decision history, continuity, and exact resumption state.
- Keep Markdown or another open export as the durable source of truth.
- Optimize for completed, author-approved work rather than requiring the author to manually perform every stage or master writing craft first.

## Two flagship engines

### Workshop Engine

Diagnose the current story, identify the most consequential missing information, conduct adaptive interview/workshop sessions, record author decisions, and propagate their consequences through the project.

### Composition Engine

Translate approved story state into scene contracts and finished prose, then run separate developmental, continuity, narrative-residue, voice, prose-residue, and line-editing passes without inventing missing canon.

### Voice Key

Voice Key learns what the author notices, what counts as evidence, how causes and consequences connect, how outcomes are judged, what deserves explanation, where ambiguity belongs, and which surprising choices still feel earned. The Composition Engine uses it to select among high-quality presentation strategies before surface prose rendering. It does not merely copy conversational phrasing or add artificial errors. Detailed proposed mechanics are in [[07 Coordination/Authoring System/06 - Voice Key]].

Its established functionality combines four layers: authorial decisions, prose topology, residue filtering, and recent-pattern memory. Preferences are stored as contextual ranges and distributions, not fixed commands to add fragments, asymmetry, delayed theses, or other supposed signs of human writing. The system should break unwanted regularity while refusing to turn "grit" into another formula.

## Demonstration surfaces

- **Project Explorer:** explains and demonstrates the vault, author decisions, provenance, workshops, engine state, continuity, and progress toward a finished story.
- **Docs site:** presents the resulting story as a reader-facing narrative experience, with development machinery excluded unless intentionally exposed.

## Current constraint

Seeds remains development-first at its present stage. This direction expands the destination to finished prose but does not bypass current story gates or authorize bulk chapter generation.

## Next validation milestone

Complete the four audits, then test one vertical slice:

`intake → one author gate → accepted decision record → dependency propagation → scene contract → scene draft → deterministic continuity check → proposed vault updates`

Do not install or rewrite the final skill system until the audits and the author-gate architecture are reviewed.

The proposed architecture and staged validation plan are indexed at [[07 Coordination/Authoring System/README|Conversational Authoring System]].
