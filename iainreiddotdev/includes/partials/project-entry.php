<?php

declare(strict_types=1);

/**
 * One project entry.
 *
 * The order is deliberate and it is the same for every project: what it is,
 * why it matters, how it works, what it is made of, and where to go next.
 * There are no decorative badges — the mark, the category and the status are
 * the only labels, and each of them carries a fact.
 *
 * Block labels ("Understanding flow", "Margin notes") are paragraphs rather
 * than headings, and the list they introduce points back at them with
 * aria-labelledby. That keeps the announced structure intact without adding
 * heading levels that would visually undercut the project title above them.
 *
 * Expects: $project, $categoryName.
 */

$id = $project['id'];
$name = portfolio_short_name($project);

/** Live work gets the filled marker; a finished field record does not. */
$isActive = stripos($project['status'], 'active') !== false
    || stripos($project['status'], 'working') !== false;

/** A field record is something an instrument produced, so it sits back a step
    rather than competing with the projects that produced it. */
$isSecondary = $project['status'] === 'Field record';
$isFeatured = !empty($project['featured']);
?>
<article
    class="entry<?= $isSecondary ? ' entry--secondary' : '' ?><?= $isFeatured ? ' entry--featured' : '' ?>"
    id="project-<?= e($id) ?>"
    aria-labelledby="project-<?= e($id) ?>-title">

    <div class="entry__rail">
        <p class="entry__mark"><?= e($project['mark']) ?></p>
        <p class="entry__category"><?= e($categoryName) ?></p>
        <p class="status"<?= $isActive ? ' data-state="active"' : '' ?>><?= e($project['status']) ?></p>
    </div>

    <div class="entry__body">
        <h3 class="entry__title" id="project-<?= e($id) ?>-title"><?= e($project['name']) ?></h3>
        <p class="entry__tagline"><?= e($project['tagline']) ?></p>

        <p class="entry__summary"><?= e($project['summary']) ?></p>

        <?php foreach ($project['detail'] ?? [] as $paragraph): ?>
            <p class="entry__detail"><?= e($paragraph) ?></p>
        <?php endforeach; ?>

        <?php if (!empty($project['problem'])): ?>
            <div class="entry__block">
                <dl class="why">
                    <?php foreach ($project['problem'] as $term => $definition): ?>
                        <div>
                            <dt><?= e((string) $term) ?></dt>
                            <dd><?= e($definition) ?></dd>
                        </div>
                    <?php endforeach; ?>
                </dl>
            </div>
        <?php endif; ?>

        <?php if (!empty($project['sequence'])): ?>
            <div class="entry__block">
                <p class="entry__block-title" id="flow-<?= e($id) ?>">
                    <?= e($project['sequence_label'] ?? 'How it works') ?>
                </p>
                <ol class="flow" aria-labelledby="flow-<?= e($id) ?>">
                    <?php foreach ($project['sequence'] as $index => $step): ?>
                        <li>
                            <span class="flow__step" aria-hidden="true"><?= e(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)) ?></span>
                            <span class="flow__label"><?= e($step['label']) ?></span>
                            <span class="flow__hint"><?= e($step['hint']) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        <?php endif; ?>

        <?php if (!empty($project['highlights'])): ?>
            <div class="entry__block">
                <p class="entry__block-title" id="points-<?= e($id) ?>">Key properties</p>
                <ul class="points" aria-labelledby="points-<?= e($id) ?>">
                    <?php foreach ($project['highlights'] as $item): ?>
                        <li><?= e($item) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($project['stack'])): ?>
            <div class="entry__block">
                <p class="entry__block-title" id="stack-<?= e($id) ?>">
                    <?= e($project['stack_label'] ?? 'What it is made of') ?>
                </p>
                <ul class="tags" aria-labelledby="stack-<?= e($id) ?>">
                    <?php foreach ($project['stack'] as $item): ?>
                        <li><?= e($item) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($project['studies'])): ?>
            <div class="entry__block">
                <p class="entry__block-title" id="studies-<?= e($id) ?>">Applied to</p>
                <div aria-labelledby="studies-<?= e($id) ?>">
                    <?php foreach ($project['studies'] as $study): ?>
                        <?php $referenced = portfolio_project($study['project']); ?>
                        <div class="study">
                            <div class="study__head">
                                <p class="study__specimen"><?= e($study['specimen']) ?></p>
                                <h4 class="study__name">
                                    <?= e($referenced !== null ? portfolio_short_name($referenced) : $study['project']) ?>
                                </h4>
                            </div>
                            <p class="study__context"><?= e($study['context']) ?></p>
                            <ul class="points">
                                <?php foreach ($study['findings'] as $finding): ?>
                                    <li><?= e($finding) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Every link carries the project name in its accessible name, so a
             screen reader's link list never shows four bare "Repository"
             entries with no way to tell them apart. -->
        <p class="entry__links">
            <?php foreach ($project['links'] as $link): ?>
                <a
                    class="action"
                    href="<?= e($link['href']) ?>"
                    <?= empty($link['internal']) ? 'rel="noopener noreferrer"' : '' ?>>
                    <span class="action__label"><?= e($link['label']) ?></span>
                    <span class="sr-only"> — <?= e($name) ?></span>
                    <span class="action__arrow" aria-hidden="true">&rarr;</span>
                </a>
            <?php endforeach; ?>

            <?php foreach ($project['related'] ?? [] as $relatedId): ?>
                <?php $related = portfolio_project($relatedId); ?>
                <?php if ($related !== null): ?>
                    <a class="action" href="#project-<?= e($related['id']) ?>">
                        <span class="action__label">Read about <?= e(portfolio_short_name($related)) ?></span>
                        <span class="action__arrow" aria-hidden="true">&rarr;</span>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </p>
    </div>
</article>
