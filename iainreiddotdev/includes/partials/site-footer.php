<?php

declare(strict_types=1);

/**
 * The footer. Also the only door to the Showdown gate, which is deliberately
 * unlabelled beyond its name, and to the retro page at retro/.
 *
 * Expects: $links, $year.
 */
?>
<footer class="site-footer">
    <div class="wrap site-footer__inner">
        <p>&copy; <?= e((string) $year) ?> Iain Reid</p>

        <div class="site-footer__links">
            <a href="<?= e($links['github']) ?>" rel="noopener noreferrer">GitHub</a>
            <a href="<?= e($links['x']) ?>" rel="noopener noreferrer"><?= e($links['x_handle']) ?></a>
            <a href="<?= e($links['mailto']) ?>">Email</a>
            <a href="retro/">Retro</a>
            <button type="button" data-showdown-open>Showdown</button>
        </div>
    </div>
</footer>
