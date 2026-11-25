# Component Map - Synthesis - 2026-11-25

Status: WORKING synthesis of the two 2026-11-25 GitHub component scans (Front Half, Back Half), folded into the Factory Blueprint Draft 01 layers. Rule applied throughout (Noa, 2026-11-25): components must be free for our use; anything with paid tiers, paid API dependencies, or company licenses is flagged and excluded from the chosen stack.
Method note: every repo named was verified by opening its GitHub page on 2026-11-25; stars and licenses are as shown that day. Full detail lives in the two scan files in this folder.

## The chosen stack, layer by layer

- Orchestration spine (runs the daily pipeline, retries, run history, gates as blocking steps): **Prefect** (24,241 stars, Apache-2.0, free). Directly answers our held-slate failures: a stage that cannot run is visible and retried, not silently lost.
- Layer 0, peer harvest (S1): **yt-dlp** (210,667 stars, Unlicense, free), run from a home IP because YouTube bot-walls cloud IPs. Covers IG/YouTube/TikTok mirrors for medians, outliers, comments, subtitles. Facebook-native peers remain the blind spot (no free component fixes it; the Neo scraper route is still the candidate build).
- Layer 0, fresh signals (S4): **Huginn** (50,639 stars, MIT, free, no paid tier) as always-on monitoring agents with a daily digest; **changedetection.io** core is free (its optional paid SaaS is not used).
- Layer 0/2, primary shelf (S2): **Docling** (71,043 stars, MIT, free, fully local) converts the shelf (declassified PDFs, old books, papers) into structured, searchable Markdown. **Trafilatura** (7,173 stars, Apache-2.0, free) extracts clean, dated, attributed text from web sources for Research Cards.
- Layer 1/8, idea bank and Registry dedupe: **SemHash** (979 stars, MIT, free, local embeddings) for semantic dedupe of every new idea against everything ever published or banked; **text-dedup** (765 stars, Apache-2.0, free) SimHash/MinHash for near-exact text repeats; **videohash** (388 stars, MIT, quiet since 2022) treated as a pattern to vendor for perceptual video dedupe, not a living dependency.
- Layer 4, the gate: **promptfoo** (27,676 stars, MIT, free) turns the rubric into a runnable, backtestable eval suite instead of a document: candidate first lines scored the same way every time, and the suite re-run against outcomes at calibration.
- Layer 6, production: **WhisperX** (25,670 stars, BSD-2, free) forced-alignment word timings for the karaoke layer, doubling as the narration-vs-locked-script verification gate. **Remotion** stays our assembly tool with a flag: its license is free for individuals and small teams, with a paid company tier; we are inside the free tier, noted so it is never a surprise. **Kokoro** (free, local TTS) noted as a fallback voice route only; ElevenLabs remains the quality standard while credits last, and it is a paid service, so the factory treats narration credits as a metered input, not a component.
- Layer 7, scheduling: **Postiz** (42,400 stars, AGPL-3.0, free self-hosted) is the only verified component that could own scheduling and cross-posting outright; adopting it needs Meta developer-app approval when self-hosting. Not adopted yet; the facebook-cli route works and stays until the factory design says otherwise.
- Layer 9, measurement: **Metabase** (AGPL, free self-hosted tier) as a possible dashboard over our own reads; the Facebook Page analytics bridge itself has no component and stays our facebook-cli reads plus hand-built plumbing.

## Flagged, not chosen (cost rule)
- GPT Researcher (Apache code, but every run spends paid LLM/search API money). STORM and Vane/Perplexica: free only in specific local configurations (SearXNG plus local models, Ollama); usable later only in those configurations. Crawl4AI: library free, vendor cloud freemium; self-host only. n8n: fair-code, not open source; Prefect covers the need with a clean license. MoneyPrinterTurbo: verified in the back-half scan as a reference for assembly patterns, not adopted (its output shape is the generic AI-slop shape we are designing against).

## What does not exist and must be built by us
1. The on-this-day engine (source S3): no component anywhere on GitHub. A dated events table from the RV/AP record plus a daily lookup. Also the simplest build in the factory.
2. The calibration loop (Layer 9's core): no maintained open-source tool predicts short-form performance or re-fits a rubric to real outcomes. promptfoo gives the eval harness; the loop logic is ours.
3. The hook library as software (Layer 3): beyond prompt packs, there is no maintained hook-generation tool. The library stays ours, grown from harvested teardowns, the borrowed hook banks from the first scan, and STORM's perspective-question method as a technique.
4. The Facebook-native peer harvest: unchanged blind spot from the first scan; candidate route is the scraper running on the Neo (which has Chrome), still unbuilt.

## Dead ends recorded so they are not re-evaluated
pytrends (archived), snscrape (dead since 2023), news-please (archived). Details and the one 404 candidate are in the front-half scan file.

## Effect on the blueprint
Draft 01's build order stands, with components now named: step 1 registries use SemHash/text-dedup checks; step 2 source engines start with Docling on the shelf (S2) and our own on-this-day table (S3); the gate (step 3) is implemented as a promptfoo suite; the daily run (step 4) sits on Prefect; production verification (step 4) uses WhisperX timings. The one-week dry run remains the acceptance test for the whole machine.
