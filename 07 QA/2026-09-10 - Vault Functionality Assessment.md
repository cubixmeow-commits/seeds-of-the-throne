---
type: vault-functionality-assessment
status: completed
updated: 2026-09-10
scope: vault operation, usability, validation, and projection; story content excluded
---

# Vault Functionality Assessment

## Purpose

This assessment evaluates the vault as a working authorship system. It does not assess the story, characters, world, or plot.

The question is simple:

> Can the vault reliably capture ideas, preserve decisions, show the current state, guide the next useful action, produce story work, verify itself, and explain all of that to a person without exposing the machinery?

## Executive assessment

The vault is already a strong, unusually complete human-readable story-development environment. It has clear places for raw intake, chronological sessions, compiled memory, compact context, research, decisions, contradictions, workshops, story-development loops, drafts, public material, shared methods, verification evidence, and cross-device handoffs.

Its main weakness is the gap between **documented capability** and **enforced capability**. The system describes stable IDs, authority transitions, dependency graphs, blast-radius checks, exact pickup state, automatic projections, manuscript assembly, and safe resumption. Most of those functions are still performed manually or exist only as proposed design documents.

The next stage should not add more conceptual layers. It should make the existing layers trustworthy, visible, and easier to operate.

## Current footprint

- 603 Markdown documents.
- 492 documents have YAML frontmatter.
- 1 document currently has a frontmatter `id` field.
- 132 different frontmatter `type` values.
- 66 different frontmatter `status` values.
- 1,593 detected Obsidian-style links.
- 1,592 resolve to one target.
- 0 detected missing targets.
- 1 detected ambiguous target.
- 39 repeated filenames; most are intentional templates, dated runs, or research stages.
- 230 documents have no detectable incoming wiki link. Many are intentional references, generated snapshots, or skill files, but the set also contains legacy root-level material and discoverability risks.

These figures describe the committed repository at `583deed` on 2026-09-10. They are evidence for maintenance decisions, not permanent display copy.

## What the vault already does well

### 1. Captures development without pretending every idea is true

`00 Inbox/` and `01 Sessions/` preserve raw and chronological work. Exploration is allowed to remain exploratory. This protects the author's original meaning and makes later correction possible.

**Assessment:** strong.

### 2. Separates long memory from quick resumption

`02 Story/` holds compiled working memory. `03 Context/`, `START HERE.md`, and `07 Coordination/CURRENT-PICKUP.md` are intended to provide a smaller resume packet.

**Assessment:** strong design, inconsistent freshness. Current Pickup has accumulated old checkpoints instead of functioning only as the current state.

### 3. Protects author authority

The rules consistently distinguish source material, interpretation, proposals, accepted decisions, research, drafts, and published material. Author gates are explicit throughout the system.

**Assessment:** one of the vault's strongest features in policy; weakly enforced by software.

### 4. Preserves research as advisory material

`04 Research/Requests`, `Full Reports`, and `Findings` form a clear request-to-evidence lifecycle. Research does not automatically become story truth.

**Assessment:** strong and reusable.

### 5. Supports structured diagnosis and development

`08 Story Loop/` contains a Gap Analyzer, Development Orchestrator, critics, research routing, story units, brainstorm packets, run logs, sequence packets, scene packets, and draft-pipeline contracts.

**Assessment:** functionally rich, but only lightly exercised end to end.

### 6. Provides a conversational workshop model

The workshop asks one consequential question at a time, gives context, preserves uncertainty, and requires author acceptance. The newer reassessment workshop correctly replaces an obsolete fixed task set.

**Assessment:** strong interaction model; current builder and validator no longer agree with the new workshop format.

### 7. Maintains explicit decisions, contradictions, and questions

`07 QA/Decisions.md`, `Contradictions.md`, and `Questions.md` preserve uncertainty rather than silently cleaning it up.

**Assessment:** strong human-readable memory; weak indexing and propagation.

### 8. Has mature visual-development controls

The image system includes approved identity references, prompt contracts, provenance, storage rules, evaluation, and validation scripts.

**Assessment:** the most mechanically mature subsystem. Its validator passed with three registered characters.

### 9. Has substantial prose methods

The prose skill separates scene structure, drafting, developmental editing, voice, continuity, line editing, artificial-residue cleanup, and regression examples.

**Assessment:** sophisticated method library with working lint tests, but not yet a proven manuscript-production pipeline. Ten prose-lint tests passed; substantive manuscript output remains sparse.

### 10. Can project reviewed material to public websites

The website builder creates the story atlas, workshop material, shared JSON, Markdown downloads, and snapshots. The Project Explorer reads the vault and exposes search, sources, decisions, workshop material, progress, and files.

**Assessment:** valuable and concrete, but currently out of synchronization with the newest workflow.

### 11. Preserves ownership and recoverability

Markdown, Obsidian links, Git history, and readable folders make the project portable. The vault does not depend on a proprietary database.

**Assessment:** strong foundation.

## What is currently failing or drifting

### 1. The public projection is stale

`python3 scripts/check_story_sites.py` reports eleven stale generated outputs, including public pages, workshop JSON, and workflow snapshots.

The build script successfully produces ten reassessment modules, but the committed outputs still describe the earlier twenty-module workshop.

### 2. The builder and validator enforce different workshop systems

The builder now reads `Reassessment Workshop/` and builds ten modules. The checker still requires twenty modules and the old thirteen-heading module contract. The current reassessment files intentionally use a simpler format, so a clean rebuild still fails validation.

This is the clearest current example of system drift.

### 3. There is no repository-wide automated quality gate

There is no committed continuous-integration workflow enforcing:

- PHP syntax checks;
- website build freshness;
- builder/checker contract agreement;
- JavaScript syntax;
- Markdown link and frontmatter validation;
- accidental generated-file drift;
- deployment configuration safety.

The recent unescaped apostrophe in `workbench.php` reached production and created a server `error_log`. That log then made cPanel see the live checkout as dirty and blocked the next deployment. This failure should have been caught before merge.

### 4. The authority vocabulary is too unconstrained for automation

The vault currently uses 66 distinct `status` values and 132 distinct `type` values. Many are meaningful to a person, but they cannot reliably drive deterministic state transitions without normalization.

The design calls for stable record IDs, yet only one Markdown document currently has a frontmatter `id` field.

### 5. Decisions do not propagate mechanically

`07 QA/Decisions.md` is active and detailed. The separate workflow decision log contains only its initialization entry. Accepted answers are manually copied into context, compiled notes, tasks, QA, websites, and pickup state.

The vault can describe a blast radius but cannot yet compute one.

### 6. “Current” state is distributed and sometimes stale

The active state is spread across `START HERE`, `03 Context/CURRENT`, `CURRENT-PICKUP`, the completion pointer, Story Completion `CURRENT`, `COMPLETION`, the task registry, weekly intake, desktop queue, and generated snapshots.

Examples of drift:

- Current Pickup still contains old website and story checkpoints beneath newer material.
- Current Week Intake still declares the August 23–27 cycle while containing September material.
- The most recent weekly synthesis run is dated August 27.
- The retired task registry still contains the new reassessment table even though it warns not to route current work through that table.

The system does not yet satisfy its own goal of one trustworthy current position.

### 7. Legacy material remains beside the current architecture

Root-level `characters/`, `components/`, `current/`, and `sessions/` contain the original August stress-test structure beside the numbered vault. They are useful historical evidence but look like active parallel systems.

This creates retrieval ambiguity and makes the vault harder to explain.

### 8. Discoverability is excellent at the link level but uneven at the system level

Almost every detected wiki link resolves, which is excellent. However, hundreds of documents have no detected incoming wiki link, and the Project Explorer presents the archive primarily as files rather than as an understandable operating map.

The user can find a file; the user cannot yet see the whole system at a glance.

### 9. Weekly maintenance exists as a method, not a dependable cycle

Weekly Synthesis has a strong schedule, templates, intake funnel, authority rules, and output contracts. It has not remained current through recent rapid development, and no scheduler or completion check enforces the cadence.

### 10. The manuscript destination is mostly designed rather than operational

The vault has scene, sequence, critique, and draft templates plus a sophisticated Composition Engine proposal. It does not yet have a populated ordered scene registry, a repeatably approved scene-to-manuscript path, or a tested manuscript assembly/export cycle.

### 11. Mobile workshop answers are not durable vault writes

The public workshop stores drafts in browser local storage and supports Markdown import/export. It does not write to the vault, synchronize devices, or integrate accepted decisions. That limitation is honestly documented, but it remains a major missing part of the intended conversational system.

### 12. Deployment architecture needs separation

The cPanel-managed Git checkout and deployment destination were both configured as `/home/iainmcok/public_html/devsite/`. This places server-generated files inside the Git working tree. Ignoring `error_log` prevents the immediate recurrence, but the durable fix is a separate clean repository checkout that deploys an archive into the public directory.

## Functional scorecard

| Capability | Current strength | What would make it dependable |
|---|---|---|
| Raw idea and session capture | Strong | automatic intake summary and duplicate detection |
| Human-readable memory | Strong | stable IDs and clearer historical boundaries |
| Quick resume | Partial | one generated current-state projection |
| Author authority | Strong policy | enforced transitions and acceptance events |
| Research lifecycle | Strong | request/finding status checks and coverage view |
| Workshop | Strong design | one supported schema, valid build, durable answer integration |
| Decisions and contradictions | Strong records | index, dependencies, supersession, blast radius |
| Story development loops | Strong methods | repeated end-to-end runs and measurable outcomes |
| Visual production | Strongest automation | broader registry coverage and regression fixtures |
| Prose production | Advanced design | one approved vertical slice through manuscript output |
| Public projections | Real but drifting | rebuild, aligned validator, automated freshness check |
| Project Explorer | Useful browser | simple whole-vault map and current health view |
| Mobile continuity | Partial | durable capture, confirmation, synchronization, and recovery |
| Deployment | Fragile | clean build gate and separate checkout/deploy directories |

## Priority work

### Priority 1 — Make the current system truthful

1. Update the website checker to the ten-module reassessment contract.
2. Rebuild and commit every generated projection.
3. Add PHP syntax, JavaScript syntax, site build, site freshness, Markdown link, and frontmatter checks before merge.
4. Verify the Project Explorer and story site on mobile and desktop after every public change.

### Priority 2 — Create one trustworthy current state

1. Define one authoritative Markdown current-state record.
2. Generate Current Pickup, progress, and public snapshots from it where practical.
3. Reset the Weekly Synthesis cycle and intake dates.
4. Move old checkpoints into history instead of appending them indefinitely to Current Pickup.

### Priority 3 — Normalize the Markdown runtime

1. Approve a small set of record types and authority statuses.
2. Add stable IDs first to one vertical slice, not the entire vault at once.
3. Validate IDs, links, status transitions, supersession, and required fields.
4. Preserve readable prose while making the bookkeeping deterministic.

### Priority 4 — Connect decisions to consequences

1. Record accepted answers as stable decision events.
2. Add explicit `affects`, `supersedes`, and dependency links.
3. Generate a blast-radius report when a decision changes.
4. Mark affected projections and scene contracts stale until reviewed.

### Priority 5 — Prove the complete authorship path

Use one bounded vertical slice to prove:

`conversation → reflected answer → author confirmation → decision event → updated state → scene contract → draft → checks → author review → manuscript candidate → Project Explorer explanation`

Do not build a general platform before this path works once.

### Priority 6 — Simplify operation and presentation

1. Build a plain-language Vault Overview in the Project Explorer.
2. Present the vault as a small number of understandable jobs rather than hundreds of files.
3. Separate “working,” “needs repair,” and “planned” capabilities.
4. Keep technical paths available only as optional detail.
5. Mark or relocate the old root-level stress-test structure so it cannot be mistaken for the current vault.

### Priority 7 — Harden deployment and recovery

1. Keep the cPanel Git checkout outside the public web root.
2. Deploy a clean archive into `public_html/devsite/`.
3. Ignore server logs and other runtime artifacts.
4. Keep `main` deployable and use one `dev` branch for substantial work.
5. Record a short, tested mobile recovery procedure.

## Recommended next milestone

The next milestone should be **Vault Reliability Pass 1**, not another new workflow.

It is complete when:

- a clean build produces ten current workshop modules;
- every site and snapshot is current;
- the checker passes;
- PHP and JavaScript syntax are checked before merge;
- one page identifies the actual current state;
- the Project Explorer clearly shows what the vault does and what is still planned;
- the author can understand the system without reading folder names or workflow terminology.

## Bottom line

The vault already contains most of the right ideas and boundaries. It does not need more complexity. It needs consolidation, enforcement, one proven end-to-end path, and a much simpler public explanation.
