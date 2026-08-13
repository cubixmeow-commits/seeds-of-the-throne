<?php

declare(strict_types=1);

require __DIR__ . '/../includes/bootstrap.php';
require __DIR__ . '/../includes/layout.php';

require_admin();

$admin = current_user();

// Resolve the target idea from a verified database record, never trusting
// the raw id for anything beyond the lookup.
$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
$experiment = find_experiment_by_id($id);

$errors = [];
$inviteError = null;

// Form state for sticky values on validation errors.
$form = null;

if ($experiment !== null && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate()) {
        http_response_code(400);
        $errors[] = 'Your session expired. Please try again.';
    } else {
        $action = (string) ($_POST['action'] ?? '');
        $now = gmdate('Y-m-d H:i:s');

        if ($action === 'save_idea') {
            $form = [
                'name'        => clean_idea_text((string) ($_POST['name'] ?? ''), 120),
                'description' => clean_idea_text((string) ($_POST['description'] ?? ''), 500),
                'problem'     => clean_idea_multiline((string) ($_POST['problem'] ?? ''), 4000),
                'target_user' => clean_idea_text((string) ($_POST['target_user'] ?? ''), 255),
                'status'      => (string) ($_POST['status'] ?? ''),
                'priority'    => (string) ($_POST['priority'] ?? ''),
                'next_action' => clean_idea_text((string) ($_POST['next_action'] ?? ''), 500),
                'hypothesis'  => clean_idea_multiline((string) ($_POST['hypothesis'] ?? ''), 4000),
                'decision'    => clean_idea_multiline((string) ($_POST['decision'] ?? ''), 4000),
                'notes'       => clean_idea_multiline((string) ($_POST['notes'] ?? ''), 8000),
                'evidence'    => clean_idea_multiline((string) ($_POST['evidence'] ?? ''), 8000),
                'lessons'     => clean_idea_multiline((string) ($_POST['lessons'] ?? ''), 8000),
                'visibility'  => (string) ($_POST['visibility'] ?? ''),
                'slug'        => strtolower(clean_idea_text((string) ($_POST['slug'] ?? ''), 80)),
                'route_path'  => clean_idea_text((string) ($_POST['route_path'] ?? ''), 255),
            ];

            if ($form['name'] === '') {
                $errors['name'] = 'Enter an idea name.';
            }
            if ($form['description'] === '') {
                $errors['description'] = 'Enter a one-sentence concept.';
            }
            if (!is_valid_experiment_status($form['status'])) {
                $errors['status'] = 'Choose a valid status.';
            }
            if (!is_valid_experiment_priority($form['priority'])) {
                $errors['priority'] = 'Choose a valid priority.';
            }
            if (!is_valid_experiment_visibility($form['visibility'])) {
                $errors['visibility'] = 'Choose a valid visibility.';
            }
            if ($form['slug'] === '' || !preg_match('/^[a-z0-9][a-z0-9-]*$/', $form['slug'])) {
                $errors['slug'] = 'Slug must be lowercase letters, numbers, and hyphens.';
            }

            if ($errors === []) {
                // Enforce slug uniqueness; if the advanced slug conflicts, reject.
                $slugCheck = unique_idea_slug($form['slug'], (int) $experiment['id']);
                if ($slugCheck !== $form['slug'] && $form['slug'] !== $experiment['slug']) {
                    // User typed a taken slug (unique_idea_slug would append -2).
                    $stmt = db()->prepare(
                        'SELECT id FROM experiments WHERE slug = :slug AND id != :id LIMIT 1'
                    );
                    $stmt->execute([':slug' => $form['slug'], ':id' => (int) $experiment['id']]);
                    if ($stmt->fetch() !== false) {
                        $errors['slug'] = 'That slug is already in use.';
                    }
                }
            }

            if ($errors === []) {
                $publishedAt = $experiment['published_at'];
                if ($form['visibility'] === 'public' && $publishedAt === null) {
                    $publishedAt = $now;
                }

                $archivedAt = $experiment['archived_at'];
                if ($form['status'] === 'archived') {
                    if ($archivedAt === null) {
                        $archivedAt = $now;
                    }
                } else {
                    $archivedAt = null;
                }

                try {
                    $stmt = db()->prepare(
                        'UPDATE experiments SET
                            name = :name,
                            description = :desc,
                            problem = :problem,
                            target_user = :target,
                            status = :status,
                            priority = :priority,
                            next_action = :next,
                            hypothesis = :hyp,
                            decision = :decision,
                            notes = :notes,
                            evidence = :evidence,
                            lessons = :lessons,
                            visibility = :vis,
                            slug = :slug,
                            route_path = :route,
                            published_at = :pub,
                            archived_at = :archived,
                            updated_at = :now
                          WHERE id = :id'
                    );
                    $stmt->execute([
                        ':name'     => $form['name'],
                        ':desc'     => $form['description'],
                        ':problem'  => $form['problem'],
                        ':target'   => $form['target_user'],
                        ':status'   => $form['status'],
                        ':priority' => $form['priority'],
                        ':next'     => $form['next_action'],
                        ':hyp'      => $form['hypothesis'],
                        ':decision' => $form['decision'],
                        ':notes'    => $form['notes'],
                        ':evidence' => $form['evidence'],
                        ':lessons'  => $form['lessons'],
                        ':vis'      => $form['visibility'],
                        ':slug'     => $form['slug'],
                        ':route'    => $form['route_path'] !== '' ? $form['route_path'] : null,
                        ':pub'      => $publishedAt,
                        ':archived' => $archivedAt,
                        ':now'      => $now,
                        ':id'       => (int) $experiment['id'],
                    ]);
                    $_SESSION['flash'] = 'Idea saved.';
                    redirect(url('admin/experiment.php?id=' . (int) $experiment['id']));
                } catch (PDOException $ex) {
                    if ($ex->getCode() === '23000') {
                        $errors[] = 'That slug is already in use.';
                    } else {
                        $errors[] = 'Unable to save the idea. Please try again.';
                    }
                }
            }
        } elseif ($action === 'archive') {
            archive_idea((int) $experiment['id']);
            $_SESSION['flash'] = 'Idea archived.';
            redirect(url('admin/experiment.php?id=' . (int) $experiment['id']));
        } elseif ($action === 'restore') {
            restore_idea((int) $experiment['id']);
            $_SESSION['flash'] = 'Idea restored to Inbox.';
            redirect(url('admin/experiment.php?id=' . (int) $experiment['id']));
        } elseif ($action === 'add_invite') {
            $email = strtolower(trim((string) ($_POST['email'] ?? '')));
            $stmt = db()->prepare('SELECT id FROM users WHERE email = :email');
            $stmt->execute([':email' => $email]);
            $userRow = $stmt->fetch();
            if ($userRow === false) {
                // No such registered user: change nothing, create nothing, send nothing.
                $inviteError = 'No registered user matches that email address.';
            } else {
                $created = invite_user_to_experiment((int) $experiment['id'], (int) $userRow['id'], (int) $admin['id']);
                $_SESSION['flash'] = $created ? 'Invite added.' : 'That user is already invited.';
                redirect(url('admin/experiment.php?id=' . (int) $experiment['id']));
            }
        } elseif ($action === 'remove_invite') {
            $userId = (int) ($_POST['user_id'] ?? 0);
            remove_experiment_invite((int) $experiment['id'], $userId);
            $_SESSION['flash'] = 'Invite removed.';
            redirect(url('admin/experiment.php?id=' . (int) $experiment['id']));
        }
    }
}

// A missing idea gets the generic admin 404 (this is an admin tool, so a
// real 404 is appropriate here; the privacy gate for public routes is separate).
if ($experiment === null) {
    render_not_found();
}

// Reload after any in-request edits so the form shows current values.
$experiment = find_experiment_by_id((int) $experiment['id']) ?? $experiment;
$invites = list_experiment_invites((int) $experiment['id']);

// Prefer sticky form values after validation errors.
$v = static function (string $key) use ($form, $experiment): string {
    if ($form !== null && array_key_exists($key, $form)) {
        return (string) $form[$key];
    }
    return (string) ($experiment[$key] ?? '');
};

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$isArchived = $experiment['status'] === 'archived';

render_page_top('Idea workspace', 'ideas');
?>
<section class="auth-card auth-card--wide idea-workspace" aria-labelledby="exp-title">
    <p class="mono">VibeKB · Idea workspace</p>
    <div class="idea-workspace__title">
        <h1 id="exp-title"><?= e($v('name') !== '' ? $v('name') : $experiment['name']) ?></h1>
        <span class="idea-workspace__code" title="Read-only idea code"><?= e($experiment['experiment_code']) ?></span>
    </div>
    <p class="idea-workspace__nav">
        <a class="btn btn--quiet" href="<?= e(url('admin/experiments.php')) ?>">← Ideas</a>
        <?php if ($isArchived): ?>
            <form method="post" action="<?= e(url('admin/experiment.php?id=' . (int) $experiment['id'])) ?>" class="idea-workspace__inline-form"
                  onsubmit="return confirm('Restore this idea to Inbox?');">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="restore">
                <input type="hidden" name="id" value="<?= e((string) $experiment['id']) ?>">
                <button type="submit" class="btn btn--ghost">Restore idea</button>
            </form>
        <?php else: ?>
            <form method="post" action="<?= e(url('admin/experiment.php?id=' . (int) $experiment['id'])) ?>" class="idea-workspace__inline-form"
                  onsubmit="return confirm('Archive this idea? It will leave the active list but will not be deleted.');">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="archive">
                <input type="hidden" name="id" value="<?= e((string) $experiment['id']) ?>">
                <button type="submit" class="btn btn--quiet">Archive idea</button>
            </form>
        <?php endif; ?>
    </p>

    <?php if ($flash !== null): ?>
        <p class="flash" role="status"><?= e($flash) ?></p>
    <?php endif; ?>

    <?php render_error_summary(array_values($errors)); ?>

    <form method="post" action="<?= e(url('admin/experiment.php?id=' . (int) $experiment['id'])) ?>" class="auth-form idea-workspace__form" novalidate>
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="save_idea">
        <input type="hidden" name="id" value="<?= e((string) $experiment['id']) ?>">

        <section class="idea-section" aria-labelledby="sec-overview">
            <h2 class="admin-subhead" id="sec-overview">Overview</h2>
            <div class="field<?= isset($errors['name']) ? ' field--error' : '' ?>">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?= e($v('name')) ?>" required maxlength="120">
                <?php if (isset($errors['name'])): ?><p class="field__error"><?= e($errors['name']) ?></p><?php endif; ?>
            </div>
            <div class="field<?= isset($errors['description']) ? ' field--error' : '' ?>">
                <label for="description">One-sentence concept</label>
                <textarea id="description" name="description" rows="2" maxlength="500" required><?= e($v('description')) ?></textarea>
                <?php if (isset($errors['description'])): ?><p class="field__error"><?= e($errors['description']) ?></p><?php endif; ?>
            </div>
            <div class="field">
                <label for="problem">Problem being solved</label>
                <textarea id="problem" name="problem" rows="3" maxlength="4000"><?= e($v('problem')) ?></textarea>
            </div>
            <div class="field">
                <label for="target_user">Target user</label>
                <input type="text" id="target_user" name="target_user" value="<?= e($v('target_user')) ?>" maxlength="255">
            </div>
            <div class="idea-section__pair">
                <div class="field<?= isset($errors['status']) ? ' field--error' : '' ?>">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <?php foreach (EXPERIMENT_STATUSES as $s): ?>
                            <option value="<?= e($s) ?>"<?= $v('status') === $s ? ' selected' : '' ?>><?= e(idea_status_label($s)) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['status'])): ?><p class="field__error"><?= e($errors['status']) ?></p><?php endif; ?>
                </div>
                <div class="field<?= isset($errors['priority']) ? ' field--error' : '' ?>">
                    <label for="priority">Priority</label>
                    <select id="priority" name="priority">
                        <?php foreach (EXPERIMENT_PRIORITIES as $p): ?>
                            <option value="<?= e($p) ?>"<?= $v('priority') === $p ? ' selected' : '' ?>><?= e(idea_priority_label($p)) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['priority'])): ?><p class="field__error"><?= e($errors['priority']) ?></p><?php endif; ?>
                </div>
            </div>
        </section>

        <section class="idea-section" aria-labelledby="sec-direction">
            <h2 class="admin-subhead" id="sec-direction">Current direction</h2>
            <div class="field field--next">
                <label for="next_action">Next action</label>
                <input type="text" id="next_action" name="next_action" value="<?= e($v('next_action')) ?>" maxlength="500" placeholder="No next action set">
                <p class="field__hint">The smallest concrete thing you should do next.</p>
            </div>
            <div class="field">
                <label for="hypothesis">Hypothesis</label>
                <textarea id="hypothesis" name="hypothesis" rows="3" maxlength="4000"><?= e($v('hypothesis')) ?></textarea>
            </div>
            <div class="field">
                <label for="decision">Decision needed</label>
                <textarea id="decision" name="decision" rows="3" maxlength="4000"><?= e($v('decision')) ?></textarea>
            </div>
        </section>

        <section class="idea-section" aria-labelledby="sec-notes">
            <h2 class="admin-subhead" id="sec-notes">Working notes</h2>
            <div class="field">
                <label for="notes">Notes</label>
                <textarea id="notes" name="notes" rows="5" maxlength="8000"><?= e($v('notes')) ?></textarea>
            </div>
            <div class="field">
                <label for="evidence">Evidence or observations</label>
                <textarea id="evidence" name="evidence" rows="4" maxlength="8000"><?= e($v('evidence')) ?></textarea>
            </div>
            <div class="field">
                <label for="lessons">Lessons learned</label>
                <textarea id="lessons" name="lessons" rows="4" maxlength="8000"><?= e($v('lessons')) ?></textarea>
            </div>
        </section>

        <details class="idea-advanced">
            <summary>Access and deployment</summary>
            <div class="idea-advanced__body">
                <p class="auth-note">
                    Visibility controls who may reach a gated experiment page.
                    Status does not grant access.
                    Private means owner/admin only.
                    Invite means invited registered users may access.
                    Public means publicly accessible where the route implements the experiment gate.
                </p>
                <div class="field<?= isset($errors['visibility']) ? ' field--error' : '' ?>">
                    <label for="visibility">Visibility</label>
                    <select id="visibility" name="visibility">
                        <?php foreach (EXPERIMENT_VISIBILITIES as $vis): ?>
                            <option value="<?= e($vis) ?>"<?= $v('visibility') === $vis ? ' selected' : '' ?>><?= e($vis) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['visibility'])): ?><p class="field__error"><?= e($errors['visibility']) ?></p><?php endif; ?>
                </div>
                <div class="field<?= isset($errors['slug']) ? ' field--error' : '' ?>">
                    <label for="slug">Slug</label>
                    <input type="text" id="slug" name="slug" value="<?= e($v('slug')) ?>" required maxlength="80">
                    <p class="field__hint">Used by the page gate. Changing it may break existing links.</p>
                    <?php if (isset($errors['slug'])): ?><p class="field__error"><?= e($errors['slug']) ?></p><?php endif; ?>
                </div>
                <div class="field">
                    <label for="route_path">Route path <span class="field__hint">(display-only note; never used for routing)</span></label>
                    <input type="text" id="route_path" name="route_path" value="<?= e($v('route_path')) ?>" maxlength="255">
                </div>
                <p class="auth-note">
                    Published: <?= e((string) ($experiment['published_at'] ?? '—')) ?> ·
                    Created: <?= e($experiment['created_at']) ?> UTC ·
                    Updated: <?= e($experiment['updated_at']) ?> UTC
                    <?php if ($experiment['archived_at']): ?>
                        · Archived: <?= e((string) $experiment['archived_at']) ?> UTC
                    <?php endif; ?>
                </p>
            </div>
        </details>

        <button type="submit" class="btn btn--primary">Save idea</button>
    </form>

    <section class="idea-section idea-section--invites" aria-labelledby="sec-invites">
        <h2 class="admin-subhead" id="sec-invites">Tester invitations</h2>
        <p class="auth-note">
            Invitations only grant access while visibility is <strong>invite</strong>.
            They apply to existing registered users only.
        </p>

        <?php if ($inviteError !== null): ?>
            <p class="field__error" role="alert"><?= e($inviteError) ?></p>
        <?php endif; ?>

        <?php if ($invites === []): ?>
            <p class="auth-note">No testers invited yet.</p>
        <?php else: ?>
            <div class="table-scroll">
                <table class="registry">
                    <thead>
                        <tr><th scope="col">Name</th><th scope="col">Email</th><th scope="col">Invited</th><th scope="col"></th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($invites as $inv): ?>
                            <tr>
                                <td><?= e($inv['name']) ?></td>
                                <td><?= e($inv['email']) ?></td>
                                <td><?= e($inv['created_at']) ?></td>
                                <td>
                                    <form method="post" action="<?= e(url('admin/experiment.php?id=' . (int) $experiment['id'])) ?>">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="action" value="remove_invite">
                                        <input type="hidden" name="id" value="<?= e((string) $experiment['id']) ?>">
                                        <input type="hidden" name="user_id" value="<?= e((string) $inv['id']) ?>">
                                        <button type="submit" class="btn btn--quiet">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= e(url('admin/experiment.php?id=' . (int) $experiment['id'])) ?>" class="auth-form" novalidate>
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="add_invite">
            <input type="hidden" name="id" value="<?= e((string) $experiment['id']) ?>">
            <div class="field">
                <label for="invite-email">Invite a registered user by email</label>
                <input type="email" id="invite-email" name="email" autocomplete="off" required>
            </div>
            <button type="submit" class="btn btn--ghost">Add invite</button>
        </form>
    </section>
</section>
<?php
render_page_bottom();
