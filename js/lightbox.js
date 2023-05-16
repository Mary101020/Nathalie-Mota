class Lightbox {
  constructor() {
    this.images = [];
    this.url = null;
    this.element = this.buildDOM();
    document.body.appendChild(this.element);

    const fullscreenTriggers = document.querySelectorAll('.fullscreen-trigger');
    fullscreenTriggers.forEach(trigger => {
      trigger.addEventListener('click', (e) => {
        e.preventDefault();
        const imgPost = trigger.closest('.image-grid-item').querySelector('.img-post');
        if (imgPost) {
          const photoUrl = imgPost.getAttribute('src');
          this.loadImage(photoUrl);
          this.show();
        }
      });
    });

    const closeButton = this.element.querySelector('.lightbox-close');
    closeButton.addEventListener('click', this.close.bind(this));
  }

  /**
   * @param {string} url URL of the image
   * @return {HTMLElement}
   */
  buildDOM(url) {
    const dom = document.createElement('div');
    dom.setAttribute('id', 'lightbox-container');

    const overlay = document.createElement('div');
    overlay.classList.add('lightbox-overlay');
    dom.appendChild(overlay);

    const modal = document.createElement('div');
    modal.classList.add('lightbox-modal');
    overlay.appendChild(modal);

    const closeButton = document.createElement('button');
    closeButton.classList.add('lightbox-close');
    closeButton.innerHTML = '&times;';
    modal.appendChild(closeButton);

    const nextButton = document.createElement('button');
    nextButton.classList.add('lightbox-next');
    nextButton.innerHTML = '&#x2192;';
    nextButton.addEventListener('click', this.next.bind(this));
    modal.appendChild(nextButton);

    const prevButton = document.createElement('button');
    prevButton.classList.add('lightbox-prev');
    prevButton.innerHTML = '&#x2190;';
    prevButton.addEventListener('click', this.prev.bind(this));
    modal.appendChild(prevButton);

    const photo = document.createElement('img');
    photo.classList.add('lightbox-photo');
    modal.appendChild(photo);

    return dom;
  }

  show() {
    const overlay = this.element.querySelector('.lightbox-overlay');
    overlay.style.display = 'block';
  }

  hide() {
    const overlay = this.element.querySelector('.lightbox-overlay');
    overlay.style.display = 'none';
  }

  loadImage(url) {
    this.url = null;
    const image = new Image();
    const photo = this.element.querySelector('.lightbox-photo');
    const loader = document.createElement('div');
    loader.classList.add('lightbox-loader');
    photo.parentNode.insertBefore(loader, photo);
    photo.style.display = 'none';
    image.onload = () => {
      loader.parentNode.removeChild(loader);
      photo.src = url;
      photo.style.display = 'block';
      this.url = url;
    };
    image.src = url;
  }

  /**
   * @param {MouseEvent|KeyboardEvent} e
   */
  next(e) {
    e.preventDefault();
    let i = this.images.findIndex(image => image === this.url);
    if (i === this.images.length - 1) {
      i = -1;
    }
    this.loadImage(this.images[i + 1]);
  }

  /**
   * @param {MouseEvent|KeyboardEvent} e
   */
 

  prev(e) {
    e.preventDefault();
    let i = this.images.findIndex(image => image === this.url);
    if (i === 0) {
      i = this.images.length;
    }
    this.loadImage(this.images[i - 1]);
  }

  close() {
    const overlay = this.element.querySelector('.lightbox-overlay');
    overlay.style.display = 'none';
    this.url = null;
  }
  
}

// Example usage
const lightbox = new Lightbox();
const imageElements = document.querySelectorAll('.img-post');
imageElements.forEach(element => {
  const imageUrl = element.getAttribute('src');
  lightbox.images.push(imageUrl);
});
