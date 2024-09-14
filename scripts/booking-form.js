let isSubmitting = false;

document
  .getElementById("tennis-booking-form")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent the form from submitting immediately

    if (isSubmitting) return; // Prevent further submissions if the form is already submitting

    isSubmitting = true;

    // AJAX request to check session status
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "db/check_session.php", true);
    xhr.onload = function () {
      if (this.status === 200) {
        const response = JSON.parse(xhr.responseText);
        if (response.loggedIn) {
          // User is logged in, proceed with form validation and submission
          // validateAndSubmitForm(event); // Add actual form submission code here
        } else {
          // User is not logged in, redirect to login page
          window.location.href = "login.php";
        }
      }

      isSubmitting = false; // Reset the flag once the request completes
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
