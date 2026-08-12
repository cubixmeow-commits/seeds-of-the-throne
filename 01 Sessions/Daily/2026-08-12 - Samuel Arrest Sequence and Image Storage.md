---
type: development-session
status: active
date: 2026-08-12
topics: Samuel Franklin, arrest sequence, image approval, image storage, compression
---

# Samuel Arrest Sequence and Image Storage

## Question explored

Which generated Samuel arrest images should be kept, how they relate as a sequence, and how approved images should be stored without making the GitHub repository or public site unnecessarily large.

## Author decisions

- Approve generated Candidate 3 as the first frame in the sequence.
- Approve generated Candidate 1 as the second frame.
- Frame 1 shows authenticated evidence, system failure, and increasing law-enforcement presence.
- Frame 2 shows the progression into direct physical arrest.
- The image workflow is proven useful across OpenAI and Gemini-style prompting.
- Establish a repeatable source, derivative, metadata, and compression process for future images.

## Current working direction

Approved full-resolution PNG sources remain available for future edits and visual continuity. The public atlas receives separate WebP derivatives. The sequence order is registered as story presentation, while the exact room, officer design, and arrest formation remain noncanonical visual interpretation.

## Storage results

- Frame 1 source PNG: approximately 2.3 MB.
- Frame 1 public WebP: approximately 218 KB.
- Frame 2 source PNG: approximately 2.2 MB.
- Frame 2 public WebP: approximately 175 KB.
- Public delivery size is reduced by approximately 91 percent while preserving the original 1672 by 941 dimensions.

## Vault impact

- `skills/create-seeds-images/SKILL.md`
- `skills/create-seeds-images/references/storage-policy.md`
- `skills/create-seeds-images/references/visual-registry.json`
- `skills/create-seeds-images/assets/approved-images/samuel-franklin/`
- `docs/assets/images/`
- `docs/visuals.html`
