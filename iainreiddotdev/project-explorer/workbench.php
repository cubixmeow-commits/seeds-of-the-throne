<?php
// Included by the existing read-only Explorer. All content originates in reviewed vault Markdown.
$atlasPath = $repositoryRoot . '/docs/assets/story-atlas.json';
$workshopPath = $repositoryRoot . '/docs/assets/story-workshop.json';
$endgameWorkshopPath = $repositoryRoot . '/docs/assets/story-endgame-workshop.json';
$atlasData = is_file($atlasPath) ? json_decode((string) file_get_contents($atlasPath), true) : [];
$workshopData = is_file($workshopPath) ? json_decode((string) file_get_contents($workshopPath), true) : [];
$endgameWorkshopData = is_file($endgameWorkshopPath) ? json_decode((string) file_get_contents($endgameWorkshopPath), true) : [];
$atlasData = is_array($atlasData) ? $atlasData : [];
$bookOneModules = is_array($workshopData) && isset($workshopData['modules']) && is_array($workshopData['modules']) ? $workshopData['modules'] : [];
$endgameModules = is_array($endgameWorkshopData) && isset($endgameWorkshopData['modules']) && is_array($endgameWorkshopData['modules']) ? $endgameWorkshopData['modules'] : [];
$requestedWorkshop = isset($_GET['workshop']) && is_string($_GET['workshop']) ? $_GET['workshop'] : '';
$requestedModule = isset($_GET['module']) && is_string($_GET['module']) ? $_GET['module'] : '';
$selectedWorkshop = $requestedWorkshop === 'book-one' || ($requestedWorkshop === '' && str_starts_with($requestedModule, 'BA-'))
    ? 'book-one'
    : 'endgame';
$modules = $selectedWorkshop === 'book-one' ? $bookOneModules : $endgameModules;

$workbenchViews = [
    'overview' => [
        'id' => 'overview-view',
        'title' => 'See how the authoring system turns ordinary language into finished story work.',
        'lede' => 'The Project Explorer shows the live notes, decisions, and workshop used to develop Seeds of the Throne. Each step keeps confirmed decisions separate from suggestions and unanswered questions.',
    ],
    'sources' => [
        'id' => 'story-view',
        'title' => 'Open the public story pages and the reviewed Markdown behind them.',
        'lede' => 'The story site and Project Explorer are built from the same reviewed Markdown. Open any topic to see the public story, the source behind it, and whether the idea is settled or still being developed.',
    ],
    'evidence' => [
        'id' => 'decisions-view',
        'title' => 'Trace assessments, research boundaries, contradictions, and accepted decisions.',
        'lede' => 'These documents show what the analysis found, where ideas conflict, what science can support, and which choices now control the story.',
    ],
    'workshop' => [
        'id' => 'workshop-view',
        'title' => 'Develop the endgame without losing the evidence trail.',
        'lede' => 'The focused Endgame Workshop organizes the newest decisions about the hidden hierarchy, bloodline operation, Resistance evidence, Konrad\'s commitment, Samuel\'s final counterplan, and the outcome presentation. Book One Architecture remains available as a separate track.',
    ],
];

$activeWorkbench = isset($workbenchViews[$view]) ? $view : 'overview';
$activeMeta = $workbenchViews[$activeWorkbench];
?>
<section class="development-workspace wrap" id="<?= e($activeMeta['id']) ?>" aria-labelledby="workbench-title" data-explorer-view="<?= e($activeWorkbench) ?>">
  <header class="workspace-intro">
    <?php if ($activeWorkbench === 'overview'): ?>
    <p>Story development tools</p>
    <h2 id="workbench-title"><?= e($activeMeta['title']) ?></h2>
    <p><?= e($activeMeta['lede']) ?></p>
    <?php else: ?>
    <p>Story development tools · <?= e(['sources' => 'Story', 'evidence' => 'Decisions', 'workshop' => 'Workshop'][$activeWorkbench] ?? $activeWorkbench) ?></p>
    <h2 id="workbench-title"><?= e($activeMeta['title']) ?></h2>
    <p><?= e($activeMeta['lede']) ?></p>
    <?php endif; ?>
  </header>
  <p class="workspace-notice">This is a public, read-only look at the real project, so it contains full spoilers. You can try the workshop, but your draft stays in this browser unless you export it.</p>
  <?php if ($activeWorkbench === 'overview'): ?>
    <ol class="workspace-sequence">
      <li><h3>The author explains the story in ordinary language.</h3><p>The system records those ideas and separates confirmed decisions from suggestions and unanswered questions.</p><a href="<?= e(explorer_file_url('01 Sessions/Daily/2026-09-07 - Conversational Authorship Product Direction.md')) ?>">Read how the system is designed</a></li>
      <li><h3>The new Endgame Workshop develops the final confrontation from the evidence outward.</h3><p>Eight focused modules separate locked decisions from the mechanisms, character choices, disclosure order, and final presentation that still need work.</p><a href="<?= e(explorer_view_url('workshop', ['workshop' => 'endgame', 'module' => 'EG-01'], 'session')) ?>">Start the Endgame Workshop</a></li>
      <li><h3>Accepted answers are added where they belong.</h3><p>An accepted decision can update character notes, the timeline, world rules, plot events, and the list of remaining questions.</p><a href="<?= e(explorer_view_url('evidence')) ?>">Review decisions and supporting information</a></li>
      <li><h3>Use the completed plan to write and revise scenes.</h3><p>The planned system will create scene outlines, draft prose, check continuity, revise weak sections, and assemble the manuscript for the author's approval.</p><a href="<?= e(explorer_file_url('07 Coordination/Authoring System/03 - Workshop and Composition Engines.md')) ?>">Read the system plan</a></li>
    </ol>
    <p class="workspace-example">Seeds of the Throne is the working example. The notes, decisions, and workshop below are the live project, not a demonstration mockup.</p>
    <div class="workspace-actions"><a href="<?= e(explorer_file_url('07 QA/2026-09-19 - Endgame Workshop Assessment.md')) ?>">See the latest assessment</a><a href="<?= e(explorer_file_url('07 Coordination/CURRENT-PICKUP.md')) ?>">See where development continues</a><a href="../../docs/index.html">Enter the story</a></div>
  <?php elseif ($activeWorkbench === 'sources'): ?>
    <div class="workspace-grid">
    <?php foreach ($atlasData as $entry): ?>
      <article><span><?= e($entry['route']) ?></span><h3><?= e($entry['title']) ?></h3><p><?= e($entry['deck']) ?></p><a href="<?= e(explorer_file_url($entry['source'])) ?>">See the source</a> · <a href="../../docs/<?= e($entry['route']) ?>.html">Read the story page</a></article>
    <?php endforeach; ?>
    </div>
  <?php elseif ($activeWorkbench === 'evidence'): ?>
    <div class="workspace-grid">
    <?php foreach ([
      '07 QA/2026-09-05 - Comprehensive Story Assessment.md' => ['What the story needs', 'The strongest ideas, the missing causes, and the decisions with the largest consequences.'],
      '07 QA/2026-09-17 - Resistance and Revelation Reassessment.md' => ['How the newest material changes Book One', 'The Resistance evidence chain, Converging Revelation method, continuity conflicts, and the workshop modules they affect.'],
      '07 QA/2026-09-19 - Endgame Workshop Assessment.md' => ['How the endgame now fits together', 'The locked collaboration, hidden hierarchy, bloodline operation, evidence boundaries, and eight focused development modules.'],
      '07 QA/2026-09-05 - Review Coverage.md' => ['What was reviewed', 'What the analysis covered and what still needs a closer look.'],
      '04 Research/Findings/48 - Luminai Evidence Audit and Architecture Boundaries.md' => ['What science can support', 'Real human results, animal experiments, early prototypes, and the point where fiction begins.'],
      '04 Research/Findings/48 - Preliminary Brief Reference Status.md' => ['Where the research came from', 'Verified sources, preliminary leads, and anything that still needs confirmation.'],
      '07 QA/Contradictions.md' => ['Where ideas conflict', 'Contradictions stay visible until the author decides what is true.'],
      '07 QA/Decisions.md' => ['What the author decided', 'The choices that now control the story and the earlier ideas they replaced.']
    ] as $path => $item): ?>
      <article><h3><?= e($item[0]) ?></h3><p><?= e($item[1]) ?></p><a href="<?= e(explorer_file_url($path)) ?>">Read source</a></article>
    <?php endforeach; ?>
    </div>
  <?php elseif ($activeWorkbench === 'workshop'): ?>
    <nav class="workspace-actions" aria-label="Workshop tracks">
      <a<?= $selectedWorkshop === 'endgame' ? ' aria-current="page"' : '' ?> href="<?= e(explorer_view_url('workshop', ['workshop' => 'endgame', 'module' => 'EG-01'], 'session')) ?>">Endgame Workshop</a>
      <a<?= $selectedWorkshop === 'book-one' ? ' aria-current="page"' : '' ?> href="<?= e(explorer_view_url('workshop', ['workshop' => 'book-one', 'module' => 'BA-01'], 'session')) ?>">Book One Architecture</a>
    </nav>
    <details class="workspace-module-index" open><summary>Choose from <?= e((string) count($modules)) ?> <?= $selectedWorkshop === 'endgame' ? 'Endgame' : 'Book One architecture' ?> questions</summary><nav class="workspace-grid" aria-label="Decision modules">
    <?php foreach ($modules as $module): ?>
      <a href="<?= e(explorer_view_url('workshop', ['workshop' => $selectedWorkshop, 'module' => $module['id']], 'session')) ?>"><strong><?= e($module['id'] . ' · ' . $module['title']) ?></strong><span><?= e($module['gate']) ?></span></a>
    <?php endforeach; ?>
    </nav></details>
    <section id="session" class="workshop-session" data-workshop data-workshop-default="<?= e($selectedWorkshop) ?>" data-source-endgame="../../docs/assets/story-endgame-workshop.json?v=<?= e($assetVersion) ?>" data-source-book-one="../../docs/assets/story-workshop.json?v=<?= e($assetVersion) ?>"><p role="status">Loading the selected workshop.</p></section>
    <noscript><p>The workshop needs JavaScript. Every question is also available in the project vault below.</p></noscript>
    <a href="<?= e(explorer_file_url($selectedWorkshop === 'endgame' ? '07 Coordination/Story Completion Workflow/Endgame Workshop/README.md' : '07 Coordination/Story Completion Workflow/Book One Architecture Workshop/README.md')) ?>">See this workshop and its source</a>
    <script src="../../docs/workshop.js?v=<?= e($assetVersion) ?>" defer></script>
  <?php endif; ?>
</section>
