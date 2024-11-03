function validateLicenseNumber() {
  const licenseNumberInput = document.getElementById("license-number-input");
  const licenseNumber = licenseNumberInput.value.trim();
  return licenseNumber.startsWith("B");
}

function validateNICNumber() {
  const nicInput = document.getElementById("nic-input");
  const nic = nicInput.value.trim();
  const nicPattern1 = /^[0-9]{9}v$/i; // NIC with 'v'
  const nicPattern2 = /^[0-9]{12}$/; // NIC without 'v'
  return nicPattern1.test(nic) || nicPattern2.test(nic);
}

function validatePhoneNumber() {
  const phoneNumberInput = document.getElementById("phone-number-input");
  const phoneNumber = phoneNumberInput.value.trim();
  const phonePattern = /^[0-9]{10}$/;
  return phonePattern.test(phoneNumber);
}

function validatePasswords() {
  const passwordInput = document.getElementById("password-input");
  const confirmPasswordInput = document.getElementById(
    "confirm-password-input"
  );
  const password = passwordInput.value.trim();
  const confirmPassword = confirmPasswordInput.value.trim();

  const lengthPattern = /^.{8,16}$/; // Length between 8 and 16 characters
  const uppercasePattern = /[A-Z]/; // At least one uppercase letter
  const lowercasePattern = /[a-z]/; // At least one lowercase letter
  const numericPattern = /[0-9]/; // At least one numeric digit
  const symbolPattern = /[\W_]/; // At least one special symbol

  const validLength = lengthPattern.test(password);
  const hasUppercase = uppercasePattern.test(password);
  const hasLowercase = lowercasePattern.test(password);
  const hasNumeric = numericPattern.test(password);
  const hasSymbol = symbolPattern.test(password);

  let errorMessage = "";

  if (!validLength) {
    errorMessage += "Password must be between 8 and 16 characters. ";
  }
  if (!hasUppercase) {
    errorMessage += "Password must include at least one uppercase letter. ";
  }
  if (!hasLowercase) {
    errorMessage += "Password must include at least one lowercase letter. ";
  }
  if (!hasNumeric) {
    errorMessage += "Password must include at least one number. ";
  }
  if (!hasSymbol) {
    errorMessage += "Password must include at least one special character. ";
  }
  if (password !== "" && password !== confirmPassword) {
    errorMessage += "Passwords do not match. ";
  }

  return errorMessage;
}

function validateForm(event) {
  event.preventDefault();

  let isValid = true;

  const licenseError = document.getElementById("license-error");
  const nicError = document.getElementById("nic-error");
  const phoneError = document.getElementById("phone-error");
  const passwordError = document.getElementById("password-error");

  licenseError.textContent = "";
  nicError.textContent = "";
  phoneError.textContent = "";
  passwordError.textContent = "";

  if (!validateLicenseNumber()) {
    licenseError.textContent = "License number must start with the letter B.";
    isValid = false;
  }

  if (!validateNICNumber()) {
    nicError.textContent =
      "NIC number must be 9 digits followed by 'v' or 12 numeric characters.";
    isValid = false;
  }

  if (!validatePhoneNumber()) {
    phoneError.textContent = "Phone number must be 10 numeric characters.";
    isValid = false;
  }

  const passwordValidationMessage = validatePasswords();
  if (passwordValidationMessage) {
    passwordError.textContent = passwordValidationMessage;
    isValid = false;
  }

  const fields = [
    "license-number-input",
    "nic-input",
    "phone-number-input",
    "password-input",
    "confirm-password-input",
  ];
  fields.forEach((field) => {
    const input = document.getElementById(field);
    if (input.value.trim() === "") {
      document.getElementById(field + "-error").textContent =
        "This field must be filled.";
      isValid = false;
    }
  });

  if (isValid) {
    // document.querySelector("#sign-up-form").method = "POST";
    // document.querySelector("#sign-up-form").action = "app/sign_up.php";
    document.querySelector("#sign-up-form").submit();
  }
}

document.addEventListener("DOMContentLoaded", () => {
  const signUpBtn = document.getElementById("sign-up-btn");
  signUpBtn.addEventListener("click", validateForm);
});
