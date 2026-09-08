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

$explorerViews = explorer_views();
$view = explorer_normalize_view(isset($_GET['view']) && is_string($_GET['view']) ? $_GET['view'] : null);
if (!isset($_GET['view'])
    && (
        (isset($_GET['file']) && is_string($_GET['file']) && trim($_GET['file']) !== '')
        || (isset($_GET['q']) && is_string($_GET['q']) && trim($_GET['q']) !== '')
    )) {
    $view = 'files';
}

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
        $rendered = preg_replace('/<(\/?)h1\b/', '<$1h2', $rendered) ?? $rendered;
        $modifiedValue = filemtime($resolvedPath);
        $modified = $modifiedValue === false ? null : $modifiedValue;
        $sizeValue = filesize($resolvedPath);
        $bytes = $sizeValue === false ? null : $sizeValue;
    }
}

$matches = explorer_search_markdown($repositoryRoot, $files, $query);

$completionPointerPath = '07 Coordination/Weekly Synthesis/CURRENT-COMPLETION-TODO.md';
$completionRegistryPath = '07 Coordination/Story Completion Workflow/TASK-REGISTRY.md';
$completionCurrentPath = '07 Coordination/Story Completion Workflow/CURRENT.md';
$completionSweeps = [
    'Macro',
    'Causal',
    'Agency',
    'Systems + evidence',
    'Sequence',
    'Scene map',
    'Scene development',
    'Draft',
];
$completionPublicLabels = [
    1 => 'Containment rules',
    2 => 'Modern inciting loss',
    3 => 'Human–Luminai breakthrough',
    4 => 'Evidence chain',
    5 => 'Character agency',
    6 => 'Eighty-year middle',
    7 => 'Endgame mechanics',
    8 => 'Narrative form',
];
$completion = [
    'available' => false,
    'completed' => 0,
    'total' => 0,
    'percent' => 0,
    'current_sweep' => 'Macro Shape',
    'current_task' => 'SC-001',
    'active_sweep' => 0,
    'working_fronts' => [],
];

if (
    isset($fileSet[$completionPointerPath], $fileSet[$completionRegistryPath], $fileSet[$completionCurrentPath])
) {
    $pointerContents = file_get_contents($repositoryRoot . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $completionPointerPath));
    $currentContents = file_get_contents($repositoryRoot . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $completionCurrentPath));

    if (
        $pointerContents !== false
        && $currentContents !== false
        && preg_match('/^source_path:\s*(.+)$/m', $pointerContents, $pointerMatch) === 1
    ) {
        $todoPath = trim($pointerMatch[1]);
        if (isset($fileSet[$todoPath])) {
            $todoContents = file_get_contents($repositoryRoot . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $todoPath));
            if ($todoContents !== false) {
                $priority = null;
                $priorityCounts = [];
                foreach (preg_split('/\R/', $todoContents) ?: [] as $line) {
                    if (preg_match('/^# Priority (\d+)\b/', $line, $priorityMatch) === 1) {
                        $priority = (int) $priorityMatch[1];
                        $priorityCounts[$priority] ??= ['completed' => 0, 'total' => 0];
                        continue;
                    }
                    if (str_starts_with($line, '# ')) {
                        $priority = null;
                        continue;
                    }
                    if ($priority !== null && preg_match('/^- \[([ xX])\]/', $line, $taskMatch) === 1) {
                        $priorityCounts[$priority]['total']++;
                        $completion['total']++;
                        if (strtolower($taskMatch[1]) === 'x') {
                            $priorityCounts[$priority]['completed']++;
                            $completion['completed']++;
                        }
                    }
                }

                foreach ($priorityCounts as $number => $counts) {
                    if ($counts['completed'] < $counts['total'] && isset($completionPublicLabels[$number])) {
                        $completion['working_fronts'][] = $completionPublicLabels[$number];
                    }
                    if (count($completion['working_fronts']) === 3) {
                        break;
                    }
                }

                if (preg_match('/\*\*Current sweep:\*\*\s*([^\n]+)/', $currentContents, $sweepMatch) === 1) {
                    $completion['current_sweep'] = trim($sweepMatch[1]);
                }
                if (preg_match('/\*\*Current task:\*\*\s*(SC-\d{3})\b/', $currentContents, $taskMatch) === 1) {
                    $completion['current_task'] = $taskMatch[1];
                }
                $sweepNeedle = strtolower(strtok($completion['current_sweep'], ' ') ?: 'macro');
                foreach ($completionSweeps as $index => $sweep) {
                    if (str_starts_with(strtolower($sweep), $sweepNeedle)) {
                        $completion['active_sweep'] = $index;
                        break;
                    }
                }
                $completion['percent'] = $completion['total'] > 0
                    ? (int) round(($completion['completed'] / $completion['total']) * 100)
                    : 0;
                $completion['available'] = $completion['total'] > 0;
            }
        }
    }
}

$data = portfolio();
$identity = $data['identity'];
$links = $data['links'];
$pageTitle = 'Project Explorer | Seeds of the Throne';
$pageDescription = 'See how thousands of story ideas, notes, decisions, and questions are being organized into the finished Seeds of the Throne series.';
$canonical = 'https://iainreid.dev/devsite/iainreiddotdev/project-explorer/';
$assetVersion = '20260911-hpi';
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
    <meta name="theme-color" content="#f3eee4" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#0b0c0b" media="(prefers-color-scheme: dark)">
    <link rel="icon" href="../assets/favicon.svg?v=<?= e($assetVersion) ?>" type="image/svg+xml">
    <link rel="stylesheet" href="../assets/css/site.css?v=<?= e($assetVersion) ?>">
    <link rel="stylesheet" href="assets/project-explorer.css?v=<?= e($assetVersion) ?>">
    <link rel="stylesheet" href="assets/workbench.css?v=<?= e($assetVersion) ?>">
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
    <a class="skip-link" href="#main">Skip to content</a>

    <header class="site-header" id="site-header">
        <div class="wrap site-header__inner">
            <a class="brand" href="<?= e(explorer_view_url('overview')) ?>" aria-label="Project Explorer home">
                <span class="brand__mark" aria-hidden="true">ST</span>
                <span class="brand__name">Seeds of the Throne</span>
            </a>
            <button
                class="product-nav__toggle"
                type="button"
                id="product-nav-toggle"
                data-product-nav-button
                aria-expanded="false"
                aria-controls="product-nav"
                aria-label="Open Project Explorer menu">
                <span>Menu</span>
                <span aria-hidden="true">☰</span>
            </button>
            <nav class="product-nav" id="product-nav" data-product-nav aria-label="Project Explorer">
                <?php foreach ($explorerViews as $key => $meta): ?>
                    <?php
                    $navParams = [];
                    if ($key === 'files') {
                        $navParams['file'] = $requested !== '' ? $requested : 'README.md';
                        if ($query !== '') {
                            $navParams['q'] = $query;
                        }
                    }
                    if ($key === 'workshop' && isset($_GET['module']) && is_string($_GET['module'])) {
                        $navParams['module'] = $_GET['module'];
                    }
                    ?>
                    <a href="<?= e(explorer_view_url($key, $navParams)) ?>"<?= $key === $view ? ' aria-current="page"' : '' ?>><?= e($meta['label']) ?></a>
                <?php endforeach; ?>
            </nav>
            <div class="explorer-nav">
                <a href="../">Portfolio</a>
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
        <section class="explorer-hero" aria-labelledby="explorer-title">
            <div class="explorer-hero__content wrap">
                <p class="explorer-hero__label">Project Explorer</p>
                <h1 id="explorer-title">Seeds of the Throne</h1>
                <p class="explorer-hero__lede">Seeds of the Throne began as years of conversations and thousands of story ideas. The Project Explorer shows how those ideas are being organized into characters, a world, a timeline, and a finished series.</p>
                <div class="explorer-hero__actions" aria-label="Explorer actions">
                    <a class="archive-cta archive-cta--primary" href="<?= e(explorer_view_url('overview')) ?>">
                        <span>See how the story is being built</span>
                        <span class="archive-cta__arrow" aria-hidden="true">↓</span>
                    </a>
                    <a class="archive-cta" href="<?= e(explorer_view_url('files', ['file' => $requested !== '' ? $requested : 'README.md'])) ?>">Browse the story files</a>
                </div>
            </div>
            <figure class="explorer-hero__frame">
                <img
                    class="explorer-hero__image"
                    src="../../docs/assets/images/recovered-records-evidence-v1.webp"
                    alt="Interpretive still life of recovered records aligned against hidden-system evidence."
                    width="1774"
                    height="887"
                    fetchpriority="high">
                <figcaption class="explorer-hero__caption">Working instrument. Evidence language without cinematic key art.</figcaption>
            </figure>
        </section>

        <?php require __DIR__ . '/workbench.php'; ?>

        <section class="explorer-progress" id="story-progress" aria-labelledby="story-progress-title">
            <div class="wrap">
                <header class="explorer-progress__header">
                    <p class="archive-intro__index">Current story development</p>
                    <div>
                        <h2 id="story-progress-title">See what the story already has and what it still needs.</h2>
                        <p>The system checks the whole story for missing causes, weak character decisions, unclear rules, and unfinished events. The results show the author what to work on next.</p>
                    </div>
                </header>

                <article class="explorer-assessment" aria-labelledby="assessment-title">
                    <div>
                        <p class="explorer-assessment__date">Current story premise</p>
                        <h3 id="assessment-title">The colonization process trains participants and contains dangerous criminals.</h3>
                    </div>
                    <div>
                        <p>Humanity developed the Luminai inside an interactive colonization environment. Sylvan and his Luminai are tested against Samuel Franklin, a criminal already held inside the containment process.</p>
                        <p class="explorer-assessment__method"><span>The current story problem</span> Explain how Sylvan can expose Samuel while Samuel still believes he can regain control.</p>
                        <a class="explorer-progress__link" href="<?= e(explorer_file_url('05 Public/Published/2026-09-03 - Bridge World Atlas Update.md')) ?>"><span>See how the story changed</span><span aria-hidden="true">↗</span></a>
                    </div>
                </article>

                <?php if ($completion['available']): ?>
                    <div class="explorer-progress__summary">
                        <p class="explorer-progress__count"><strong><?= e((string) $completion['completed']) ?> / <?= e((string) $completion['total']) ?></strong><span>major story problems resolved</span></p>
                        <div class="explorer-progress__meter">
                            <div><span>Current development pass</span><strong><?= e((string) $completion['percent']) ?>%</strong></div>
                            <progress max="100" value="<?= e((string) $completion['percent']) ?>" aria-label="Current story checklist completion"><?= e((string) $completion['percent']) ?>%</progress>
                        </div>
                        <dl class="explorer-progress__current">
                            <div><dt>Current sweep</dt><dd><?= e($completion['current_sweep']) ?></dd></div>
                            <div><dt>Current task</dt><dd><?= e($completion['current_task']) ?></dd></div>
                        </dl>
                    </div>

                    <ol class="explorer-progress__sweeps" aria-label="Story completion sweep sequence">
                        <?php foreach ($completionSweeps as $index => $sweep): ?>
                            <li<?= $index === $completion['active_sweep'] ? ' class="is-current" aria-current="step"' : '' ?>>
                                <span><?= e(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)) ?></span>
                                <strong><?= e($sweep) ?></strong>
                            </li>
                        <?php endforeach; ?>
                    </ol>

                    <div class="explorer-progress__footer">
                        <div>
                            <p>What the story needs next</p>
                            <ul>
                                <?php foreach ($completion['working_fronts'] as $front): ?>
                                    <li><?= e($front) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <a class="explorer-progress__link" href="../../docs/todo.html"><span>Follow the full story roadmap</span><span aria-hidden="true">↗</span></a>
                    </div>
                <?php else: ?>
                    <div class="explorer-progress__unavailable">
                        <p>Live story progress is temporarily unavailable.</p>
                        <a class="explorer-progress__link" href="../../docs/todo.html">Open the full story roadmap <span aria-hidden="true">↗</span></a>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <section class="explorer-archive" id="archive" aria-labelledby="archive-title"<?= $view === 'files' ? ' data-active-destination="true"' : '' ?>>
            <header class="archive-intro wrap">
                <p class="archive-intro__index">Story files</p>
                <div>
                    <h2 id="archive-title">Browse the files used to develop the story.</h2>
                    <p>Search <?= e((string) count($files)) ?> documents about the world, characters, plot, research, decisions, workshops, and earlier ideas.</p>
                </div>
            </header>

            <div class="explorer-shell wrap" data-archive-shell>
            <div class="explorer-document-column">
            <div class="explorer-browse-bar">
                <button
                    class="explorer-browse-toggle"
                    type="button"
                    data-archive-open
                    aria-expanded="false"
                    aria-controls="archive-browser">
                    Browse files
                </button>
                <p class="explorer-browse-bar__current">
                    <span>Current document</span>
                    <strong><?= e($requested !== '' ? $requested : 'No document selected') ?></strong>
                </p>
            </div>

            <article class="explorer-document" id="archive-document" aria-label="<?= e($requested !== '' ? $requested : 'Repository document') ?>">
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
                                <li><a href="<?= e(explorer_file_url('README.md')) ?>">Repository</a></li>
                                <?php $segments = explode('/', $requested); ?>
                                <?php foreach ($segments as $segment): ?>
                                    <li><span><?= e($segment) ?></span></li>
                                <?php endforeach; ?>
                            </ol>
                        </nav>
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
            <?php if ($requested !== '' && $rendered !== ''): ?>
                <aside class="explorer-context" aria-label="Document details">
                    <p class="explorer-context__label">Document details</p>
                    <p class="explorer-context__path"><?= e($requested) ?></p>
                    <dl>
                        <div><dt>Size</dt><dd><?= e(explorer_format_bytes($bytes)) ?></dd></div>
                        <?php if ($modified !== null): ?>
                            <div><dt>Updated</dt><dd><time datetime="<?= e(date(DATE_ATOM, $modified)) ?>"><?= e(date('M j, Y', $modified)) ?></time></dd></div>
                        <?php endif; ?>
                    </dl>
                    <a href="<?= e($links['github']) ?>/seeds-of-the-throne/blob/main/<?= e(str_replace('%2F', '/', rawurlencode($requested))) ?>" rel="noopener noreferrer">View source on GitHub</a>
                </aside>
            <?php endif; ?>
            </div>

            <aside class="explorer-sidebar" id="archive-browser" data-archive-panel aria-label="Repository navigation">
                <div class="explorer-sidebar__toolbar">
                    <button class="explorer-browse-close" type="button" data-archive-close>Close file browser</button>
                    <a class="explorer-sidebar__return" href="#archive-document" data-archive-close>View the current document</a>
                </div>
                <form class="explorer-search" method="get" action="#archive">
                    <input type="hidden" name="view" value="files">
                    <input type="hidden" name="file" value="<?= e($requested) ?>">
                    <label for="repository-search">Find a document</label>
                    <div>
                        <input
                            id="repository-search"
                            name="q"
                            type="search"
                            value="<?= e($query) ?>"
                            placeholder="Search names, ideas, or systems...">
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
                            <p>No document titles or contents contain “<?= e($query) ?>”. Try a character, place, system, or report name.</p>
                        <?php else: ?>
                            <ul>
                                <?php foreach ($matches as $match): ?>
                                    <li>
                                        <a href="<?= e(explorer_file_url($match['path'])) ?>">
                                            <span><?= e($match['path']) ?></span>
                                            <?php if ($match['context'] !== ''): ?>
                                                <small><?= e($match['context']) ?></small>
                                            <?php endif; ?>
                                        </a>
                                    </li>
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
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="wrap site-footer__inner">
            <p>&copy; <?= e((string) $year) ?> Iain Reid</p>
            <div class="site-footer__links">
                <a href="../">Portfolio</a>
                <a href="<?= e($links['github']) ?>/seeds-of-the-throne" rel="noopener noreferrer">Repository</a>
            </div>
        </div>
    </footer>

    <script src="../assets/js/site.js?v=<?= e($assetVersion) ?>" defer></script>
    <script src="assets/project-explorer.js?v=<?= e($assetVersion) ?>" defer></script>
</body>
</html>
