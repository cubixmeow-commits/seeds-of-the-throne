<?php

declare(strict_types=1);

/**
 * Per-experiment bootstrap — template for a MULTI-PAGE experiment.
 *
 * A single-page experiment gates itself with one require_experiment_access()
 * call (see x/hello.php). A multi-page experiment must not depend on every file
 * remembering to gate itself. Instead:
 *
 *   1. Copy this file to  x/<slug>/_experiment.php
 *   2. Replace 'your-slug' below with the experiment's real slug.
 *   3. Make the FIRST line of every page in x/<slug>/ :
 *
 *          <?php require __DIR__ . '/_experiment.php';
 *
 *      before any HTML, whitespace, or BOM.
 *
 * Gating the whole sub-app then becomes structural rather than per-file
 * discipline. Every route inside a gated experiment must enforce access,
 * directly or through this shared bootstrap — never gate only the homepage and
 * leave internal routes open.
 *
 * This example file is not itself a gated route; it is a template.
 */

require __DIR__ . '/../includes/bootstrap.php';

// Available to every page that includes this file.
$experiment = require_experiment_access('your-slug');
