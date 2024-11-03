document.addEventListener("DOMContentLoaded", function () {
  function validateField(field) {
    const error = document.getElementById(field.id + "_error");

    if (!field.value.trim()) {
      field.style.border = "2px solid red";
      if (error) {
        error.textContent = "This field is required.";
        error.style.color = "red";
      }
    } else {
      field.style.border = "";
      if (error) {
        error.textContent = "";
      }
    }
  }

  function setupFormValidation(form) {
    const fields = form.querySelectorAll(
      "input[required], select[required], textarea[required]"
    );

    fields.forEach(function (field, index) {
      field.addEventListener("blur", function () {
        validateField(field);
        if (index > 0) {
          validateField(fields[index - 1]);
        }
      });
    });

    form.addEventListener("submit", function (event) {
      let isValid = true;

      fields.forEach(function (field) {
        validateField(field);
        if (!field.value.trim()) {
          isValid = false;
        }
      });

      if (!isValid) {
        event.preventDefault();
      }
    });
  }

  document.querySelectorAll("form").forEach(function (form) {
    setupFormValidation(form);
  });
});
