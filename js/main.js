AOS.init({ once: true });
const form = document.querySelector('form');
const errorDiv = document.getElementById("-messages");
urlParams = new URLSearchParams(window.location.search);

const setMessage = (message, color) => {
  errorDiv.textContent = message;
  errorDiv.style.color = color;
};

const handleFormSubmit = event => {
  event.preventDefault();

  // Get the form data
  const formData = new FormData(form);

  // Send the form data to the PHP script using AJAX
  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'contact.php');
  xhr.onload = function () {
    if (xhr.status === 200) {
      // Parse the JSON response
      const response = JSON.parse(xhr.responseText);

      // Display the success or error message
      if (response.success) {
        setMessage(response.success, "green");
      } else {
        setMessage(response.error, "red");
      }
    } else {
      alert('An error occurred. Please try again.');
    }
  };
  xhr.send(formData);
};

const handleNavbarBurgerClick = () => {
  // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
  $(".navbar-burger").toggleClass("is-active");
  $(".navbar-menu").toggleClass("is-active");
};

const handleHasDropdownClick = () => {
  // Toggle the "is-active" class on the "navbar-menu"
  $(".has-dropdown").toggleClass("is-active");
};

const handleAnchorClick = e => {
  e.preventDefault();

  document.querySelector(e.target.getAttribute('href')).scrollIntoView({
    behavior: 'smooth'
  });
};

const handleTopLinkClick = e => {
  e.preventDefault();
  $('body, html').scrollTop(0, {
    behavior: 'smooth'
  });
};

$(document).ready(() => {
  // Check for click events on the navbar burger icon
  $(".navbar-burger").click(handleNavbarBurgerClick);

  // Check for click events on the navbar burger icon
  $(".has-dropdown").click(handleHasDropdownClick);
});

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', handleAnchorClick);
});

$('a[href="#top"]').on('click', handleTopLinkClick);

const errorMessage = urlParams.get("error");
const successMessage = urlParams.get("success");

if (errorMessage) {
  setMessage(errorMessage, "red");
}

if (successMessage) {
  setMessage(successMessage, "green");
}

form.addEventListener('submit', handleFormSubmit);