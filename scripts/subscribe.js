document
  .querySelector(".subscribe-form")
  .addEventListener("submit", function (event) {
    const emailField = document.querySelector(
      ".subscribe-form input[type='email']"
    );
    const emailError = emailField.nextElementSibling;

    emailError.textContent = "";

    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    const emailValue = emailField.value.trim();

    if (!emailValue) {
      emailError.textContent = "Please enter your Email.";
      emailField.focus();
      event.preventDefault();
    } else if (!emailPattern.test(emailValue)) {
      emailError.textContent =
        "Please enter a valid Email (e.g., example@example.com).";
      emailField.focus();
      event.preventDefault();
    }
  });
