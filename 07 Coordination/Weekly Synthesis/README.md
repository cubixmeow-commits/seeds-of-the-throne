---
type: coordination-system
status: active
version: 1.2
updated: 2026-08-24
---

# Weekly Story Synthesis

## Purpose

Use an end-of-credit-cycle deep pass to reconstruct the current project, find the highest-value gaps, and create a bounded next-week development queue. This is analysis and coordination, not an autonomous canon-writing process.

The approved completion checklist named by [[CURRENT-COMPLETION-TODO]] is the sole author-facing story-development TODO. The synthesis may replace that checklist after author review; it must never create a second active execution list.

## Weekly intake funnel

During the week, brainstorm freely in dated session notes and focused Story Loop brainstorm packets. Add a brief, source-linked signal to [[CURRENT-WEEK-INTAKE]] only when a discovery may change completion scope, dependencies, validation, or future priority. The intake index has no checkboxes or working order and is not something the author works through.

At the next synthesis, inventory all changed files and reconcile every intake signal using `Templates/13 Weekly Intake Reconciliation.md`. Each signal must be classified as already covered, revise existing, promote new, leave open, or no TODO change. Deduplicate aggressively: prefer linking new evidence to an existing `SC-###` task over creating another task.

Only an author-approved replacement checklist may become current. After approval, update the stable pointer, reconcile the task registry and dependency map, carry forward valid completion evidence, verify the public dashboard, and reset the intake index for the new week.

Never overwrite an earlier run. Create:

`07 Coordination/Weekly Synthesis/Runs/YYYY-MM-DD/`

and copy the templates into it. If rerun on the same date, add `-02`, `-03`, and so on.

## Core package

1. Weekly State of the Story
2. Master Story Outline
3. Character Arc Audit
4. Continuity and Adversarial Critique
5. Open Questions Ranked
6. Scene Opportunity Map
7. Foreshadowing and Evidence Map
8. Next Week Story Queue
9. Public Development Ideas
10. Vault Maintenance Recommendations

High-capacity options: Editorial Board, Forward/Reverse Causal Reconstruction, and Novelization Readiness.

## Operating flow

`capture daily work -> index consequential signals -> read rules and current pickup -> declare cutoff/budget -> inventory all changed and authoritative material -> reconcile intake against the current TODO -> run core reports -> classify BUILD NOW / BRAINSTORM NEXT / LEAVE OPEN -> draft one replacement checklist -> author gate -> update pointer/registry/dashboard -> apply approved maintenance separately`

The synthesis may recommend promotion, merging, renaming, archiving, cross-linking, or TODO changes. It must not perform those mutations merely because they appear in the report.

## Connection to the Story Loop

- Send the highest-value unresolved cluster to [[08 Story Loop/GAP-ANALYZER]].
- Use [[08 Story Loop/DEVELOPMENT-ORCHESTRATOR]] to choose brainstorm, exploration, research, structure, prototype, or critique.
- Create or update Story Units only after the author gate.
- Treat journal pages, genealogies, surveillance records, and behavioral fingerprints as evidence nodes with setup, custody, authentication, reveal, and consequence.
- Record the final queue as `BUILD NOW`, `BRAINSTORM NEXT`, or `LEAVE OPEN` so deliberate ambiguity is not mistaken for a defect.
- Convert the approved weekly completion set into [[07 Coordination/Story Completion Workflow/TASK-REGISTRY|the task registry]] and advance it horizontally through [[07 Coordination/Story Completion Workflow/WORKFLOW|Story Completion Workflow]]. The weekly checklist remains the binary/public source of truth; the registry records depth and validation.
- Treat `BUILD NOW` and `BRAINSTORM NEXT` as synthesis classifications used to construct the one completion TODO, not as separate lists for the author to work from.

## Validation

Before closing a run, verify source paths, authority labels, chronology, character knowledge, causality, system limits, evidence paths, public spoilers, and that no proposal was silently promoted. Record missing or unreadable sources in the manifest.

## Files

- [[CONFIG]] — scope, modes, scoring, and stop rules.
- [[MASTER PROMPT]] — reusable execution prompt.
- [[CURRENT-COMPLETION-TODO]] — stable pointer used by the public dashboard; update it only after a replacement completion checklist is approved.
- [[CURRENT-WEEK-INTAKE]] — non-executable index of consequential material awaiting the next synthesis.
- `Templates/` — copyable run manifest and report contracts.
- `Runs/` — dated, immutable-by-convention analysis history.
