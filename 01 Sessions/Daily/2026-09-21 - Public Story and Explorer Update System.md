---
type: development-session
status: active
date: 2026-09-21
topics: public story atlas, Project Explorer, projection workflow, update consistency
---

# Public Story and Explorer Update System

## Question explored

How should accepted story and workflow changes reach the public story pages and Project Explorer consistently without turning every vault edit into an automatic publication?

## Existing constraints

- `02 Story/` and `03 Context/` remain story authority; generated pages cannot establish canon.
- Public copy must be reviewed, fictional, safe out of context, and clear to first-time visitors.
- The Story atlas and Project Explorer share sources but serve different audiences.
- Generated HTML, JSON, and snapshots must not be edited by hand.
- The approved Pale Signal design remains the production baseline.

## Author decision

Create a repeatable public-projection system and use it now to bring both sites current. The process should become part of every desktop assessment instead of relying on occasional manual reconciliation.

## Current working direction

Use four explicit layers:

1. **Canon integration:** record accepted decisions in sessions, compiled notes, context, and QA.
2. **Projection assessment:** classify each accepted change as public now, public with spoiler framing, Project Explorer only, or private.
3. **Reviewed sources:** update the smallest relevant files in `05 Public/Atlas/` and the Explorer's current-state links and descriptions.
4. **Generated verification:** rebuild both projections, run structural and browser checks, inspect mobile and desktop renders, then commit source and generated output together.

The canonical dynamic workshop becomes the live workshop on both sites. BA, EG, RW, Reveal Chain, and the earlier twenty-part workshop remain historical downloads and source records.

## Vault impact

- Add a durable site-update contract under `07 Coordination/`.
- Update public atlas sources for the Resistance, duplicated godhood con, false superweapon, bloodline betrayal, and dynamic workshop.
- Update Project Explorer's workshop, assessment, overview, and current-state links.
- Extend the builder and checker so the live workshop is generated from `DYNAMIC-WORKSHOP.md`.
- Update `CURRENT-PICKUP.md` so the resume point no longer routes to BA-01.
