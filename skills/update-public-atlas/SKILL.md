---
name: update-public-atlas
description: Convert approved Seeds of the Throne vault developments into accurate, modular updates to the static public story atlas in docs/. Use when adding or revising public pages, diagrams, dossiers, timelines, development status, navigation, styling, accessibility, local testing, or GitHub Pages publication.
---

# Update the Public Atlas

## Select public material

Read `03 Context/CURRENT.md`, `03 Context/RULES.md`, `05 Public/README.md`, the relevant compiled notes, and the session that produced the update. Inspect the current `docs/` site before editing.

Publish only material that is fictional, safe out of context, useful to the public experience, and approved or already represented publicly. Keep established, working, and unresolved material visibly distinct.

Use `references/page-map.md` to choose the smallest appropriate page update.

## Design the update

1. Identify the visitor question the update answers.
2. Choose the smallest modular page or diagram that can answer it.
3. Preserve the atlas's current dark visual language: near-black surfaces, antique gold for reality and evidence, red for coercion and corruption, and green for constructive development.
4. Keep in-world truth separate from public mythology, sealed evidence, and author development.
5. Write concise, navigable copy. Do not use em dashes.
6. Preserve semantic HTML, keyboard operation, visible focus, reduced-motion support, readable contrast, and 320-pixel reflow.

## Verify

Before publishing:

- check all local links and assets;
- check JavaScript syntax and whitespace errors;
- search public files for outdated canonical terms and em dashes;
- load every changed route locally;
- test interactive states with keyboard-capable controls;
- test desktop and 320-pixel layouts for horizontal overflow;
- review the rendered result, not only source code;
- confirm the git diff contains only intended files.

## Publish

Commit the intentional `docs/` scope with a descriptive message and push the current branch only when the user has authorized publication. Verify that GitHub Pages serves a unique marker from the new build. Archive public copy in `05 Public/Published/` when the project workflow requires an exact publication record.

## Guardrails

- Do not expose private analogies, credentials, unsafe transcripts, or unapproved twists.
- Do not present research as canon.
- Do not erase status labels to make the site sound more certain.
- Do not redesign unrelated pages during a content update unless requested.
- Do not publish before local visual and interaction checks pass.
