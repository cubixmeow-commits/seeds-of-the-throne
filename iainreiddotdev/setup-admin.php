<?php

declare(strict_types=1);

/**
 * One-time first-administrator setup page.
 *
 * This route requires no account login, but it does require a random setup
 * code stored only in the HTTP-protected data directory. It disables itself
 * as soon as any administrator exists.
 */

require __DIR__ . '/includes/bootstrap.php';
require __DIR__ . '/includes/layout.php';

$pdo = db();
$dataDir = (string) config('data_dir');
$codePath = $dataDir . '/.admin-setup-code';
$lockPath = $dataDir . '/.admin-setup-complete';
$adminCount = (int) $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'admin'")->fetchColumn();

if ($adminCount > 0 || is_file($lockPath)) {
    http_response_code(410);
    render_page_top('Administrator setup complete');
    ?>
    <section class="auth-card auth-card--narrow" aria-labelledby="setup-complete-title">
        <p class="mono">One-time setup · Disabled</p>
        <h1 id="setup-complete-title">Administrator setup is complete</h1>
        <p class="auth-lede">This page can no longer create an administrator.</p>
        <p><a class="btn btn--primary" href="<?= e(url('auth/login.php')) ?>">Log in</a></p>
    </section>
    <?php
    render_page_bottom();
    exit;
}

if (!is_file($codePath)) {
    $rawCode = strtoupper(bin2hex(random_bytes(12)));
    $displayCode = implode('-', str_split($rawCode, 4));
    $handle = @fopen($codePath, 'x');
    if (is_resource($handle)) {
        $created = fwrite($handle, $displayCode . "\n");
        fclose($handle);
    } else {
        // Another first request may have created it between the existence
        // check and exclusive open. In that case, use the existing code.
        $created = is_file($codePath) ? 1 : false;
    }
    if ($created === false || $created === 0) {
        saas_lab_fatal('The one-time administrator setup code could not be created in the protected data directory.');
    }
    @chmod($codePath, 0600);
}

$storedCode = @file_get_contents($codePath);
if (!is_string($storedCode) || trim($storedCode) === '') {
    saas_lab_fatal('The one-time administrator setup code could not be read from the protected data directory.');
}
$storedCode = strtoupper(trim($storedCode));

$passwordMin = (int) config('password_min', 10);
$errors = [];
$values = ['name' => '', 'email' => '', 'setup_code' => ''];

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    if (!csrf_validate()) {
        http_response_code(400);
        $errors[] = 'Your setup session expired. Reload this page and try again.';
    } else {
        $name = trim((string) ($_POST['name'] ?? ''));
        $email = strtolower(trim((string) ($_POST['email'] ?? '')));
        $password = (string) ($_POST['password'] ?? '');
        $confirm = (string) ($_POST['password_confirm'] ?? '');
        $setupCode = strtoupper(trim((string) ($_POST['setup_code'] ?? '')));

        $values = ['name' => $name, 'email' => $email, 'setup_code' => $setupCode];

        if ($setupCode === '' || !hash_equals($storedCode, $setupCode)) {
            $errors['setup_code'] = 'Enter the setup code from the protected data folder.';
        }
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
            // Recheck immediately before writing so a completed setup cannot be
            // replayed from an older form submission.
            $adminCount = (int) $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'admin'")->fetchColumn();
            if ($adminCount > 0 || is_file($lockPath)) {
                http_response_code(409);
                $errors[] = 'Administrator setup has already been completed.';
            } else {
                $now = gmdate('Y-m-d H:i:s');
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                try {
                    $existing = $pdo->prepare('SELECT id FROM users WHERE email = :email LIMIT 1');
                    $existing->execute([':email' => $email]);
                    $existingId = $existing->fetchColumn();

                    if ($existingId !== false) {
                        $stmt = $pdo->prepare(
                            'UPDATE users
                                SET name = :name, password_hash = :hash, role = :role, updated_at = :updated
                              WHERE id = :id'
                        );
                        $stmt->execute([
                            ':name' => $name,
                            ':hash' => $passwordHash,
                            ':role' => 'admin',
                            ':updated' => $now,
                            ':id' => (int) $existingId,
                        ]);
                        $adminId = (int) $existingId;
                    } else {
                        $stmt = $pdo->prepare(
                            'INSERT INTO users (name, email, password_hash, role, created_at, updated_at)
                             VALUES (:name, :email, :hash, :role, :created, :updated)'
                        );
                        $stmt->execute([
                            ':name' => $name,
                            ':email' => $email,
                            ':hash' => $passwordHash,
                            ':role' => 'admin',
                            ':created' => $now,
                            ':updated' => $now,
                        ]);
                        $adminId = (int) $pdo->lastInsertId();
                    }

                    @file_put_contents($lockPath, 'Completed ' . $now . " UTC\n", LOCK_EX);
                    @chmod($lockPath, 0600);
                    @unlink($codePath);

                    login_user(['id' => $adminId]);
                    redirect(url('admin/analytics.php'));
                } catch (PDOException) {
                    $errors[] = 'The administrator account could not be created. Please try again.';
                }
            }
        }
    }
}

render_page_top('Create first administrator');
?>
<section class="auth-card" aria-labelledby="setup-title">
    <p class="mono">One-time setup · No login required</p>
    <h1 id="setup-title">Create the first administrator</h1>
    <p class="auth-lede">This page permanently disables itself after creating one administrator.</p>

    <div class="auth-note">
        <strong>Get the one-time setup code first.</strong>
        In cPanel File Manager, enable “Show Hidden Files,” then open:<br>
        <code>public_html/devsite/iainreiddotdev/data/.admin-setup-code</code>
    </div>

    <?php render_error_summary(array_values($errors)); ?>

    <form method="post" action="<?= e(url('setup-admin.php')) ?>" novalidate class="auth-form auth-form--inline">
        <?= csrf_field() ?>

        <div class="field<?= isset($errors['setup_code']) ? ' field--error' : '' ?>">
            <label for="setup_code">One-time setup code</label>
            <input type="text" id="setup_code" name="setup_code" autocomplete="off" required
                   value="<?= e($values['setup_code']) ?>"
                   aria-describedby="setup-code-hint<?= isset($errors['setup_code']) ? ' setup-code-error' : '' ?>"
                   <?= isset($errors['setup_code']) ? 'aria-invalid="true"' : '' ?>>
            <p class="field__hint" id="setup-code-hint">Copy the complete code, including hyphens.</p>
            <?php if (isset($errors['setup_code'])): ?><p class="field__error" id="setup-code-error"><?= e($errors['setup_code']) ?></p><?php endif; ?>
        </div>

        <div class="field<?= isset($errors['name']) ? ' field--error' : '' ?>">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" autocomplete="name" required value="<?= e($values['name']) ?>"
                   <?= isset($errors['name']) ? 'aria-describedby="name-error" aria-invalid="true"' : '' ?>>
            <?php if (isset($errors['name'])): ?><p class="field__error" id="name-error"><?= e($errors['name']) ?></p><?php endif; ?>
        </div>

        <div class="field<?= isset($errors['email']) ? ' field--error' : '' ?>">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" autocomplete="email" required value="<?= e($values['email']) ?>"
                   <?= isset($errors['email']) ? 'aria-describedby="email-error" aria-invalid="true"' : '' ?>>
            <?php if (isset($errors['email'])): ?><p class="field__error" id="email-error"><?= e($errors['email']) ?></p><?php endif; ?>
        </div>

        <div class="field<?= isset($errors['password']) ? ' field--error' : '' ?>">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" autocomplete="new-password" required minlength="<?= e((string) $passwordMin) ?>"
                   aria-describedby="password-hint<?= isset($errors['password']) ? ' password-error' : '' ?>"
                   <?= isset($errors['password']) ? 'aria-invalid="true"' : '' ?>>
            <p class="field__hint" id="password-hint">At least <?= e((string) $passwordMin) ?> characters.</p>
            <?php if (isset($errors['password'])): ?><p class="field__error" id="password-error"><?= e($errors['password']) ?></p><?php endif; ?>
        </div>

        <div class="field<?= isset($errors['password_confirm']) ? ' field--error' : '' ?>">
            <label for="password_confirm">Confirm password</label>
            <input type="password" id="password_confirm" name="password_confirm" autocomplete="new-password" required
                   <?= isset($errors['password_confirm']) ? 'aria-describedby="password-confirm-error" aria-invalid="true"' : '' ?>>
            <?php if (isset($errors['password_confirm'])): ?><p class="field__error" id="password-confirm-error"><?= e($errors['password_confirm']) ?></p><?php endif; ?>
        </div>

        <button type="submit" class="btn btn--primary">Create administrator</button>
    </form>
</section>
<?php render_page_bottom(); ?>
