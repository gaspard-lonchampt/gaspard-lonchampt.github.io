AOS.init({ once: true });

$(window).scroll(function () {
  $("#show").toggleClass(
    "is-fixed-top is-transparent",
    $(this).scrollTop() > 600
  );
});

$(document).ready(function() {

  // Check for click events on the navbar burger icon
  $(".navbar-burger").click(function() {

      // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
      $(".navbar-burger").toggleClass("is-active");
      $(".navbar-menu").toggleClass("is-active");

  });

    // Check for click events on the navbar burger icon
    $(".has-dropdown").click(function() {

      // Toggle the "is-active" class on the "navbar-menu"
      $(".has-dropdown").toggleClass("is-active");

  });
});

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
      e.preventDefault();

      document.querySelector(this.getAttribute('href')).scrollIntoView({
          behavior: 'smooth'
      });
  });
});

$('a[href="#top"]').on('click', function(e) {
  e.preventDefault();
  $('body, html').scrollTop(0, {
    behavior: 'smooth'
});
});

