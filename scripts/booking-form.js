document
  .getElementById("tennis-booking-form")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent the form from submitting immediately

    // AJAX request to check session status
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "db/check_session.php", true);
    xhr.onload = function () {
      if (this.status === 200) {
        const response = JSON.parse(xhr.responseText);
        if (response.loggedIn) {
          // User is logged in, proceed with form validation and submission
          validateAndSubmitForm(event); // Assume this is a function that handles form validation and submission
        } else {
          // User is not logged in, redirect to login page

          window.location.href = "login.php";
        }
      }
    };
    xhr.send();
  });

document.addEventListener("DOMContentLoaded", function () {
  fetchAvailableTimeSlots();
});
function fetchAvailableTimeSlots() {
  const facilityId = document.getElementById("facility").value;
  const bookingDate = document.getElementById("booking-date").value;

  if (facilityId && bookingDate) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "db/load_time_availability.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
      if (this.status == 200) {
        document.getElementById("time-duration").innerHTML = this.responseText;
      }
    };
    xhr.send("facilityId=" + facilityId + "&bookingDate=" + bookingDate);
  }
}

function validateAndSubmitForm(event) {
  // Existing form validation code
  const fields = [
    { id: "first-name", name: "First Name" },
    { id: "last-name", name: "Last Name" },
    {
      id: "email",
      name: "Email",
      pattern: /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/,
    },
    { id: "phone", name: "Phone Number", pattern: /^\d{10}$/ },
    { id: "booking-date", name: "Booking Date" },
    { id: "time-duration", name: "Time Duration" },
  ];

  let isValid = true;

  fields.forEach((field) => {
    const input = document.getElementById(field.id);
    const value = input.value.trim();
    const errorElement = document.getElementById(field.id + "-error");

    errorElement.textContent = "";

    if (!value) {
      errorElement.textContent = `Please enter your ${field.name}.`;
      isValid = false;
    } else if (field.pattern && !field.pattern.test(value)) {
      if (field.id === "email") {
        errorElement.textContent = `Please enter a valid Email (e.g., example@example.com).`;
      } else if (field.id === "phone") {
        errorElement.textContent = `Please enter a valid Phone Number (10 digits, e.g., 1234567890).`;
      } else {
        errorElement.textContent = `Please enter a valid ${field.name}.`;
      }
      isValid = false;
    }
  });

  const bookingDate = document.getElementById("booking-date").value;
  const today = new Date().toISOString().split("T")[0];
  if (bookingDate < today) {
    document.getElementById("booking-date-error").textContent =
      "Booking date cannot be in the past.";
    isValid = false;
  }

  if (isValid) {
    event.target.submit(); // Submit the form if everything is valid
  }
}
