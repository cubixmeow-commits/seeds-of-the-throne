---
type: implementation-verification
status: pass-with-stated-limits
updated: 2026-09-06
---

# Website verification

## Passed

- Python builder and generated-output hashes; eight rebuilt atlas pages, workshop page, twenty complete module packets, local workflow snapshots and shared data.
- Local HTML links, assets, fragments, duplicate IDs, and one primary page heading in static routes.
- Every workshop module has all required sections, three to five alternatives (four each), valid source links, and valid prerequisites.
- Curated content checks for the corrected premise and unapproved mechanics.
- JavaScript syntax for all docs scripts; PHP 8.2 syntax for Explorer, workbench and renderer.
- PHP HTTP responses for overview, source, evidence and workshop views, search, and source-document rendering; invalid traversal rejected with 404.
- Chromium browser checks for twelve docs routes and four Explorer views at 320px and 1440px, thirty-two route/viewport combinations, with no remaining horizontal page overflow and no JavaScript exceptions.
- Mobile menu open/close and Escape behavior; module switching; draft save/reload; exact Markdown export and import; source-packet disclosure; search; traversal rejection; explicit warning when browser storage fails.
- Representative desktop and mobile renders inspected: atlas homepage, workshop page, Explorer hero, development workbench, and selected session.
- Git whitespace checks. Browser test drafts and temporary runtimes remain outside the repository.

## Fixed during verification

The workshop index duplicated the page heading; generated packet headings now sit below the page heading. Legacy Ideas and Visuals grids exceeded 320px through intrinsic sizing; their small-screen columns and text now shrink correctly. The workshop presents the selected question before the long module catalogue.

## Limits

This is Chromium desktop emulation, not a test on an actual iPhone or Safari. Semantic structure, labels, focus, keyboard menu behavior, and reflow were checked; no full assistive-technology conformance audit was performed. External sites and every older research reference were not exhaustively revalidated. The science brief remains preliminary, with checked and unchecked claims recorded separately. Hosting deployment and the author's Mac worktree were not inspected or changed.

Run instructions: [[scripts/README]]. Deployment handoff: [[07 Coordination/2026-09-05 - Website Rebuild Handoff]].
