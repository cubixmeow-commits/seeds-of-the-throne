<?php

declare(strict_types=1);

/**
 * Belt-and-braces protection for the data directory. If .htaccess handling is
 * ever disabled, a request for this directory still returns 403 rather than
 * exposing a listing or any file contents.
 */

http_response_code(403);
header('Content-Type: text/plain; charset=utf-8');
echo "Forbidden";
