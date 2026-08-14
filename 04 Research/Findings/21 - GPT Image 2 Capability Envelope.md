---
type: research-finding
status: adopted-for-production
updated: 2026-08-13
source_report: 21
---

# GPT Image 2 Capability Envelope — Adopted Finding

## Reusable finding

GPT Image 2 supports the project's reference-grounded workflow, but renderer capability does not replace identity, composition, or QA systems. It accepts multiple high-fidelity image inputs and supports generation, editing, iterative editing, and configurable outputs. Current official documentation still names recurring-image consistency and precise composition as limitations.

## Adopted production implications

- GPT Image 2 remains the sole active renderer.
- One-shot generation and editing resolve to the Image API; iterative editing resolves to the Responses API unless the active in-app tool is explicitly recorded.
- Renderer intent, route, output controls, and input-fidelity behavior are compiled separately from image type, composition mode, and render style.
- Original and revised prompts, renderer version, reference checksums, route, settings, date, and result status belong in provenance.
- Character continuity and composition require benchmarks and human QA rather than trust in the renderer.

## Story implication

None. This finding changes the production system only and establishes no canon.

## Source

[[04 Research/Full Reports/21 - GPT Image 2 Capability Envelope]]
