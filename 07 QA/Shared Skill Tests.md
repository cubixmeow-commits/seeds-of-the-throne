---
type: qa
status: active
updated: 2026-08-15
---

# Shared Skill Tests

## Test method

Each skill was initialized with the standard skill scaffold, checked with the official structural validator, and forward-tested by a fresh agent on a representative read-only task. Tests evaluated workflow behavior rather than agreement with a predetermined creative answer.

## Results

| Skill | Scenario | Expected behavior | Result |
| --- | --- | --- | --- |
| `develop-story-session` | Explore whether George's Daemon notices the first inconsistency before George | Separate established constraints from possibilities, preserve agency, create a session structure, and avoid canonizing an answer | Pass. Produced three alternatives, identified impossible provenance as proposed, explicitly recorded that no author decision was made, and listed unresolved mechanics. |
| `research-story-material` | Plan research into mutually reinforcing human and AI belief systems | Define a scoped research request, separate evidence from extrapolation, include disconfirming evidence, and invent no story facts | Pass. Produced source priorities, claim labels, an extrapolation ladder, adversarial checks, and a clear non-canon boundary. |
| `check-story-continuity` | Audit George's three fifteen-year roles, thirty-year hunt, and approximate age of 130 | Verify arithmetic and authority, distinguish contradiction from missing chronology, and cite evidence | Pass. Confirmed the 75-year sequence, identified an unmapped 55-year period as a gap rather than a contradiction, and flagged minor status drift. |
| `coach-seeds-writing` | Diagnose an explained-unease opening, preserve prose-free default coaching, and provide short examples only in explicit demonstration mode | Identify the strongest craft issue and assign a revision action in coaching mode; when samples are explicitly requested, label them non-canon, vary the demonstrated technique, explain tradeoffs, and avoid expanding into a full scene | Pass after mode separation and retesting. A fresh coaching request produced a focused emotional diagnosis and one governing question without prose. An explicit demonstration request produced two short samples—action/perception and dialogue/subtext—under a non-canon label, identified invented evidence details as proposed, explained each technique and tradeoff, and ended by returning the choice to the author. |
| `write-seeds-prose` | Draft and refine a first-person George anomaly scene, then distinguish refinement from promotion | Default to a labeled non-canon exploratory draft, keep viewpoint limited, make the anomaly concrete, preserve George's agency, mark connective details proposed, use no em dashes, revise the whole affected scene coherently, and require explicit promotion before manuscript-candidate status | Prior baseline pass produced exactly 180 words, maintained first-person present, used dialogue under pressure, labeled all connective material provisional, and contained no em dashes. Expanded mode and promotion workflow requires forward retesting. |
| `update-public-atlas` | Plan an atlas update for a newly approved first anomaly | Choose the smallest page, preserve status and spoiler boundaries, define verification, and block publication without traceable approval | Pass. Chose `docs/archive.html`, limited scope, preserved status layers, and refused implementation because no approved anomaly record existed in the vault. |
| `create-seeds-images` | Prepare a Samuel-only archive-chamber image packet from a fresh agent | Locate exact approved references, prioritize the clean identity master, preserve Luminai terminology, reproduce locked style and drift controls, and apply the approval scorecard | Pass after rerunning from a project-visible copy. Named all four Samuel references and checksums, prioritized the clean master, ignored obsolete George and Lumina labels, preserved the red-and-gold visual grammar, and applied the required score thresholds. The first staging-path attempt was invalid because the fresh agent could not access temporary files and was not counted as a skill result. |

## Structural validation

All seven folders passed the official skill validator after initialization. Their metadata contains valid names and descriptions, their instructions are under 500 lines, and detailed checklists are loaded progressively from one-level `references/` files where needed.

## Follow-up

Use the skills on real work and revise them when repeated friction appears. A successful isolated test demonstrates that the workflow is legible; it does not make the skill permanently complete.
