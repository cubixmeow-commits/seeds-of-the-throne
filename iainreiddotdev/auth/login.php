<?php

declare(strict_types=1);

require __DIR__ . '/../includes/bootstrap.php';
require __DIR__ . '/../includes/layout.php';

// A validated internal return path may arrive by GET (link) or POST (form).
$return = safe_return_path($_POST['return'] ?? $_GET['return'] ?? null);

if (is_logged_in()) {
    redirect($return ?? (is_admin() ? url('admin/experiments.php') : url('auth/account.php')));
}

$errors = [];
$values = ['email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate()) {
        http_response_code(400);
        $errors[] = 'Your session expired. Please try again.';
    } else {
        $email = strtolower(trim((string) ($_POST['email'] ?? '')));
        $password = (string) ($_POST['password'] ?? '');
        $values['email'] = $email;

        $user = null;
        if ($email !== '' && $password !== '') {
            $stmt = db()->prepare('SELECT * FROM users WHERE email = :email');
            $stmt->execute([':email' => $email]);
            $row = $stmt->fetch();
            if ($row !== false && password_verify($password, (string) $row['password_hash'])) {
                $user = $row;
            }
        }

        if ($user === null) {
            // Generic message: never reveal whether the email exists.
            $errors[] = 'Email or password is incorrect.';
        } else {
            login_user($user);
            $isAdmin = ($user['role'] ?? 'user') === 'admin';
            // A valid return path wins; otherwise fall back on role.
            redirect($return ?? ($isAdmin ? url('admin/') : url('auth/account.php')));
        }
    }
}

render_page_top('Log in');
?>
<section class="auth-card" aria-labelledby="login-title">
    <p class="mono">Account Access · Sign in</p>
    <h1 id="login-title">Log in to VibeKB</h1>
    <p class="auth-lede">Access your VibeKB account.</p>

    <?php render_error_summary($errors); ?>

    <form method="post" action="<?= e(url('auth/login.php')) ?>" novalidate class="auth-form">
        <?= csrf_field() ?>
        <?php if ($return !== null): ?>
            <input type="hidden" name="return" value="<?= e($return) ?>">
        <?php endif; ?>

        <div class="field">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" autocomplete="email" required
                   value="<?= e($values['email']) ?>">
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" autocomplete="current-password" required>
        </div>

        <button type="submit" class="btn btn--primary">Log in</button>
    </form>

    <p class="auth-alt">Need an account? <a href="<?= e(url('auth/register.php')) ?>">Create one</a>.</p>
</section>
<?php
render_page_bottom();
