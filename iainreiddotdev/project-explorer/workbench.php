<?php
// Included by the existing read-only Explorer. All content originates in reviewed vault Markdown.
$atlasPath = $repositoryRoot . '/docs/assets/story-atlas.json';
$workshopPath = $repositoryRoot . '/docs/assets/story-workshop.json';
$atlasData = is_file($atlasPath) ? json_decode((string) file_get_contents($atlasPath), true) : [];
$workshopData = is_file($workshopPath) ? json_decode((string) file_get_contents($workshopPath), true) : [];
$atlasData = is_array($atlasData) ? $atlasData : [];
$modules = is_array($workshopData) && isset($workshopData['modules']) && is_array($workshopData['modules']) ? $workshopData['modules'] : [];
$views = ['overview' => 'Development map', 'sources' => 'Story structure', 'evidence' => 'Evidence and decisions', 'workshop' => 'Brainstorming workshop'];
$view = isset($_GET['view']) && is_string($_GET['view']) && isset($views[$_GET['view']]) ? $_GET['view'] : 'overview';
?>
<section class="development-workspace wrap" id="workbench" aria-labelledby="workbench-title">
  <header class="workspace-intro"><p>Development workspace · September 5 review</p><h2 id="workbench-title">Find the cause. Test the choice.</h2><p>Sources, unresolved mechanics, and eighty non-canon alternatives. The active execution gate remains SC-010 Question 7.</p></header>
  <nav class="workspace-tabs" aria-label="Development views">
  <?php foreach ($views as $key => $label): ?>
    <a href="?view=<?= e($key) ?>#workbench"<?= $key === $view ? ' aria-current="page"' : '' ?>><?= e($label) ?></a>
  <?php endforeach; ?>
  </nav>
  <p class="workspace-notice">Public, read-only development material with full spoilers. Draft answers stay in your browser until exported; they do not update the vault. A spoiler boundary is not privacy protection.</p>
  <?php if ($view === 'overview'): ?>
    <div class="workspace-grid">
      <article><span>01 · Foundation</span><h3>The environment creates the bond.</h3><p>The leaders developed Luminai within an interactive colonization environment. Sylvan tests a more deeply integrated generation after thousands of years of development.</p><a href="<?= e(explorer_file_url('02 Story/Components/Core Premise.md')) ?>">Inspect the controlling premise</a></article>
      <article><span>02 · Institutional gap</span><h3>Control must protect people.</h3><p>Final-years control is established. Stopping authority, cumulative harm, privacy, and remedies still need concrete rules.</p><a href="?view=workshop&amp;module=08#session">Test the leaders' safeguards</a></article>
      <article><span>03 · Causal gap</span><h3>Autonomy becomes access.</h3><p>Konrad's reactivation gives Samuel a hidden advantage. The exact lock, retained powers, and failed verification need definition.</p><a href="?view=workshop&amp;module=11#session">Build the takeover sequence</a></article>
      <article><span>04 · Human stakes</span><h3>Sylvan controls the outcome.</h3><p>Suspense must come from what a responsible outcome costs, rather than pretending Samuel still might seize decisive control.</p><a href="?view=workshop&amp;module=16#session">Develop Book One suspense</a></article>
    </div>
    <div class="workspace-actions"><a href="<?= e(explorer_file_url('07 QA/2026-09-05 - Comprehensive Story Assessment.md')) ?>">Read Astra's integrated assessment</a><a href="<?= e(explorer_file_url('07 Coordination/CURRENT-PICKUP.md')) ?>">Open Current Pickup</a><a href="../../docs/index.html">Open the reader's atlas</a></div>
  <?php elseif ($view === 'sources'): ?>
    <p>The same reviewed Markdown builds the atlas and this topic index. Open a source to inspect its authority; follow its canonical links before changing a claim.</p>
    <div class="workspace-grid">
    <?php foreach ($atlasData as $entry): ?>
      <article><span><?= e($entry['route']) ?></span><h3><?= e($entry['title']) ?></h3><p><?= e($entry['deck']) ?></p><a href="<?= e(explorer_file_url($entry['source'])) ?>">Source and canon links</a> · <a href="../../docs/<?= e($entry['route']) ?>.html">Atlas view</a></article>
    <?php endforeach; ?>
    </div>
  <?php elseif ($view === 'evidence'): ?>
    <div class="workspace-grid">
    <?php foreach ([
      '07 QA/2026-09-05 - Comprehensive Story Assessment.md' => ['Story assessment', 'Source-linked findings, consequences, and creative synthesis.'],
      '07 QA/2026-09-05 - Review Coverage.md' => ['Review coverage', 'What was read, inventoried, and left outside this pass.'],
      '04 Research/Findings/48 - Luminai Evidence Audit and Architecture Boundaries.md' => ['Scientific evidence', 'Human results, animal experiments, prototypes, and fictional extrapolation.'],
      '04 Research/Findings/48 - Preliminary Brief Reference Status.md' => ['Reference status', 'Every reference in the preliminary brief, including unchecked leads.'],
      '07 QA/Contradictions.md' => ['Contradictions', 'Unresolved conflicts retained rather than silently repaired.'],
      '07 QA/Decisions.md' => ['Author decisions', 'Accepted corrections and the authority needed to integrate new answers.']
    ] as $path => $item): ?>
      <article><h3><?= e($item[0]) ?></h3><p><?= e($item[1]) ?></p><a href="<?= e(explorer_file_url($path)) ?>">Read source</a></article>
    <?php endforeach; ?>
    </div>
  <?php elseif ($view === 'workshop'): ?>
    <p>Recommended foundation sessions: purpose, entry, placement, reconstruction, and generations. This is preparation guidance; it does not replace the active completion list.</p>
    <details class="workspace-module-index"><summary>Browse all twenty decision packets</summary><nav class="workspace-grid" aria-label="Decision modules">
    <?php foreach ($modules as $module): ?>
      <a href="?view=workshop&amp;module=<?= e($module['id']) ?>#session"><strong><?= e($module['id'] . ' · ' . $module['title']) ?></strong><span><?= e($module['gate']) ?></span></a>
    <?php endforeach; ?>
    </nav></details>
    <section id="session" class="workshop-session" data-workshop data-source="../../docs/assets/story-workshop.json"><p role="status">Loading the selected packet.</p></section>
    <noscript><p>The editor needs JavaScript. Every packet is also readable in the repository browser below.</p></noscript>
    <a href="<?= e(explorer_file_url('07 Coordination/Story Completion Workflow/Workshop/README.md')) ?>">Read the full workshop index and Markdown source links</a>
    <script src="../../docs/workshop.js?v=20260905" defer></script>
  <?php endif; ?>
</section>
