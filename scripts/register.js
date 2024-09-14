document
  .getElementById("check-email-button")
  .addEventListener("click", function () {
    var email = document.getElementById("email").value;
    var emailStatus = document.getElementById("email-status");

    // Email format validation
    var emailPattern = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;
    if (!emailPattern.test(email)) {
      emailStatus.textContent = "Invalid email format.";
      emailStatus.classList.remove("success");
      emailStatus.classList.add("error");
      return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "", true); // '' indicates the current PHP file
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        if (xhr.responseText === "exists") {
          emailStatus.textContent = "This email is already registered.";
          emailStatus.classList.remove("success");
          emailStatus.classList.add("error");
        } else {
          emailStatus.textContent = "This email is available.";
          emailStatus.classList.remove("error");
          emailStatus.classList.add("success");
        }
      }
    };

    xhr.send("checkEmail=true&email=" + encodeURIComponent(email));
  });
document
  .getElementById("sign-up-form")
  .addEventListener("submit", function (event) {
    // Get all form fields
    var firstName = document.getElementById("first-name").value.trim();
    var lastName = document.getElementById("last-name").value.trim();
    var email = document.getElementById("email").value.trim();
    var password = document.getElementById("password").value.trim();
    var retypePassword = document
      .getElementById("retype-password")
      .value.trim();
    var phone = document.getElementById("phone").value.trim();

    var missingFields = [];

    // Check if each field is filled
    if (!firstName) missingFields.push("First Name");
    if (!lastName) missingFields.push("Last Name");
    if (!email) missingFields.push("Email");
    if (!password) missingFields.push("Password");
    if (!retypePassword) missingFields.push("Retype Password");
    if (!phone) missingFields.push("Phone Number");

    if (missingFields.length > 0) {
      // If there are missing fields, show an alert
      event.preventDefault(); // Prevent form submission
      alert(
        "Please fill out the following fields: " + missingFields.join(", "),
      );
    } else if (password !== retypePassword) {
      // Passwords do not match
      event.preventDefault(); // Prevent form submission
      alert("Passwords do not match. Please try again.");
    }
  });

document
  .getElementById("update-user-form")
  ?.addEventListener("submit", function (event) {
    let isValid = true;

    // Clear existing error messages
    document
      .querySelectorAll(".error-message")
      .forEach((error) => (error.textContent = ""));

    const firstName = document.getElementById("first-name").value.trim();
    const lastName = document.getElementById("last-name").value.trim();
    const phone = document.getElementById("phone").value.trim();
    const newPassword = document.getElementById("new-password").value.trim();
    const confirmPassword = document
      .getElementById("confirm-new-password")
      .value.trim();
    const currentPassword = document
      .getElementById("current-password")
      .value.trim();

    // Name validation (ensure no special characters)
    const namePattern = /^[a-zA-Z\s]+$/;

    if (!namePattern.test(firstName)) {
      document.getElementById("first-name-error").textContent =
        "First name must contain only letters and spaces.";
      isValid = false;
    }

    if (!namePattern.test(lastName)) {
      document.getElementById("last-name-error").textContent =
        "Last name must contain only letters and spaces.";
      isValid = false;
    }

    // Phone number validation (must be exactly 10 digits)
    const phonePattern = /^[0-9]{10}$/;

    if (!phonePattern.test(phone)) {
      document.getElementById("phone-error").textContent =
        "Phone number must be a valid 10-digit number.";
      isValid = false;
    }

    // Password validation (if changing password)
    const passwordPattern = /^(?=.*[A-Z])(?=.*[!@#$%^&*])(?=.*[0-9])(?=.{8,})/;

    if (newPassword !== "" || confirmPassword !== "") {
      if (!passwordPattern.test(newPassword)) {
        document.getElementById("new-password-error").textContent =
          "Password must be at least 8 characters, contain one uppercase letter, one number, and one special character.";
        isValid = false;
      }

      if (newPassword !== confirmPassword) {
        document.getElementById("confirm-new-password-error").textContent =
          "Passwords do not match.";
        isValid = false;
      }

      if (!currentPassword) {
        document.getElementById("current-password-error").textContent =
          "Please enter your current password to change the password.";
        isValid = false;
      }
    }

    // Prevent form submission if validation fails
    if (!isValid) {
      event.preventDefault();
    }
  });
