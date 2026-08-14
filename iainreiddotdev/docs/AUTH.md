# VibeKB — Shared Account System

## Architecture, briefly

VibeKB is the featured portfolio project, and the workshop also runs smaller
experiments behind a shared gate. Rather than give each
experiment its own login, this is a **single shared account layer** that every
future project can adopt by including one file. One identity, one
session, one user table — so a person who signs up once is known across the workshop.

Design choices, and why:

- **SQLite** is right for this first deployment: the workshop has very low
  concurrency, the database is a single file that lives with the app, there is
  no separate database server to provision on shared hosting, and backups are a
  file copy. It scales far enough for a foundation and can be migrated later if
  a project ever outgrows it.
- **PDO + native PHP sessions**: PDO gives prepared statements (no string-built
  SQL) and a clean path to another driver later; PHP's own session handling is
  battle-tested and needs nothing installed.
- **A small hand-built auth layer, not a framework**: the whole system is a
  handful of readable files with no Composer packages, no MVC, no build step.
  That keeps it deployable on plain cPanel shared hosting and easy to audit — the
  point of the workshop is understandable software, not an identity platform.
- **Deployable on shared cPanel hosting**: no daemons, no queues, no external
  services. Git-deploy the files, ensure one directory is writable, done.

## Purpose

Provide registration, login, logout, session-based authentication, a minimal
account page, and the beginning of an admin dashboard — a reusable foundation,
nothing more.

## Directory structure

```
includes/
  bootstrap.php    single entry point future projects include
  config.php       the one place base path + db path + session config live
  database.php     PDO(SQLite) connection, schema init, controlled failures
  auth.php         session, URL, and authorization helpers
  csrf.php         CSRF token helpers
  layout.php       shared page chrome + the 403 access-denied page
auth/
  register.php     create an account (auto-login on success)
  login.php        sign in (safe internal return path supported)
  logout.php       POST + CSRF only
  account.php      minimal protected account record
admin/
  index.php        protected dashboard: totals + newest-first user list
data/
  .htaccess        blocks HTTP access to database files
  index.php        returns 403 if the directory is ever hit directly
  saas-lab.sqlite  created at runtime — NEVER committed
scripts/
  create-admin.php CLI-only first-administrator creator
  .htaccess        denies web access (defense in depth)
assets/css/auth.css account-system styles
```

## Required PHP extensions

- `PDO` and `pdo_sqlite`
- Sessions (standard)
- Native password functions (`password_hash` / `password_verify`)

Target: **PHP 8.2** on cPanel shared hosting.

### Verifying `pdo_sqlite` is enabled

If the account pages report that the SQLite extension is missing, enable it in
cPanel:

- **Select PHP Version** → *Extensions* tab → tick `pdo_sqlite`, or
- **MultiPHP INI Editor** for the domain.

The code fails with a controlled message and never silently falls back to flat
files.

## Database

### Location

`data/saas-lab.sqlite`, which deploys to
`/home/iainmcok/public_html/devsite/iainreiddotdev/data/saas-lab.sqlite`.

### Why this path

The public document root is `public_html/`, and the repository deploys to
`public_html/devsite/iainreiddotdev/` (served at `https://iainreid.dev/devsite/iainreiddotdev/`). Keeping the
database inside `data/` under the deployed tree means it deploys reliably, is
owned and writable by the site's PHP user, and survives redeploys (the cPanel
`cp -R` merges and never deletes the runtime file). It is protected from HTTP by
`.htaccess` plus a 403 `index.php`. A location outside the document root was not
chosen because it adds deployment and configuration fragility for no real gain
at this scale.

### Initialization

On first connection the code runs `CREATE TABLE IF NOT EXISTS` and
`CREATE UNIQUE INDEX IF NOT EXISTS`. This is idempotent — repeated page loads
never recreate or damage existing data. `init_schema()` is deliberately small so
it can grow into versioned migrations later without adding a framework now.

Journaling uses SQLite's default rollback-journal mode (not WAL), which suits
the workshop's very low concurrency and avoids `-wal`/`-shm` files that could
complicate backups and deployment. `PRAGMA foreign_keys = ON` is set ahead of
future related tables (a no-op for the single table today).

### Schema

```sql
CREATE TABLE IF NOT EXISTS users (
    id            INTEGER PRIMARY KEY AUTOINCREMENT,
    name          TEXT NOT NULL,
    email         TEXT NOT NULL UNIQUE,
    password_hash TEXT NOT NULL,
    role          TEXT NOT NULL DEFAULT 'user',
    created_at    TEXT NOT NULL,
    updated_at    TEXT NOT NULL
);
CREATE UNIQUE INDEX IF NOT EXISTS idx_users_email ON users (email);
```

Emails are stored lowercase and trimmed; the unique constraint is the final
authority on duplicates. Timestamps are UTC `Y-m-d H:i:s`. Passwords are stored
only as `password_hash(PASSWORD_DEFAULT)` hashes.

## Writable directories

SQLite must create journal and lock files next to the database, so **the `data/`
directory itself must be writable by the PHP process**, not just the file.

If it is not writable, the code stops with a controlled, operator-facing message
that names the absolute directory (and nothing else):

```
The VibeKB data directory is not writable. Verify PHP write permissions for: /home/iainmcok/public_html/devsite/iainreiddotdev/data
```

## cPanel permissions & ownership

**Ownership matters more than the numeric mode.** On this host PHP runs as the
site's own user, so owner-write is sufficient. Prefer the least-permissive
settings that work:

- `data/` directory: **750** (or 700)
- `data/saas-lab.sqlite`: **640** (or 600)

Do **not** use 777. The blanket `chmod 755 dirs / 644 files` in `DEPLOYMENT.md`
still leaves `data/` owner-writable and does not break the database.

## Creating the first administrator

No admin email is hardcoded, there is no public "make admin" URL, and the first
registered user is **not** auto-promoted.

### Preferred: the CLI script (run on the server via cPanel Terminal / SSH)

```bash
cd ~/public_html/devsite/iainreiddotdev
SAAS_LAB_ADMIN_PASSWORD='choose-a-strong-password' \
  php scripts/create-admin.php --name="Iain Reid" --email="admin@example.com"
```

The password comes from the environment variable so it never lands in the
argument list or shell history, and it is never printed. Exit codes: `0` success,
`1` data directory/database not writable, `2` usage/validation error, `3` email
already registered. The script refuses to run under any non-CLI SAPI.

### Fallback: promote an existing account by SQL

Register normally, then (CLI preferred, this is a fallback):

```sql
UPDATE users
SET role = 'admin', updated_at = CURRENT_TIMESTAMP
WHERE email = 'normalized@example.com';
```

Use the normalized (lowercase, trimmed) email.

## Never commit

- `data/saas-lab.sqlite` and any `-wal` / `-shm` / `-journal` sidecar files
- Any real credentials or `.env` files
- PHP session files

The protective `data/.htaccess` and `data/index.php` **are** committed.

## How future projects require authentication

Include the shared bootstrap, then use the helpers:

```php
require __DIR__ . '/../includes/bootstrap.php';

require_login();            // any signed-in user, else redirect to login
// or
require_admin();            // administrators only, else 403 (or login if signed out)

$user = current_user();     // ['id','name','email','role','created_at','updated_at']
```

For links and redirects, always use the URL helpers so nothing hardcodes the
`/devsite/iainreiddotdev/` base path:

```php
redirect(url('auth/account.php'));
echo '<a href="' . e(url('admin/')) . '">Admin</a>';
```

## Testing

### Registration
- Valid registration creates the account, logs the user in, and redirects to the
  account page (via the URL helper).
- Duplicate email → *This email is already registered.* (enforced ultimately by
  the DB unique constraint, so a race is still caught).
- Invalid email, password shorter than 10 characters, and mismatched
  confirmation are each rejected with an inline message; safe values are
  preserved, the password never is.
- The password is stored only as a hash.

### Login
- Correct credentials succeed; wrong password and unknown email both return the
  same generic *Email or password is incorrect.*
- The session ID is regenerated after login.
- Normal users land on the account page; administrators land on the admin
  dashboard.
- External (`https://evil.com`) and protocol-relative (`//evil.com`) return
  values are rejected; valid internal paths (e.g. `/devsite/iainreiddotdev/admin/`) are honored.

### Authorization
- A signed-out visitor cannot reach the account page and is redirected to login.
- A signed-out visitor hitting an admin route is redirected to login with a
  validated `return` path back to the admin page.
- A signed-in **non-admin** hitting an admin route gets a clean **HTTP 403**
  page (not a silent redirect).
- An administrator can reach the admin dashboard.
- Navigation visibility is never relied on for access control.

### Logout
- A `GET` request is rejected (405); it is never treated as a logout action.
- An invalid CSRF token is rejected (400).
- A valid POST clears the session and redirects to login via the URL helper.

### Database protection over HTTP

You cannot confirm Apache/LiteSpeed `.htaccess` protection from a local PHP
build — it must be checked on the deployed host. After deploying, run:

```bash
curl -I https://iainreid.dev/devsite/iainreiddotdev/data/saas-lab.sqlite
```

**Expected: `403 Forbidden`** (a `404` is also acceptable if the host hides the
path). A `200`, a file download, or raw database output is a **deployment
blocker** — fix `.htaccess`/permissions before going further. Repeat for any
`-wal` / `-shm` files if they ever exist.

> The correct URL is under `/devsite/iainreiddotdev/` because the application is nested inside the repository deployment at
> `https://iainreid.dev/devsite/`, not at the domain root.

## Security notes

Implemented: PDO prepared statements, output escaping, CSRF on register/login/
logout, session-ID regeneration on login, generic login errors, unique
normalized emails, `password_hash`/`password_verify`, POST-only logout,
HTTP-protected database storage, server-side role checks on every admin request,
centralized redirects, and a validated internal return path.

### Login rate limiting is out of scope (by design)

This foundation intentionally does **not** implement login rate limiting or
lockout. It is the **next recommended security addition** once the foundation is
in place — e.g. per-IP/per-email attempt throttling with a short backoff.
