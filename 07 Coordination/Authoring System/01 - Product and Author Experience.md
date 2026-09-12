---
type: product-design
status: proposed
updated: 2026-09-12
---

# Product and Author Experience

## Initial user and job

The first user has vivid people, worlds, incidents, themes, fragments, recordings, or role-playing histories but may not know scene structure, continuity practice, manuscript planning, or line editing. Their job is not “learn to write professionally.” It is:

> Help me get the story out of my head, make it coherent without taking it away from me, and finish the book.

Seeds is the founder use case: a large, evolving story, limited author time, voice transcription errors, years of accumulated notes, and a strong need to preserve corrections and provenance.

## Author-attention budget

Every interaction should earn its cost. A question is worth asking when the answer changes several downstream decisions, prevents substantial rework, or requires uniquely human judgment. The system should batch clerical integration and validation instead of making the author watch files update after every answer.

Primary measures:

- accepted decisions per focused session;
- downstream story work unlocked per answer;
- author corrections required because the system misunderstood;
- unresolved load-bearing gaps remaining;
- scenes reaching author-approved manuscript state;
- minutes of author attention per approved scene or chapter;
- continuity defects found before and after drafting.

Completion percentages must be computed from explicit criteria, never improvised.

## One conversational front door

The author should not need to select a skill. The system identifies the smallest useful action and confirms the intended outcome when ambiguity matters.

Supported answer modes:

1. **I know:** accept a free spoken or written answer.
2. **Help me decide:** compare meaningfully different choices and consequences.
3. **Inspire me:** generate candidates grounded in approved story state.
4. **Decide provisionally:** let the system recommend a reversible working answer, clearly labeled proposed.
5. **Not yet:** defer without losing the question or its dependencies.
6. **That question is wrong:** revise the system's model rather than forcing an answer.

## Session loop

1. **Resume:** say what changed, what is stable, and the single most valuable next decision.
2. **Ask:** present one plain-language gate with just enough context.
3. **Listen:** preserve the raw answer; normalize obvious transcription only when unambiguous.
4. **Reflect:** restate the answer, consequences, and remaining uncertainty.
5. **Confirm:** author accepts, corrects, rejects, or defers.
6. **Integrate silently in batch:** update decision state, affected records, tests, and projections.
7. **Show progress:** explain what the answer unlocked in story terms.
8. **Continue or stop safely:** persist an exact pickup state.

The author sees no repository ceremony unless they ask for it or a conflict requires intervention.

## Progressive disclosure

Mobile/default view:

- one question;
- a short reason it matters;
- optional choices;
- answer and confirmation;
- immediate story consequence.

Desktop/deep view:

- sources and authority;
- conflicting notes;
- dependency and blast-radius map;
- alternatives and tradeoffs;
- test scene;
- continuity and research concerns;
- exact affected artifacts.

## Trust contract

The system must always reveal:

- whether it is quoting a source, interpreting it, or inventing a candidate;
- whether an answer is captured, proposed, accepted, disputed, deferred, rejected, or superseded;
- what changed because of an accepted decision;
- what remains uncertain;
- where the durable copy lives;
- whether a save, export, validation, or synchronization actually succeeded.

## Voice learning

Voice is learned from positive examples, corrections, dislikes, and explicit rules. A detected preference becomes a proposed style rule; it is not silently promoted. Character voice, narrator voice, project prose style, and public-development style remain separate.

**Voice Key extends beyond surface voice.** Its primary job is to learn how the user selects and presents information: attention, causality, evidence, judgment, ambiguity, surprise, emotional distance, compression, correction, and closure. Natural transcripts supply evidence, but finished prose should not inherit raw speech merely to resemble the user. Creative-choice exercises and reactions to project passages provide stronger calibration than verbal mannerisms alone.

The system should use Voice Key to choose among several structurally valid presentation decisions before prose rendering. It may change information order, emphasis, explanation, focal detail, recognition timing, and degree of closure while remaining inside the scene contract. See [[06 - Voice Key]].

The system must detect both:

- **prose residue:** generic phrasing, repetitive cadence, over-signposting, synthetic symmetry;
- **narrative residue:** overly tidy causality, premature moral resolution, uniform competence, reduced ambiguity, and plots shaped by what is easy for a model to generate.

## Safety and ownership

- private drafts stay private unless deliberately published;
- export is complete and usable without the system;
- facts and consent require stronger controls for memoir/nonfiction later;
- living-author style requests are translated into general qualities rather than imitation;
- harmful faction beliefs remain attributed to the faction, not normalized by the system;
- model and provider should be replaceable; the vault must not depend on one vendor.
