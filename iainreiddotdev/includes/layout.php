<?php

declare(strict_types=1);

/**
 * Minimal shared view helpers for the VibeKB account pages.
 *
 * These render the small amount of page chrome the auth and admin screens
 * share, so each page stays a short, readable script while still looking like
 * the rest of the portfolio. No templating engine is involved; this is a pair
 * of echo helpers plus the access-denied and account-navigation partials.
 */

/**
 * Open an account-system page: <head>, shared header, and the start of <main>.
 * $active marks the current nav item ('account', 'admin', or 'ideas') for aria-current.
 */
function render_page_top(string $title, string $active = ''): void
{
    $accountUrl = url('auth/account.php');
    $adminUrl = url('admin/');
    $ideasUrl = url('admin/experiments.php');
    $labUrl = url('saas-lab/');
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0d0c0a">
    <meta name="robots" content="noindex">
    <title><?= e($title) ?> · VibeKB</title>
    <link rel="stylesheet" href="<?= e(url('assets/css/style.css?v=20260719g')) ?>">
    <link rel="stylesheet" href="<?= e(url('assets/css/auth.css?v=20260719b')) ?>">
</head>
<body class="auth-body">
    <div class="ambient-light" aria-hidden="true"></div>
    <div class="dust" aria-hidden="true"></div>

    <header class="site-header">
        <a class="maker-mark" href="<?= e($labUrl) ?>" aria-label="Return to VibeKB">
            <span class="maker-mark__sigil">IR</span>
            <span>
                <strong>VibeKB</strong>
                <small>Account Access</small>
            </span>
        </a>
        <nav class="auth-nav" aria-label="Account navigation">
            <a href="<?= e($labUrl) ?>">VibeKB</a>
            <?php if (is_logged_in()): ?>
                <?php if (is_admin()): ?>
                    <a href="<?= e($ideasUrl) ?>"<?= $active === 'ideas' ? ' aria-current="page"' : '' ?>>Ideas</a>
                    <a href="<?= e($adminUrl) ?>"<?= $active === 'admin' ? ' aria-current="page"' : '' ?>>Admin</a>
                <?php endif; ?>
                <a href="<?= e($accountUrl) ?>"<?= $active === 'account' ? ' aria-current="page"' : '' ?>>Account</a>
            <?php else: ?>
                <a href="<?= e(url('auth/login.php')) ?>">Log in</a>
                <a href="<?= e(url('auth/register.php')) ?>">Create account</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="auth-main" id="top">
    <?php
}

/**
 * Close <main>, render the shared footer, and finish the document.
 */
function render_page_bottom(): void
{
    ?>
    </main>
    <footer class="auth-footer">
        <span>iainreid.dev / vibekb / account</span>
        <span>Account Access · <time datetime="<?= e(gmdate('Y')) ?>"><?= e(gmdate('Y')) ?></time></span>
    </footer>
</body>
</html>
    <?php
}

/**
 * Render an error summary block for a list of validation messages, or nothing
 * when there are no errors. Linked from fields via aria-describedby elsewhere.
 */
function render_error_summary(array $errors): void
{
    if ($errors === []) {
        return;
    }
    ?>
    <div class="form-errors" role="alert" tabindex="-1">
        <p class="form-errors__title">Please fix the following:</p>
        <ul>
            <?php foreach ($errors as $message): ?>
                <li><?= e($message) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
}

/**
 * Render the clean HTTP 403 access-denied page shown to a signed-in
 * non-administrator who requests an admin route. The caller has already sent
 * the 403 status. No internal authorization detail is revealed.
 */
function render_access_denied(): void
{
    render_page_top('Access denied', '');
    ?>
    <section class="auth-card auth-card--narrow" aria-labelledby="denied-title">
        <p class="mono">403 · Access denied</p>
        <h1 id="denied-title">This area is restricted</h1>
        <p class="auth-lede">Your account does not have access to the admin console.</p>
        <p><a class="btn btn--ghost" href="<?= e(url('auth/account.php')) ?>">Back to your account</a></p>
    </section>
    <?php
    render_page_bottom();
}
