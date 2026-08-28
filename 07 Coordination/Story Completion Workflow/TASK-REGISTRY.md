---
type: task-registry
status: active
updated: 2026-08-25
source: 07 Coordination/Weekly Synthesis/Runs/2026-08-23/12 Weekly Story Completion Todo.md
---

# Story Completion Task Registry

The weekly TODO owns the checklist wording and public completion state. This registry adds execution depth without changing story authority.

| ID | Priority | Task | Depth | Phase | Validation | Direct prerequisites |
|---|---:|---|---|---|---|---|
| SC-001 | 1 | Define what makes one contained criminal the primary | MACRO | COMPLETE | NOT-RUN | — |
| SC-002 | 1 | Finish the S-008 containment hierarchy needs analysis | MACRO | COMPLETE | NOT-RUN | SC-001 |
| SC-003 | 1 | Define Konrad's verification failure | MACRO | COMPLETE | NOT-RUN | SC-001, SC-002 |
| SC-004 | 2 | Choose the exact target of the attack on Sylvan's startup | MACRO | COMPLETE | NOT-RUN | — |
| SC-005 | 2 | Define Sylvan's irreversible choice and loss | MACRO | COMPLETE | NOT-RUN | SC-004 |
| SC-006 | 2 | Plant the first anomaly George cannot explain | MACRO | COMPLETE | NOT-RUN | SC-004 |
| SC-007 | 3 | Define one unprecedented completed-bond capability | MACRO | COMPLETE | NOT-RUN | — |
| SC-008 | 3 | Define why the capability could not act earlier | MACRO | COMPLETE | NOT-RUN | SC-007 |
| SC-009 | 3 | Define a hard limit and cost | MACRO | COMPLETE | NOT-RUN | SC-007, SC-008 |
| SC-010 | 3 | Build an endgame setup coverage matrix | MACRO | AUTHOR-GATE | NOT-RUN | SC-007, SC-008, SC-009 |
| SC-011 | 4 | Choose the first record proving Konrad designed Samuel's mission to fail | UNTOUCHED | IDLE | NOT-RUN | — |
| SC-012 | 4 | Choose the Witness | UNTOUCHED | IDLE | NOT-RUN | — |
| SC-013 | 4 | Map Witness to Orzai to Sylvan custody | UNTOUCHED | IDLE | NOT-RUN | SC-011, SC-012 |
| SC-014 | 4 | Define Samuel's surveillance channel | UNTOUCHED | IDLE | NOT-RUN | SC-002 |
| SC-015 | 5 | Define what George can independently verify | UNTOUCHED | IDLE | NOT-RUN | SC-006, SC-014 |
| SC-016 | 5 | Identify two or three George refusal points | UNTOUCHED | IDLE | NOT-RUN | SC-015 |
| SC-017 | 5 | Give Orzai her first costly professional refusal | UNTOUCHED | IDLE | NOT-RUN | — |
| SC-018 | 6 | Build the relative chronology anchor table | UNTOUCHED | IDLE | NOT-RUN | — |
| SC-019 | 6 | Select four to six indispensable middle milestones | UNTOUCHED | IDLE | NOT-RUN | SC-018 |
| SC-020 | 6 | Choose Konrad's first limited Great War defeat | UNTOUCHED | IDLE | NOT-RUN | — |
| SC-021 | 7 | Define the employment environment's terminal rule | UNTOUCHED | IDLE | NOT-RUN | — |
| SC-022 | 7 | Define Samuel's ongoing maintenance actions | UNTOUCHED | IDLE | NOT-RUN | SC-014, SC-021 |
| SC-023 | 7 | Define the exposure audience and proof threshold | UNTOUCHED | IDLE | NOT-RUN | SC-013, SC-022 |
| SC-024 | 7 | Define Sylvan's cost of victory | UNTOUCHED | IDLE | NOT-RUN | SC-005, SC-009, SC-021 |
| SC-025 | 8 | Prototype two openings | UNTOUCHED | IDLE | NOT-RUN | SC-005, SC-011, SC-018, SC-019, SC-020 |
| SC-026 | 8 | Choose the revelation order | UNTOUCHED | IDLE | NOT-RUN | SC-010, SC-013, SC-015, SC-019, SC-022, SC-023, SC-025 |
| SC-027 | 8 | Choose final states only after the mechanism works | UNTOUCHED | IDLE | NOT-RUN | SC-016, SC-023, SC-024, SC-026 |

## Update contract

When a row changes, also update its task packet, [[CURRENT]], [[COMPLETION]], and [[LOOP-LOG]]. If an approved decision changes a prerequisite or downstream result, run [[UNLOCK-MAP#Decision propagation]] before marking validation complete.
