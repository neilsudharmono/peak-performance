document
  .getElementById("contact-form")
  .addEventListener("submit", function (event) {
    const fields = [
      { id: "first-name", name: "First Name" },
      {
        id: "email",
        name: "Email",
        pattern: /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/,
      },
      { id: "enquiry", name: "Enquiry" },
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
        errorElement.textContent = `Please enter a valid ${field.name}.`;
        isValid = false;
      }
    });

    if (!isValid) {
      event.preventDefault();
    }
  });
