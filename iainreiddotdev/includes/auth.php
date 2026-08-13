<?php

declare(strict_types=1);

/**
 * Shared authentication and URL helpers for the VibeKB account system.
 *
 * These functions are intentionally small and dependency-free so any future
 * project can include bootstrap.php and reuse the same session,
 * authorization, and URL behaviour. Nothing here builds SQL from user input;
 * database access goes through prepared statements in database.php.
 */

/**
 * Read a configuration value loaded by bootstrap.php.
 */
function config(string $key, mixed $default = null): mixed
{
    return SAAS_LAB_CONFIG[$key] ?? $default;
}

/**
 * Escape a value for safe HTML output.
 */
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/**
 * Resolve an absolute filesystem path inside the application root.
 */
function app_path(string $relative = ''): string
{
    $base = dirname(__DIR__);
    if ($relative === '') {
        return $base;
    }
    return $base . '/' . ltrim($relative, '/');
}

/**
 * The public base URL of the application, e.g. https://iainreid.dev/iainreiddotdev
 * (no trailing slash). Built once from the request and the configured base
 * path so no domain literal appears anywhere else in the codebase.
 */
function base_url(): string
{
    static $cached = null;
    if ($cached !== null) {
        return $cached;
    }

    $https = (!empty($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off')
        || (isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443)
        || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower((string) $_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https');

    $scheme = $https ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'iainreid.dev';
    $basePath = rtrim((string) config('base_path', '/'), '/');

    return $cached = $scheme . '://' . $host . $basePath;
}

/**
 * Build an absolute internal URL from an application-relative path.
 * url('auth/login.php') -> https://iainreid.dev/iainreiddotdev/auth/login.php
 */
function url(string $path = ''): string
{
    return base_url() . '/' . ltrim($path, '/');
}

/**
 * Safely redirect and stop. Accepts either an absolute URL produced by url()
 * or an already-validated internal path. CR/LF are stripped to prevent header
 * injection (PHP also blocks these, this is belt-and-braces).
 */
function redirect(string $to): never
{
    $to = str_replace(["\r", "\n"], '', $to);
    if (!headers_sent()) {
        header('Location: ' . $to, true, 302);
    }
    exit;
}

/**
 * Validate an untrusted return path. Returns a safe internal absolute path
 * (e.g. "/iainreiddotdev/admin/") or null if the value is not an acceptable internal
 * destination. Rejects schemes, protocol-relative URLs, hosts, backslashes,
 * traversal, and anything outside the application base path.
 */
function safe_return_path(?string $raw): ?string
{
    if (!is_string($raw) || $raw === '') {
        return null;
    }
    if (str_contains($raw, "\r") || str_contains($raw, "\n") || str_contains($raw, "\\")) {
        return null;
    }
    // Reject any URL scheme (http:, javascript:, etc.).
    if (preg_match('#^[a-z][a-z0-9+.\-]*:#i', $raw) === 1) {
        return null;
    }
    // Must be an absolute path, but not protocol-relative ("//host").
    if ($raw[0] !== '/' || str_starts_with($raw, '//')) {
        return null;
    }

    $basePath = rtrim((string) config('base_path', '/'), '/');
    if ($basePath !== '' && $raw !== $basePath && !str_starts_with($raw, $basePath . '/')) {
        return null;
    }

    // Reject path traversal in the path component.
    $pathComponent = parse_url($raw, PHP_URL_PATH);
    if (!is_string($pathComponent) || str_contains($pathComponent, '..')) {
        return null;
    }

    return $raw;
}

/**
 * The safe internal path of the current request, or null if it cannot be
 * expressed as one. Used to build return links for require_login().
 */
function current_path(): ?string
{
    return safe_return_path($_SERVER['REQUEST_URI'] ?? null);
}

/**
 * Configure and start the PHP session. No-op under the CLI and when a session
 * is already active. Called by bootstrap.php.
 */
function start_session(): void
{
    if (PHP_SAPI === 'cli' || session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    $session = (array) config('session', []);
    $secure = (!empty($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off')
        || (isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443)
        || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower((string) $_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https');

    // Harden before the session starts.
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');

    session_name((string) ($session['name'] ?? 'saaslab_session'));
    session_set_cookie_params([
        'lifetime' => (int) ($session['lifetime'] ?? 0),
        'path'     => (string) config('base_path', '/'),
        'httponly' => true,
        'secure'   => $secure,
        'samesite' => (string) ($session['samesite'] ?? 'Lax'),
    ]);

    session_start();
}

/**
 * The currently authenticated user row, or null. Fetched from the database
 * (only the id is stored in the session) and cached per request.
 */
function current_user(): ?array
{
    static $user = null;
    static $loaded = false;

    if ($loaded) {
        return $user;
    }
    $loaded = true;

    $id = $_SESSION['user_id'] ?? null;
    if (!is_int($id) && !(is_string($id) && ctype_digit($id))) {
        return $user = null;
    }

    $stmt = db()->prepare(
        'SELECT id, name, email, role, created_at, updated_at FROM users WHERE id = :id'
    );
    $stmt->execute([':id' => (int) $id]);
    $row = $stmt->fetch();

    if ($row === false) {
        // Session references a user that no longer exists.
        unset($_SESSION['user_id']);
        return $user = null;
    }

    return $user = $row;
}

function is_logged_in(): bool
{
    return current_user() !== null;
}

function is_admin(): bool
{
    $user = current_user();
    return $user !== null && ($user['role'] ?? 'user') === 'admin';
}

/**
 * Require an authenticated user. Signed-out visitors are redirected to the
 * login page with a validated internal return path so login can bring them
 * back to where they were headed.
 */
function require_login(): void
{
    if (is_logged_in()) {
        return;
    }

    $loginUrl = url('auth/login.php');
    $return = current_path();
    if ($return !== null) {
        $loginUrl .= '?return=' . rawurlencode($return);
    }
    redirect($loginUrl);
}

/**
 * Require an administrator. Signed-out visitors are redirected to login (with a
 * return path); signed-in non-administrators receive a real HTTP 403 page.
 * Authorization is always server-side; navigation visibility is never trusted.
 */
function require_admin(): void
{
    if (!is_logged_in()) {
        require_login();
        return;
    }

    if (!is_admin()) {
        http_response_code(403);
        if (function_exists('render_access_denied')) {
            render_access_denied();
        } else {
            header('Content-Type: text/html; charset=utf-8');
            echo '<h1>Access denied</h1>';
        }
        exit;
    }
}

/**
 * Establish an authenticated session for a user. Regenerates the session id to
 * prevent fixation and rotates the CSRF token. Only the user id is stored.
 */
function login_user(array $user): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_regenerate_id(true);
    }
    $_SESSION['user_id'] = (int) $user['id'];
    csrf_rotate();
}

/**
 * Clear the authenticated session completely.
 */
function logout_user(): void
{
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            [
                'expires'  => time() - 42000,
                'path'     => $params['path'],
                'domain'   => $params['domain'],
                'secure'   => $params['secure'],
                'httponly' => $params['httponly'],
                'samesite' => $params['samesite'] ?? 'Lax',
            ]
        );
    }

    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy();
    }
}
