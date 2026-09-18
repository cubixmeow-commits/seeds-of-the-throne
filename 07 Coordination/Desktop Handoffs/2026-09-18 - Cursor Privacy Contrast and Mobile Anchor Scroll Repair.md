---
type: implementation-handoff
status: ready
date: 2026-09-18
owner: Cursor
scope: Privacy contrast and Project Explorer mobile anchor scrolling
---

# Cursor Privacy Contrast and Mobile Anchor Scroll Repair

## Outcome

Fix two narrow production regressions without redesigning either page:

1. Privacy-page body text must remain clearly readable in light, dark, and system-selected themes.
2. Project Explorer anchor navigation must land below the sticky header once, then release control so normal manual scrolling never snaps back to the anchor on mobile.

Work from current `main`. Read `AGENTS.md` and preserve unrelated work. Do not change story content, analytics behavior, navigation structure, or the approved Pale Signal design.

## Defect 1: Privacy page has nearly invisible text

### Reproduction

Open `iainreiddotdev/privacy.php`, especially with the system or site theme set to dark. The privacy card can be white while inherited text is light gray or near-white.

### Likely cause

In `iainreiddotdev/assets/css/site.css`, `.privacy-record` uses:

```css
background: var(--paper, #fbf9f5);
```

The portfolio theme defines semantic tokens such as `--surface` and `--text`, but does not define `--paper` on this page. The fallback therefore remains light even when dark-theme text tokens are active. Also inspect the privacy-only use of the undefined `--muted` token.

### Required repair

- Use the portfolio design system's existing semantic background, foreground, border, and muted-text tokens.
- Ensure `.privacy-record`, headings, paragraphs, links, button labels, and analytics status text have readable contrast in explicit light, explicit dark, and system themes.
- Preserve the current layout and wording.
- Do not solve this with a hard-coded foreground/background pair that breaks theme switching.

## Defect 2: Mobile anchor scrolling fights the user

### Reproduction

On the Project Explorer in a mobile browser, activate a navigation link containing a fragment. The page reaches the destination, but subsequent manual scrolling can jerk or snap back to that anchor.

### Confirmed suspicious code

`iainreiddotdev/project-explorer/assets/project-explorer.js` defines `settleDestination()`, which can issue up to 30 scroll commands. Initial hash handling runs it immediately, again on `load`, and at 120, 400, and 900 ms. The generic `resize` handler calls it again. Mobile browser chrome and viewport changes commonly emit resize events while a person scrolls, so the page can repeatedly reclaim the scroll position.

The CSS already provides sticky-header offsets through `scroll-padding-top` and `scroll-margin-top` in `iainreiddotdev/project-explorer/assets/project-explorer.css`.

### Required repair

- Keep smooth anchor navigation for users who have not requested reduced motion.
- Respect `prefers-reduced-motion` with immediate/non-animated movement.
- Land fragment targets below the compact sticky header.
- Remove repeated or delayed scroll enforcement that can run after navigation is complete.
- Do not re-scroll to `location.hash` on ordinary resize events.
- If JavaScript correction is still necessary, make it deterministic, bounded, and cancelable as soon as the user scrolls/touches/gestures; prefer the existing CSS `scroll-padding`/`scroll-margin` behavior.
- Preserve hash changes, direct fragment loads, back/forward navigation, active navigation state, mobile-menu behavior, and desktop behavior.

## Primary files

- `iainreiddotdev/privacy.php`
- `iainreiddotdev/assets/css/site.css`
- `iainreiddotdev/project-explorer/assets/project-explorer.js`
- `iainreiddotdev/project-explorer/assets/project-explorer.css`
- `iainreiddotdev/project-explorer/index.php` only if its asset version must be bumped
- `scripts/test_story_browser.cjs` for focused regression coverage where practical

## Acceptance checks

- Privacy text is visibly readable in light and dark themes at 320px and desktop widths.
- Privacy theme toggling does not leave a light card with light text or a dark card with dark text.
- On mobile, each Explorer anchor link lands below the sticky header.
- After the destination settles, manual upward and downward scrolling remains under the user's control for at least several seconds; there is no snap-back.
- Collapsing/expanding browser chrome, rotating the device, or causing a viewport resize does not return the page to the old anchor.
- Direct fragment URLs and browser back/forward still reach the correct destination.
- Reduced-motion mode does not animate the scroll.
- No horizontal overflow or mobile-menu regression at 320, 375, and 430px.
- Asset query versions are bumped for every changed production CSS/JS file so deployment cannot serve stale behavior.

## Verification

Run the existing relevant checks, plus syntax/lint checks for changed files:

```text
python3 scripts/check_story_sites.py
node --check iainreiddotdev/project-explorer/assets/project-explorer.js
node scripts/test_story_browser.cjs
git diff --check
git status --short
```

If PHP is available, lint changed PHP files. Manually test the scrolling defect in a narrow/mobile browser because a screenshot alone cannot prove that scroll position is no longer being reclaimed.

## Completion report

Report the root cause and fix for each defect, exact files changed, checks run with results, mobile browsers/viewports tested, anything not tested, and final `git status`. Do not deploy unless separately asked.
