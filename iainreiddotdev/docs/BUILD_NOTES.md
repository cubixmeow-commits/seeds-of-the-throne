# Build Notes

## Homepage

`index.php` is a thin composition. It loads the portfolio data, then requires
one partial per region:

```
includes/partials/
  head.php           metadata, social cards, Person JSON-LD, no-flash theme script
  icons.php          the three inline SVG icons, drawn with currentColor
  site-header.php    compact sticky header, four section links, appearance toggle
  intro.php          role, name, statement, actions, and the concerns card
  work.php           the Selected work section
  project-entry.php  one project entry, used by work.php
  approach.php       the four principles and their per-project ties
  foundations.php    four grouped capability lists
  about.php          portrait and the note about the maker
  contact.php        address, copy control, profiles
  site-footer.php    footer and the Showdown trigger
  showdown.php       the Showdown dialog
```

Every fact comes from `includes/portfolio.php` and nowhere else. Edit portfolio
content there; the header comment in that file documents which keys a project
record takes and which blocks are optional.

Styling is `assets/css/site.css` (tokens, primitives, regions, responsive) and
behaviour is `assets/js/site.js`. There is no package manager, bundler, or
build step, and the page has no third-party runtime dependency.

### What the page needs to keep working

- **The appearance toggle** stores `theme` in `localStorage` and is applied by a
  small inline script in `head.php` before first paint. Without JavaScript the
  page still follows `prefers-color-scheme`.
- **The Showdown dialog** posts to `showdown-gate.php`, which is unchanged. The
  riddle wording and the single response message must stay exactly as they are.
- **Colour** is defined once per token in OKLCH, with the dark palette repeated
  in two blocks (a `prefers-color-scheme` query and a `[data-theme="dark"]`
  selector) so the toggle can override the system in both directions. The
  `prefers-contrast: more` overrides are gated by appearance as well as
  contrast — see the comment there for why.

## VibeKB

VibeKB is the featured project. Its public page lives at `saas-lab/index.php`
(URL path `/devsite/iainreiddotdev/saas-lab/` for deploy continuity). Update that page's copy in
place; keep the existing layout and components. It and the account pages under
`auth/` and `admin/` use `assets/css/style.css`, `assets/css/saas-lab.css`,
`assets/css/auth.css`, and `assets/js/app.js`. The homepage does not, so those
files stay in place and were not touched by the homepage redesign.

## Retro (MEOWNET BBS)

`retro/index.php` is a self-contained joke page: a 1990s dial-up bulletin board
about cats, linked from the homepage footer. It is one file plus
`assets/css/retro.css` and `assets/js/retro.js`, and it uses none of the
homepage's stylesheet, script, or partials — only `includes/portfolio.php`, and
only for the escape helper and the sysop's real name and profile links, so those
cannot disagree with the homepage.

All of its copy (bulletins, messages, file listing, doors, one-liners, stats)
lives in arrays at the top of the page. Edit content there.

- **Screens** are five `role="tabpanel"` sections driven by a `role="tablist"`
  menu. Without JavaScript every screen renders stacked and readable; the script
  sets `data-ready` on the panel container and hides all but one.
- **Hotkeys** `1`–`4`, `0`, and `P` are extras on top of the menu buttons, which
  stay clickable and arrow-key navigable. They are ignored while a field has
  focus.
- **Phosphor** green or amber, stored as `retro-phosphor` in `localStorage` and
  driven by `data-phosphor` on `<body>`; every colour downstream is a token.
- **The artwork is text.** The page requests no images at all, so the banner
  must stay 65 columns wide — `.banner__art` sizes itself from the viewport on
  that assumption.

## Deployment

The complete repository deploys to `/home/iainmcok/public_html/devsite/`; this application remains nested at `/home/iainmcok/public_html/devsite/iainreiddotdev/`.
The deploy is copy-only, so nothing above needs a `.cpanel.yml` change:
`assets`, `includes`, and `index.php` are already copied recursively. The one
exception is a new top-level directory: `retro/` was added to `.cpanel.yml`
when it was created, the same way `x/` was.

Because the deploy never deletes, files the repository removed stay on the
server. The retired three.js homepage (`assets/js/vendor/`,
`assets/js/workbench/`, `assets/js/doc.js`, `assets/css/workbench.css`) is no
longer referenced by any page, so a stale copy is inert — but it is about
950 KB of dead weight and can be removed over SSH:

```bash
rm -rf ~/public_html/devsite/iainreiddotdev/assets/js/vendor \
       ~/public_html/devsite/iainreiddotdev/assets/js/workbench \
       ~/public_html/devsite/iainreiddotdev/assets/css/workbench.css \
       ~/public_html/devsite/iainreiddotdev/assets/js/doc.js
```
