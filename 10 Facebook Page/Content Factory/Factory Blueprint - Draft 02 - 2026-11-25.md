# Factory Blueprint - Draft 02 - 2026-11-25

Status: WORKING. Draft 02 folds the Component Map synthesis and the External Model Review (Grok Bot workflow) into Draft 01. The layer stack is unchanged; what changed is that the parts are now named, the gate is sharper, and the learning loop is stricter. Noa approved continuing the build on 2026-11-25 ("keep building the factory, and refining as we go"). Posting remains paused until the dry run passes and Noa lifts it.

## Changes from Draft 01
1. Components named per layer (all free; see Component Map - Synthesis - 2026-11-25.md): Prefect runs the daily pipeline; yt-dlp harvests peers from a home IP; Docling converts the primary shelf; Trafilatura extracts web sources; Huginn watches fresh signals; SemHash and text-dedup guard uniqueness; promptfoo implements the gate as a testable suite; WhisperX supplies karaoke timings and the narration check.
2. The gate gains a saturation modifier (from the external review): after the /100 score, apply saturation at topic level. Niche-saturated topic (the Egypt pattern: the feed is full of it and nothing distinguishes ours): minus 10 and a note. A story a giant peer already owns outright in our niche: kill regardless of score.
3. Research Cards adopt the claim scorecard: every load-bearing claim labeled ACCURATE, OVERSTATED, MISLEADING, HYPE, or THEIR WORDS, with a one-line reason and the source. No draft before the scorecard exists.
4. Artifacts are claims: card art, on-screen text, captions, and tables pass the same fact-check as scripts before banking. (Our Miss Z card art carried an invented date; his table shipped a wrong status. Same failure, same fix.)
5. Layer 3 angle sets gain a third named form: the correction (the honest gap between the hype and the record), beside the question form and the paradox form.
6. Layer 9 tightened: every published piece gets a predicted range (views, saves) logged in its bank file at publish time, before numbers move; actuals are read at 48 hours and 14 days; calibration runs weekly, and it proposes weight changes to Noa, never applies them itself.
7. The daily run is silent by default: Noa receives the survivor list and, on days with no survivors, one end-of-day line. No digests of the funnel.

## The gate, v2 (fixed until calibration says otherwise)
Base rubric /100: hook 25, one-line paradox 20, checkable record 15, surviving anchor 15, lesser-known factor 15, save/send triggers 10. Then the saturation modifier. Produce at 70+, rework once at 55 to 69, kill below 55. Every verdict logged in the scoring log with the source template named and the first line written out.

## Build order, with status
1. Registries and working files (Idea Bank, Research Card template, Registry seeded with everything published or banked). DONE with Draft 02, files in this folder.
2. Source engines S2 (Docling on the shelf) and S3 (on-this-day table, our own build), then S5 (community questions), then the S1 Neo scraper route, then S4 (Huginn), S6, S7, S9.
3. The gate as a promptfoo suite over the scoring log.
4. Production and scheduling reconnected under Prefect; the paused slate job rewritten to pull only gate-passed, Noa-approved pieces.
5. The learning loop: prediction logging, scheduled actuals checks, weekly calibration proposals.
6. One-week dry run, posting still paused: a week of banked, scored pieces, judged cold by Noa before anything ships.

## Still open (Noa's calls, unchanged from Draft 01)
Daily output target when posting resumes; formats in scope for v1; approval depth (topics only or scripts too); Practice Room inside the factory or separate; how much of the funnel Noa sees (Draft 02 assumes survivors plus one line, per change 7, until he says otherwise).
