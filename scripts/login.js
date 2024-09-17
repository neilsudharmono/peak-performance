// Sign-up form validation
document
  .getElementById("sign-up-form")
  ?.addEventListener("submit", function (event) {
    validateForm(event, "sign-up");
  });

function validateForm(event, formType) {
  let isValid = true;

  // Clear existing error messages
  document
    .querySelectorAll(".error-message")
    .forEach((error) => (error.textContent = ""));

  const emailField = document.getElementById("email");
  const emailPattern = /^[^@]+@[^@]+\.[^@]+$/;

  // Email validation
  if (!emailField.value) {
    document.getElementById("email-error").textContent =
      "Your email is required.";
    isValid = false;
  } else if (!emailPattern.test(emailField.value)) {
    document.getElementById("email-error").textContent =
      "Please enter a valid email (e.g., example@example.com).";
    isValid = false;
  }

  // Password validation for both login and sign-up
  const passwordField = document.getElementById("password");
  if (!passwordField.value) {
    document.getElementById("password-error").textContent =
      "Password is required.";
    isValid = false;
  }

  // Sign-up specific validations
  if (formType === "sign-up") {
    const firstNameField = document.getElementById("first-name");
    const lastNameField = document.getElementById("last-name");
    const phoneField = document.getElementById("phone");
    const phonePattern = /^[0-9]{10}$/;
    const retypePasswordField = document.getElementById("retype-password");
    const passwordPattern = /^(?=.*[A-Z])(?=.*[!@#$%^&*])(?=.{8,})/;
    const namePattern = /^[A-Za-z]+$/; // Only letters, no spaces, numbers, or special characters

    // First name validation
    if (!firstNameField.value) {
      document.getElementById("first-name-error").textContent =
        "Please enter your first name.";
      isValid = false;
    } else if (!namePattern.test(firstNameField.value)) {
      document.getElementById("first-name-error").textContent =
        "First name cannot contain spaces, numbers, or special characters.";
      isValid = false;
    }

    // Last name validation
    if (!lastNameField.value) {
      document.getElementById("last-name-error").textContent =
        "Please enter your last name.";
      isValid = false;
    } else if (!namePattern.test(lastNameField.value)) {
      document.getElementById("last-name-error").textContent =
        "Last name cannot contain spaces, numbers, or special characters.";
      isValid = false;
    }

    // Phone validation
    if (!phoneField.value) {
      document.getElementById("phone-error").textContent =
        "Your contact number is required.";
      isValid = false;
    } else if (!phonePattern.test(phoneField.value)) {
      document.getElementById("phone-error").textContent =
        "Please enter a valid 10-digit contact number.";
      isValid = false;
    }

    // Password validation
    if (!passwordPattern.test(passwordField.value)) {
      document.getElementById("password-error").textContent =
        "Password must be at least 8 characters, contain at least one capital letter, and one special character.";
      isValid = false;
    }

    // Retype password validation
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

  // If form is not valid, prevent submission
  if (!isValid) {
    event.preventDefault();
  }
}

// Password reset form validation
document
  .getElementById("password-reset-form")
  ?.addEventListener("submit", function (event) {
    let isValid = true;

    // Clear previous error messages
    document.querySelectorAll(".error-message").forEach(function (error) {
      error.textContent = "";
    });

    const newPassword = document.getElementById("new-password").value;
    const confirmPassword = document.getElementById("confirm-password").value;

    // Password validation: at least 8 characters, one uppercase letter, and one special character
    const passwordPattern = /^(?=.*[A-Z])(?=.*[!@#$%^&*])(?=.{8,})/;
    if (!passwordPattern.test(newPassword)) {
      document.getElementById("password-error").textContent =
        "Password must be at least 8 characters, contain at least one capital letter, and one special character.";
      isValid = false;
    }

    // Check if passwords match
    if (newPassword !== confirmPassword) {
      document.getElementById("confirm-password-error").textContent =
        "Passwords do not match.";
      isValid = false;
    }

    // Prevent form submission if the form is invalid
    if (!isValid) {
      event.preventDefault();
    }
  });
