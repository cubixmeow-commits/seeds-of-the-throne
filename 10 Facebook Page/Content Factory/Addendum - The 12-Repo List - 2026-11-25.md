# Addendum - The 12-Repo List - 2026-11-25

Status: WORKING addendum to the Component Map. Source: a hype-style X post Noa pasted on 2026-11-25 ("6 Grok Bots can run your entire social media team", 12 repos). Each repo checked against our scans or verified fresh on 2026-11-25. Verdict up front: the list changes nothing in the architecture. Five of the twelve were already in our scans, two are worth adding, the rest are real tools aimed at problems we do not have yet.

## Already in our map (no change)
- n8n: flagged in the back-half scan, fair-code license, Prefect covers the need.
- Crawl4AI: in the front-half scan, self-host only under the free rule.
- Remotion: already our assembly tool, free tier noted.
- Postiz: evaluated, deferred (Meta app approval; our facebook-cli route works).
- Metabase: noted as a possible dashboard over our own reads.

## New and worth taking
- pavelhov/social-media-skills (MIT, free; 106 skills; created 2026-09, young): its hook-writer skill (hooks generated across named mechanisms, hooks must stay true to the content) and short-form-video-script skill (the WATCH framework) are direct Layer 3 and Layer 5 reference material, same class as the vyralcontent pack from the first scan. Borrow the frameworks into our hook library; do not adopt the pack wholesale.
- Repomix (MIT, free): packs a folder of files into one AI-readable document. A small utility with a real job here: packaging vault and engine context for the factory's research runs, so a run reads the whole shelf folder as one input.
- coreyhaines31/marketingskills (MIT, free, 50k+ stars, actively maintained): a large marketing-skills library (copywriting, social, ads, CRO). Built for SaaS marketing, so most of it is not our niche; the copywriting and social skills are reference only. Low priority.

## Real, but not for us now
- LangGraph (MIT, LangChain's agent-graph framework): the credible alternative spine to Prefect, for coordinating stateful agent teams rather than scheduled pipelines. Our factory is a pipeline with gates, so Prefect stands. LangGraph is the named fallback if the design ever becomes a true multi-agent team. Pick one spine, never both.
- Langfuse (open source, self-hostable): observability for LLM runs, traces and cost per step. This is Layer 9 for the machine itself rather than the content. Worth adding when the daily run spends enough credits that we need per-stage cost accounting; premature today.
- ComfyUI: local image-generation workflows. Needs a GPU-class machine; our VM has none and the Neo could run it. Its moment is if canon-face consistency ever becomes a local job (the face gate). Deferred, noted.
- TryPost (AGPL-3.0; self-hosted free with all features, cloud paid): a younger, smaller Postiz alternative with an MCP publishing surface that includes Facebook. Same deferred status as Postiz; no reason to prefer it over the route that already works.

## The post itself
The workflow line (research, strategy, writing, design, publishing, analytics) is our pipeline with agent branding. The six-bot split contradicts the one hard lesson from the Grok Bot workflow article reviewed the same day: its author split at two bots because drafting and artifacts need shared context and the voice has to live in one place. Our factory keeps the same discipline: scheduled runs do the monitoring, one conversational agent does the thinking, Noa keeps the gates.
