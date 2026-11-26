# External Model Review - The Grok Bot Workflow - 2026-11-25

Status: WORKING review, planning input only. Source: an X article Noa pasted on 2026-11-25 (author: founder of Pinli and Weekbird), describing a one-person viral-content system built with a Grok bot for AI/science news on X. Noa's question: is any of this useful for the Content Factory?
Short answer: yes. It is the same architecture as Blueprint Draft 01, arrived at independently, with four mechanisms our draft lacks and one discipline stated better than ours. It also carries limits that matter: it is a real-time news system on X fitted to a tiny sample, and most of its transfer value is in its checks, not its cadence.

## What transfers (adopt into Draft 02)
1. Saturation as a scored factor. His model scores saturation inverted (a giant account already owning the story kills the lead) with a hard penalty at the bottom. Our rubric has no saturation term, yet Noa's own Egypt judgment is a saturation call. Add a saturation modifier to the gate: topic-level for us (has the niche done this to death) rather than his hour-level version.
2. Prediction logged before the numbers move. Every post gets a written estimate with a range at posting time, a scheduled check reads the actuals, and a weekly calibration routine refits the model and proposes weight changes for the human to approve, never auto-applies. Our Layer 9 said monthly calibration with no per-piece prediction. Upgrade: per-piece predicted range logged in the bank file at publish, weekly calibration, weight changes proposed to Noa only.
3. The claim scorecard. Per-claim verdict labels (ACCURATE / OVERSTATED / MISLEADING / HYPE / THEIR WORDS) with a one-line reason and the exact source, produced before any draft. This sharpens our Research Card honesty note into a per-claim discipline. Adopt the labels.
4. Artifacts pass the same fact-check as text. His table shipped a wrong verification status and his video mismatched the post's numbers; both were caught in review, and his fix was to fact-check images and tables too. We have already been bitten the same way (an invented prop date in the Miss Z card art). Rule for the factory: card art, on-screen text, and captions are claims and get checked like claims.
5. Silence by default. His scan speaks only when something clears the bar, plus one line at day's end if nothing did. Adopt for the daily run: Noa sees survivors and one end-of-day line, never a digest of everything scanned.
6. The correction angle. His strongest recurring finding: in hype-heavy news, the honest correction is the angle ("it still does not break RSA"). Add "the correction" as a named angle type in Layer 3 beside the question form and the paradox form. It fits our honesty beat and the Plain Account standard.

## What does not transfer
- Cadence and velocity. Five scans a day, momentum in posts per hour, a 24 to 48 hour window: that is X news physics. Our surface is a Facebook Page mining an evergreen record; our scan is daily, our harvest weekly, and saturation for us is measured in months of niche repetition, not hours.
- The follower snapshot report. X-specific mechanics; our follower movement already comes from Page insights in the daily research run.
- The estimate formula's precision. His log-linear fit is anchored on essentially one outlier and a handful of posts, and by his own account it runs 3 to 5x hot. The discipline (log it before, check it after, refit weekly) is the value; the coefficients are not evidence. Our rubric has the same small-sample risk (one proven breakout), so our predictions stay ranges, wide ones.
- His proof point is thin. The 3.1M anchor post predates the system; the system's first real test is one post at 62k in six hours. Good discipline, unproven machine. We should read it the way we read our own Dream Book numbers: a shape worth copying, not a result worth expecting.

## What it validates in Draft 01
The layer order (scan, score, verify, angle, draft, artifact, measure) matches ours. The human keeps the angle choice and the publish button, which matches Noa's gates. Dedupe against his own recent posts matches our Registry. Skills holding procedures while memory holds context matches how the factory's files are separated from standing rules.

## Changes queued for Blueprint Draft 02
1. Gate gains a saturation modifier (topic-level, niche repetition).
2. Layer 9 becomes: per-piece prediction at publish, scheduled actuals check, weekly calibration proposing weight changes to Noa.
3. Research Cards adopt the five claim labels; artifacts are fact-checked as claims.
4. Daily run adopts silence by default (survivors plus one end-of-day line).
5. Layer 3 angle set gains the correction as a named third form.
