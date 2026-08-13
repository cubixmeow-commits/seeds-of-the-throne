/**
 * iainreid.dev — the whole of the homepage's behaviour.
 *
 * Four small things, none of which the page depends on to be readable:
 *
 *   1. Appearance toggle    light / dark, remembered, system-following by default
 *   2. Header hairline      appears once the page has actually scrolled
 *   3. Section highlighting marks the nav item for the section you are in
 *   4. Copy email           with the mailto link as the real mechanism
 *   5. Showdown gate        the dialog, its focus trap, and its submission
 *
 * No modules, no dependencies, no build step. Everything degrades: with
 * JavaScript off the page still renders completely, the email is still a
 * mailto link, and the appearance still follows the system preference.
 */
(() => {
    'use strict';

    const root = document.documentElement;

    /* ------------------------------------------------------- 1. APPEARANCE */

    const toggle = document.querySelector('#theme-toggle');
    const systemDark = window.matchMedia('(prefers-color-scheme: dark)');

    /** What the visitor is actually looking at right now. */
    const activeTheme = () => {
        const explicit = root.getAttribute('data-theme');
        if (explicit === 'light' || explicit === 'dark') return explicit;
        return systemDark.matches ? 'dark' : 'light';
    };

    /** The label names the action, not the current state. */
    const labelToggle = () => {
        if (!toggle) return;
        toggle.setAttribute(
            'aria-label',
            activeTheme() === 'dark'
                ? 'Switch to light appearance'
                : 'Switch to dark appearance'
        );
    };

    labelToggle();

    if (toggle) {
        toggle.addEventListener('click', () => {
            const next = activeTheme() === 'dark' ? 'light' : 'dark';
            root.setAttribute('data-theme', next);
            try {
                localStorage.setItem('theme', next);
            } catch (error) {
                /* Storage blocked: the choice still applies for this page view. */
            }
            labelToggle();
        });
    }

    /* Follow the system while the visitor has not overridden it. */
    systemDark.addEventListener('change', () => {
        if (!root.hasAttribute('data-theme')) labelToggle();
    });

    /* ---------------------------------------------------- 2. HEADER HAIRLINE */

    const header = document.querySelector('#site-header');

    if (header) {
        const syncHeader = () => {
            header.setAttribute('data-scrolled', window.scrollY > 8 ? 'true' : 'false');
        };

        syncHeader();
        window.addEventListener('scroll', syncHeader, { passive: true });
    }

    /* ------------------------------------------------- 3. SECTION HIGHLIGHT */

    const navLinks = Array.from(document.querySelectorAll('.site-nav__list a[href^="#"]'));

    if (navLinks.length > 0 && 'IntersectionObserver' in window) {
        const sections = navLinks
            .map((link) => document.querySelector(link.getAttribute('href')))
            .filter(Boolean);

        const visible = new Set();

        const syncNav = () => {
            /* The topmost section currently on screen wins, so scrolling past a
               short section never leaves two items marked. */
            let current = null;
            for (const section of sections) {
                if (visible.has(section)) {
                    current = section;
                    break;
                }
            }

            navLinks.forEach((link) => {
                const isCurrent = current !== null
                    && link.getAttribute('href') === '#' + current.id;
                if (isCurrent) {
                    link.setAttribute('aria-current', 'true');
                } else {
                    link.removeAttribute('aria-current');
                }
            });
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    visible.add(entry.target);
                } else {
                    visible.delete(entry.target);
                }
            });
            syncNav();
        }, { rootMargin: '-20% 0px -70% 0px' });

        sections.forEach((section) => observer.observe(section));
    }

    /* ------------------------------------------------------- 4. COPY EMAIL */

    const copyButton = document.querySelector('[data-copy-email]');
    const copyStatus = document.querySelector('#copy-status');

    const setCopyStatus = (message) => {
        if (copyStatus) copyStatus.textContent = message;
    };

    if (copyButton) {
        copyButton.addEventListener('click', async () => {
            const email = copyButton.getAttribute('data-copy-email') || '';

            try {
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    await navigator.clipboard.writeText(email);
                } else {
                    const field = document.createElement('textarea');
                    field.value = email;
                    field.setAttribute('readonly', '');
                    field.style.position = 'absolute';
                    field.style.insetInlineStart = '-9999px';
                    document.body.appendChild(field);
                    field.select();
                    document.execCommand('copy');
                    field.remove();
                }
                setCopyStatus('Copied ' + email + ' to the clipboard.');
            } catch (error) {
                setCopyStatus('Unable to copy. Use the email link above instead.');
            }
        });
    }

    /* ---------------------------------------------------------- 5. SHOWDOWN */

    const modal = document.querySelector('#showdown-modal');
    const panel = modal ? modal.querySelector('.showdown__panel') : null;
    const form = document.querySelector('#showdown-form');
    const answerInput = document.querySelector('#showdown-answer');
    const feedback = document.querySelector('#showdown-feedback');
    const submitButton = form ? form.querySelector('button[type="submit"]') : null;

    /* Everything the dialog has to make inert while it is open. */
    const background = ['#site-header', '#main', '.site-footer']
        .map((selector) => document.querySelector(selector))
        .filter(Boolean);

    const FOCUSABLE = 'a[href], button:not([disabled]), input:not([disabled]), '
        + 'select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';

    let lastFocus = null;

    const setFeedback = (message) => {
        if (feedback) feedback.textContent = message;
    };

    const openModal = () => {
        if (!modal || !modal.hidden) return;

        lastFocus = document.activeElement;
        modal.hidden = false;
        background.forEach((node) => { node.inert = true; });
        document.body.style.overflow = 'hidden';

        setFeedback('');
        if (answerInput) {
            answerInput.value = '';
            answerInput.focus();
        }
    };

    const closeModal = () => {
        if (!modal || modal.hidden) return;

        modal.hidden = true;
        background.forEach((node) => { node.inert = false; });
        document.body.style.overflow = '';
        setFeedback('');

        if (lastFocus && typeof lastFocus.focus === 'function') {
            lastFocus.focus();
        }
    };

    document.querySelectorAll('[data-showdown-open]').forEach((trigger) => {
        trigger.addEventListener('click', openModal);
    });

    document.querySelectorAll('[data-showdown-close]').forEach((trigger) => {
        trigger.addEventListener('click', closeModal);
    });

    document.addEventListener('keydown', (event) => {
        if (!modal || modal.hidden) return;

        if (event.key === 'Escape') {
            closeModal();
            return;
        }

        /* `inert` already removes the background from the tab order; this wraps
           focus at the two ends of the dialog itself. */
        if (event.key !== 'Tab' || !panel) return;

        const items = Array.from(panel.querySelectorAll(FOCUSABLE))
            .filter((item) => item.offsetParent !== null);
        if (items.length === 0) return;

        const first = items[0];
        const last = items[items.length - 1];

        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first.focus();
        }
    });

    if (form && answerInput) {
        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            setFeedback('');

            const answer = answerInput.value.trim();
            if (!answer) {
                setFeedback('Soon enough the secrets will be revealed');
                answerInput.focus();
                return;
            }

            /* Disabled only while the request is in flight, and the label does
               not change underneath the pointer. */
            if (submitButton) submitButton.disabled = true;

            try {
                const response = await fetch('showdown-gate.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ answer }),
                    cache: 'no-store',
                });

                const payload = await response.json();

                if (payload && payload.ok === true && typeof payload.redirect === 'string') {
                    window.location.assign(payload.redirect);
                    return;
                }

                setFeedback(
                    (payload && typeof payload.message === 'string' && payload.message)
                        || 'Soon enough the secrets will be revealed'
                );
            } catch (error) {
                setFeedback('Soon enough the secrets will be revealed');
            } finally {
                if (submitButton) submitButton.disabled = false;
            }
        });
    }
})();
