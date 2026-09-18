<?php

declare(strict_types=1);

require __DIR__ . '/../includes/bootstrap.php';
require __DIR__ . '/../includes/layout.php';

require_admin();

$pdo = db();
$allowedRanges = [1, 7, 30, 90, 180];
$range = isset($_GET['range']) ? (int) $_GET['range'] : 30;
if (!in_array($range, $allowedRanges, true)) {
    $range = 30;
}

$allowedSites = ['', 'Portfolio', 'Project Explorer', 'Seeds story'];
$site = isset($_GET['site']) && is_string($_GET['site']) ? $_GET['site'] : '';
if (!in_array($site, $allowedSites, true)) {
    $site = '';
}

$includeBots = isset($_GET['bots']) && $_GET['bots'] === '1';
$cutoff = gmdate('Y-m-d H:i:s', time() - ($range * 86400));
$where = ['visited_at >= :cutoff'];
$params = [':cutoff' => $cutoff];
if ($site !== '') {
    $where[] = 'site = :site';
    $params[':site'] = $site;
}
if (!$includeBots) {
    $where[] = 'is_bot = 0';
}
$whereSql = implode(' AND ', $where);

function analytics_query(PDO $pdo, string $sql, array $params): PDOStatement
{
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

function analytics_location_label(array $row): string
{
    $parts = array_values(array_filter([
        (string) ($row['city'] ?? ''),
        (string) ($row['region'] ?? ''),
        (string) ($row['country'] ?? ''),
    ], static fn (string $value): bool => $value !== ''));
    return $parts === [] ? 'Location unavailable' : implode(', ', array_unique($parts));
}

if (isset($_GET['format']) && $_GET['format'] === 'csv') {
    $rows = analytics_query(
        $pdo,
        "SELECT visited_at, site, page_path, page_title, referrer, ip_address,
                visitor_hash, browser, operating_system, device_type, language,
                visitor_timezone, screen_width, screen_height, city, region,
                country, country_code, isp, is_bot
           FROM analytics_visits
          WHERE $whereSql
          ORDER BY visited_at DESC, id DESC
          LIMIT 5000",
        $params
    )->fetchAll();

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="visitor-analytics-' . gmdate('Y-m-d') . '.csv"');
    header('Cache-Control: no-store, max-age=0');
    $output = fopen('php://output', 'wb');
    if ($output !== false) {
        fputcsv($output, [
            'Visited UTC', 'Site', 'Page', 'Title', 'Referrer', 'IP address',
            'Visitor ID', 'Browser', 'OS', 'Device', 'Language', 'Time zone',
            'Screen width', 'Screen height', 'City', 'Region', 'Country',
            'Country code', 'ISP', 'Bot',
        ]);
        foreach ($rows as $row) {
            fputcsv($output, array_values($row));
        }
        fclose($output);
    }
    exit;
}

$summary = analytics_query(
    $pdo,
    "SELECT COUNT(*) AS pageviews,
            COUNT(DISTINCT visitor_hash) AS visitors,
            COUNT(DISTINCT page_path) AS pages,
            SUM(CASE WHEN is_bot = 1 THEN 1 ELSE 0 END) AS bots
       FROM analytics_visits WHERE $whereSql",
    $params
)->fetch() ?: [];

$topPages = analytics_query(
    $pdo,
    "SELECT site, page_path, MAX(page_title) AS page_title,
            COUNT(*) AS pageviews, COUNT(DISTINCT visitor_hash) AS visitors
       FROM analytics_visits WHERE $whereSql
      GROUP BY site, page_path ORDER BY pageviews DESC, visitors DESC LIMIT 12",
    $params
)->fetchAll();

$locations = analytics_query(
    $pdo,
    "SELECT city, region, country, country_code, isp,
            COUNT(*) AS pageviews, COUNT(DISTINCT visitor_hash) AS visitors
       FROM analytics_visits WHERE $whereSql
      GROUP BY city, region, country, country_code, isp
      ORDER BY visitors DESC, pageviews DESC LIMIT 12",
    $params
)->fetchAll();

$referrers = analytics_query(
    $pdo,
    "SELECT CASE WHEN referrer = '' THEN 'Direct or unavailable' ELSE referrer END AS source,
            COUNT(*) AS pageviews, COUNT(DISTINCT visitor_hash) AS visitors
       FROM analytics_visits WHERE $whereSql
      GROUP BY source ORDER BY visitors DESC, pageviews DESC LIMIT 12",
    $params
)->fetchAll();

$recent = analytics_query(
    $pdo,
    "SELECT visited_at, site, page_path, page_title, referrer, ip_address,
            visitor_hash, browser, operating_system, device_type, city, region,
            country, isp, is_bot
       FROM analytics_visits WHERE $whereSql
      ORDER BY visited_at DESC, id DESC LIMIT 200",
    $params
)->fetchAll();

$query = ['range' => $range];
if ($site !== '') {
    $query['site'] = $site;
}
if ($includeBots) {
    $query['bots'] = '1';
}
$csvUrl = url('admin/analytics.php?' . http_build_query($query + ['format' => 'csv']));
$retention = (int) (analytics_settings(SAAS_LAB_CONFIG)['retention_days'] ?? 180);

render_page_top('Visitor analytics', 'analytics');
?>
<section class="auth-card auth-card--wide analytics" aria-labelledby="analytics-title">
    <div class="analytics__heading">
        <div>
            <p class="mono">Private dashboard · UTC</p>
            <h1 id="analytics-title">Visitor analytics</h1>
            <p class="auth-lede">First-party traffic for the portfolio, Project Explorer, and Seeds story site.</p>
        </div>
        <a class="btn btn--ghost" href="<?= e($csvUrl) ?>">Export CSV</a>
    </div>

    <form class="analytics-filters" method="get">
        <label>Period
            <select name="range">
                <?php foreach ($allowedRanges as $days): ?>
                    <option value="<?= e((string) $days) ?>"<?= $range === $days ? ' selected' : '' ?>>Last <?= e((string) $days) ?> day<?= $days === 1 ? '' : 's' ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Site
            <select name="site">
                <option value="">All sites</option>
                <?php foreach (array_slice($allowedSites, 1) as $option): ?>
                    <option value="<?= e($option) ?>"<?= $site === $option ? ' selected' : '' ?>><?= e($option) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label class="analytics-filters__check">
            <input type="checkbox" name="bots" value="1"<?= $includeBots ? ' checked' : '' ?>> Include detected bots
        </label>
        <button class="btn btn--primary" type="submit">Apply</button>
    </form>

    <ul class="summary analytics-summary" aria-label="Traffic totals">
        <li class="summary__stat"><span class="summary__value"><?= e((string) ($summary['visitors'] ?? 0)) ?></span><span class="summary__label">Distinct visitors</span></li>
        <li class="summary__stat"><span class="summary__value"><?= e((string) ($summary['pageviews'] ?? 0)) ?></span><span class="summary__label">Pageviews</span></li>
        <li class="summary__stat"><span class="summary__value"><?= e((string) ($summary['pages'] ?? 0)) ?></span><span class="summary__label">Pages visited</span></li>
        <?php if ($includeBots): ?><li class="summary__stat"><span class="summary__value"><?= e((string) ($summary['bots'] ?? 0)) ?></span><span class="summary__label">Detected bot views</span></li><?php endif; ?>
    </ul>

    <div class="analytics-grid">
        <section>
            <h2>Most visited pages</h2>
            <?php if ($topPages === []): ?><p class="analytics-empty">No visits in this period.</p><?php else: ?>
                <div class="table-scroll"><table class="registry"><thead><tr><th>Page</th><th>Visitors</th><th>Views</th></tr></thead><tbody>
                <?php foreach ($topPages as $row): ?><tr><td><strong><?= e((string) $row['site']) ?></strong><small><?= e((string) ($row['page_title'] ?: $row['page_path'])) ?></small></td><td><?= e((string) $row['visitors']) ?></td><td><?= e((string) $row['pageviews']) ?></td></tr><?php endforeach; ?>
                </tbody></table></div>
            <?php endif; ?>
        </section>
        <section>
            <h2>Locations and networks</h2>
            <?php if ($locations === []): ?><p class="analytics-empty">No location data in this period.</p><?php else: ?>
                <div class="table-scroll"><table class="registry"><thead><tr><th>Approximate location</th><th>Network</th><th>Visitors</th></tr></thead><tbody>
                <?php foreach ($locations as $row): ?><tr><td><?= e(analytics_location_label($row)) ?></td><td><?= e((string) ($row['isp'] ?: 'Unavailable')) ?></td><td><?= e((string) $row['visitors']) ?></td></tr><?php endforeach; ?>
                </tbody></table></div>
            <?php endif; ?>
        </section>
    </div>

    <section class="analytics-section">
        <h2>Referrers</h2>
        <?php if ($referrers === []): ?><p class="analytics-empty">No referrer data in this period.</p><?php else: ?>
            <div class="table-scroll"><table class="registry"><thead><tr><th>Source</th><th>Visitors</th><th>Views</th></tr></thead><tbody>
            <?php foreach ($referrers as $row): ?><tr><td><?= e((string) $row['source']) ?></td><td><?= e((string) $row['visitors']) ?></td><td><?= e((string) $row['pageviews']) ?></td></tr><?php endforeach; ?>
            </tbody></table></div>
        <?php endif; ?>
    </section>

    <section class="analytics-section">
        <h2>Recent visits</h2>
        <p class="analytics-note">Visitor IDs group the same IP and browser without a tracking cookie. Location is approximate. Records automatically expire after <?= e((string) $retention) ?> days.</p>
        <?php if ($recent === []): ?><p class="analytics-empty">No visits in this period.</p><?php else: ?>
            <div class="table-scroll"><table class="registry analytics-recent"><thead><tr><th>Time</th><th>Visitor</th><th>Page</th><th>Location</th><th>Device</th><th>Referrer</th></tr></thead><tbody>
            <?php foreach ($recent as $row): ?><tr>
                <td><?= e((string) $row['visited_at']) ?></td>
                <td><strong><?= e((string) $row['ip_address']) ?></strong><small><?= e((string) $row['visitor_hash']) ?><?= (int) $row['is_bot'] === 1 ? ' · bot' : '' ?></small></td>
                <td><strong><?= e((string) $row['site']) ?></strong><small><?= e((string) ($row['page_title'] ?: $row['page_path'])) ?></small></td>
                <td><?= e(analytics_location_label($row)) ?><small><?= e((string) ($row['isp'] ?: 'Network unavailable')) ?></small></td>
                <td><?= e(implode(' · ', array_filter([(string) $row['device_type'], (string) $row['browser'], (string) $row['operating_system']]))) ?></td>
                <td><?= e((string) ($row['referrer'] ?: 'Direct or unavailable')) ?></td>
            </tr><?php endforeach; ?>
            </tbody></table></div>
        <?php endif; ?>
    </section>
</section>
<?php render_page_bottom(); ?>
