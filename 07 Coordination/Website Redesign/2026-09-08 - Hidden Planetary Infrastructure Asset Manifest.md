---
type: website-asset-manifest
status: approved-for-website-design
date: 2026-09-08
direction: Hidden Planetary Infrastructure
generator: OpenAI built-in image generation
canon_status: interpretive, non-canon
---

# Hidden Planetary Infrastructure Asset Manifest

## Approval boundary

The author approved this image set for the website redesign. Approval means Cursor may use, crop, layer, compress, and responsively present these assets within the selected website direction. It does **not** make any depicted architecture, geography, machine, moon connection, institution, document, person, containment room, or visualized mechanism a story fact.

The images contain no authoritative character identities. Use the existing approved character assets and `skills/create-seeds-images/references/visual-registry.json` whenever Samuel, Sylvan, or Konrad appears.

## Design reference

### Selected responsive mockup

- **Source:** `07 Coordination/Website Redesign/Assets/Web/hidden-planetary-infrastructure-selected-mockup-v1.webp`
- **Dimensions:** 1536 × 1024
- **Size:** 176,824 B
- **SHA-256:** `a7c6f4cc7b99e7e54d2c4cf67f842444b0f84fda16871ff80585ba43655db5e8`
- **Use:** layout, hierarchy, palette, responsive composition, and surface/hidden-system relationship.
- **Do not use as:** production website screenshot, copy source, character identity source, literal labeled diagram, or canon reference.
- **Warning:** every word, face, label, and specific mechanism inside the mockup is generated design material. Render approved copy as HTML and use approved character art separately.

## Production-oriented artwork

| Asset | Dimensions | Vault path | Size | SHA-256 | Intended use |
|---|---:|---|---:|---|---|
| `planetary-cutaway-hero-desktop-v1` | 1672 × 941 | `Assets/Web/planetary-cutaway-hero-desktop-v1.webp` | 192,414 B | `ab338be84ad58878056f72555977b6343144d3940418a269c06275a2fd12f427` | Wide homepage hero; copy occupies protected left field |
| `planetary-cutaway-hero-mobile-v1` | 941 × 1672 | `Assets/Web/planetary-cutaway-hero-mobile-v1.webp` | 220,562 B | `8ffc49b2a7d131f858f29a64bbec7d21bed635cc6ebc928bd333842e5c0b8c47` | Portrait mobile hero or picture-source crop |
| `surface-civilization-editorial-v1` | 1536 × 1024 | `Assets/Web/surface-civilization-editorial-v1.webp` | 312,544 B | `e60623b11172876d7ebceff05d8ebbc10d9d5b062ccdde5bc0d5c750fb50d1a1` | “World everyone knew” editorial section |
| `recovered-records-evidence-v1` | 1774 × 887 | `Assets/Web/recovered-records-evidence-v1.webp` | 197,566 B | `9b48afe9709a23d388a69e4fd71ed0e112534a3409563f4cb9552159af1ba406` | Conspiracy, evidence, timeline, archive, or transition section |

The durable vault package uses optimized WebP files to avoid adding roughly 15 MB of duplicate PNG working data to Git. The exact prompts below preserve reproducibility. Cursor should copy selected WebP assets into `docs/assets/images/` only when implementing references. Preserve this package and never recompress an existing WebP into another WebP.

## Visual QA

| Category | Desktop hero | Mobile hero | Surface civilization | Evidence image |
|---|---:|---:|---:|---:|
| Project style | 5 | 5 | 4 | 5 |
| Palette and light | 5 | 5 | 4 | 5 |
| Composition for intended use | 5 | 5 | 5 | 5 |
| Artifact control | 5 | 5 | 5 | 5 |
| Canon safety with manifest warning | 4 | 4 | 4 | 4 |

### Reasons for scores below 5

- The surface image intentionally prioritizes natural observational light over the full dark archive palette.
- All four images invent convenient visual architecture. They are safe only while treated as interpretive compositions rather than literal world documentation.
- The heroes' highly exposed underground spaces make the premise legible but must not establish how the real system is arranged or whether a physical cutaway could exist in-world.
- The surface city suggests a particular coastal architectural culture and the evidence image suggests particular physical records. Neither is approved as a named location or artifact.

## Exact generation prompts

### Desktop planetary hero

```text
Use case: stylized-concept
Asset type: Seeds of the Throne responsive website hero artwork, desktop landscape
Input image: visual direction reference only; use its palette and surface-versus-hidden-system idea, but do not reproduce its interface, text, labels, or exact architecture.
Primary request: Create a cinematic, painterly-photorealistic symbolic cutaway of a populated colonization planet. The upper surface is a genuinely lived-in civilization with a dense coastal city, working civic buildings, neighborhoods, roads, transit, trees, water, maintenance, and ordinary human activity. Beneath it, immense concealed distributed infrastructure is revealed through a clean sectional opening: layered energy, logistics, archives, permissions, and containment zones integrated into rock and architecture. A moon-scale command structure hangs above and coordinates the planet without becoming a glowing face or orb.
Composition: wide 16:9 website hero. Main planetary cutaway occupies the right two-thirds. Preserve calm near-black negative space on the left for real HTML headline and buttons. Strong readable silhouette at desktop crop. No UI elements in the image.
Style: Seeds gothic archival science-fantasy; tactile real materials; solemn scale; near-black ground; antique gold for evidence and constructive systems; clear blue used sparingly for coordination; restrained crimson only in the deepest containment region; small living green areas on the surface.
Canon safety: this is an interpretive website visualization, not a literal engineering diagram. Do not imply the surface civilization is fake or a terrarium.
Avoid: words, letters, numbers, labels, logos, watermarks, crowns, named characters, identifiable portraits, holograms, neon cyberpunk, spaceship dashboard, generic fantasy castle, empty city, giant AI face, pristine utopia, apocalyptic destruction.
```

### Mobile planetary hero

```text
Use case: stylized-concept
Asset type: Seeds of the Throne responsive website hero artwork, mobile portrait
Input image: visual direction reference only; use its palette and surface-versus-hidden-system idea, but do not reproduce text, interface, labels, or exact architecture.
Primary request: Create the mobile companion to a cinematic symbolic cutaway of a populated colonization planet. A real, thriving coastal surface civilization curves across the upper middle, with neighborhoods, civic buildings, transit, vegetation, water, maintenance, and tiny ordinary human activity. A vertical sectional reveal descends into vast concealed distributed infrastructure: archives, energy, logistics, permissions, Luminai development spaces, and a restrained crimson containment depth. The command moon is visible above.
Composition: tall 9:16 mobile website artwork. Leave a quiet dark upper-left/top zone suitable for HTML heading. Keep the surface, hidden-system layers, and moon readable at phone width. No UI inside the image.
Style: painterly photorealism, tactile stone/metal/soil/water, near-black negative space, warm antique gold, sparse clear blue coordination lines, minimal deep crimson at the lowest containment layer, living green on the authentic surface.
Canon safety: interpretive website visualization only; surface civilization is real and inhabited, not fake.
Avoid: all text, labels, logos, watermarks, named characters, portraits, fantasy royalty, holograms, neon cyberpunk, giant AI orb or face, sterile cutaway model, empty plaza, destruction.
```

### Surface civilization

```text
Use case: historical-scene
Asset type: Seeds of the Throne homepage editorial image, the world everyone knew
Input image: palette and tone reference only; do not copy its interface, cutaway, or text.
Primary request: A convincing observational view of a thriving invented coastal capital on the colonization planet before the hidden infrastructure is revealed. Show real ordinary life: layered old and newer civic architecture, apartment neighborhoods, public transit, pedestrians, workers maintaining streets and utilities, markets, trees, water, distant industry, and evidence of generations of repair and adaptation. The civilization must feel lived, autonomous, historically accumulated, and worth protecting.
Composition: wide editorial landscape with foreground human scale and deep city context; suitable for a responsive website section. People are small anonymous residents, never hero portraits.
Style: credible cinematic photography with subtle archival character, warm natural late-day light, stone, brick, steel, plaster, glass, greenery and water. Only a nearly invisible geometric alignment in the sky or infrastructure hints that something deeper exists.
Canon safety: candidate environment direction; do not establish a specific city, nation, institution, era, or event.
Avoid: text, flags, insignia, logos, recognizable Earth landmarks, fantasy castle, cyberpunk, holograms, futuristic consumer technology, empty concept-art plaza, military parade, dystopian ruin.
```

### Recovered records and evidence

```text
Use case: stylized-concept
Asset type: Seeds of the Throne homepage/archive evidence background
Input image: visual direction reference only; preserve its near-black, antique-gold, restrained-cyan and crimson palette but do not copy text or layout.
Primary request: An overhead editorial still life where recovered historical records meet hidden-system evidence. Layer worn institutional folders, maps, correspondence, photographic fragments, timeline strips, seals without insignia, and a physical planetary survey over a near-black archival table. Precise antique-gold provenance paths and sparse clear-blue coordination geometry align contradictions across the materials. One restrained crimson fracture or captured pathway interrupts the evidence chain.
Composition: wide website section image with generous clean areas for HTML captions. Strong visual hierarchy, a few large evidence objects rather than clutter. All record surfaces must be blank, abstract, redacted, or too small to read.
Style: tactile archival documentary fused with exact advanced-system geometry; serious, restrained, elegant, ominous.
Canon safety: represents the method of reconstructing history, not literal documents or settled evidence.
Avoid: readable generated text, letters, numbers, real seals, real-world maps, logos, watermarks, parchment fantasy, detective-corkboard cliché, messy conspiracy strings, neon HUD, glowing screens.
```

## Implementation rules for Cursor

- Use `<picture>` with the supplied mobile and desktop hero sources. Do not rely on an uncontrolled center crop of the desktop image on narrow screens.
- Render all title, premise, navigation, labels, callouts, and buttons as real HTML.
- Write meaningful alt text that describes the image as a symbolic visualization. Do not describe invented machinery as confirmed fact.
- Prefer `loading="eager"` and `fetchpriority="high"` only for the above-the-fold hero. Lazy-load below-fold imagery.
- Set intrinsic width and height or `aspect-ratio` to prevent layout shift.
- Apply a gradient/scrim in CSS only where needed for text contrast; do not permanently crush the surface detail.
- Do not use the mockup's generated faces. Preserve approved identity sources.
- Do not use these images to generate new character identities.
- Keep the manifest and original WebPs together; if a later edit is required, generate or edit from the original renderer output rather than recompressing a public derivative.
