<?php

declare(strict_types=1);

/**
 * Document head: metadata, social cards, structured data, and the one inline
 * script on the page.
 *
 * Every fact emitted here — name, role, statement, email, profiles, portrait —
 * is read from includes/portfolio.php. Nothing is written down twice and
 * nothing is invented.
 *
 * Expects: $identity, $links, $canonical, $pageTitle, $pageDescription,
 *          $assetVersion.
 */

/** Absolute URLs are derived from the canonical so they can never disagree. */
$ogImage = $canonical . ltrim($identity['portrait']['src'], '/');

$personLd = [
    '@context' => 'https://schema.org',
    '@type' => 'Person',
    'name' => $identity['name'],
    'url' => $canonical,
    'jobTitle' => $identity['role'],
    'description' => $identity['statement'],
    'email' => $links['email'],
    'image' => $ogImage,
    'sameAs' => [$links['github'], $links['x']],
];
?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($pageDescription) ?>">
    <link rel="canonical" href="<?= e($canonical) ?>">

    <meta property="og:title" content="<?= e($pageTitle) ?>">
    <meta property="og:description" content="<?= e($pageDescription) ?>">
    <meta property="og:type" content="profile">
    <meta property="og:url" content="<?= e($canonical) ?>">
    <meta property="og:image" content="<?= e($ogImage) ?>">
    <meta property="og:image:alt" content="<?= e($identity['portrait']['alt']) ?>">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:creator" content="<?= e($links['x_handle']) ?>">

    <!-- Warm paper and warm ink: the two page backgrounds, so the browser
         chrome matches the appearance the visitor actually gets. -->
    <meta name="theme-color" content="#fbf9f5" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#1d1b18" media="(prefers-color-scheme: dark)">

    <link rel="icon" href="assets/favicon.svg?v=<?= e($assetVersion) ?>" type="image/svg+xml">
    <link rel="stylesheet" href="assets/css/site.css?v=<?= e($assetVersion) ?>">

    <script type="application/ld+json"><?= json_encode(
        $personLd,
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP
    ) ?></script>

    <!-- The only blocking script on the page. It applies a stored appearance
         before first paint so a visitor who chose light never sees a dark
         flash. Without it the site still follows the system preference. -->
    <script>
        (function () {
            try {
                var stored = localStorage.getItem('theme');
                if (stored === 'light' || stored === 'dark') {
                    document.documentElement.setAttribute('data-theme', stored);
                }
            } catch (error) {
                /* Private mode or blocked storage: keep the system preference. */
            }
        })();
    </script>
