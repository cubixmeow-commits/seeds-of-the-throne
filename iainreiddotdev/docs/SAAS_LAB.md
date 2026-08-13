# Private idea workspace

## Purpose

The private idea workspace captures and manages multiple product ideas.

Its job is to help the owner:

1. Capture ideas quickly.
2. Understand what each idea is.
3. See the current stage of every idea.
4. Record the next action.
5. Keep notes and observations.
6. Pause, archive, or continue ideas.
7. Later test optional tools inside individual ideas.

It is not an AI idea generator, startup operating system, project-management
platform, market-research tool, public directory, or validation framework.

## Core model

The existing `experiments` table is the idea record. Internal code may still
use the word *experiment* where renaming would add risk. The private admin UI
uses *idea*, *Ideas dashboard*, and *Idea workspace*.

Primary private surface after admin login:

- Ideas dashboard: `/iainreiddotdev/admin/experiments.php`
- Idea workspace: `/iainreiddotdev/admin/experiment.php?id=…`

The public `/iainreiddotdev/saas-lab/` page is the VibeKB portfolio showcase, not the
management interface.

## Idea lifecycle (status)

Status answers: *Where is this idea in its lifecycle?*

| Status | Meaning |
|--------|---------|
| `inbox` | Freshly captured |
| `exploring` | Clarifying the idea |
| `validating` | Checking the problem/user fit |
| `building` | Building a usable loop |
| `testing` | Testing with real use |
| `launched` | Live / shipping |
| `paused` | Held, still active (not archived) |
| `archived` | Retired; kept for history |

Legacy statuses from the first visibility phase are remapped on schema init:

- `framing` → `inbox`
- `self-testing` → `testing`
- `invite-testing` → `testing`
- `public` → `launched`

`building` and `archived` keep their values.

## Visibility

Visibility answers: *Who is allowed to access a gated experiment page?*

- `private` — administrators only
- `invite` — administrators plus invited registered users
- `public` — anyone

**Status and visibility are independent.** Authorization is derived only from
visibility (plus admin/invite). Never from status. Archiving does not delete
records and does not by itself change who can access a gated route.

## Priorities

Application-validated priorities: `low`, `normal`, `high`.

New ideas default to `status = inbox`, `priority = normal`, `visibility = private`.

## Codes and slugs

- Idea codes are generated as `IDEA-001`, `IDEA-002`, … by inspecting existing
  `IDEA-NNN` codes (not row count). Legacy codes are left unchanged.
- Slugs are generated from the idea name (ASCII-safe, unique with `-2`, `-3`, …).
  Slug editing remains under Access and deployment in the workspace.

## Future tool rule

A future tool earns its place only when it:

1. Runs inside a specific idea,
2. Saves a useful result, and
3. Helps decide or perform the next action.

## Intentionally deferred

AI integrations, competitor/market research, idea scoring, kanban/tasks,
notifications, email, billing, teams, uploads, charts, and external APIs are
out of scope for this phase.

## Related docs

- Authentication: `docs/AUTH.md`
- Visibility gates: `docs/EXPERIMENT_VISIBILITY.md`
- Deployment: `docs/DEPLOYMENT.md`
