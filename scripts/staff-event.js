document
  .getElementById("event-form")
  .addEventListener("submit", function (event) {
    const fields = [
      { id: "event-name", name: "Event Name" },
      { id: "event-date", name: "Event Date" },
      { id: "start-time", name: "Start Time" },
      { id: "end-time", name: "End Time" },
      { id: "location", name: "Location" },
      { id: "category", name: "Category" },
      { id: "description", name: "Description" },
      { id: "event-image", name: "Event Image" }, // New field for file upload
    ];

    let isValid = true;
    console.log("Form submit triggered");
    const currentImage = document.getElementById("current-image");

    fields.forEach((field) => {
      const input = document.getElementById(field.id);
      const value = input.value.trim();
      const errorElement = document.getElementById(field.id + "-error");

      errorElement.textContent = "";
      console.log(value);
      if (field.id === "event-image") {
        // Only validate file upload in create mode (when currentImage is null or empty)
        if (!currentImage || currentImage.value.trim() === "") {
          if (!input.files || input.files.length === 0) {
            errorElement.textContent = `Please upload ${field.name}.`;
            isValid = false;
          }
        }
      } else {
        if (!value) {
          errorElement.textContent = `Please enter your ${field.name}.`;
          isValid = false;
        }
      }
    });
    console.log("Form submit triggered");

    if (!isValid) {
      event.preventDefault();
    }
  });
