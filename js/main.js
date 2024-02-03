AOS.init({ once: true });
const form = document.querySelector('form');
const errorDiv = document.getElementById("error-messages"); // Assurez-vous que cet ID correspond à un élément dans votre HTML.

const setMessage = (message, color) => {
  errorDiv.textContent = message;
  errorDiv.style.color = color;
};

const clearFormFields = () => {
  form.reset(); // Cette fonction efface tous les champs du formulaire.
};

const handleFormSubmit = event => {
  event.preventDefault();

  const formData = new FormData();
  formData.append('name', form.name.value);
  formData.append('surname', form.surname.value);
  formData.append('email', form.email.value);
  formData.append('besoin', form.besoin.value);

  fetch('contact_form.php', {
    method: 'POST',
    body: formData,
  })
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(data => {
      if (data.success) {
        setMessage(data.success, "green");
        clearFormFields(); // Efface les champs du formulaire si l'envoi est un succès.
      } else {
        setMessage(data.error, "red");
      }
    })
    .catch((error) => {
      console.error('Error:', error);
      alert('An error occurred. Please try again.');
    });
};

const handleNavbarBurgerClick = () => {
  $(".navbar-burger").toggleClass("is-active");
  $(".navbar-menu").toggleClass("is-active");
};

$(document).ready(() => {
  $(".navbar-burger").click(handleNavbarBurgerClick);
  $(".has-dropdown").click(handleHasDropdownClick);
});

const errorMessage = urlParams.get("error");
const successMessage = urlParams.get("success");

if (errorMessage) {
  setMessage(errorMessage, "red");
}

if (successMessage) {
  setMessage(successMessage, "green");
}

form.addEventListener('submit', handleFormSubmit);
