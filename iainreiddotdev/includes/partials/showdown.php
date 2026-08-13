<?php

declare(strict_types=1);

/**
 * The Showdown gate.
 *
 * Carried forward unchanged in behaviour: the riddle wording, the field, and
 * the single response message are exactly what showdown-gate.php expects and
 * what the previous page asked. Only the markup and styling are new.
 *
 * It is a custom overlay rather than <dialog> because it has to keep working
 * on the same browsers the rest of this no-build site targets; the script
 * supplies the trap, the inert background, and focus restoration that
 * showModal() would otherwise give for free.
 */
?>
<div class="showdown" id="showdown-modal" hidden>
    <!-- Pointer-only convenience. It is not focusable, so hiding it from the
         accessibility tree costs nothing: Escape and the close button are the
         keyboard and screen-reader paths out. -->
    <div class="showdown__scrim" data-showdown-close aria-hidden="true"></div>

    <div
        class="showdown__panel"
        role="dialog"
        aria-modal="true"
        aria-labelledby="showdown-title"
        aria-describedby="showdown-riddle">

        <button class="showdown__close" type="button" data-showdown-close aria-label="Close the riddle">
            <?php icon('close'); ?>
        </button>

        <p class="kicker">Showdown</p>
        <h2 class="showdown__title" id="showdown-title">A riddle from the workshop</h2>
        <p class="showdown__riddle" id="showdown-riddle">one wrong move, and the entire process focuses on this:</p>

        <form class="showdown__form" id="showdown-form" novalidate>
            <label class="showdown__label" for="showdown-answer">Your answer</label>
            <input
                class="showdown__input"
                id="showdown-answer"
                name="answer"
                type="text"
                autocomplete="off"
                spellcheck="false"
                maxlength="64"
                required>
            <button class="btn btn--primary showdown__submit" type="submit">Unseal the gate</button>
            <p class="showdown__feedback" id="showdown-feedback" role="status"></p>
        </form>
    </div>
</div>
