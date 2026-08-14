<?php

declare(strict_types=1);

/**
 * Seed the single demo experiment ("hello") — the acceptance-test surface for
 * the visibility gate. Run once, from the command line, after at least one
 * administrator exists. This is the ONLY experiment row the project seeds; real
 * experiments are created by an admin through the registry.
 *
 * Usage:
 *   php scripts/seed-demo-experiment.php --email="admin@example.com"
 *
 * The --email must belong to an existing administrator; it becomes created_by.
 * The demo is seeded as visibility=private, status=inbox so you can exercise
 * private -> invite -> public. If a "hello" row already exists, nothing changes.
 *
 * Exit codes: 0 success (or already present), 1 db/write error, 2 usage error.
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Forbidden';
    exit(1);
}

require __DIR__ . '/../includes/bootstrap.php';

function fail_cli(string $message, int $code): never
{
    fwrite(STDERR, $message . "\n");
    exit($code);
}

$options = getopt('', ['email:', 'help']);

if (isset($options['help'])) {
    echo "Seed the demo experiment.\n\n"
        . "Usage:\n  php scripts/seed-demo-experiment.php --email=\"admin@example.com\"\n";
    exit(0);
}

$email = isset($options['email']) ? strtolower(trim((string) $options['email'])) : '';
if ($email === '') {
    fail_cli('Error: --email of an existing administrator is required.', 2);
}

$stmt = db()->prepare("SELECT id, role FROM users WHERE email = :email");
$stmt->execute([':email' => $email]);
$admin = $stmt->fetch();

if ($admin === false) {
    fail_cli('Error: no user found with that email. Create an admin first (scripts/create-admin.php).', 2);
}
if (($admin['role'] ?? 'user') !== 'admin') {
    fail_cli('Error: that user is not an administrator.', 2);
}

if (find_experiment_by_slug('hello') !== null) {
    echo "Demo experiment 'hello' already exists; nothing to do.\n";
    exit(0);
}

$now = gmdate('Y-m-d H:i:s');
try {
    $stmt = db()->prepare(
        'INSERT INTO experiments
            (experiment_code, slug, name, description, visibility, route_path, status, created_by, created_at, updated_at, published_at)
         VALUES (:code, :slug, :name, :desc, :vis, :route, :status, :by, :created, :updated, NULL)'
    );
    $stmt->execute([
        ':code'    => 'EXP-HELLO',
        ':slug'    => 'hello',
        ':name'    => 'Hello (gate demo)',
        ':desc'    => 'A content-free demo that proves the visibility gate works end to end.',
        ':vis'     => 'private',
        ':route'   => '/devsite/iainreiddotdev/x/hello.php',
        ':status'  => 'inbox',
        ':by'      => (int) $admin['id'],
        ':created' => $now,
        ':updated' => $now,
    ]);
} catch (PDOException $ex) {
    fail_cli('Error: could not seed the demo experiment.', 1);
}

echo "Seeded demo experiment 'hello' (private). Visit /devsite/iainreiddotdev/x/hello.php to test the gate.\n";
exit(0);
