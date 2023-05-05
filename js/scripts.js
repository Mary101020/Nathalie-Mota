document.addEventListener("DOMContentLoaded", function (event) {
  // Récupérez les boutons pour ouvrir la modale
  var btn1 = document.getElementById("myBtn");
  var btn2 = document.getElementById("myBtn2");
  var btn3 = document.getElementById("myBtn1");

  // Récupérez l'élément de la modale
  var modal = document.getElementById("modal");

  // Récupérez l'élément <span> qui ferme la modale
  var span = document.getElementsByClassName("close")[0];

  // Lorsque l'utilisateur clique sur le premier bouton, ouvrez la modale
  btn1.onclick = function () {
    modal.style.display = "block";
  }

  // Lorsque l'utilisateur clique sur le second bouton, ouvrez la modale
  if (btn2) {
  btn2.onclick = function () {
    modal.style.display = "block";
    var photoRef = this.getAttribute("data-photo-ref");
    // console.log(photoRef);

    // Pré-remplissez le champ "Réf. Photo"
    var refField = modal.querySelector(".photo-ref");
    refField.value= photoRef;
    console.log(refField.value);
    //  refField.setAttribute("data-photo-ref",photoRef);
  }}

  // Lorsque l'utilisateur clique sur le troisième bouton, ouvrez la modale
  btn3.onclick = function () {
    modal.style.display = "block";
  }

  // Lorsque l'utilisateur clique en dehors de la modale, fermez-la
  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
});

var ajaxurl = 'http://nathalie-mota.local/wp-admin/admin-ajax.php';

jQuery(function($) {
  $('#load-more-btn').on('click', function() {
      var page = $(this).data('page');
      

      
      $.ajax({
          type: 'POST',
          url: ajaxurl,
          data: {
              action: 'load_more_posts',
              page: page
          },
          beforeSend: function() {
              // Add a loading indicator here
          },
          success: function(response) {
              $('#post-container').append(response);
              $('#load-more-btn').data('page', parseInt(page) + 1);
          },
          complete: function() {
              // Remove the loading indicator here
          }
      });

      
  });
});

jQuery(document).ready(function($) {
  var ajaxurl = 'http://nathalie-mota.local/wp-admin/admin-ajax.php';

  function sort_posts(order) {
    $.ajax({
      url: ajaxurl,
      type: 'POST',
      dataType: 'json',
      data: {
        action: 'get_images_by_date',
        order: order
      },
      success: function(data) {
        if (data.html) {
          $('.image-grid').replaceWith(data.html);
        }
      },
      error: function() {
        console.log('Error while getting images');
      }
    });
  }

  $(document).on('change', '#sort-posts', function() {
    var order = $(this).val();
    sort_posts(order);
  });
});




