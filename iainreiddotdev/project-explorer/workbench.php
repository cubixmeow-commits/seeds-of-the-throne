<?php
// Included by the existing read-only Explorer. All content originates in reviewed vault Markdown.
$atlasPath = $repositoryRoot . '/docs/assets/story-atlas.json';
$workshopPath = $repositoryRoot . '/docs/assets/story-workshop.json';
$atlasData = is_file($atlasPath) ? json_decode((string) file_get_contents($atlasPath), true) : [];
$workshopData = is_file($workshopPath) ? json_decode((string) file_get_contents($workshopPath), true) : [];
$atlasData = is_array($atlasData) ? $atlasData : [];
$modules = is_array($workshopData) && isset($workshopData['modules']) && is_array($workshopData['modules']) ? $workshopData['modules'] : [];

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
        'title' => 'Build the missing path through Book One.',
        'lede' => 'The ending is established. The current workshop now defines the exact contest, Samuel\'s lie, the birthday clock, the opening, the middle, the evidence order, and the final choices that make it work as a novel.',
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
      <li><h3>The current workshop builds Book One one consequential decision at a time.</h3><p>Each answer turns the established ending into a clearer objective, scene, relationship change, revelation, or causal transition.</p><a href="<?= e(explorer_view_url('workshop', ['module' => 'BA-01'], 'session')) ?>">Start the Book One workshop</a></li>
      <li><h3>Accepted answers are added where they belong.</h3><p>An accepted decision can update character notes, the timeline, world rules, plot events, and the list of remaining questions.</p><a href="<?= e(explorer_view_url('evidence')) ?>">Review decisions and supporting information</a></li>
      <li><h3>Use the completed plan to write and revise scenes.</h3><p>The planned system will create scene outlines, draft prose, check continuity, revise weak sections, and assemble the manuscript for the author's approval.</p><a href="<?= e(explorer_file_url('07 Coordination/Authoring System/03 - Workshop and Composition Engines.md')) ?>">Read the system plan</a></li>
    </ol>
    <p class="workspace-example">Seeds of the Throne is the working example. The notes, decisions, and workshop below are the live project, not a demonstration mockup.</p>
    <div class="workspace-actions"><a href="<?= e(explorer_file_url('07 QA/2026-09-11 - Book One Buildability Assessment.md')) ?>">See the new assessment</a><a href="<?= e(explorer_file_url('07 Coordination/CURRENT-PICKUP.md')) ?>">See where development continues</a><a href="../../docs/index.html">Enter the story</a></div>
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
    <details class="workspace-module-index"><summary>Choose from ten Book One architecture questions</summary><nav class="workspace-grid" aria-label="Decision modules">
    <?php foreach ($modules as $module): ?>
      <a href="<?= e(explorer_view_url('workshop', ['module' => $module['id']], 'session')) ?>"><strong><?= e($module['id'] . ' · ' . $module['title']) ?></strong><span><?= e($module['gate']) ?></span></a>
    <?php endforeach; ?>
    </nav></details>
    <section id="session" class="workshop-session" data-workshop data-source="../../docs/assets/story-workshop.json?v=<?= e($assetVersion) ?>"><p role="status">Loading the selected workshop.</p></section>
    <noscript><p>The workshop needs JavaScript. Every question is also available in the project vault below.</p></noscript>
    <a href="<?= e(explorer_file_url('07 Coordination/Story Completion Workflow/Book One Architecture Workshop/README.md')) ?>">See the current workshop and its source</a>
    <script src="../../docs/workshop.js?v=<?= e($assetVersion) ?>" defer></script>
  <?php endif; ?>
</section>
