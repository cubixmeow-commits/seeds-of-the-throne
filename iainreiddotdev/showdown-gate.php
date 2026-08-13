<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'message' => 'Soon enough the secrets will be revealed']);
    exit;
}

$raw = file_get_contents('php://input');
$payload = is_string($raw) ? json_decode($raw, true) : null;
$answer = '';

if (is_array($payload) && isset($payload['answer']) && is_string($payload['answer'])) {
    $answer = strtolower(trim($payload['answer']));
}

// SHA-256 of the expected passphrase. Never store the plaintext answer here.
$expected = '1e8c36fe36363beaf43717f01c363b345392af1bfa9d703e01827f44ebf062ad';
$submitted = hash('sha256', $answer);

if ($answer !== '' && hash_equals($expected, $submitted)) {
    echo json_encode([
        'ok' => true,
        'redirect' => 'https://cubixmeow.com/showdown/',
    ]);
    exit;
}

echo json_encode([
    'ok' => false,
    'message' => 'Soon enough the secrets will be revealed',
]);
