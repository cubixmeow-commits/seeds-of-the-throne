<?php

declare(strict_types=1);

/**
 * iainreid.dev — homepage.
 *
 * A single editorial page composed from small partials. Every fact on it is
 * read from includes/portfolio.php, which stays the only source of truth:
 * adding a project is still a data edit and no copy is written down twice.
 *
 * Runs on PHP 8.2 (Namecheap shared hosting / LiteSpeed). No build step, no
 * package manager, no framework, no third-party runtime dependency. The page
 * requests one stylesheet, one script, and one image.
 */

require __DIR__ . '/includes/portfolio.php';
require __DIR__ . '/includes/partials/icons.php';

$data = portfolio();
$identity = $data['identity'];
$links = $data['links'];
$projects = $data['projects'];
$categories = $data['categories'];
$foundations = $data['foundations'];
$method = $data['method'];

$year = (int) date('Y');

/* The published repository root redirects here while the portfolio remains self-contained. */
$canonical = 'https://iainreid.dev/devsite/iainreiddotdev/';

$pageTitle = 'Iain Reid — creative and software development portfolio';
$pageDescription = 'Seeds of the Throne is Iain Reid’s creative and software-development showcase: a speculative world built with repository architecture, author-directed AI, visual generation, and public publishing systems.';
$assetVersion = '20260813a';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php require __DIR__ . '/includes/partials/head.php'; ?>
</head>
<body>
    <a class="skip-link" href="#main">Skip to content</a>

    <?php require __DIR__ . '/includes/partials/site-header.php'; ?>

    <main id="main">
        <?php require __DIR__ . '/includes/partials/intro.php'; ?>
        <?php require __DIR__ . '/includes/partials/work.php'; ?>
        <?php require __DIR__ . '/includes/partials/approach.php'; ?>
        <?php require __DIR__ . '/includes/partials/foundations.php'; ?>
        <?php require __DIR__ . '/includes/partials/about.php'; ?>
        <?php require __DIR__ . '/includes/partials/contact.php'; ?>
    </main>

    <?php require __DIR__ . '/includes/partials/site-footer.php'; ?>
    <?php require __DIR__ . '/includes/partials/showdown.php'; ?>

    <script src="assets/js/site.js?v=<?= e($assetVersion) ?>" defer></script>
</body>
</html>
