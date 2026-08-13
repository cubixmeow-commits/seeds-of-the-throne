<?php

declare(strict_types=1);

/**
 * Small CSRF helper shared across the VibeKB forms (registration, login,
 * logout). A single cryptographically random token is stored in the session,
 * rendered into forms, and compared with hash_equals() on submission.
 */

/**
 * Return the current CSRF token, creating one for the session if needed.
 */
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token']) || !is_string($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Render a hidden input carrying the current CSRF token, ready to drop into a
 * <form>.
 */
function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

/**
 * Validate the CSRF token submitted with a POST request in constant time.
 */
function csrf_validate(): bool
{
    $submitted = $_POST['csrf_token'] ?? '';
    $stored = $_SESSION['csrf_token'] ?? '';

    return is_string($submitted)
        && is_string($stored)
        && $stored !== ''
        && hash_equals($stored, $submitted);
}

/**
 * Rotate the CSRF token. Called after authentication state changes (login,
 * logout) so a token is never reused across a privilege boundary.
 */
function csrf_rotate(): void
{
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
