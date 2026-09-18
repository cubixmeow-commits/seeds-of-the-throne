<?php

declare(strict_types=1);

/**
 * The compact sticky header: a maker's mark, four section links, and the
 * appearance toggle. Six items was the old header's count; four is enough,
 * because everything else on this page is reachable by scrolling.
 *
 * The nav links are real anchors, so Cmd-click and middle-click behave. The
 * toggle is a real button with an accessible name that names the action.
 *
 * On non-home pages (for example privacy.php), section links must target the
 * portfolio homepage rather than a missing in-page fragment.
 *
 * Expects: $identity.
 * Optional: $homeHref — absolute or relative homepage URL. Defaults to './'.
 */

$homeHref = $homeHref ?? './';
$sectionHref = static function (string $fragment) use ($homeHref): string {
    $script = basename((string) ($_SERVER['SCRIPT_NAME'] ?? ''));
    if ($script === 'index.php' || $script === '') {
        return '#' . $fragment;
    }
    return rtrim($homeHref, '/') . '/#' . $fragment;
};
?>
<header class="site-header" id="site-header">
    <div class="wrap site-header__inner">
        <a class="brand" href="<?= e($sectionHref('top')) ?>">
            <span class="brand__mark" aria-hidden="true"><?= e($identity['initials']) ?></span>
            <span class="brand__name"><?= e($identity['name']) ?></span>
        </a>

        <div class="site-nav">
            <nav aria-label="Sections">
                <ul class="site-nav__list">
                    <li><a href="<?= e($sectionHref('work')) ?>">Showcase</a></li>
                    <li><a href="<?= e($sectionHref('approach')) ?>">Approach</a></li>
                    <li><a href="<?= e($sectionHref('about')) ?>">About</a></li>
                    <li><a href="<?= e($sectionHref('contact')) ?>">Contact</a></li>
                </ul>
            </nav>

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
