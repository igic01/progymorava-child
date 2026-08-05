(() => {
  'use strict';

  const header = document.querySelector('[data-site-header]');

  if (!header) {
    return;
  }

  const toggle = header.querySelector('[data-site-menu-toggle]');
  const menu = header.querySelector('[data-site-menu]');
  const mobileViewport = window.matchMedia('(max-width: 820px)');

  if (!toggle || !menu) {
    return;
  }

  const setMenuState = (open, returnFocus = false) => {
    const isOpen = mobileViewport.matches && open;

    header.classList.toggle('is-menu-open', isOpen);
    toggle.setAttribute('aria-expanded', String(isOpen));
    toggle.setAttribute('aria-label', isOpen ? 'Zavrieť menu' : 'Otvoriť menu');

    if (mobileViewport.matches) {
      menu.setAttribute('aria-hidden', String(!isOpen));
      menu.inert = !isOpen;
    } else {
      menu.removeAttribute('aria-hidden');
      menu.inert = false;
    }

    if (returnFocus) {
      toggle.focus();
    }
  };

  toggle.addEventListener('click', () => {
    setMenuState(toggle.getAttribute('aria-expanded') !== 'true');
  });

  menu.addEventListener('click', (event) => {
    if (event.target.closest('a')) {
      setMenuState(false);
    }
  });

  document.addEventListener('click', (event) => {
    if (header.classList.contains('is-menu-open') && !header.contains(event.target)) {
      setMenuState(false);
    }
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && header.classList.contains('is-menu-open')) {
      setMenuState(false, true);
    }
  });

  if (typeof mobileViewport.addEventListener === 'function') {
    mobileViewport.addEventListener('change', () => setMenuState(false));
  } else {
    mobileViewport.addListener(() => setMenuState(false));
  }

  setMenuState(false);
})();
