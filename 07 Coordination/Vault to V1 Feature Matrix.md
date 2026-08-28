---
type: product-planning
status: active
updated: 2026-08-25
scope: local Story Engine V1
---

# Vault to V1 Feature Matrix

This matrix converts working vault behavior into the first desktop product. V1 should make the existing system easier and safer to operate; it should not invent a parallel story process.

| Vault source / proven behavior | Product capability | V1 scope | Portable contract | Desktop implementation | Later |
|---|---|---|---|---|---|
| `START HERE.md`, `03 Context/`, `CURRENT-PICKUP.md` | Project orientation and exact resume point | Project home with current phase, task, depth, progress, and next author action | `ProjectManifest`, `ProjectSnapshot` | Rust reads local project; React renders workspace | Mobile resume view and sync |
| `DEVELOPMENT-ORCHESTRATOR.md` | Deterministic development pipeline | Show phases, permitted transitions, hard stops, and current route | `WorkflowDefinition`, `WorkflowState` | Engine service evaluates transitions; UI requests actions | Pluggable workflow definitions |
| Story Completion `CURRENT`, registry, task packets, loop log | Horizontal sweep and task state | Active task, depth, dependencies, completion count, and immutable event log | `Task`, `Sweep`, `WorkflowEvent` | Markdown adapter reads current vault format | Visual task map and multi-project reporting |
| Author-gate interaction rule | Human authority boundary | Lock unresolved decisions; require explicit author acceptance before transition | `AuthorityGate`, `DecisionRecord` | Engine rejects unauthorized transition; UI explains why | Signed/attributed multi-author gates |
| Status labels across sessions and compiled notes | Canon and uncertainty safety | Preserve `established`, `working`, `proposed`, `unresolved`, `rejected` | `AuthorityStatus`, `SourceRef` | Parser exposes status and provenance | Inline promotion/redline tools |
| Gap Analyzer | Structured diagnosis before generation | Build source packet, gap register, priority queue, and author decisions required | `GapAnalysis`, `GapItem` | Local provider receives scoped context | Comparative multi-model analysis |
| Story Map and Story Units | Causal structure navigation | Browse units, dependencies, open gaps, and highest-value next unit | `StoryUnit`, `StoryEdge` | Read-only graph/list in V1 | Interactive editing and timeline |
| Research request/findings folders | Advisory research lifecycle | Create request, attach findings, preserve advisory authority | `ResearchRequest`, `ResearchFinding` | Local files and provider adapter | Web research connectors |
| Prototype style and prototype packets | Disposable story-form tests | Generate a clearly non-canon prototype with assumptions and evaluation fields | `PrototypeRun`, `Artifact` | Ollama provider with bounded prompt packet | Audio playback and model comparison |
| Critics and continuity skills | Focused QA | Run only selected critics; return findings without silent story edits | `Evaluation`, `Finding` | Local analysis service; user chooses integration | Automated regression suites |
| `07 QA/Decisions`, contradictions, questions | Durable decision and continuity memory | Browse decisions, unresolved questions, and contradictions with source links | `DecisionRecord`, `ContinuityIssue` | Markdown adapters | Assisted reconciliation UI |
| Character journal registry and provenance | Artifact identity and approval separation | Show artifact state, design state, image approval, and evidence provenance | `Artifact`, `ApprovalState`, `Provenance` | Read-only V1 browser | Journal creation and visual QA |
| Weekly Synthesis and sole completion TODO | Planning intake without task sprawl | Display authoritative TODO and capture new intake separately | `PlanningCycle`, `IntakeItem` | Adapter reads weekly pointer files | Scheduled local synthesis |
| Markdown-first vault and Git history | Local ownership and portability | Open an existing project, preserve readable files, write atomically, export archive | `ProjectManifest`, file layout | Rust filesystem boundary | Git UI and cloud sync |
| Tool-neutral research/model language | Provider independence | Ollama default behind a provider interface with health/model discovery | `ModelProvider`, `ModelRequest`, `ModelResponse` | Rust Ollama adapter | Cloud and remote-local adapters |
| Public atlas and manuscript folders | Downstream exports | Expose export destinations, but do not publish automatically | `ExportRequest`, `ExportResult` | Local export stubs | Site publishing and manuscript packages |

## V1 release boundary

V1 is complete when a local project can be opened, its active workflow and authority state can be reconstructed, scoped context can be assembled, Ollama can run a bounded analysis or prototype, an author gate cannot be bypassed, and resulting artifacts can be saved as readable versioned files with provenance.

## Explicitly deferred

- Full mobile UI and mobile platform targets.
- Cloud sync, accounts, collaboration, publishing, and paid providers.
- Automatic canon promotion or unattended author-gate advancement.
- A database as the source of truth.
- Large-scale semantic indexing until simple scoped retrieval is measured against real runs.
- Finished-manuscript generation as the primary workflow.
