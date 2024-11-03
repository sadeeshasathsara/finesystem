var cardDrop = document.getElementById("card-dropdown");
var activeDropdown;
cardDrop.addEventListener("click", function () {
  var node;
  for (var i = 0; i < this.childNodes.length - 1; i++)
    node = this.childNodes[i];
  if (node.className === "dropdown-select") {
    node.classList.add("visible");
    activeDropdown = node;
  }
});

window.onclick = function (e) {
  console.log(e.target.tagName);
  console.log("dropdown");
  console.log(activeDropdown);
  if (e.target.tagName === "LI" && activeDropdown) {
    if (e.target.innerHTML === "Master Card") {
      document.getElementById("credit-card-image").src =
        "https://dl.dropboxusercontent.com/s/2vbqk5lcpi7hjoc/MasterCard_Logo.svg.png";
      activeDropdown.classList.remove("visible");
      activeDropdown = null;
      e.target.innerHTML = document.getElementById("current-card").innerHTML;
      document.getElementById("current-card").innerHTML = "Master Card";
    } else if (e.target.innerHTML === "American Express") {
      document.getElementById("credit-card-image").src =
        "https://dl.dropboxusercontent.com/s/f5hyn6u05ktql8d/amex-icon-6902.png";
      activeDropdown.classList.remove("visible");
      activeDropdown = null;
      e.target.innerHTML = document.getElementById("current-card").innerHTML;
      document.getElementById("current-card").innerHTML = "American Express";
    } else if (e.target.innerHTML === "Visa") {
      document.getElementById("credit-card-image").src =
        "https://dl.dropboxusercontent.com/s/ubamyu6mzov5c80/visa_logo%20%281%29.png";
      activeDropdown.classList.remove("visible");
      activeDropdown = null;
      e.target.innerHTML = document.getElementById("current-card").innerHTML;
      document.getElementById("current-card").innerHTML = "Visa";
    }
  } else if (e.target.className !== "dropdown-btn" && activeDropdown) {
    activeDropdown.classList.remove("visible");
    activeDropdown = null;
  }
};

function validateCardNumber(cardNumber) {
  // Remove spaces for validation
  const cleaned = cardNumber.replace(/\s+/g, "");
  const isValid = /^\d{16}$/.test(cleaned);
  return isValid;
}

function validateExpiryDate(expiryDate) {
  const today = new Date();
  const [month, year] = expiryDate.split("/").map((num) => parseInt(num, 10));
  const isValidFormat = /^\d{2}\/\d{2}$/.test(expiryDate);
  const expiryDateObj = new Date(`20${year}`, month - 1); // Assuming year is in 'YY' format
  const withinRange =
    expiryDateObj > today &&
    expiryDateObj < new Date(today.getFullYear() + 5, 11, 31);
  return isValidFormat && withinRange;
}

function validateCVC(cvc) {
  return /^\d{3}$/.test(cvc);
}

function validateAndPay() {
  const cardNumber = document.getElementById("cardNumberInput").value;
  const expiryDate = document.getElementById("expiryDateInput").value;
  const cvc = document.getElementById("cvvInput").value;

  let isValid = true;

  // Clear previous errors
  document.getElementById("cardNumberError").textContent = "";
  document.getElementById("expiryDateError").textContent = "";
  document.getElementById("cvvError").textContent = "";

  // Validate Card Number
  if (!validateCardNumber(cardNumber)) {
    document.getElementById("cardNumberError").textContent =
      "Card number must be 16 digits long, with spaces after every four digits.";
    isValid = false;
  }

  // Validate Expiry Date
  if (!validateExpiryDate(expiryDate)) {
    document.getElementById("expiryDateError").textContent =
      "Expiry date must be in MM/YY format and within the next five years.";
    isValid = false;
  }

  // Validate CVC
  if (!validateCVC(cvc)) {
    document.getElementById("cvvError").textContent =
      "CVC must be 3 digits long.";
    isValid = false;
  }

  // Proceed to payment if all validations pass
  if (isValid) {
    redirectToSuccessPage();
  }
}
