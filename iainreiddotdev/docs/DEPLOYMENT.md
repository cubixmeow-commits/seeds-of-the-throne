# Deployment

The repository keeps the existing cPanel Git deployment flow.

Deployment target:

`/home/iainmcok/public_html/devsite/`

The portfolio application remains in the repository subfolder:

`/home/iainmcok/public_html/devsite/iainreiddotdev/`

Recommended permissions after deployment:

```bash
find ~/public_html/devsite -type d -exec chmod 755 {} \;
find ~/public_html/devsite -type f -exec chmod 644 {} \;
```

## URL mapping

The public document root is `public_html/`. The repository deploys to
`public_html/devsite/`, while the portfolio remains in its `iainreiddotdev/` subfolder. The application is therefore served under `https://iainreid.dev/devsite/iainreiddotdev/`
(for example the VibeKB page is `https://iainreid.dev/devsite/iainreiddotdev/saas-lab/`). The
shared account system lives under the same base path (`/devsite/iainreiddotdev/auth/...`,
`/devsite/iainreiddotdev/admin/`). This base path is configured in one place: `includes/config.php`.

The Seeds static atlas remains at `/devsite/docs/`, while vault files retain their repository-relative paths beneath `/devsite/`.

## Shared account system (VibeKB)

The complete tracked repository deployment includes this application's `auth/`, `admin/`, `data/`, and `scripts/` directories in their existing nested location.
The VibeKB portfolio page is served by `saas-lab/index.php`. See
`docs/AUTH.md` for the full account-system guide.

### Database directory must be writable

The SQLite database is created at runtime at
`~/public_html/devsite/iainreiddotdev/data/saas-lab.sqlite`. SQLite also writes journal/lock files
in that directory, so **`data/` itself must be writable by the PHP user**.
Ownership matters more than the numeric mode; on this host PHP runs as the site
user, so owner-write suffices. Least-permissive starting point:

```bash
chmod 750 ~/public_html/devsite/iainreiddotdev/data
# after the DB is created:
chmod 640 ~/public_html/devsite/iainreiddotdev/data/saas-lab.sqlite
```

Do not use 777. The blanket `chmod` above still leaves `data/` owner-writable.

### Create the first administrator (on the server)

```bash
cd ~/public_html/devsite/iainreiddotdev
SAAS_LAB_ADMIN_PASSWORD='strong-password' \
  php scripts/create-admin.php --name="Iain Reid" --email="admin@example.com"
```

### Verify the database is not reachable over HTTP (required post-deploy test)

```bash
curl -I https://iainreid.dev/devsite/iainreiddotdev/data/saas-lab.sqlite
```

Expected: **403 Forbidden** (404 also acceptable). A 200 / file download is a
deployment blocker — fix `data/.htaccess` and permissions before proceeding.

## Gated experiments (`x/`)

The deployment includes the `x/` directory (gated experiment routes, e.g.
`x/hello.php` served at `https://iainreid.dev/devsite/iainreiddotdev/x/hello.php`). Because the complete tracked repository is published, application documentation and experiment templates are also present beneath the nested application folder; they remain development material rather than application navigation.

### Stale gated-route files (important)

The cPanel deploy is **copy-only** — it never deletes files the repository
removed or renamed. If you rename or replace a gated route, the **old, possibly
ungated file stays live on the server and can bypass the gate**. After any such
change, remove the stale file over SSH, for example:

```bash
rm -f ~/public_html/devsite/iainreiddotdev/x/old-name.php
# or an entire renamed experiment folder:
rm -rf ~/public_html/devsite/iainreiddotdev/x/old-slug
```

Then re-verify the old URL returns 404 and the new one is gated. See
`docs/EXPERIMENT_VISIBILITY.md` for the full verification procedure.
