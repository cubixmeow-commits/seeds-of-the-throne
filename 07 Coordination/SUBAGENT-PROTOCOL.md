---
type: coordination-protocol
status: active
updated: 2026-08-18
---

# Seeds Delegation Protocol

## Purpose

Protect quality during long or complex *Seeds of the Throne* work by dividing independent investigations among focused subagents while preserving one authoritative coordinator.

## Activation

The author may activate this protocol by saying:

> Use the Seeds delegation protocol.

Activation authorizes the primary agent to create subagents for bounded work inside the current request. It does not authorize publication, canon decisions, destructive actions, commits, pushes, external writes, or unrelated work.

The primary agent should briefly state which workstreams it is delegating and why. The author does not need to manage the individual agents unless a subagent encounters a decision that requires author authority.

## Primary-agent authority

The primary agent remains responsible for:

- interpreting the author's request;
- selecting authoritative vault material;
- protecting canon and unresolved questions;
- assigning non-overlapping work;
- resolving conflicts between findings;
- approving and inspecting all file changes;
- running final validation;
- reporting one unified result.

Subagent conclusions are evidence and recommendations, not project decisions.

## Delegation trigger

Use subagents when at least two concrete workstreams can proceed independently, especially:

- separate benchmark cases;
- research into unrelated mechanisms;
- continuity checks across different story systems;
- independent prose critiques;
- inspection of separate repository areas;
- competing explanations for a failure;
- tests that benefit from fresh context.

Do not wait for a specific context-window percentage. Consider delegation when:

- the task contains several unrelated investigations;
- earlier conversation is less useful than current vault files;
- repeated retrieval or noisy tool output is crowding out synthesis;
- independent review would materially improve coverage;
- parallel execution would save meaningful time.

## Keep work with one agent when

- the task depends on one continuous creative judgment;
- each step depends on the previous result;
- the author is actively choosing unresolved story material;
- the task is a single prose draft requiring one coherent voice;
- multiple agents would edit the same files or mutable state;
- the task is too small to justify coordination overhead.

## Context checkpoint

Before delegation, the primary agent creates a compact internal checkpoint containing:

1. current objective;
2. author's explicit instructions;
3. controlling vault files;
4. active style authority;
5. established facts;
6. unresolved facts that must remain unresolved;
7. files already changed;
8. validation already completed;
9. exact delegated workstreams;
10. final success criteria.

Subagents receive only the portion relevant to their assignments. Prefer current vault files over large transcript dumps.

## Subagent task packet

Every assignment must specify:

- one bounded objective;
- relevant files or evidence;
- authority and canon constraints;
- whether the task is read-only;
- expected output format;
- stopping condition;
- prohibited assumptions;
- whether independent alternatives are desired.

Example:

> Evaluate prose benchmarks B1-B3 using the current `write-seeds-prose` skill. Work read-only. Treat every generated passage as non-canon. Preserve Archive Thriller / Dark Historical Reconstruction and all unresolved story facts. Return, for each benchmark: pass/fail, strongest success, strongest failure, relevant module, and one proposed refinement. Do not edit files.

## File ownership

Default subagent work is read-only.

If implementation is delegated:

- assign each file to only one agent;
- prohibit overlapping edits;
- preserve existing uncommitted work;
- require the primary agent to inspect every diff;
- never allow a subagent to commit or push unless the author explicitly requests that exact action.

Files affecting canon, current context, style authority, or project-wide rules should normally remain under primary-agent control.

## Return contract

Each subagent returns:

1. conclusion;
2. evidence with file references;
3. tests or checks performed;
4. uncertainty;
5. recommended action;
6. files changed, if authorized;
7. unresolved issues.

Subagents should return distilled findings, not lengthy transcripts of their process.

## Integration

The primary agent must:

1. compare findings against controlling vault authority;
2. identify agreement, conflict, and unsupported inference;
3. reject any silent canonization;
4. choose the smallest high-leverage change;
5. inspect combined diffs;
6. run final tests centrally;
7. update session and QA records when appropriate;
8. summarize what was accepted, rejected, and left unresolved.

No subagent result becomes authoritative merely because multiple agents agree.

## Context-reset rule

When a conversation becomes dominated by completed history rather than current work:

1. finish or safely checkpoint current edits;
2. record durable decisions in the vault;
3. record unresolved questions explicitly;
4. ensure Git status is understood;
5. begin a fresh task using the vault as the source of truth.

A fresh task should receive the current objective and relevant files, not a complete transcript dump.

## Recommended concurrency

Use the smallest useful team:

- one primary agent;
- one subagent for a single independent audit;
- two or three subagents for genuinely parallel benchmark, research, or review work.

More agents are not automatically better. Coordination cost, token use, duplicated reading, and conflicting edits increase with team size.

## Completion condition

Delegated work is complete only when:

- every assigned workstream has returned or been explicitly abandoned;
- the primary agent has reconciled the findings;
- authorized changes have been inspected;
- relevant tests pass;
- canon and unresolved status remain intact;
- the author receives one unified result.

## Learning loop

After a meaningful delegated task, record only useful observations:

- what delegation improved;
- what coordination cost it introduced;
- whether focused context changed quality;
- whether tasks were independent enough;
- whether another agent count or division would work better.

Do not turn one successful or unsuccessful example into a universal rule. Refine this protocol only after a pattern appears across multiple real tasks.

## Reference basis

OpenAI's subagent guidance recommends focused parallel work for exploration, tests, triage, and summarization; returning summaries instead of noisy intermediate output; and extra care with parallel write-heavy workflows:

- https://learn.chatgpt.com/docs/agent-configuration/subagents
- https://developers.openai.com/api/docs/guides/responses-multi-agent

These product references inform the workflow but do not override vault authority or the author's instructions.
