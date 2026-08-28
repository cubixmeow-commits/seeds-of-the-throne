---
type: session
status: active
date: 2026-08-18
topic: subagent delegation protocol
---

# Seeds Delegation Protocol

## Author direction

Create a durable protocol for using subagents effectively and seamlessly during complex or long-running vault work. The author plans to work through examples in a later session to learn when delegation improves quality and when a single agent is better.

## Decision

The protocol belongs in `07 Coordination/` as workflow memory, not story canon. The activation phrase is:

> Use the Seeds delegation protocol.

This phrase authorizes bounded subagent delegation inside the current request. It does not expand permission for canon decisions, external publication, destructive actions, commits, pushes, or unrelated work.

## Intended operating model

- The primary agent remains responsible for author intent, canon protection, integration, final edits, validation, and the user-facing result.
- Subagents handle concrete independent workstreams with focused context.
- Read-heavy exploration, tests, audits, comparisons, and research are preferred delegation targets.
- Concurrent editing is avoided by default; when writing is delegated, each file has one owner.
- Subagent findings remain advisory until the primary agent verifies and integrates them.
- The protocol is triggered by task shape and context pollution, not an arbitrary context-window percentage.

## Future calibration

Use real examples to discover which Seeds tasks benefit from delegation. Record observed successes and failures before turning them into stricter project rules.

This session changes no story facts, canon status, or prose-style authority.
