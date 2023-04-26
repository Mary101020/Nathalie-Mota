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







