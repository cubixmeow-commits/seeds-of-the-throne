---
type: research-request
status: completed
updated: 2026-08-13
research_sequence: 38-of-40
---

# Research Request — Graph Resolution and Renderer Packet Projection

## Question

How should a resolved visual subgraph become a compact renderer packet while preserving identity, world causality, and source separation?

## Required output

- Resolution order and dependency traversal
- Merge rules for inherited, overridden, prohibited, and scene-variable properties
- Packet sections derived from node types
- Renderer projection that strips IDs, citations, QA, and unresolved alternatives
- Round-trip trace from every packet instruction to graph nodes and vault sources

## Development gate

The renderer receives only observable instructions. The compiler must retain a separate trace proving where they came from.

## Result

[[04 Research/Full Reports/38 - Graph Resolution and Renderer Packet Projection|Full report]]
