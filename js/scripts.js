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


jQuery(document).ready(function($) {
  var page = 2; // The current page of posts
  var postsPerPage = 10; // The number of posts to display per page
  var container = $('#post-container'); // The container for the posts
  var button = $('#load-more'); // The "Load More" button

  button.on('click', function() {
      var data = {
          'action': 'load_posts',
          'page': page,
          'posts_per_page': postsPerPage
      };
      $.ajax({
          url: ajaxurl,
          type: 'POST',
          data: data,
          beforeSend: function() {
              button.text('Loading...'); // Change the button text while the posts are loading
          },
          success: function(response) {
              if (response) {
                  container.append(response); // Append the new posts to the container
                  button.text('Load More'); // Change the button text back to "Load More"
                  page++; // Increment the page counter
              } else {
                  button.hide(); // Hide the button if there are no more posts to load
              }
          }
      });
  });
});







