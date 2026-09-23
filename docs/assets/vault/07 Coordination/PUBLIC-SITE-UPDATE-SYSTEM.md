---
type: coordination-system
status: active
updated: 2026-09-21
scope: story atlas and Project Explorer
---

# Public Site Update System

This contract keeps the Story atlas and Project Explorer current after desktop assessments. It does not publish every vault change automatically. The author still controls canon, spoilers, privacy, and public wording.

## Source hierarchy

1. Latest explicit author decision.
2. `07 QA/Decisions.md` and the latest relevant QA audit.
3. `03 Context/CURRENT.md` and `03 Context/OPEN-QUESTIONS.md`.
4. Status-labeled compiled notes in `02 Story/`.
5. Dated sessions in `01 Sessions/Daily/`.
6. Advisory research.

The public site never outranks these sources.

## Projection decision

For every accepted desktop assessment, classify each material change:

| Class | Destination | Rule |
| --- | --- | --- |
| Public story | `05 Public/Atlas/` and generated `docs/` | Fictional, approved, understandable, and useful to readers. |
| Public spoiler | Spoiler sections in `05 Public/Atlas/` | Approved but reveal-sensitive; label it clearly. |
| Explorer only | Project Explorer current-state, decisions, or workshop views | Useful for understanding development but not needed in the reader-facing story. |
| Private | No public projection | Sensitive, unsafe out of context, unapproved, or too mechanically unresolved. |

If a change affects no public page, record “no public projection” in the assessment or session note so omission is deliberate.

## Update matrix

| Change type | Story atlas source | Project Explorer | Other required update |
| --- | --- | --- | --- |
| Premise or world rule | `index.md`, `colonization.md`, or `ai.md` | Story and Decisions views | Page-map and canon check if route scope changes. |
| Character role or choice | `characters.md`, plus `timeline.md` when ordered | Story and Decisions views | Current context and compiled character note first. |
| Antagonist system or evidence | `faction.md`, `archive.md`, or `timeline.md` | Decisions and Workshop views | Preserve privacy and evidence ownership. |
| Workshop or assessment state | `archive.md` and generated Workshop/Progress pages | Overview, Workshop, Progress, Vault links | `DYNAMIC-WORKSHOP.md`, `CURRENT.md`, weekly pointer, and `CURRENT-PICKUP.md`. |
| Approved visual | Relevant page source or builder composition | Story view and Visuals when useful | Approved source, public derivative, registry, provenance, and alt text. |
| Research boundary | `research.md` | Decisions view | Cite primary sources and keep research noncanonical. |

## Project Explorer overview hierarchy

The Project Explorer overview must orient a first-time visitor to the whole current project before emphasizing the newest decision. Its current-project summary should cover, in compact form:

1. the premise and world;
2. the human and Luminai future;
3. the central conflict;
4. the current endgame;
5. the Resistance or other major active story forces;
6. what is established and what is being developed next.

A new assessment may update one or more of these areas, but one focused discovery must not replace the overall summary. Focused details belong inside the relevant summary area, the Decisions view, the Dynamic Story Workshop, or the latest-assessment section.

## Desktop assessment checklist

1. Sync and confirm a clean base.
2. Record the dated session before promoting story decisions.
3. Update compiled story notes, context, decisions, contradictions, and open questions.
4. Update `DYNAMIC-WORKSHOP.md`, including its Change Log and Next Assessment Pass.
5. Complete the projection decision table for material changes.
6. Edit reviewed sources in `05 Public/Atlas/`; never hand-edit generated HTML or JSON.
7. Update Project Explorer current-state copy and links when the workflow, latest assessment, or active workshop changes. Preserve the overall-summary hierarchy and place focused decisions inside the relevant area.
8. Run `python3 scripts/build_story_sites.py`.
9. Run `python3 scripts/check_story_sites.py` and `python3 scripts/test_workshop_contract.py`.
10. Check JavaScript and PHP syntax.
11. Run the responsive browser suite and inspect changed pages at 320, 430, 768, 1024, and 1440 pixels.
12. Confirm no stale active-workshop language, obsolete terminology, broken links, missing assets, accidental private material, or em dashes entered public files.
13. Commit reviewed sources, code, generated projections, QA evidence, and workflow notes together.
14. Push only after all checks pass and publication is authorized.

## Live and historical workshop rule

`07 Coordination/Story Completion Workflow/DYNAMIC-WORKSHOP.md` is the only live workshop source. The builder publishes it as one current assessment module and updates that module after every desktop assessment.

BA, EG, RW, Reveal Chain, and the earlier twenty-part workshop remain available as historical sources. The public interface may link to them as development history, but it must not present them as parallel active tracks.

## Failure behavior

The build must fail when:

- the dynamic workshop lacks any required section;
- its Next Assessment Pass has no single quoted gate;
- generated workshop content differs from the source;
- a reviewed source link is broken;
- a generated asset is stale;
- required current-canon markers disappear;
- the live UI again describes a deprecated workshop as active.

## Ownership boundary

The builder automates projection and drift detection. It does not decide what is canon, what should be public, how spoilers should be framed, or whether a visual interpretation establishes a story fact.
