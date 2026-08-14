# Seeds of the Throne

This repository is the AI-facing Obsidian vault for developing *Seeds of the Throne*.

It is persistent working memory for story development: chronological sessions, compiled story elements, compact context files, research, drafts, public material, and continuity QA.

## Public website

The complete tracked repository is published under `https://iainreid.dev/devsite/` so its public-facing vault material can be explored directly. The `iainreiddotdev/` directory contains the PHP portfolio previously maintained in the separate public `iainreid.dev` repository, and the root `index.php` redirects `/devsite/` visitors into that nested application at `/devsite/iainreiddotdev/`. Repository metadata and dotfiles remain blocked from web access.

## Start here

1. Read [START HERE](START%20HERE.md).
2. Read [03 Context/CURRENT](03%20Context/CURRENT.md).
3. Read [03 Context/RULES](03%20Context/RULES.md).
4. For current cast, world, and story summaries, read the other files in `03 Context/`.

## Important separation

The old working vault is kept separately as `Seeds of the Throne archive`. It is not part of this repository and is not routine AI context. Old transcripts, sensitive mappings, and unsafe historical material were intentionally excluded from this vault.

## Working roles

- The author makes story decisions and controls final voice.
- GPT is the story-development and organization command center.
- Claude is research-only. Research informs decisions but does not create canon automatically.

## Session workflow

Record development in `01 Sessions/Daily/`. Preserve competing possibilities and contradictions there. Promote deliberately selected material into `02 Story/`, update `03 Context/` when the working summary changes, and record consequential resolutions in `07 QA/Decisions.md`.

## Mobile and desktop handoff

Mobile sessions may develop story material, research plans, vault-ready notes, and public copy. Local repository reconciliation, structural edits, code or website changes, verification, commits, pushes, and publishing happen on desktop. See [07 Coordination](07%20Coordination/README.md) and the [desktop implementation queue](07%20Coordination/DESKTOP-QUEUE.md).
