document.addEventListener("DOMContentLoaded", function () {
  var departmentInput = document.getElementById("edit-department");
  var suggestionsList = document.getElementById("suggestions-list");
  var errorMessage = document.getElementById("error-message");

  if (!departmentInput || !suggestionsList || !errorMessage) {
    console.error("One or more elements are missing.");
    return;
  }

  departmentInput.addEventListener("input", function () {
    var query = this.value;

    if (query.length < 3) {
      suggestionsList.style.display = "none";
      errorMessage.style.display = "none";
      return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open(
      "GET",
      "../app/suggest_department.php?q=" + encodeURIComponent(query),
      true
    );
    xhr.onload = function () {
      if (xhr.status >= 200 && xhr.status < 400) {
        var suggestions = JSON.parse(xhr.responseText);
        suggestionsList.innerHTML = "";

        if (suggestions.length > 0) {
          suggestions.forEach(function (department) {
            var li = document.createElement("li");
            li.textContent = department;
            li.onclick = function () {
              departmentInput.value = department;
              suggestionsList.style.display = "none";
            };
            suggestionsList.appendChild(li);
          });
          suggestionsList.style.display = "block";
          errorMessage.style.display = "none";
        } else {
          suggestionsList.style.display = "none";
          errorMessage.style.display = "none";
        }
      } else {
        errorMessage.textContent = "Error fetching data. Please try again.";
        errorMessage.style.display = "block";
        suggestionsList.style.display = "none";
      }
    };
    xhr.onerror = function () {
      errorMessage.textContent =
        "Network error. Please check your connection and try again.";
      errorMessage.style.display = "block";
      suggestionsList.style.display = "none";
    };
    xhr.send();
  });
});
