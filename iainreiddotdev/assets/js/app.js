(() => {
    'use strict';

    const header = document.querySelector('.site-header');
    const toggle = document.querySelector('.nav-toggle');
    const nav = document.querySelector('#site-nav');
    const revealItems = document.querySelectorAll('[data-reveal]');
    const desktopQuery = window.matchMedia('(min-width: 901px)');

    const updateHeader = () => {
        if (!header) return;
        header.classList.toggle('is-scrolled', window.scrollY > 24);
    };

    const setNavOpen = (open) => {
        if (!header || !toggle) return;
        header.classList.toggle('is-nav-open', open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
    };

    const closeNav = () => setNavOpen(false);

    updateHeader();
    window.addEventListener('scroll', updateHeader, { passive: true });

    if (toggle && nav && header) {
        toggle.addEventListener('click', () => {
            setNavOpen(!header.classList.contains('is-nav-open'));
        });

        nav.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', closeNav);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') closeNav();
        });

        document.addEventListener('click', (event) => {
            if (!header.classList.contains('is-nav-open')) return;
            if (header.contains(event.target)) return;
            closeNav();
        });

        const handleDesktopChange = (event) => {
            if (event.matches) closeNav();
        };

        if (typeof desktopQuery.addEventListener === 'function') {
            desktopQuery.addEventListener('change', handleDesktopChange);
        } else if (typeof desktopQuery.addListener === 'function') {
            desktopQuery.addListener(handleDesktopChange);
        }
    }

    if (!('IntersectionObserver' in window)) {
        revealItems.forEach((item) => item.classList.add('is-visible'));
    } else {
        const observer = new IntersectionObserver((entries, activeObserver) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                activeObserver.unobserve(entry.target);
            });
        }, {
            rootMargin: '0px 0px -8% 0px',
            threshold: 0.12,
        });

        revealItems.forEach((item) => observer.observe(item));
    }

    const modal = document.querySelector('#showdown-modal');
    const openTriggers = document.querySelectorAll('[data-showdown-open]');
    const closeTriggers = document.querySelectorAll('[data-showdown-close]');
    const form = document.querySelector('#showdown-form');
    const answerInput = document.querySelector('#showdown-answer');
    const feedback = document.querySelector('#showdown-feedback');
    const submitButton = form ? form.querySelector('button[type="submit"]') : null;
    let lastFocus = null;

    const setFeedback = (message) => {
        if (feedback) feedback.textContent = message;
    };

    const openModal = () => {
        if (!modal) return;
        lastFocus = document.activeElement;
        modal.hidden = false;
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
        document.body.style.overflow = '';
        setFeedback('');
        if (lastFocus && typeof lastFocus.focus === 'function') {
            lastFocus.focus();
        }
    };

    openTriggers.forEach((trigger) => {
        trigger.addEventListener('click', openModal);
    });

    closeTriggers.forEach((trigger) => {
        trigger.addEventListener('click', closeModal);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && modal && !modal.hidden) {
            closeModal();
        }
    });

    if (form && answerInput) {
        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            setFeedback('');

            const answer = answerInput.value.trim();
            if (!answer) {
                setFeedback('Soon enough the secrets will be revealed');
                return;
            }

            if (submitButton) submitButton.disabled = true;

            try {
                const response = await fetch('showdown-gate.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ answer }),
                    cache: 'no-store',
                });

                const data = await response.json();

                if (data && data.ok === true && typeof data.redirect === 'string') {
                    window.location.assign(data.redirect);
                    return;
                }

                setFeedback(
                    (data && typeof data.message === 'string' && data.message)
                        || 'Soon enough the secrets will be revealed'
                );
            } catch (_error) {
                setFeedback('Soon enough the secrets will be revealed');
            } finally {
                if (submitButton) submitButton.disabled = false;
            }
        });
    }
})();
