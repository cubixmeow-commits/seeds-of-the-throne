---
type: story-loop-protocol
status: active
version: 0.1
updated: 2026-08-26
scope: bounded research and brainstorming synthesis into non-canon story possibilities
---

# Research → Creative Possibilities / Inspiration Pass

## Purpose

Turn a bounded window of recent research, brainstorming, canon decisions, character motives, system rules, unresolved questions, and structural gaps into several strong directions for author review.

The pass answers:

> Given what we now know, what interesting possibilities does it create?

It is an **inspiration and option-generation stage**, not an automatic story solver. Every generated direction remains **NON-CANON EXPLORATION** until the author explicitly accepts it through an Author Gate.

## Position in the Story Loop

Default sequence:

`research / brainstorming -> canon extraction -> gap analysis -> Creative Possibilities Pass -> author interest selection -> author-gate development -> canon decision -> focused critics -> integration / prototype / prose when separately authorized`

Use [[08 Story Loop/RESEARCH-CREATIVITY-FIT-LOOP|Research → Creativity → Story Fit Loop]] when a question needs new outside research. Use this pass when enough useful material already exists and the missing act is synthesis: discovering what the accumulated material could make possible.

[[08 Story Loop/CREATIVE-INTEREST-LOOP|Creative Interest Loop]] evaluates whether a selected unit or candidate is experientially interesting. This pass operates one stage earlier and more broadly: it creates a portfolio of distinct possibilities from a recent development window.

## Authority contract

Before generation, classify every premise:

- **ESTABLISHED** — explicit author decision or current recorded canon;
- **WORKING** — active scaffold that may change;
- **UNRESOLVED** — deliberately open question;
- **RESEARCH** — supported finding, extrapolation, or premise from a research note;
- **NON-CANON EXPLORATION** — generated possibility only;
- **REJECTED / SUPERSEDED** — unavailable unless the author explicitly reopens it.

The pass may combine established facts, pressure working assumptions, and offer answers to unresolved questions. It may not present an offered answer as established. It may not overwrite an author decision, conceal a contradiction, or promote a possibility because it scored well.

## Input packet

Declare a bounded development window. Prefer a week, one arc, one character cluster, or one research family rather than the whole vault.

Required inputs:

1. target scope and inspiration question;
2. direct source notes;
3. recent established decisions;
4. relevant character wants, fears, knowledge, and compulsions;
5. relevant system rules and hard limits;
6. unresolved questions and story gaps;
7. exclusions and protected ambiguity;
8. downstream Story Units or tasks the ideas might strengthen.

Do not use stale or superseded material as a live premise. If two sources conflict, record the conflict before generating.

## Analysis passes

### 1. Consequence mining

Ask what follows naturally from accepted decisions but has not yet been dramatized or structurally used.

Look for:

- second- and third-order consequences;
- costs displaced onto another character or generation;
- evidence created accidentally by a long-running system;
- a small earlier choice that becomes load-bearing later;
- a rule that helps one character while trapping another.

### 2. Character collision

Compare motives, shame, pride, knowledge, loyalties, and incompatible definitions of victory.

Generate choices rather than diagnoses. A useful possibility forces a character to act, refuse, confess, conceal, bargain, misread, sacrifice, or change tactics.

### 3. System exploitation and failure

Ask how existing Seeds-specific systems can be used honestly, abused, misunderstood, resisted, or made to reveal their operator.

Prefer existing containment, story functionality, lineage, synthetic, Luminai/Daemon, evidence, jurisdiction, scoring, and human-authority mechanisms over a new technology.

### 4. Gap conversion

For each important gap, ask whether it can become a source of tension or discovery before it is solved.

Do not fill every blank. Some gaps should become author questions, research prompts, controlled mysteries, or competing candidate mechanisms.

### 5. Research translation

Translate useful findings through:

`research mechanism -> Seeds-specific pressure -> concrete situation -> character choice -> cost -> later payoff`

Keep evidence class visible. Research can inspire a fictional mechanism; it does not prove the fictional mechanism or establish it as canon.

### 6. Anti-generic and risk pass

Attack the first obvious version. Ask what makes the idea belong specifically to *Seeds of the Throne*, what it risks contradicting, and whether it steals uncertainty or agency from a later sequence.

Include at most two higher-risk possibilities. Experimental does not mean arbitrary.

## Required possibility families

Generate across several families rather than producing cosmetic variants:

- natural consequences;
- character opportunities;
- world / system opportunities;
- plot escalations;
- reveals / recontextualizations;
- concrete scenes or set pieces;
- research-derived possibilities;
- weird / high-risk ideas.

Not every run needs an item in every family, but a standard run should contain 8–15 raw candidates before filtering.

## Candidate record

Each surviving possibility includes:

- **status:** NON-CANON EXPLORATION;
- **possibility:** one clear direction;
- **builds on:** exact sources or accepted facts;
- **story function:** what gap, pressure, reveal, or transition it could serve;
- **character choice:** who must choose what;
- **dramatic expression:** at least one concrete situation, image, record, ritual, or reversal;
- **continuity / authority risk:** what it might contradict or prematurely decide;
- **next gate:** Explore / Maybe / Reject / Promote to author-gate brainstorming.

## Ranking

Use **High / Medium / Low**, not false numerical precision, for:

- canon fit;
- dramatic potential;
- character relevance;
- Seeds specificity;
- setup / payoff value;
- continuity cost.

Add a one-sentence reason for the overall rank. Continuity cost is a risk measure: Low is safer.

Do not collapse the portfolio to one “best answer.” Preserve meaningful diversity. The shortlist should normally contain 4–7 possibilities with different functions or mechanisms.

## Output packet

Use [[08 Story Loop/Templates/creative-possibilities-pass|Creative Possibilities Pass template]]. The durable packet contains:

1. scope and source window;
2. authority ledger;
3. strongest implications already present;
4. gaps and tensions used as generators;
5. candidate portfolio;
6. shortlist with ratings and risks;
7. protected ambiguity / rejected shortcuts;
8. author review board;
9. one recommended first author-gate question.

Save active output in `08 Story Loop/Brainstorms/` while it awaits author decisions. Move durable critic findings to `Evaluations/` only when a selected candidate is evaluated. Accepted decisions are integrated into canon notes; the brainstorm packet remains a provenance record.

## Author review board

The author marks each shortlisted candidate:

- **Explore** — run one author-gate question at a time;
- **Maybe** — park without development;
- **Reject** — do not reuse as a live premise;
- **Promote** — the author has approved the direction for structured development, but any unresolved implementation still requires gates;
- **Combine** — name the specific candidates and preserve each one's risks.

Silence, enthusiasm from the model, or a high rating never counts as promotion.

## Desktop and weekly workflow

### Docs website projection

The public docs interface at `docs/ideas.html` reads [[08 Story Loop/Brainstorms/CURRENT-EXPERIMENTAL-IDEAS|CURRENT-EXPERIMENTAL-IDEAS]], which points to one active packet.

The active packet supplies four live interface regions:

- `Raw candidate portfolio` supplies the idea list and detail view;
- `Research inputs` shows which findings inspired the pass;
- `Suggested research queue` supplies Markdown checkboxes for research that could change or strengthen candidates;
- `Author review board` supplies each idea's current author status.

To update the website, edit the Markdown packet—not the rendered page. Use `UNREVIEWED`, `Explore`, `Maybe`, `Reject`, or `Promote` in the review board. Mark research complete with `[x]`. Change the stable pointer only when a newer packet should replace the current public workspace.

The website remains read-only and cannot approve canon.

### Current Pickup use

A Current Pickup may request a possibilities pass as a bounded sidecar without replacing the active Story Completion task. Record:

- the source cutoff;
- whether new canon was first integrated;
- where the non-canon output was saved;
- the next author gate;
- confirmation that the active completion sweep was not silently advanced.

### Weekly use

After weekly intake reconciliation and canon extraction:

1. take `BUILD NOW`, `BRAINSTORM NEXT`, research findings, open questions, and recent author decisions as inputs;
2. run one bounded portfolio;
3. return only the shortlist to the author;
4. route selected candidates into the existing Story Completion Workflow or a dedicated brainstorm;
5. leave unselected candidates non-canon and out of compiled story notes.

## Failure conditions

The pass fails if it:

- merely summarizes the sources;
- produces generic science-fiction twists;
- changes canon without an author gate;
- creates many variants of one preferred answer;
- hides contradictory premises;
- answers a protected mystery because an empty field exists;
- introduces new power to solve a problem an existing system should pressure;
- treats victims or children only as evidence, leverage, or plot objects;
- confuses intensity with interest;
- advances into prose or app implementation without separate authorization.

## Success condition

The pass succeeds when the author receives several causally grounded, Seeds-specific, dramatically expressible directions that reveal new uses for existing material while preserving the freedom to reject every one of them.
