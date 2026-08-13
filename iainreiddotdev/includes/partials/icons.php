<?php

declare(strict_types=1);

/**
 * Inline SVG icons.
 *
 * Three icons is the whole set. They are inlined rather than fetched so the
 * page still makes no image request, and every one of them draws with
 * `currentColor` at a 1.5 stroke, which is the weight that sits correctly
 * beside regular-weight UI text. State comes from CSS colour and opacity;
 * there is never a second asset for a second state.
 *
 * Each icon is decorative on its own — the control around it carries the
 * accessible name — so every <svg> is hidden from the accessibility tree.
 */

/**
 * Render one icon by name. Unknown names render nothing.
 */
function icon(string $name, string $class = ''): void
{
    $attrs = sprintf(
        'viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" '
        . 'stroke-linejoin="round" aria-hidden="true" focusable="false"%s',
        $class !== '' ? ' class="' . e($class) . '"' : ''
    );

    switch ($name) {
        case 'sun':
            echo '<svg ' . $attrs . '>'
                . '<circle cx="12" cy="12" r="4"/>'
                . '<path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41'
                . 'M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/>'
                . '</svg>';
            break;

        case 'moon':
            echo '<svg ' . $attrs . '>'
                . '<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79Z"/>'
                . '</svg>';
            break;

        case 'close':
            echo '<svg ' . $attrs . '>'
                . '<path d="M18 6 6 18M6 6l12 12"/>'
                . '</svg>';
            break;
    }
}
