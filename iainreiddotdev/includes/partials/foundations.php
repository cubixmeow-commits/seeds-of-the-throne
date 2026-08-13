<?php

declare(strict_types=1);

/**
 * Foundations — what the visible work is built on.
 *
 * Plain grouped lists. No proficiency bars, no logo grid: a bar chart claiming
 * "PHP 87%" tells a reader nothing they can check, and the four group names
 * already say what each skill is for.
 *
 * Expects: $foundations.
 */
?>
<section class="section" id="foundations" aria-labelledby="foundations-title">
    <div class="wrap ledger">
        <div class="ledger__rail">
            <p class="kicker">
                <span class="kicker__num">03</span>
                <span>Foundations</span>
            </p>
        </div>

        <div class="ledger__body">
            <div class="section__head">
                <h2 class="section__title" id="foundations-title">Foundations</h2>
                <p class="section__line">Grouped by what it produces rather than by logo.</p>
            </div>

            <div class="foundations">
                <?php foreach ($foundations as $group): ?>
                    <div>
                        <h3 class="foundation__title" id="found-<?= e($group['id']) ?>"><?= e($group['title']) ?></h3>
                        <ul class="foundation__list" aria-labelledby="found-<?= e($group['id']) ?>">
                            <?php foreach ($group['items'] as $item): ?>
                                <li><?= e($item) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
