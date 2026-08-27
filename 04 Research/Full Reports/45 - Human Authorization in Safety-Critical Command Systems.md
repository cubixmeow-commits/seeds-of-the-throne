---
type: research-report
status: complete-advisory-non-canon
date: 2026-08-26
research_queue_id: R-04
---

# 45 — Human Authorization in Safety-Critical Command Systems

**Story focus:** P-05 The One Honest Task; P-06 The Army That Requires a Human No; SC-010 permission setup

## Research question

How do mature command systems distinguish access, recommendation, authorization, identity, and accountable consent when a powerful operator attempts to seize control?

## Bottom line

Real safety and security practice does not treat control as a single transferable substance. It separates:

`identity -> authenticated role -> scoped access -> available action -> required authorization -> concurrence / separation of duties -> execution -> monitoring -> audit -> override or deactivation`

A person may see a system without controlling it, control one function without authorizing a consequential outcome, or possess an authorization role without holding custody of the mechanism that executes it. High-consequence action can require multiple competent people, explicit approval, mode awareness, and a durable record.

For Seeds, the strongest translation is not a synthetic system that morally judges Samuel. It is a mature architecture that cannot assemble a valid consequential command because Samuel lacks the independent legitimate human decisions the process requires.

## Supported findings

### 1. Least privilege and separation of duties constrain authorized insiders

**[SUPPORTED]** NIST controls use least privilege to limit access to what a role requires and separation of duties to reduce abuse by dividing critical functions among people or roles. Access administration and audit administration should not collapse into one actor.

**Story value:** Samuel's broad alpha access can remain real while still failing to include custody, independent verification, audit control, or another leader's authorization.

### 2. Authorization is an accountable decision, not mere authentication

**[SUPPORTED]** NIST's risk-management framework distinguishes technical permissions from a responsible official's decision to accept risk and authorize operation. Identity and access systems can distribute approval authority across operational, technical, and physical-security roles.

**Story value:** a correct identity token can open the request path without satisfying the decision requirement.

### 3. Human–AI roles must be explicit and testable

**[SUPPORTED]** The NIST AI RMF calls for documented human roles, oversight procedures, independent assessment, monitoring, appeal, override, incident response, and deactivation. NASA human-systems guidance requires attention to task allocation, mode changes, human error, and human-in-the-loop verification for safety-critical work.

**Story value:** Sylvan's conscious authority should appear as a trained operational role with visible handoffs and limits, not a thematic incantation.

### 4. Some critical actions require concurrence

**[SUPPORTED]** Two-person rules and comparable controls require two competent people to remain present or independently participate in a sensitive operation. Their purpose is to prevent one authorized individual from acting alone.

**Story value:** “cooperation” can mean a valid multi-role decision whose participants remain individually accountable, not emotional agreement or system-scored redemption.

## A Seeds-compatible command grammar

1. **Observe:** the system or Luminai can perceive and model.
2. **Recommend:** it can propose an action and expose consequences.
3. **Request:** an authenticated human can initiate a bounded operation.
4. **Authorize:** the human holding the relevant legitimate role accepts responsibility.
5. **Concur:** an independent role confirms a different required proposition.
6. **Execute:** the system performs only the authorized scope.
7. **Verify:** participants receive state and outcome feedback.
8. **Audit:** the record preserves who knew, chose, refused, or attempted to bypass.
9. **Override / safe stop:** a separate path contains failure without granting unlimited counter-control.

This is a story synthesis from supported principles, not canon.

## Research-to-story translation

`broad access without complete authority + independent human roles + explicit concurrence + immutable audit -> Samuel can reach the command surface but cannot manufacture the missing legitimate decisions -> he must ask real people to cooperate or expose his attempt to bypass them`

## Constraints and failure modes

- A nominal human button is not meaningful oversight if the operator lacks time, information, competence, or freedom to refuse.
- Too many approvals can become bureaucracy rather than drama.
- Concurrence does not prove morality; colluding authorized people can still abuse power.
- Override paths can become hidden master keys unless separately scoped and audited.
- Mode confusion can make a human believe automation is waiting when it has already acted, or vice versa.
- The story must establish the role grammar early enough that the endgame does not feel invented for the payoff.

## What this adds to the creative packet

- P-05 should be a small multi-role act with separate request, authorization, concurrence, and verification functions.
- P-06 should become **missing valid human authority**, not an army's moral refusal.
- SC-010 gains a plausible future setup category: Sylvan learns to distinguish seeing, requesting, authorizing, concurring, executing, and auditing consequential actions.

## Sources

- NIST (2020, updated release), SP 800-53 Rev. 5.1, separation of duties and least privilege: https://csrc.nist.gov/CSRC/media/Projects/risk-management/800-53%20Downloads/800-53r5/SP_800-53_v5_1-derived-OSCAL.pdf
- NIST Risk Management Framework, authorization step (current page accessed 2026-08-26): https://csrc.nist.gov/Projects/risk-management/about-rmf/authorize-step
- NIST (2018), SP 1800-2, identity and access management: https://www.nccoe.nist.gov/publication/1800-2/VolB/
- NIST (2023), AI RMF Core: https://airc.nist.gov/airmf-resources/airmf/5-sec-core/
- NIST (2023), AI RMF Appendix C, human–AI interaction: https://airc.nist.gov/airmf-resources/airmf/appendices/app-c-ai-risk-management-and-human-ai-interaction/
- NASA, Systems Engineering Processes, human error and human-in-the-loop evaluation (current reference accessed 2026-08-26): https://www.nasa.gov/reference/3-0-systems-engineering-processes-vol-2/
- NASA, Crew Interfaces, automation responsibility delineation (current reference accessed 2026-08-26): https://www.nasa.gov/reference/10-0-crew-interfaces-vol-2/
- IAEA (2008), Nuclear Security Series No. 8, two-person rule: https://www-pub.iaea.org/MTCD/publications/PDF/pub1359_web.pdf
