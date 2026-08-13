<?php

declare(strict_types=1);

require __DIR__ . '/../includes/bootstrap.php';
require __DIR__ . '/../includes/layout.php';

// Already signed in? Nothing to register.
if (is_logged_in()) {
    redirect(url('auth/account.php'));
}

$passwordMin = (int) config('password_min', 10);
$errors = [];
$values = ['name' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate()) {
        http_response_code(400);
        $errors[] = 'Your session expired. Please try again.';
    } else {
        $name = trim((string) ($_POST['name'] ?? ''));
        $email = strtolower(trim((string) ($_POST['email'] ?? '')));
        $password = (string) ($_POST['password'] ?? '');
        $confirm = (string) ($_POST['password_confirm'] ?? '');

        // Preserve safe values for redisplay (never the password).
        $values['name'] = $name;
        $values['email'] = $email;

        if ($name === '') {
            $errors['name'] = 'Enter your name.';
        }
        if ($email === '') {
            $errors['email'] = 'Enter your email address.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Enter a valid email address.';
        }
        if ($password === '') {
            $errors['password'] = 'Enter a password.';
        } elseif (strlen($password) < $passwordMin) {
            $errors['password'] = 'Use at least ' . $passwordMin . ' characters for your password.';
        }
        if ($confirm !== $password) {
            $errors['password_confirm'] = 'The passwords do not match.';
        }

        if ($errors === []) {
            $now = gmdate('Y-m-d H:i:s');
            $hash = password_hash($password, PASSWORD_DEFAULT);

            try {
                $stmt = db()->prepare(
                    'INSERT INTO users (name, email, password_hash, role, created_at, updated_at)
                     VALUES (:name, :email, :hash, :role, :created, :updated)'
                );
                $stmt->execute([
                    ':name'    => $name,
                    ':email'   => $email,
                    ':hash'    => $hash,
                    ':role'    => 'user',
                    ':created' => $now,
                    ':updated' => $now,
                ]);

                $user = ['id' => (int) db()->lastInsertId()];
                login_user($user);
                redirect(url('auth/account.php'));
            } catch (PDOException $e) {
                // The database unique constraint is the final authority on
                // duplicate emails; a race can slip past the checks above.
                if (is_duplicate_email_error($e)) {
                    $errors['email'] = 'This email is already registered.';
                } else {
                    $errors[] = 'Unable to create the account. Please try again.';
                }
            }
        }
    }
}

render_page_top('Create account');
?>
<section class="auth-card" aria-labelledby="register-title">
    <p class="mono">Account Access · New account</p>
    <h1 id="register-title">Create your VibeKB account</h1>
    <p class="auth-lede">One account for VibeKB and related workshop tools. Enter your details to get started.</p>

    <?php render_error_summary(array_values($errors)); ?>

    <form method="post" action="<?= e(url('auth/register.php')) ?>" novalidate class="auth-form">
        <?= csrf_field() ?>

        <div class="field<?= isset($errors['name']) ? ' field--error' : '' ?>">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" autocomplete="name" required
                   value="<?= e($values['name']) ?>"
                   <?= isset($errors['name']) ? 'aria-describedby="name-error" aria-invalid="true"' : '' ?>>
            <?php if (isset($errors['name'])): ?>
                <p class="field__error" id="name-error"><?= e($errors['name']) ?></p>
            <?php endif; ?>
        </div>

        <div class="field<?= isset($errors['email']) ? ' field--error' : '' ?>">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" autocomplete="email" required
                   value="<?= e($values['email']) ?>"
                   <?= isset($errors['email']) ? 'aria-describedby="email-error" aria-invalid="true"' : '' ?>>
            <?php if (isset($errors['email'])): ?>
                <p class="field__error" id="email-error"><?= e($errors['email']) ?></p>
            <?php endif; ?>
        </div>

        <div class="field<?= isset($errors['password']) ? ' field--error' : '' ?>">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" autocomplete="new-password" required
                   minlength="<?= e((string) $passwordMin) ?>"
                   aria-describedby="password-hint<?= isset($errors['password']) ? ' password-error' : '' ?>"
                   <?= isset($errors['password']) ? 'aria-invalid="true"' : '' ?>>
            <p class="field__hint" id="password-hint">At least <?= e((string) $passwordMin) ?> characters.</p>
            <?php if (isset($errors['password'])): ?>
                <p class="field__error" id="password-error"><?= e($errors['password']) ?></p>
            <?php endif; ?>
        </div>

        <div class="field<?= isset($errors['password_confirm']) ? ' field--error' : '' ?>">
            <label for="password_confirm">Confirm password</label>
            <input type="password" id="password_confirm" name="password_confirm" autocomplete="new-password" required
                   <?= isset($errors['password_confirm']) ? 'aria-describedby="password_confirm-error" aria-invalid="true"' : '' ?>>
            <?php if (isset($errors['password_confirm'])): ?>
                <p class="field__error" id="password_confirm-error"><?= e($errors['password_confirm']) ?></p>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn--primary">Create account</button>
    </form>

    <p class="auth-alt">Already have an account? <a href="<?= e(url('auth/login.php')) ?>">Log in</a>.</p>
</section>
<?php
render_page_bottom();
