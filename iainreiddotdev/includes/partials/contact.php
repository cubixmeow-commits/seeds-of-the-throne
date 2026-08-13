<?php

declare(strict_types=1);

/**
 * The close: one address, one copy control, two profiles.
 *
 * The email is a real mailto link first — the copy button is the convenience,
 * not the mechanism — and the status line is a stable, permanently rendered
 * live region so repeated copies are announced reliably.
 *
 * Expects: $identity, $links.
 */
?>
<section class="section" id="contact" aria-labelledby="contact-title">
    <div class="wrap ledger">
        <div class="ledger__rail">
            <p class="kicker">
                <span class="kicker__num">05</span>
                <span>Contact</span>
            </p>
        </div>

        <div class="ledger__body">
            <h2 class="contact__title" id="contact-title"><?= e($identity['contact']['title']) ?></h2>
            <p class="lead"><?= e($identity['contact']['lead']) ?></p>

            <a class="contact__email" href="<?= e($links['mailto']) ?>"><?= e($links['email']) ?></a>

            <div class="contact__actions">
                <button
                    class="btn"
                    type="button"
                    id="copy-email"
                    data-copy-email="<?= e($links['email']) ?>">Copy email address</button>
                <a class="btn" href="<?= e($links['github']) ?>" rel="noopener noreferrer">GitHub profile</a>
                <a class="btn" href="<?= e($links['x']) ?>" rel="noopener noreferrer"><?= e($links['x_handle']) ?> on X</a>
            </div>

            <p class="contact__status" id="copy-status" role="status"></p>
        </div>
    </div>
</section>
