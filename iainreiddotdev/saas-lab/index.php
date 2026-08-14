<?php

declare(strict_types=1);

// Shared account system: gives this page an auth-state-aware account
// entry point. The bootstrap starts the session and wires the helpers.
// Public idea counts come from the database; private/invite ideas never appear.
require __DIR__ . '/../includes/bootstrap.php';

$publicIdeaCount = count_public_ideas();
$publicIdeaCountLabel = str_pad((string) $publicIdeaCount, 2, '0', STR_PAD_LEFT);

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="VibeKB is a repository understanding platform for AI-assisted development. It transforms repositories into living understanding sites so developers can explore architecture, features, and relationships with confidence.">
    <meta name="theme-color" content="#0d0c0a">
    <meta property="og:title" content="VibeKB · Iain Reid">
    <meta property="og:description" content="Repository understanding for AI-assisted development. Understand your software before you change it.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://iainreid.dev/devsite/iainreiddotdev/saas-lab/">
    <meta name="twitter:card" content="summary">
    <title>VibeKB · Repository Understanding · Iain Reid</title>
    <link rel="canonical" href="https://iainreid.dev/devsite/iainreiddotdev/saas-lab/">
    <link rel="stylesheet" href="../assets/css/style.css?v=20260719g">
    <link rel="stylesheet" href="../assets/css/saas-lab.css?v=20260719a">
    <link rel="stylesheet" href="../assets/css/auth.css?v=20260719a">
</head>
<body>
    <div class="ambient-light" aria-hidden="true"></div>
    <div class="dust" aria-hidden="true"></div>
    <div class="ledger-rule" aria-hidden="true"></div>

    <header class="site-header">
        <a class="maker-mark" href="/devsite/iainreiddotdev/" aria-label="Return to the workshop journal">
            <span class="maker-mark__sigil">IR</span>
            <span>
                <strong>Iain Reid</strong>
                <small>Independent software developer</small>
            </span>
        </a>
        <button
            class="nav-toggle"
            type="button"
            aria-expanded="false"
            aria-controls="site-nav"
            aria-label="Open menu">
            <span class="nav-toggle__bars" aria-hidden="true"></span>
        </button>
        <nav id="site-nav" aria-label="Primary navigation">
            <a href="/devsite/iainreiddotdev/">Workshop</a>
            <a href="/devsite/iainreiddotdev/saas-lab/" aria-current="page">VibeKB</a>
            <a href="#experiments">Capabilities</a>
            <a href="#method">Method</a>
            <a href="#principles">Principles</a>
            <span class="lab-account-nav" role="group" aria-label="Account access">
                <?php if (is_logged_in()): ?>
                    <?php if (is_admin()): ?>
                        <a class="btn btn--ghost" href="<?= e(url('admin/experiments.php')) ?>">Ideas</a>
                        <a class="btn btn--ghost" href="<?= e(url('admin/')) ?>">Admin</a>
                    <?php endif; ?>
                    <a class="btn btn--ghost" href="<?= e(url('auth/account.php')) ?>">Account</a>
                <?php else: ?>
                    <a class="btn btn--ghost" href="<?= e(url('auth/login.php')) ?>">Log in</a>
                    <a class="btn btn--primary" href="<?= e(url('auth/register.php')) ?>">Create account</a>
                <?php endif; ?>
            </span>
        </nav>
    </header>

    <main>
        <!-- Hero -->
        <section class="lab-hero" id="top" aria-labelledby="lab-title">
            <div class="lab-hero__intro" data-reveal>
                <p class="mono">Field ledger · Featured project</p>
                <h1 id="lab-title">VibeKB</h1>
                <p class="lab-hero__lede">Understand your AI-built software.</p>
                <p class="lab-hero__copy">Modern AI coding tools help us build software faster than ever. Understanding it hasn’t kept up. VibeKB transforms repositories into living understanding sites that help developers regain confidence, understand architecture, explore functionality, and safely continue development.</p>
                <div class="lab-hero__meta">
                    <span><b>Focus</b> repository understanding</span>
                    <span><b>Built for</b> AI-assisted workflows</span>
                    <span><b>Public ideas</b> <?= e($publicIdeaCountLabel) ?></span>
                </div>
            </div>

            <aside class="board" data-reveal aria-label="Capability index">
                <div class="board__head">
                    <span class="board__title">Active bench</span>
                    <span class="board__count">03</span>
                </div>
                <ul class="board__rows">
                    <li class="board__row">
                        <span class="board__id">CAP-01</span>
                        <a class="board__name" href="#exp-understand">Understanding</a>
                        <span class="signal signal--active">Core</span>
                    </li>
                    <li class="board__row">
                        <span class="board__id">CAP-02</span>
                        <a class="board__name" href="#exp-explore">Exploration</a>
                        <span class="signal signal--working">Core</span>
                    </li>
                    <li class="board__row">
                        <span class="board__id">CAP-03</span>
                        <a class="board__name" href="#exp-architecture">Architecture</a>
                        <span class="signal signal--dev">Core</span>
                    </li>
                </ul>
                <div class="board__pipe" aria-label="Understanding pipeline">
                    <span>analyze</span><i>→</i>
                    <span>structure</span><i>→</i>
                    <span>explain</span><i>→</i>
                    <span>explore</span><i>→</i>
                    <span>continue</span>
                </div>
            </aside>
        </section>

        <!-- What it is -->
        <section class="section lab-section" id="about" aria-labelledby="about-heading">
            <div class="section-heading" data-reveal>
                <span class="mono">01 · Premise</span>
                <h2 id="about-heading">Understanding before modification</h2>
                <p class="eyebrow-note">AI coding tools let people build large applications quickly. After a few days or weeks, many struggle to answer basic questions about their own software.</p>
            </div>
            <div class="instruments" data-reveal>
                <p><span class="accent">VibeKB is a repository understanding platform designed for the age of AI-assisted software development.</span> Instead of forcing developers to rediscover their own architecture, it helps them regain understanding and confidence—so they can see how the application works, where to make changes, and what could break if they do.</p>
                <div class="inv-grid">
                    <div class="inv-group">
                        <h3>What it is</h3>
                        <ul>
                            <li>Repository understanding</li>
                            <li>Human-first explanation</li>
                            <li>Living project knowledge</li>
                        </ul>
                    </div>
                    <div class="inv-group">
                        <h3>What it is not</h3>
                        <ul>
                            <li>A code generator</li>
                            <li>A marketing pitch</li>
                            <li>A throwaway summary</li>
                        </ul>
                    </div>
                    <div class="inv-group">
                        <h3>It helps answer</h3>
                        <ul>
                            <li>How does this work</li>
                            <li>Where should I change</li>
                            <li>What depends on this</li>
                        </ul>
                    </div>
                    <div class="inv-group">
                        <h3>Built for</h3>
                        <ul>
                            <li>Solo developers</li>
                            <li>AI-assisted workflows</li>
                            <li>Returning to a codebase</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Capabilities -->
        <section class="section lab-section" id="experiments" aria-labelledby="experiments-heading">
            <div class="section-heading" data-reveal>
                <span class="mono">02 · On the bench</span>
                <h2 id="experiments-heading">Three capabilities in focus</h2>
                <p class="eyebrow-note">Each capability exists to make software comprehension concrete: what the system does, how features relate, and where architecture lives in the files.</p>
            </div>

            <div class="experiments">
                <!-- CAP-01 Understanding -->
                <article class="experiment" id="exp-understand" data-reveal aria-labelledby="exp1-name">
                    <div class="experiment__head">
                        <span class="experiment__ghost" aria-hidden="true">01</span>
                        <span class="experiment__id">CAP-01</span>
                        <h3 class="experiment__name" id="exp1-name">Human-first understanding</h3>
                        <span class="signal signal--active">Core</span>
                    </div>
                    <div class="experiment__body">
                        <div class="experiment__narrative">
                            <div class="experiment__hypothesis">
                                <span class="field-label">Hypothesis</span>
                                <blockquote>Developers regain confidence faster when a repository is explained in clear, structured, human-friendly language—not buried in raw file trees.</blockquote>
                            </div>
                            <div class="experiment__block">
                                <span class="field-label">Problem being addressed</span>
                                <p>After building with AI, people often cannot answer how their application actually works. The code exists. The understanding does not. Returning after time away makes the gap worse.</p>
                            </div>
                            <div class="experiment__block">
                                <span class="field-label">Working product loop</span>
                                <div class="loop">
                                    <span>Connect a repository</span><i>→</i>
                                    <span>Analyze with AI assistance</span><i>→</i>
                                    <span>Read a living understanding site</span>
                                </div>
                            </div>
                        </div>
                        <div class="rail">
                            <dl>
                                <div>
                                    <dt>Evidence watched</dt>
                                    <dd class="muted">Whether developers can explain their own system after time away, and whether they feel ready to modify it without rediscovering everything from scratch.</dd>
                                </div>
                                <div>
                                    <dt>Technology</dt>
                                    <dd class="tech"><span>PHP</span><span>AI analysis</span><span>JavaScript</span></dd>
                                </div>
                                <div>
                                    <dt>Decision gate</dt>
                                    <dd>Does the understanding site restore functional comprehension faster than reading the repository alone?</dd>
                                </div>
                                <div>
                                    <dt>Next experiment</dt>
                                    <dd class="muted">Keep explanations current as the repository changes.</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </article>

                <!-- CAP-02 Exploration -->
                <article class="experiment" id="exp-explore" data-reveal aria-labelledby="exp2-name">
                    <div class="experiment__head">
                        <span class="experiment__ghost" aria-hidden="true">02</span>
                        <span class="experiment__id">CAP-02</span>
                        <h3 class="experiment__name" id="exp2-name">Feature-oriented exploration</h3>
                        <span class="signal signal--working">Core</span>
                    </div>
                    <div class="experiment__body">
                        <div class="experiment__narrative">
                            <div class="experiment__hypothesis">
                                <span class="field-label">Hypothesis</span>
                                <blockquote>Developers find the right place to work when they can explore software by feature and functionality, not only by folder and filename.</blockquote>
                            </div>
                            <div class="experiment__block">
                                <span class="field-label">Problem being addressed</span>
                                <p>AI-generated repositories grow quickly. Files implement functionality, but the map from “what I want to change” to “which files matter” is often missing. Relationships between features stay opaque.</p>
                            </div>
                            <div class="experiment__block">
                                <span class="field-label">Working product loop</span>
                                <div class="loop">
                                    <span>Browse by feature</span><i>→</i>
                                    <span>See related functionality</span><i>→</i>
                                    <span>Open the implementing files</span>
                                </div>
                            </div>
                        </div>
                        <div class="rail">
                            <dl>
                                <div>
                                    <dt>Evidence watched</dt>
                                    <dd class="muted">Whether people can locate the files behind a feature without hunting through the tree, and whether feature relationships reduce accidental breakage.</dd>
                                </div>
                                <div>
                                    <dt>Technology</dt>
                                    <dd class="tech"><span>PHP</span><span>AI analysis</span><span>Structured views</span></dd>
                                </div>
                                <div>
                                    <dt>Decision gate</dt>
                                    <dd>Can a developer answer “what files implement this?” and “what depends on this?” from the understanding site?</dd>
                                </div>
                                <div>
                                    <dt>Next experiment</dt>
                                    <dd class="muted">Surface clear relationships between features as the primary navigation path.</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </article>

                <!-- CAP-03 Architecture -->
                <article class="experiment" id="exp-architecture" data-reveal aria-labelledby="exp3-name">
                    <div class="experiment__head">
                        <span class="experiment__ghost" aria-hidden="true">03</span>
                        <span class="experiment__id">CAP-03</span>
                        <h3 class="experiment__name" id="exp3-name">Functional architecture mapping</h3>
                        <span class="signal signal--dev">Core</span>
                    </div>
                    <div class="experiment__body">
                        <div class="experiment__narrative">
                            <div class="experiment__hypothesis">
                                <span class="field-label">Hypothesis</span>
                                <blockquote>Architecture clarity comes from mapping how the system behaves—not from generating more text about the code.</blockquote>
                            </div>
                            <div class="experiment__block">
                                <span class="field-label">Problem being addressed</span>
                                <p>People can ship software they no longer understand. Without a functional map, every change feels risky. The question is not “what did the AI write?” but “how does this application hold together?”</p>
                            </div>
                            <div class="experiment__block">
                                <span class="field-label">Working product loop</span>
                                <div class="loop">
                                    <span>Map functional structure</span><i>→</i>
                                    <span>Clarify module roles</span><i>→</i>
                                    <span>Assess change impact</span>
                                </div>
                            </div>
                        </div>
                        <div class="rail">
                            <dl>
                                <div>
                                    <dt>Evidence watched</dt>
                                    <dd class="muted">Whether architecture views help people predict what could break, and whether they continue development with less hesitation after time away.</dd>
                                </div>
                                <div>
                                    <dt>Technology</dt>
                                    <dd class="tech"><span>PHP</span><span>AI analysis</span><span>Architecture views</span></dd>
                                </div>
                                <div>
                                    <dt>Decision gate</dt>
                                    <dd>Does functional architecture mapping make safe continuation of AI-assisted projects feel possible again?</dd>
                                </div>
                                <div>
                                    <dt>Next experiment</dt>
                                    <dd class="muted">Keep the architecture map living as the repository evolves.</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <!-- Operating method -->
        <section class="section lab-section" id="method" aria-labelledby="method-heading">
            <div class="section-heading" data-reveal>
                <span class="mono">03 · Operating method</span>
                <h2 id="method-heading">From repository to understanding</h2>
                <p class="eyebrow-note">The path is deliberate. Analysis is only useful when it becomes something a developer can read, explore, and trust before making changes.</p>
            </div>
            <div class="pipeline" data-reveal>
                <div class="pipe-step">
                    <div class="pipe-step__num">01</div>
                    <div class="pipe-step__body">
                        <h3>Start from a real repository</h3>
                        <p>Begin with software that already exists—especially systems built quickly with AI assistance, where understanding has not kept pace with construction.</p>
                    </div>
                </div>
                <div class="pipe-step">
                    <div class="pipe-step__num">02</div>
                    <div class="pipe-step__body">
                        <h3>Analyze with AI assistance</h3>
                        <p>Use AI to inspect structure, features, and relationships at a scale that would be slow to do by hand—then shape the result for human reading.</p>
                    </div>
                </div>
                <div class="pipe-step">
                    <div class="pipe-step__num">03</div>
                    <div class="pipe-step__body">
                        <h3>Build a living understanding site</h3>
                        <p>Produce a clear, structured site that explains how the software works. The point is software comprehension, not generating more text for its own sake.</p>
                    </div>
                </div>
                <div class="pipe-step">
                    <div class="pipe-step__num">04</div>
                    <div class="pipe-step__body">
                        <h3>Explore by feature and function</h3>
                        <p>Let developers navigate through functionality, architecture, and relationships so they can find where to work without rediscovering the whole tree.</p>
                    </div>
                </div>
                <div class="pipe-step">
                    <div class="pipe-step__num">05</div>
                    <div class="pipe-step__body">
                        <h3>Understand before you change</h3>
                        <p>Use the map to answer practical questions: what implements this, what depends on it, and what could break if you modify it.</p>
                    </div>
                </div>
                <div class="pipe-step pipe-step--gate">
                    <div class="pipe-step__num"><span>◆</span></div>
                    <div class="pipe-step__body">
                        <h3>Continue with confidence</h3>
                        <p>Return to development knowing how the application holds together. Understanding is the gate; modification comes after.</p>
                        <div class="gate-outcomes">
                            <span>Explore</span>
                            <span>Clarify</span>
                            <span>Modify</span>
                            <span>Maintain</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Principles -->
        <section class="section lab-section" id="principles" aria-labelledby="principles-heading">
            <div class="section-heading" data-reveal>
                <span class="mono">04 · Lab principles</span>
                <h2 id="principles-heading">How the bench is run</h2>
            </div>
            <ol class="tenets" data-reveal>
                <li class="tenet">
                    <span class="tenet__num">P1</span>
                    <p>Understanding before modification.</p>
                </li>
                <li class="tenet">
                    <span class="tenet__num">P2</span>
                    <p>Explain software for humans first.</p>
                </li>
                <li class="tenet">
                    <span class="tenet__num">P3</span>
                    <p>Explore by feature and function, not only by file.</p>
                </li>
                <li class="tenet">
                    <span class="tenet__num">P4</span>
                    <p>Keep project knowledge living as the code changes.</p>
                </li>
                <li class="tenet">
                    <span class="tenet__num">P5</span>
                    <p>Architecture clarity reduces fear of change.</p>
                </li>
                <li class="tenet">
                    <span class="tenet__num">P6</span>
                    <p>AI assists analysis. Human understanding remains the goal.</p>
                </li>
            </ol>
        </section>

        <!-- Technical approach -->
        <section class="section lab-section" id="stack" aria-labelledby="stack-heading">
            <div class="section-heading" data-reveal>
                <span class="mono">05 · The bench</span>
                <h2 id="stack-heading">Instruments on hand</h2>
                <p class="eyebrow-note">The stack stays deliberately practical. The point is not the tools. It is turning a repository into something a developer can understand and continue.</p>
            </div>
            <div class="instruments" data-reveal>
                <p><span class="accent">Modest, well understood tools keep the distance short between analysis and a usable understanding site.</span> Shared hosting and familiar runtimes keep each iteration honest about real deployment conditions.</p>
                <div class="inv-grid">
                    <div class="inv-group">
                        <h3>Runtime</h3>
                        <ul>
                            <li>PHP 8.2</li>
                            <li>HTML</li>
                            <li>CSS</li>
                            <li>JavaScript</li>
                        </ul>
                    </div>
                    <div class="inv-group">
                        <h3>Data</h3>
                        <ul>
                            <li>SQLite</li>
                            <li>MySQL</li>
                        </ul>
                    </div>
                    <div class="inv-group">
                        <h3>Automation</h3>
                        <ul>
                            <li>Cron workers</li>
                            <li>GitHub</li>
                        </ul>
                    </div>
                    <div class="inv-group">
                        <h3>Delivery</h3>
                        <ul>
                            <li>cPanel</li>
                            <li>Shared Linux hosting</li>
                        </ul>
                    </div>
                    <div class="inv-group">
                        <h3>AI assistance</h3>
                        <ul>
                            <li>Claude</li>
                            <li>Cursor</li>
                            <li>ChatGPT</li>
                            <li>Gemini</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="lab-close" data-reveal aria-labelledby="close-heading">
        <h2 id="close-heading">Software you built should still make sense</h2>
        <p>VibeKB is about repository understanding for AI-assisted development. When construction outpaces comprehension, a living understanding site helps developers regain confidence and continue with clarity.</p>
        <div class="lab-close__links">
            <a href="/devsite/iainreiddotdev/">Return to the workshop journal</a>
            <a href="mailto:iain@iainreid.dev">iain@iainreid.dev</a>
        </div>
        </section>
    </main>

    <footer>
        <span>iainreid.dev / vibekb</span>
        <span>Field ledger · <time datetime="2026">2026</time></span>
    </footer>

    <script src="../assets/js/app.js?v=20260719d"></script>
</body>
</html>
