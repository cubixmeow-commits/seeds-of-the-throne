/**
 * MEOWNET BBS — the whole of the retro page's behaviour.
 *
 * Four small things, none of which the page depends on to be readable:
 *
 *   1. Connect log     types out the modem handshake on arrival
 *   2. Menu            turns the stacked screens into a real BBS menu
 *   3. Phosphor        green or amber, remembered
 *   4. Status line     the "time on" counter in the bottom bar
 *
 * No modules, no dependencies, no build step. Everything degrades: with
 * JavaScript off every screen is already rendered on the page, the handshake
 * text is already in the document, and the phosphor control is never shown
 * because it could not do anything.
 */
(() => {
    'use strict';

    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

    /* ----------------------------------------------------- 1. CONNECT LOG */

    const log = document.querySelector('[data-connect]');

    if (log && !reduceMotion.matches) {
        const full = log.textContent;
        let index = 0;

        log.textContent = '';

        /* Roughly the rate a 14.4k line painted text, which is about as fast
           as it is possible to read along with. */
        const tick = window.setInterval(() => {
            index += 1;
            log.textContent = full.slice(0, index);

            if (index >= full.length) {
                window.clearInterval(tick);
            }
        }, 22);
    }

    /* ------------------------------------------------------------ 2. MENU */

    const menu = document.querySelector('[data-menu]');
    const panelHost = document.querySelector('[data-panels]');
    const tabs = menu ? Array.from(menu.querySelectorAll('[data-panel]')) : [];

    /** Show one screen and mark its menu item, optionally moving focus. */
    const open = (id, moveFocus) => {
        tabs.forEach((tab) => {
            const selected = tab.dataset.panel === id;
            const panel = document.getElementById('panel-' + tab.dataset.panel);

            tab.setAttribute('aria-selected', String(selected));
            /* Only the selected tab is in the tab order; arrow keys move
               between them, which is how a tablist is expected to behave. */
            tab.tabIndex = selected ? 0 : -1;

            if (panel) {
                panel.hidden = !selected;
            }
        });

        if (!moveFocus) return;

        const panel = document.getElementById('panel-' + id);
        if (panel) {
            panel.focus();
        }
    };

    if (tabs.length > 0 && panelHost) {
        /* Marks that the script has taken over, so the stylesheet can drop the
           between-screens rules it only needs in the no-JavaScript layout. */
        panelHost.dataset.ready = '';
        open('main', false);

        tabs.forEach((tab) => {
            tab.addEventListener('click', () => open(tab.dataset.panel, true));
        });

        /* Arrow keys move along the menu, Home and End jump to its ends. */
        menu.addEventListener('keydown', (event) => {
            const current = tabs.indexOf(document.activeElement);
            if (current === -1) return;

            const last = tabs.length - 1;
            let next = null;

            if (event.key === 'ArrowRight' || event.key === 'ArrowDown') {
                next = current === last ? 0 : current + 1;
            } else if (event.key === 'ArrowLeft' || event.key === 'ArrowUp') {
                next = current === 0 ? last : current - 1;
            } else if (event.key === 'Home') {
                next = 0;
            } else if (event.key === 'End') {
                next = last;
            }

            if (next === null) return;

            event.preventDefault();
            tabs[next].focus();
            open(tabs[next].dataset.panel, false);
        });
    }

    /* -------------------------------------------------------- 3. PHOSPHOR */

    const phosphorButton = document.querySelector('[data-phosphor-toggle]');
    const phosphorLabel = document.querySelector('[data-phosphor-label]');

    /** Apply a phosphor and keep the button's label honest. */
    const setPhosphor = (name) => {
        document.body.dataset.phosphor = name;
        if (phosphorLabel) {
            phosphorLabel.textContent = name;
        }
    };

    if (phosphorButton) {
        /* The control only exists once it can work. */
        phosphorButton.hidden = false;

        try {
            const stored = localStorage.getItem('retro-phosphor');
            if (stored === 'green' || stored === 'amber') {
                setPhosphor(stored);
            }
        } catch (error) {
            /* Private mode or blocked storage: green, as shipped. */
        }

        phosphorButton.addEventListener('click', () => {
            const next = document.body.dataset.phosphor === 'amber' ? 'green' : 'amber';
            setPhosphor(next);

            try {
                localStorage.setItem('retro-phosphor', next);
            } catch (error) {
                /* Storage blocked: the choice still applies for this page view. */
            }
        });
    }

    /* ------------------------------------------------------- HOTKEYS ---- */

    /* The numbered menu keys, plus P for the phosphor. Ignored while a control
       or a text field has focus, so nothing hijacks ordinary typing. */
    document.addEventListener('keydown', (event) => {
        if (event.metaKey || event.ctrlKey || event.altKey) return;

        const active = document.activeElement;
        if (active && active.closest('input, textarea, select, [contenteditable]')) return;

        const key = event.key.toLowerCase();

        if (key === 'p' && phosphorButton) {
            event.preventDefault();
            phosphorButton.click();
            return;
        }

        const tab = tabs.find((candidate) => candidate.dataset.hotkey === key);
        if (tab) {
            event.preventDefault();
            open(tab.dataset.panel, true);
        }
    });

    /* ----------------------------------------------------- 4. STATUS LINE */

    const elapsed = document.querySelector('[data-elapsed]');

    if (elapsed) {
        const start = Date.now();
        const pad = (value) => String(value).padStart(2, '0');

        const showElapsed = () => {
            const seconds = Math.floor((Date.now() - start) / 1000);
            elapsed.textContent = pad(Math.floor(seconds / 60)) + ':' + pad(seconds % 60);
        };

        showElapsed();
        window.setInterval(showElapsed, 1000);
    }
})();
