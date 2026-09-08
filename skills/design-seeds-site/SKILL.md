---
name: design-seeds-site
description: Design, prototype, implement, or visually review responsive Seeds of the Throne story-atlas and Project Explorer interfaces. Use for visual identity, layout, components, responsive behavior, or coded design work; not for copy-only edits or story-canon development.
---

# Design Seeds Site

## Objective

Produce a distinctive, usable interface by designing in responsive code and reviewing the rendered result. A written design brief or generated image is not an approved design.

## Required context

Before changing an interface, read:

1. `AGENTS.md`
2. `03 Context/CURRENT.md`
3. the active website handoff in `07 Coordination/`
4. [visual-identity-boundaries.md](references/visual-identity-boundaries.md)

Read [coded-prototype-workflow.md](references/coded-prototype-workflow.md) when creating a new direction or substantially redesigning a page. Read [visual-qa.md](references/visual-qa.md) before declaring a prototype or implementation ready.

## Choose the operating mode

- **Prototype:** Build isolated, working alternatives with real content. Do not edit production templates.
- **Production:** Apply only an author-approved coded prototype to the live surfaces.
- **Review:** Inspect rendered pages at target widths and diagnose specific visual or interaction failures.

If no coded prototype has been approved, use Prototype mode. Do not skip directly from prose or an image mockup to Production mode.

## Design requirements

- Start with hierarchy, composition, rhythm, and interaction—not palette substitution.
- Use real public copy, representative navigation, and actual assets so the prototype exposes genuine layout pressure.
- Make mobile a designed composition, not a collapsed desktop layout.
- Treat the story atlas and Project Explorer as related but different products.
- Integrate imagery into the composition. A rectangular image placed after a completed text block is not a hero design.
- Use semantic tokens and a limited component vocabulary after the visual direction is established.
- Preserve content authority, accessibility, navigation truth, and repaired functionality.
- Use design-reference tools or UI libraries for critique and option discovery, never as an automatic style generator.

## Approval gate

The author must review the working coded prototype before production implementation. Approval applies to the rendered direction, not merely its name or palette.

Until approval:

- keep prototype assets isolated;
- do not import prototype CSS into production;
- do not replace the live site;
- do not merge or deploy unless explicitly requested.

## Output standard

A substantial redesign produces:

1. working responsive prototype routes;
2. a small prototype index explaining the alternatives without bias;
3. actual mobile navigation and representative interactions;
4. screenshots at the required review widths;
5. a visual QA report with failures and tradeoffs;
6. a concise inventory of tokens and reusable components;
7. a focused review PR that does not alter production pages.

## Guardrails

- Do not establish story canon through interface imagery or labels.
- Do not invent public story copy to make a layout easier.
- Do not copy the rejected black-and-yellow archive treatment.
- Do not use generic dashboard cards, terminal styling, spaceship HUD decoration, or empty cinematic slogans as substitutes for design.
- Do not declare success from automated checks alone. Inspect the rendered result.
- Preserve the existing mobile menu, distinct destinations, Workshop behavior, archive browser, theme state, and accessibility when later entering Production mode.
