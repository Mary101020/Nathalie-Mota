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



// Find all thumbnail images with a data-photo attribute
const thumbnails = document.querySelectorAll('.thumbnail[data-photo]');

// For each thumbnail image
thumbnails.forEach(thumbnail => {
    // Get the URL of the corresponding photo
    const photoUrl = thumbnail.dataset.photo;

    // When the mouse hovers over the thumbnail
    thumbnail.addEventListener('mouseover', () => {
        // Set the src attribute of the thumbnail to the photo URL
        thumbnail.src = photoUrl;
    });

    // When the mouse leaves the thumbnail
    thumbnail.addEventListener('mouseout', () => {
        // Reset the src attribute of the thumbnail to the thumbnail URL
        thumbnail.src = thumbnail.dataset.thumbnail;
    });
});

