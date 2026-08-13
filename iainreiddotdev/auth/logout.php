<?php

declare(strict_types=1);

require __DIR__ . '/../includes/bootstrap.php';

// Logout is a state-changing action: POST + CSRF only. A GET request (for
// example a prefetch or a link) must never log anyone out.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Method Not Allowed. Use the logout button.';
    exit;
}

if (!csrf_validate()) {
    http_response_code(400);
    header('Content-Type: text/html; charset=utf-8');
    echo '<!doctype html><meta charset="utf-8"><p>Your session expired. Please try again.</p>';
    exit;
}

logout_user();
redirect(url('auth/login.php'));
