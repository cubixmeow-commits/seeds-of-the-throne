# Component Scan, Front Half, 2026-11-25

Scope: reusable GitHub components for Layers 0 to 3 of the Content Factory (source engines, idea capture and dedupe, research, angle and hook development). Method: discovery searches across GitHub and the web, then every repo listed below was verified by opening its GitHub page in-session on 2026-11-25; stars, license, and archived status are the figures on the page that day. Planning only: nothing was installed, built, or run. The earlier scan's twelve repos are not repeated here.

Cost rule (Noa, 2026-11-25): every component must be FREE for our use. Each entry carries a cost note. "Free software, paid running cost" means the code is open source but the tool only works when fed a paid API (usually an LLM); those are flagged, and none of them appear in the Top 5.

---

## Layer 0, Source Engines

### yt-dlp/yt-dlp
- URL: https://github.com/yt-dlp/yt-dlp
- Stars: 210,667. License: Unlicense. Archived: no. Created 2020-10-26; 24,070 commits; actively released (139 releases).
- What: feature-rich command-line downloader and metadata extractor for YouTube, Instagram, TikTok, and thousands of other sites.
- Use for us: the harvest backbone for peer mirrors. Flat playlist pulls (titles plus view counts) give us peer medians and outlier multiples; `--write-comments` and subtitle pulls feed teardowns. This is the tool the first harvest already ran on.
- Cost: FREE. Unlicense, no API key, no paid tier. Operational caveat, not a cost: YouTube bot-walls full extraction from cloud IPs ("Sign in to confirm you're not a bot"); run it from the Neo or a home IP.

### huginn/huginn
- URL: https://github.com/huginn/huginn
- Stars: 50,639. License: MIT. Archived: no. Created 2013-03-10; 4,362 commits.
- What: self-hosted agent system ("a hackable IFTTT on your own server"): agents watch RSS feeds, scrape websites, detect changes and peaks, and emit digests and alerts.
- Use for us: the fresh-signal monitoring automation (blueprint S4). Standing agents watch the ministry and Egyptology announcement pages, journal feeds, and niche news sources, and deliver one daily digest into the idea bank instead of scattered manual checks.
- Cost: FREE. MIT, self-hosted, no paid tier exists. Server cost is ours alone (it runs on the VM or the Neo).

### DIYgod/RSSHub
- URL: https://github.com/DIYgod/RSSHub
- Stars: 47,336. License: AGPL-3.0 per the repo-details block. Archived: no. Created 2018-04-02; 20,717 commits.
- What: generates RSS feeds for thousands of sites that do not offer them, with routes for YouTube, Instagram, Twitter, Telegram, and many news and announcement sites.
- Use for us: feed plumbing for Layer 0. Any source the factory wants to watch that lacks a feed (peer channels, announcement pages, subreddit-adjacent sources) becomes a feed Huginn or FreshRSS can consume.
- Cost: FREE for self-hosted use. License flag: the repo-details block says AGPL-3.0 while an older cached README copy said MIT; treat AGPL-3.0 as governing. AGPL is fine for our internal self-hosted use; it only bites if we offered it as a public network service.

### FreshRSS/FreshRSS
- URL: https://github.com/FreshRSS/FreshRSS
- Stars: 16,674. License: AGPL-3.0. Archived: no. Created 2012-10-21; 7,646 commits.
- What: self-hosted RSS aggregator with WebSub push updates and basic XPath scraping for sites without feeds.
- Use for us: optional monitoring inbox, the human-readable river of every watched source, if we want a reading surface separate from Huginn's automation. Overlaps RSSHub plus Huginn; adopt only if the digest alone feels blind.
- Cost: FREE. AGPL-3.0, self-hosted, no paid tier.

### dgtlmoon/changedetection.io
- URL: https://github.com/dgtlmoon/changedetection.io
- Stars: 36,034. License: Apache-2.0. Archived: no. Created 2021-01-27; 2,815 commits, 229 releases.
- What: website change detection with visual diffing, keyword triggers, and scheduled watches; can monitor PDFs and JSON as well as pages.
- Use for us: watch the small set of pages where a change IS the signal: CIA reading-room and Star Gate release listings, DIA FOIA pages, journal tables of contents, museum collection pages for our anchor objects. A diff alert becomes a dated idea-bank deposit.
- Cost: FREE for self-hosted use (Apache-2.0). Flags: the vendor sells an optional hosted SaaS (about $8.99/month) which we do not need; its optional AI change summaries use your own LLM key, so leave that feature off to stay at zero cost. Core change detection is fully free.

### fhamborg/news-please, ARCHIVED, dead end
- URL: https://github.com/fhamborg/news-please
- Stars: 2,491. License: Apache-2.0. Archived: YES, the repo is a public archive, read-only and unmaintained.
- What: news crawler and article extractor with CommonCrawl CC-NEWS access.
- Verdict: do not build on it. Recorded here because it surfaces in every "news monitoring" search; its CommonCrawl news-archive idea is sound, but the living route to that data is CommonCrawl directly plus trafilatura (Layer 2), not this repo.
- Cost: free code, but dead. Excluded on maintenance, not price.

### flack0x/trendspyg
- URL: https://github.com/flack0x/trendspyg
- Stars: 68. License: MIT. Archived: no. Created 2025-11-03; 26 releases, current v1.9.0.
- What: maintained Google Trends library and CLI (trending now, interest over time, related queries, YouTube and News search interest), with an MCP server; the working successor to pytrends.
- Use for us: a light trend check at the angle stage: is search interest in "remote viewing," "astral projection," or a case name rising, flat, or spiking this week? Useful seasoning for scheduling, never a topic source by itself.
- Cost: FREE. MIT, no API key. Caveats: very young and small (included because it is the only maintained Trends client found; GeneralMills/pytrends is archived as of April 2025 and its trending calls are broken by Google 429s). Its Explore path drives a browser and is rate-limit sensitive; the RSS path is the safe one. Google's official Trends API is still a limited, application-gated alpha.

### praw-dev/praw
- URL: https://github.com/praw-dev/praw
- Stars: 4,307. License: BSD-2-Clause. Archived: no. Created 2010-08-19; 4,628 commits, current releases in 2026.
- What: the standard Python wrapper for Reddit's official API.
- Use for us: community question mining (blueprint S5): pull top and rising threads from r/remoteviewing and r/AstralProjection, extract the recurring beginner questions and the claims people argue about, and deposit them as question-form idea candidates.
- Cost: FREE. BSD-2-Clause; Reddit API access for a registered script app is free within rate limits. Access flag, not a cost: Reddit now requires registering the app and following its API terms; plan a one-time setup. Note the old scraping route is dead: JustAnotherArchivist/snscrape's last commit was June 2023 and its Reddit modules call the defunct Pushshift API. Do not use it.

### egbertbouman/youtube-comment-downloader
- URL: https://github.com/egbertbouman/youtube-comment-downloader
- Stars: 1,279. License: MIT. Archived: no. Created 2015-08-31; 84 commits, 18 releases.
- What: downloads YouTube comments to JSONL or CSV with no YouTube API key, sortable by popular or recent.
- Use for us: comment mining on peer outlier videos (the other half of S5). The questions and objections in the comments of a 34x outlier are angle material: each recurring question is a candidate first line.
- Cost: FREE. MIT, no API key, no paid tier.

### jdepoix/youtube-transcript-api
- URL: https://github.com/jdepoix/youtube-transcript-api
- Stars: 8,662. License: MIT. Archived: no. Created 2018-04-20; 419 commits, 36 releases.
- What: fetches YouTube transcripts and subtitles (including auto-generated) from Python or CLI, no API key and no headless browser.
- Use for us: teardown input. The transcript of a peer outlier gives us its first spoken line, beat order, and runtime shape for the hook library, without downloading video. Serves Layer 0 harvesting and Layer 2 teardown.
- Cost: FREE (MIT) in normal use. Flag: the README itself warns that cloud-provider IPs get blocked and recommends paid rotating residential proxies (Webshare) as the workaround. We avoid that cost entirely by running it from the Neo or home connection, the same fix as yt-dlp.

### jjjake/internetarchive
- URL: https://github.com/jjjake/internetarchive
- Stars: 1,933. License: AGPL-3.0. Archived: no. Created 2012-08-15; 2,369 commits, 71 releases.
- What: the `ia` command-line tool and Python module for archive.org: search, metadata, and download of texts, scans, and collections.
- Use for us: the primary-texts engine (blueprint S2). Scripted pulls of the old shelf: Muldoon (1929), Dunne (1927), Van Eeden (1913), SPR Proceedings, and public-domain RV and AP literature, straight into the research shelf with identifiers recorded for the Registry.
- Cost: FREE. AGPL-3.0 tool; archive.org itself is free. Security note from its own README: use v5.5.1 or later (earlier versions had a directory-traversal flaw in downloads).

### ocrmypdf/OCRmyPDF
- URL: https://github.com/ocrmypdf/OCRmyPDF
- Stars: 35,403. License: MPL-2.0. Archived: no. Created 2013-12-20; 4,651 commits, 69 releases.
- What: adds a searchable OCR text layer (Tesseract) to scanned PDFs, preserving the original images.
- Use for us: digitizing the scanned half of the primary shelf: SPR Proceedings scans, declassified Star Gate PDFs that are image-only, old journal scans. OCR output feeds Docling conversion and full-text search. Serves Layers 0 and 2.
- Cost: FREE. MPL-2.0 (weak copyleft on the tool's own files only; our use is unaffected). Runs fully local, no API.

### docling-project/docling
- URL: https://github.com/docling-project/docling
- Stars: 71,043. License: MIT. Archived: no. Created 2024-07-09; 2,016 commits, 244 releases.
- What: IBM's document conversion toolkit: PDF, EPUB, Office, images, and more to clean Markdown or JSON, with layout, reading order, table structure, and built-in OCR for scanned documents; runs locally; ships an MCP server and LangChain, LlamaIndex, CrewAI, and Haystack integrations.
- Use for us: the standard intake converter for Layer 2. Every primary text, declassified document, or paper that enters the research shelf passes through Docling once and becomes searchable, chunkable Markdown with structure intact, ready for a Research Card.
- Cost: FREE. MIT, local execution, no API key, no paid tier. (Its GraniteDocling vision model is optional; the standard pipeline needs nothing paid.)

### booknlp/booknlp
- URL: https://github.com/booknlp/booknlp
- Stars: 951. License: MIT. Archived: no. Created 2021-11-22; this mirror shows only 7 commits and no releases.
- What: NLP pipeline built for book-length texts: entity recognition, character clustering and coreference, quotation attribution, event and supersense tagging.
- Use for us: mining long primary texts for structure: who did what, in what order, with which attributed quotes. On a text like Sinclair's Mental Radio it would extract the experiment sequence and the named witnesses, the skeleton of a Research Card.
- Cost: FREE (MIT, local models). Flag: maintenance looks thin (few commits, no releases on this mirror), so treat it as an optional experiment, never a load-bearing step. The factory's book mining works without it; Docling plus the research layer covers the core need.


---

## Layer 1, Idea Capture, Dedupe, and the Registry

### MinishLab/semhash
- URL: https://github.com/MinishLab/semhash
- Stars: 979. License: MIT. Archived: no. Created 2024-10-13; 71 commits, 11 releases.
- What: fast semantic deduplication and filtering using local Model2Vec embeddings, including cross-dataset dedupe (check a new set against a reference set) and multi-column records.
- Use for us: the Registry's dedupe gate, and the single best fit in this layer. Every new idea is deduped against the full Registry of everything ever made or banked before it enters the Idea Bank; near-duplicates surface with their similarity scores so a human (or the gate) decides whether the angle is genuinely new. Its cross-dataset mode is exactly "new candidates versus everything we have already done."
- Cost: FREE. MIT; embeddings are computed locally by Model2Vec, no API key, no per-call cost, works offline.

### ChenghaoMou/text-dedup
- URL: https://github.com/ChenghaoMou/text-dedup
- Stars: 765. License: Apache-2.0. Archived: no. Created 2021-03-13; 397 commits.
- What: all-in-one text deduplication toolkit: MinHash plus LSH, SimHash, suffix-array substring dedupe, and bloom-filter exact dedupe, config-driven, with published benchmarks.
- Use for us: the cheap first pass under SemHash. Exact and near-exact duplicate detection (same fact harvested twice, same question mined from two subreddits) at the text level, before semantic dedupe spends effort. Also useful inside the research shelf to catch the same document arriving from two sources.
- Cost: FREE. Apache-2.0, fully local, no paid tier.

### huggingface/sentence-transformers
- URL: https://github.com/huggingface/sentence-transformers
- Stars: 19,307. License: Apache-2.0. Archived: no. Created 2019-07-24; 3,403 commits, 74 releases.
- What: the standard embeddings framework: sentence embeddings, semantic similarity and search, clustering, paraphrase mining, and reranking, with 15,000+ pretrained models.
- Use for us: the general similarity engine behind Layers 1 to 3. Cluster the Idea Bank to spot over-mined veins and empty territory; paraphrase-mine the research shelf for the same case described in different words; rerank candidate angles against the proven winner shapes. SemHash is the ready-made dedupe tool; this is the toolbox when we need custom similarity work.
- Cost: FREE. Apache-2.0; models download free from Hugging Face and run locally. No API key needed for local use.

### ArchiveBox/ArchiveBox
- URL: https://github.com/ArchiveBox/ArchiveBox
- Stars: 29,097. License: MIT. Archived: no. Created 2017-05-05; 10,982 commits.
- What: self-hosted web archiving: saves URLs as HTML, PDF, PNG, WARC, and extracted text in a SQLite-backed collection, with scheduled imports from feeds.
- Use for us: evidence preservation for Research Cards. When a card rests on a ministry announcement, a journal page, or a document listing, archive the source at capture time so the citation survives link rot and page edits. The Registry then points at our own snapshot, not just a live URL.
- Cost: FREE. MIT, self-hosted, no paid tier.

---

## Layer 2, Research: Idea to Verified Facts and an Angle

### assafelovic/gpt-researcher, FREE SOFTWARE, PAID RUNNING COST
- URL: https://github.com/assafelovic/gpt-researcher
- Stars: 30,906. License: Apache-2.0. Archived: no; 3,490 commits, 75 releases.
- What: autonomous deep-research agent: a planner, execution agents, and a publisher produce a cited report from web sources plus your local documents; ships an MCP server.
- Use for us: the Research Card drafter. Given an idea (a case, a date, a text), it assembles a sourced fact draft with citations for the human verification pass, and can ground on our own Docling-converted shelf through its local-document mode.
- Cost: NOT GENUINELY FREE TO RUN. The code is Apache-2.0 and free, but it is built around paid LLM and search APIs; every research run costs money unless it is reconfigured onto a local model, which its docs treat as a secondary path. Marked clearly per Noa's rule: adopt only with eyes open about per-run cost, or hold it as the design reference for a research step we run on tools already in the stack. Excluded from the Top 5 for this reason.

### stanford-oval/storm
- URL: https://github.com/stanford-oval/storm
- Stars: 31,952. License: MIT. Archived: no. Created 2024-03-24; latest release news January 2025 (knowledge-storm v1.1.0).
- What: Stanford's knowledge-curation system: it generates perspective-guided questions, simulates a conversation between a writer and topic experts grounded in retrieved sources, and produces an outlined, cited article. Supports grounding on user-provided documents and many retrievers, including SearXNG.
- Use for us: two jobs. Layer 2: turn a Research Card into an outlined, cited brief. Layer 3: its perspective-guided question asking is a genuine angle-finding method: the same case interrogated from a skeptic's, a practitioner's, and a historian's perspective yields three different angles, which is exactly the factory's "at least three angles per card" rule, mechanized.
- Cost: FREE SOFTWARE, RUNNING COST DEPENDS ON CONFIGURATION. MIT code; it needs an LLM and a retriever. Paired with our own SearXNG (free) and a local model via its LiteLLM support it can run at zero API cost; paired with a cloud LLM it costs per run. Flagged accordingly, and excluded from the Top 5 because the free configuration is the non-default one.

### ItzCrazyKns/Vane (formerly Perplexica), FREE SOFTWARE, LLM-DEPENDENT
- URL: https://github.com/ItzCrazyKns/Vane
- Stars: 38,312. License: MIT. Archived: no. Created 2024-04-09; 1,009 commits, 34 releases.
- What: self-hosted AI answering engine in the Perplexity style: SearXNG-powered web search plus an LLM, returning answers with cited sources; has an API, file upload Q&A, and speed, balanced, and quality search modes.
- Use for us: the quick verification desk. One-off fact checks during Research Card work ("when was this paper read to the SPR?", "where is this papyrus now?") with citations attached, faster than assembling a full GPT Researcher run.
- Cost: FREE SOFTWARE, RUNNING COST DEPENDS ON CONFIGURATION. MIT and self-hosted; with a local Ollama model it runs free, with a cloud provider (OpenAI, Claude, Groq) each answer costs API money. Same flag as STORM; excluded from the Top 5.

### searxng/searxng
- URL: https://github.com/searxng/searxng
- Stars: 39,862. License: AGPL-3.0. Archived: no. Created 2021-04-12; 9,908 commits.
- What: privacy-respecting metasearch engine aggregating many search services, with a JSON API; users are neither tracked nor profiled.
- Use for us: the search plumbing under the whole research layer. It is the retriever STORM explicitly supports, the engine Vane bundles, and a clean programmatic search endpoint for the factory's own scripts, replacing ad-hoc web searches with one logged, repeatable route. Serves Layers 0 and 2.
- Cost: FREE. AGPL-3.0, self-hosted, no paid tier. AGPL note as with RSSHub: fine for internal use.

### adbar/trafilatura
- URL: https://github.com/adbar/trafilatura
- Stars: 7,173. License: Apache-2.0 (current versions; pre-v1.8.0 was GPLv3+). Archived: no. Created 2019-04-08; 1,792 commits, 44 releases.
- What: benchmark-leading web text and metadata extraction: main text, title, author, and date from HTML, with crawling, sitemap and feed discovery, and CSV, JSON, Markdown, and XML output. Used by, among others, the Internet Archive and HuggingFace.
- Use for us: turning any web source (news article, journal page, announcement, blog post) into clean, dated, attributed text for a Research Card, with the publication date extracted rather than guessed. It is also the living replacement for news-please's extraction half.
- Cost: FREE. Apache-2.0, fully local, no API, no paid tier.

### unclecode/crawl4ai, FREE LIBRARY, PAID CLOUD EXISTS
- URL: https://github.com/unclecode/crawl4ai
- Stars: 87,880. License: Apache-2.0. Archived: no. Created 2024-05-09; latest release v0.9.6, 20 November 2026.
- What: LLM-friendly web crawler: renders JavaScript-heavy pages in a real browser and returns clean Markdown or structured JSON extracted against a schema.
- Use for us: the heavy lifter for sources trafilatura cannot read: JavaScript-walled archives, dynamic listings, and pages where we need specific fields (dates, view counts, catalog entries) extracted into a schema for the harvest table.
- Cost: THE LIBRARY IS FREE; THE VENDOR'S CLOUD IS FREEMIUM. Self-hosted Crawl4AI is Apache-2.0 and costs nothing. The same project now sells a hosted cloud (1,000 free credits a month, then paid) and its README leads with it. Rule for us: self-host the library only, never the cloud API. Also flagged: its LLM-extraction mode needs your own LLM key; its CSS and schema extraction modes do not. Included with this flag rather than in the Top 5, because the project's center of gravity is moving toward the paid cloud.

---

## Layer 3, Angle Development and Hooks

Honest summary first: this is the thinnest layer on GitHub. Beyond the prompt and skill packs the earlier scan already covered, there is no substantial, maintained hook-generation software to adopt. What exists and is reusable:

### stanford-oval/storm (see Layer 2)
Its perspective-guided question generation is the strongest angle-development method found in either scan: angles as interrogated perspectives, each grounded in retrieved sources, rather than angles as free association. Filed in Layer 2 above with its cost flag.

### matt-j-penny/ai-video-marketing (hook-generator skill)
- URL: https://github.com/matt-j-penny/ai-video-marketing
- Stars: 9. License: MIT. Archived: no. Created 2026-09-07; 32 commits, no releases.
- What: a pack of agent skills for video marketing. The relevant one: `content-writing/hook-generator`, which writes 6 to 8 spoken hooks per idea from a bank of 404 hooks scraped from top reels, each tagged by structure, framework, source, and view count. Sibling research skills rank competitors' recent posts by breakout score.
- Use for us: a second hook bank to cross-pollinate ours. Our hook library (built in System v1 from the rediumvex database and our own teardowns) is the primary; this repo's 404-hook bank, tagged by structure and views, is a cheap way to widen the formula set and check our templates against an independently gathered corpus.
- Cost: FREE for the hook-generator skill itself (MIT markdown). Flags: the repo is tiny and young (9 stars), so treat it as a borrowable asset, not infrastructure; several sibling skills depend on paid services (Deepgram, vidIQ, Apify), which we would not use. Only the hook bank and generator transfer.

### huggingface/sentence-transformers (see Layer 1)
Paraphrase mining and clustering double as angle tools: cluster the mined community questions to find the five questions everyone asks (angle supply), and similarity-rank drafted first lines against the proven winner shapes before they reach the gate.

### Not found as a repo: the People Also Ask route
Question-tree mining from Google's People Also Ask box would suit S5 well, and a small Node CLI for it (josefresco/people-also-ask) is described in its author's write-ups, but the GitHub URL returned a 404 when opened in this session, so per the verify-by-opening rule it is not reported as a finding. The capability gap is real but small: PRAW plus YouTube comments cover community questions from primary sources, which are better evidence than Google's box anyway.

---

## Top 5 for Us (all genuinely free, no paid dependency)

1. **yt-dlp** (Layer 0). The harvest backbone: peer medians, outliers, comments, and subtitles from the platforms peers actually post on. Unlicense, no key, no tier. Only rule: run it from a home IP, not the cloud VM.
2. **Docling** (Layers 0 and 2). One local converter for the entire primary shelf: declassified PDFs, old books, and papers become structured Markdown once, forever searchable. MIT, fully local, nothing paid behind it.
3. **SemHash** (Layer 1). The Registry dedupe gate in a box: cross-dataset semantic dedupe of every new idea against everything ever made, running on local embeddings at zero per-call cost. MIT. This is the component that makes "unique content every day" enforceable rather than aspirational.
4. **Huginn** (Layer 0). The always-on fresh-signal watch: self-hosted agents that monitor announcement pages and feeds and deliver one digest, replacing manual checking. MIT, no paid tier exists.
5. **Trafilatura** (Layer 2). Clean, dated, attributed text from any web source, benchmark-proven and fully local. Apache-2.0. It is what turns a found page into Research Card material without an API bill.

Runners-up, also free: changedetection.io (watch pages where a change is the signal), PRAW and youtube-comment-downloader (community question mining), the `ia` tool (archive.org pulls), OCRmyPDF (scanned-document layer), ArchiveBox (source preservation).

Held back by Noa's cost rule: GPT Researcher, STORM, and Vane are strong tools whose code is free but whose default operation spends paid LLM API money; Crawl4AI's library is free but its vendor cloud is freemium. Any of them can be revisited if we deliberately budget API spend or standardize on a local model; none should be adopted silently.

---

## Honest Limits

- **No on-this-day component exists.** No repo in either scan offers an anniversary or record-calendar engine. Blueprint source S3 (anniversaries of sessions, publications, declassifications) has no off-the-shelf part; it is a small build of our own: a dated table of record events plus a daily lookup. The good news: it is the simplest component in the whole factory.
- **Layer 3 is thin.** Hook and angle generation on GitHub is prompt packs and markdown skill files (the earlier scan's category), plus exactly one small hook-bank repo found here. There is no maintained hook-generation software with real adoption. Conclusion for the blueprint: the hook library and the angle discipline will be ours, assembled from harvested teardowns, the two hook banks, and STORM's question method. Budget build time accordingly.
- **Facebook remains the blind spot.** Nothing in this scan changes the first harvest's finding: no tool reads other Facebook Pages' posts and Reel metrics reliably. The front half routes around it exactly as System v1 does: peer outliers are harvested from the same creators' Instagram, YouTube, and TikTok mirrors, and Facebook-native peers stay a manual or Neo-side check.
- **Dead ends worth recording:** GeneralMills/pytrends is archived (April 2025) and broken by Google rate limits; JustAnotherArchivist/snscrape is effectively dead (last commit June 2023, Reddit modules depend on the defunct Pushshift API, Twitter modules broken); fhamborg/news-please is archived. Any future search will keep surfacing all three; do not re-evaluate them.
- **License watch-outs:** several plumbing pieces are AGPL-3.0 (RSSHub, SearXNG, FreshRSS, the `ia` tool). All are free for our internal, self-hosted use; AGPL obligations would only arise if we exposed them as a public network service, which the factory does not. RSSHub additionally carries a license discrepancy between its repo-details block (AGPL-3.0) and an older README copy (MIT); we record AGPL-3.0 as governing.
- **Maintenance watch-outs:** BookNLP's mirror shows very low activity; trendspyg is weeks old with 68 stars; ai-video-marketing has 9 stars. All three are recorded as borrow-or-experiment, never load-bearing.
- **Verification boundary:** every repo above was opened on GitHub in this session and its figures read from the page. The one candidate that failed verification (the People Also Ask CLI, 404 on open) is named in Layer 3 as not found, not reported as a finding.
