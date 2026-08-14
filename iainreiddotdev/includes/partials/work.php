<?php

declare(strict_types=1);

/**
 * Showcase and selected work.
 *
 * Entries appear in the order declared in the portfolio data. They are
 * not grouped into sub-headings here: each entry names its own category in the
 * rail, which keeps one flat, scannable list instead of three short ones.
 *
 * Expects: $projects, $categories, $identity.
 */

/** category id => display name, so the rail can name it without a second lookup. */
$categoryNames = [];
foreach ($categories as $category) {
    $categoryNames[$category['id']] = $category['name'];
}
?>
<section class="section" id="work" aria-labelledby="work-title">
    <div class="wrap ledger">
        <div class="ledger__rail">
            <p class="kicker">
                <span class="kicker__num">01</span>
                <span>Showcase</span>
            </p>
        </div>

        <div class="ledger__body">
            <div class="section__head">
                <h2 class="section__title" id="work-title">Seeds of the Throne and selected work</h2>
                <p class="section__line"><?= e($identity['margin']) ?></p>
            </div>

            <div class="entries">
                <?php foreach ($projects as $project): ?>
                    <?php
                    $categoryName = $categoryNames[$project['category']] ?? '';
                    require __DIR__ . '/project-entry.php';
                    ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
