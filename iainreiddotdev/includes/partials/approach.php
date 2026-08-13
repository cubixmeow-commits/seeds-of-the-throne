<?php

declare(strict_types=1);

/**
 * How the work gets built — the short working philosophy.
 *
 * Four principles, each with the three projects underneath it as evidence.
 * The ties are what make this section worth having: without them it would be
 * four opinions, and with them it is four claims each project has to answer.
 *
 * Expects: $method.
 */
?>
<section class="section" id="approach" aria-labelledby="approach-title">
    <div class="wrap ledger">
        <div class="ledger__rail">
            <p class="kicker">
                <span class="kicker__num">02</span>
                <span>Approach</span>
            </p>
        </div>

        <div class="ledger__body">
            <div class="section__head">
                <h2 class="section__title" id="approach-title">How the work gets built</h2>
                <p class="section__line">Four principles, and what each one looks like in the three systems above.</p>
            </div>

            <div class="principles">
                <?php foreach ($method as $entry): ?>
                    <article class="principle">
                        <p class="principle__num"><?= e($entry['mark']) ?></p>
                        <h3 class="principle__title"><?= e($entry['title']) ?></h3>
                        <p class="principle__body"><?= e($entry['body']) ?></p>
                        <dl class="ties">
                            <?php foreach ($entry['ties'] as $name => $tie): ?>
                                <div>
                                    <dt><?= e((string) $name) ?></dt>
                                    <dd><?= e($tie) ?></dd>
                                </div>
                            <?php endforeach; ?>
                        </dl>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
