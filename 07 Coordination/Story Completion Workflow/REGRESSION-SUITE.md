---
type: story-regression-contract
status: active
updated: 2026-08-24
---

# Story Regression Suite

Run checks selected by the blast radius. Record `PASS`, `PASS-WITH-NOTES`, `FAIL`, or `NOT-APPLICABLE` with file evidence.

| ID | Trigger | Check |
|---|---|---|
| R-01 Authority | any story claim changes | No proposal, prototype, research result, generated image, or task state was promoted without an author gate. |
| R-02 Chronology | event, age, duration, custody, sequence order | Relative ordering, elapsed time, ages, and handoffs remain possible. |
| R-03 Knowledge | evidence, reveal, surveillance, POV | Each character knows only what they could perceive, infer, receive, or verify by that point. |
| R-04 Causality | event or mechanism | The next load-bearing event follows from an action, constraint, or consequence rather than coincidence. Reverse reconstruction also works. |
| R-05 Agency | manipulation, control, environment, AI | Available choices, verification opportunities, costs, and responsibility remain visible. |
| R-06 Systems | capability, permission, containment, Luminai/Daemon | Actor, channel, permission, resource, blind spot, audit trail, failure mode, and hard limit remain bounded. |
| R-07 Evidence | record, artifact, disclosure | Creation, custody, authentication, access, challenge, reveal threshold, privacy, and consequence are traceable. |
| R-08 Motivation | character choice or consequence | The change does not erase or reverse a motive without an experienced cause. |
| R-09 Setup/payoff | capability, clue, trap, final state | Required setup remains early enough, payoff uses it, and no new retroactive convenience appears. |
| R-10 Control/state | sequence or scene transition | Entering control/belief/relationship/evidence state matches the preceding output. |
| R-11 Ending pressure | endgame change | The ending is not made easier by omnipotence, missing opposition, erased cost, or diminished Sylvan agency. |
| R-12 Theme boundary | leadership, inheritance, cultivation | Legitimate development remains distinct from the criminal faction's inheritance obsession and coercive hierarchy. |
| R-13 Prose boundary | prototype or draft | Development prose does not establish canon; final prose enters the manuscript only after author approval. |
| R-14 Registry integrity | task/dependency change | IDs resolve, prerequisites exist, depth never skips a required sweep, and reopened work is visible. |

Use `Templates/regression-run.md` for every sweep close and any material decision change.
