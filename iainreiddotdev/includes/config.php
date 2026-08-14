<?php

declare(strict_types=1);

/**
 * Shared VibeKB configuration.
 *
 * This is the single place where deployment-specific values live. Nothing
 * else in the codebase should hardcode a domain or application base path.
 * prefix. Future projects read the same values through the helpers
 * in auth.php (base_url(), url(), app_path()).
 *
 * Deployment mapping (confirmed by inspection):
 *   repository  -> /home/iainmcok/public_html/devsite/
 *   site folder -> /home/iainmcok/public_html/devsite/iainreiddotdev/
 *               -> https://iainreid.dev/devsite/iainreiddotdev/
 * The public document root is public_html/, so the deployed folder is served
 * under the /devsite/iainreiddotdev/ path, not at the domain root. If the host is ever repointed
 * so this folder becomes the document root, only 'base_path' changes here.
 */

return [
    // Public URL path the application is served under. Must start and end
    // with a slash. Every internal link/redirect is built from this.
    'base_path' => '/devsite/iainreiddotdev/',

    // Absolute filesystem paths, derived from this file's location so they are
    // correct in every environment (local and cPanel) without editing.
    'data_dir' => dirname(__DIR__) . '/data',
    'db_path'  => dirname(__DIR__) . '/data/saas-lab.sqlite',

    // Minimum password length. Kept modest and explained on the form.
    'password_min' => 10,

    // PHP session settings.
    'session' => [
        'name'     => 'saaslab_session',
        'lifetime' => 0,
        'samesite' => 'Lax',
    ],
];
