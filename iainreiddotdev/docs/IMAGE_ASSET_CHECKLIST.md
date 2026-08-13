# Image assets

## Homepage

One raster asset: the portrait at `assets/images/portrait.jpg`.

It is rendered inside a 4:5 box that is at most 240 CSS px wide, using
`object-fit: cover` with `object-position: center`. The source is wider than
the box, so the crop is horizontal only.

Keep the file around 1000px on its long edge — that is 2× the largest size the
box is ever painted at, including on a high-density display. It is currently
1000×893 at about 75 KB. Re-exporting at the original 2068×1847 would add
roughly 450 KB for pixels no browser will ever use, and would restore the
camera EXIF that the current export drops.

The favicon (`assets/favicon.svg`) and the three interface icons are inline
SVG. Nothing else on the page is downloaded.

## VibeKB and the account pages

These still use the workshop language described in `docs/ART_DIRECTION.md` and
are built entirely from CSS. If generated artwork is ever added there, it should
enrich that scenery rather than replace it.
