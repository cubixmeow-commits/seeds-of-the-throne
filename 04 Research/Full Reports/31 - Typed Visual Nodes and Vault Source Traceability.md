---
type: research-report
status: advisory-non-canon
updated: 2026-08-13
research_sequence: 31-of-40
produced_by: OpenAI Codex (Sol)
---

# Typed Visual Nodes and Vault Source Traceability

## Purpose

This report defines the first implementable layer between the Seeds vault and the image renderer. The goal is not to reproduce the vault in another database. It is to create a typed index whose nodes point to existing machine-readable payloads and whose source records point back to the human-readable vault authority.

## Executive finding

The existing visual registry should remain the machine-readable source of truth. It needs a graph index around, not beside, its current character, appearance, era, environment, manifestation, style, and renderer records.

Every graph node requires five things: stable ID, type, payload pointer, status, and source references. Every edge requires stable type, endpoints, and a statement of what can be inferred through it. The compiler should resolve only the subgraph required by the scene and emit its source trace outside the renderer context.

## 1. Nodes represent visual responsibilities

Useful initial node types are:

- character identity;
- appearance state;
- wardrobe profile;
- era packet;
- environment master;
- manifestation;
- rejuvenation system;
- visual style;
- composition mode;
- renderer capability.

A node does not need to contain a second copy of its facts. Its `payload_ref` points into the existing registry. This prevents graph data and prompt data from drifting apart.

## 2. Sources and payloads serve different purposes

The registry payload supplies normalized machine-readable instructions. The source catalog explains why those instructions are allowed to exist.

Source classes must remain distinct:

- **story authority:** compiled story, timeline, cast, and system files;
- **author decision:** explicit QA decisions and approvals;
- **production rule:** visual compiler and prompt-system files;
- **approved visual evidence:** identity masters and approved images;
- **research:** advisory material that cannot establish canon by itself;
- **external operational documentation:** renderer behavior, never story truth.

This distinction prevents a strong renderer recommendation, research analogy, or attractive generated image from being mistaken for story canon.

## 3. Status is part of the node

At minimum the graph needs established, authoritative-working, working, proposed, unresolved, required-definition, rejected, obsolete, and operational statuses. Report 32 must determine claim-level conflict and supersession. In this first implementation, node status is descriptive and validation-enforced; it does not yet resolve conflicts automatically.

## 4. Edges express legal traversal

The initial graph needs typed edges such as:

- `HAS_APPEARANCE`;
- `HAS_WARDROBE`;
- `RESOLVES_IN_ERA`;
- `USES_ENVIRONMENT`;
- `MAY_MANIFEST_AS`;
- `AFFECTED_BY_REJUVENATION`;
- `RENDERED_WITH_STYLE`;
- `RENDERED_BY`.

Edges are not decorative. They define which neighboring nodes may enter a selected scene subgraph. Future reports will add temporal qualification, relationships, technology dependencies, visibility, and conflict semantics.

## 5. Deterministic graph selection comes before semantic retrieval

Known character IDs, explicit roles, years, locations, manifestations, composition modes, and render styles should resolve deterministically. Semantic retrieval is useful later for locating candidate vault passages, but it must not silently set authority or choose among contradictions.

Official OpenAI file-search documentation supports semantic and keyword retrieval, metadata filtering, bounded result counts, and inclusion of raw search results for inspection. These capabilities could support a later vault retrieval adapter. They do not replace the project's graph, status, or source-authority logic.

## 6. Trace and renderer context must be separated

The clean packet should contain resolved visual instructions, not file paths, graph IDs, confidence labels, QA scores, or research notes. A separate trace should list:

- selected node IDs and types;
- node status;
- payload pointers;
- source IDs, locations, classes, and authority;
- graph edges used during resolution.

This trace supports debugging and audit while avoiding the benchmark-language leakage already observed in B01 and B02.

## 7. Initial development boundary

The first implementation should index the graph entities already defined well enough to compile: Sylvan, Samuel, their known appearance states and wardrobe profiles, supported era packets, the surface-civilization environment, Luminai and Daemon manifestation, rejuvenation, the project visual style, composition modes, and GPT Image 2.

It should not yet attempt to ingest arbitrary Markdown claims, infer relationships from prose, resolve conflicting sources, or invent graph nodes for undefined environments and technologies. Those are the work of Reports 32–40.

## Adopted engineering recommendations

1. Keep `visual-registry.json` as the existing payload store.
2. Add a source catalog and typed graph index inside that registry.
3. Validate source paths, node types, payload pointers, edge types, and edge endpoints.
4. Resolve a scene-specific selected subgraph during prompt compilation.
5. Expose source trace only through a separate diagnostic channel.
6. Keep deterministic selection primary; treat future semantic retrieval as candidate discovery.
7. Block missing load-bearing visual nodes rather than traversing into invented facts.

## Sources

- Seeds of the Throne, `03 Context/RULES.md`, `03 Context/CURRENT.md`, `03 Context/CAST.md`, `02 Story/Timeline/Timeline.md`, and the existing Visual Generation production files.
- OpenAI, [File search](https://developers.openai.com/api/docs/guides/tools-file-search) (accessed 2026-08-13).
- OpenAI, [GPT Image 2 model](https://developers.openai.com/api/docs/models/gpt-image-2) (accessed 2026-08-13).

## Bottom line for *Seeds of the Throne*

The visual graph is the controlled transformation layer between prose knowledge and imagery. Its job is not merely retrieval. It preserves what a fact is, where it came from, whether it is settled, which other facts it depends on, and whether it is permitted to become visible in this scene.
