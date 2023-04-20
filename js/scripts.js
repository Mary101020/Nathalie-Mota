document.addEventListener("DOMContentLoaded", function(event) { 


  // Récupérez les boutons pour ouvrir la modale
  var btn1 = document.getElementById("myBtn");
  var btn2 = document.getElementById("myOtherBtn");

  // Récupérez l'élément de la modale
  var modal = document.getElementById("modal");

  // Récupérez l'élément <span> qui ferme la modale
  var span = document.getElementsByClassName("close")[0];

  // Lorsque l'utilisateur clique sur le premier bouton, ouvrez la modale
  btn1.onclick = function() {
    modal.style.display = "block";
  }

  // Lorsque l'utilisateur clique sur le second bouton, ouvrez la modale
  btn2.onclick = function() {
    modal.style.display = "block";
    var photoRef = this.getAttribute("data-photo-ref");

    // Pré-remplissez le champ "Réf. Photo"
    var refField = modal.querySelector("#reference");
    refField.getAttribute('data-photo-ref') = photoRef;
  }

  // Lorsque l'utilisateur clique en dehors de la modale, fermez-la
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
});



const previousPostLink = document.querySelector('.previous-post');
const nextPostLink = document.querySelector('.next-post');
const thumbnailContainer = document.querySelector('.thumbnail-container');
const thumbnails = thumbnailContainer ? thumbnailContainer.querySelectorAll('.thumbnail') : null;
const thumbnailImage = document.querySelector('.thumbnail-preview');

function getThumbnailUrl(postUrl) {
  const thumbnail = thumbnailContainer ? thumbnailContainer.querySelector(`img[data-photo="${postUrl}"]`) : null;
  if (thumbnail && thumbnail.getAttribute('src')) {
    return thumbnail.getAttribute('src');
  }
  return null;
}

previousPostLink.addEventListener('mouseover', function(event) {
    const previousPostUrl = event.currentTarget.getAttribute('href');
    const previousThumbnailUrl = getThumbnailUrl(previousPostUrl);
    if (previousThumbnailUrl) {
      thumbnailImage.src = previousThumbnailUrl;
    }
});

nextPostLink.addEventListener('mouseover', function(event) {
    const nextPostUrl = event.currentTarget.getAttribute('href');
    const nextThumbnailUrl = getThumbnailUrl(nextPostUrl);
    if (nextThumbnailUrl) {
      thumbnailImage.src = nextThumbnailUrl;
    }
});
