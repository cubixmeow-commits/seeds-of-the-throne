---
type: session
status: established
date: 2026-09-07
topic: conversational authorship product direction
authority: direct author decision
scope: vault functionality and future authoring product
---

# Conversational Authorship Product Direction

## Founder motivation

The immediate reason for building this system is practical and personal: the author wants to finish *Seeds of the Throne* but does not have time to manually perform all of the writing required to turn the developed story into finished books.

The system therefore must solve a real completion problem, not merely demonstrate interesting AI-assisted brainstorming. It should let the author supply the story, corrections, taste, intent, and consequential decisions while the system performs much of the time-intensive organization, dependency analysis, scene planning, drafting, continuity checking, revision, manuscript assembly, and project maintenance.

This founder problem is also the broader market hypothesis: many people have stories worth telling and can recognize, guide, and approve the story they want, but lack the time, craft experience, sustained attention, or production capacity to create a finished book manually.

## Author-established direction

The vault's authoring functionality is now being developed primarily for **story-rich, craft-light creators**: people who have interesting stories, memories, characters, knowledge, or imagined worlds but do not have the extensive writing capability, craft vocabulary, organization, or endurance required to turn that material into a finished book by themselves.

The product ambition is to do for writing what vibe coding did for software development. A person should be able to explain what they want in ordinary language, inspect understandable results, answer focused questions, make meaningful choices, and guide successive improvements without first mastering the professional techniques operating underneath the experience.

This direction extends all the way to finished prose. The system is not limited to producing a story bible, outline, workshop, or disposable prototype. It should be capable of helping the author move from raw spoken or written material through story development, structure, scene planning, drafting, revision, continuity review, and export of a completed manuscript.

## Public-facing market definition

Do not describe the audience as people who “cannot write.” The public framing is:

> You already have the story. We help you discover it, develop it, and turn it into a finished book.

The initial recommended beachhead is imaginative non-writers creating fiction: people with developed characters, worlds, role-playing histories, voice notes, fragments, or unfinished stories who need a reliable completion process. Memoir and family history remain a strong later mode that will require stricter factual provenance, memory-uncertainty, consent, and privacy rules.

The market size remains a research question. Do not repeat old claims about the percentage of people who want to write a book as verified market evidence without tracing and evaluating the original research.

## Product promise

> Tell us the story the way you naturally tell it. The system will help you discover what it is, ask what only you can answer, and build it into finished prose without taking the story away from you.

The system supplies craft knowledge, organization, diagnosis, questions, alternatives, causal analysis, continuity, drafting, revision, and production discipline. The author retains meaning, lived experience, taste, moral judgment, consequential creative decisions, corrections, and final approval.

The system should optimize for **finished, author-approved work**, not maximum author labor. Learning writing craft may be a welcome result, but it is not a prerequisite for completion and should not become an obstacle placed between the author and the book.

## Required interaction model

1. Begin with conversation, voice, notes, transcripts, images, research, or an unfinished manuscript rather than a blank manuscript page.
2. Reflect back what the system heard before making load-bearing interpretations.
3. Separate the author's source material from the system's understanding and from proposed story uses.
4. Determine the highest-leverage missing decision and ask one ordinary-language author-gate question at a time.
5. Let the author answer freely, request help deciding, request inspiration, defer the question, or reject the premise of the question.
6. Explain progress through concrete story results rather than invented completion percentages.
7. Require an understandable scene contract before generating load-bearing prose.
8. Learn voice through samples, choices, corrections, approved examples, and negative preferences without imitating a named living author.
9. Generate and revise prose in controlled sections while preserving character knowledge, chronology, revelation order, and author authority.
10. Carry the work through structural revision, continuity, prose refinement, readiness review, manuscript assembly, and export.

## Information boundary

Every captured idea should preserve three distinct layers:

| Layer | Meaning |
|---|---|
| Source | What the author actually said, wrote, recorded, or uploaded |
| Understanding | What the system believes that source establishes |
| Story use | A proposed narrative function or creative development based on it |

The system may not silently collapse an interpretation or proposed story use into an author-established fact.

## Author control modes

For a focused question, support at least these responses:

- **I know** — capture the author's answer.
- **Help me decide** — offer meaningfully different possibilities and their consequences.
- **Give me inspiration** — generate possibilities without accepting any of them.
- **Not yet** — preserve the unresolved decision and continue where dependencies permit.
- **That question is wrong** — correct the system's model before proceeding.

## Functional architecture

### Story Workshop Engine

The Workshop Engine retrieves the relevant project state, diagnoses what is missing, ranks dependencies, asks one author-gate question at a time, preserves exact answers and corrections, and propagates only accepted decisions. It should adapt to the particular story instead of imposing a universal framework.

### Story Composition Engine

The Composition Engine converts approved story structure into finished prose through bounded context packets, scene contracts, drafting, developmental revision, continuity checks, voice control, narrative-residue checks, line editing, manuscript assembly, and export. Prose may reveal a missing structural decision, but it may not silently settle that decision; the question returns to the Workshop Engine.

### Shared foundation

Both engines depend on:

- explicit authority order;
- durable status and provenance;
- stable entity identifiers;
- chronology separated from revelation order;
- character knowledge, relationship, object, promise, and payoff state;
- accepted, proposed, rejected, deferred, disputed, and superseded decisions;
- exact pickup and resumption state;
- deterministic checks where correctness can be encoded;
- portable, versioned source files;
- clear public versus private/development visibility;
- inspectable records of author choices and AI contributions.

## Vault implication

The current Seeds vault becomes both a working story-development environment and the proving ground for a reusable conversational authorship system. The Project Explorer should eventually demonstrate how the authoring system works; the docs site should present the resulting story to readers.

Seeds remains development-first at its current story stage. This decision establishes the full destination of the system; it does not authorize premature chapter generation, install external skills, settle unresolved story facts, or make untested interface mechanics final.

## Research and design still open

- Validate the initial fiction beachhead and later memoir mode through user research.
- Complete the open-source skill, author-problem, competitive-workflow, and requirements audits.
- Determine the smallest onboarding session that produces an immediately valuable result.
- Design the question-priority and dependency-scoring method.
- Define scene-contract and authorship/provenance schemas.
- Determine how voice calibration works for users with little or no finished prose.
- Define privacy, consent, disclosure, export, and deletion behavior.
- Test the complete vertical slice: intake → author gate → accepted decision → propagation → scene contract → prose → continuity → proposed updates.

## Superseded assumption

Any earlier workflow wording that treats AI as permanently limited to skeletons, disposable prototypes, or support while requiring all final fiction prose to be written manually by the author is superseded as a **product boundary**. AI-assisted finished prose is now within scope. Author authority, approval, provenance, and the current development-first sequencing remain mandatory.
