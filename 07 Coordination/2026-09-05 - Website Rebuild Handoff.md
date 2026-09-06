---
type: implementation-handoff
status: verified-ready-for-deployment
started: 2026-09-05
updated: 2026-09-06
---

# Integrated vault and website rebuild handoff

## Implemented

The explicit author corrections now govern the premise, AI terminology, timeline, character and system boundaries, context, and pickup notes. Historical records remain traceable with supersession notices. The preliminary research brief is preserved with an audit qualifying its technical and security claims.

[[07 QA/2026-09-05 - Comprehensive Story Assessment]] contains Astra's central analysis, source conflicts, human stakes, and proposed development sequence. [[07 QA/2026-09-05 - Review Coverage]] records 167 content-reviewed source notes and all unreviewed archive material. The repository inventory covers 610 tracked baseline files.

The public atlas has eight rebuilt pages and a new workshop. The Explorer has a development map, source index, evidence/decision view, and workshop editor while preserving the existing search, document rendering, tree navigation, and progress view. Approved Sylvan, Samuel, and Konrad portraits are reused unchanged.

The [[07 Coordination/Story Completion Workflow/Workshop/README|workshop]] has twenty Markdown modules and eighty non-canon alternatives. Each includes prerequisites, sources, a single gate, consequences, follow-ups, scene and adversarial tests, a checklist, and a decision template. The first five recommended preparation sessions are purpose, entry, placement, reconstruction, and generation differences. No task completion changed; SC-010 Question 7 remains the active gate.

## Open story decisions

- Implant-free learned channel versus a physical-interface research path.
- Which harms are prohibited and which independent authority stops observation.
- Exact reactivation/permission lock, including the SC-001 Samuel Jr. actor discrepancy.
- What Sylvan can still lose under decisive control, and George's distinct final role.
- Authentication, protected disclosure, individual accountability, and placement after exposure.

## Open the deliverables

- Public atlas: `docs/index.html`.
- Public workshop: `docs/workshop.html`.
- Development workspace: `iainreiddotdev/project-explorer/?view=overview`.
- Full workshop editor: `iainreiddotdev/project-explorer/?view=workshop`.
- Durable modules: `07 Coordination/Story Completion Workflow/Workshop/`.

Use an HTTP server for interactive pages. Draft answers save only in the current browser/origin; export Markdown to preserve or transfer them. Nothing in the editor writes or approves vault canon.

## Verification

Completed: generated content hashes, local HTML links/assets/anchors, all twenty module schemas and source links, curated stale-claim checks, JavaScript syntax, PHP 8.2 syntax, and PHP HTTP responses for all four development views, search, and document rendering. A traversal request returns 404.

Final Chromium verification passed across 32 desktop/mobile route checks at 320px and 1440px. Menu keyboard behavior, draft persistence across reload and module changes, Markdown export/import, packet disclosure, Explorer search, traversal rejection, and unavailable-storage handling passed with no JavaScript errors. Legacy Ideas and Visuals mobile overflow was found and fixed. Representative atlas, workbench, and workshop renders were visually inspected. This is not a full screen-reader audit or real-device Safari test. See [[07 QA/2026-09-06 - Website Verification]]. The build and checks are documented in [[scripts/README]].

## Synchronization and approval

The initial cloud checkout and a later pre-publication fetch both matched `origin/main` at `3ae563dbf296477f98410870627af733bf32f0bf`. This does not verify the author's Mac vault. Existing remote work was preserved; no conflict was guessed away.

The author's later instruction, “when you are finished, publish to github so i can deploy,” authorizes a commit and push after verification, superseding the original hold on GitHub publication. Hosting deployment remains with the author. A push may trigger the repository's existing GitHub Pages workflow; this run does not change its configuration or operate cPanel.

## Deployment handoff

After the final push is confirmed, fetch/pull the repository on the desktop, preserving any local changes. Review a clean fast-forward before deploying. Run the documented build/check commands if changing source content; generated assets are already committed.

Use the existing cPanel Git deployment for the updated main revision. The existing `.cpanel.yml` archives the complete committed repository into its configured deployment root. Keep `docs/`, `iainreiddotdev/`, and the Markdown vault from the same revision. After deployment, verify the September 5 integrated review, workshop module 11, export/import, and source search. Deployment success is not claimed by this handoff.
