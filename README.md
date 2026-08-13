# Seeds of the Throne

This repository is the AI-facing Obsidian vault for developing *Seeds of the Throne*.

It is persistent working memory for story development: chronological sessions, compiled story elements, compact context files, research, drafts, public material, and continuity QA.

## Public website

The `iainreiddotdev/` directory contains the PHP portfolio previously maintained in the separate public `iainreid.dev` repository. The root `index.php` redirects visitors into that self-contained site. The root `.cpanel.yml` deploys only the redirect and portfolio application; the story vault is not copied into the public web root.

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
