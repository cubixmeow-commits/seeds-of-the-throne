---
type: verification
status: source-verified-branch-only
updated: 2026-09-09
branch: codex/samuel-terminal-separation
---

# Reassessment and public projection verification

## Scope

Verified the retirement of the old 27-task author route, creation of the current assessment and ten-module workshop, and propagation into the Story atlas and Project Explorer sources.

## Story and workflow checks

- Current Story Completion state routes to RW-01.
- Current Pickup routes to RW-01.
- The current agenda pointer targets the reassessment workshop.
- SC-010 Question 7 is explicitly retired.
- SC-011 through SC-027 are marked retired in the historical registry.
- The nine completed old tasks remain historical evidence.
- The first twenty-module workshop is labeled historical and completed.
- The new assessment begins from the accepted terminal separation and placement ending.

## Public projection checks

- Story homepage includes the final separation, $15 million allocation, exhaustion within days, processing, exposure, and accepted placement.
- World page explains Sylvan and Orzai's cheap placement plan.
- Timeline continues through processing and placement instead of ending at the failed bargain.
- Conspiracy page includes Samuel's rapid resource collapse.
- Archive page explains why the old checklist was retired and links the current assessment.
- Project Explorer points to the September 9 reassessment and parses RW module identifiers.
- Workshop page and data contain ten RW modules.
- Progress snapshots target the current workshop instead of the old weekly checklist.
- No active checked page reports 9 of 27 as current progress.
- No active checked page routes the author to SC-010.

## Technical checks

- JavaScript syntax passed for `docs/todo.js`, `docs/workshop.js`, and the existing Project Explorer client.
- Python syntax passed for `scripts/build_story_sites.py`.
- Updated public HTML pages have balanced main, section, details, nav, and div tags in the source-level check.
- Checked internal HTML routes resolve to existing atlas pages.
- Workshop JSON parses and contains exactly ten modules with RW-01 through RW-10.
- The branch is ahead of main and not behind it.

## Verification boundary

The changes are isolated on the story branch. They have not been merged or deployed, so live-server rendering, PHP runtime lint, responsive viewport inspection, and post-deployment marker verification remain pending. No visual redesign was introduced; the approved Pale Signal structure and styles were preserved.
