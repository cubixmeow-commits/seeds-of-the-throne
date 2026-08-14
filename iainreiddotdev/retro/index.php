<?php

declare(strict_types=1);

/**
 * MEOWNET BBS — the retro page.
 *
 * A 1990s dial-up bulletin board, rebuilt as one page: an ANSI banner, a
 * numbered main menu, a message base, a file area, a door-game list, and a
 * sysop screen. Every board on it is about cats, because that is the whole
 * point of the joke.
 *
 * Same production rules as the rest of the site: PHP 8.2, no build step, no
 * package manager, no framework, no third-party runtime dependency. The page
 * requests one stylesheet and one script and no images at all — the artwork is
 * text, the way it was on a real board.
 *
 * All copy lives in the arrays below, so this file is the single source of
 * truth for the page and no line is written down twice. Only the sysop's real
 * name and profile links are read from includes/portfolio.php, so they cannot
 * disagree with the homepage.
 *
 * Behaviour degrades completely. With JavaScript off every screen renders
 * stacked on the page and stays readable; assets/js/retro.js only turns them
 * into a menu.
 */

require __DIR__ . '/../includes/portfolio.php';

$data = portfolio();
$identity = $data['identity'];
$links = $data['links'];

$year = (int) date('Y');
$assetVersion = '20260802a';

$pageTitle = 'MEOWNET BBS — 1 node, 24 hours, all cats';
$pageDescription = 'A 1990s dial-up bulletin board system about cats: message base, '
    . 'file area, door games, and one very tired sysop.';
$canonical = 'https://iainreid.dev/devsite/iainreiddotdev/retro/';

/* ---------------------------------------------------------------- BULLETINS */
/* The news block under the banner. Dated the way a real board dated things:
   whatever the sysop last remembered to edit. */
$bulletins = [
    ['date' => '03-14-97', 'text' => 'Second line installed. We are now a TWO NODE system. Please do not both call at once.'],
    ['date' => '02-28-97', 'text' => 'The cat sat on the modem again. If you were disconnected on Tuesday, that was why.'],
    ['date' => '01-09-97', 'text' => 'New file area: ANSI CAT ART. 340k of it. Download responsibly.'],
];

/* ------------------------------------------------------------- MESSAGE BASE */
/* Sub-board 1 of 1. Handles in caps, because everyone shouted in 1997. */
$messages = [
    [
        'number' => 4417,
        'from' => 'LORD FLUFFINGTON III',
        'to' => 'ALL',
        'date' => 'Fri Mar 14 1997  02:14',
        'subject' => 'Re: Re: Re: the red dot',
        'body' => [
            'It is not a bug in your carpet. I have investigated the matter thoroughly',
            'for eleven months and I am prepared to state, on the record, that the dot',
            'is UNCATCHABLE and that this is a COVER UP.',
            '',
            'Someone in this house is holding the dot. I will find them.',
        ],
    ],
    [
        'number' => 4416,
        'from' => 'MITTENS',
        'to' => 'LORD FLUFFINGTON III',
        'date' => 'Thu Mar 13 1997  23:51',
        'subject' => 'Re: the red dot',
        'body' => [
            'Respectfully, you chased a dot into a wall at speed. Twice. On Tuesday.',
            'I was there. I have witnesses. I have a WITNESS, singular, and he is a',
            'houseplant, but he saw everything.',
        ],
    ],
    [
        'number' => 4415,
        'from' => 'TUNA_BANDIT',
        'to' => 'ALL',
        'date' => 'Thu Mar 13 1997  19:08',
        'subject' => 'ADVICE NEEDED — box situation',
        'body' => [
            'Box arrived. Box is 2 sizes too small. Box is, however, MY box.',
            '',
            'I am sitting in approximately 40% of the box with the remaining 60% of',
            'myself deployed externally. Is this still sitting in the box? Please',
            'advise. Have been here 6 hours.',
        ],
    ],
    [
        'number' => 4414,
        'from' => 'SNOWBALL',
        'to' => 'TUNA_BANDIT',
        'date' => 'Thu Mar 13 1997  19:44',
        'subject' => 'Re: ADVICE NEEDED — box situation',
        'body' => [
            'If any part of you is in the box, you are in the box. This has been settled',
            'law since 1991. Do not let the dogs on node 2 tell you otherwise.',
        ],
    ],
    [
        'number' => 4413,
        'from' => 'WHISKERS.EXE',
        'to' => 'SYSOP',
        'date' => 'Wed Mar 12 1997  04:02',
        'subject' => 'why is there a keyboard on my warm bed',
        'body' => [
            'Every night I settle on the warm flat bed and every night the big one moves',
            'me off it and makes the clicking sounds again. Tonight I sat on the clicking',
            'part and the screen filled with',
            '',
            'ppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppp',
            '',
            'and he made a NOISE. Worth it.',
        ],
    ],
];

/* ---------------------------------------------------------------- FILE AREA */
/* Sizes are period-plausible: nothing here would survive a 14.4k call without
   a lot of patience and a household rule about the telephone. */
$files = [
    ['name' => 'CATSCAN.ZIP',  'size' => '412k', 'date' => '03-01-97', 'dls' => 1841, 'desc' => 'Scanned photos of my cat. 14 images. 256 colours. Worth the call.'],
    ['name' => 'ANSICATS.ZIP', 'size' => '340k', 'date' => '01-09-97', 'dls' => 2203, 'desc' => 'ANSI cat art collection. 88 pieces. Best viewed at 80x25.'],
    ['name' => 'PURR16.WAV',   'size' => ' 88k', 'date' => '11-22-96', 'dls' => 4410, 'desc' => 'Genuine purring. 16-bit. Loops seamlessly if you are patient.'],
    ['name' => 'MEOWMIDI.ZIP', 'size' => ' 24k', 'date' => '10-04-96', 'dls' =>  672, 'desc' => 'Twelve MIDI files. All of them are cats. Do not ask how.'],
    ['name' => 'CATFACTS.TXT', 'size' => '  9k', 'date' => '09-17-96', 'dls' => 5119, 'desc' => 'Facts about cats. Some verified. One of them is about the moon.'],
    ['name' => 'LITTER.EXE',   'size' => '156k', 'date' => '08-30-96', 'dls' =>  318, 'desc' => 'Litter tray scheduling utility. Requires 4MB RAM and commitment.'],
    ['name' => 'NAPMAP.GIF',   'size' => '211k', 'date' => '07-12-96', 'dls' =>  944, 'desc' => 'Floor plan of the house annotated with every sunbeam by hour.'],
];

/* -------------------------------------------------------------------- DOORS */
$doors = [
    ['key' => 'A', 'name' => 'LEGEND OF THE RED CATNIP', 'players' => 214, 'line' => 'Fight, forage, and flirt your way through the garden. 15 turns a day.'],
    ['key' => 'B', 'name' => 'TRADE PAWS 2002',          'players' =>  88, 'line' => 'Interstellar tuna futures. Alliances collapse by Wednesday, always.'],
    ['key' => 'C', 'name' => 'GLOBAL YARN',              'players' =>  41, 'line' => 'Turn-based world domination. One ball of yarn. No survivors.'],
    ['key' => 'D', 'name' => 'THE 4AM ZOOMIES',          'players' => 337, 'line' => 'Real-time racing simulator. Runs only between 03:50 and 04:10.'],
];

/* ---------------------------------------------------------------- ONELINERS */
/* The scrolling ticker. Left by callers on their way out, as tradition demands. */
$oneliners = [
    'I have knocked the glass off the table and I would do it again — MITTENS',
    'The bed is warm because I am correct — LORD FLUFFINGTON III',
    'ASK ME ABOUT MY BOX — TUNA_BANDIT',
    'sysop please fix node 2 the dog keeps posting — SNOWBALL',
    '3am is a normal time to sing — WHISKERS.EXE',
    'no thoughts. sunbeam. — ANONYMOUS TABBY',
];

/* ------------------------------------------------------------- SYSTEM STATS */
$stats = [
    'System name'  => 'MEOWNET BBS',
    'Software'     => 'CatMail Pro v2.11 /386',
    'Nodes'        => '2 (node 2 intermittent — see bulletin)',
    'Connect'      => '300 / 1200 / 2400 / 9600 / 14.4k',
    'Callers'      => '18,204 since 08-14-94',
    'Message base' => '4,417 messages in 1 sub-board',
    'File base'    => '7 files, 1.2 megabytes',
    'Best hour'    => '04:00 — nobody knows why',
];

/* The main menu. The key is the hotkey; the id is the panel it opens. */
$menu = [
    ['key' => '1', 'id' => 'msgs',  'name' => 'MESSAGE BASE',  'line' => 'Read what the cats are arguing about'],
    ['key' => '2', 'id' => 'files', 'name' => 'FILE AREA',     'line' => 'Download at 14.4k, or overnight'],
    ['key' => '3', 'id' => 'doors', 'name' => 'DOOR GAMES',    'line' => 'Four doors, fifteen turns a day'],
    ['key' => '4', 'id' => 'sysop', 'name' => 'SYSOP / SYSTEM', 'line' => 'Who runs this and on what'],
    ['key' => '0', 'id' => 'main',  'name' => 'MAIN MENU',     'line' => 'Back to the top'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($pageDescription) ?>">
    <link rel="canonical" href="<?= e($canonical) ?>">

    <meta property="og:title" content="<?= e($pageTitle) ?>">
    <meta property="og:description" content="<?= e($pageDescription) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= e($canonical) ?>">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:creator" content="<?= e($links['x_handle']) ?>">

    <!-- Phosphor black, so the browser chrome matches the terminal. -->
    <meta name="theme-color" content="#050705">

    <link rel="icon" href="../assets/favicon.svg?v=<?= e($assetVersion) ?>" type="image/svg+xml">
    <link rel="stylesheet" href="../assets/css/retro.css?v=<?= e($assetVersion) ?>">
</head>
<body class="crt" data-phosphor="green">
    <a class="skip-link" href="#board">Skip to the board</a>

    <!-- Two purely decorative overlays: scanlines and a faint screen bloom.
         Both are switched off under prefers-reduced-motion / prefers-contrast. -->
    <div class="crt__scanlines" aria-hidden="true"></div>
    <div class="crt__glow" aria-hidden="true"></div>

    <div class="screen">

        <!-- ================================================== CONNECT ==== -->
        <!-- The dial-up handshake. It is real text in the document, so it is
             there without JavaScript; the script only types it out slowly. -->
        <section class="connect" aria-label="Modem connection">
            <pre class="connect__log" data-connect>ATDT 555-0142
CONNECT 14400/ARQ/V32/LAPM/V42BIS
</pre>
        </section>

        <main id="board">

            <!-- ================================================ BANNER ==== -->
            <header class="banner">
                <pre class="banner__art" role="img" aria-label="MEOWNET, drawn in block characters">
███╗   ███╗███████╗ ██████╗ ██╗    ██╗███╗   ██╗███████╗████████╗
████╗ ████║██╔════╝██╔═══██╗██║    ██║████╗  ██║██╔════╝╚══██╔══╝
██╔████╔██║█████╗  ██║   ██║██║ █╗ ██║██╔██╗ ██║█████╗     ██║
██║╚██╔╝██║██╔══╝  ██║   ██║██║███╗██║██║╚██╗██║██╔══╝     ██║
██║ ╚═╝ ██║███████╗╚██████╔╝╚███╔███╔╝██║ ╚████║███████╗   ██║
╚═╝     ╚═╝╚══════╝ ╚═════╝  ╚══╝╚══╝ ╚═╝  ╚═══╝╚══════╝   ╚═╝</pre>

                <div class="banner__meta">
                    <pre class="banner__cat" aria-hidden="true">
 /\_/\
( o.o )
 > ^ <</pre>
                    <p class="banner__strap">
                        <strong>&laquo; MEOWNET BBS &raquo;</strong><br>
                        2 nodes &middot; 300&ndash;14.4k &middot; 24 hrs<br>
                        Sysop: THE BIG ONE &middot; Est. 1994
                    </p>
                </div>

                <p class="banner__welcome">
                    Welcome back, <span class="hl">GUEST</span>. You are caller
                    <span class="hl">#18,205</span>. You have <span class="hl">60</span>
                    minutes remaining today. Do not tie up the phone line.
                </p>
            </header>

            <!-- ================================================== MENU ==== -->
            <nav class="menu" aria-label="Main menu">
                <p class="menu__hint">
                    Press a number, or click. <kbd>P</kbd> changes the phosphor.
                    <kbd>0</kbd> returns here.
                </p>
                <ul class="menu__list" role="tablist" aria-label="Board areas" data-menu>
                    <?php foreach ($menu as $item): ?>
                        <li>
                            <button
                                type="button"
                                role="tab"
                                id="tab-<?= e($item['id']) ?>"
                                aria-controls="panel-<?= e($item['id']) ?>"
                                aria-selected="false"
                                data-panel="<?= e($item['id']) ?>"
                                data-hotkey="<?= e($item['key']) ?>"
                            >
                                <span class="menu__key">[<?= e($item['key']) ?>]</span>
                                <span class="menu__name"><?= e($item['name']) ?></span>
                                <span class="menu__line"><?= e($item['line']) ?></span>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <!-- =============================================== PANELS ===== -->
            <div class="panels" data-panels>

                <!-- ------------------------------------------ MAIN ------- -->
                <section
                    class="panel"
                    id="panel-main"
                    role="tabpanel"
                    aria-labelledby="tab-main"
                    tabindex="-1"
                >
                    <h1 class="panel__title"><span class="bar" aria-hidden="true">&#9617;&#9618;&#9619;&#9608;</span> BULLETINS</h1>

                    <dl class="bulletins">
                        <?php foreach ($bulletins as $bulletin): ?>
                            <div class="bulletins__row">
                                <dt><?= e($bulletin['date']) ?></dt>
                                <dd><?= e($bulletin['text']) ?></dd>
                            </div>
                        <?php endforeach; ?>
                    </dl>

                    <h2 class="panel__sub"><span class="bar" aria-hidden="true">&#9617;&#9618;&#9619;&#9608;</span> ONE-LINERS</h2>
                    <ul class="oneliners">
                        <?php foreach ($oneliners as $line): ?>
                            <li><span aria-hidden="true">&gt;</span> <?= e($line) ?></li>
                        <?php endforeach; ?>
                    </ul>

                    <p class="prompt">
                        <span aria-hidden="true">MAIN:&nbsp;</span>Choose an area above
                        <span class="cursor" aria-hidden="true"></span>
                    </p>
                </section>

                <!-- ------------------------------------------ MESSAGES --- -->
                <section
                    class="panel"
                    id="panel-msgs"
                    role="tabpanel"
                    aria-labelledby="tab-msgs"
                    tabindex="-1"
                >
                    <h1 class="panel__title"><span class="bar" aria-hidden="true">&#9617;&#9618;&#9619;&#9608;</span> MESSAGE BASE 1 &mdash; FELINE CHATTER</h1>
                    <p class="panel__lede">4,417 messages. Showing the last five. Reading is free; posting requires a validated account and a thumb.</p>

                    <?php foreach ($messages as $message): ?>
                        <article class="msg">
                            <header class="msg__head">
                                <p><span class="msg__label">Msg #</span><?= e((string) $message['number']) ?></p>
                                <p><span class="msg__label">From</span><span class="hl"><?= e($message['from']) ?></span></p>
                                <p><span class="msg__label">To</span><?= e($message['to']) ?></p>
                                <p><span class="msg__label">Date</span><?= e($message['date']) ?></p>
                                <p class="msg__subject"><span class="msg__label">Subj</span><span class="hl"><?= e($message['subject']) ?></span></p>
                            </header>
                            <pre class="msg__body"><?php
                                echo e(implode("\n", $message['body']));
                            ?></pre>
                        </article>
                    <?php endforeach; ?>

                    <p class="prompt">
                        <span aria-hidden="true">MSG:&nbsp;</span>End of messages
                        <span class="cursor" aria-hidden="true"></span>
                    </p>
                </section>

                <!-- ------------------------------------------ FILES ------ -->
                <section
                    class="panel"
                    id="panel-files"
                    role="tabpanel"
                    aria-labelledby="tab-files"
                    tabindex="-1"
                >
                    <h1 class="panel__title"><span class="bar" aria-hidden="true">&#9617;&#9618;&#9619;&#9608;</span> FILE AREA 3 &mdash; CATS (ALL)</h1>
                    <p class="panel__lede">Ratio 1:3. Protocol ZMODEM. At 14.4k the big ones take about four minutes, so start them and go and do something else.</p>

                    <div class="table-scroll">
                        <table class="files">
                            <caption class="sr-only">Files available for download</caption>
                            <thead>
                                <tr>
                                    <th scope="col">Filename</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">DLs</th>
                                    <th scope="col">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($files as $file): ?>
                                    <tr>
                                        <td class="hl"><?= e($file['name']) ?></td>
                                        <td><?= e($file['size']) ?></td>
                                        <td><?= e($file['date']) ?></td>
                                        <td><?= e(number_format($file['dls'])) ?></td>
                                        <td><?= e($file['desc']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <p class="prompt">
                        <span aria-hidden="true">FILE:&nbsp;</span>Nothing here actually downloads. It is 1997 in here and 2026 out there
                        <span class="cursor" aria-hidden="true"></span>
                    </p>
                </section>

                <!-- ------------------------------------------ DOORS ------ -->
                <section
                    class="panel"
                    id="panel-doors"
                    role="tabpanel"
                    aria-labelledby="tab-doors"
                    tabindex="-1"
                >
                    <h1 class="panel__title"><span class="bar" aria-hidden="true">&#9617;&#9618;&#9619;&#9608;</span> DOOR GAMES</h1>
                    <p class="panel__lede">Fifteen turns a day, reset at midnight. Inter-BBS scores are posted weekly when the sysop remembers.</p>

                    <ul class="doors">
                        <?php foreach ($doors as $door): ?>
                            <li class="door">
                                <p class="door__name">
                                    <span class="menu__key">[<?= e($door['key']) ?>]</span>
                                    <span class="hl"><?= e($door['name']) ?></span>
                                </p>
                                <p class="door__line"><?= e($door['line']) ?></p>
                                <p class="door__players"><?= e((string) $door['players']) ?> players</p>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <p class="prompt">
                        <span aria-hidden="true">DOOR:&nbsp;</span>All doors are closed. A cat is sitting in front of each one
                        <span class="cursor" aria-hidden="true"></span>
                    </p>
                </section>

                <!-- ------------------------------------------ SYSOP ------ -->
                <section
                    class="panel"
                    id="panel-sysop"
                    role="tabpanel"
                    aria-labelledby="tab-sysop"
                    tabindex="-1"
                >
                    <h1 class="panel__title"><span class="bar" aria-hidden="true">&#9617;&#9618;&#9619;&#9608;</span> SYSOP &amp; SYSTEM</h1>

                    <p class="panel__lede">
                        This board is a joke page on <a href="../">iainreid.dev</a>, built by
                        <span class="hl"><?= e($identity['name']) ?></span> in the same stack as the
                        rest of the site: PHP, HTML, CSS, and one small script. No build step, no
                        dependencies, and no images &mdash; every piece of art on this page is text.
                    </p>

                    <div class="table-scroll">
                        <table class="stats">
                            <caption class="sr-only">System statistics</caption>
                            <tbody>
                                <?php foreach ($stats as $label => $value): ?>
                                    <tr>
                                        <th scope="row"><?= e($label) ?></th>
                                        <td><?= e($value) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <h2 class="panel__sub"><span class="bar" aria-hidden="true">&#9617;&#9618;&#9619;&#9608;</span> LEAVE A MESSAGE FOR THE SYSOP</h2>
                    <ul class="sysop-links">
                        <li><a href="<?= e($links['mailto']) ?>">E-mail <?= e($links['email']) ?></a></li>
                        <li><a href="<?= e($links['x']) ?>" rel="noopener noreferrer"><?= e($links['x_handle']) ?></a></li>
                        <li><a href="<?= e($links['github']) ?>" rel="noopener noreferrer">GitHub</a></li>
                        <li><a href="../">Return to iainreid.dev</a></li>
                    </ul>

                    <p class="prompt">
                        <span aria-hidden="true">SYSOP:&nbsp;</span>Chat request sent. The sysop is asleep
                        <span class="cursor" aria-hidden="true"></span>
                    </p>
                </section>
            </div>
        </main>

        <!-- ================================================== STATUS ====== -->
        <footer class="status" aria-label="Status line">
            <p class="status__cell">Node 1</p>
            <p class="status__cell">14400 bps</p>
            <p class="status__cell">ANSI on</p>
            <p class="status__cell">Time on: <span data-elapsed>00:00</span></p>
            <p class="status__cell">
                <!-- Amber or green. Hidden without JavaScript, because without
                     the script it cannot do anything. -->
                <button type="button" class="status__button" data-phosphor-toggle hidden>
                    [P] Phosphor: <span data-phosphor-label>green</span>
                </button>
            </p>
            <p class="status__cell status__cell--wide">
                <a href="../">&lt; LOG OFF &mdash; back to iainreid.dev</a>
            </p>
            <p class="status__cell">&copy; <?= e((string) $year) ?></p>
        </footer>
    </div>

    <script src="../assets/js/retro.js?v=<?= e($assetVersion) ?>" defer></script>
</body>
</html>
