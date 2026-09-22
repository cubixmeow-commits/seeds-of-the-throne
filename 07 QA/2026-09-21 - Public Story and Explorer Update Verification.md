---
type: qa-report
status: complete-with-limitation
date: 2026-09-21
scope: public-story-site-project-explorer
---

# Public Story and Explorer Update Verification

## Verdict

The Story pages and Project Explorer now project the 2026-09-21 canon state from one current Dynamic Story Workshop. The Resistance identity, duplicated-throne endgame con, superweapon failure, bloodline betrayal, and escape reversal are visible in the appropriate public surfaces. Older Book One and Endgame workshop packets remain accessible as historical development records rather than competing current workflows.

## Source and build verification

- Dynamic workshop contract tests: passed, 14 tests.
- Story-site build: passed, producing 8 Atlas pages, 1 live Dynamic module, 22 historical workshop modules, and 73 tracked projections.
- Story-site consistency checker: passed for local links, assets, anchors, generated hashes, dynamic workshop source agreement, and curated canon markers.
- JavaScript syntax checks: passed for the public workshop and Project Explorer.
- PHP syntax checks: passed for the Project Explorer index, workbench, and vault overview.
- Whitespace and patch integrity check: passed.

## Visual review

The following local routes were inspected in the available in-app browser at approximately 590 pixels wide:

- Story home: current Resistance infographic, ark explanation, endgame framing, and Dynamic Story Workshop entry point rendered without visible horizontal overflow.
- Dynamic Story Workshop: DW-01 loaded as the only live assessment, with the current gate, source context, response area, and export controls readable at the inspected width.
- Project Explorer workshop view: the Dynamic workshop, latest canon feature, Resistance image, updated vault links, and current assessment language all rendered coherently.

The automated multi-viewport browser suite could not run because the repository does not currently provide its Playwright dependency. No dependency was installed during this content update. Full automated captures at 320, 430, 1024, and 1440 pixels therefore remain a known verification gap; the direct responsive browser review and source-level checks passed.

## Projection decisions

- The Resistance's black-and-orange ark identity is suitable for the public story site because it expresses sanctuary, testimony, and cultural preservation without disclosing private process notes.
- The duplicated promise to George White and Aiden Fitzgerald is treated as spoiler-visible endgame canon.
- The apparent superweapon's dependence on Sylvan's disadvantage, its failure during public exposure, and the bloodline betrayal are treated as spoiler-visible endgame canon.
- The Dynamic Story Workshop and update system are development-process material and are visible in Project Explorer and the public development pages.

## Files governing the next update

- `07 Coordination/Story Completion Workflow/DYNAMIC-WORKSHOP.md` is the only live workshop.
- `07 Coordination/PUBLIC-SITE-UPDATE-SYSTEM.md` defines the repeatable assessment-to-publication process.
- `scripts/build_story_sites.py` creates the public projections.
- `scripts/check_story_sites.py` checks drift, links, assets, and required canon markers.

## Project Explorer summary follow-up

After review, the focused “one con, two promises” feature was identified as too narrow to represent the current project. The Explorer overview now places a project-wide current-state summary before the authoring-system explanation. It covers the world, the human and Luminai future, the central conflict, the current endgame, the Resistance, and the next development work. The duplicated promise remains visible as one part of the endgame rather than standing in for the entire project.

The revised summary was visually and structurally checked at 320, 375, 430, 768, 1024, and 1440 CSS pixels. The page and body widths matched every viewport, the summary changed from one column to two only when space allowed, and all summary links remained inside the viewport. The 320-pixel rendered review showed clear reading order and no visible horizontal overflow.
