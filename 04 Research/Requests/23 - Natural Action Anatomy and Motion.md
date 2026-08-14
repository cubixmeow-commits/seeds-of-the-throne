---
type: research-request
status: open
updated: 2026-08-13
research_sequence: 23-of-30
---

# Research Request — Natural Action, Anatomy, and Motion

## Story question

What scene and camera specifications produce credible bodies in motion rather than posed figures, especially for running, reaching, carrying, fighting, and interacting with terrain?

## Scope

Research biomechanics, sports photography, shutter and lens behavior, gait phases, hand-object contact, cloth response, and renderer failure patterns. Use the Sylvan beach-running scene as the first benchmark without treating its current candidates as approved.

## Required output

- Action packet schema: phase, balance, weight transfer, limb state, gaze, breathing, and contact
- Camera and motion-blur guidance tied to action type
- Anatomy and interaction QA checks
- Benchmark prompts that vary action phase without changing identity
- Failure taxonomy for floating feet, frozen stride, extra limbs, and implausible cloth or energy behavior

## Development gate

Add action packets and action-specific QA only after natural movement can be evaluated independently from identity and style.
