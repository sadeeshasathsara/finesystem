document.addEventListener("DOMContentLoaded", function () {
  var contentButton = document.querySelector(".content__button a");
  var popup = document.getElementById("content_update");
  var closeButton = document.querySelector(".popup__close");

  contentButton.addEventListener("click", function (e) {
    e.preventDefault(); // Prevent the default link action
    popup.style.display = "block"; // Show the popup
  });

  closeButton.addEventListener("click", function () {
    popup.style.display = "none"; // Hide the popup
  });

  // Close the popup when clicking outside of the content area
  window.addEventListener("click", function (e) {
    if (e.target === popup) {
      popup.style.display = "none"; // Hide the popup
    }
  });

  document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("edit-officer-form");

    form.addEventListener("submit", function (event) {
      let isValid = true;
      const errors = [];

      // Get form field values
      const policeId = document.getElementById("edit-police-id").value.trim();
      const department = document
        .getElementById("edit-department")
        .value.trim();
      const dob = document.getElementById("edit-dob").value;
      const address = document.getElementById("edit-address").value.trim();
      const mobile = document.getElementById("edit-mobile").value.trim();

      // Clear previous errors
      document.querySelectorAll(".error").forEach((error) => error.remove());

      // Validate Police ID if it's provided
      if (policeId && !/^P/.test(policeId)) {
        isValid = false;
        errors.push({
          field: "edit-police-id",
          message: 'Police ID must begin with "P".',
        });
      }

      // Validate Date of Birth if it's provided
      if (dob) {
        const birthDate = new Date(dob);
        const today = new Date();
        const age = today.getFullYear() - birthDate.getFullYear();
        const m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
          age--;
        }
        if (age < 20) {
          isValid = false;
          errors.push({
            field: "edit-dob",
            message: "Date of Birth should indicate at least 20 years old.",
          });
        }
      }

      // Validate Mobile Number if it's provided
      if (mobile && !/^\d{10}$/.test(mobile)) {
        isValid = false;
        errors.push({
          field: "edit-mobile",
          message: "Mobile number should contain exactly 10 digits.",
        });
      }

      // Display errors if validation fails
      if (!isValid) {
        errors.forEach((error) => {
          const field = document.getElementById(error.field);
          const errorMsg = document.createElement("div");
          errorMsg.className = "error";
          errorMsg.textContent = error.message;
          field.parentNode.appendChild(errorMsg);
        });
        event.preventDefault(); // Prevent form submission
      }
    });
  });
});
