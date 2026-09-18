/**
 * Project Explorer interactions: mobile product menu, archive browse drawer,
 * and a single destination scroll that clears the sticky header.
 * Theme switching remains in shared site.js.
 */
(() => {
  'use strict';

  const menuButton = document.querySelector('[data-product-nav-button]');
  const productNav = document.querySelector('[data-product-nav]');
  const desktopQuery = window.matchMedia('(min-width: 1024px)');
  const narrowQuery = window.matchMedia('(max-width: 1023px)');

  if ('scrollRestoration' in history) {
    history.scrollRestoration = 'manual';
  }

  const stickyOffset = () => {
    const header = document.querySelector('#site-header');
    return header ? Math.ceil(header.getBoundingClientRect().height) + 8 : 88;
  };

  const prefersReducedMotion = () =>
    window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  let scrollCorrectionAllowed = true;
  let pendingFrame = 0;
  let cancellationArmed = false;

  const stopAnimatedScroll = () => {
    const root = document.documentElement;
    const previous = root.style.scrollBehavior;
    root.style.scrollBehavior = 'auto';
    window.scrollTo(0, window.scrollY);
    root.style.scrollBehavior = previous;
  };

  const cancelScrollCorrection = () => {
    scrollCorrectionAllowed = false;
    if (pendingFrame) {
      window.cancelAnimationFrame(pendingFrame);
      pendingFrame = 0;
    }
  };

  const onUserScrollIntent = () => {
    if (!cancellationArmed || !scrollCorrectionAllowed) return;
    cancelScrollCorrection();
    stopAnimatedScroll();
  };

  const onScrollKey = (event) => {
    const keys = new Set([
      ' ',
      'Spacebar',
      'PageUp',
      'PageDown',
      'Home',
      'End',
      'ArrowUp',
      'ArrowDown',
    ]);
    if (keys.has(event.key)) onUserScrollIntent();
  };

  const armCancellation = () => {
    if (cancellationArmed) return;
    cancellationArmed = true;
    ['wheel', 'touchstart', 'pointerdown'].forEach((type) => {
      window.addEventListener(type, onUserScrollIntent, { passive: true, capture: true });
    });
    window.addEventListener('keydown', onScrollKey, { passive: true, capture: true });
  };

  const scrollToDestination = (id, { smooth = true } = {}) => {
    if (!id || !scrollCorrectionAllowed) return false;
    const target = document.getElementById(id);
    if (!target) return false;
    const top = Math.max(0, window.scrollY + target.getBoundingClientRect().top - stickyOffset());
    const useSmooth = smooth && !prefersReducedMotion();
    if (useSmooth) {
      window.scrollTo({ top, behavior: 'smooth' });
      return true;
    }
    // CSS `html { scroll-behavior: smooth }` makes behavior:"auto" animate in
    // Chromium. Force an instantaneous jump for load/reduced-motion settles.
    const root = document.documentElement;
    const previous = root.style.scrollBehavior;
    root.style.scrollBehavior = 'auto';
    window.scrollTo(0, top);
    root.style.scrollBehavior = previous;
    return true;
  };

  const navigateToHash = (id, { smooth = true } = {}) => {
    if (!id) return;
    scrollCorrectionAllowed = true;
    if (pendingFrame) {
      window.cancelAnimationFrame(pendingFrame);
      pendingFrame = 0;
    }
    pendingFrame = window.requestAnimationFrame(() => {
      pendingFrame = 0;
      scrollToDestination(id, { smooth });
    });
  };

  const syncVaultCurrent = () => {
    if (!productNav) return;
    const hash = (location.hash || '').replace(/^#/, '');
    const vaultLink = productNav.querySelector('[data-explorer-nav="vault"]');
    if (!vaultLink) return;
    if (hash === 'vault-overview') {
      productNav.querySelectorAll('a[aria-current="page"]').forEach((link) => {
        link.removeAttribute('aria-current');
      });
      vaultLink.setAttribute('aria-current', 'page');
      return;
    }
    if (vaultLink.getAttribute('aria-current') === 'page') {
      vaultLink.removeAttribute('aria-current');
      const params = new URLSearchParams(location.search);
      const view = params.get('view') || 'overview';
      const current = productNav.querySelector(`[data-explorer-nav="${view}"]`);
      if (current && current !== vaultLink) current.setAttribute('aria-current', 'page');
    }
  };

  const initialHash = (location.hash || '').replace(/^#/, '');
  if (initialHash) {
    // Remove the fragment before the browser can smooth-scroll to a stale
    // layout position. Restore it after our one-shot settle.
    const urlWithoutHash = location.href.split('#')[0];
    history.replaceState(null, '', urlWithoutHash);

    const settleInitial = () => {
      navigateToHash(initialHash, { smooth: false });
      history.replaceState(null, '', `${urlWithoutHash}#${initialHash}`);
      syncVaultCurrent();
      window.requestAnimationFrame(armCancellation);
    };
    if (document.readyState === 'complete') settleInitial();
    else window.addEventListener('load', settleInitial, { once: true });
  } else {
    armCancellation();
  }

  syncVaultCurrent();
  window.addEventListener('hashchange', () => {
    syncVaultCurrent();
    navigateToHash((location.hash || '').replace(/^#/, ''), { smooth: true });
  });

  if (menuButton && productNav) {
    const setMenuLabel = (open) => {
      menuButton.setAttribute('aria-label', open ? 'Close Project Explorer menu' : 'Open Project Explorer menu');
      const icon = menuButton.querySelector('[data-product-nav-icon]');
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
