<?php

declare(strict_types=1);

/**
 * Shared VibeKB bootstrap.
 *
 * This is the single include future projects pull in to gain the
 * shared account system:
 *
 *     require __DIR__ . '/../includes/bootstrap.php';
 *
 * It loads configuration, wires the helper library, configures and starts the
 * PHP session, and makes the SQLite-backed database available on demand. It is
 * safe to include more than once.
 */

if (defined('SAAS_LAB_BOOTSTRAPPED')) {
    return;
}
define('SAAS_LAB_BOOTSTRAPPED', true);

// Configuration is loaded once and exposed through config() in auth.php.
define('SAAS_LAB_CONFIG', require __DIR__ . '/config.php');

require __DIR__ . '/auth.php';
require __DIR__ . '/database.php';
require __DIR__ . '/csrf.php';
require __DIR__ . '/experiments.php';

// Configure and start the session for web requests. No-op under the CLI so the
// admin creation script can reuse this bootstrap.
start_session();
