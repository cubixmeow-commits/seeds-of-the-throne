# Story website projections

The public atlas sources are reviewed Markdown in `05 Public/Atlas/`. Canon remains in `02 Story/`; each public page links the notes from which its copy was selected. Canonical changes still require editorial review before changing public copy. The builder prevents drift between a reviewed source and its generated views; it does not decide canon.

The active workshop source of truth is `07 Coordination/Story Completion Workflow/Book One Architecture Workshop/`. The builder and checker share `scripts/workshop_contract.py`, which requires the unique sequential set BA-01 through BA-10. Prerequisite values must be `none`, the named accepted-ending label, a required module ID, a comma-separated list of IDs, or a supported ID range. Unknown or malformed values fail. The completed reassessment and retired twenty-module workshop remain historical and are not the active validation contract.

Run from the repository root:

```sh
python3 scripts/build_story_sites.py
python3 scripts/check_story_sites.py
python3 scripts/test_workshop_contract.py
git diff --check
```

Python's standard library is sufficient. Commit generated output with the sources so both GitHub Pages and shared PHP hosting need no build service or package manager. Do not hand-edit generated pages, JSON, workflow snapshots, or workshop downloads.

The builder creates eight atlas pages, the workshop page, shared JSON for the Explorer, Markdown downloads, and local snapshots of existing workflow pointers and their targets. `docs/todo.html`, `ideas.html`, and `visuals.html` retain their original interactions; their scripts now read the bundled workflow snapshot. Changes to pointer targets need a rebuild.

The Explorer keeps the existing PHP Markdown browser, search, request allowlist, and portfolio styling. Its new workbench reads the same generated JSON as the atlas. Both must be deployed from the same repository revision.

## Public voice separation

The two sites share sources but do not speak to the same audience in the same way:

- `docs/` presents the story. Lead with the world, danger, mystery, characters, and consequences.
- Project Explorer presents the system that helps an author turn conversation into decisions, scenes, and finished prose.

Primary copy should be simple enough to understand on the first reading. The opening must tell a new visitor what the story, Project Explorer, or workshop actually is before trying to create mystery or excitement. Keep repository, provenance, and workflow terms in deeper development views instead of using them as the main pitch. Rebuild generated pages after changing any Atlas source or shared template.

The complete copy contract and approved examples are in `skills/update-public-atlas/references/public-writing-style.md`. A visual-only redesign must preserve approved copy unless the author separately authorizes a rewrite.

## Browser verification

Playwright and a Chromium executable are development-only test prerequisites; they are not website dependencies. Start PHP 8.2 at the repository root, then run:

```sh
php -S 127.0.0.1:8766 -t .
```

In another terminal:

```sh
node scripts/test_story_browser.cjs
```

Optional variables: `SEEDS_TEST_URL`, `SEEDS_TEST_OUTPUT`, and `SEEDS_CHROMIUM` for a compatible custom executable. Screenshots and results default to a temporary folder outside the repository. Never commit test draft answers.

## Draft persistence

The browser editor saves only to that origin's local storage, with an in-page fallback when storage fails. It provides Markdown export and import. It does not write to the vault, synchronize devices, invoke AI, or approve decisions. The author must review and accept an exported answer before integrating it through the existing workflow.

## Deployment layout

GitHub Pages serves `docs/`. Shared hosting uses `.cpanel.yml` to archive the full committed repository under the existing deployment root. Do not upload only `project-explorer/`: it needs the portfolio includes, vault Markdown, and `docs/assets/story-*.json` plus `docs/workshop.js` and styles.
