---
type: public-project-index
status: active
updated: 2026-08-19
platform: X
---

# Wildlife Meme Adventures

Wildlife Meme Adventures turns real local wildlife photographs into original, X-ready visual episodes. Each post preserves the real animal and authentic scene while adding a playful adventure premise through the retained Wildlife Meme Adventures poster design.

This is a public-photography system, not *Seeds of the Throne* story canon.

## Series identity

- **Umbrella title:** Wildlife Meme Adventures
- **Supporting identity:** Local Wildlife Photography
- **Format:** image-determined editorial field-poster built around an authentic photograph; orientation and aspect ratio follow the source image unless a deliberate crop is selected
- **Episode rule:** every photograph receives a new title, joke, and visual direction
- **Adaptive-theme rule:** recurring identity stays fixed, while palette, composition, borders, and graphic motifs are derived from and complementary to the individual photograph
- **Image-determined canvas rule:** the retained reference supplies visual language, not a mandatory portrait size, aspect ratio, crop, or panel structure
- **Dynamic-layout rule:** every photograph receives a fresh layout derived from its subject placement, gaze or motion, horizon, negative space, visual weight, habitat structure, protected details, and natural text zones
- **Ribbon legibility rule:** when an episode ribbon is used, its title must be immediately readable in the native-aspect feed preview without opening or zooming the image
- **Tone:** affectionate, observant, adventurous, and funny without misrepresenting the animal
- **Factual boundary:** species, location, and capture date must be verified or author-confirmed

The retained template remains unchanged at:

`~/.codex/skills/artifact-template-wildlife-meme-adventures/assets/reference.png`

Use `$artifact-template-wildlife-meme-adventures` for production. The template controls the recurring identity, hierarchy, material language, and finish. The photograph controls the subject, scene, orientation, aspect ratio, composition, and protected details. The episode record controls factual metadata, format decisions, and originality.

## Folder map

- [[EPISODE-INDEX|Episode Index]] — one-row overview of every planned, drafted, approved, and published episode.
- `Episodes/` — one complete Markdown record per episode.
- `Source Photos/` — small GitHub-friendly source previews and original-file provenance.
- `Drafts/` — small GitHub-friendly previews of generated candidates, plus caption drafts and alt text awaiting approval.
- `Published/` — publication record, small image preview, caption, date, X link, and full-quality master provenance.
- `Templates/` — reusable episode record and intake checklist.
- [[Templates/Adaptive Three-Band Design Process|Adaptive Three-Band Design Process]] — reusable workflow for image-led title/photo/payoff compositions.

## Episode workflow

1. **Intake the photograph.** Keep the full-resolution original outside the GitHub vault. Store only a lightweight preview here, and record the original filename, dimensions, orientation, aspect ratio, checksum, and known external path in the episode record.
2. **Verify the facts.** Record the real subject, specific location at the author's chosen privacy level, capture date, photographer, and how each fact was verified. Preserve uncertainty rather than guessing.
3. **Check originality.** Review the episode index for prior titles, joke structures, taglines, visual devices, and animal scenarios. Reusing the umbrella identity is required; repeating an episode concept is not.
4. **Design the episode.** Define the episode ribbon, dominant joke line, bottom payoff, and one visual treatment that fits the photograph without replacing its real scene.
   - Treat every photograph as a new layout problem, even when it shares an orientation or aspect ratio with an earlier episode.
   - Inspect subject position, gaze or motion, horizon, negative space, visual weight, habitat structure, and protected details before placing text or panels.
   - Choose the canvas from the source photograph before choosing a layout. Preserve a strong source orientation and aspect ratio by default.
   - Do not force portrait, square, 2:3, three bands, or another prior episode structure onto a photograph. Any changed crop or aspect ratio must be deliberate, image-supported, and recorded.
   - Redesign the hierarchy and reading order for the selected canvas. Resizing or rearranging a portrait composition on a horizontal image does not count as an image-responsive landscape design.
   - Reuse a prior layout only when the new photograph independently supports it, and record the image-specific reason.
   - Sample the palette from the photograph's subject, habitat, and light rather than imposing one series-wide color scheme.
   - Keep the small umbrella branding and hierarchy recognizable, but vary composition, display typography, borders, icons, and graphic metaphor when the image supports it.
   - Treat variants as different art-direction concepts, not simple color swaps.
   - Maintain phone-size contrast and legibility even when the photograph is visually busy.
   - If a ribbon is used, make its title substantially larger than the supporting identity text. Widen the ribbon, simplify its ornaments, or use a deliberate two-line treatment before shrinking the title.
5. **Generate from the retained template.** Attach both the source wildlife photograph and the retained reference. Preserve animal identity, pose, count, recognizable environment, and photographic truth.
6. **Inspect visually.** Reject anatomical drift, duplicated or missing animals, altered species, false environmental details, illegible text, clipped type, branding drift, and compositions that bury the photograph. Inspect a preview that preserves the selected aspect ratio with its longest edge at 768 pixels; a ribbon that requires zooming fails even if it is legible in the production master.
7. **Write the X package.** Produce a concise factual caption, useful alt text, and any restrained hashtags. The caption may describe the joke but must clearly state the real subject, location, and capture date.
8. **Record approval.** A generated candidate remains a draft until the author approves the image and caption.
9. **Publish only when requested.** Publication is a separate external action requiring explicit authorization.
10. **Archive exactly without repository bloat.** Save a roughly 50 KB preview in the vault plus the full-quality master checksum and external provenance, exact caption, publication timestamp, X URL, and any post-publication lesson.

## GitHub image-storage policy

- Target roughly 50 KB per vault image; a practical range is 30–60 KB.
- Current preview profile: JPEG, selected aspect ratio preserved, longest edge 768 pixels, approximately quality 30.
- Preview dimensions follow the selected episode canvas. Do not stretch, pad, or crop every poster to one default shape merely for consistency.
- Store high-resolution source photographs and production masters outside the Git repository.
- Never treat a preview as the production master. Record the master dimensions and SHA-256 when available.
- Generate or retrieve the full-quality asset before publishing to X.

## Canonical X caption format

Use this structure for every episode:

```text
Wildlife Meme Adventures 🧭

“[One short episode joke or observation.]”
📍 [Verified location at the approved privacy level]
📅 [Month Day, Year] · [Weekday], [Time]

Behind the meme: This is a real photograph of [factual subject and scene], [one light comic observation grounded in what is visible].
```

Formatting rules:

- Keep the series header exact, including the compass emoji.
- Canonical series header: `Wildlife Meme Adventures 🧭`. The compass represents exploration and works across animals, habitats, and occasional non-animal adventure episodes.
- Use curly quotation marks around one short joke line.
- Put location and capture time on their own emoji-led lines.
- Include month, day, year, weekday, and local capture time.
- Use the author's chosen location privacy level; never expose an exact site when the record says undisclosed.
- Begin the final paragraph with `Behind the meme:` and identify the real photograph factually before adding the joke.
- Do not use em dashes in captions. Use a period, comma, colon, semicolon, or parentheses instead.
- Do not add hashtags by default.
- Preserve this structure while giving every episode original wording.

## File naming

Use:

`YYYY-MM-DD - Short Episode Title.md`

Associated assets use the same date and slug:

- source: `YYYY-MM-DD-short-episode-title-source.ext`
- draft preview: `YYYY-MM-DD-short-episode-title-draft-v01.jpg`
- final preview: `YYYY-MM-DD-short-episode-title-final-preview.jpg`

The episode date is the development date. Record the actual capture and publication dates separately.

## Approval states

- `intake` — source received; facts or direction incomplete
- `planned` — facts verified; episode direction selected
- `draft` — image or caption candidate exists
- `approved` — author approved the complete X package
- `published` — exact post and link archived
- `retired` — concept rejected or superseded

Approval of one episode does not approve a new global visual or writing rule.

## Quality gates

An episode is not ready when:

- wildlife identity or count has changed;
- the authentic scene has been replaced without explicit direction;
- subject, location, or date is invented;
- the episode repeats a prior premise or tagline;
- the branding dominates the photograph;
- the output uses a default template orientation or aspect ratio that the source photograph does not support;
- the layout repeats an earlier episode without a recorded image-specific reason;
- an unrecorded crop removes important subject, habitat, action, or environmental context;
- on-image text is illegible or incorrect;
- an episode ribbon is present but its title is not immediately readable in the native-aspect feed preview;
- the caption presents the joke as wildlife fact;
- the caption contains an em dash;
- the caption omits the series header, verified location, weekday, capture time, or `Behind the meme:` factual explanation;
- alt text merely repeats the caption instead of describing the image;
- approval or publication status is ambiguous.

## Learning loop

After author feedback or publication, record the smallest transferable lesson in the episode record. Promote a pattern into this README only after it succeeds across more than one photograph. Keep photograph-specific choices local to their episode.
