---
type: research-report
status: advisory-non-canon
updated: 2026-08-13
research_sequence: 21-of-30
produced_by: OpenAI Codex (Sol)
---

# GPT Image 2 Capability Envelope

## Purpose

This report establishes the documented operating envelope of GPT Image 2, the sole active renderer for the Visual World Compiler. It separates renderer capabilities from project assumptions and translates verified behavior into engineering requirements.

## Executive finding

GPT Image 2 can support the intended compiler architecture: it generates and edits images, accepts multiple reference images, processes its image inputs at high fidelity, supports flexible image sizes and output controls, and can participate in iterative editing through the Responses API.

It does not eliminate the need for a compiler or external QA. OpenAI explicitly identifies recurring-character consistency and precise composition as remaining limitations. Identity locks, appearance timelines, composition packets, benchmark evaluation, and author approval therefore remain load-bearing project systems.

## 1. One-shot and iterative work are different execution routes

The Image API is the direct route for one-prompt generation or editing. The Responses API is the appropriate route for conversational or multi-step image work and supports iterative high-fidelity edits with image context.

The compiler should choose an execution route from declared intent:

- **new image or one-pass edit:** Image API;
- **iterative edit:** Responses API;
- **current in-app generation tool:** record the tool route explicitly while preserving the same clean packet boundary.

The route is production metadata. It must not alter story facts, identity authority, or the clean visual brief.

## 2. Multiple references are supported, but reference meaning remains the compiler's job

GPT Image workflows can use one or more reference images. GPT Image 2 processes every image input at high fidelity; the API does not expose a lower or higher `input_fidelity` setting for this model.

This supports multi-angle identity masters and scene references, but the renderer does not inherently know which image controls facial geometry, wardrobe, pose, environment, or edit canvas. The compiler must continue to label reference purpose and include only relevant images. More inputs can also increase cost and create competing visual instructions.

## 3. Output controls belong in the execution plan

The documented controls include size, quality, format, compression for JPEG/WebP, and background behavior. GPT Image 2 supports flexible dimensions. These are renderer settings, not render style.

The compiler should therefore keep:

- `image_type`: what the image is for;
- `render_style`: how the image should look;
- `composition_mode`: how the scene is visually organized;
- `output`: size, quality, format, compression, and background;
- `execution`: one-shot or iterative route.

This prevents a file-format or API decision from leaking into worldbuilding language.

## 4. Prompt revision and version information are provenance

When the Responses API image tool is used, the mainline model may revise the submitted prompt and exposes a `revised_prompt` field. GPT Image 2 also has a dated snapshot as well as the moving model alias.

For reproducibility, a completed generation record should preserve when available:

- original clean generation brief;
- revised prompt;
- model alias and dated snapshot or observed model version;
- API or tool route;
- reference-image paths and checksums;
- output controls;
- request date and result status.

The revised prompt belongs in provenance and QA, not in canon.

## 5. Documented limitations define the benchmark program

OpenAI lists latency, text rendering, recurring visual consistency, and precise composition as continuing limitations. The Seeds system should respond as follows:

- avoid generated text unless the image purpose requires a dedicated typography test;
- measure identity across genuinely new photographs rather than same-pose copies;
- test structured composition and multi-character blocking explicitly;
- treat timeouts and user-correctable generation errors as production states, not worldbuilding failures;
- never auto-promote a visually plausible result to canon.

## 6. Error handling should preserve diagnosis

Some failures are user-correctable and include stable error codes. A production wrapper should retain the request identifier, stable code, moderation stage when present, and whether the input or output failed. It should not blindly retry a user-correctable request without changing the prompt or inputs.

This belongs in a later renderer-execution layer. The current packet compiler should declare the intended route and settings without pretending it executed the request.

## Engineering recommendations

1. Keep GPT Image 2 as the sole renderer.
2. Add a renderer execution plan to every successful clean packet.
3. Distinguish `new-with-references`, `edit`, and `iterative-edit` intent.
4. Route iterative edits to the Responses API; use the Image API for one-shot work.
5. Add output size, quality, format, compression, and background fields without merging them into style.
6. Preserve prompt revision and exact renderer version in result provenance when available.
7. Keep identity, composition, anatomy, and accidental-canon QA external.
8. Do not expose a configurable input-fidelity field for GPT Image 2 because all image inputs are already processed at high fidelity.
9. Benchmark reference count and purpose rather than assuming that more references are better.
10. Treat renderer documentation as time-sensitive and reverify this report before a major production release.

## Sources

- OpenAI, [GPT Image 2 model](https://developers.openai.com/api/docs/models/gpt-image-2) (accessed 2026-08-13).
- OpenAI, [Image generation guide](https://developers.openai.com/api/docs/guides/image-generation) (accessed 2026-08-13).

## Bottom line for *Seeds of the Throne*

The renderer is capable enough for reference-grounded, iterative visual development, but the hard problems remain project-level: deciding what is authoritative, resolving time and role, compiling only relevant visual facts, measuring continuity, and refusing silent invention. Report 21 therefore justifies expanding the execution contract while preserving the existing compiler and QA boundaries.
