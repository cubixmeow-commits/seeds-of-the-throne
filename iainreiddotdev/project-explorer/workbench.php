<?php
// Included by the existing read-only Explorer. All content originates in reviewed vault Markdown.
$atlasPath = $repositoryRoot . '/docs/assets/story-atlas.json';
$workshopPath = $repositoryRoot . '/docs/assets/story-workshop.json';
$atlasData = is_file($atlasPath) ? json_decode((string) file_get_contents($atlasPath), true) : [];
$workshopData = is_file($workshopPath) ? json_decode((string) file_get_contents($workshopPath), true) : [];
$atlasData = is_array($atlasData) ? $atlasData : [];
$modules = is_array($workshopData) && isset($workshopData['modules']) && is_array($workshopData['modules']) ? $workshopData['modules'] : [];
$views = ['overview' => 'How it works', 'sources' => 'Explore the story', 'evidence' => 'Proof and decisions', 'workshop' => 'Build the story'];
$view = isset($_GET['view']) && is_string($_GET['view']) && isset($views[$_GET['view']]) ? $_GET['view'] : 'overview';
?>
<section class="development-workspace wrap" id="workbench" aria-labelledby="workbench-title">
  <header class="workspace-intro"><p>Story development tools</p><h2 id="workbench-title">The workshop helps the author complete the parts of the story that are still missing.</h2><p>It explains one story problem, asks one clear question, offers different possible answers, and shows what each answer would change. The author makes the decision. The accepted answer is then added to the characters, timeline, world, and plot.</p></header>
  <nav class="workspace-tabs" aria-label="Development views">
  <?php foreach ($views as $key => $label): ?>
    <a href="?view=<?= e($key) ?>#workbench"<?= $key === $view ? ' aria-current="page"' : '' ?>><?= e($label) ?></a>
  <?php endforeach; ?>
  </nav>
  <p class="workspace-notice">This is a public, read-only look at the real project, so it contains full spoilers. You can try the workshop, but your draft stays in this browser unless you export it.</p>
  <?php if ($view === 'overview'): ?>
    <div class="workspace-grid">
      <article><span>01 · Add the author's ideas</span><h3>The author explains the story in ordinary language.</h3><p>The system records those ideas and separates confirmed decisions from suggestions and unanswered questions.</p><a href="<?= e(explorer_file_url('01 Sessions/Daily/2026-09-07 - Conversational Authorship Product Direction.md')) ?>">Read how the system is designed</a></article>
      <article><span>02 · Complete the missing parts</span><h3>The workshop asks one question at a time.</h3><p>Each question helps the author decide a missing cause, character choice, relationship, world rule, or event.</p><a href="?view=workshop&amp;module=08#session">Open a workshop question</a></article>
      <article><span>03 · Update the connected notes</span><h3>Accepted answers are added where they belong.</h3><p>An accepted decision can update character notes, the timeline, world rules, plot events, and the list of remaining questions.</p><a href="?view=evidence#workbench">Review decisions and supporting information</a></article>
      <article><span>04 · Create the finished story</span><h3>Use the completed plan to write and revise scenes.</h3><p>The planned system will create scene outlines, draft prose, check continuity, revise weak sections, and assemble the manuscript for the author's approval.</p><a href="<?= e(explorer_file_url('07 Coordination/Authoring System/03 - Workshop and Composition Engines.md')) ?>">Read the system plan</a></article>
    </div>
    <div class="workspace-actions"><a href="<?= e(explorer_file_url('07 QA/2026-09-05 - Comprehensive Story Assessment.md')) ?>">See what the analysis found</a><a href="<?= e(explorer_file_url('07 Coordination/CURRENT-PICKUP.md')) ?>">See where development continues</a><a href="../../docs/index.html">Enter the story</a></div>
  <?php elseif ($view === 'sources'): ?>
    <p>The story site and Project Explorer are built from the same reviewed Markdown. Open any topic to see the public story, the source behind it, and whether the idea is settled or still being developed.</p>
    <div class="workspace-grid">
    <?php foreach ($atlasData as $entry): ?>
      <article><span><?= e($entry['route']) ?></span><h3><?= e($entry['title']) ?></h3><p><?= e($entry['deck']) ?></p><a href="<?= e(explorer_file_url($entry['source'])) ?>">See the source</a> · <a href="../../docs/<?= e($entry['route']) ?>.html">Read the story page</a></article>
    <?php endforeach; ?>
    </div>
  <?php elseif ($view === 'evidence'): ?>
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
  <?php elseif ($view === 'workshop'): ?>
    <p>Choose one part of the story. Each workshop explains what is known, what is missing, why the answer matters, and several different ways the story could work. Nothing becomes part of the story until the author accepts it.</p>
    <details class="workspace-module-index"><summary>Choose from twenty story workshops</summary><nav class="workspace-grid" aria-label="Decision modules">
    <?php foreach ($modules as $module): ?>
      <a href="?view=workshop&amp;module=<?= e($module['id']) ?>#session"><strong><?= e($module['id'] . ' · ' . $module['title']) ?></strong><span><?= e($module['gate']) ?></span></a>
    <?php endforeach; ?>
    </nav></details>
    <section id="session" class="workshop-session" data-workshop data-source="../../docs/assets/story-workshop.json"><p role="status">Loading the selected workshop.</p></section>
    <noscript><p>The workshop needs JavaScript. Every question is also available in the project vault below.</p></noscript>
    <a href="<?= e(explorer_file_url('07 Coordination/Story Completion Workflow/Workshop/README.md')) ?>">See every workshop and its source</a>
    <script src="../../docs/workshop.js?v=20260906" defer></script>
  <?php endif; ?>
</section>
