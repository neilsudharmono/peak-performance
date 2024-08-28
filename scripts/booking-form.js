document
  .getElementById("tennis-booking-form")
  .addEventListener("submit", function (event) {
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
      { id: "time-from", name: "Time From" },
      { id: "time-to", name: "Time To" },
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
    const timeFrom = document.getElementById("time-from").value;
    const timeTo = document.getElementById("time-to").value;

    const today = new Date().toISOString().split("T")[0];
    if (bookingDate < today) {
      document.getElementById("booking-date-error").textContent =
        "Booking date cannot be in the past.";
      isValid = false;
    }

    if (timeTo <= timeFrom) {
      document.getElementById("time-to-error").textContent =
        "'Time To' must be greater than 'Time From'.";
      isValid = false;
    }

    if (!isValid) {
      event.preventDefault();
    }
  });
