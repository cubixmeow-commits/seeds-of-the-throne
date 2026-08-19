---
type: coordination-index
status: active
updated: 2026-08-18
---

# Coordination

This folder holds operating conventions for moving work between conversations, devices, and the local repository. It is workflow memory, not story canon.

## Start here

- [[device-workflow]] — what belongs in mobile development and what requires desktop implementation.
- [[DESKTOP-QUEUE]] — the durable handoff list for filesystem, repository, website, testing, commit, and publishing work.
- [[SUBAGENT-PROTOCOL|Seeds Delegation Protocol]] — when and how to delegate independent work while preserving primary-agent authority, canon boundaries, and safe file ownership.

The short desktop instruction is: **Process the desktop queue.** A desktop session should sync safely, inspect existing files before editing, implement each ready item, record story decisions through the normal session workflow, verify the diff, and then mark completed queue items with their resulting files or commit.

The short delegation instruction is: **Use the Seeds delegation protocol.** This explicitly authorizes bounded subagent delegation for the current request under the protocol's limits.
