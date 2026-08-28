---
type: development-session
status: completed
date: 2026-08-26
topics: docs website, creative possibilities, research queue, author review
---

# Experimental Ideas Docs Interface

## Result

Added a live Experimental Ideas workspace to the docs website at `docs/ideas.html`.

The page reads [[08 Story Loop/Brainstorms/CURRENT-EXPERIMENTAL-IDEAS|a stable current pointer]] and renders the active creative-possibilities packet without creating a separate database or authority source.

## Interface behavior

- shows live idea, unreviewed, and research-prompt totals;
- lists every non-canon possibility with filters for author-review status;
- opens a detailed view containing source foundations, story function, character choice, dramatic expression, continuity risk, and next gate;
- displays the research mechanisms that inspired the pass;
- displays suggested research as live Markdown checklist items and identifies the ideas each question supports;
- links directly to the current packet and governing protocol;
- keeps non-canon authority visible throughout.

## Update contract

- Change idea status in the packet's `Author review board`.
- Check off completed research in `Suggested research queue`.
- Edit or add candidates in `Raw candidate portfolio`.
- Point `CURRENT-EXPERIMENTAL-IDEAS.md` to a new packet when the active window changes.

The website is read-only. It reflects author decisions recorded in the vault but cannot make them.

## Verification

- parser assertions: 10 ideas, 5 research inputs, 5 suggested research items;
- desktop visual review completed;
- mobile review completed at 390 × 844 with no horizontal overflow;
- idea selection and empty-filter recovery verified;
- no browser console errors;
- native buttons, status text, live announcements, focus styling, reduced-motion rules, and responsive reflow preserved.
