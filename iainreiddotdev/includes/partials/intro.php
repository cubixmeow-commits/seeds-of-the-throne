<?php

declare(strict_types=1);

/**
 * The introduction. It starts immediately: role, name, what he builds, and
 * how to reach him, all above the fold on a laptop.
 *
 * Beside it sits the concerns card — the three real categories from the
 * portfolio data. It is a definition list rather than a set of headings, so
 * the page keeps one clean h1 → h2 outline, and it is what stops the
 * introduction from being a large empty rectangle.
 *
 * Expects: $identity, $links, $categories.
 */
?>
<section class="intro wrap" id="top" aria-labelledby="intro-name">
    <div class="intro__grid">
        <div>
            <p class="kicker"><?= e($identity['role']) ?></p>
            <h1 class="intro__name" id="intro-name"><?= e($identity['name']) ?></h1>
            <p class="intro__statement"><?= e($identity['statement']) ?></p>
            <p class="intro__note"><?= e($identity['note']) ?></p>

            <div class="intro__actions">
                <a class="btn btn--primary" href="#work">See the work</a>
                <a class="btn" href="<?= e($links['mailto']) ?>">Email <?= e($identity['name']) ?></a>
            </div>
        </div>

        <div class="concerns">
            <p class="concerns__title" id="concerns-title">What I work on</p>
            <dl class="concerns__list" aria-labelledby="concerns-title">
                <?php foreach ($categories as $category): ?>
                    <div>
                        <dt><?= e($category['name']) ?></dt>
                        <dd><?= e($category['line']) ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
        </div>
    </div>
</section>
