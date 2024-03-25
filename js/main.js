AOS.init({ once: true });

$(document).ready(() => {
  // Gestionnaire de clic pour le burger menu
  $(".navbar-burger").click(() => {
    $(".navbar-burger").toggleClass("is-active");
    $(".navbar-menu").toggleClass("is-active");
  });

  // Gestionnaire de clic pour le dropdown
  $(".has-dropdown").click(function (event) {
    // Empêche le menu déroulant de se fermer lorsque l'on clique dessus
    event.stopPropagation();
    $(this).toggleClass('is-active');
  });

  // Clic n'importe où pour fermer le dropdown
  $(document).click(function (e) {
    if (!$(e.target).closest('.has-dropdown').length) {
      $('.has-dropdown').removeClass('is-active');
    }
  });
});