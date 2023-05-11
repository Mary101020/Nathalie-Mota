// Function to close the lightbox
function closeLightbox() {
    // Remove the lightbox overlay
    var overlay = document.querySelector('.lightbox-overlay');
    overlay.parentNode.removeChild(overlay);
  }
  
  function openLightbox(photoUrl) {
    //console.log(photoUrl);
    // Create the overlay
    var overlay = document.createElement('div');
    overlay.classList.add('lightbox-overlay');
    document.body.appendChild(overlay);
  
    // Create the modal container
    var modal = document.createElement('div');
    modal.classList.add('lightbox-modal');
    overlay.appendChild(modal);
  
    // Create the photo
    var photo = document.createElement('img');
    photo.src = photoUrl;
    photo.classList.add('lightbox-photo');
    modal.appendChild(photo);
  
    // Create the info and interaction area
    var info = document.createElement('div');
    info.classList.add('lightbox-info');
    modal.appendChild(info);
  
    // Create the close button
    var closeBtn = document.createElement('button');
    closeBtn.classList.add('lightbox-close');
    closeBtn.innerHTML = 'X';
    closeBtn.addEventListener('click', closeLightbox);
    info.appendChild(closeBtn);
  
    function nextPhoto() {
      // Get the current photo element
      var currentPhoto = document.querySelector('.lightbox-photo');
  
      // Get the next photo element
      var nextPhoto = currentPhoto.nextElementSibling;
      //console.log(nextPhoto.src);
  
      // If there is no next photo, go back to the first photo
      if (!nextPhoto) {
        nextPhoto = currentPhoto.parentNode.firstElementChild;
      }
  
      // Update the source of the photo element in the lightbox
      currentPhoto.src = nextPhoto.src;
    }
  
    // Create the next navigation button
    var nextBtn = document.createElement('button');
    nextBtn.classList.add('lightbox-next');
    nextBtn.innerHTML = '&#x2192;';
    nextBtn.addEventListener('click', nextPhoto);
    info.appendChild(nextBtn);
  
    function prevPhoto() {
      // Get the current photo element
      var currentPhoto = document.querySelector('.lightbox-photo');
  
      // Get the previous photo element
      var prevPhoto = currentPhoto.previousElementSibling;
  
      // If there is no previous photo, go to the last photo
      if (!prevPhoto) {
        prevPhoto = currentPhoto.parentNode.lastElementChild;
      }
  
      // Update the source of the photo element in the lightbox
      currentPhoto.src = prevPhoto.src;
    }
  
    // Create the previous navigation button
    var prevBtn = document.createElement('button');
    prevBtn.classList.add('lightbox-prev');
    prevBtn.innerHTML = '&#x2190;';
    prevBtn.addEventListener('click', prevPhoto);
    info.appendChild(prevBtn);
  }
  
  jQuery(document).ready(function($) {
    // Click handler for fullscreen trigger
    $('.fullscreen-trigger').on('click', function(e) {
      e.preventDefault();
      var photoUrl = $(this).closest('.image-grid-item').find('.img-post').attr('src');
      openLightbox(photoUrl);
    });
  });
  