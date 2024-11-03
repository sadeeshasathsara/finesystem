// script.js

document.addEventListener("DOMContentLoaded", () => {
  // Example: Smooth scrolling to sections
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault();

      document.querySelector(this.getAttribute("href")).scrollIntoView({
        behavior: "smooth",
      });
    });
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const navbarToggle = document.getElementById("navbar-toggle");
  const navbarMenu = document.querySelector(".navbar-menu");

  navbarToggle.addEventListener("click", () => {
    navbarMenu.classList.toggle("active");
    navbarToggle.classList.toggle("active");
  });
});

// script.js
