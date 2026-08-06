(() => {
  'use strict';

  const cookieHasKey = (key) => {
    const encodedKey = `${encodeURIComponent(key)}=`;
    return document.cookie.split('; ').some((cookie) => cookie.startsWith(encodedKey));
  };

  const hasBeenDismissed = (key) => {
    try {
      if (window.localStorage.getItem(key) === '1') {
        return true;
      }
    } catch (error) {
      // The cookie fallback below still remembers the visitor.
    }

    return cookieHasKey(key);
  };

  const rememberAsDismissed = (key) => {
    try {
      window.localStorage.setItem(key, '1');
    } catch (error) {
      // Some privacy modes block localStorage; the cookie is a safe fallback.
    }

    document.cookie = `${encodeURIComponent(key)}=1; max-age=31536000; path=/; SameSite=Lax`;
  };

  const initialisePopup = (layer) => {
    const popup = layer.querySelector('.pg-app-popup');
    const closeButton = layer.querySelector('[data-pg-app-popup-close]');
    const downloadButton = layer.querySelector('[data-pg-app-download]');
    const storageKey = layer.dataset.storageKey || 'progymorava_app_popup_dismissed_v2';

    if (!popup || !closeButton || !downloadButton) {
      layer.remove();
      return;
    }

    if (hasBeenDismissed(storageKey)) {
      layer.remove();
      return;
    }

    const appleUrl = downloadButton.dataset.appleUrl;
    const googleUrl = downloadButton.dataset.googleUrl;
    const isAppleDevice = /iPad|iPhone|iPod|Macintosh/i.test(window.navigator.userAgent);

    downloadButton.href = isAppleDevice && appleUrl ? appleUrl : googleUrl;

    const closePopup = () => {
      rememberAsDismissed(storageKey);
      layer.classList.remove('is-open');
      layer.setAttribute('aria-hidden', 'true');
      document.body.classList.remove('pg-app-popup-open');
      layer.remove();
    };

    const keepFocusInside = (event) => {
      if (event.key !== 'Tab') {
        return;
      }

      const focusable = Array.from(
        popup.querySelectorAll('a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])')
      );

      if (!focusable.length) {
        return;
      }

      const first = focusable[0];
      const last = focusable[focusable.length - 1];

      if (event.shiftKey && document.activeElement === first) {
        event.preventDefault();
        last.focus();
      } else if (!event.shiftKey && document.activeElement === last) {
        event.preventDefault();
        first.focus();
      }
    };

    closeButton.addEventListener('click', closePopup);
    layer.addEventListener('click', (event) => {
      if (event.target === layer) {
        closePopup();
      }
    });
    layer.addEventListener('keydown', (event) => {
      if (event.key === 'Escape') {
        closePopup();
        return;
      }

      keepFocusInside(event);
    });

    layer.hidden = false;
    layer.setAttribute('aria-hidden', 'false');
    document.body.classList.add('pg-app-popup-open');

    window.requestAnimationFrame(() => {
      layer.classList.add('is-open');
      closeButton.focus();
    });
  };

  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-pg-app-popup]').forEach(initialisePopup);
  });
})();
