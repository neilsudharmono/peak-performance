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
