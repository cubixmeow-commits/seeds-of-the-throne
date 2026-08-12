# Image storage policy

## Directory roles

| Layer | Location | Format | Purpose |
| --- | --- | --- | --- |
| Identity source | `assets/reference-images/` | PNG or original JPEG | Canonical character geometry and supporting visual references |
| Approved story source | `assets/approved-images/<character-id>/` | Original PNG/JPEG | Approved full-quality story frames and future edit sources |
| Public delivery | `docs/assets/images/` | WebP or optimized JPEG | Fast GitHub Pages display |
| Prompt record | `prompts/` | Markdown | Reproducible generation instructions |
| Metadata | `references/visual-registry.json` | JSON | Status, provenance, checksums, dimensions, relationships, and sequence order |

## Promotion workflow

1. Keep generated candidates outside the repository until the author chooses one.
2. Copy an approved source into `assets/approved-images/<character-id>/` with a stable semantic filename.
3. Never overwrite it. Use `-v2`, `-v3`, and later suffixes for revisions.
4. Create a public derivative from the approved source. Do not recompress an existing derivative.
5. Add both source and derivative checksums to the visual registry.
6. Record the model, date, prompt path, dimensions, approval, intended use, and any sequence relationship.
7. Validate the registry, inspect the public derivative, and test every site reference.

Use `scripts/prepare_approved_image.py` for steps 2 through 4. It refuses to overwrite existing assets, uses WebP quality 82 by default, strips public metadata, and prints dimensions, byte counts, paths, and SHA-256 checksums for the registry.

## Compression targets

- Preserve approved identity masters and approved story sources at their original dimensions and format.
- Use WebP quality 80 to 84 for large cinematic site images. Aim for 250 to 700 KB.
- Use optimized JPEG quality 82 to 88 only when WebP is impractical.
- Keep site dimensions no larger than the display use requires. A 1600 to 2000 pixel wide derivative is sufficient for most full-width atlas imagery.
- Strip metadata from public derivatives.
- Do not enlarge generated images.
- Keep ordinary image files below 10 MB. Review any file above 25 MB before committing. Do not add an ordinary Git object approaching GitHub's 50 MB warning threshold.

## Repository budget

- Keep the Git repository comfortably below 1 GB.
- Keep the published `docs/` site comfortably below 1 GB.
- Review image growth when the working tree reaches 500 MB or when `docs/assets/images/` reaches 250 MB.
- Git LFS is not the default for this project because GitHub Pages cannot serve LFS objects directly. If source masters eventually outgrow the repository budget, move archival originals to external object storage and keep compressed public derivatives plus registry metadata in Git.

## Retention

- Keep canonical identity images.
- Keep author-approved narrative frames.
- Keep a rejected candidate only if it demonstrates a documented failure mode.
- Delete disposable local candidates only after confirming the approved source is stored and checksummed.
- Never rewrite Git history merely to remove a small image without explicit authorization.
