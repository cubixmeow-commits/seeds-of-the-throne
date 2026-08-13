---
type: workflow-convention
status: established
updated: 2026-08-13
---

# Mobile and Desktop Workflow

## Purpose

Creative development can happen anywhere, but repository implementation needs one visible handoff path. The vault remains the durable authority after conversation decisions have been reviewed and promoted.

## Mobile

Mobile sessions are for:

- story development, brainstorming, character and world work;
- research planning and discussion;
- vault-ready summaries, public copy, and X drafts;
- identifying changes that require local files, testing, commits, or publishing;
- adding those implementation needs to [[DESKTOP-QUEUE]] when vault access is available, or carrying an explicit handoff into the next desktop session.

Mobile sessions do not modify or publish website files. They may plan website work and prepare copy or specifications.

## Desktop

Desktop sessions may do everything mobile sessions do, and are the implementation environment for:

- safely fetching and reconciling the local repository;
- processing accumulated conversation decisions into dated session notes and compiled vault memory;
- structural file changes, scripts, code, and website work;
- local verification, continuity checks, diff review, commits, pushes, and publishing.

## Handoff convention

The durable flow is:

**mobile development → desktop queue → desktop audit and implementation → verified commit → queue completion record**

Every queue item should contain enough context to implement without relying on memory: source conversation or date, intended outcome, affected area, status, and unresolved choices. Desktop work must inspect existing files first to avoid duplication.

When a queue item contains story development, create or update a dated note in `01 Sessions/Daily/` before changing compiled story notes. Mark uncertain mechanics as working or unresolved rather than silently settling them.

## Website boundary

Website files are modified, tested, committed, and published only from desktop. A story-vault audit does not authorize website changes unless the queue item or current request explicitly includes them.
