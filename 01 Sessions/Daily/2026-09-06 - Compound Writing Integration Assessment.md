---
type: session
status: proposed
date: 2026-09-06
topic: compound writing integration assessment
authority: advisory analysis only — no canon or workflow promotion yet
sources:
  - https://github.com/EveryInc/compound-writing
  - skills/README.md
  - skills/write-seeds-prose/
  - skills/coach-seeds-writing/
  - skills/develop-story-session/
  - 08 Story Loop/
  - 03 Context/WRITING-STYLE.md
  - 03 Context/RULES.md
audience: GPT analysis / author decision support
---

# Compound Writing → Seeds Integration Assessment

## Purpose of this note

This is an advisory integration assessment for GPT and the author. It asks whether and how functionality from Every's open-source **Compound Writing** (CW) toolbox should be integrated into the *Seeds of the Throne* vault.

Status of every recommendation below: **proposed**. Nothing in this note establishes story canon, promotes a compiled workflow change, or retires an existing Seeds skill.

## Executive recommendation

Integrate **selectively and late in the pipeline**, not as a replacement for Seeds' development system.

- **Do integrate:** CW's front-door routing pattern, named pressure-test lenses, residue/tracks cleanup, BLUF/lede diagnosis, portable author-voice calibration loop, and a few reviewer personas adapted for fiction.
- **Do not integrate wholesale:** CW's essay/article outcome map, publication-readiness as the default end state, generic writing-home scaffold as a second memory system, or any CW skill that would encourage finished prose before structural stability.
- **Governing principle:** Seeds remains a **development-first story OS**. CW patterns should strengthen the **downstream manuscript / exploratory-prose layer**, and only after Story Loop gates say the material is ready enough to draft.

## Source systems compared

### Seeds of the Throne (current)

Primary job: persistent multi-year story development memory with deliberate promotion of ideas into compiled notes.

Strengths already present:

1. Layered memory (`01 Sessions/` → `02 Story/` → `03 Context/`) with status labels.
2. Development Orchestrator and Gap Analyzer as the default path.
3. Development Prototype Style as the disposable story-test register.
4. Modular fiction prose system (`write-seeds-prose`) with scene packets, anti-AI pass, controlled variance, rubric, benchmarks, and learning loop.
5. Coaching skill that withholds prose by default.
6. Continuity auditing, research-advisory boundary, critic loop, subagent delegation protocol.
7. Visual generation, journals, weekly synthesis, public atlas — adjacent production systems CW does not cover.

Current phase constraint from `03 Context/CURRENT.md`: the vault is explicitly development-first. Finished-novel prose is downstream. Prototypes are the default story-rendering mode.

### Compound Writing (external)

Primary job: context-first writing toolbox for developing ideas, drafting, revising, stress-testing, and preparing work for publication without sanding off the writer.

Relevant architecture:

1. Front door: `cw-scribe` routes open-ended requests to the smallest useful workflow.
2. Writing home: `VOICE.md` (syntax/diction/tone) vs `STYLE.md` (argument/evidence/structure/readiness).
3. Outcome map rather than forced seven-stage pipeline.
4. Specialist skills across idea development, drafting/revision, and pressure-testing.
5. `cw-save` for durable preference learning into VOICE/STYLE.
6. Shared skill source for Claude and Codex.
7. MIT-licensed generic toolbox; publication-specific extensions stay private.

CW is optimized for portable essay/article craft. Seeds is optimized for long-horizon fiction world continuity under author authority.

## Compatibility analysis

### Where the systems align

| Shared concern | Seeds already | CW contribution |
|---|---|---|
| Preserve writer voice | `WRITING-STYLE.md`, voice profile, controlled variance | Stronger portable VOICE vs STYLE split and save routing |
| Anti-machine residue | `anti-ai-prose.md`, prose lint | `cw-ai-check`, `cw-tracks` as named passes |
| Diagnose before rewrite | revision-method largest→smallest | `cw-dev-edit` then `cw-line-edit` separation |
| Pressure-test work | Critic Loop, Creative Interest, listener clarity | Reader/asshole/panel/debate and named stylistic lenses |
| Route by outcome | Orchestrator + skill handoffs | Cleaner conversational front door (`cw-scribe`) |
| Learn from feedback | prose learning loop + session notes | Explicit `cw-save` confirmation ritual |

### Where they conflict

| Conflict | Risk if integrated naively |
|---|---|
| CW default gravity is finished prose | Seeds would draft too early and smuggle proposed facts into polished language |
| CW `STYLE.md` encodes argument/evidence/publication readiness | Seeds needs canon status, POV limits, and unresolved questions more than article thesis/promise |
| CW writing home is a second scaffold | Duplicating `VOICE/STYLE/examples/drafts` beside the vault creates competing memory authorities |
| CW publication lenses assume one reader promise | Seeds often needs controlled ambiguity, incomplete explanation, and reconstruction mystery |
| CW skills are essay-shaped (`cw-thesis`, `cw-promise`, `cw-bluf`) | Useful for nonfiction-adjacent project writing; dangerous as fiction defaults |
| CW treats sources as provenance for claims | Seeds research is advisory and must not become canon without author decision |

### Non-transferable CW pieces

Do not port these into Seeds as first-class story tools:

1. **Generic writing-home installer** as a parallel vault root.
2. **Publication-readiness as terminal success condition** during current development phase.
3. **Essay thesis/promise pipeline** as the default story discovery path.
4. **Hard-coded publication/platform skills** — Seeds already rejects this pattern; CW itself keeps them out of the public package.
5. **Any CW behavior that silently edits plugin defaults or hidden onboarding state** — conflicts with Seeds' explicit session → compile promotion rule.

## Recommended integration strategy

### Strategy name

**Late-pipeline CW Adaptation Layer**

Keep Story Loop as the only development authority. Add a thin CW-inspired layer that activates only when:

1. the author explicitly asks for prose work, **or**
2. Development Orchestrator routes to prototype/manuscript prose after structural shortlisting, **or**
3. the author is writing non-story project text (handoffs, public atlas copy, research briefs) where essay tooling is appropriate.

### Design rules for any CW import

1. **Skill methods, not story authority.** Same rule as existing Seeds skills.
2. **No second memory root.** Map CW concepts onto existing files rather than creating a sibling writing-home.
3. **Preserve status labels.** Every nontrivial imported claim remains established/working/proposed/unresolved/rejected.
4. **Prototype vs manuscript modes stay distinct.** CW-style polish belongs mainly to manuscript-candidate mode.
5. **Author gate remains mandatory** before promotion into `02 Story/` or style-authority changes.
6. **Do not replace** `develop-story-session`, Gap Analyzer, Critic Loop, or continuity audit with CW brainstorm/interview tools.
7. **Prefer adaptation over vendoring.** Re-express useful CW passes in Seeds vocabulary; do not install the CW plugin tree as a dependency of canon.

## Proposed adoption tiers

### Tier 0 — Do not change yet (observe)

Use CW as external reference material only. No Seeds skill edits.

When useful: if the author wants to try CW in a separate Claude/Codex session on disposable prototype prose, then bring back only confirmed preferences via a Seeds daily note.

### Tier 1 — High value, low risk (recommended first)

These improve Seeds without changing development authority.

#### 1. Conversational prose front door inside existing routing

**Adapt:** `cw-scribe` pattern.

**Seeds placement:** extend `write-seeds-prose` and/or a thin new skill such as `route-seeds-writing` that:

- accepts ordinary-language requests ("this scene feels dead"; "find the buried lede"; "make this less AI");
- checks whether the request is actually coaching, continuity, research, or story invention;
- hands off to the correct Seeds skill;
- if prose is appropriate, chooses the smallest pass (evaluate / structural revise / line revise / anti-AI / reader test).

**Why:** Seeds already has excellent specialist tools, but the catalog is agent-facing. CW's front door is user-facing. The author currently benefits most when the system chooses the pass.

**Risk:** low, if it never bypasses Story Loop for unresolved story decisions.

#### 2. Named residue / tracks pass

**Adapt:** `cw-tracks` + parts of `cw-ai-check`.

**Seeds placement:** add an explicit **Tracks Pass** section to `write-seeds-prose/references/anti-ai-prose.md` or a sibling `tracks-pass.md`.

Target residues common in AI-assisted fiction development:

- process narration ("as established earlier", "we need to understand");
- scaffolding left from outlines and critic notes;
- development-prototype conversational crutches leaking into manuscript candidates;
- over-explained turns;
- leftover option menus inside narrative.

**Why:** Seeds already catches machine patterns, but not always the *development-process residue* created by this vault's own workflows.

**Risk:** low.

#### 3. BLUF / buried-lede diagnosis for scenes and prototypes

**Adapt:** `cw-bluf`.

**Seeds placement:** optional diagnostic in `write-seeds-prose` revision and in Development Prototype critique.

Ask:

- What is the most important change in pressure, knowledge, or choice?
- Does it appear where the reader needs it?
- Is the true turn buried under setup, lore, or throat-clearing?

**Why:** Especially useful for Archive Thriller / reconstruction scenes and for prototypes that bury the interesting mechanism under orientation.

**Risk:** medium if applied dogmatically. Seeds sometimes wants delayed revelation. BLUF must diagnose placement, not force journalism-style openings.

#### 4. Split developmental edit vs line edit more sharply in UX

**Adapt:** `cw-dev-edit` / `cw-line-edit` naming and sequencing.

**Seeds placement:** already present in revision-method largest→smallest; expose it as named author-facing passes:

- **Dev-edit pass:** purpose, causality, motive, knowledge, order, stakes.
- **Line-edit pass:** sentences, diction, rhythm, controlled variance, anti-AI.

**Why:** Reduces premature polishing, which is one of the highest failure modes when AI helps write fiction inside a rich vault.

**Risk:** low.

#### 5. Explicit save ritual for prose preferences

**Adapt:** `cw-save`.

**Seeds placement:** formalize the existing learning loop into a visible confirmation ritual:

1. detect repeated author preference;
2. propose a rule candidate;
3. say whether it belongs in `WRITING-STYLE.md`, voice-profile, character-voice notes, anti-AI list, or a benchmark;
4. wait for author confirmation;
5. never silently edit style authority.

**Why:** CW's confirmation ritual is cleaner than "update the skill when the pattern is clear enough." Seeds already intends this; CW makes the UX explicit.

**Risk:** low.

### Tier 2 — Medium value, needs fiction adaptation

#### 6. Reader-experience pass

**Adapt:** `cw-reader` / `cw-mom`.

**Seeds placement:** optional critic under Critic Loop or prose evaluation:

- first-time-reader confusion;
- missing setup;
- term density;
- false assumptions;
- off-putting friction that is accidental rather than intentional.

**Why:** Overlaps Problem-Solving / Listener-Clarity Critic, but CW's first-time-reader framing is useful for manuscript candidates and public atlas prose.

**Risk:** medium. Must not flatten deliberate mystery, incomplete explanation, or reconstruction ambiguity into "clarity at all costs."

#### 7. Hostile / least-charitable reading pass

**Adapt:** `cw-asshole` / `cw-objections`.

**Seeds placement:** optional pressure tool for:

- antagonist logic holes;
- protagonist plan convenience;
- evidence that only works because the vault knows the answer;
- thematic speeches disguised as dialogue.

**Why:** Complements Causality Critic and Creative Interest Critic with a more adversarial rhetorical stance.

**Risk:** medium. Must not become a demand for realist procedural completeness that kills speculative or grotesque modes.

#### 8. Multi-reviewer panel / debate

**Adapt:** `cw-panel` / `cw-debate`.

**Seeds placement:** optional mode of Critic Loop when several lenses disagree.

**Why:** Seeds already separates critics, but synthesis is often single-threaded. Structured disagreement among Character / Causality / Continuity / Creative Interest critics would surface real tradeoffs.

**Risk:** medium-high token cost; can create committee mush if the primary agent does not adjudicate against Seeds authority rules.

#### 9. VOICE vs STYLE conceptual split mapped onto existing files

**Adapt:** CW's VOICE/STYLE boundary.

**Seeds mapping proposal:**

| CW concept | Seeds home |
|---|---|
| VOICE.md | `03 Context/WRITING-STYLE.md` + `write-seeds-prose/references/voice-profile.md` + character voice notes |
| STYLE.md | scene/chapter architecture, exposition rules, information-control standards, prototype vs manuscript readiness criteria, continuity/authority gates |
| examples/ | approved author prose samples + benchmark suite + approved journal writing samples |
| drafts/ | `06 Draft/` and/or Story Loop run packets / exploratory drafts in sessions |

**Why:** The conceptual split is excellent. Creating literal `VOICE.md`/`STYLE.md` at vault root would fork authority.

**Risk:** medium if filenames proliferate. Prefer clarifying the existing map over adding parallel files.

#### 10. Selected stylistic lenses, fiction-adapted only

**Adapt carefully:** `cw-hemingway`, `cw-hitchcock`, `cw-sorkin`, `cw-vonnegut`, `cw-sedaris`.

Recommended Seeds stance:

- Keep as **optional named lenses**, not default style authorities.
- Use only when the author asks for a pressure test.
- Never let a celebrity-lens rewrite overwrite Archive Thriller / Development Prototype defaults.
- Prefer Seeds-native lens names where possible to avoid imitating living/dead author voice as a substitute aesthetic.

Suggested Seeds-native equivalents:

| CW lens | Seeds-native job |
|---|---|
| hemingway | economy / cut false profundity |
| hitchcock | reader-knowledge timing / suspense geometry |
| sorkin | momentum / forward motion |
| vonnegut | want, stakes, purposeful sentences |
| sedaris | specificity / self-implication (use sparingly; often wrong register for Seeds) |
| asshole | least-charitable attack on convenience |

**Why:** Useful as temporary diagnostic heat, dangerous as house style.

**Risk:** high if they become default. Keep opt-in.

### Tier 3 — Useful outside core story drafting

#### 11. Essay/outcome tools for project communication

**Adapt:** `cw-thesis`, `cw-promise`, `cw-outline`, `cw-final-pass`.

**Seeds placement:** optional helpers for:

- weekly synthesis summaries;
- public atlas page copy;
- desktop handoff briefs;
- research-request framing;
- non-canon exploratory memos.

**Why:** CW is strong at nonfiction clarity. Seeds project writing often needs that more than the fiction does.

**Risk:** low if strictly quarantined from story discovery.

#### 12. Interview / brainstorm only as secondary helpers

**Adapt:** `cw-interview`, `cw-brainstorm`.

**Seeds placement:** subordinate helpers inside `develop-story-session`, never replacements for Gap Analyzer / Creative Possibilities / author gate.

**Why:** Seeds brainstorming already preserves alternatives and status. CW interview is good at drawing out material, but weaker at canon discipline.

**Risk:** medium if used as a bypass around orchestrated development.

### Tier 4 — Reject or defer

1. **Installing CW as a marketplace plugin dependency of the vault.** Seeds skills should remain tool-neutral and vault-owned.
2. **Making `cw-final-pass` the definition of done for story units.** Development done ≠ manuscript ready ≠ publishable.
3. **Replacing Development Prototype Style with CW draft defaults.**
4. **Creating a literal writing-home that mirrors CW's folder scaffold beside `01/02/03`.**
5. **Auto-promoting CW pressure-test suggestions into canon.**
6. **Using CW to generate finished chapters as the main discovery method.** Conflicts with stated authorship boundary: final fiction remains human-authored; AI builds skeleton and disposable tests.

## Suggested concrete implementation plan

### Phase A — Analysis complete / author decision

This note.

Author decides:

- adopt Tier 1 now?
- which Tier 2 lenses are wanted?
- quarantine Tier 3 to project-comms only?

### Phase B — Documentation-only integration (no behavior change)

If approved, create a proposed compiled note such as:

`08 Story Loop/COMPOUND-WRITING-ADAPTATION.md` (status: proposed)

Contents:

- activation conditions;
- mapping table CW concept → Seeds file;
- allowed passes;
- forbidden substitutions;
- examples of good/bad routing.

Also update `skills/README.md` catalog descriptions only after skills exist.

### Phase C — Tier 1 skill/reference edits

1. Add Tracks Pass reference under `write-seeds-prose`.
2. Add BLUF/lede diagnostic as optional revision step with mystery-preserving caveats.
3. Expose Dev-edit vs Line-edit as named passes in `revision-method.md` and `SKILL.md`.
4. Add Save Preference ritual to the learning loop.
5. Optionally add `route-seeds-writing` skill as conversational front door.

Validation:

- run against one disposable prototype;
- run against one manuscript-candidate paragraph;
- confirm no unresolved story fact gets silently settled;
- record results in `07 QA/Shared Skill Tests.md`.

### Phase D — Tier 2 critic extensions

1. Add Reader-Experience and Hostile-Reading as optional Critic Loop lenses.
2. Add Panel/Debate synthesis mode with primary-agent adjudication rules.
3. Document VOICE/STYLE mapping without creating duplicate authority files.
4. Add opt-in named stylistic lenses with hard "not house style" warnings.

Validation:

- one Critic Loop run where lenses disagree;
- confirm author gate still required;
- confirm continuity critic can veto prose elegance.

### Phase E — Tier 3 project-comms helpers

Only if the author wants clearer public/status writing. Keep physically separate from fiction prose skill if possible (`skills/write-seeds-project-prose/` or references under coordination).

## Fit against current Seeds priorities

From current context, the active center of gravity is:

- bridge-world / Luminai initialization foundation;
- Samuel–Konrad containment hierarchy, one question at a time;
- development-first Story Loop;
- journals and weekly synthesis as support systems;
- finished prose deferred.

Implication:

**CW integration is not the highest story priority.** It is a tooling improvement that should wait for an explicit author request to touch writing-system files, or be queued as desktop/workflow work rather than interrupting active containment-hierarchy development.

Recommended queue classification if accepted:

- **Workflow / tooling enhancement**
- Not a story completion task
- Not a canon decision
- Suitable for desktop implementation after author selects tiers

## Decision checklist for GPT analysis

When analyzing this note, GPT should answer:

1. Which Tier 1 items are redundant with existing Seeds references and should be merged rather than added?
2. Does a new `route-seeds-writing` skill improve discoverability enough to justify another catalog entry, or should `write-seeds-prose` absorb front-door routing?
3. Which CW essay metaphors (`thesis`, `promise`, `BLUF`) are safest to rename into Seeds fiction language?
4. What failure modes appear if Reader/Hostile lenses run before Continuity Critic?
5. How should CW-adapted passes interact with Development Prototype Style vs Archive Thriller manuscript candidates?
6. What is the smallest reversible experiment that would falsify the value of this integration?
7. Should any recommendation be rejected because it conflicts with the human-authored final-fiction boundary?

## Smallest reversible experiment

If the author wants evidence before broader integration:

1. Take one existing 500–1,000 word development prototype.
2. Without changing skills, manually run four CW-inspired passes in order:
   - BLUF/lede diagnosis;
   - Dev-edit only;
   - Tracks/anti-residue;
   - Hostile reading.
3. Record whether the passes found problems Seeds critics missed.
4. Only then decide whether to encode them into skills.

Success criteria:

- finds at least one high-leverage structural or residue problem not already caught;
- does not pressure the prototype into false certainty or premature canon;
- remains usable in under one focused session.

Fail criteria:

- mostly restates existing revision-method checks;
- pushes journalistic clarity onto material that needs mystery;
- increases tooling complexity without changing revision behavior.

## Open questions

- Should CW-adapted passes be available during prototype mode, or only manuscript-candidate mode?
- Does the author want celebrity-named lenses at all, or only Seeds-native names?
- Should project-comms writing get its own skill, or remain informal?
- Is the desired end state a stronger Seeds prose skill, or a dual-mode system (development OS + manuscript workshop)?
- Should any CW MIT code/text be copied, or only concepts reimplemented in Seeds language to avoid upstream coupling?

## Affected files if later implemented

Proposed touch list only; not modified by this note:

- `skills/write-seeds-prose/SKILL.md`
- `skills/write-seeds-prose/references/revision-method.md`
- `skills/write-seeds-prose/references/anti-ai-prose.md`
- possible new `skills/write-seeds-prose/references/tracks-pass.md`
- possible new `skills/route-seeds-writing/SKILL.md`
- `08 Story Loop/CRITIC-LOOP.md`
- possible new `08 Story Loop/COMPOUND-WRITING-ADAPTATION.md`
- `skills/README.md`
- `07 QA/Shared Skill Tests.md`
- maybe `03 Context/CURRENT.md` only if writing-system center of gravity changes

## Explicit non-decisions

This assessment does **not**:

- change Story Loop defaults;
- install or vendor Compound Writing;
- alter `WRITING-STYLE.md`;
- promote any story fact;
- resolve whether finished prose should become a nearer-term focus.

## Author decision — narrow experiment approved

On 2026-09-06, the author approved a small reversible integration experiment while story development is paused for vault-functionality work.

Approved for implementation and testing:

1. a Tracks pass for development-process residue;
2. a pressure-turn placement diagnostic adapted from the buried-lede idea;
3. visible development-edit and line-edit modes;
4. explicit preference routing and confirmation.

Not approved through this decision: a new routing skill, parallel `VOICE.md` or `STYLE.md` files, celebrity-named lenses, multi-reviewer panels, installation of Compound Writing, or changes to story canon.

## Summary recommendation for the author

Adopt **Tier 1 only** if tooling work is wanted now:

1. conversational routing into existing Seeds skills;
2. tracks/residue pass;
3. BLUF diagnosis with mystery caveats;
4. named dev-edit vs line-edit;
5. explicit preference-save ritual.

Hold Tier 2 for after one reversible experiment. Quarantine Tier 3 to project communication. Reject Tier 4.

Net expected benefit: better late-stage prose diagnosis and less process residue, without letting an essay workshop displace Seeds' development-first operating system.

## 2026-09-07 product-direction supersession

The author has now established a broader product destination: the vault should serve story-rich, craft-light creators and guide them conversationally from raw material through workshops, story construction, and finished prose. This supersedes this assessment's earlier **permanent product-boundary implication** that final fiction must remain manually human-written or that AI must stop at skeletons and disposable tests.

The sequencing constraint remains active: Seeds is development-first at its current stage, finished prose should not conceal unresolved structure, and author authority and approval remain mandatory. Compound Writing remains a selective component candidate rather than the governing system. See [[07 Coordination/Conversational Authorship Product Direction]].
