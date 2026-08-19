# Seeds Prose Benchmark Suite

Use these scenarios to regression-test the prose skill after meaningful changes. The expected behavior matters more than any exact wording.

## B1 — Close POV anomaly

**Prompt shape:** Draft a short George scene in which a familiar system behaves slightly wrong before he understands why.

**Must:** stay inside George's available perception; make the anomaly concrete; preserve a plausible local explanation; change pressure by the end.

**Must not:** explain the hidden system from vault knowledge; announce that reality is false; resolve the anomaly immediately; rely on generic dread.

## B2 — Political grotesque without villain monologue

**Prompt shape:** Draft a private Samuel/Konrad exchange about an ugly institutional decision.

**Must:** give each speaker an immediate goal; use hierarchy, euphemism, irritation, procedure, vanity, or family status; let moral ugliness emerge from what they normalize.

**Must not:** make either character lecture the reader about ideology; turn both voices into interchangeable sinister dialogue; use theatrical declarations merely to make them evil.

## B3 — Archive reconstruction

**Prompt shape:** Explain an accepted historical account that is weakened by one surviving record.

**Must:** clearly establish the accepted version and the contradictory detail; preserve uncertainty if the record does not prove the full alternative; make the contradiction matter.

**Must not:** use a compulsory punchline turn; over-explain the entire system; claim certainty beyond the evidence.

## B4 — Technology as infrastructure

**Prompt shape:** Reveal a sophisticated system during a scene in which a character needs it to work.

**Must:** show capability through use, limit, delay, failure, cost, or procedure; describe only what the viewpoint needs.

**Must not:** marvel at routine technology; insert an encyclopedia paragraph; explain architecture before consequence.

## B5 — Suspense through unequal knowledge

**Prompt shape:** The reader has one fact the POV character lacks while another character is trying to conceal it.

**Must:** maintain the three knowledge states; let dialogue/actions carry concealment; create pressure from the gap.

**Must not:** leak the hidden fact into POV narration; force implausible evasiveness only to preserve suspense.

## B6 — Restraint on a clean passage

**Prompt shape:** Revise a passage that already has clear POV, concrete action, and effective ending, but contains one awkward sentence.

**Must:** diagnose the narrow problem; preserve unusual choices that work; make the smallest useful revision.

**Must not:** rewrite the entire voice into house-style clichés; add a turn; increase drama without need.

## B7 — Anti-AI seeded passage

**Prompt shape:** Evaluate prose intentionally containing repeated "not X, but Y" contrasts, generic grandeur, explanation after effect, symmetrical one-line paragraphs, and abstract emotion labels.

**Must:** identify the specific clusters; distinguish pattern from isolated legitimate use; recommend structural correction before cosmetic synonym replacement.

**Must not:** call every short sentence or metaphor an AI tell.

## B8 — Unresolved canon boundary

**Prompt shape:** Draft around an event whose exact cause remains unresolved in the vault.

**Must:** preserve the unresolved cause; use observable consequences or character beliefs; mark any exploratory connective detail as proposed outside the prose.

**Must not:** select a canonical cause merely to make the passage feel complete.

## B9 — Continuation inheritance

**Prompt shape:** Continue supplied prose with an established tense, POV, psychic distance, and rhythm.

**Must:** inherit those properties; move the existing pressure forward; avoid reintroducing already-established setup.

**Must not:** snap back to a default project register when the source passage intentionally uses a different valid register.

## B10 — Exposition under conflict

**Prompt shape:** A character must explain a system to someone who has a reason to resist, doubt, exploit, or misunderstand the explanation.

**Must:** make explanation serve persuasion, argument, briefing, interrogation, or another real action; let response reshape what gets explained.

**Must not:** alternate question-and-answer lines that exist only to teach the reader.

## Scoring protocol

For each benchmark:

1. verify critical gates from `evaluation-rubric.md`;
2. score only dimensions relevant to the scenario;
3. run `prose_lint.py` when available;
4. record the strongest success and strongest failure;
5. revise the skill only for repeatable failures, not one-off taste differences.

A change passes regression when it improves its target benchmark without causing a meaningful failure in a different register.
