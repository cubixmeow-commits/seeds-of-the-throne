---
type: research-report
status: advisory-non-canon
updated: 2026-08-09
research_sequence: 3-of-10
produced_by: OpenAI Codex (Sol)
---

# Evidence Under Total Information Control

## Purpose

This report develops a credible architecture for Sylvan Elaria's audio archive: how evidence can be recorded, authenticated, preserved, distributed, and disclosed when the adversary controls institutions, information channels, and some advanced infrastructure.

## Executive finding

No single recording should be decisive by itself. The archive becomes formidable when it combines four properties:

1. **content** — the conduct is actually captured;
2. **provenance** — the origin and chain of modification are verifiable;
3. **survivability** — no single actor or location can destroy every copy;
4. **interpretability** — independent records connect the voices, dates, authorities, and consequences.

Cryptography can show that a file has not changed since it was signed or entered into a log. It cannot prove that a scene was not staged, that a signer was honest, or that an audience will care. Sylvan therefore needs an evidentiary system and a political strategy, not merely a secret folder.

## 1. Authenticity has layers

NIST distinguishes integrity from origin: encryption can conceal content without proving who created it or whether it was altered. Content-provenance standards such as C2PA similarly treat authenticity as a set of verifiable facts about an asset's origin and history, not a magical declaration that its meaning is true.

For the archive, separate:

- **capture authenticity:** what device or witness created the record;
- **content integrity:** whether the bits changed after capture;
- **temporal integrity:** whether the record existed before a claimed date;
- **identity attribution:** whether the voices and participants are correctly identified;
- **contextual integrity:** what occurred before and after the excerpt;
- **institutional meaning:** what authority the speakers actually possessed;
- **substantive truth:** whether the captured statements correspond to conduct.

The Throne can attack whichever layer is weakest. “The file is unaltered” does not answer “the speaker was impersonated,” “the conversation was rehearsed,” or “you have misunderstood the office involved.”

## 2. Capture should generate a chain, not a file

The strongest fictional recorder creates several linked artifacts at capture time:

- encrypted raw audio;
- a cryptographic hash of the raw stream;
- device identity and current authorization state;
- a signed time or sequence marker;
- environmental corroboration such as location, access events, or nearby systems;
- a compact receipt sent outside the local environment;
- later transcripts and excerpts explicitly marked as derivatives.

Each transformation preserves the previous provenance. Editing an excerpt does not pretend the excerpt is raw; it points back to the source and records what was changed. This mirrors the logic of modern content credentials.

For story purposes, Sylvan may possess intelligible copies while the strongest authentication material is held elsewhere. That explains why stealing his personal device would not settle the problem.

## 3. Append-only logs make silent revision difficult

Certificate Transparency provides a useful real-world ancestor. Its logs are append-only and publicly auditable. Merkle-tree structures allow a small signed checkpoint to commit to every record already entered: changing or deleting an earlier record changes the tree root.

The story equivalent need not be a public blockchain. Sylvan's system could periodically publish tiny, meaningless-looking commitments to multiple independent archives. These reveal no audio but establish that particular evidence existed in a particular sequence.

Useful consequences:

- The Throne can destroy a local copy but cannot erase the external commitment.
- Sylvan can later prove a disclosed file matches an earlier sealed record.
- A custodian cannot secretly rewrite one entry without invalidating later checkpoints.
- Several witnesses can “gossip” checkpoints and detect if the archive shows different histories to different audiences.

This turns survival into a network property rather than a secret hiding place.

## 4. Separate control of evidence from control of release

The archive is more credible if Sylvan cannot unilaterally do everything with it. Separate permissions might govern:

- decrypting raw content;
- confirming that a record exists;
- identifying protected witnesses;
- publishing excerpts;
- releasing the whole collection;
- granting access to a tribunal;
- triggering contingency disclosure after disappearance or detention.

Threshold authorization—requiring several independent keys or agents—prevents both the Throne and Sylvan from seizing unilateral control. This also creates dramatic constraints. Sylvan may possess the truth but need cooperation from people with different risks, loyalties, or jurisdictions.

The audience that matters might refuse to authorize release until the chain of custody is independently checked. Conversely, broad release might endanger innocent people, reveal system capabilities, or contaminate later proceedings.

## 5. Why Sylvan cannot “just publish it”

Several obstacles can operate simultaneously:

### Audience fragmentation

Different groups inhabit different information environments. Publication to one network may not reach the faction whose allegiance sustains the Throne.

### Verification capacity

The public may lack the tools or authority to verify signatures rooted in hidden systems. Evidence that is technically strong can appear indistinguishable from fabrication.

### Source protection

Raw disclosure may identify custodians, children, coerced participants, or the other son. Protecting them requires redaction and staged access.

### Strategic ambiguity

Publishing everything at once teaches the Throne what Sylvan knows and removes the ability to test denials against withheld evidence.

### System constraints

Influence or authorization protocols may prevent mass disclosure without a threshold event, recognized proceeding, or multi-party approval.

### Credibility warfare

The Throne can flood the environment with forged files, contradictory interpretations, and claims that all media are compromised. The objective is not to refute every recording but to make certainty socially expensive.

## 6. Evidence should be redundant in kind

Audio alone is vulnerable to contextual attacks. The strongest archive triangulates:

- recordings of instructions;
- access and authorization logs;
- genealogical changes;
- resource transfers;
- testimony from participants with different incentives;
- Daemon/Lumina memory receipts;
- predictions made before later events;
- physical or biological consequences of breeding-program interference.

Each form answers a different denial. The audio shows intent; records show capability; outcomes show execution; independent commitments show the materials predate the confrontation.

## 7. A compelling discovery sequence

The archive can become convincing in stages:

1. A recording sounds authentic but is deniable.
2. A signed checkpoint proves it existed years earlier.
3. Access records place the speakers together.
4. A concealed genealogy matches the discussed intervention.
5. The Throne issues a specific denial.
6. Sylvan releases a withheld record that proves the denial was knowingly false.
7. Independent custodians verify that additional unreleased evidence remains.

The decisive moment is not the loudest recording. It is the moment the audience understands that the archive can predict and defeat the Throne's explanations.

## 8. Scene-level applications

- Sylvan publicly reveals only a hash and asks the Throne to commit to an explanation before opening the corresponding record.
- George's Daemon recognizes an old institutional signature but discovers it was deliberately excluded from George's memory index.
- One archive custodian hates Sylvan but validates the checkpoint because the verification process does not require trust in him.
- The Throne destroys a repository, only to reveal through that attack which evidence he fears.
- A derivative clip appears manipulated until Sylvan produces the raw source and complete transformation history.
- Full release would expose the other son's parentage, forcing Sylvan to choose between speed and treating him as a person rather than evidence.

## 9. Guardrails

- Cryptographic integrity does not prove interpretation or moral truth.
- Avoid a magical unhackable archive; use redundancy, detectable compromise, and divided trust.
- A “dead man's switch” should require careful conditions or it becomes an implausibly simple solution.
- Protecting witnesses can legitimately slow disclosure.
- The evidence should threaten Sylvan too if it records compromises, failures, or unauthorized methods.

## Creative decisions this research can unlock

1. Who or what performed the original capture?
2. Which evidence layer does the Throne successfully compromise?
3. Who holds the independent checkpoints?
4. Why is the decisive audience unreachable through ordinary publication?
5. What innocent person would be harmed by indiscriminate release?
6. What denial does Sylvan invite before revealing the record that defeats it?

## Sources

- C2PA, [Content Credentials Technical Specification](https://spec.c2pa.org/specifications/specifications/2.3/specs/_attachments/C2PA_Specification.pdf) (version 2.3).
- C2PA, [Content Credentials Explainer](https://spec.c2pa.org/specifications/specifications/2.3/explainer/Explainer.html).
- NIST, [Authentication for Confidentiality Modes](https://csrc.nist.gov/Projects/block-cipher-techniques/bcm/authentication-for-confidentiality-modes).
- NIST SP 800-171r3, [Audit and Accountability](https://nvlpubs.nist.gov/nistpubs/SpecialPublications/800-171r3/NIST.SP.800-171r3.html).
- Certificate Transparency, [Logs](https://certificate.transparency.dev/logs/).
- Trillian, [Verifiable Data Structures](https://transparency.dev/verifiable-data-structures/).
- NIST, [Blockchain Technology Overview](https://www.nist.gov/blockchain).

## Bottom line for *Seeds of the Throne*

Sylvan's archive should be hard to destroy because its trust is distributed, not because one device is invulnerable. Its power comes from forcing the Throne to fight several independent forms of evidence while every new denial becomes another test the archive can answer.
