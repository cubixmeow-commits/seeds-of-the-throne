<?php

declare(strict_types=1);

/**
 * Read-only repository exploration helpers.
 *
 * The public explorer exposes only Markdown files discovered beneath the
 * deployed repository root. Hidden directories, symlinks, and every other
 * file type are excluded before a request path is considered.
 */

/** @return list<string> */
function explorer_markdown_files(string $root): array
{
    $root = rtrim((string) realpath($root), DIRECTORY_SEPARATOR);
    $directory = new RecursiveDirectoryIterator(
        $root,
        FilesystemIterator::SKIP_DOTS | FilesystemIterator::CURRENT_AS_FILEINFO
    );

    $filter = new RecursiveCallbackFilterIterator(
        $directory,
        static function (SplFileInfo $entry): bool {
            if ($entry->isLink()) {
                return false;
            }

            if ($entry->isDir()) {
                return !str_starts_with($entry->getFilename(), '.');
            }

            return strtolower($entry->getExtension()) === 'md';
        }
    );

    $files = [];
    $iterator = new RecursiveIteratorIterator($filter, RecursiveIteratorIterator::LEAVES_ONLY);
    foreach ($iterator as $entry) {
        if (!$entry instanceof SplFileInfo || !$entry->isFile()) {
            continue;
        }

        $real = $entry->getRealPath();
        if ($real === false || !str_starts_with($real, $root . DIRECTORY_SEPARATOR)) {
            continue;
        }

        $files[] = str_replace(DIRECTORY_SEPARATOR, '/', substr($real, strlen($root) + 1));
    }

    natcasesort($files);
    return array_values($files);
}
/**
 * @param list<string> $paths
 * @return array{directories: array<string, mixed>, files: list<array{name: string, path: string}>, count: int}
 */
function explorer_build_tree(array $paths): array
{
    $tree = ['directories' => [], 'files' => [], 'count' => 0];

    foreach ($paths as $path) {
        $parts = explode('/', $path);
        $filename = array_pop($parts);
        $node =& $tree;
        $node['count']++;

        foreach ($parts as $directory) {
            if (!isset($node['directories'][$directory])) {
                $node['directories'][$directory] = [
                    'directories' => [],
                    'files' => [],
                    'count' => 0,
                ];
            }
            $node =& $node['directories'][$directory];
            $node['count']++;
        }

        $node['files'][] = ['name' => (string) $filename, 'path' => $path];
        unset($node);
    }

    return $tree;
}

function explorer_file_url(string $path, string $fragment = 'archive'): string
{
    $url = '?' . http_build_query(['file' => $path], '', '&', PHP_QUERY_RFC3986);

    if ($fragment !== '') {
        $url .= '#' . rawurlencode($fragment);
    }

    return $url;
}

/**
 * Render the nested repository tree using native disclosure controls.
 *
 * @param array{directories: array<string, mixed>, files: list<array{name: string, path: string}>, count: int} $node
 */
function explorer_render_tree(array $node, string $current, string $prefix = ''): void
{
    $directories = $node['directories'];
    uksort($directories, 'strnatcasecmp');
    $files = $node['files'];
    usort($files, static fn (array $a, array $b): int => strnatcasecmp($a['name'], $b['name']));

    echo '<ul class="explorer-tree">';

    foreach ($directories as $name => $directory) {
        $path = $prefix === '' ? (string) $name : $prefix . '/' . $name;
        $open = str_starts_with($current, $path . '/');
        echo '<li class="explorer-tree__directory">';
        echo '<details' . ($open ? ' open' : '') . '>';
        echo '<summary><span>' . e((string) $name) . '</span>';
        echo '<span class="explorer-tree__count">' . e((string) $directory['count']) . '</span></summary>';
        explorer_render_tree($directory, $current, $path);
        echo '</details></li>';
    }

    foreach ($files as $file) {
        $isCurrent = $file['path'] === $current;
        echo '<li class="explorer-tree__file"><a href="' . e(explorer_file_url($file['path'])) . '"';
        echo $isCurrent ? ' aria-current="page"' : '';
        echo '><span aria-hidden="true">MD</span>' . e($file['name']) . '</a></li>';
    }

    echo '</ul>';
}

/** @param list<string> $allPaths */
function explorer_find_markdown_target(string $target, string $current, array $allPaths): ?string
{
    $target = rawurldecode(trim(str_replace('\\', '/', $target)));
    if ($target === '') {
        return null;
    }

    $lookup = [];
    foreach ($allPaths as $path) {
        $lookup[strtolower($path)] = $path;
    }

    $base = dirname($current);
    $base = $base === '.' ? '' : $base;
    $candidate = explorer_normalize_relative_path(($base === '' ? '' : $base . '/') . $target);
    $rootCandidate = explorer_normalize_relative_path($target);

    foreach ([$candidate, $rootCandidate] as $path) {
        if ($path === null) {
            continue;
        }
        $variants = [$path];
        if (strtolower(pathinfo($path, PATHINFO_EXTENSION)) !== 'md') {
            $variants[] = $path . '.md';
        }
        foreach ($variants as $variant) {
            if (isset($lookup[strtolower($variant)])) {
                return $lookup[strtolower($variant)];
            }
        }
    }

    $wanted = strtolower(pathinfo($target, PATHINFO_FILENAME));
    $matches = array_values(array_filter(
        $allPaths,
        static fn (string $path): bool => strtolower(pathinfo($path, PATHINFO_FILENAME)) === $wanted
    ));

    return count($matches) === 1 ? $matches[0] : null;
}

function explorer_normalize_relative_path(string $path): ?string
{
    $parts = [];
    foreach (explode('/', $path) as $part) {
        if ($part === '' || $part === '.') {
            continue;
        }
        if ($part === '..') {
            if ($parts === []) {
                return null;
            }
            array_pop($parts);
            continue;
        }
        if (str_starts_with($part, '.') || str_contains($part, "\0")) {
            return null;
        }
        $parts[] = $part;
    }

    return $parts === [] ? null : implode('/', $parts);
}

function explorer_slug(string $text): string
{
    $slug = strtolower(trim(strip_tags($text)));
    $slug = preg_replace('/[^\p{L}\p{N}]+/u', '-', $slug) ?? '';
    return trim($slug, '-') ?: 'section';
}

/** @param list<string> $allPaths */
function explorer_inline_markdown(string $text, string $current, array $allPaths): string
{
    $tokens = [];
    $stash = static function (string $html) use (&$tokens): string {
        $key = "\x1A" . count($tokens) . "\x1A";
        $tokens[$key] = $html;
        return $key;
    };

    $text = preg_replace_callback('/`([^`]+)`/', static function (array $match) use ($stash): string {
        return $stash('<code>' . e($match[1]) . '</code>');
    }, $text) ?? $text;

    $text = preg_replace_callback('/!\[([^\]]*)\]\(([^)]+)\)/', static function (array $match) use ($stash): string {
        $label = trim($match[1]) !== '' ? $match[1] : 'Referenced image';
        return $stash('<span class="markdown-image-reference">Image reference: ' . e($label) . '</span>');
    }, $text) ?? $text;

    $text = preg_replace_callback('/\[([^\]]+)\]\(([^)\s]+)(?:\s+["\'][^"\']*["\'])?\)/',
        static function (array $match) use ($stash, $current, $allPaths): string {
            return $stash(explorer_link_html($match[1], $match[2], $current, $allPaths));
        },
        $text
    ) ?? $text;

    $text = preg_replace_callback('/\[\[([^\]]+)\]\]/', static function (array $match) use ($stash, $current, $allPaths): string {
        [$target, $label] = array_pad(explode('|', $match[1], 2), 2, '');
        $label = $label !== '' ? $label : preg_replace('/#.*$/', '', $target);
        return $stash(explorer_link_html((string) $label, $target, $current, $allPaths));
    }, $text) ?? $text;

    $text = e($text);
    $text = preg_replace('/\*\*([^*]+)\*\*/', '<strong>$1</strong>', $text) ?? $text;
    $text = preg_replace('/__([^_]+)__/', '<strong>$1</strong>', $text) ?? $text;
    $text = preg_replace('/~~([^~]+)~~/', '<del>$1</del>', $text) ?? $text;
    $text = preg_replace('/(?<!\*)\*([^*]+)\*(?!\*)/', '<em>$1</em>', $text) ?? $text;
    $text = preg_replace('/(?<!_)_([^_]+)_(?!_)/', '<em>$1</em>', $text) ?? $text;

    return strtr($text, $tokens);
}

/** @param list<string> $allPaths */
function explorer_link_html(string $label, string $target, string $current, array $allPaths): string
{
    $label = e($label);
    $target = trim($target, " <>\t\n\r\0\x0B");

    if (preg_match('#^(https?://|mailto:)#i', $target) === 1) {
        return '<a href="' . e($target) . '" rel="noopener noreferrer">' . $label . '</a>';
    }

    if (str_starts_with($target, '#')) {
        return '<a href="#' . e(explorer_slug(substr($target, 1))) . '">' . $label . '</a>';
    }

    [$fileTarget, $fragment] = array_pad(explode('#', $target, 2), 2, '');
    $resolved = explorer_find_markdown_target($fileTarget, $current, $allPaths);
    if ($resolved === null) {
        return '<span class="markdown-unresolved" title="Linked document is not uniquely resolvable">' . $label . '</span>';
    }

    $href = explorer_file_url(
        $resolved,
        $fragment !== '' ? explorer_slug($fragment) : 'archive'
    );
    return '<a href="' . e($href) . '">' . $label . '</a>';
}

function explorer_is_block_start(array $lines, int $index): bool
{
    $line = $lines[$index] ?? '';
    if (trim($line) === '') {
        return true;
    }
    if (preg_match('/^(#{1,6})\s+|^```|^~~~|^>\s?|^\s*[-*+]\s+|^\s*\d+[.)]\s+|^\s*(?:---+|___+|\*\*\*+)\s*$/', $line) === 1) {
        return true;
    }
    return isset($lines[$index + 1])
        && str_contains($line, '|')
        && preg_match('/^\s*\|?\s*:?-{3,}:?\s*(?:\|\s*:?-{3,}:?\s*)+\|?\s*$/', $lines[$index + 1]) === 1;
}

/** @param list<string> $allPaths */
function explorer_render_markdown(string $markdown, string $current, array $allPaths): string
{
    $markdown = str_replace(["\r\n", "\r"], "\n", $markdown);
    $lines = explode("\n", $markdown);
    $html = [];
    $index = 0;
    $count = count($lines);

    if (($lines[0] ?? '') === '---') {
        $end = 1;
        while ($end < $count && $lines[$end] !== '---') {
            $end++;
        }
        if ($end < $count) {
            $metadata = implode("\n", array_slice($lines, 1, $end - 1));
            $html[] = '<details class="markdown-metadata"><summary>Document metadata</summary><pre><code>'
                . e($metadata) . '</code></pre></details>';
            $index = $end + 1;
        }
    }

    while ($index < $count) {
        $line = $lines[$index];
        if (trim($line) === '') {
            $index++;
            continue;
        }

        if (preg_match('/^(```|~~~)([^\s]*)\s*$/', $line, $fence) === 1) {
            $marker = $fence[1];
            $language = preg_replace('/[^a-z0-9_-]/i', '', $fence[2]) ?? '';
            $code = [];
            $index++;
            while ($index < $count && !str_starts_with($lines[$index], $marker)) {
                $code[] = $lines[$index++];
            }
            if ($index < $count) {
                $index++;
            }
            $class = $language !== '' ? ' class="language-' . e($language) . '"' : '';
            $html[] = '<pre><code' . $class . '>' . e(implode("\n", $code)) . '</code></pre>';
            continue;
        }

        if (preg_match('/^(#{1,6})\s+(.+)$/', $line, $heading) === 1) {
            $level = min(6, strlen($heading[1]) + 1);
            $title = preg_replace('/\s+#+\s*$/', '', $heading[2]) ?? $heading[2];
            $html[] = '<h' . $level . ' id="' . e(explorer_slug($title)) . '">'
                . explorer_inline_markdown($title, $current, $allPaths) . '</h' . $level . '>';
            $index++;
            continue;
        }

        if (preg_match('/^\s*(?:---+|___+|\*\*\*+)\s*$/', $line) === 1) {
            $html[] = '<hr>';
            $index++;
            continue;
        }

        if (str_contains($line, '|') && isset($lines[$index + 1])
            && preg_match('/^\s*\|?\s*:?-{3,}:?\s*(?:\|\s*:?-{3,}:?\s*)+\|?\s*$/', $lines[$index + 1]) === 1) {
            $headers = array_map('trim', explode('|', trim($line, " |\t")));
            $index += 2;
            $rows = [];
            while ($index < $count && str_contains($lines[$index], '|') && trim($lines[$index]) !== '') {
                $rows[] = array_map('trim', explode('|', trim($lines[$index], " |\t")));
                $index++;
            }
            $table = '<div class="markdown-table-wrap"><table><thead><tr>';
            foreach ($headers as $cell) {
                $table .= '<th scope="col">' . explorer_inline_markdown($cell, $current, $allPaths) . '</th>';
            }
            $table .= '</tr></thead><tbody>';
            foreach ($rows as $row) {
                $table .= '<tr>';
                foreach ($headers as $cellIndex => $_header) {
                    $table .= '<td>' . explorer_inline_markdown($row[$cellIndex] ?? '', $current, $allPaths) . '</td>';
                }
                $table .= '</tr>';
            }
            $html[] = $table . '</tbody></table></div>';
            continue;
        }

        if (preg_match('/^>\s?(.*)$/', $line, $quote) === 1) {
            $parts = [];
            while ($index < $count && preg_match('/^>\s?(.*)$/', $lines[$index], $quote) === 1) {
                $parts[] = $quote[1];
                $index++;
            }
            $html[] = '<blockquote><p>' . explorer_inline_markdown(implode(' ', $parts), $current, $allPaths) . '</p></blockquote>';
            continue;
        }

        if (preg_match('/^\s*[-*+]\s+(.+)$/', $line, $item) === 1) {
            $list = '<ul>';
            while ($index < $count && preg_match('/^\s*[-*+]\s+(.+)$/', $lines[$index], $item) === 1) {
                $list .= '<li>' . explorer_inline_markdown($item[1], $current, $allPaths) . '</li>';
                $index++;
            }
            $html[] = $list . '</ul>';
            continue;
        }

        if (preg_match('/^\s*\d+[.)]\s+(.+)$/', $line, $item) === 1) {
            $list = '<ol>';
            while ($index < $count && preg_match('/^\s*\d+[.)]\s+(.+)$/', $lines[$index], $item) === 1) {
                $list .= '<li>' . explorer_inline_markdown($item[1], $current, $allPaths) . '</li>';
                $index++;
            }
            $html[] = $list . '</ol>';
            continue;
        }

        $paragraph = [];
        while ($index < $count && trim($lines[$index]) !== ''
            && ($paragraph === [] || !explorer_is_block_start($lines, $index))) {
            $paragraph[] = trim($lines[$index]);
            $index++;
        }
        if ($paragraph === []) {
            $paragraph[] = trim($lines[$index]);
            $index++;
        }
        $html[] = '<p>' . explorer_inline_markdown(implode(' ', $paragraph), $current, $allPaths) . '</p>';
    }

    return implode("\n", $html);
}
