<?php

declare(strict_types=1);

// The collector always fails closed and quietly. Analytics must never prevent
// a visitor from reading the portfolio or story.
http_response_code(204);
header('Cache-Control: no-store, max-age=0');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: no-referrer');

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    exit;
}
if ((int) ($_SERVER['CONTENT_LENGTH'] ?? 0) > 16384) {
    exit;
}

$config = require dirname(__DIR__) . '/includes/config.php';
require dirname(__DIR__) . '/includes/analytics.php';

if (!analytics_is_same_origin()) {
    exit;
}

$raw = file_get_contents('php://input');
$payload = is_string($raw) ? json_decode($raw, true) : null;
if (!is_array($payload)) {
    exit;
}

$pagePath = analytics_string($payload['page'] ?? '', 500);
if ($pagePath === '' || $pagePath[0] !== '/' || str_contains($pagePath, '..')) {
    exit;
}
$site = analytics_site_for_path($pagePath);
if ($site === null) {
    exit;
}

$pdo = analytics_connect($config);
if (!$pdo instanceof PDO) {
    exit;
}

try {
    $ip = analytics_client_ip();
    $userAgent = analytics_string($_SERVER['HTTP_USER_AGENT'] ?? '', 1000);
    $agent = analytics_parse_user_agent($userAgent);
    $secret = analytics_secret($config);
    $visitorHash = substr(hash_hmac('sha256', $ip . "\0" . $userAgent, $secret), 0, 20);
    $now = gmdate('Y-m-d H:i:s');

    // Ignore accidental duplicate beacons caused by a reload race while
    // retaining normal navigation between different pages.
    $duplicate = $pdo->prepare(
        "SELECT 1 FROM analytics_visits
          WHERE visitor_hash = :visitor AND page_path = :page
            AND visited_at >= :cutoff
          LIMIT 1"
    );
    $duplicate->execute([
        ':visitor' => $visitorHash,
        ':page' => $pagePath,
        ':cutoff' => gmdate('Y-m-d H:i:s', time() - 5),
    ]);
    if ($duplicate->fetchColumn() !== false) {
        exit;
    }

    $location = analytics_location($pdo, $ip, $config);
    $screenWidth = filter_var($payload['screen_width'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 20000]]);
    $screenHeight = filter_var($payload['screen_height'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 20000]]);

    $insert = $pdo->prepare(
        'INSERT INTO analytics_visits
        (visited_at, site, page_path, page_title, referrer, ip_address,
         visitor_hash, user_agent, browser, operating_system, device_type,
         language, visitor_timezone, screen_width, screen_height, country_code,
         country, region, city, isp, location_source, is_bot)
     VALUES
        (:visited_at, :site, :page_path, :page_title, :referrer, :ip_address,
         :visitor_hash, :user_agent, :browser, :operating_system, :device_type,
         :language, :visitor_timezone, :screen_width, :screen_height, :country_code,
         :country, :region, :city, :isp, :location_source, :is_bot)'
    );
    $insert->execute([
        ':visited_at' => $now,
        ':site' => $site,
        ':page_path' => $pagePath,
        ':page_title' => analytics_string($payload['title'] ?? '', 300),
        ':referrer' => analytics_string($payload['referrer'] ?? '', 500),
        ':ip_address' => $ip,
        ':visitor_hash' => $visitorHash,
        ':user_agent' => $userAgent,
        ':browser' => $agent['browser'],
        ':operating_system' => $agent['operating_system'],
        ':device_type' => $agent['device_type'],
        ':language' => analytics_string($payload['language'] ?? '', 40),
        ':visitor_timezone' => analytics_string($payload['timezone'] ?? '', 80),
        ':screen_width' => $screenWidth === false ? null : $screenWidth,
        ':screen_height' => $screenHeight === false ? null : $screenHeight,
        ':country_code' => $location['country_code'],
        ':country' => $location['country'],
        ':region' => $location['region'],
        ':city' => $location['city'],
        ':isp' => $location['isp'],
        ':location_source' => $location['source'],
        ':is_bot' => $agent['is_bot'],
    ]);

    // Amortize retention maintenance instead of running it on every pageview.
    if (mt_rand(1, 100) === 1) {
        analytics_cleanup($pdo, $config);
    }
} catch (Throwable) {
    exit;
}
