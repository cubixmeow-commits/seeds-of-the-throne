<?php

declare(strict_types=1);

/**
 * Demo experiment — the acceptance-test surface for the visibility gate.
 *
 * This page is content-free and is not a product. It exists only to prove the
 * gate works end to end. The gate MUST be the first action after the bootstrap,
 * before any output (no HTML, whitespace, or BOM above this).
 */

require __DIR__ . '/../includes/bootstrap.php';

// First action, before any output. Returns the record on success; renders a
// real 404 and terminates on any denial or a missing slug.
$experiment = require_experiment_access('hello');

require __DIR__ . '/../includes/layout.php';

render_page_top('Experiment');
?>
<section class="auth-card auth-card--narrow" aria-labelledby="demo-title">
    <p class="mono">Experiment · Access granted</p>
    <h1 id="demo-title"><?= e($experiment['name']) ?></h1>
    <p class="auth-lede">
        Experiment <strong><?= e($experiment['slug']) ?></strong> —
        visibility <strong><?= e($experiment['visibility']) ?></strong>.
    </p>
</section>
<?php
render_page_bottom();
