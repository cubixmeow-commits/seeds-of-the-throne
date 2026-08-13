---
type: production-system
status: working
updated: 2026-08-13
---

# Output Formats and Delivery

## Still image briefs

Specify:

- intended use: exploration, identity reference, scene art, atlas, social post, or sequence source;
- aspect ratio and orientation;
- minimum useful resolution when the tool exposes it;
- crop-safe area for the intended platform;
- text policy: normally no generated text, logos, captions, or watermarks;
- number and type of variants;
- whether transparent background or isolated subject is actually required;
- approval state expected after review.

Common working shapes:

- **16:9 landscape** — cinematic story frames and video source images;
- **9:16 portrait** — vertical social and mobile video frames;
- **1:1 square** — identity comparisons and flexible social crops;
- **4:5 portrait** — character-led social imagery;
- **front/profile/three-quarter sheets** — identity geometry, neutral light, minimal perspective distortion.

## Video briefs

Specify duration, frame orientation, start and end state, camera movement, dialogue or silence, sound expectations, looping behavior if any, and the still or prior shot that anchors continuity. Treat tool-specific resolution, duration, frame rate, audio, and extension limits as capabilities to verify for the current session.

## Voice deliverables

Retain:

- character and voice-bible version;
- exact spoken text;
- tool/model and settings when visible;
- date and test purpose;
- neutral and emotional continuity samples;
- approval status and known drift.

## File naming

Use stable descriptive names:

`character-or-scene__era-or-location__beat__angle-or-shot__vNN__status.ext`

Do not encode uncertain canon as fact in a filename. Use `candidate`, `continuity-pass`, `approved-reference`, or `published` as the final status token when useful.

## Provenance sidecar

For any retained output, preserve:

- generation date;
- generating tool and model when known;
- full prompt or prompt-packet path;
- source references and their priority;
- aspect ratio, duration, and exposed settings;
- continuity notes and drift warnings;
- reviewer decision and approval state;
- intended uses and publication history.

## Delivery checklist

- Identity matches the approved lock.
- The scene depicts the intended story beat without settling unresolved canon.
- Environment and technology have physical and social function.
- Pose, crop, wardrobe, palette, and composition were regenerated when references were used.
- Hands, props, text, reflections, and background people pass inspection.
- Output dimensions fit the intended use and safe crop.
- Prompt and provenance are stored with the asset.
- Only approved material enters the public atlas or becomes a reusable identity anchor.
