(() => {
  const gallery = document.querySelector('[data-home-gallery]');

  if (!gallery) {
    return;
  }

  const items = [...gallery.querySelectorAll('[data-home-gallery-item]')];
  const lightbox = gallery.querySelector('[data-home-gallery-lightbox]');
  const image = gallery.querySelector('[data-home-gallery-image]');
  const video = gallery.querySelector('[data-home-gallery-video]');
  const closeButton = gallery.querySelector('[data-home-gallery-close]');
  const previousButton = gallery.querySelector('[data-home-gallery-previous]');
  const nextButton = gallery.querySelector('[data-home-gallery-next]');

  if (!items.length || !lightbox || !image || !video) {
    return;
  }

  let currentIndex = 0;
  let lastTrigger = null;

  const stopVideo = () => {
    video.pause();
    video.removeAttribute('src');
    video.load();
  };

  const showItem = (index) => {
    currentIndex = (index + items.length) % items.length;
    const item = items[currentIndex];
    const isVideo = item.dataset.mediaType === 'video';

    if (isVideo) {
      image.hidden = true;
      image.removeAttribute('src');
      image.alt = '';
      video.src = item.dataset.mediaUrl;
      video.hidden = false;
      video.load();
      return;
    }

    stopVideo();
    video.hidden = true;
    image.src = item.dataset.mediaUrl;
    image.alt = item.dataset.mediaAlt || '';
    image.hidden = false;
  };

  const openItem = (index, trigger) => {
    lastTrigger = trigger;
    showItem(index);

    if (!lightbox.open) {
      lightbox.showModal();
    }
  };

  items.forEach((item, index) => {
    item.addEventListener('click', () => openItem(index, item));
  });

  if (previousButton && nextButton) {
    const hasNavigation = items.length > 1;
    previousButton.hidden = !hasNavigation;
    nextButton.hidden = !hasNavigation;
    previousButton.addEventListener('click', () => showItem(currentIndex - 1));
    nextButton.addEventListener('click', () => showItem(currentIndex + 1));
  }

  closeButton?.addEventListener('click', () => lightbox.close());

  lightbox.addEventListener('click', (event) => {
    if (event.target === lightbox) {
      lightbox.close();
    }
  });

  lightbox.addEventListener('keydown', (event) => {
    if (items.length < 2) {
      return;
    }

    if (event.key === 'ArrowLeft') {
      event.preventDefault();
      showItem(currentIndex - 1);
    }

    if (event.key === 'ArrowRight') {
      event.preventDefault();
      showItem(currentIndex + 1);
    }
  });

  lightbox.addEventListener('close', () => {
    stopVideo();
    image.removeAttribute('src');
    image.alt = '';

    if (lastTrigger) {
      lastTrigger.focus();
    }
  });
})();
