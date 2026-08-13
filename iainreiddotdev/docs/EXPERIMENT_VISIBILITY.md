# Experiment Visibility — private-first workshop experiments

A SaaS experiment can be deployed to the real production server before it is
publicly discoverable. It can be used privately, then by a few invited testers,
then published only after it earns public access. This document explains the
mechanism and how to operate it.

## Why experiments deploy privately first

There is no separate staging server. A shared cPanel host is the production
environment, and standing up a second environment is not worth it for small
experiments. Instead, an experiment ships to production but stays invisible:
`visibility = private` means only administrators can reach it, so you can use the
real thing under real conditions before anyone else knows it exists. A separate
staging server is unnecessary because privacy is enforced in the application,
not by hiding the deployment.

## Status vs visibility (never confuse them)

Two independent columns on the `experiments` table:

- **visibility** — *who may access this?* This is authorization. One of
  `private`, `invite`, `public`.
- **status** — *where is this idea in its lifecycle?* This is informational only:
  `inbox`, `exploring`, `validating`, `building`, `testing`, `launched`,
  `paused`, `archived`.

**Authorization is derived only from visibility (plus admin, plus invite). Never
from status.** A status of `launched` does not grant access; only
`visibility = public` does. Archiving is a status, not a deletion and not an
access rule. See `docs/SAAS_LAB.md` for the idea-manager model.

## The three states

- **private** — administrators only. Everyone else gets a 404.
- **invite** — administrators, plus logged-in registered users who hold an invite
  to this experiment. Everyone else gets a 404.
- **public** — anyone, logged in or not.

## Why unauthorized private/invite access returns 404

The privacy guarantee is that a hidden experiment is **indistinguishable from a
route that does not exist**. So unauthorized access to a private or invite
experiment returns a real **HTTP 404**, not 200, 302, 401, or 403, and never a
redirect to login (a redirect would reveal that the page exists and that logging
in might grant access). The 404 body is identical to a genuinely missing slug and
names nothing about the experiment or the viewer's login state.

## The single most important rule: gate before any output

The gate can only send a 404 before any byte of output has been sent. Therefore
`require_experiment_access('<slug>')` must be the **first thing a gated page does
after including the bootstrap** — before any HTML, whitespace, blank line, BOM,
`<title>`, meta tag, or database query.

If output has already started, the not-found renderer cannot set a 404; it logs
loudly to the server error log and raises rather than silently returning a
"200 not found" (which is forbidden). Keep the top of every gated page exactly
like this, with no blank line or markup above the gate:

```php
<?php
declare(strict_types=1);
require __DIR__ . '/../includes/bootstrap.php';
$experiment = require_experiment_access('hello'); // FIRST action, before any output
// ... only now include layout and render ...
```

## How to register an experiment / idea

Registering a record does **not** create any code or directory — it is metadata.

1. Log in as an administrator and open **Ideas**
   (`/iainreiddotdev/admin/experiments.php`).
2. Capture an idea with *name* and *one-sentence concept* only. The system
   assigns `IDEA-NNN`, a unique slug, `status = inbox`, `priority = normal`, and
   `visibility = private`.
3. Open the Idea workspace to refine fields, visibility, and invites.
4. Build the actual page(s) under `x/<slug>...` and gate them (below).

`route_path` is a **display-only note** so you can remember where a page lives.
It is never used for routing, redirects, includes, or authorization.

## How to gate a single page

```php
<?php
declare(strict_types=1);
require __DIR__ . '/../includes/bootstrap.php';
$experiment = require_experiment_access('your-slug');

require __DIR__ . '/../includes/layout.php';
render_page_top('Your experiment');
// render using $experiment ...
render_page_bottom();
```

See `x/hello.php` for the working demo.

## How to gate a multi-page experiment

Do not rely on remembering to gate every file. Give the experiment one tiny
per-experiment bootstrap and include it first from every page:

1. Copy `x/_experiment.example.php` to `x/<slug>/_experiment.php` and set the
   slug.
2. Make the **first line** of every page in `x/<slug>/`:

   ```php
   <?php require __DIR__ . '/_experiment.php';
   ```

Gating the whole sub-app is then structural, not per-file discipline. **Every
route inside a gated experiment must enforce access** — directly or through this
shared bootstrap. Never gate only the homepage and leave internal routes open.

## How to invite an existing user

Invites only matter while visibility is `invite`, and only apply to existing
registered users. From **Ideas → Idea workspace → Tester invitations**:

- Enter the user's email and *Add invite*. If no registered user matches, nothing
  is created or sent and you get an inline message.
- Invited users appear in the list; *Remove* revokes access immediately.

There are no invite emails, tokens, expiring links, bulk invites, or groups. A
user cannot invite anyone or change visibility; only admins manage invites.

## Moving private → invite → public, and archiving

Change *visibility* in the Idea workspace (Access and deployment). `published_at`
is set the first time visibility becomes `public` and is preserved if you later
move it back. To retire an idea, use *Archive idea* (POST + CSRF): `status`
becomes `archived` and `archived_at` is set. *Restore idea* returns it to
`inbox`. The record and its data remain; there is no delete in this phase.

## Where the framing Markdown is used

`experiments/_template/EXPERIMENT.md` is a short, phone-writable framing
template: the one job, the riskiest assumption, the disconfirming signal, the
smallest complete loop, private-use notes, invite-test notes, and the public
decision with a note. Copy it per experiment to think through the experiment; it
is documentation, not deployed code.

## Verifying a private route is not exposed (run on the live host)

You run these on the deployed site; they cannot be run from the build
environment. With the demo seeded as `private`:

```bash
# Logged out — expect 404 (a real not-found, no redirect to login)
curl -s -o /dev/null -w "%{http_code}\n" https://iainreid.dev/iainreiddotdev/x/hello.php   # -> 404

# Compare with a genuinely missing slug page — the gate body should match
```

Then check the source of the public VibeKB page and site navigation and
confirm the experiment name/slug appears **nowhere** (HTML, comments, meta/OG,
canonical, JSON/JS, structured data, sitemap, feeds). Privacy must come from the
server-side gate, not from an obscure URL or robots.txt.

After flipping to `invite`, confirm: the invited user reaches it; a logged-in
uninvited user and a logged-out visitor both get 404; it shows on the invited
user's account page only. After flipping to `public`, confirm everyone reaches
it. After revoking an invite, confirm that user is back to 404.

## The `/iainreiddotdev/`-inclusive URL shape

This repository is served under `/iainreiddotdev/`, so gated experiments live at, e.g.:

```
https://iainreid.dev/iainreiddotdev/x/hello.php
```

Build every internal link with the shared `url()` helper so the base path is
never hardcoded.

## Deployment and stale files

`x/` is copied on deploy; `experiments/` and `docs/` are not. The cPanel deploy
is copy-only and never deletes removed/renamed files, so a renamed gated route
can leave an old ungated file live. After renaming or replacing a gated route,
delete the stale file over SSH and re-verify the old URL 404s. See
`docs/DEPLOYMENT.md`.

## Security summary

Server-side enforcement only; 404 for unauthorized private/invite; no
authorization in any cookie beyond the existing session; no URL tokens; hidden
visibility inputs are validated against the allowed set; prepared statements;
output escaping; database-level uniqueness on `experiment_code` and `slug`;
foreign keys on invites; all admin mutations are POST with a validated CSRF token
and a fresh server-side `require_admin()` check. `route_path` is display-only.
