<?php

declare(strict_types=1);

require __DIR__ . '/../includes/bootstrap.php';
require __DIR__ . '/../includes/layout.php';

// Re-check admin authorization server-side on every request.
require_admin();

$admin = current_user();
$errors = [];
$create = ['name' => '', 'description' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate()) {
        http_response_code(400);
        $errors[] = 'Your session expired. Please try again.';
    } else {
        $action = (string) ($_POST['action'] ?? '');

        if ($action === 'create') {
            $create['name'] = clean_idea_text((string) ($_POST['name'] ?? ''), 120);
            $create['description'] = clean_idea_text((string) ($_POST['description'] ?? ''), 500);

            if ($create['name'] === '') {
                $errors['name'] = 'Enter an idea name.';
            }
            if ($create['description'] === '') {
                $errors['description'] = 'Enter a one-sentence concept.';
            }

            if ($errors === []) {
                try {
                    $newId = create_idea($create['name'], $create['description'], (int) $admin['id']);
                    $_SESSION['flash'] = 'Idea saved to Inbox.';
                    redirect(url('admin/experiment.php?id=' . $newId));
                } catch (PDOException $ex) {
                    $errors[] = 'Unable to create the idea. Please try again.';
                }
            }
        }
    }
}

$filters = [
    'q'          => trim((string) ($_GET['q'] ?? '')),
    'status'     => (string) ($_GET['status'] ?? ''),
    'priority'   => (string) ($_GET['priority'] ?? ''),
    'visibility' => (string) ($_GET['visibility'] ?? ''),
    'archive'    => (string) ($_GET['archive'] ?? 'active'),
    'sort'       => (string) ($_GET['sort'] ?? 'updated'),
];

if ($filters['status'] !== '' && !is_valid_experiment_status($filters['status'])) {
    $filters['status'] = '';
}
if ($filters['priority'] !== '' && !is_valid_experiment_priority($filters['priority'])) {
    $filters['priority'] = '';
}
if ($filters['visibility'] !== '' && !is_valid_experiment_visibility($filters['visibility'])) {
    $filters['visibility'] = '';
}
if (!in_array($filters['archive'], ['active', 'archived', 'all'], true)) {
    $filters['archive'] = 'active';
}
if (!in_array($filters['sort'], ['updated', 'oldest', 'priority', 'name', 'stage'], true)) {
    $filters['sort'] = 'updated';
}

$ideas = list_ideas_for_dashboard($filters);
$counts = idea_dashboard_counts();
$hasActiveFilters = $filters['q'] !== ''
    || $filters['status'] !== ''
    || $filters['priority'] !== ''
    || $filters['visibility'] !== ''
    || $filters['archive'] !== 'active'
    || $filters['sort'] !== 'updated';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

render_page_top('Ideas', 'ideas');
?>
<section class="auth-card auth-card--wide ideas-dash" aria-labelledby="ideas-title">
    <header class="ideas-dash__header">
        <div>
            <p class="mono">VibeKB · Idea manager</p>
            <h1 id="ideas-title">Ideas</h1>
            <p class="auth-lede">Capture, organize, and move product ideas forward.</p>
        </div>
        <a class="btn btn--primary" href="#new-idea">New idea</a>
    </header>

    <?php if ($flash !== null): ?>
        <p class="flash" role="status"><?= e($flash) ?></p>
    <?php endif; ?>

    <?php render_error_summary(array_values($errors)); ?>

    <ul class="summary ideas-summary" aria-label="Idea totals">
        <li class="summary__stat">
            <span class="summary__value"><?= e((string) $counts['active']) ?></span>
            <span class="summary__label">Active</span>
        </li>
        <li class="summary__stat">
            <span class="summary__value"><?= e((string) $counts['inbox']) ?></span>
            <span class="summary__label">Inbox</span>
        </li>
        <li class="summary__stat">
            <span class="summary__value"><?= e((string) $counts['building']) ?></span>
            <span class="summary__label">Building</span>
        </li>
        <li class="summary__stat">
            <span class="summary__value"><?= e((string) $counts['testing']) ?></span>
            <span class="summary__label">Testing</span>
        </li>
        <li class="summary__stat">
            <span class="summary__value"><?= e((string) $counts['launched']) ?></span>
            <span class="summary__label">Launched</span>
        </li>
        <li class="summary__stat">
            <span class="summary__value"><?= e((string) $counts['paused']) ?></span>
            <span class="summary__label">Paused</span>
        </li>
    </ul>

    <form method="get" action="<?= e(url('admin/experiments.php')) ?>" class="ideas-filters" role="search">
        <div class="ideas-filters__row">
            <div class="field ideas-filters__search">
                <label for="q">Search ideas</label>
                <input type="search" id="q" name="q" value="<?= e($filters['q']) ?>" placeholder="Name, problem, notes, next action…">
            </div>
            <div class="field">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="">All stages</option>
                    <?php foreach (EXPERIMENT_STATUSES as $s): ?>
                        <option value="<?= e($s) ?>"<?= $filters['status'] === $s ? ' selected' : '' ?>><?= e(idea_status_label($s)) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="field">
                <label for="priority">Priority</label>
                <select id="priority" name="priority">
                    <option value="">All priorities</option>
                    <?php foreach (EXPERIMENT_PRIORITIES as $p): ?>
                        <option value="<?= e($p) ?>"<?= $filters['priority'] === $p ? ' selected' : '' ?>><?= e(idea_priority_label($p)) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="field">
                <label for="visibility">Visibility</label>
                <select id="visibility" name="visibility">
                    <option value="">All access</option>
                    <?php foreach (EXPERIMENT_VISIBILITIES as $v): ?>
                        <option value="<?= e($v) ?>"<?= $filters['visibility'] === $v ? ' selected' : '' ?>><?= e($v) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="field">
                <label for="archive">Active / archived</label>
                <select id="archive" name="archive">
                    <option value="active"<?= $filters['archive'] === 'active' ? ' selected' : '' ?>>Active only</option>
                    <option value="archived"<?= $filters['archive'] === 'archived' ? ' selected' : '' ?>>Archived only</option>
                    <option value="all"<?= $filters['archive'] === 'all' ? ' selected' : '' ?>>All ideas</option>
                </select>
            </div>
            <div class="field">
                <label for="sort">Sort</label>
                <select id="sort" name="sort">
                    <option value="updated"<?= $filters['sort'] === 'updated' ? ' selected' : '' ?>>Recently updated</option>
                    <option value="oldest"<?= $filters['sort'] === 'oldest' ? ' selected' : '' ?>>Oldest updated</option>
                    <option value="priority"<?= $filters['sort'] === 'priority' ? ' selected' : '' ?>>Priority</option>
                    <option value="name"<?= $filters['sort'] === 'name' ? ' selected' : '' ?>>Name</option>
                    <option value="stage"<?= $filters['sort'] === 'stage' ? ' selected' : '' ?>>Stage</option>
                </select>
            </div>
        </div>
        <div class="ideas-filters__actions">
            <button type="submit" class="btn btn--ghost">Apply filters</button>
            <?php if ($hasActiveFilters): ?>
                <a class="btn btn--quiet" href="<?= e(url('admin/experiments.php')) ?>">Clear filters</a>
            <?php endif; ?>
        </div>
    </form>

    <section class="ideas-capture" id="new-idea" aria-labelledby="capture-title">
        <h2 class="admin-subhead" id="capture-title">Quick capture</h2>
        <p class="auth-note">Name it, describe it in one sentence, and save it to Inbox. Stage, priority, and access stay private by default.</p>
        <form method="post" action="<?= e(url('admin/experiments.php')) ?>" class="auth-form ideas-capture__form" novalidate>
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="create">
            <div class="field<?= isset($errors['name']) ? ' field--error' : '' ?>">
                <label for="name">Idea name</label>
                <input type="text" id="name" name="name" value="<?= e($create['name']) ?>" required maxlength="120" autocomplete="off">
                <?php if (isset($errors['name'])): ?><p class="field__error"><?= e($errors['name']) ?></p><?php endif; ?>
            </div>
            <div class="field<?= isset($errors['description']) ? ' field--error' : '' ?>">
                <label for="description">One-sentence concept</label>
                <input type="text" id="description" name="description" value="<?= e($create['description']) ?>" required maxlength="500" autocomplete="off">
                <?php if (isset($errors['description'])): ?><p class="field__error"><?= e($errors['description']) ?></p><?php endif; ?>
            </div>
            <button type="submit" class="btn btn--primary">Save to Inbox</button>
        </form>
    </section>

    <h2 class="admin-subhead">Your ideas</h2>

    <?php if ($ideas === []): ?>
        <?php if ($hasActiveFilters): ?>
            <div class="ideas-empty">
                <p>No ideas match these filters.</p>
                <p><a class="btn btn--ghost" href="<?= e(url('admin/experiments.php')) ?>">Clear filters</a></p>
            </div>
        <?php else: ?>
            <div class="ideas-empty">
                <p>No SaaS ideas yet.</p>
                <p>Capture the first one before it disappears.</p>
                <p><a class="btn btn--primary" href="#new-idea">New idea</a></p>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <ul class="idea-list">
            <?php foreach ($ideas as $idea): ?>
                <?php
                $workspaceUrl = url('admin/experiment.php?id=' . (int) $idea['id']);
                $nextAction = trim((string) ($idea['next_action'] ?? ''));
                $isPaused = $idea['status'] === 'paused';
                $isArchived = $idea['status'] === 'archived';
                ?>
                <li class="idea-card<?= $isPaused ? ' idea-card--paused' : '' ?><?= $isArchived ? ' idea-card--archived' : '' ?>">
                    <a class="idea-card__link" href="<?= e($workspaceUrl) ?>">
                        <div class="idea-card__top">
                            <span class="idea-card__code"><?= e($idea['experiment_code']) ?></span>
                            <span class="idea-card__vis" title="Visibility"><?= e($idea['visibility']) ?></span>
                        </div>
                        <h3 class="idea-card__name"><?= e($idea['name']) ?></h3>
                        <?php if ($idea['description'] !== ''): ?>
                            <p class="idea-card__desc"><?= e($idea['description']) ?></p>
                        <?php endif; ?>
                        <div class="idea-card__meta">
                            <span class="badge badge--status badge--<?= e($idea['status']) ?>"><?= e(idea_status_label($idea['status'])) ?></span>
                            <span class="badge badge--priority badge--pri-<?= e($idea['priority'] ?? 'normal') ?>"><?= e(idea_priority_label((string) ($idea['priority'] ?? 'normal'))) ?></span>
                            <span class="idea-card__updated">Updated <?= e(substr((string) $idea['updated_at'], 0, 10)) ?></span>
                        </div>
                        <p class="idea-card__next<?= $nextAction === '' ? ' idea-card__next--empty' : '' ?>">
                            <span class="idea-card__next-label">Next action</span>
                            <?= e($nextAction !== '' ? $nextAction : 'No next action set') ?>
                        </p>
                    </a>
                    <p class="idea-card__open"><a href="<?= e($workspaceUrl) ?>">Open workspace</a></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>
<?php
render_page_bottom();
