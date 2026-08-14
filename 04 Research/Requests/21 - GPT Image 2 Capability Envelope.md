---
type: research-request
status: completed
updated: 2026-08-13
research_sequence: 21-of-30
---

# Research Request — GPT Image 2 Capability Envelope

## Story question

Which controls and limitations of the sole active renderer should the Visual World Compiler expose or compensate for?

## Scope

Research current official GPT Image 2 generation and editing behavior: reference inputs, fidelity, one-shot versus iterative workflows, output controls, prompt revision, errors, consistency, and composition limits. Do not compare or add other renderers.

## Required output

- Verified renderer capabilities and limitations
- API-route decision rules
- Compiler fields and provenance fields to add
- Benchmark implications
- Sources limited to current official OpenAI documentation

## Development gate

Implement only controls supported by current documentation, keep GPT Image 2 as the sole renderer, and add regression coverage for the execution plan.

## Result

See [[04 Research/Full Reports/21 - GPT Image 2 Capability Envelope|Report 21]].
