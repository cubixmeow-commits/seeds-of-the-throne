<?php

declare(strict_types=1);

/**
 * Portfolio content — the single source of truth.
 *
 * Everything the homepage shows comes from here: the identity block, the
 * project records, the foundations (capabilities), and the method ledger.
 * index.php and the partials under includes/partials/ read this array and
 * nothing else, so no sentence, status, or URL is written down twice.
 *
 * ---------------------------------------------------------------------------
 * ADDING A PROJECT
 * ---------------------------------------------------------------------------
 *
 * It is a data edit. Add a record to $projects with:
 *
 *   'id'        a slug, unique — it becomes the entry's anchor
 *   'category'  one of the ids in $categories (or add a new category)
 *   'mark'      the numeral shown in the entry rail
 *   'status'    a plain status; "Field record" renders the quieter treatment
 *   'tagline'   one line naming what the thing is
 *   'summary'   what it does and why that matters
 *   'links'     at least one, each with a 'label' and an 'href'
 *
 * Optional blocks render only when present: 'detail', 'problem', 'sequence'
 * (with 'sequence_label'), 'highlights', 'stack' (with 'stack_label'),
 * 'studies', and 'related'.
 *
 * Keep claims grounded in working projects. This file is also the editorial
 * source for how those projects are positioned on the public homepage.
 */
if (!function_exists('e')) {
    /**
     * Escape a string for HTML output.
     */
    function e(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}

/**
 * Return the complete portfolio record.
 *
 * @return array<string, mixed>
 */
function portfolio(): array
{
    static $data = null;

    if ($data !== null) {
        return $data;
    }

    $links = [
        'github' => 'https://github.com/cubixmeow-commits',
        'x' => 'https://x.com/realiainreid',
        'x_handle' => '@realiainreid',
        'email' => 'iain@iainreid.dev',
        'mailto' => 'mailto:iain@iainreid.dev',
    ];

    // ---------------------------------------------------------------- IDENTITY
    $identity = [
        'name' => 'Iain Reid',
        'initials' => 'IR',
        'role' => 'Creative systems and software developer',
        'statement' => 'I build stories and the software systems that make ambitious creative work possible.',
        'note' => 'Seeds of the Throne is the central project: a long-form speculative world, a repository-owned development system, a visual compiler, and a public publishing platform built together.',
        'margin' => 'Seeds of the Throne is the showcase. The supporting projects demonstrate the repository understanding, workflow design, image production, and application engineering behind it.',
        'portrait' => [
            'src' => 'assets/images/portrait.jpg',
            'alt' => 'Portrait of Iain Reid',
            'width' => 400,
            'height' => 500,
        ],
        'about' => [
            'title' => 'Creative work as a software system',
            'body' => [
                'Seeds of the Throne brings Iain’s creative and software work into one evolving system: story development, canon and continuity, research, visual generation, and public presentation all remain connected without surrendering authorial judgment to AI.',
                'The supporting products develop the same underlying craft—making repositories understandable, guiding substantial AI-assisted work, producing finished imagery, and shipping maintainable systems into real environments.',
            ],
        ],
        'contact' => [
            'title' => 'Build the ambitious thing clearly.',
            'lead' => 'Seeds of the Throne is my working proof that creative direction and software architecture can reinforce each other. I’m interested in similarly ambitious creative and software systems that need structure before they can grow.',
        ],
    ];

    // -------------------------------------------------------------- CATEGORIES
    // Categories group the work by what the software is for. Each entry names
    // its own category in the rail, so the page stays one flat list.
    $categories = [
        [
            'id' => 'showcase',
            'name' => 'Creative and software development',
            'line' => 'One story project connecting worldbuilding, repository architecture, visual generation, publishing, and author-directed AI.',
        ],
        [
            'id' => 'understanding',
            'name' => 'Software understanding',
            'line' => 'Making existing systems legible before the next change.',
        ],
        [
            'id' => 'workflows',
            'name' => 'Guided AI workflows',
            'line' => 'Helping people finish substantial work with the AI they already have.',
        ],
        [
            'id' => 'creative',
            'name' => 'Production creative systems',
            'line' => 'Complete engines that turn creative input into finished output.',
        ],
    ];

    // ---------------------------------------------------------------- PROJECTS
    $projects = [
        [
            'id' => 'vibekb',
            'name' => 'VibeKB',
            'mark' => 'II',
            'category' => 'understanding',
            'status' => 'Active',
            'tagline' => 'Repository understanding',
            'summary' => 'Turns an unfamiliar software repository into a living understanding site—documenting what the software currently does, how components connect, where functionality lives, what is verified, and what remains uncertain.',
            'detail' => [
                'The current focus: a system for understanding software before the next change.',
            ],
            'problem' => [
                'The core problem' => 'AI-assisted development makes software faster to create but harder to understand later.',
                'The system response' => 'VibeKB creates a repository-owned, source-grounded model before the next developer or agent changes anything.',
            ],
            'spec' => [
                'Concern' => 'Make complex software understandable, structured, and usable.',
                'Output' => 'Static understanding site with commit-pinned source links.',
            ],
            'sequence' => [
                ['label' => 'Repository', 'hint' => 'Source of truth', 'link' => 'analyzed into'],
                ['label' => 'Functionality model', 'hint' => 'What the software does', 'link' => 'organized with'],
                ['label' => 'Warnings & files', 'hint' => 'Evidence with reasons', 'link' => 'rendered through'],
                ['label' => 'Explainable Diagrams', 'hint' => 'Nodes and edges', 'link' => 'published as'],
                ['label' => 'Understanding site', 'hint' => 'Static, shareable'],
            ],
            'sequence_label' => 'Understanding flow',
            'highlights' => [
                'Functionality-first model',
                'Nodes explain what components are',
                'Edges explain why they connect',
                'Verified versus inferred relationships',
                'Files always include reasons',
                'No graph database required',
                'Static output suitable for GitHub Pages',
            ],
            // Applied studies. Each one references another project record for
            // its links, so no URL is written down twice.
            'studies' => [
                [
                    'specimen' => 'Specimen A',
                    'project' => 'arcana',
                    'context' => 'VibeKB documenting a real PHP / MySQL / Gemini production application.',
                    'findings' => [
                        'Authentication and email verification paths',
                        'Credits, plan gating, and Stripe assumptions',
                        'Uploads, image generation, and queue workers',
                        'Gallery behavior, watermarks, and render storage',
                        'Deployment assumptions, warnings, and uncertainty',
                    ],
                ],
                [
                    'specimen' => 'Specimen B',
                    'project' => 'stoppr',
                    'context' => 'VibeKB applied to a separate mobile application and its surrounding architecture.',
                    'findings' => [
                        'Implemented versus partial functionality',
                        'Paywall and subscription flows',
                        'Superwall integration and placeholder configuration',
                        'OAuth assumptions',
                        'Widget and app-group concerns',
                        'Verified and inferred architecture boundaries',
                    ],
                ],
            ],
            'links' => [
                ['label' => 'Repository', 'href' => 'https://github.com/cubixmeow-commits/VibeKB', 'kind' => 'repo'],
                ['label' => 'Project page', 'href' => 'saas-lab/', 'kind' => 'page', 'internal' => true],
            ],
        ],
        [
            'id' => 'stoppr',
            'name' => 'Stoppr',
            'mark' => 'II·B',
            'category' => 'understanding',
            'status' => 'Field record',
            'tagline' => 'Applied study',
            'summary' => 'VibeKB applied to a separate mobile application and its surrounding architecture.',
            'detail' => [
                'An annotated specimen rather than an interchangeable archive card: the understanding site records what is implemented, what is partial, and where the architecture boundaries are verified or inferred.',
            ],
            'stack_label' => 'Documented surface',
            'stack' => [
                'Implemented versus partial functionality',
                'Paywall and subscription flows',
                'Superwall integration and placeholder configuration',
                'OAuth assumptions',
                'Widget and app-group concerns',
                'Verified and inferred architecture boundaries',
            ],
            'links' => [
                ['label' => 'Repository', 'href' => 'https://github.com/cubixmeow-commits/VibeKB-stoppr', 'kind' => 'repo'],
                ['label' => 'Understanding site', 'href' => 'https://cubixmeow-commits.github.io/VibeKB-stoppr/', 'kind' => 'doc'],
            ],
            'related' => ['vibekb'],
        ],
        [
            'id' => 'sousmeow',
            'name' => 'SousMeow',
            'mark' => 'III',
            'category' => 'workflows',
            'status' => 'Active prototype',
            'tagline' => 'Guided AI workflows',
            'summary' => 'A guided workflow system that helps people complete substantial tasks using the AI subscriptions they already have.',
            'detail' => [
                'Not a prompt library. It is closer to sitting beside someone who is good at AI and being guided through the complete task.',
            ],
            'sequence' => [
                ['label' => 'Pantry', 'hint' => 'Persistent context'],
                ['label' => 'Recipe', 'hint' => 'One sequential step'],
                ['label' => 'Run in ChatGPT / Claude / Gemini', 'hint' => 'Use existing subscriptions'],
                ['label' => 'Bring back result', 'hint' => 'Capture the artifact'],
                ['label' => 'Quality check', 'hint' => 'Success criteria & failure signals'],
                ['label' => 'Next Recipe', 'hint' => 'Continue the workflow'],
                ['label' => 'Project Kit', 'hint' => 'Exportable outcomes'],
            ],
            'sequence_label' => 'Guided workflow',
            'highlights' => [
                'Cookbooks contain complete workflows.',
                'Recipes are sequential steps.',
                'Pantry context persists across the run.',
                'Artifacts retain versions.',
                'Every step has success criteria and failure signals.',
                'Works with free or paid AI subscriptions.',
                'The core loop avoids required API metering.',
                'Results can be exported as a project kit.',
            ],
            'links' => [
                ['label' => 'Open SousMeow', 'href' => 'https://cubixmeow.com/iain/projects/sousmeow/public/', 'kind' => 'live'],
            ],
        ],
        [
            'id' => 'arcana',
            'name' => 'Arcana / You Are The Song Now',
            'short' => 'Arcana',
            'mark' => 'IV',
            'category' => 'creative',
            'status' => 'Working system',
            'tagline' => 'Production creative engine',
            'summary' => 'Transforms a song, lyrics, band identity, style direction, and optional portrait references into a single cinematic visual composition.',
            'detail' => [
                'Built as an operable product—not a single prompt demo—with accounts, credits, queues, storage, and shared-hosting deployment in mind.',
                'Commercial integrations are part of the production surface; verification depth varies by path.',
            ],
            'sequence' => [
                ['label' => 'Song input', 'hint' => 'Lyrics, identity, style'],
                ['label' => 'Analysis', 'hint' => 'Gemini → Song DNA'],
                ['label' => 'Prompt construction', 'hint' => 'Structured direction'],
                ['label' => 'Queue', 'hint' => 'Job intake'],
                ['label' => 'Worker', 'hint' => 'Parallel cron paths'],
                ['label' => 'Image service', 'hint' => 'Generation + fallbacks'],
                ['label' => 'Storage', 'hint' => 'Renders retained'],
                ['label' => 'Gallery', 'hint' => 'Watermarked presentation'],
            ],
            'sequence_label' => 'Production flow',
            'stack_label' => 'Production capabilities',
            'stack' => [
                'Gemini song analysis',
                'Structured Song DNA',
                'Prompt construction',
                'Image generation',
                'Style selection',
                'Dynamic band-style analysis',
                'Portrait references',
                'Multiple aspect ratios',
                'Queue processing',
                'Parallel cron workers',
                'Fallback paths',
                'Accounts & email verification',
                'Credits & plan gating',
                'Stripe (integration present)',
                'Render storage & gallery',
                'Watermarks',
                'Admin & maintenance controls',
                'Shared-hosting deployment',
            ],
            'links' => [
                ['label' => 'Repository', 'href' => 'https://github.com/cubixmeow-commits/youarethesongnow', 'kind' => 'repo'],
                ['label' => 'Product', 'href' => 'https://youarethesongnow.com', 'kind' => 'live'],
                ['label' => 'Understanding site', 'href' => 'https://cubixmeow-commits.github.io/youarethesongnow/', 'kind' => 'doc'],
            ],
            'related' => ['vibekb'],
        ],
        [
            'id' => 'seeds-of-the-throne',
            'name' => 'Seeds of the Throne',
            'mark' => 'I',
            'category' => 'showcase',
            'status' => 'Showcase · Active development',
            'featured' => true,
            'tagline' => 'Speculative fiction world and creative-development platform',
            'summary' => 'A long-form speculative fiction project and the software system being built to develop it. A repository-owned Obsidian vault connects story sessions, canon, research, drafts, visual direction, generated imagery, public material, and continuity checks without treating AI output as authority.',
            'detail' => [
                'The repository acts as persistent creative memory and machine-readable direction. Its Visual World Compiler turns vault knowledge into structured character, appearance, era, environment, and scene context for repeatable image generation and feedback-driven refinement.',
                'The creative work and the software evolve together: gaps exposed by a scene become explicit worldbuilding questions, approved answers return to the vault, and public-facing material is generated only from selected sources. The author retains control of canon, visual identity, and voice.',
            ],
            'sequence' => [
                ['label' => 'Story session', 'hint' => 'Possibilities and decisions'],
                ['label' => 'Canon promotion', 'hint' => 'Selected material only'],
                ['label' => 'Knowledge graph', 'hint' => 'Entities, eras, appearances, and places'],
                ['label' => 'Scene compilation', 'hint' => 'Clean context for prose or imagery'],
                ['label' => 'Review and feedback', 'hint' => 'Continuity, quality, and missing definitions'],
                ['label' => 'Creative output', 'hint' => 'Prose, atlas, images, and video'],
            ],
            'sequence_label' => 'Creative development loop',
            'highlights' => [
                'Repository-owned creative memory',
                'Canon separated from exploration',
                'Visual entity graph and generation packets',
                'Authoritative identity, appearance, and era resolution',
                'Environment masters and composition modes',
                'Clean generation context separated from quality review',
                'Missing visual definitions become worldbuilding tasks',
                'Continuity decisions and unresolved questions tracked explicitly',
                'Public story atlas generated from approved material',
                'Authorial judgment remains the final authority',
            ],
            'links' => [
                ['label' => 'Repository', 'href' => 'https://github.com/cubixmeow-commits/seeds-of-the-throne', 'kind' => 'repo'],
                ['label' => 'Explore the story atlas', 'href' => '../docs/', 'kind' => 'doc', 'internal' => true],
            ],
        ],
    ];

    // The showcase leads while the supporting projects retain their declared
    // order. Keeping this in the content layer lets every renderer agree.
    $projects = array_merge(
        array_values(array_filter($projects, static fn (array $project): bool => !empty($project['featured']))),
        array_values(array_filter($projects, static fn (array $project): bool => empty($project['featured'])))
    );

    // ------------------------------------------------------------- FOUNDATIONS
    // These become the surface roots: what the visible work grows out of.
    $foundations = [
        [
            'id' => 'product',
            'title' => 'Product systems',
            'items' => [
                'Product architecture',
                'Workflow design',
                'Authentication',
                'Billing and credits',
                'Administration and maintenance',
            ],
        ],
        [
            'id' => 'ai',
            'title' => 'AI systems',
            'items' => [
                'Structured prompting',
                'Gemini integration',
                'Image generation',
                'Response review',
                'Human-in-the-loop workflows',
            ],
        ],
        [
            'id' => 'engineering',
            'title' => 'Application engineering',
            'items' => [
                'PHP 8.2',
                'MySQL',
                'SQLite',
                'Vanilla JavaScript',
                'HTML and CSS',
                'Cron and queue workers',
                'File and image processing',
                'Shared-hosting deployment',
            ],
        ],
        [
            'id' => 'understanding',
            'title' => 'Software understanding',
            'items' => [
                'Repository analysis',
                'Functionality mapping',
                'Explainable diagrams',
                'Provenance',
                'Warnings and uncertainty',
                'Static knowledge generation',
                'Agent handoffs',
            ],
        ],
    ];

    // ------------------------------------------------------------------ METHOD
    $method = [
        [
            'mark' => '01',
            'title' => 'Find the real friction',
            'body' => 'Begin with the actual problem experienced by the user—not the abstract technology story.',
            'ties' => [
                'Seeds of the Throne' => 'Starts from the difficulty of sustaining canon, continuity, and creative direction across a long story.',
                'VibeKB' => 'Starts from the confusion that follows AI-assisted code.',
                'SousMeow' => 'Starts from unfinished AI work and brittle prompt habits.',
                'Arcana' => 'Starts from the gap between song intent and finished visuals.',
            ],
        ],
        [
            'mark' => '02',
            'title' => 'Build the smallest complete mechanism',
            'body' => 'Favor one complete end-to-end loop over many disconnected features.',
            'ties' => [
                'Seeds of the Throne' => 'Session → canon promotion → scene compilation → review → creative output.',
                'VibeKB' => 'Repository in → understanding site out.',
                'SousMeow' => 'Pantry → recipe → review → next step.',
                'Arcana' => 'Song in → queued render → gallery out.',
            ],
        ],
        [
            'mark' => '03',
            'title' => 'Make the system explain itself',
            'body' => 'Capture architecture, warnings, decisions, status, and handoffs in the repository.',
            'ties' => [
                'Seeds of the Throne' => 'Canon, open questions, visual direction, and consequential decisions stay explicit.',
                'VibeKB' => 'The product is the explanation.',
                'SousMeow' => 'Every step carries success criteria and failure signals.',
                'Arcana' => 'Song DNA, queue state, and admin controls stay inspectable.',
            ],
        ],
        [
            'mark' => '04',
            'title' => 'Ship for the environment that exists',
            'body' => 'Design around actual hosting, deployment, maintenance, and operating constraints.',
            'ties' => [
                'Seeds of the Throne' => 'Uses an Obsidian-compatible repository and static public atlas that remain portable across AI tools.',
                'VibeKB' => 'Static output that can live on GitHub Pages.',
                'SousMeow' => 'Works with free or paid AI subscriptions; no required API metering.',
                'Arcana' => 'Built for shared hosting, cron workers, and real billing paths.',
            ],
        ],
    ];

    $data = [
        'identity' => $identity,
        'links' => $links,
        'categories' => $categories,
        'projects' => $projects,
        'foundations' => $foundations,
        'method' => $method,
    ];

    return $data;
}

/**
 * Look up a project record by id, or null when it does not exist.
 *
 * @return array<string, mixed>|null
 */
function portfolio_project(string $id): ?array
{
    foreach (portfolio()['projects'] as $project) {
        if ($project['id'] === $id) {
            return $project;
        }
    }

    return null;
}

/**
 * The name used in compact places (rail headings, index rows, tree labels).
 */
function portfolio_short_name(array $project): string
{
    return isset($project['short']) && is_string($project['short'])
        ? $project['short']
        : $project['name'];
}
