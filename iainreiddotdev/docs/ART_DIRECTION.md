# Art direction

The site has two visual languages, and they are deliberately different.

## 1. The homepage

`index.php`, styled entirely by `assets/css/site.css`.

The target is an independent builder's studio rather than a developer
template: restrained, editorial, technically confident, warm, and quiet. It
should read like something a person maintains, not something a generator
produced.

### Core visual language

- **Warm paper and warm ink.** The neutrals carry a slight warm cast in both
  appearances, so the page never looks like default greyscale UI.
- **One accent, and it means one thing.** Electric cobalt blue, carried
  forward from the previous concept, is reserved for interactive elements and
  the numerals that count the page. It never appears on decorative text. If
  something is blue, it is either a link, a control, or an index mark.
- **Hairlines and numerals.** Sections and entries are separated by 1px rules
  and labelled with mono numerals (`01 WORK`, `I`, `Specimen A`). The counting
  is the memorable device; there is no other ornament.
- **The ledger grid.** From laptop width up, a narrow rail holds the metadata
  (section numeral, project mark, category, status) and a wide column holds
  the content. It is the layout the whole page is built around.
- **Depth from shadow, structure from borders.** Cards use layered
  transparent shadows; borders are kept for dividers, inputs, and state.
- **Disciplined radii.** Three steps only: 3px, 8px, 14px.
- **Generous but purposeful whitespace.** Space does the grouping; rules are
  used only where space alone cannot carry the structure.

### Typography

A restrained scale, five sizes, no downloaded fonts.

A system serif sets names, section titles, and project titles. A system sans
sets everything anyone has to read. A system mono sets labels, numerals, and
status. Body copy runs at roughly 62–70 characters with a 1.58 line height.

### Motion

Subtle, fast, reversible, and opt-in. Every transition is declared inside
`@media (prefers-reduced-motion: no-preference)`, names its exact properties
(never `transition: all`), and animates only compositable ones. There is no
autoplaying motion, no scroll-triggered reveal, and no background animation.

### What it must not become

- A generic AI look. No large gradients, glassmorphism, neon, floating blobs,
  purple cyberpunk, glowing circuitry, or animated background noise.
- A generic developer template. No giant empty hero, no skill-proficiency
  bars, no logo cloud, no identical decorative project cards, and no "I build
  digital experiences" copy.
- Colour used as decoration. One accent, one meaning.

### Personal information

Only what is already in `includes/portfolio.php`. Nothing on the page may
invent a fact about anybody — no metrics, employers, client work, or
biography that is not already recorded there.

### Assets

One raster asset: the existing portrait at `assets/images/portrait.jpg`,
lazy-loaded, with a neutral 1px ring (pure black at 10% in light, pure white
at 10% in dark — never a tinted near-black, which reads as dirt on the edge).
The favicon is an inline SVG monogram. The three icons on the page are inline
SVG drawn with `currentColor`. Nothing else is downloaded.

## 2. VibeKB and the account pages

`saas-lab/index.php`, `auth/`, and `admin/` still use the earlier workshop
language, built entirely from CSS in `assets/css/style.css`,
`assets/css/saas-lab.css`, and `assets/css/auth.css`. They were not part of
the homepage redesign and are unchanged.
