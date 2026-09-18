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
$pageDescription = 'Privacy notice for the Iain Reid portfolio and Seeds of the Throne story site.';
$assetVersion = '20260918c';
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
            <p class="privacy-choice">
                <button class="btn" type="button" data-analytics-opt-out>Disable analytics</button>
                <button class="btn btn--quiet" type="button" data-analytics-opt-in>Enable analytics</button>
                <span role="status" data-analytics-status></span>
            </p>
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
