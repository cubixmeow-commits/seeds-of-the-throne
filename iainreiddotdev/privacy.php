<?php

declare(strict_types=1);

require __DIR__ . '/includes/portfolio.php';
require __DIR__ . '/includes/partials/icons.php';

$data = portfolio();
$identity = $data['identity'];
$links = $data['links'];
$year = (int) date('Y');
$canonical = 'https://iainreid.dev/devsite/iainreiddotdev/privacy.php';
$pageTitle = 'Privacy | Iain Reid';
$pageDescription = 'How first-party visitor analytics are collected and protected on the Iain Reid portfolio and Seeds of the Throne story site.';
$assetVersion = '20260918a';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php require __DIR__ . '/includes/partials/head.php'; ?>
</head>
<body>
    <a class="skip-link" href="#main">Skip to content</a>
    <?php require __DIR__ . '/includes/partials/site-header.php'; ?>

    <main id="main" class="privacy-main">
        <article class="privacy-record">
            <p class="eyebrow">Privacy and visitor analytics</p>
            <h1>Useful traffic information without advertising trackers.</h1>
            <p class="privacy-lede">This portfolio, Project Explorer, and the Seeds of the Throne story site use a small first-party analytics system operated by Iain Reid.</p>

            <section>
                <h2>What is collected</h2>
                <p>For each recorded pageview, the system stores the date and time, requested page and title, referrer path when available, IP address, a short visitor ID derived from the IP address and browser, browser and device information, language, time zone, and screen dimensions.</p>
                <p>A server-side lookup through ipwho.is may add an approximate city, region, country, and internet provider. IP location is approximate and does not identify a person or a precise physical address.</p>
            </section>

            <section>
                <h2>How it is used</h2>
                <p>The information is used only to understand which pages people visit, how they found the site, whether the mobile and desktop experiences are reaching readers, and broad geographic and network patterns. It is not used for advertising, sold, or combined with outside profiles.</p>
            </section>

            <section>
                <h2>Storage and choices</h2>
                <p>Analytics records are stored in a protected SQLite database on the site server and automatically expire after 180 days. The collector does not set an analytics cookie. Global Privacy Control and Do Not Track signals are honored.</p>
                <p>You can also disable analytics for this browser. This choice is saved only in your browser.</p>
                <p class="privacy-choice">
                    <button class="btn" type="button" data-analytics-opt-out>Disable analytics</button>
                    <button class="btn btn--quiet" type="button" data-analytics-opt-in>Enable analytics</button>
                    <span role="status" data-analytics-status></span>
                </p>
            </section>

            <section>
                <h2>Questions or deletion requests</h2>
                <p>To ask about the analytics record or request deletion of information associated with your IP address, email <a href="<?= e($links['mailto']) ?>"><?= e($links['email']) ?></a>.</p>
            </section>
        </article>
    </main>

    <?php require __DIR__ . '/includes/partials/site-footer.php'; ?>
    <script src="assets/js/site.js?v=<?= e($assetVersion) ?>" defer></script>
    <script>
        (function () {
            var status = document.querySelector('[data-analytics-status]');
            function render() {
                var disabled = false;
                try { disabled = localStorage.getItem('site_analytics_opt_out') === '1'; } catch (error) {}
                if (status) status.textContent = disabled ? 'Analytics is disabled in this browser.' : 'Analytics is enabled unless your browser sends a privacy signal.';
            }
            document.querySelector('[data-analytics-opt-out]').addEventListener('click', function () {
                try { localStorage.setItem('site_analytics_opt_out', '1'); } catch (error) {}
                render();
            });
            document.querySelector('[data-analytics-opt-in]').addEventListener('click', function () {
                try { localStorage.removeItem('site_analytics_opt_out'); } catch (error) {}
                render();
            });
            render();
        })();
    </script>
</body>
</html>
