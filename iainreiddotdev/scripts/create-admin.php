<?php

declare(strict_types=1);

/**
 * Create the first VibeKB administrator (or any additional admin) from the
 * command line. This is the preferred, documented way to seed an admin account
 * without hardcoding credentials into the codebase or exposing a public
 * "make admin" URL.
 *
 * Usage:
 *   SAAS_LAB_ADMIN_PASSWORD='temporary-password' \
 *       php scripts/create-admin.php --name="Iain Reid" --email="admin@example.com"
 *
 * The password is read from the SAAS_LAB_ADMIN_PASSWORD environment variable so
 * it never appears in the argument list or shell history. It is never printed.
 *
 * Exit codes:
 *   0  success
 *   1  data directory / database not writable (reported by the shared code)
 *   2  usage or validation error
 *   3  email already registered
 */

// Refuse to run outside the CLI. This script must never be web-reachable.
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    header('Content-Type: text/plain; charset=utf-8');
    echo "Forbidden";
    exit(1);
}

require __DIR__ . '/../includes/bootstrap.php';

/**
 * Print a message to stderr and exit with the given code.
 */
function fail_cli(string $message, int $code): never
{
    fwrite(STDERR, $message . "\n");
    exit($code);
}

// --- Parse arguments -------------------------------------------------------

$options = getopt('', ['name:', 'email:', 'help']);

if (isset($options['help'])) {
    echo "Create a VibeKB administrator.\n\n"
        . "Usage:\n"
        . "  SAAS_LAB_ADMIN_PASSWORD='...' php scripts/create-admin.php "
        . "--name=\"Full Name\" --email=\"admin@example.com\"\n";
    exit(0);
}

$name = isset($options['name']) ? trim((string) $options['name']) : '';
$email = isset($options['email']) ? strtolower(trim((string) $options['email'])) : '';
$password = (string) getenv('SAAS_LAB_ADMIN_PASSWORD');
$passwordMin = (int) config('password_min', 10);

// --- Validate --------------------------------------------------------------

if ($name === '') {
    fail_cli('Error: --name is required.', 2);
}
if ($email === '') {
    fail_cli('Error: --email is required.', 2);
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    fail_cli('Error: --email is not a valid email address.', 2);
}
if ($password === '') {
    fail_cli('Error: set the SAAS_LAB_ADMIN_PASSWORD environment variable.', 2);
}
if (strlen($password) < $passwordMin) {
    fail_cli('Error: password must be at least ' . $passwordMin . ' characters.', 2);
}

// --- Insert ----------------------------------------------------------------

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
        ':role'    => 'admin',
        ':created' => $now,
        ':updated' => $now,
    ]);
} catch (PDOException $e) {
    if (is_duplicate_email_error($e)) {
        fail_cli('Error: an account with that email already exists.', 3);
    }
    fail_cli('Error: could not create the administrator account.', 1);
}

echo "Administrator created: " . $email . "\n";
exit(0);
