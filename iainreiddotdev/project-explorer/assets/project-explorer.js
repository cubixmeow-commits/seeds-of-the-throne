/**
 * Project Explorer interactions: mobile product menu, archive browse drawer,
 * and destination scrolling that clears the sticky header.
 * Theme switching remains in shared site.js.
 */
(() => {
  'use strict';

  const menuButton = document.querySelector('[data-product-nav-button]');
  const productNav = document.querySelector('[data-product-nav]');
  const desktopQuery = window.matchMedia('(min-width: 1024px)');
  const narrowQuery = window.matchMedia('(max-width: 1023px)');

  const stickyOffset = () => {
    const header = document.querySelector('#site-header');
    return header ? Math.ceil(header.getBoundingClientRect().height) + 8 : 88;
  };

  const scrollToDestination = (id) => {
    if (!id) return;
    const target = document.getElementById(id);
    if (!target) return;
    const top = window.scrollY + target.getBoundingClientRect().top - stickyOffset();
    window.scrollTo({ top: Math.max(0, top), behavior: 'auto' });
  };

  const settleDestination = (id) => {
    if (!id) return;
    let attempts = 0;
    const run = () => {
      scrollToDestination(id);
      attempts += 1;
      const target = document.getElementById(id);
      if (!target || attempts >= 12) return;
      const top = target.getBoundingClientRect().top;
      const offset = stickyOffset();
      if (top < offset - 2 || top > offset + 120) {
        window.requestAnimationFrame(run);
      }
    };
    run();
  };

  const initialHash = (location.hash || '').replace(/^#/, '');
  if (initialHash) {
    settleDestination(initialHash);
    window.addEventListener('load', () => {
      settleDestination(initialHash);
      window.setTimeout(() => settleDestination(initialHash), 120);
    }, { once: true });
  }

  if (menuButton && productNav) {
    const setMenuLabel = (open) => {
      menuButton.setAttribute('aria-label', open ? 'Close Project Explorer menu' : 'Open Project Explorer menu');
      const icon = menuButton.querySelector('[aria-hidden="true"]');
      if (icon) icon.textContent = open ? '✕' : '☰';
    };

    const closeMenu = ({ restoreFocus = false } = {}) => {
      if (menuButton.getAttribute('aria-expanded') !== 'true') return;
      menuButton.setAttribute('aria-expanded', 'false');
      productNav.removeAttribute('data-open');
      setMenuLabel(false);
      if (restoreFocus) menuButton.focus();
    };

    const openMenu = () => {
      menuButton.setAttribute('aria-expanded', 'true');
      productNav.setAttribute('data-open', '');
      setMenuLabel(true);
      const firstLink = productNav.querySelector('a');
      if (firstLink) firstLink.focus();
    };

    menuButton.addEventListener('click', () => {
      const open = menuButton.getAttribute('aria-expanded') === 'true';
      if (open) closeMenu();
      else openMenu();
    });

    productNav.addEventListener('click', (event) => {
      if (event.target.closest('a')) closeMenu();
    });

    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape' && menuButton.getAttribute('aria-expanded') === 'true') {
        closeMenu({ restoreFocus: true });
      }
    });

    const syncDesktop = (event) => {
      if (event.matches) closeMenu();
    };
    if (typeof desktopQuery.addEventListener === 'function') {
      desktopQuery.addEventListener('change', syncDesktop);
    } else if (typeof desktopQuery.addListener === 'function') {
      desktopQuery.addListener(syncDesktop);
    }
  }

  const shell = document.querySelector('[data-archive-shell]');
  if (!shell) return;

  const openButton = shell.querySelector('[data-archive-open]');
  const panel = shell.querySelector('[data-archive-panel]');
  const closeControls = shell.querySelectorAll('[data-archive-close]');
  const documentTarget = shell.querySelector('#archive-document');

  if (!openButton || !panel) return;

  const setBrowseState = (open) => {
    shell.classList.toggle('is-browsing', open);
    openButton.setAttribute('aria-expanded', String(open));
    panel.toggleAttribute('data-open', open);
    if (open) {
      const focusTarget = panel.querySelector('input, button, a, summary');
      if (focusTarget) focusTarget.focus();
    } else if (documentTarget) {
      documentTarget.focus({ preventScroll: true });
    }
  };

  openButton.addEventListener('click', () => {
    setBrowseState(openButton.getAttribute('aria-expanded') !== 'true');
  });

  closeControls.forEach((control) => {
    control.addEventListener('click', () => setBrowseState(false));
  });

  panel.addEventListener('click', (event) => {
    if (!narrowQuery.matches) return;
    if (event.target.closest('.explorer-tree__file a, .explorer-results a')) {
      setBrowseState(false);
    }
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && shell.classList.contains('is-browsing') && narrowQuery.matches) {
      setBrowseState(false);
      openButton.focus();
    }
  });

  const syncBrowse = (event) => {
    if (!event.matches) setBrowseState(false);
  };
  if (typeof narrowQuery.addEventListener === 'function') {
    narrowQuery.addEventListener('change', syncBrowse);
  } else if (typeof narrowQuery.addListener === 'function') {
    narrowQuery.addListener(syncBrowse);
  }

  if (documentTarget && !documentTarget.hasAttribute('tabindex')) {
    documentTarget.setAttribute('tabindex', '-1');
  }
})();
