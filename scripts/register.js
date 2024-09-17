document.addEventListener("DOMContentLoaded", function () {
  const emailButton = document.getElementById("check-email-button");
  const emailField = document.getElementById("email");
  const emailStatus = document.getElementById("email-status");
  const form = document.getElementById("sign-up-form");
  const securityQuestionField = document.getElementById("security-question");
  const securityAnswerField = document.getElementById("security-answer");
  const securityQuestionError = document.getElementById(
    "security-question-error",
  );
  const securityAnswerError = document.getElementById("security-answer-error");

  const passwordField = document.getElementById("password");
  const retypePasswordField = document.getElementById("retype-password");
  const passwordError = document.getElementById("password-error");
  const retypePasswordError = document.getElementById("retype-password-error");

  let emailExists = false;
  let emailChecked = false;

  // AJAX check email
  emailButton.addEventListener("click", function () {
    const email = emailField.value.trim();
    if (!/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/.test(email)) {
      emailStatus.textContent = "Invalid email format.";
      emailStatus.classList.add("error");
      return;
    }
    emailChecked = false;
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        if (xhr.responseText === "exists") {
          emailStatus.textContent = "This email is already registered.";
          emailStatus.classList.remove("success");
          emailStatus.classList.add("error");
          emailExists = true; // email duplicatied
        } else {
          emailStatus.textContent = "This email is available.";
          emailStatus.classList.remove("error");
          emailStatus.classList.add("success");
          emailExists = false; // email NOT duplicatied
        }
        emailChecked = true;
      }
    };
    xhr.send("checkEmail=true&email=" + encodeURIComponent(email));
  });

  form.addEventListener("submit", function (event) {
    let isValid = true;

    // check email
    if (emailExists) {
      event.preventDefault();
      emailStatus.textContent = "This email is already registered.";
      return;
    }

    // password check
    const passwordPattern = /^(?=.*[A-Z])(?=.*[!@#$%^&*])(?=.*[0-9])(?=.{8,})/;
    if (!passwordField.value) {
      passwordError.textContent = "Password is required.";
      isValid = false;
    } else if (!passwordPattern.test(passwordField.value)) {
      passwordError.textContent =
        "Password must be at least 8 characters, contain one uppercase letter, one number, and one special character.";
      isValid = false;
    } else {
      passwordError.textContent = "";
    }

    // retypepassword check
    if (!retypePasswordField.value) {
      retypePasswordError.textContent = "Please retype your password.";
      isValid = false;
    } else if (passwordField.value !== retypePasswordField.value) {
      retypePasswordError.textContent = "Passwords do not match.";
      isValid = false;
    } else {
      retypePasswordError.textContent = "";
    }

    // security question check
    if (!securityQuestionField.value) {
      securityQuestionError.textContent = "Please select a security question.";
      isValid = false;
    } else {
      securityQuestionError.textContent = "";
    }

    // security answer check
    if (!securityAnswerField.value.trim()) {
      securityAnswerError.textContent = "Please enter your security answer.";
      isValid = false;
    } else if (!/^[A-Za-z0-9]+$/.test(securityAnswerField.value)) {
      securityAnswerError.textContent =
        "Security answer cannot contain special characters.";
      isValid = false;
    } else {
      securityAnswerError.textContent = "";
    }

    if (!isValid) {
      event.preventDefault();
    }
  });
});
