# Component Scan - Back Half - 2026-11-25

Scope: reusable GitHub components for the back half of the Seeds content factory (Layers 4 to 9 plus cross-cutting orchestration and quality gates). Method: web and GitHub search, then every repo below was verified by opening its GitHub page on 2026-11-25; star counts and licenses are as shown on the page that day. Nothing was installed, built, or run. This scan complements the earlier front-half scan and does not repeat its repos.

## Layer 4: Scoring, gating, calibration

### promptfoo/promptfoo
- URL: https://github.com/promptfoo/promptfoo
- Stars: 27,676. License: MIT. Activity: very active (10,805 commits, 434 releases, not archived).
- What: a CLI and library for evaluating LLM outputs with declarative configs, deterministic and model-graded assertions, and side-by-side comparisons.
- Use for us: turn the Layer 4 rubric into a runnable eval suite. Each candidate hook, script, and caption becomes a test case; rubric criteria (hook strength, paradox, record check, anchor, save/send triggers) become assertions, some deterministic (character caps, question format, no em dashes) and some model-graded. Run the same suite against our published back-catalog to calibrate: pieces that actually broke out should score high, the flat-band pieces should not, and any rubric version that fails that backtest gets re-weighted before it gates anything new. Its CI mode also gives us a pass/fail gate in the pipeline rather than a score in a spreadsheet.

## Layers 5 and 6: Production

### harry0703/MoneyPrinterTurbo
- URL: https://github.com/harry0703/MoneyPrinterTurbo
- Stars: 145,666. License: MIT. Activity: very active (1,292 commits, 24 releases).
- What: an end-to-end short-video pipeline: topic in, LLM script, stock or generated footage, TTS narration, subtitles, music, finished 9:16 video out, with WebUI, API, and CLI, and stage checkpoints (`--stop-at` per stage).
- Use for us: not as our renderer (our Remotion compositions carry the house style), but as the reference architecture for the production stage and a fallback assembler. Its stage list (script, terms, audio, subtitle, materials, video) maps one-to-one onto our Layer 5/6 steps, its provider-pluggable TTS layer (Edge TTS, ElevenLabs, Kokoro, and others behind one interface) is the pattern to copy so narration providers can be swapped without rebuilding the pipeline, and its batch mode (several variants of one topic, pick the best) is a concrete model for variant generation at the gate.

### remotion-dev/remotion
- URL: https://github.com/remotion-dev/remotion
- Stars: 75,688. License: custom Remotion license (free for individuals; a company license is required in some cases, per the repo's own license note). Activity: extremely active (42,368 commits, 706 releases).
- What: make videos programmatically with React; compositions are parameterized by data and rendered in batch via Node APIs.
- Use for us: already our assembly layer. The verified point for the factory design is its dataset-render pattern: one composition plus a JSON dataset renders the whole slate, which is exactly how the card and Reel templates should consume the registry and the day's approved scripts. License caveat to settle at planning time: confirm the Page's use stays inside the free tier before the factory depends on it commercially.

### m-bain/whisperX
- URL: https://github.com/m-bain/whisperX
- Stars: 25,670. License: BSD-2-Clause. Activity: active (572 commits, 44 releases; a 2026 context-aware batching update is announced on the page).
- What: fast Whisper transcription with wav2vec2 forced alignment, giving accurate word-level timestamps (plus optional speaker diarization).
- Use for us: the karaoke timing engine. Our caption rule needs the spoken word highlighted on its real boundary, full sentences on one baseline; WhisperX's aligned word timings are the input our Remotion caption layer consumes, replacing estimated timings with measured ones. It also serves as the verification pass on narration: transcribe the generated voiceover and diff it against the locked script, so a swallowed or altered line fails the quality gate before render.

### hexgrad/kokoro
- URL: https://github.com/hexgrad/kokoro
- Stars: 10,368. License: Apache-2.0 (code and weights). Activity: active (repo created January 2025, 71 commits).
- What: Kokoro-82M, a small open-weight text-to-speech model with 54 voices across 8 languages, fast and cheap enough to run locally.
- Use for us: the zero-marginal-cost narration fallback and draft voice. Narration credits are our scarcest production cost (the 2026-11-25 analysis: 1,890 credits bought about 585 views on the Practice Room set). Kokoro voices can narrate scratch cuts, timing tests, and Practice Room drafts locally, reserving ElevenLabs spend for gate-passing final pieces; its voice set includes Bella and Sarah namesakes, though timbre will differ from the ElevenLabs voices and final pieces stay on the proven voices until a Kokoro read passes Noa's ear.

### Zulko/moviepy
- URL: https://github.com/Zulko/moviepy
- Stars: 15,206. License: MIT. Activity: maintained (v2.x current; page notes v1 is unmaintained).
- What: video editing with Python: cuts, concatenation, compositing, titles, and effects, over ffmpeg.
- Use for us: the utility knife around the Remotion core: trimming generated clips to narration length, loudness and format pre-processing, quick one-off composites (watermark burn, end cards) that do not justify a new composition, and the FB-encode step (size-capped re-encodes) as scripted, repeatable steps in the daily run.

### smacke/ffsubsync
- URL: https://github.com/smacke/ffsubsync
- Stars: 7,960. License: MIT. Activity: maintained (467 commits, releases current).
- What: language-agnostic automatic synchronization of subtitles with video audio, using voice activity detection and FFT alignment.
- Use for us: a quality gate, not a caption generator. After a Reel is assembled, run ffsubsync against the caption file and the final audio: a measurable offset means the karaoke timings drifted and the piece fails the gate instead of shipping with captions that lag the voice. Cheap, scriptable, and it turns "captions look synced" into a number.

### chjm-ai/tiktok-karaoke-captions
- URL: https://github.com/chjm-ai/tiktok-karaoke-captions
- Stars: 2. License: MIT (per its LICENSE file and README; GitHub metadata shows NOASSERTION). Activity: new and tiny (9 commits, created May 2026).
- What: burns TikTok-style per-word karaoke captions plus a persistent headline banner into a video in one ffmpeg pass, with script forced-alignment so displayed text comes from your script verbatim while timing comes from Whisper.
- Use for us: a design reference, not a dependency. Two of its ideas are directly ours: script-aligned captions (our scripts are locked before narration, so on-screen text should never be a transcription guess) and the persistent headline banner (our hook burned in over the first seconds). It is macOS Apple Silicon only and effectively unproven, so we borrow the pattern into our own Remotion/ffmpeg steps rather than adopt the tool.

## Layer 7: Scheduling and publishing

### gitroomhq/postiz-app
- URL: https://github.com/gitroomhq/postiz-app
- Stars: 42,400. License: AGPL-3.0. Activity: very active (3,715 commits, 205 releases).
- What: a self-hostable social media management platform: scheduling, calendar, cross-posting, analytics, public API, and an MCP server and CLI built for AI agents, covering Facebook, Instagram, Threads, TikTok, YouTube, X, and more.
- Use for us: the strongest Layer 7 candidate if we ever outgrow the facebook-cli route. The factory's approved slate could be handed to Postiz over its API or MCP and it would own the calendar, the per-platform variants, and the retry queue, while its analytics feed Layer 9. Two honest costs: self-hosting means creating our own developer app per platform and going through Meta approval (weeks, per its own comparison table), and AGPL is copyleft, fine for internal use but a real consideration if any factory tooling is ever distributed.

### inovector/mixpost
- URL: https://github.com/inovector/mixpost
- Stars: 3,963. License: MIT (this repo is Mixpost Lite). Activity: maintained but slower (397 commits, 29 releases; Lite 2.6.0 shipped March 2026).
- What: a self-hosted social media scheduler on Laravel, with calendar, media library, post versions, templates, queues, and basic analytics.
- Use for us: the permissive-license alternative to Postiz, and its Lite edition does cover Facebook Pages, which is the one channel the factory publishes to. Its media library and post-version concepts are also a good model for our bank. Limits: Instagram, Threads, and the API/MCP server sit in the paid Pro edition, and the Lite repo's cadence is visibly slower than Postiz's, so it is the fallback, not the lead.

## Layer 8: Registry and duplicate detection

### akamhy/videohash
- URL: https://github.com/akamhy/videohash
- Stars: 388. License: MIT. Activity: low (228 commits; PyPI releases stalled in 2022). Included because it is uniquely on-target.
- What: perceptual video hashing: any video gets a 64-bit hash that stays the same or near under resizing, transcoding, watermarking, cropping, and color changes, so near-duplicate videos are found by Hamming distance.
- Use for us: the registry's video fingerprint. Every produced Reel gets hashed at bank time and the hash stored beside its registry row; before a "new" piece is scheduled, its hash is compared against the registry, catching accidental re-renders, re-uploads of the same cut, and near-identical remakes even after the FB re-encode changes the bytes. Low maintenance is the risk; the algorithm is small and stable, so vendoring the method is realistic if the package rots.

### ChenghaoMou/text-dedup
- URL: https://github.com/ChenghaoMou/text-dedup
- Stars: 765. License: Apache-2.0. Activity: stable reference implementation (397 commits, benchmarked).
- What: an all-in-one text deduplication toolkit: MinHash plus LSH and SimHash for near-duplicates, suffix-array and Bloom filter for exact duplicates, config-driven, with published benchmarks.
- Use for us: the registry's text fingerprint, the other half of duplicate control. Hooks, first lines, scripts, and captions are the factory's real repetition risk (the same paradox wearing new words). SimHash over each banked script and caption, checked at idea intake and again at the gate, flags near-duplicate angles before production money is spent; its benchmarks (MinHash F1 0.95 on the CORE set) tell us which algorithm to start with.

## Layer 9: Measurement and learning

### metabase/metabase
- URL: https://github.com/metabase/metabase
- Stars: 50,530. License: AGPL-3.0 for the open-source edition (commercial editions in the same repo under a commercial license). Activity: extremely active (46,818 commits, 860 releases).
- What: open-source business intelligence: dashboards and questions over any SQL database, with alerts and scheduled dashboard subscriptions.
- Use for us: the Layer 9 dashboard over our own results store. The factory already produces the raw material (facebook-cli reads at 48 hours and 14 days, scores, templates, source engines); landed in a small Postgres or SQLite database, Metabase turns it into the standing views the calibration loop needs: score-versus-views scatter per rubric version, template leaderboard, source-engine yield, and the flat-band watch. Its alerts can flag the one event we currently find by hand: a published piece sitting near zero distribution hours later.

### growthbook/growthbook
- URL: https://github.com/growthbook/growthbook
- Stars: 8,659. License: MIT for the bulk of the code (open core; a few directories under a commercial enterprise license). Activity: active (5,028 commits, 59 releases).
- What: open-source feature flagging and experimentation platform with a serious stats engine (Bayesian, sequential, CUPED, bandits, SRM checks) that queries your own warehouse.
- Use for us: the experiment ledger for the factory's A/B questions: morning versus afternoon slots, question-form versus verdict-form first lines, caption ending with or without a viewer-life question. Each experiment gets defined metrics and a stats read instead of a vibe, and its experiment documentation (hypothesis, screenshots, meta fields) doubles as the decision record the weekly review currently rebuilds from scratch. Heavier than our current scale strictly needs; it earns its place when two or more format experiments run at once.

## Cross-cutting: Orchestration and quality gates

### PrefectHQ/prefect
- URL: https://github.com/PrefectHQ/prefect
- Stars: 24,241. License: Apache-2.0. Activity: very active (22,643 commits, 958 releases).
- What: a Python workflow orchestration framework: ordinary Python functions become scheduled, retried, cached, observable flows and tasks, with a self-hostable server and UI.
- Use for us: the best-fit spine for the daily run. The factory's steps are already Python-shaped (harvest, score, produce, verify, schedule, measure); Prefect gives each step retries with backoff (the Neo-unreachable and approval-timeout failures we keep hitting become handled states, not lost mornings), a run history that shows exactly which stage failed, and scheduling that replaces a pile of independent crons with one visible pipeline. Quality gates slot in as tasks that can block downstream steps: no publish task runs unless the sync check, dedupe check, and gate score tasks passed.

### n8n-io/n8n
- URL: https://github.com/n8n-io/n8n
- Stars: 212,117. License: Sustainable Use License (fair-code, not OSI open source; self-hosting for internal use is allowed, reselling as a service is not). Activity: extremely active (28,137 commits, 923 releases).
- What: a visual workflow automation platform with native AI steps and 1,500+ integrations, self-hostable.
- Use for us: the alternative spine, better if the factory's glue becomes mostly API calls between services (Postiz, ElevenLabs, Meta) rather than local Python. Its human-approval steps map neatly onto Noa's gates, and its template library is a source of working patterns. We rank it behind Prefect for us because our heavy steps (rendering, hashing, alignment) are local compute, not integrations, and because the license is source-available rather than open.

## Top 5 for us

1. m-bain/whisperX: it fixes the one input our signature format depends on, word timing, and doubles as the narration verification gate; BSD-licensed, proven, and it drops into the existing Remotion caption data shape.
2. PrefectHQ/prefect: the daily run is the factory's weakest current point (held slates, lost mornings, invisible failures); Prefect's retries, run history, and gate-as-task model answer exactly those failures, in Python, under Apache-2.0.
3. promptfoo/promptfoo: it turns the Layer 4 rubric from a document into a testable, backtestable suite, which is the difference between a scoring system and a scoring habit.
4. gitroomhq/postiz-app: the only verified component that could own Layer 7 outright, calendar, cross-posting, agent API, and analytics in one; held back from rank 1 only by the Meta developer-app approval cost of self-hosting.
5. akamhy/videohash plus ChenghaoMou/text-dedup (as a pair): together they give the registry teeth on both halves of the corpus, video and text, for the price of two small permissive libraries; uniqueness stops being a promise and becomes a check.

## Honest limits

- Layer 4 remains the thinnest layer. Beyond promptfoo's general eval harness, this scan found no maintained, credible open-source tool that predicts short-form video performance or calibrates a content rubric against real outcomes; the earlier scan's small repos (reels-analyzer class) are still the only purpose-built attempts, and they are young and lightly proven. The calibration loop will have to be built by us, on promptfoo-style evals plus our own results store.
- No verified component covers Facebook-native analytics ingestion. Postiz and Mixpost expose their own analytics, and Metabase can chart whatever we land in a database, but the bridge from Meta's Page data into that store remains our facebook-cli reads and hand-built plumbing; nothing on GitHub closes that gap for a single Page.
- Thumbnail and card generation as a distinct category was a dead end: the strong, maintained projects are the general renderers already listed (Remotion, MoviePy) plus design tools with no pipeline story. Our compose.py plus Remotion dataset-render pattern is, on this evidence, already the right shape.
- Two license cautions surfaced repeatedly: several headline tools are not MIT/Apache despite being "open source" in casual coverage (Postiz and Metabase are AGPL, n8n is fair-code, Remotion has its own license with a company tier). None of these block internal use, but each needs a deliberate note in the factory plan rather than a surprise later.
- Videohash and the karaoke-captions repo are included on fit, not on health: one is quiet since 2022, the other has 2 stars and 9 commits. Treat both as methods to vendor or copy patterns from, not as dependencies to lean on.
- Star counts are a snapshot from 2026-11-25 and move daily; MoneyPrinterTurbo's count in particular varies between sources (about 86k in one skill file, 145,666 on the repo page as opened). The repo page figure is the one reported here.
