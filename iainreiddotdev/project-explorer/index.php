<?php

declare(strict_types=1);

/**
 * Seeds of the Throne Project Explorer.
 *
 * A read-only view of the deployed repository's folder structure and Markdown
 * documents. It shares the portfolio design system and has no dependencies.
 */

require dirname(__DIR__) . '/includes/portfolio.php';
require dirname(__DIR__) . '/includes/repository-explorer.php';
require dirname(__DIR__) . '/includes/partials/icons.php';

$repositoryRoot = dirname(__DIR__, 2);
$files = explorer_markdown_files($repositoryRoot);
$tree = explorer_build_tree($files);
$fileSet = array_fill_keys($files, true);

$requested = isset($_GET['file']) && is_string($_GET['file'])
    ? trim(str_replace('\\', '/', $_GET['file']))
    : 'README.md';
$query = isset($_GET['q']) && is_string($_GET['q']) ? trim($_GET['q']) : '';
$error = null;

if (!isset($fileSet[$requested])) {
    http_response_code(404);
    $error = 'That Markdown document is not available in the public repository explorer.';
    $requested = isset($fileSet['README.md']) ? 'README.md' : ($files[0] ?? '');
}

$markdown = '';
$rendered = '';
$modified = null;
$bytes = null;
if ($requested !== '') {
    $absolutePath = $repositoryRoot . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $requested);
    $resolvedPath = realpath($absolutePath);
    $resolvedRoot = realpath($repositoryRoot);
    $isSafeDocument = $resolvedPath !== false
        && $resolvedRoot !== false
        && str_starts_with($resolvedPath, rtrim($resolvedRoot, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR)
        && is_file($resolvedPath)
        && !is_link($resolvedPath)
        && strtolower(pathinfo($resolvedPath, PATHINFO_EXTENSION)) === 'md';
    $contents = $isSafeDocument ? file_get_contents($resolvedPath) : false;
    if ($contents === false || $resolvedPath === false) {
        http_response_code(500);
        $error = 'This document could not be read. Return to the repository overview and try another file.';
    } else {
        $markdown = $contents;
        $rendered = explorer_render_markdown($markdown, $requested, $files);
        $modifiedValue = filemtime($resolvedPath);
        $modified = $modifiedValue === false ? null : $modifiedValue;
        $sizeValue = filesize($resolvedPath);
        $bytes = $sizeValue === false ? null : $sizeValue;
    }
}

$matches = [];
if ($query !== '') {
    $matches = array_values(array_filter(
        $files,
        static fn (string $path): bool => stripos($path, $query) !== false
    ));
}

$data = portfolio();
$identity = $data['identity'];
$links = $data['links'];
$pageTitle = 'Project Explorer | Seeds of the Throne';
$pageDescription = 'Explore the Seeds of the Throne repository structure and read its public Markdown documents.';
$canonical = 'https://iainreid.dev/devsite/iainreiddotdev/project-explorer/';
$assetVersion = '20260814a';
$year = (int) date('Y');
$hasDocumentHeading = preg_match('/^#\s+.+$/m', $markdown) === 1;

function explorer_format_bytes(?int $bytes): string
{
    if ($bytes === null) {
        return 'Size unavailable';
    }
    if ($bytes < 1024) {
        return $bytes . ' B';
    }
    return number_format($bytes / 1024, 1) . ' KB';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($pageDescription) ?>">
    <link rel="canonical" href="<?= e($canonical) ?>">
    <meta property="og:title" content="<?= e($pageTitle) ?>">
    <meta property="og:description" content="<?= e($pageDescription) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= e($canonical) ?>">
    <meta name="theme-color" content="#fbf9f5" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#1d1b18" media="(prefers-color-scheme: dark)">
    <link rel="icon" href="../assets/favicon.svg?v=<?= e($assetVersion) ?>" type="image/svg+xml">
    <link rel="stylesheet" href="../assets/css/site.css?v=<?= e($assetVersion) ?>">
    <link rel="stylesheet" href="assets/project-explorer.css?v=<?= e($assetVersion) ?>">
    <script>
        (function () {
            try {
                var stored = localStorage.getItem('theme');
                if (stored === 'light' || stored === 'dark') {
                    document.documentElement.setAttribute('data-theme', stored);
                }
            } catch (error) {
                /* Keep the system appearance when storage is unavailable. */
            }
        })();
    </script>
</head>
<body class="explorer-page">
    <a class="skip-link" href="#document">Skip to document</a>

    <header class="site-header" id="site-header">
        <div class="wrap site-header__inner">
            <a class="brand" href="../" aria-label="Return to Iain Reid's portfolio">
                <span class="brand__mark" aria-hidden="true"><?= e($identity['initials']) ?></span>
                <span class="brand__name">Project Explorer</span>
            </a>

            <div class="explorer-nav">
                <a href="../">Portfolio</a>
                <a href="<?= e($links['github']) ?>/seeds-of-the-throne" rel="noopener noreferrer">GitHub</a>
                <button
                    class="theme-toggle"
                    type="button"
                    id="theme-toggle"
                    aria-label="Switch to dark appearance">
                    <?php icon('sun', 'icon-sun'); ?>
                    <?php icon('moon', 'icon-moon'); ?>
                </button>
            </div>
        </div>
    </header>

    <main id="main">
        <section class="explorer-hero wrap" aria-labelledby="explorer-title">
            <p class="kicker"><span class="kicker__num">SOTT</span><span>Repository view</span></p>
            <h1 id="explorer-title">Seeds of the Throne Project Explorer</h1>
            <p>Explore the structure behind the story. Browse <?= e((string) count($files)) ?> Markdown documents across canon, research, development sessions, visual systems, drafts, public material, and project coordination.</p>
        </section>

        <div class="explorer-shell wrap">
            <aside class="explorer-sidebar" aria-label="Repository navigation">
                <form class="explorer-search" method="get" action="">
                    <label for="repository-search">Find a document</label>
                    <div>
                        <input
                            id="repository-search"
                            name="q"
                            type="search"
                            value="<?= e($query) ?>"
                            placeholder="Character, system, report...">
                        <button class="btn" type="submit">Search</button>
                    </div>
                </form>

                <?php if ($query !== ''): ?>
                    <section class="explorer-results" aria-labelledby="results-title">
                        <div class="explorer-results__head">
                            <h2 id="results-title"><?= e((string) count($matches)) ?> result<?= count($matches) === 1 ? '' : 's' ?></h2>
                            <a href="<?= e(explorer_file_url($requested)) ?>">Clear search</a>
                        </div>
                        <?php if ($matches === []): ?>
                            <p>No document paths contain “<?= e($query) ?>”. Try a character, place, system, or report name.</p>
                        <?php else: ?>
                            <ul>
                                <?php foreach ($matches as $path): ?>
                                    <li><a href="<?= e(explorer_file_url($path)) ?>"><?= e($path) ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </section>
                <?php else: ?>
                    <details class="explorer-index" open>
                        <summary>
                            <span>Repository structure</span>
                            <span><?= e((string) count($files)) ?> documents</span>
                        </summary>
                        <nav aria-label="Markdown documents">
                            <?php explorer_render_tree($tree, $requested); ?>
                        </nav>
                    </details>
                <?php endif; ?>
            </aside>

            <article class="explorer-document" id="document" aria-label="<?= e($requested !== '' ? $requested : 'Repository document') ?>">
                <?php if ($error !== null): ?>
                    <div class="explorer-error" role="alert">
                        <h2>Document unavailable</h2>
                        <p><?= e($error) ?></p>
                    </div>
                <?php endif; ?>

                <?php if ($requested !== '' && $rendered !== ''): ?>
                    <header class="explorer-document__header">
                        <nav class="breadcrumbs" aria-label="Document path">
                            <ol>
                                <li><a href="?file=README.md">Repository</a></li>
                                <?php $segments = explode('/', $requested); ?>
                                <?php foreach ($segments as $segment): ?>
                                    <li><span><?= e($segment) ?></span></li>
                                <?php endforeach; ?>
                            </ol>
                        </nav>
                        <div class="explorer-document__meta">
                            <span><?= e(explorer_format_bytes($bytes)) ?></span>
                            <?php if ($modified !== null): ?>
                                <span>Updated <time datetime="<?= e(date(DATE_ATOM, $modified)) ?>"><?= e(date('M j, Y', $modified)) ?></time></span>
                            <?php endif; ?>
                            <a href="<?= e($links['github']) ?>/seeds-of-the-throne/blob/main/<?= e(str_replace('%2F', '/', rawurlencode($requested))) ?>" rel="noopener noreferrer">View source on GitHub</a>
                        </div>
                    </header>

                    <div class="markdown-body">
                        <?php if (!$hasDocumentHeading): ?>
                            <h2><?= e(pathinfo($requested, PATHINFO_FILENAME)) ?></h2>
                        <?php endif; ?>
                        <?= $rendered ?>
                    </div>
                <?php elseif ($error === null): ?>
                    <div class="explorer-empty">
                        <h2>No Markdown documents found</h2>
                        <p>The deployed repository does not currently contain a document the explorer can open.</p>
                    </div>
                <?php endif; ?>
            </article>
        </div>
    </main>

    <footer class="site-footer">
        <div class="wrap site-footer__inner">
            <p>&copy; <?= e((string) $year) ?> Iain Reid</p>
            <div class="site-footer__links">
                <a href="../">Portfolio</a>
                <a href="<?= e($links['github']) ?>/seeds-of-the-throne" rel="noopener noreferrer">Repository</a>
                <a href="../../docs/">Story atlas</a>
            </div>
        </div>
    </footer>

    <script src="../assets/js/site.js?v=<?= e($assetVersion) ?>" defer></script>
</body>
</html>
