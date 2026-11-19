# Existing Agent Skills and Systems for Facebook Content

Compiled 2026-11-19. A sweep of what already exists in the world of AI-agent skills, frameworks, and playbooks for social media and Facebook content, evaluated against our setup: two Facebook Pages (Seeds of the Throne, documentary RV/AP/Egypt mystery; Cubix Meow, watercolor cat reels) run by scheduled agent jobs that measure insights daily, compare against peer pages, issue adaptation briefs, and produce reels and posts under a standing authorization.

Method: GitHub search via `gh` (repos and code), the major skill registries and vendor skill packs, Facebook MCP servers, and the documented write-ups of agents that actually run content loops in production. Each find gets a verdict: **adopt** (use the mechanism as-is), **adapt** (take the mechanism, change the surface), or **skip** (not useful to us, with the reason). Licenses are noted where reuse is plausible. Nothing below is copied at length; mechanisms are summarized and linked.

The headline finding: nobody has published a complete agent-run Facebook Page growth system like ours. What exists is parts: excellent grading rubrics, one genuinely proven analytics feedback loop (built for TikTok slideshows), a disciplined experimentation method, research skills for peer analysis, and several publishing tools. Our loop architecture (measure, compare, brief, produce, review) is ahead of everything public we found. The value is in stealing specific mechanisms to harden each stage.

---

## 1. Skill libraries and registries

### socai-io/skills: 106 social media skills
https://github.com/socai-io/skills (MIT)

The largest coherent social media skill library found: 106 SKILL.md files across strategy, writing, video, design, growth, publishing, and analytics, designed to chain (a strategy skill reads `brand-profile` and `goals-and-kpis` first, hands drafting to writer skills, publishing to a scheduler skill, readout to `analytics-and-reporting`). The individual skills are unusually disciplined: each has a named framework, an "honest scope" section with never-violate rules, a "distinct from its siblings" routing section, and a definition of done. Four of them matter directly to us and are treated in detail in the steals section: `experimentation-and-ab-testing` (the TEST framework), `viral-reverse-engineering`, `content-audit` (the AUDIT framework), and `facebook-strategy` (the REACH framework: Reels for discovery, first-hour engagement velocity, anchor about two themes because the algorithm tags a Page from its last 9 to 12 posts, link in first comment, Groups for community; it corroborates several moves our own 2026-11-19 brief already made, including the link-in-first-comment rule).

**Verdict: adapt, heavily.** We will not install the pack (it assumes a WoopSocial publishing surface we do not use, and 106 generic skills would dilute our canon and character rules), but its framework discipline is the best public model for how our own briefs and strategy files should be written, and three of its frameworks plug straight into our loop.

### Blotato free skill pack (7 skills)
https://github.com/Blotato-Inc/blotato-skills and https://www.blotato.com/tools/claude-skills (free download, no signup; skills free to use and edit)

A chained mini-system: `brand-brief` (one-time setup producing a `brand-brief.md` every other skill reads), `content-coach` (front door), `post-writer`, `post-grader`, `post-scheduler` (publishes via Blotato MCP), `viral-hooks` (100 hook frameworks in 13 categories), and `repurpose` (calls viral-hooks automatically for every post). The jewel is `post-grader`: a scoring gate that grades a draft across seven dimensions with the hook weighted at 50 percent, plus a pass/fail voice-rules audit (zero em dashes, contractions, digits for numbers, no filler words or filler openers, platform hashtag limits), each audit failure subtracting from the score, and a required output of the top three fixes with exact rewrites. Notably, its platform-fit dimension already encodes that Facebook rewards shares.

**Verdict: adapt.** The scheduler is useless to us (we publish through our own connector), but the grader rubric and the brand-brief-as-single-source pattern are directly stealable. Our no-em-dashes rule is already in their audit, which validates the shape.

### PostEverywhere: 15 Claude skills for social media
https://posteverywhere.ai/blog/claude-skills-for-social-media (skills open source under MIT in their plugin repository)

Fifteen skills covering scheduling, calendar planning, cross-posting one video with per-platform captions, analytics reading, and failure retry, all working through their hosted MCP connector. The interesting mechanism is the loop closure: the skills do not stop at a draft; the same skill set schedules, publishes, reads how the post did, and retries failures.

**Verdict: skip the product, note the pattern.** We already have publish, measure, and retry in our own jobs; a paid connector adds nothing. Worth remembering only as proof that the market converged on the same loop shape we built.

### Upload-Post skills: viraloop, tiktok-app-marketing ("larry-marketing"), comment-funnel
https://github.com/Upload-Post/upload-post-skills (MIT)

`viraloop` is a single SKILL.md implementing a daily iteration loop for TikTok/Instagram carousels: research the site and competitors, generate three hook variants in fixed archetypes (SHOCK, CURIOSITY, CONTRADICTION), render slides, review them with vision before publishing, publish, then after 24 to 48 hours read analytics and run a learning step that updates a persistent `learnings.json` (best hooks, optimal times, what to avoid) which the next run reads before generating. `tiktok-app-marketing` is the same methodology generalized (it is the public distillation of the "Larry" agent below), with the added lesson of separating vanity metrics from conversion metrics: views pick hooks, downstream conversions pick CTAs. `comment-funnel` is Instagram comment-to-DM automation; not applicable to Pages work here.

**Verdict: adapt.** The `learnings.json` pattern and the three-archetype hook-variant step are two of the cleanest mechanisms found anywhere in this sweep. See steals.

### Registries and directories (for future sweeps)
- VoltAgent/awesome-agent-skills, https://github.com/VoltAgent/awesome-agent-skills (about 37k stars): the biggest curated index of agent skills, 1,000+ entries; the place to re-check quarterly.
- skills.sh: the registry the `npx skills add` installer resolves against; OmniSocials and others list there.
- skillmds/SkillMD, https://github.com/skillmds/SkillMD (MIT): lint, search, and install tooling for SKILL.md files, with an MCP server; useful if our own skill files multiply.
- TerminalSkills/skills, https://github.com/TerminalSkills/skills (Apache-2.0): another general library; no social-specific depth found.
- OmniSocials agent skill, https://omnisocials.com/agent-skill: one SKILL.md plus a 56-command CLI for posting, inbox, and analytics across 13 platforms, with a "save drafts first, never publish without your OK" rule baked into the skill. Paid ($10/mo/seat). **Verdict: skip** (we have a better-fitted connector), though its draft-first safety rule mirrors our own approval practice.

## 2. Research skills (the peer-comparison stage)

### ScrapeAtlas social-media-agent-skills
https://github.com/ScrapeAtlas/social-media-agent-skills (MIT)

Seventeen research skills, each a complete workflow rather than an API wrapper, all fed by one scraping MCP: `outlier-post-finder` (find posts that beat a creator's own baseline, return the outlier table plus repeatable patterns and hooks to test), `hook-library` (collect opening lines of top short videos in a niche, return hook formulas with verbatim examples and fill-in templates), `comment-mining` (questions, objections, pains, and audience language, with verbatim quotes), `competitor-content-research` (benchmark table, top posts, recurring formats across several competitors), `creator-profile-teardown`, `ad-library-teardown` (Meta and LinkedIn ad libraries: longest-running concepts are the signal), `trend-scan`, `social-listening-brief`, `transcript-intelligence`. Facebook is among its data sources.

**Verdict: adapt the methods, skip the dependency.** We should not add a paid scraping dependency for data our connector and web reads mostly cover, but the *methods* are exactly what our daily research run's peer stage should formalize: outlier-vs-own-baseline instead of raw view counts (a 2,000-view post from a 300-follower peer is a stronger signal than a 50,000-view post from a giant), and a standing hook library with verbatim peer examples filed by formula.

## 3. Agent frameworks and content pipelines

### langchain-ai/social-media-agent
https://github.com/langchain-ai/social-media-agent (about 3k stars)

The most-starred social agent repo: takes a URL, generates Twitter/LinkedIn posts, and runs a human-in-the-loop flow through an Agent Inbox where a person edits, accepts, or rejects before anything posts; supports cron-triggered generation and a customizable post-style file.

**Verdict: skip the code, keep one idea.** Its approval-inbox pattern is what our standing authorization deliberately replaced; but its separation of "generate" and "approve" as distinct graph nodes is a reminder to keep our own publish gate explicit in the slate job design if the authorization ever narrows.

### lucasgrow/social-media-agent
https://github.com/lucasgrow/social-media-agent (MIT)

A file-based production layer driven from Claude Code or Codex: all state on disk per profile under `profiles/<name>/`, with a `DESIGN.md` (palette, fonts, principles, anti-references) and a `VOICE.md` (tone, go-words, no-go-words, per-context rules) that every generation prompt is built from; reference ingest with *grounding* (anchor real subjects to real reference images before generating, so the model does not invent them); and an audit/learning loop that scans past posts, detects brand drift, extracts patterns, and feeds learnings back into future prompts.

**Verdict: adapt.** This is the closest public architecture to ours, and it validates two things we already do (reference-image grounding is exactly how the Cubix definitive designs are enforced; per-page strategy files are our DESIGN/VOICE). Its explicit brand-drift audit is the piece we lack: a scheduled check that recent pieces still match the bible, scored against the files rather than vibes. Steal for the weekly review.

### NachaFromMars/social-media-agent (OpenClaw skill)
https://github.com/NachaFromMars/social-media-agent

Autonomous X management with zero API keys: browser posting, web_fetch research, parallel content generation via spawned sessions, cron scheduling, memory search for history.

**Verdict: skip.** Browser-automation posting is the route we deliberately avoid on Facebook (account risk, and our connector is API-clean), and it is X-only. Noted only because it proves the cron-plus-parallel-generation shape is a pattern others independently reached.

### alessiopagliarulo/content-generation-platform (PRD)
https://github.com/apagplayz/content-generation-platform (design document)

A product requirements doc for a short-form video engine whose core decision is worth stealing as language: *each content method is its own persistent, semi-autonomous agent* with three per-agent properties: a **playbook** (versioned system prompt: voice, hook patterns, structure, cadence, do/don'ts), a **memory** (what has worked for that format), and an **autonomy toggle** (auto-run vs pause-for-review), all orchestrated from one hub.

**Verdict: adapt the vocabulary.** Our series (From the Record, Cats of the Ancient World, Adventures, Night Watch) are de facto per-format agents; naming their playbook, memory, and autonomy explicitly in the strategy files would make the weekly review's keep/kill decisions cleaner.

### owera/owera-channels-manager
https://github.com/owera/owera-channels-manager

A self-hosted fleet manager for faceless YouTube channels with an optional autonomous growth agent that is the most operationally mature loop description found: per-video daily analytics snapshots in a database with leaderboards (including by-topic), a launchd timer running headless Claude Code against a *versioned playbook file*, and a daily mandate to read analytics, rank winners and losers, steer topics, and ship *one or two small, reversible improvements* as ordinary git commits, then write a dated report to `run/agent-reports/`. Guardrails and a kill switch bound the agent.

**Verdict: adapt.** The "one or two small reversible changes per cycle, each logged" discipline is the right governor for our adaptation briefs: it prevents the weekly strategy whiplash that daily data invites. Our briefs should cap and rank changes the same way.

### AI-Content-Studio and the multi-agent content systems
https://github.com/naqashafzal/AI-Content-Studio and peers (Klaudiusz321/social-media-agents, colesmcintosh/social-media-agent-system)

A crowded genre: a coordinator agent delegating to Research, Content Creator, Analytics, and Engagement specialists. Uniformly demo-grade, no published performance evidence, and architecturally the opposite of our single-agent-with-files design.

**Verdict: skip.** Multi-agent role theater adds coordination cost without a mechanism we lack.

## 4. Facebook tooling and MCP servers

### facebook-mcp by SalindaHulangamuwa
https://glama.ai/mcp/servers/SalindaHulangamuwa/facebook-mcp (open source, FastMCP)

Sixteen tools for Pages from any MCP client: publish and schedule posts, photo posts, Reels from local video, comment moderation, and insights, multi-page from one user token, with heavy test coverage against a mocked Graph API.

**Verdict: skip.** Our facebook-cli connector already covers this surface and is the one our jobs are written against. Noted as the fallback if our connector ever breaks: a same-week replacement exists in the open.

### social-mcp by bmachek
https://glama.ai/mcp/servers/bmachek/social-mcp (self-hosted)

Instagram and Facebook Page management plus an **autopilot** that plans and queues two weeks of content from a photo inbox in one pass. Self-hosted, tokens never leave the machine; a one-shot public URL sidecar solves Meta's fetch-the-image problem for local files.

**Verdict: skip, with one idea noted.** The two-week autopilot queue is a content-bank pattern; our bank already does this at smaller scale. If bank depth ever becomes the bottleneck, its "plan a fortnight from an inbox folder" is the model.

### thenavidm/facebook-mcp-cli
https://navid.me/mcp-servers/facebook

The open Facebook MCP server and CLI family our own connector belongs to: identical tools as MCP and as `facebook-cli` commands, read-only by default, writing gated behind an explicit `FACEBOOK_ALLOW_WRITE=true`, deletes behind a second flag and a confirmation. Its design notes are a good checklist of platform truths (Page tokens only exist through your own Meta app; native scheduling means Facebook itself publishes, so nothing needs to be running; rate limits are per-app, not per-Page).

**Verdict: adopt as reference.** No action needed; it documents why our tooling behaves as it does, and its write-gating flags are the pattern to copy if we ever wrap additional Meta surfaces.

### Hosted publishing MCPs (Blotato, PostEverywhere)
Both expose one hosted endpoint through which an agent publishes to Facebook Pages, Reels, and photos on the official Graph API (Blotato from $29/mo). **Verdict: skip.** Redundant with our connector; the only scenario that changes this is a connector outage lasting days.

## 5. Write-ups and loop designs

### LarryLoop: the documented iteration engine
https://www.larryloop.com/docs/the-loop (and the Startup Ideas Podcast episode, "I let OpenClaw run my organic marketing (while I sleep)")

The single most concrete public description of an agent content loop that demonstrably worked (an OpenClaw agent running TikTok slideshow marketing for apps, revenue attributed). The mechanism, in full: once at least 10 posts have analytics, a weekly iteration run (1) pulls analytics and scores every post with fixed weights, views 50 percent, engagement rate 30 percent, downstream clicks 20 percent; (2) classifies every post into four tiers: **Dead** (kill it; similar patterns are never generated again), **Testing** (not enough data), **Promising** (decent and growing; generate variations to push it up), **Winner** (extract hook style, visual format, and topic as templates for new variations); (3) analyzes patterns across posts, not just scores: hook style patterns, visual styles, topic clusters, CTA effectiveness; (4) writes winning and dead patterns back into the knowledge base the next generation reads. Two operating lessons from the podcast: hooks and CTAs are diagnosed separately because they fail separately (views vs conversions), and draft-posting to access trending audio beat API posting on TikTok (platform-specific; not transferable to our Facebook route).

**Verdict: adopt the mechanism.** This is the scoring and tiering engine our weekly review should run, with weights translated to our metrics. See steal #1.

### SocialKit's three copyable skills (monthly report, caption QA, hook variants)
https://socialk.it/en/blog/claude-skills-for-social-media

A practitioner write-up publishing three complete, small SKILL.md files. `monthly-social-report`: fixed section order (one-line headline, numbers table with anything over 20 percent flagged, top three posts with one sentence each on why, bottom three likewise, maximum three changes for next month each tied to the data), and a hard rule to never estimate a number not in the data. `caption-qa`: a pre-publish gate returning PASS/FIX per item: hook must work with everything after the first line truncated away, one idea per caption, banned phrases list, *every number or superlative must be traceable to supplied material*, exactly one CTA matched to platform behavior, accessibility checks. `hook-variants`: return exactly eight opening lines, one per named category (direct claim, number, contrarian, mistake, before/after, specific detail, cost, question), each under 12 words, then name the two to test first and why; never invent a statistic for the number variant, use a count from the user's own material. The article's meta-lesson is also worth keeping: do not hardcode facts that change (like character limits) into a skill; point at a maintained reference instead.

**Verdict: adopt.** The caption-QA claims-traceability item is our verified-claims rule wearing a checklist, and the eight-category hook generator is a ready-made production step. See steals.

### RevenueCat's AI creative workflow write-up
https://www.revenuecat.com/documents/app-growth-annual-julien-daver-workshop

An agency-grade workflow description with two stealable habits: every creative is briefed *per hook* (audience + problem + angle + hook as the unit, so results can be attributed to the hook), and a daily research harvester (theirs reads X with a keyword list plus a watchlist of top accounts, filters to actionable creative insight, favors heavily bookmarked posts, and *dedupes against everything already shared* so nothing repeats). Their ideation ratio: generate many concepts (they cite 56/day), test few (2).

**Verdict: adapt.** The per-hook brief unit and the dedupe-against-history rule both map onto our content bank and peer watch list.

---

## What we should steal

Ranked by expected value to our loop. Each names the mechanism, its source, and the exact place it plugs in.

### 1. Weighted post scoring with a four-tier kill/keep system
**Mechanism:** every published piece gets a fixed-weight score and a tier (Dead, Testing, Promising, Winner). Dead patterns go on a kill list the generators must not reuse; Winner pieces have their hook, visual treatment, and topic extracted as templates. LarryLoop's weights (views 50, engagement 30, clicks 20) translate to ours: for Seeds, views and completion first, new followers second, saves/shares as the engagement term; for Cubix, completion and rewatches first, comments and sends second.
**Source:** LarryLoop, https://www.larryloop.com/docs/the-loop
**Plugs into:** the **weekly review** (it does the scoring and tiering and maintains the kill list in each strategy.md), consumed by the **daily research run** (tiers explain yesterday's numbers) and **slate production** (kill list is a hard constraint, Winner templates are the first place to look for variations). This replaces impressionistic "what worked" summaries with a scoreboard that compounds.

### 2. A persistent learnings file per page that every run reads and the learning step rewrites
**Mechanism:** viraloop's `learnings.json`: a structured, accumulating file (best hooks, best times, dead patterns, open questions) updated by a dedicated learn-from-analytics step after a fixed 24 to 48 hour maturation window, and read at the start of every generation run. Our adaptation briefs are currently prose snapshots; a learnings file makes them cumulative state instead of daily journalism.
**Source:** Upload-Post viraloop, https://github.com/Upload-Post/upload-post-skills (MIT)
**Plugs into:** the **daily research run** writes it (one per engine workspace, next to strategy.md), the **adaptation briefs** become the human-readable diff of what changed in it, and **slate production** reads it before the brief. This is the single change that most improves loop memory.

### 3. A pre-publish grading gate with a fixed rubric
**Mechanism:** Blotato's post-grader (hook weighted 50 percent, seven dimensions, pass/fail voice audit with per-failure deductions, top-three fixes with exact rewrites, a deliberately harsh scale where 10 does not exist) merged with SocialKit's caption-qa items (first line must survive truncation, one idea, every claim traceable, one CTA). Our version adds our own audit rows: no em dashes, claim verified or dropped, canon-safe source for Seeds, character-bible match for Cubix, burned-in hook present per the 2026-11-19 brief.
**Sources:** https://github.com/Blotato-Inc/blotato-skills and https://socialk.it/en/blog/claude-skills-for-social-media
**Plugs into:** **slate production**, as the last step before any publish or schedule call, with the score and fixes logged in the engine log. A piece under the bar gets its hook rewritten once; still under, it is banked or dropped, never shipped to fill a slot (which our originality rules already demand).

### 4. One live experiment at all times, run under the TEST framework
**Mechanism:** socai's experimentation discipline: Target one variable, Establish the decision rule (primary metric, win threshold around +20 percent, guardrail metric) *before* publishing, Set controls (same format, topic class, length, window; 3 to 5 paired repetitions; small accounts judge over 2 to 4 weeks), Tally and scale winners into the playbook. No post-hoc rationalizing; a tie is a valid result; a single viral post is noise, not strategy.
**Source:** socai-io/skills, `experimentation-and-ab-testing` (MIT), https://github.com/socai-io/skills
**Plugs into:** the **adaptation briefs** carry the one live experiment per page (Seeds is already primed for this with its four-week morning-vs-evening timing test; formalize it), the **daily research run** reports the experiment's running tally without calling it early, and the **weekly review** tallies, repeats, or retires it and writes winners into strategy.md.

### 5. Peer analysis by outlier-vs-baseline, with a standing hook library
**Mechanism:** ScrapeAtlas's outlier method: judge a peer post against that peer's own baseline, not against absolute numbers, and return repeatable patterns; plus its hook-library method: collect opening lines and on-screen hooks from top niche pieces, filed by formula with verbatim examples. Add socai's viral-reverse-engineering teardown for the biggest outliers: deconstruct by layer, isolate the 1 to 2 load-bearing drivers with the counterfactual test ("remove this, does it still pop?"), name the share-trigger, and run the replicability check (account size, luck, one-time moment) before extracting any principle.
**Sources:** https://github.com/ScrapeAtlas/social-media-agent-skills (MIT) and socai-io/skills, `viral-reverse-engineering`
**Plugs into:** the **daily research run** (peer stage produces an outlier table and files new hooks into a per-page hook library in each engine's research folder), feeding **adaptation briefs** with mechanisms rather than imitations, which is exactly the line our canon and originality rules require.

### 6. Hook variants as a standard production step
**Mechanism:** generate variants before choosing: SocialKit's eight categories (direct claim, number, contrarian, mistake, before/after, specific detail, cost, question), each under 12 words and standing alone, or viraloop's three archetypes (SHOCK, CURIOSITY, CONTRADICTION) for a lighter pass; the grader (steal #3) picks, and the choice is logged so the weekly tiering can learn which categories win per page.
**Sources:** https://socialk.it/en/blog/claude-skills-for-social-media and viraloop (MIT)
**Plugs into:** **slate production** (every Reel and question post gets variants for its burned-in hook and first caption line), with outcomes feeding the **weekly review** via the engine log.

### 7. Brand-drift audit and keep/kill/refresh triage on a monthly layer
**Mechanism:** lucasgrow's audit loop (scan past posts, detect drift from DESIGN.md/VOICE.md, extract patterns, feed back into prompts) combined with socai's AUDIT framework (Assemble a 90-day inventory, Uncover signal scored on saves/shares rather than vanity, Diagnose pillar coverage and voice drift *both ways* since winners may say the voice should evolve, Iterate keep/kill/refresh with refresh before kill and kills never auto-applied, Turn into a quick-wins vs long-term roadmap).
**Sources:** https://github.com/lucasgrow/social-media-agent (MIT) and socai-io/skills, `content-audit`
**Plugs into:** a monthly extension of the **weekly review** (first Sunday of the month runs the deep version): Cubix pieces checked against the definitive designs and catchphrase discipline, Seeds pieces against Plain Account and the public-safe lines, pillar whitespace reported for both.

### 8. Governor rules for the loop itself: small reversible changes, per-hook attribution, dedupe
**Mechanism:** three small disciplines from three sources: owera's cap of one or two small, reversible improvements per cycle, each committed and reported; RevenueCat's per-hook brief unit so every result attributes to a hook, not a vibe; and the harvester dedupe rule (nothing already shared is ever re-shared as new) applied to our peer findings and content bank.
**Sources:** https://github.com/owera/owera-channels-manager and https://www.revenuecat.com/documents/app-growth-annual-julien-daver-workshop
**Plugs into:** the **adaptation briefs** (cap and rank the changes; name the hook each piece is testing), the **daily research run** (peer watch list deduped against prior reports), and the **content bank** format (each banked piece carries its hook as a named field).

---

## Bottom line

The public ecosystem has no system to copy wholesale, and several of its loudest products are wrappers around the same loop we already run. What it does have is five battle-tested mechanisms our loop lacks: LarryLoop's scoring and tiers, viraloop's learnings file, Blotato's grading gate, socai's experiment discipline, and ScrapeAtlas's outlier method. All five are MIT-licensed or published as copyable method, none requires new tooling or a new dependency, and each plugs into a named stage of the existing daily loop. Steal those, keep our architecture.
