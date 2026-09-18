<?php

declare(strict_types=1);

/**
 * Small first-party analytics layer shared by the public collector and the
 * authenticated admin dashboard. It uses no cookies, ad identifiers, or
 * third-party JavaScript.
 */

function analytics_init_schema(PDO $pdo): void
{
    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS analytics_visits (
            id              INTEGER PRIMARY KEY AUTOINCREMENT,
            visited_at      TEXT NOT NULL,
            site            TEXT NOT NULL,
            page_path       TEXT NOT NULL,
            page_title      TEXT NOT NULL DEFAULT '',
            referrer        TEXT NOT NULL DEFAULT '',
            ip_address      TEXT NOT NULL,
            visitor_hash    TEXT NOT NULL,
            user_agent      TEXT NOT NULL DEFAULT '',
            browser         TEXT NOT NULL DEFAULT '',
            operating_system TEXT NOT NULL DEFAULT '',
            device_type     TEXT NOT NULL DEFAULT '',
            language        TEXT NOT NULL DEFAULT '',
            visitor_timezone TEXT NOT NULL DEFAULT '',
            screen_width    INTEGER NULL,
            screen_height   INTEGER NULL,
            country_code    TEXT NOT NULL DEFAULT '',
            country         TEXT NOT NULL DEFAULT '',
            region          TEXT NOT NULL DEFAULT '',
            city            TEXT NOT NULL DEFAULT '',
            isp             TEXT NOT NULL DEFAULT '',
            location_source TEXT NOT NULL DEFAULT '',
            is_bot          INTEGER NOT NULL DEFAULT 0
        )"
    );
    $pdo->exec('CREATE INDEX IF NOT EXISTS idx_analytics_visits_time ON analytics_visits (visited_at)');
    $pdo->exec('CREATE INDEX IF NOT EXISTS idx_analytics_visits_site_time ON analytics_visits (site, visited_at)');
    $pdo->exec('CREATE INDEX IF NOT EXISTS idx_analytics_visits_visitor ON analytics_visits (visitor_hash, visited_at)');

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS analytics_ip_cache (
            ip_address    TEXT PRIMARY KEY,
            looked_up_at  TEXT NOT NULL,
            success       INTEGER NOT NULL DEFAULT 0,
            country_code  TEXT NOT NULL DEFAULT '',
            country       TEXT NOT NULL DEFAULT '',
            region        TEXT NOT NULL DEFAULT '',
            city          TEXT NOT NULL DEFAULT '',
            isp           TEXT NOT NULL DEFAULT '',
            source        TEXT NOT NULL DEFAULT ''
        )"
    );
}

/** @return array<string, mixed> */
function analytics_settings(array $config): array
{
    $settings = $config['analytics'] ?? [];
    return is_array($settings) ? $settings : [];
}

function analytics_connect(array $config): ?PDO
{
    if (!extension_loaded('pdo_sqlite')) {
        return null;
    }

    $dataDir = (string) ($config['data_dir'] ?? '');
    $dbPath = (string) ($config['db_path'] ?? '');
    if ($dataDir === '' || $dbPath === '') {
        return null;
    }

    if (!is_dir($dataDir) && !@mkdir($dataDir, 0750, true)) {
        return null;
    }
    if (!is_writable($dataDir)) {
        return null;
    }

    try {
        $pdo = new PDO('sqlite:' . $dbPath, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        $pdo->exec('PRAGMA foreign_keys = ON;');
        analytics_init_schema($pdo);
        return $pdo;
    } catch (Throwable) {
        return null;
    }
}

function analytics_string(mixed $value, int $maximum): string
{
    if (!is_string($value)) {
        return '';
    }
    $value = trim(preg_replace('/[\x00-\x1F\x7F]/u', '', $value) ?? '');
    return function_exists('mb_substr') ? mb_substr($value, 0, $maximum) : substr($value, 0, $maximum);
}

function analytics_client_ip(): string
{
    $candidate = trim((string) ($_SERVER['REMOTE_ADDR'] ?? ''));
    return filter_var($candidate, FILTER_VALIDATE_IP) !== false ? $candidate : '0.0.0.0';
}

function analytics_site_for_path(string $path): ?string
{
    if (preg_match('#^/devsite/docs(?:/|$)#', $path) === 1) {
        return 'Seeds story';
    }
    if (preg_match('#^/devsite/iainreiddotdev/project-explorer(?:/|$)#', $path) === 1) {
        return 'Project Explorer';
    }
    if (preg_match('#^/devsite/iainreiddotdev(?:/|$)#', $path) === 1) {
        return 'Portfolio';
    }
    return null;
}

function analytics_is_same_origin(): bool
{
    $fetchSite = strtolower(trim((string) ($_SERVER['HTTP_SEC_FETCH_SITE'] ?? '')));
    if ($fetchSite !== '' && !in_array($fetchSite, ['same-origin', 'same-site', 'none'], true)) {
        return false;
    }
    $origin = trim((string) ($_SERVER['HTTP_ORIGIN'] ?? ''));
    if ($origin === '') {
        return true;
    }
    $originHost = parse_url($origin, PHP_URL_HOST);
    $requestHost = strtolower(preg_replace('/:\d+$/', '', (string) ($_SERVER['HTTP_HOST'] ?? '')) ?? '');
    return is_string($originHost) && hash_equals($requestHost, strtolower($originHost));
}

/** @return array{browser:string, operating_system:string, device_type:string, is_bot:int} */
function analytics_parse_user_agent(string $userAgent): array
{
    $browser = 'Other';
    foreach ([
        'Edge' => '/Edg\//i',
        'Opera' => '/(?:OPR|Opera)\//i',
        'Chrome' => '/(?:Chrome|CriOS)\//i',
        'Firefox' => '/(?:Firefox|FxiOS)\//i',
        'Safari' => '/Safari\//i',
    ] as $name => $pattern) {
        if (preg_match($pattern, $userAgent) === 1) {
            $browser = $name;
            break;
        }
    }

    $os = 'Other';
    foreach ([
        'iOS' => '/(?:iPhone|iPad|iPod)/i',
        'Android' => '/Android/i',
        'Windows' => '/Windows NT/i',
        'macOS' => '/Macintosh|Mac OS X/i',
        'Linux' => '/Linux/i',
    ] as $name => $pattern) {
        if (preg_match($pattern, $userAgent) === 1) {
            $os = $name;
            break;
        }
    }

    $bot = preg_match('/bot|crawler|spider|slurp|headless|preview|facebookexternalhit|bingpreview/i', $userAgent) === 1;
    $device = preg_match('/tablet|ipad/i', $userAgent) === 1
        ? 'Tablet'
        : (preg_match('/mobile|iphone|ipod|android/i', $userAgent) === 1 ? 'Mobile' : 'Desktop');

    return [
        'browser' => $browser,
        'operating_system' => $os,
        'device_type' => $device,
        'is_bot' => $bot ? 1 : 0,
    ];
}

function analytics_secret(array $config): string
{
    $dataDir = (string) ($config['data_dir'] ?? '');
    $secretPath = rtrim($dataDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . '.analytics-secret';
    $existing = @file_get_contents($secretPath);
    if (is_string($existing) && strlen(trim($existing)) >= 32) {
        return trim($existing);
    }

    try {
        $secret = bin2hex(random_bytes(32));
    } catch (Throwable) {
        $secret = hash('sha256', $secretPath . PHP_VERSION);
    }
    @file_put_contents($secretPath, $secret, LOCK_EX);
    @chmod($secretPath, 0600);
    return $secret;
}

/** @return array{country_code:string,country:string,region:string,city:string,isp:string,source:string} */
function analytics_location(PDO $pdo, string $ip, array $config): array
{
    $empty = ['country_code' => '', 'country' => '', 'region' => '', 'city' => '', 'isp' => '', 'source' => ''];
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
        return $empty;
    }

    $settings = analytics_settings($config);
    if (($settings['geolocation_enabled'] ?? false) !== true) {
        return $empty;
    }

    $cacheDays = max(1, (int) ($settings['geolocation_cache_days'] ?? 30));
    $stmt = $pdo->prepare('SELECT * FROM analytics_ip_cache WHERE ip_address = :ip LIMIT 1');
    $stmt->execute([':ip' => $ip]);
    $cached = $stmt->fetch();
    if (is_array($cached)) {
        $age = time() - (strtotime((string) $cached['looked_up_at']) ?: 0);
        $maximumAge = ((int) $cached['success'] === 1 ? $cacheDays : 1) * 86400;
        if ($age >= 0 && $age < $maximumAge) {
            return [
                'country_code' => (string) $cached['country_code'],
                'country' => (string) $cached['country'],
                'region' => (string) $cached['region'],
                'city' => (string) $cached['city'],
                'isp' => (string) $cached['isp'],
                'source' => (string) $cached['source'],
            ];
        }
    }

    $endpoint = rtrim((string) ($settings['geolocation_endpoint'] ?? ''), '/') . '/';
    $result = $empty;
    $success = 0;
    if ($endpoint !== '/') {
        $context = stream_context_create(['http' => [
            'timeout' => 1.5,
            'ignore_errors' => true,
            'header' => "Accept: application/json\r\nUser-Agent: iainreid.dev first-party analytics\r\n",
        ]]);
        $response = @file_get_contents($endpoint . rawurlencode($ip), false, $context);
        $decoded = is_string($response) ? json_decode($response, true) : null;
        if (is_array($decoded) && ($decoded['success'] ?? false) === true) {
            $connection = is_array($decoded['connection'] ?? null) ? $decoded['connection'] : [];
            $result = [
                'country_code' => analytics_string($decoded['country_code'] ?? '', 8),
                'country' => analytics_string($decoded['country'] ?? '', 100),
                'region' => analytics_string($decoded['region'] ?? '', 100),
                'city' => analytics_string($decoded['city'] ?? '', 100),
                'isp' => analytics_string($connection['isp'] ?? ($connection['org'] ?? ''), 160),
                'source' => 'ipwho.is',
            ];
            $success = 1;
        }
    }

    $cache = $pdo->prepare(
        'INSERT INTO analytics_ip_cache
            (ip_address, looked_up_at, success, country_code, country, region, city, isp, source)
         VALUES
            (:ip, :looked_up, :success, :country_code, :country, :region, :city, :isp, :source)
         ON CONFLICT(ip_address) DO UPDATE SET
            looked_up_at = excluded.looked_up_at,
            success = excluded.success,
            country_code = excluded.country_code,
            country = excluded.country,
            region = excluded.region,
            city = excluded.city,
            isp = excluded.isp,
            source = excluded.source'
    );
    $cache->execute([
        ':ip' => $ip,
        ':looked_up' => gmdate('Y-m-d H:i:s'),
        ':success' => $success,
        ':country_code' => $result['country_code'],
        ':country' => $result['country'],
        ':region' => $result['region'],
        ':city' => $result['city'],
        ':isp' => $result['isp'],
        ':source' => $result['source'],
    ]);
    return $result;
}

function analytics_cleanup(PDO $pdo, array $config): void
{
    $days = max(1, (int) (analytics_settings($config)['retention_days'] ?? 180));
    $cutoff = gmdate('Y-m-d H:i:s', time() - ($days * 86400));
    $stmt = $pdo->prepare('DELETE FROM analytics_visits WHERE visited_at < :cutoff');
    $stmt->execute([':cutoff' => $cutoff]);
    $pdo->exec('DELETE FROM analytics_ip_cache WHERE ip_address NOT IN (SELECT DISTINCT ip_address FROM analytics_visits)');
}
