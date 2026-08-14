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
 * Expects: $identity.
 */
?>
<header class="site-header" id="site-header">
    <div class="wrap site-header__inner">
        <a class="brand" href="#top">
            <span class="brand__mark" aria-hidden="true"><?= e($identity['initials']) ?></span>
            <span class="brand__name"><?= e($identity['name']) ?></span>
        </a>

        <div class="site-nav">
            <nav aria-label="Sections">
                <ul class="site-nav__list">
                    <li><a href="#work">Showcase</a></li>
                    <li><a href="#approach">Approach</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
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
