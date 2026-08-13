<?php

declare(strict_types=1);

require __DIR__ . '/../includes/bootstrap.php';
require __DIR__ . '/../includes/layout.php';

require_login();

$user = current_user();

render_page_top('Your account', 'account');
?>
<section class="auth-card" aria-labelledby="account-title">
    <p class="mono">Account Access · Account record</p>
    <h1 id="account-title">Your VibeKB account</h1>

    <dl class="record">
        <div class="record__row">
            <dt>Name</dt>
            <dd><?= e($user['name']) ?></dd>
        </div>
        <div class="record__row">
            <dt>Email</dt>
            <dd><?= e($user['email']) ?></dd>
        </div>
        <div class="record__row">
            <dt>Role</dt>
            <dd><span class="tag tag--<?= e($user['role']) ?>"><?= e($user['role']) ?></span></dd>
        </div>
        <div class="record__row">
            <dt>Account created</dt>
            <dd><?= e($user['created_at']) ?> UTC</dd>
        </div>
    </dl>

    <p class="auth-note">
        This account will eventually provide shared access to VibeKB and
        related workshop tools as they come online. For now it simply
        establishes your identity.
    </p>

    <?php if (is_admin()): ?>
        <p><a class="btn btn--primary" href="<?= e(url('admin/experiments.php')) ?>">Open Ideas</a></p>
        <p><a class="btn btn--ghost" href="<?= e(url('admin/')) ?>">Open admin console</a></p>
    <?php endif; ?>

    <form method="post" action="<?= e(url('auth/logout.php')) ?>" class="auth-form auth-form--inline">
        <?= csrf_field() ?>
        <button type="submit" class="btn btn--quiet">Log out</button>
    </form>
</section>

<section class="auth-card" aria-labelledby="private-title">
    <p class="mono">Lab Access · Private experiments</p>
    <h1 id="private-title">Private experiments</h1>
    <?php if (is_admin()): ?>
        <p class="auth-note">
            You are an administrator. Capture and manage SaaS ideas in the Ideas workspace.
        </p>
        <p><a class="btn btn--ghost" href="<?= e(url('admin/experiments.php')) ?>">Open Ideas</a></p>
    <?php else: ?>
        <?php $invited = list_user_invited_experiments((int) $user['id']); ?>
        <?php if ($invited === []): ?>
            <p class="auth-note">You have no private experiments yet. When you are invited to test one, it will appear here.</p>
        <?php else: ?>
            <ul class="private-list">
                <?php foreach ($invited as $exp): ?>
                    <li class="private-list__item">
                        <div>
                            <a class="private-list__name" href="<?= e(url('x/' . rawurlencode($exp['slug']) . '.php')) ?>"><?= e($exp['name']) ?></a>
                            <span class="tag"><?= e(idea_status_label((string) $exp['status'])) ?></span>
                            <?php if ($exp['description'] !== ''): ?>
                                <p class="private-list__desc"><?= e($exp['description']) ?></p>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    <?php endif; ?>
</section>
<?php
render_page_bottom();
