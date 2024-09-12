document
  .getElementById("login-form")
  ?.addEventListener("submit", function (event) {
    validateForm(event, "login");
  });

document
  .getElementById("forgot-password-form")
  ?.addEventListener("submit", function (event) {
    validateForm(event, "forgot-password");
  });

document
  .getElementById("sign-up-form")
  ?.addEventListener("submit", function (event) {
    validateForm(event, "sign-up");
  });

function validateForm(event, formType) {
  let isValid = true;

  document
    .querySelectorAll(".error-message")
    .forEach((error) => (error.textContent = ""));

  const emailField = document.getElementById("email");
  const emailPattern = /^[^@]+@[^@]+\.[^@]+$/;

  if (!emailField.value) {
    document.getElementById("email-error").textContent =
      "Your email is required.";
    isValid = false;
  } else if (!emailPattern.test(emailField.value)) {
    document.getElementById("email-error").textContent =
      "Please enter a valid Email (e.g., example@example.com).";
    isValid = false;
  }

  if (formType === "login" || formType === "sign-up") {
    const passwordField = document.getElementById("password");

    if (!passwordField.value) {
      document.getElementById("password-error").textContent =
        "Password is required.";
      isValid = false;
    }
  }

  if (formType === "sign-up") {
    const firstNameField = document.getElementById("first-name");
    if (!firstNameField.value) {
      document.getElementById("first-name-error").textContent =
        "Please enter your first name.";
      isValid = false;
    }

    const lastNameField = document.getElementById("last-name");
    if (!lastNameField.value) {
      document.getElementById("last-name-error").textContent =
        "Please enter your last name.";
      isValid = false;
    }

    const phoneField = document.getElementById("phone");
    const phonePattern = /^[0-9]{10}$/;
    if (!phoneField.value) {
      document.getElementById("phone-error").textContent =
        "Your contact number is required.";
      isValid = false;
    } else if (!phonePattern.test(phoneField.value)) {
      document.getElementById("phone-error").textContent =
        "Please enter a valid 10-digit contact number.";
      isValid = false;
    }

    const passwordField = document.getElementById("password");
    const passwordPattern = /^(?=.*[A-Z])(?=.*[!@#$%^&*])(?=.{8,})/;

    if (!passwordPattern.test(passwordField.value)) {
      document.getElementById("password-error").textContent =
        "Password must be at least 8 characters, contain at least one capital letter and one special character.";
      isValid = false;
    }

    const retypePasswordField = document.getElementById("retype-password");
    if (!retypePasswordField.value) {
      document.getElementById("retype-password-error").textContent =
        "Please retype your password.";
      isValid = false;
    } else if (passwordField.value !== retypePasswordField.value) {
      document.getElementById("retype-password-error").textContent =
        "Passwords do not match.";
      isValid = false;
    }
  }

  if (!isValid) {
    event.preventDefault();
  }
}
