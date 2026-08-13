<?php

declare(strict_types=1);

/**
 * A short note about the maker.
 *
 * The portrait is the only raster asset on the page. It is lazy-loaded, has
 * explicit dimensions so nothing shifts while it arrives, and carries a
 * neutral ring rather than a tinted border.
 *
 * Expects: $identity.
 */

$portrait = $identity['portrait'];
?>
<section class="section" id="about" aria-labelledby="about-title">
    <div class="wrap ledger">
        <div class="ledger__rail">
            <p class="kicker">
                <span class="kicker__num">04</span>
                <span>About</span>
            </p>
        </div>

        <div class="ledger__body">
            <div class="about__grid">
                <img
                    class="about__portrait"
                    src="<?= e($portrait['src']) ?>"
                    alt="<?= e($portrait['alt']) ?>"
                    width="<?= e((string) $portrait['width']) ?>"
                    height="<?= e((string) $portrait['height']) ?>"
                    loading="lazy"
                    decoding="async">

                <div class="about__body">
                    <h2 class="section__title" id="about-title"><?= e($identity['about']['title']) ?></h2>
                    <?php foreach ($identity['about']['body'] as $paragraph): ?>
                        <p><?= e($paragraph) ?></p>
                    <?php endforeach; ?>
                    <p class="about__signature"><?= e($identity['name']) ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
