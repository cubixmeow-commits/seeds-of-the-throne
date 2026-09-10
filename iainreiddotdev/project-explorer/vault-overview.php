<?php
// Included by the Project Explorer homepage. Describes vault function, not story content.
$vaultDocumentCount = isset($files) && is_array($files) ? count($files) : 0;
$vaultPlaces = [
    ['New material', 'Preserves incoming ideas and the order in which they developed.', '00 Inbox, 01 Sessions'],
    ['Story memory', 'Keeps the detailed working knowledge and a smaller briefing used to resume work.', '02 Story, 03 Context'],
    ['Research', 'Separates questions, reports, and usable findings from story decisions.', '04 Research'],
    ['Public work', 'Holds reviewed material prepared for readers.', '05 Public'],
    ['Drafts', 'Holds scenes and manuscript candidates awaiting review.', '06 Draft'],
    ['Decisions and direction', 'Records choices, contradictions, current work, handoffs, and verification.', '07 QA, 07 Coordination'],
    ['Development tools', 'Diagnoses missing connections and tests possible story directions.', '08 Story Loop, 09 Story Exploration'],
    ['Reusable methods', 'Provides repeatable methods for writing, research, images, websites, and checks.', 'skills, scripts'],
];
$vaultWorking = [
    'Idea and session capture',
    'Human-readable story memory',
    'Author authority and decision boundaries',
    'Research kept separate from story truth',
    'Workshop questions that wait for an answer',
    'Decisions, contradictions, and open questions',
    'Visual identity and image controls',
    'Markdown files and recoverable history',
    'Searchable file access',
];
$vaultRepair = [
    'One trustworthy current-state view',
    'Automatic checks before a change is merged',
    'Shared labels and stable record identifiers',
    'Updating every affected note after a decision',
    'Keeping the weekly cycle current',
    'Clearer boundaries around older folders',
    'A cleaner split between the repository and the live site',
];
$vaultPlanned = [
    'Durable integration of conversational answers',
    'Automatic reports of what a decision would change',
    'Complete scene-to-manuscript production',
    'Manuscript assembly and export',
    'Reliable mobile save, resume, and synchronization',
];
$vaultNext = [
    'Make builds and checks reliable.',
    'Create one trustworthy current state.',
    'Normalize the records for one small complete path.',
    'Connect accepted decisions to every affected file.',
    'Prove one complete path from conversation to approved manuscript material.',
    'Expand only after that path works.',
];
$vaultLinks = [
    ['Read the full vault assessment', '07 QA/2026-09-10 - Vault Functionality Assessment.md'],
    ['See how the vault works', 'START HERE.md'],
    ['See the current resume point', '07 Coordination/CURRENT-PICKUP.md'],
    ['Read accepted decisions', '07 QA/Decisions.md'],
    ['See unresolved conflicts', '07 QA/Contradictions.md'],
    ['Open the current workshop', '07 Coordination/Story Completion Workflow/Reassessment Workshop/README.md'],
    ['See the development tools', '08 Story Loop/README.md'],
    ['Read the planned authorship system', '07 Coordination/Authoring System/README.md'],
];
?>
<section class="vault-overview wrap" id="vault-overview" aria-labelledby="vault-overview-title">
  <header class="vault-overview__intro">
    <p class="vault-overview__kicker">Vault overview</p>
    <h2 id="vault-overview-title">See the whole story-development system at a glance.</h2>
    <p><?= e((string) $vaultDocumentCount) ?> notes work together as one system. The vault remembers where ideas came from, what the author decided, what remains uncertain, and what should happen next.</p>
    <p class="vault-overview__core">The vault turns conversations into organized story memory. It preserves sources, separates decisions from suggestions, finds missing connections, supports research and workshops, prepares scenes and prose, checks continuity, and publishes selected material without surrendering author control.</p>
    <ul class="vault-overview__now" aria-label="Current system status">
      <li><strong>Working now</strong> Capture, memory, workshops, and research already operate.</li>
      <li><strong>Needs repair</strong> Current-state agreement, automatic checks, and decision updates still drift.</li>
      <li><strong>Planned next</strong> Durable answers, manuscript production, and mobile save are not built yet.</li>
    </ul>
  </header>

  <ol class="vault-overview__flow" aria-label="How an idea moves through the vault">
    <li>
      <h3>Capture</h3>
      <p>Conversations, mobile notes, and raw ideas are preserved.</p>
    </li>
    <li>
      <h3>Understand</h3>
      <p>Current context and compiled notes explain what the project means now.</p>
    </li>
    <li>
      <h3>Decide</h3>
      <p>Workshops ask one important question and preserve the author's answer.</p>
    </li>
    <li>
      <h3>Develop</h3>
      <p>Research, alternatives, story structure, and focused tests strengthen the work.</p>
    </li>
    <li>
      <h3>Create</h3>
      <p>Scene plans, prose, images, and manuscript material are produced for review.</p>
    </li>
    <li>
      <h3>Share</h3>
      <p>Selected material becomes the story site, Project Explorer, and public posts.</p>
    </li>
  </ol>

  <section class="vault-overview__places" aria-labelledby="vault-places-title">
    <h3 id="vault-places-title">What lives where</h3>
    <p>Each area has a job. Folder names are secondary detail.</p>
    <ul>
      <?php foreach ($vaultPlaces as $place): ?>
        <li>
          <h4><?= e($place[0]) ?></h4>
          <p><?= e($place[1]) ?></p>
          <p class="vault-overview__path"><?= e($place[2]) ?></p>
        </li>
      <?php endforeach; ?>
    </ul>
  </section>

  <section class="vault-overview__capabilities" aria-labelledby="vault-capability-title">
    <h3 id="vault-capability-title">What already works, what needs repair, and what is still planned</h3>
    <div class="vault-capability-groups">
      <section class="vault-capability vault-capability--working" aria-labelledby="vault-working-title">
        <h4 id="vault-working-title"><span class="vault-capability__state">Working well</span></h4>
        <ul>
          <?php foreach ($vaultWorking as $item): ?>
            <li><?= e($item) ?></li>
          <?php endforeach; ?>
        </ul>
      </section>
      <section class="vault-capability vault-capability--repair" aria-labelledby="vault-repair-title">
        <h4 id="vault-repair-title"><span class="vault-capability__state">Needs repair</span></h4>
        <ul>
          <?php foreach ($vaultRepair as $item): ?>
            <li><?= e($item) ?></li>
          <?php endforeach; ?>
        </ul>
      </section>
      <section class="vault-capability vault-capability--planned" aria-labelledby="vault-planned-title">
        <h4 id="vault-planned-title"><span class="vault-capability__state">Planned next</span> <span class="vault-capability__note">Not built yet</span></h4>
        <ul>
          <?php foreach ($vaultPlanned as $item): ?>
            <li><?= e($item) ?></li>
          <?php endforeach; ?>
        </ul>
      </section>
    </div>
  </section>

  <section class="vault-overview__next" aria-labelledby="vault-next-title">
    <h3 id="vault-next-title">The next build order</h3>
    <ol>
      <?php foreach ($vaultNext as $item): ?>
        <li><?= e($item) ?></li>
      <?php endforeach; ?>
    </ol>
  </section>

  <nav class="vault-overview__links" aria-labelledby="vault-links-title">
    <h3 id="vault-links-title">Look next</h3>
    <ul>
      <?php foreach ($vaultLinks as $item): ?>
        <li><a href="<?= e(explorer_file_url($item[1])) ?>"><?= e($item[0]) ?></a></li>
      <?php endforeach; ?>
      <li><a href="<?= e(explorer_view_url('files', ['file' => 'README.md'])) ?>">Browse the full archive</a></li>
    </ul>
  </nav>
</section>
