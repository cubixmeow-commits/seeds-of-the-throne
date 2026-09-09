# Visual QA for Seeds interfaces

## Required viewports

Test at 320, 375, 430, 768, 1024, and 1440 CSS pixels. Include at least one 320×568 or similarly short viewport and one modern tall-phone viewport.

## Browser checks

- No document or body overflow beyond the viewport.
- Long repository paths wrap or truncate within their component.
- Tables and code blocks scroll inside their own containers.
- Mobile menus open, close, escape-dismiss, and restore focus.
- Touch targets are at least 44×44 CSS pixels.
- Focus indicators are visible.
- Text remains usable at 200% zoom.
- Reduced-motion mode removes nonessential motion.
- Images have stable dimensions and meaningful alternative text.
- Mobile image crops are intentional rather than automatic center crops.

Do not rely only on Chromium's `documentElement.scrollWidth`. Check `body.scrollWidth`, element bounds, and a Safari-sized viewport. Treat a visible horizontal browser scrollbar as a failure even when an automated assertion passes.

## Design review

Assess first-screen clarity, hierarchy, copy/image relationship, typography, color balance, component repetition, mobile rhythm, distinction between story and development surfaces, story specificity, and signs of generic template styling.

Record concrete observations. Do not describe a design as premium, cinematic, polished, or unique without pointing to visible evidence.
