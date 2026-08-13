<?php

declare(strict_types=1);

/**
 * Private-first experiment visibility and idea helpers for VibeKB.
 *
 * An experiment can be deployed to production before it is publicly
 * discoverable: used privately, then by a few invited testers, then published
 * only after it earns public access. This file holds the shared, server-side
 * gate and its supporting read/invite helpers.
 *
 * The experiments table is also the SaaS idea record. Internal names may still
 * say "experiment"; the private admin UI prefers "idea".
 *
 * Two independent concepts:
 *   - visibility ('private' | 'invite' | 'public') answers "who may access this?"
 *     Authorization is derived ONLY from visibility (+ admin + invite).
 *   - status is informational ("where is this idea in its lifecycle?"). It is
 *     NEVER used for access control.
 *
 * The single most important rule for a gated page: call
 * require_experiment_access('<slug>') as the FIRST thing after including the
 * bootstrap, before any HTML, whitespace, BOM, title, metadata, or query. The
 * 404 gate can only work before any byte of output is sent.
 */

/** Allowed visibility values (also enforced by a CHECK constraint). */
const EXPERIMENT_VISIBILITIES = ['private', 'invite', 'public'];

/**
 * Idea lifecycle statuses (informational only; enforced in application code).
 * Keep EXPERIMENT_STATUSES as the canonical list so existing call sites continue
 * to work without a risky rename.
 */
const EXPERIMENT_STATUSES = [
    'inbox',
    'exploring',
    'validating',
    'building',
    'testing',
    'launched',
    'paused',
    'archived',
];

/** Supported idea priorities. */
const EXPERIMENT_PRIORITIES = ['low', 'normal', 'high'];

/** Priority sort weight (higher first). */
const EXPERIMENT_PRIORITY_WEIGHT = [
    'high'   => 3,
    'normal' => 2,
    'low'    => 1,
];

function is_valid_experiment_visibility(string $visibility): bool
{
    return in_array($visibility, EXPERIMENT_VISIBILITIES, true);
}

function is_valid_experiment_status(string $status): bool
{
    return in_array($status, EXPERIMENT_STATUSES, true);
}

function is_valid_experiment_priority(string $priority): bool
{
    return in_array($priority, EXPERIMENT_PRIORITIES, true);
}

/**
 * Fetch an experiment by its slug, or null if none exists.
 */
function find_experiment_by_slug(string $slug): ?array
{
    $stmt = db()->prepare('SELECT * FROM experiments WHERE slug = :slug');
    $stmt->execute([':slug' => $slug]);
    $row = $stmt->fetch();
    return $row === false ? null : $row;
}

/**
 * Fetch an experiment by its id, or null if none exists.
 */
function find_experiment_by_id(int $id): ?array
{
    $stmt = db()->prepare('SELECT * FROM experiments WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch();
    return $row === false ? null : $row;
}

/**
 * Whether the given user id holds an invite to the given experiment.
 */
function is_user_invited_to_experiment(int $experimentId, int $userId): bool
{
    $stmt = db()->prepare(
        'SELECT 1 FROM experiment_invites WHERE experiment_id = :eid AND user_id = :uid'
    );
    $stmt->execute([':eid' => $experimentId, ':uid' => $userId]);
    return $stmt->fetchColumn() !== false;
}

/**
 * Pure authorization decision for an already-loaded experiment record.
 *
 *   - public                       -> allow
 *   - admin                        -> allow
 *   - invite + logged in + invited -> allow
 *   - otherwise                    -> deny
 *
 * Never consults slug, route_path, URL, query params, referrer, non-session
 * cookies, navigation, CSS, or JavaScript.
 */
function can_access_experiment(array $experiment): bool
{
    $visibility = (string) ($experiment['visibility'] ?? 'private');

    if ($visibility === 'public') {
        return true;
    }
    if (is_admin()) {
        return true;
    }
    if ($visibility === 'invite' && is_logged_in()) {
        $user = current_user();
        return $user !== null
            && is_user_invited_to_experiment((int) $experiment['id'], (int) $user['id']);
    }

    return false;
}

/**
 * The gate. A gated page calls this with its own slug as its first action after
 * the bootstrap. On success it returns the experiment record; on any denial (or
 * a genuinely missing slug) it renders a real HTTP 404 and terminates. The 404
 * body is identical whether the experiment is missing, private, or invite-only
 * and the caller is unauthorized, so existence never leaks.
 */
function require_experiment_access(string $slug): array
{
    $experiment = find_experiment_by_slug($slug);

    if ($experiment === null || !can_access_experiment($experiment)) {
        render_not_found();
    }

    return $experiment;
}

/**
 * Public, non-archived ideas for safe public listings.
 * Never returns private/invite rows or internal note fields beyond the row.
 */
function list_public_experiments(): array
{
    return db()
        ->query(
            "SELECT id, experiment_code, slug, name, description, status, published_at, updated_at
               FROM experiments
              WHERE visibility = 'public'
                AND status != 'archived'
              ORDER BY published_at DESC, id DESC"
        )
        ->fetchAll();
}

/**
 * Count of public, non-archived ideas — safe for the public VibeKB page.
 */
function count_public_ideas(): int
{
    return (int) db()
        ->query(
            "SELECT COUNT(*) FROM experiments
              WHERE visibility = 'public' AND status != 'archived'"
        )
        ->fetchColumn();
}

/**
 * Invite-visibility experiments the given user has been invited to. Scoped to
 * that user's own invite rows only; never enumerates another user's invites or
 * admin-only private experiments.
 */
function list_user_invited_experiments(int $userId): array
{
    $stmt = db()->prepare(
        "SELECT e.*
           FROM experiments e
           JOIN experiment_invites i ON i.experiment_id = e.id
          WHERE i.user_id = :uid
            AND e.visibility = 'invite'
          ORDER BY e.updated_at DESC, e.id DESC"
    );
    $stmt->execute([':uid' => $userId]);
    return $stmt->fetchAll();
}

/**
 * Users invited to an experiment (for the admin management view).
 */
function list_experiment_invites(int $experimentId): array
{
    $stmt = db()->prepare(
        'SELECT u.id, u.name, u.email, i.created_at
           FROM experiment_invites i
           JOIN users u ON u.id = i.user_id
          WHERE i.experiment_id = :eid
          ORDER BY u.email ASC'
    );
    $stmt->execute([':eid' => $experimentId]);
    return $stmt->fetchAll();
}

/**
 * Invited-user counts keyed by experiment id (for the registry list).
 */
function experiment_invite_counts(): array
{
    $rows = db()
        ->query('SELECT experiment_id, COUNT(*) AS n FROM experiment_invites GROUP BY experiment_id')
        ->fetchAll();
    $counts = [];
    foreach ($rows as $row) {
        $counts[(int) $row['experiment_id']] = (int) $row['n'];
    }
    return $counts;
}

/**
 * Grant an invite. Returns true if a new row was created, false if the user was
 * already invited (duplicate). The caller must have verified admin rights and
 * that both the experiment and user exist.
 */
function invite_user_to_experiment(int $experimentId, int $userId, int $adminId): bool
{
    if (is_user_invited_to_experiment($experimentId, $userId)) {
        return false;
    }
    $stmt = db()->prepare(
        'INSERT INTO experiment_invites (experiment_id, user_id, created_by, created_at)
         VALUES (:eid, :uid, :by, :at)'
    );
    $stmt->execute([
        ':eid' => $experimentId,
        ':uid' => $userId,
        ':by'  => $adminId,
        ':at'  => gmdate('Y-m-d H:i:s'),
    ]);
    return true;
}

/**
 * Remove an invite, revoking access immediately.
 */
function remove_experiment_invite(int $experimentId, int $userId): void
{
    $stmt = db()->prepare(
        'DELETE FROM experiment_invites WHERE experiment_id = :eid AND user_id = :uid'
    );
    $stmt->execute([':eid' => $experimentId, ':uid' => $userId]);
}

/**
 * Trim control characters and cap length for display/text fields.
 */
function clean_idea_text(string $value, int $max = 255): string
{
    $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/', '', $value) ?? '';
    return mb_substr(trim($value), 0, $max);
}

/**
 * Like clean_idea_text but preserves newlines for notes/textareas.
 */
function clean_idea_multiline(string $value, int $max = 8000): string
{
    $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/', '', $value) ?? '';
    $value = str_replace(["\r\n", "\r"], "\n", $value);
    return mb_substr(trim($value), 0, $max);
}

/**
 * ASCII-safe slug from an idea name.
 */
function slugify_idea_name(string $name): string
{
    $slug = strtolower(trim($name));
    if (function_exists('iconv')) {
        $transliterated = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $slug);
        if (is_string($transliterated) && $transliterated !== '') {
            $slug = strtolower($transliterated);
        }
    }
    // Fallback for a few common non-ASCII letters when iconv is unavailable.
    $slug = strtr($slug, [
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a',
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
        'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
        'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
        'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u',
        'ñ' => 'n', 'ç' => 'c', 'ß' => 'ss', 'œ' => 'oe', 'æ' => 'ae',
        '’' => '', "'" => '',
    ]);
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug) ?? '';
    $slug = trim($slug, '-');
    $slug = preg_replace('/-+/', '-', $slug) ?? '';
    if ($slug === '') {
        $slug = 'idea';
    }
    return mb_substr($slug, 0, 80);
}

/**
 * Ensure a slug is unique, appending -2, -3, ... when needed.
 * Pass $excludeId when updating an existing idea so it can keep its own slug.
 */
function unique_idea_slug(string $baseSlug, ?int $excludeId = null): string
{
    $baseSlug = slugify_idea_name($baseSlug);
    $candidate = $baseSlug;
    $n = 2;

    while (true) {
        if ($excludeId === null) {
            $stmt = db()->prepare('SELECT id FROM experiments WHERE slug = :slug LIMIT 1');
            $stmt->execute([':slug' => $candidate]);
        } else {
            $stmt = db()->prepare(
                'SELECT id FROM experiments WHERE slug = :slug AND id != :id LIMIT 1'
            );
            $stmt->execute([':slug' => $candidate, ':id' => $excludeId]);
        }
        if ($stmt->fetch() === false) {
            return $candidate;
        }
        $suffix = '-' . $n;
        $trimmedBase = mb_substr($baseSlug, 0, max(1, 80 - mb_strlen($suffix)));
        $candidate = $trimmedBase . $suffix;
        $n++;
        if ($n > 1000) {
            // Extremely defensive fallback; uniqueness still enforced by DB.
            return $baseSlug . '-' . bin2hex(random_bytes(3));
        }
    }
}

/**
 * Next available IDEA-NNN code. Inspects existing codes; never uses row count.
 * Legacy nonstandard codes are ignored for sequencing.
 */
function next_idea_code(): string
{
    $rows = db()
        ->query("SELECT experiment_code FROM experiments WHERE experiment_code LIKE 'IDEA-%'")
        ->fetchAll();

    $max = 0;
    foreach ($rows as $row) {
        $code = (string) ($row['experiment_code'] ?? '');
        if (preg_match('/^IDEA-(\d+)$/', $code, $m) === 1) {
            $max = max($max, (int) $m[1]);
        }
    }

    return sprintf('IDEA-%03d', $max + 1);
}

/**
 * Create a new idea with inbox/normal/private defaults and auto code/slug.
 * Returns the new id.
 *
 * @throws PDOException on unexpected database failure
 */
function create_idea(string $name, string $description, int $createdBy): int
{
    $now = gmdate('Y-m-d H:i:s');
    $code = next_idea_code();
    $slug = unique_idea_slug($name);

    // Retry once if a concurrent insert races on code uniqueness.
    for ($attempt = 0; $attempt < 3; $attempt++) {
        try {
            $stmt = db()->prepare(
                'INSERT INTO experiments
                    (experiment_code, slug, name, description, visibility, route_path, status,
                     created_by, created_at, updated_at, published_at,
                     problem, target_user, priority, next_action, notes,
                     hypothesis, evidence, decision, lessons, archived_at)
                 VALUES
                    (:code, :slug, :name, :desc, :vis, NULL, :status,
                     :by, :created, :updated, NULL,
                     \'\', \'\', :priority, \'\', \'\',
                     \'\', \'\', \'\', \'\', NULL)'
            );
            $stmt->execute([
                ':code'     => $code,
                ':slug'     => $slug,
                ':name'     => $name,
                ':desc'     => $description,
                ':vis'      => 'private',
                ':status'   => 'inbox',
                ':by'       => $createdBy,
                ':created'  => $now,
                ':updated'  => $now,
                ':priority' => 'normal',
            ]);
            return (int) db()->lastInsertId();
        } catch (PDOException $ex) {
            if ($ex->getCode() !== '23000') {
                throw $ex;
            }
            $code = next_idea_code();
            $slug = unique_idea_slug($name);
        }
    }

    throw new PDOException('Unable to allocate a unique idea code or slug.');
}

/**
 * Summary counts for the Ideas dashboard (active excludes archived).
 *
 * @return array{active:int,inbox:int,building:int,testing:int,launched:int,paused:int,archived:int}
 */
function idea_dashboard_counts(): array
{
    $counts = [
        'active'   => 0,
        'inbox'    => 0,
        'building' => 0,
        'testing'  => 0,
        'launched' => 0,
        'paused'   => 0,
        'archived' => 0,
    ];

    $rows = db()
        ->query('SELECT status, COUNT(*) AS n FROM experiments GROUP BY status')
        ->fetchAll();

    foreach ($rows as $row) {
        $status = (string) $row['status'];
        $n = (int) $row['n'];
        if (isset($counts[$status])) {
            $counts[$status] = $n;
        }
        if ($status !== 'archived') {
            $counts['active'] += $n;
        }
    }

    return $counts;
}

/**
 * List ideas for the admin dashboard with search, filters, and sort.
 *
 * @param array{
 *   q?:string,
 *   status?:string,
 *   priority?:string,
 *   visibility?:string,
 *   archive?:string,
 *   sort?:string
 * } $filters
 */
function list_ideas_for_dashboard(array $filters = []): array
{
    $where = [];
    $params = [];

    $q = trim((string) ($filters['q'] ?? ''));
    if ($q !== '') {
        $where[] = '(name LIKE :q OR description LIKE :q OR problem LIKE :q'
            . ' OR target_user LIKE :q OR notes LIKE :q OR next_action LIKE :q'
            . ' OR experiment_code LIKE :q)';
        $params[':q'] = '%' . $q . '%';
    }

    $status = (string) ($filters['status'] ?? '');
    if ($status !== '' && is_valid_experiment_status($status)) {
        $where[] = 'status = :status';
        $params[':status'] = $status;
    }

    $priority = (string) ($filters['priority'] ?? '');
    if ($priority !== '' && is_valid_experiment_priority($priority)) {
        $where[] = 'priority = :priority';
        $params[':priority'] = $priority;
    }

    $visibility = (string) ($filters['visibility'] ?? '');
    if ($visibility !== '' && is_valid_experiment_visibility($visibility)) {
        $where[] = 'visibility = :visibility';
        $params[':visibility'] = $visibility;
    }

    $archive = (string) ($filters['archive'] ?? 'active');
    if ($archive === 'archived') {
        $where[] = "status = 'archived'";
    } elseif ($archive === 'all') {
        // no archive constraint
    } else {
        // Default: active (non-archived)
        $where[] = "status != 'archived'";
    }

    $sql = 'SELECT * FROM experiments';
    if ($where !== []) {
        $sql .= ' WHERE ' . implode(' AND ', $where);
    }

    $sort = (string) ($filters['sort'] ?? 'updated');
    $order = match ($sort) {
        'oldest'   => 'CASE WHEN status = \'archived\' THEN 1 ELSE 0 END ASC, updated_at ASC, id ASC',
        'priority' => 'CASE WHEN status = \'archived\' THEN 1 ELSE 0 END ASC,'
            . ' CASE priority WHEN \'high\' THEN 3 WHEN \'normal\' THEN 2 WHEN \'low\' THEN 1 ELSE 0 END DESC,'
            . ' updated_at DESC, id DESC',
        'name'     => 'CASE WHEN status = \'archived\' THEN 1 ELSE 0 END ASC, name COLLATE NOCASE ASC, id ASC',
        'stage'    => 'CASE WHEN status = \'archived\' THEN 1 ELSE 0 END ASC, status ASC, updated_at DESC, id DESC',
        default    => 'CASE WHEN status = \'archived\' THEN 1 ELSE 0 END ASC,'
            . ' CASE priority WHEN \'high\' THEN 3 WHEN \'normal\' THEN 2 WHEN \'low\' THEN 1 ELSE 0 END DESC,'
            . ' updated_at DESC, id DESC',
    };

    // Default sort from the product brief: non-archived, higher priority, recent.
    // "updated" and unknown values use that default.
    $sql .= ' ORDER BY ' . $order;

    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

/**
 * Archive an idea (status + timestamp). Never deletes.
 */
function archive_idea(int $id): void
{
    $now = gmdate('Y-m-d H:i:s');
    $stmt = db()->prepare(
        "UPDATE experiments
            SET status = 'archived', archived_at = :at, updated_at = :now
          WHERE id = :id"
    );
    $stmt->execute([':at' => $now, ':now' => $now, ':id' => $id]);
}

/**
 * Restore an archived idea to inbox.
 */
function restore_idea(int $id): void
{
    $now = gmdate('Y-m-d H:i:s');
    $stmt = db()->prepare(
        "UPDATE experiments
            SET status = 'inbox', archived_at = NULL, updated_at = :now
          WHERE id = :id"
    );
    $stmt->execute([':now' => $now, ':id' => $id]);
}

/**
 * Human label for a status value.
 */
function idea_status_label(string $status): string
{
    return match ($status) {
        'inbox'      => 'Inbox',
        'exploring'  => 'Exploring',
        'validating' => 'Validating',
        'building'   => 'Building',
        'testing'    => 'Testing',
        'launched'   => 'Launched',
        'paused'     => 'Paused',
        'archived'   => 'Archived',
        default      => $status,
    };
}

/**
 * Human label for a priority value.
 */
function idea_priority_label(string $priority): string
{
    return match ($priority) {
        'low'    => 'Low',
        'normal' => 'Normal',
        'high'   => 'High',
        default  => $priority,
    };
}

/**
 * Render a generic "Page not found" page and terminate.
 *
 * The gate's privacy guarantee depends entirely on this running before any
 * output. If output has already begun the HTTP status is already 200 and cannot
 * be changed to 404 — that would be the forbidden "200 not found" degradation.
 * We therefore fail LOUDLY (log with the exact location, and, when errors are
 * displayed, raise) rather than silently pretending success. In all cases we
 * never render the protected content.
 */
function render_not_found(): never
{
    if (headers_sent($file, $line)) {
        error_log(sprintf(
            'VibeKB experiment gate: output already started at %s:%d — cannot send 404. '
            . 'The gated page must call require_experiment_access() before any output.',
            $file,
            (int) $line
        ));
        // Loud failure: never a silent 200 that could imply the page exists.
        // display_errors is off in production, so this becomes a generic 500
        // rather than leaking; in development it surfaces the ordering bug.
        throw new RuntimeException(
            'Experiment gate invoked after output started; fix the page to gate before output.'
        );
    }

    http_response_code(404);

    if (function_exists('render_page_top')) {
        require_once __DIR__ . '/layout.php';
        render_page_top('Page not found');
        echo '<section class="auth-card auth-card--narrow" aria-labelledby="nf-title">'
            . '<p class="mono">404</p>'
            . '<h1 id="nf-title">Page not found</h1>'
            . '<p class="auth-lede">The page you were looking for does not exist.</p>'
            . '<p><a class="btn btn--ghost" href="' . e(url('saas-lab/')) . '">Back to VibeKB</a></p>'
            . '</section>';
        render_page_bottom();
    } else {
        header('Content-Type: text/html; charset=utf-8');
        echo '<!doctype html><meta charset="utf-8"><title>Page not found</title>'
            . '<h1>Page not found</h1><p>The page you were looking for does not exist.</p>';
    }

    exit;
}
