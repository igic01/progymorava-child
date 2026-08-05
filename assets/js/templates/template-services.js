(() => {
  const modal = document.querySelector('.pg-coach-modal');

  if (modal) {
    const image = modal.querySelector('.pg-coach-modal__image');
    const name = modal.querySelector('#coach-modal-name');
    const role = modal.querySelector('#coach-modal-role');
    const text = modal.querySelector('#coach-modal-text');
    const specialty = modal.querySelector('#coach-modal-specialty');
    const gallery = modal.querySelector('#coach-modal-gallery');
    const photos = modal.querySelector('#coach-modal-photos');

    document.querySelectorAll('[data-coach-card]').forEach((card) => {
      card.addEventListener('click', () => {
        const cardImage = card.querySelector('img');
        const profile = card.querySelector('[data-coach-profile]');
        const galleryImages = [...card.querySelectorAll('[data-coach-gallery]')];

        image.src = cardImage.src;
        image.alt = cardImage.alt;
        name.textContent = card.querySelector('.pg-coach-card__name').textContent;
        role.textContent = profile.dataset.role;
        text.textContent = profile.dataset.bio;
        specialty.textContent = profile.dataset.specialty;
        photos.replaceChildren();
        gallery.hidden = galleryImages.length === 0;

        galleryImages.forEach((source, index) => {
          if (source.tagName === 'VIDEO') {
            const video = source.cloneNode();
            video.controls = true;
            video.className = 'pg-coach-modal__video';
            photos.append(video);
            return;
          }
          const button = document.createElement('button');
          const galleryImage = source.cloneNode();
          button.type = 'button';
          button.className = 'pg-coach-modal__photo';
          button.setAttribute('aria-label', `Zoom photo ${index + 1} of ${name.textContent}`);
          button.append(galleryImage);
          button.addEventListener('click', () => button.classList.toggle('is-zoomed'));
          photos.append(button);
        });

        modal.showModal();
      });
    });

    modal.querySelector('.pg-coach-modal__close').addEventListener('click', () => modal.close());
    modal.addEventListener('click', (event) => { if (event.target === modal) modal.close(); });
  }

})();
