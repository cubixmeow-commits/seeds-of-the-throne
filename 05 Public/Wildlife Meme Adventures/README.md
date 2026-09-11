---
type: public-project-index
status: active
updated: 2026-09-11
platform: X
---

# Seeds of the Throne: Surface Archive

Surface Archive turns real wildlife and environmental photographs into original, X-ready records inspired by ordinary life on the *Seeds of the Throne* colonization planet. Each post preserves the real animal and authentic scene while adding a restrained story-world identity, accessible observation, and constructive connection to the larger story.

This supersedes Wildlife Meme Adventures as the active direction. Earlier episodes remain historical. The folder keeps its existing name temporarily so links and records do not break.

Surface Archive is part of the public *Seeds of the Throne* project, but individual images remain story-inspired artifacts rather than automatic canon. See [[SURFACE-ARCHIVE-DIRECTION|the governing direction]].

## Series identity

- **Parent title:** Seeds of the Throne
- **Umbrella title:** Surface Archive
- **Supporting identity:** authentic photography from or inspired by ordinary life on the colonization world's surface
- **Format:** image-determined photographic archive record; orientation and aspect ratio follow the source image unless a deliberate crop is selected
- **Episode rule:** every photograph receives a record classification, original observation or joke, and optional constructive Luminai note
- **Adaptive-theme rule:** the photograph controls composition while deep navy, parchment, antique gold, system blue, and sparse coral or ember points connect the series to the Seeds X banner
- **Image-determined canvas rule:** the retained reference supplies visual language, not a mandatory portrait size, aspect ratio, crop, or panel structure
- **Dynamic-layout rule:** every photograph receives a fresh layout derived from its subject placement, gaze or motion, horizon, negative space, visual weight, habitat structure, protected details, and natural text zones
- **Ribbon legibility rule:** when an episode ribbon is used, its title must be immediately readable in the native-aspect feed preview without opening or zooming the image
- **Tone:** positive, affectionate, observant, lightly funny, curious, and life affirming without misrepresenting the animal
- **Factual boundary:** species, location, and capture date must be verified or author-confirmed

The previous retained template remains historical at:

`~/.codex/skills/artifact-template-wildlife-meme-adventures/assets/reference.png`

Do not use the old template as the governing Surface Archive identity. Until a dedicated template is built from multiple approved examples, use [[SURFACE-ARCHIVE-DIRECTION]] with the Seeds image workflow. The photograph controls the subject, scene, orientation, aspect ratio, composition, and protected details. The episode record controls factual metadata, format decisions, originality, and approval.

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
4. **Design the record.** Define its classification, observation or joke, optional Luminai note, and one visual treatment that fits the photograph without replacing its real scene.
   - Treat every photograph as a new layout problem, even when it shares an orientation or aspect ratio with an earlier episode.
   - Inspect subject position, gaze or motion, horizon, negative space, visual weight, habitat structure, and protected details before placing text or panels.
   - Choose the canvas from the source photograph before choosing a layout. Preserve a strong source orientation and aspect ratio by default.
   - Do not force portrait, square, 2:3, three bands, or another prior episode structure onto a photograph. Any changed crop or aspect ratio must be deliberate, image-supported, and recorded.
   - Redesign the hierarchy and reading order for the selected canvas. Resizing or rearranging a portrait composition on a horizontal image does not count as an image-responsive landscape design.
   - Reuse a prior layout only when the new photograph independently supports it, and record the image-specific reason.
   - Begin from the Surface Archive palette, then adjust its balance to complement the photograph's subject, habitat, and light.
   - Keep the small umbrella branding and hierarchy recognizable, but vary composition, display typography, borders, icons, and graphic metaphor when the image supports it.
   - Treat variants as different art-direction concepts, not simple color swaps.
   - Maintain phone-size contrast and legibility even when the photograph is visually busy.
   - If a ribbon is used, make its title substantially larger than the supporting identity text. Widen the ribbon, simplify its ornaments, or use a deliberate two-line treatment before shrinking the title.
5. **Generate from the approved direction.** Attach the source photograph and the current Seeds banner or an approved Surface Archive reference. Preserve animal identity, pose, count, recognizable environment, and photographic truth.
6. **Inspect visually.** Reject anatomical drift, duplicated or missing animals, altered species, false environmental details, illegible text, clipped type, branding drift, and compositions that bury the photograph. Inspect a preview that preserves the selected aspect ratio with its longest edge at 768 pixels; a ribbon that requires zooming fails even if it is legible in the production master.
7. **Write the X package.** Produce a short positive story-concept post and useful alt text. Keep verified subject, location, capture date, and provenance in the episode record; include them publicly only when they improve the post and match the author's privacy choice.
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

## Canonical X writing direction

Use this structure for every episode:

```text
In Seeds of the Throne, [ordinary natural moment] is part of [larger constructive idea].

[One or two clear sentences connecting the photograph to life, home, growth, cooperation, independence, adaptation, or shared reality.]
```

Formatting rules:

- Use one to three short paragraphs.
- Keep the story connection direct, positive, and understandable without prior lore.
- Let ordinary life carry the meaning. Do not force every animal into a hidden clue or criminal metaphor.
- Location, time, hashtags, coordinates, and technical metadata are optional in public copy.
- Preserve verified facts and privacy choices in the episode record even when they are absent from the post.
- Do not use em dashes in captions. Use a period, comma, colon, semicolon, or parentheses instead.
- Do not add hashtags by default.

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
- the post defaults to containment, prosecution, exposure, or criminal evidence when the photograph supports a positive ordinary-life frame;
- the post treats ordinary wildlife as a system-planted symbol rather than independent life;
- alt text merely repeats the caption instead of describing the image;
- approval or publication status is ambiguous.

## Learning loop

After author feedback or publication, record the smallest transferable lesson in the episode record. Promote a pattern into this README only after it succeeds across more than one photograph. Keep photograph-specific choices local to their episode.
