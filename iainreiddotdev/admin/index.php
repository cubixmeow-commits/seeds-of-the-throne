<?php

declare(strict_types=1);

require __DIR__ . '/../includes/bootstrap.php';
require __DIR__ . '/../includes/layout.php';

// Server-side authorization on every request. Signed-out visitors are sent to
// login with a return path; signed-in non-admins get a clean HTTP 403 page.
require_admin();

$pdo = db();

$total = (int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
$admins = (int) $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'admin'")->fetchColumn();
$standard = $total - $admins;
$latest = $pdo->query('SELECT MAX(created_at) FROM users')->fetchColumn();
$latest = is_string($latest) ? $latest : null;

$users = $pdo->query(
    'SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC, id DESC'
)->fetchAll();

render_page_top('Admin console', 'admin');
?>
<section class="auth-card auth-card--wide" aria-labelledby="admin-title">
    <p class="mono">Admin console · User registry</p>
    <h1 id="admin-title">Admin console</h1>

    <p class="auth-lede">Workshop work happens in Ideas. This console is for account oversight.</p>
    <p><a class="btn btn--primary" href="<?= e(url('admin/experiments.php')) ?>">Open Ideas →</a></p>

    <ul class="summary" aria-label="Account totals">
        <li class="summary__stat">
            <span class="summary__value"><?= e((string) $total) ?></span>
            <span class="summary__label">Total users</span>
        </li>
        <li class="summary__stat">
            <span class="summary__value"><?= e((string) $admins) ?></span>
            <span class="summary__label">Administrators</span>
        </li>
        <li class="summary__stat">
            <span class="summary__value"><?= e((string) $standard) ?></span>
            <span class="summary__label">Standard users</span>
        </li>
        <li class="summary__stat">
            <span class="summary__value summary__value--date"><?= e($latest ?? '—') ?></span>
            <span class="summary__label">Most recent registration<?= $latest !== null ? ' (UTC)' : '' ?></span>
        </li>
    </ul>

    <h2 class="admin-subhead">Registered users</h2>
    <?php if ($users === []): ?>
        <p class="auth-note">No accounts have been registered yet.</p>
    <?php else: ?>
        <div class="table-scroll">
            <table class="registry">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Created (UTC)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $row): ?>
                        <tr>
                            <td><?= e((string) $row['id']) ?></td>
                            <td><?= e($row['name']) ?></td>
                            <td><?= e($row['email']) ?></td>
                            <td><span class="tag tag--<?= e($row['role']) ?>"><?= e($row['role']) ?></span></td>
                            <td><?= e($row['created_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>
<?php
render_page_bottom();
