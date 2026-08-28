# Desktop Handoff — Weekly TODO Dashboard

Date: 2026-08-24

## Goal

Build a GitHub Pages dashboard for the current weekly story-completion TODO so the public repository site shows live progress as tasks are completed.

## Core rule

The Markdown weekly TODO remains the source of truth. Do **not** manually maintain a second independent checklist in the website.

Current source:

`07 Coordination/Weekly Synthesis/Runs/2026-08-23/12 Weekly Story Completion Todo.md`

## Dashboard plan

- Create `docs/todo.html` as the weekly development dashboard.
- Add a `Weekly TODO` link to the main navigation on the GitHub Pages site.
- Have the page read/parse the current Markdown checklist from the repository rather than duplicate its content.
- Display overall progress, for example `12 / 27 complete` and a completion percentage.
- Group work into clear visual sections such as `Now`, `Next`, and `Later`, or mirror the story-completion stages from the source TODO.
- Show progress for each major story-completion stage.
- Keep completed items visible and visually marked so the page becomes a record of progress rather than hiding finished work.
- When tasks are checked off in the vault and pushed to GitHub, the dashboard should update from the Markdown source.
- When a new weekly synthesis is generated, update the dashboard to point at the newest weekly completion TODO rather than rebuilding the page from scratch.

## Purpose

This should support the build-in-public side of Seeds of the Throne by letting visitors watch the project move from story architecture and worldbuilding toward a finished narrative, task by task.

The technical development process should remain secondary to the story itself, but this page can demonstrate the depth and discipline behind the project.

## Tonight

1. Sync the local vault/repository first.
2. Re-read the current weekly synthesis and `12 Weekly Story Completion Todo.md`.
3. Reference the ChatGPT conversation from August 24, 2026 where this dashboard idea was discussed.
4. Build `docs/todo.html` using the current site's visual language.
5. Add the navigation link across the relevant Pages documents.
6. Test automatic progress calculation from Markdown checkbox state.
7. Verify the GitHub Pages deployment after commit/push.

## Important design constraint

Avoid turning this into another technical assessment page. The dashboard should feel like a visible story-development roadmap: what is being solved, what it unlocks, and how close the project is to moving into sequence and scene construction.
