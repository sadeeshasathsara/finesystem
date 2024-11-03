// JavaScript to handle opening and closing the popup
document.addEventListener("DOMContentLoaded", function () {
  const openPopupBtn = document.getElementById("open-popup");
  const popupContainer = document.getElementById("popupContainer");
  const closeBtn = document.querySelector(".close-btn");

  // Open popup when button is clicked
  openPopupBtn.addEventListener("click", function () {
    popupContainer.style.display = "flex";
  });

  // Close popup when close button is clicked
  closeBtn.addEventListener("click", function () {
    popupContainer.style.display = "none";
  });

  // Close popup when clicking outside the popup content
  window.addEventListener("click", function (event) {
    if (event.target === popupContainer) {
      popupContainer.style.display = "none";
    }
  });

  function showFines(pid) {
    var finesPopup = document.getElementById("finesPopup");
    var tableBody = document.getElementById("finesTableBody");

    // Fetch fines data via AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../app/fines.php?pid=" + pid, true);
    xhr.onload = function () {
      if (xhr.status === 200) {
        var data = JSON.parse(xhr.responseText);
        tableBody.innerHTML = "";

        data.forEach(function (fine) {
          var row = document.createElement("tr");
          var nameCell = document.createElement("td");
          var priceCell = document.createElement("td");

          nameCell.textContent = fine.fine_name;
          priceCell.textContent = fine.fine_price;

          row.appendChild(nameCell);
          row.appendChild(priceCell);
          tableBody.appendChild(row);
        });

        finesPopup.style.display = "flex";
      }
    };
    xhr.send();
  }

  // Attach event listeners to show fines buttons
  document.querySelectorAll(".show-fines-btn").forEach(function (button) {
    button.addEventListener("click", function () {
      var pid = this.id; // Assuming button ID is the penalty ID
      showFines(pid);
    });
  });

  // Close the popup when the close button is clicked
  document
    .querySelector(".fines-popup .close-btn")
    .addEventListener("click", closeFinesPopup);
});
