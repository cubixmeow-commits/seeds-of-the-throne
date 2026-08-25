---
type: coordination-index
status: active
updated: 2026-08-24
---

# Coordination

This folder holds operating conventions for moving work between conversations, devices, and the local repository. It is workflow memory, not story canon.

## Start here

- [[Weekly Synthesis/CURRENT-COMPLETION-TODO|Current Weekly Completion TODO]] — the only author-facing story-development TODO; the public dashboard renders its approved checklist.
- [[Weekly Synthesis/CURRENT-WEEK-INTAKE|Current Week Intake]] — a non-executable index for consequential discoveries awaiting weekly reconciliation.
- [[CURRENT-PICKUP]] — the single accurate handoff for the next session.
- [[device-workflow]] — what belongs in mobile development and what requires desktop implementation.
- [[DESKTOP-QUEUE]] — the durable handoff list for filesystem, repository, website, testing, commit, and publishing work.
- [[SUBAGENT-PROTOCOL|Seeds Delegation Protocol]] — when and how to delegate independent work while preserving primary-agent authority, canon boundaries, and safe file ownership.
- [[Weekly Synthesis/README|Weekly Story Synthesis]] — dated end-of-credit-cycle full-vault analysis, ranked development intake, and maintenance recommendations.
- [[Story Completion Workflow/WORKFLOW|Story Completion Workflow]] — horizontal macro-to-draft task state, dependencies, propagation, regression, and completion tracking.

The short resume instruction is: **Open Current Pickup.** For implementation work, process the desktop queue after reading that note. A desktop session should sync safely, inspect existing files before editing, implement each ready item, record story decisions through the normal session workflow, verify the diff, and then mark completed queue items with their resulting files or commit.

The short delegation instruction is: **Use the Seeds delegation protocol.** This explicitly authorizes bounded subagent delegation for the current request under the protocol's limits.

For story development, Current Pickup and task packets only tell the system where to resume work already represented in the current completion TODO. `DESKTOP-QUEUE.md` remains a technical implementation handoff for local file, test, publishing, and repository work; it is not a second story-development list for the author.
