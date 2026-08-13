# iainreid.dev

This is the [iainreid.dev](https://iainreid.dev) portfolio.

## Deployment target

Namecheap shared hosting with cPanel and LiteSpeed.

## Production stack

- PHP 8.2
- HTML
- CSS
- Vanilla JavaScript

No framework, package manager, build system, bundler, or CDN dependency, and
no third-party runtime dependency of any kind. Nothing further should be added
unless explicitly requested.

## Homepage

The homepage is a single editorial page: a compact header, an immediate
introduction, selected work, a short account of how the work gets built,
foundations, a note about the maker, and a direct contact close.

It is composed from small partials in `includes/partials/`, and every fact on
it — names, statuses, summaries, links, contact details — is read from
`includes/portfolio.php`. That file stays the only source of truth, so adding
a project is still a data edit and no copy is written down twice.

The page requests one stylesheet, one script, and one image.

See `docs/ART_DIRECTION.md` for the visual system and `docs/BUILD_NOTES.md`
for how the files fit together.

## Retro

`retro/` is a joke page linked from the homepage footer: MEOWNET BBS, a 1990s
dial-up bulletin board about cats. Same stack, no images — every piece of art on
it is text. See the Retro section of `docs/BUILD_NOTES.md`.

## Integrated location

This site now lives in the `iainreiddotdev/` directory of the *Seeds of the Throne* repository. The repository root contains a small redirect, while the cPanel deployment copies this application to:

```
public_html/iainreiddotdev/index.php
```

The domain root redirects to: https://iainreid.dev/iainreiddotdev/
