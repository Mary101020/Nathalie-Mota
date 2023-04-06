// Récupérez le bouton ou le lien pour ouvrir la modale
var btn = document.getElementById("myBtn");

// Récupérez l'élément de la modale
var modal = document.getElementById("modal");

// Récupérez l'élément <span> qui ferme la modale
var span = document.getElementsByClassName("close")[0];

// Lorsque l'utilisateur clique sur le bouton, ouvrez la modale
btn.onclick = function() {
  modal.style.display = "block";
}

// Lorsque l'utilisateur clique sur <span> (x), fermez la modale
span.onclick = function() {
  modal.style.display = "none";
}

// Lorsque l'utilisateur clique en dehors de la modale, fermez-la
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
