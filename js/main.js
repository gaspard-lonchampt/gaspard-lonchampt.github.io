AOS.init({ once: true }); 

$(document).ready(() => {
  // Votre code existant pour le burger menu et le dropdown
  $(".navbar-burger").click(() => {
    $(".navbar-burger").toggleClass("is-active");
    $(".navbar-menu").toggleClass("is-active");
  });

  $(".has-dropdown").click(function (event) {
    event.stopPropagation();
    $(this).toggleClass('is-active');
  });

  $(document).click(function (e) {
    if (!$(e.target).closest('.has-dropdown').length) {
      $('.has-dropdown').removeClass('is-active');
    }
  });

  // Ajout de la gestion AJAX pour le formulaire de contact
  $('#contact-form').submit(function (e) {
    e.preventDefault();

    const form = $(this);
    const formMessages = $('#form-messages');
    const formData = new FormData(this);

    fetch('contact_form.php', {
      method: 'POST',
      body: formData
    })
      .then(response => response.text())
      .then(text => {
        formMessages.html(text);
        if (!text.includes("Erreur")) {
          form.trigger("reset"); // Réinitialiser le formulaire en cas de succès
        }
      })
      .catch(error => {
        formMessages.html('Erreur lors de l\'envoi du formulaire : ' + error.message);
      });
  });
});