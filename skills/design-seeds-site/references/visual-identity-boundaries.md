# Seeds website visual identity boundaries

## Approved Version 1 baseline — September 9, 2026

**Pale Signal is the author-approved Version 1 production design for the Story atlas and Project Explorer.** The author reviewed and approved the deployed result on both mobile and desktop. This approval covers the complete rendered system—not just its palette—including its hierarchy, composition, typography, imagery, responsive behavior, navigation clarity, and readable public voice.

Future pages and features must extend this production baseline unless the author explicitly opens a new coded-prototype redesign cycle. Do not treat a new feature as permission to restyle the site.

The earlier black-and-yellow treatment remains rejected. It was functional but did not have an acceptable visual identity.

Do not use black as the dominant page field; yellow, mustard, antique gold, or amber as the primary accent; large filled yellow calls to action; sepia archive styling; a conventional historical serif as the entire personality; repeated thin bordered rectangles as the main layout language; artwork inserted as a poster after a completed text block; tables or card grids as the default visual solution; or decorative circuitry and HUD ornaments without functional meaning.

The earlier Hidden Planetary Infrastructure decision remains useful as story structure: ordinary surface life above concealed systems. Its deployed palette and archive treatment are not approved references.

## Qualities to express

- A real, inhabited civilization with human stakes.
- Advanced planetary systems that are concealed, distributed, and consequential.
- Discovery through conflicting evidence and changing interpretation.
- A contrast between coercive control and accountable human–Luminai judgment.
- A story in active development without resembling project-management software.

## Unselected prototype — Planetary Dusk

Planetary Dusk remains design-lab reference material, not a production direction. Do not blend it into Version 1 without a new author-approved prototype cycle.

Its explored language was atmospheric, spatial science fiction without dark-fantasy styling: deep desaturated navy, storm slate, mineral cyan or blue-green, frost text, and restrained signal red. Use layered depth, planetary curves, translucent fields, asymmetric editorial composition, and imagery that bleeds, masks, crops, or transitions into the page.

Reference roles from the approved implementation:

```css
--atmosphere-deep: #0b1724;
--atmosphere: #142738;
--surface: #1c3446;
--luminai: #67c7d8;
--signal: #7ca9d8;
--containment: #c65d68;
--text: #e7eef2;
--text-muted: #9baeb9;
```

## Selected production direction — Pale Signal

The approved identity presents a future civilization examining its own history rather than an old archive: mineral gray-blue or fog-white fields, deep blue ink, sea-glass green or clear cyan, and muted coral/red contradiction signals. Dark sections reveal concealed systems instead of covering the page. Use strong whitespace, asymmetry, precise modern typography, cropped image fragments, overlays, annotations, and revealed layers.

Starting roles, subject to rendered review:

```css
--field: #dbe4e7;
--field-raised: #eef2f2;
--ink: #132734;
--ink-muted: #526b76;
--system: #258b95;
--signal: #447fa6;
--containment: #b95663;
--concealed: #14232d;
```

## Product distinction

The story atlas may use expressive scale, image transitions, and paced revelation. Project Explorer uses the same identity with tighter density, clearer controls, and less spectacle. It must not become a separate generic dashboard theme.

## Version 1 extension rules

- Begin with the existing production tokens, typography, navigation, spacing logic, image treatment, and responsive primitives.
- Preserve the light mineral field, deep blue ink, sea-glass/cyan system language, restrained coral contradiction signals, and dark concealed-system sections.
- Preserve the Story atlas as an editorial reading experience with paced revelation, integrated image fragments, plain language, and strong consequence.
- Preserve Project Explorer as a denser working instrument with immediate route identity, useful content before scroll, and visibly distinct destinations.
- Keep mobile intentionally composed at 320–430px and verify desktop at 1024px and 1440px. A new page must work at both; neither viewport may be treated as an afterthought.
- Preserve the established public voice: literal explanation, short readable passages, visible cause and effect, and no internal maintenance language as primary promotional copy.
- Reuse components where they fit, but do not reduce every page to identical cards or duplicate the Overview hero on utility routes.
- Preserve the working mobile menus, active destination labels, archive browser, Workshop behavior, Files state, theme state, keyboard focus, reduced motion, text scaling, and overflow protections.
- New imagery must participate in the composition, remain subordinate to readable content, and respect existing canon/provenance boundaries.
- Any proposed replacement for this baseline must be built as an isolated responsive coded prototype and approved by the author before production changes.
