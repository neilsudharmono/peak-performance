document.addEventListener("DOMContentLoaded", function () {
  const eventsPerPage = 6;
  let currentPage = 1;
  let currentCategory = "EVENTS"; // Set default to "EVENTS"
  let allEvents = [];
  let filteredEvents = [];
  let allBookings = [];
  let filteredBookings = [];

  // Fetch events data from the server
  fetch("db/fetch_member_event.php")
    .then((response) => response.json())
    .then((events) => {
      allEvents = events; // Store the fetched events
      filteredEvents = allEvents; // Initially, show all events
      filterEvents(); // Initially filter and display events
    })
    .catch((error) => console.error("Error fetching events:", error));

  fetch("db/fetch_member_booking.php")
    .then((response) => response.json())
    .then((bookings) => {
      allBookings = bookings; // Store the fetched bookings
      filteredBookings = allBookings; // Initially, show all bookings
    })
    .catch((error) => console.error("Error fetching bookings:", error));

  function getTotalPagesEvents() {
    return Math.ceil(filteredEvents.length / eventsPerPage);
  }

  function getTotalPagesBookings() {
    return Math.ceil(filteredBookings.length / eventsPerPage);
  }

  function filterEvents() {
    if (currentCategory === "EVENTS") {
      // Filter to show events only
      filteredEvents = allEvents;
      currentPage = 1;
      renderEvents();
      renderPaginationEvent();
    } else if (currentCategory === "BOOKINGS") {
      filteredBookings = allBookings;
      // Filter to show bookings only
      currentPage = 1;
      renderBookings();
      renderPaginationBooking();
      return; // Exit to prevent rendering events
    }
  }

  function filterEventsByCategory(category) {
    currentCategory = category;

    filterEvents();
  }

  function renderEvents() {
    const container = document.getElementById("filtered-event-tiles-container");
    container.innerHTML = "";

    const start = (currentPage - 1) * eventsPerPage;
    const end = start + eventsPerPage;
    const eventsToShow = filteredEvents.slice(start, end);

    if (eventsToShow.length === 0) {
      // If no events to show, display the "No result" message
      const noResultMessage = document.createElement("div");
      noResultMessage.classList.add("no-result-message");
      noResultMessage.textContent = "You have not registered to any events.";
      container.appendChild(noResultMessage);
      return; // Exit the function
    }

    const promises = eventsToShow.map((event) => {
      return checkUserRegistration(event.eventID).then((userRegistered) => {
        const eventTile = document.createElement("div");
        eventTile.classList.add("filtered-event-tile");

        eventTile.innerHTML = `
        <div class="category-tag">${event.category}</div>
        <img src="${event.imgSrc}" alt="${event.title}" />
        <div class="filtered-event-info">
            <h4 class="event-date">${new Date(
              event.date
            ).toLocaleDateString()}</h4>
            <h3 class="event-title">${event.title}</h3>
            <p>${event.description}</p>
            <a href="#" class="event-cta" data-event-id="${
              event.registrationID
            }">
                ${
                  userRegistered ? "Unregister from Event" : "Register to Event"
                }
            </a>
        </div>
      `;
        return eventTile;
      });
    });

    Promise.all(promises).then((eventTiles) => {
      eventTiles.forEach((eventTile) => {
        container.appendChild(eventTile);
      });
    });
    setTimeout(() => {
      document.querySelectorAll(".event-cta").forEach((button) => {
        button.addEventListener("click", function (e) {
          e.preventDefault();
          const registrationID = this.getAttribute("data-event-id");

          unregisterEvent(registrationID); // Call the unregister function
        });
      });
    }, 500); // Adjust timeout as needed based on the async call timing
  }

  function renderBookings() {
    const container = document.getElementById("filtered-event-tiles-container");
    container.innerHTML = "";

    const start = (currentPage - 1) * eventsPerPage;
    const end = start + eventsPerPage;
    const bookingsToShow = filteredBookings.slice(start, end);

    if (bookingsToShow.length === 0) {
      const noResultMessage = document.createElement("div");
      noResultMessage.classList.add("no-result-message");
      noResultMessage.textContent = "You have no current bookings.";
      container.appendChild(noResultMessage);
      return;
    }

    bookingsToShow.forEach((booking) => {
      const bookingTile = document.createElement("div");
      bookingTile.classList.add("filtered-event-tile");

      bookingTile.innerHTML = `
        <div class="category-tag">${booking.facilityType}</div>
        <img src="${booking.imgSrc}" alt="${booking.facilityName}" />
        <div class="filtered-event-info">
            <h4 class="event-date">${new Date(
              booking.bookingDate
            ).toLocaleDateString()}</h4>
            <h3 class="event-title">${booking.facilityName}</h3>
            <p>${booking.timeDuration}</p>
            <a href="#" class="event-cta" data-booking-id="${
              booking.bookingID
            }">
                Cancel your booking
            </a>
        </div>
      `;
      container.appendChild(bookingTile);
    });

    // Add event listeners for unregister buttons
    document.querySelectorAll(".event-cta").forEach((button) => {
      button.addEventListener("click", function (e) {
        e.preventDefault();
        const bookingID = this.getAttribute("data-booking-id");
        unregisterBooking(bookingID); // Call the unregister function
      });
    });
  }

  function renderPaginationEvent() {
    const paginationContainer = document.getElementById("pagination");
    paginationContainer.innerHTML = "";

    const totalPages = getTotalPagesEvents();

    const prevButton = createArrowButton(
      "prevPage",
      "img/left-arrow.png",
      currentPage === 1,
      function () {
        if (currentPage > 1) {
          currentPage--;
          renderEvents();
          renderPaginationEvent();
        }
      }
    );
    paginationContainer.appendChild(prevButton);

    for (let i = 1; i <= totalPages; i++) {
      const pageButton = document.createElement("a");
      pageButton.href = "#";
      pageButton.classList.add("page");
      if (i === currentPage) pageButton.classList.add("active");
      pageButton.textContent = i;
      pageButton.addEventListener("click", function (e) {
        e.preventDefault();
        currentPage = i;
        renderEvents();
        renderPaginationEvent();
      });
      paginationContainer.appendChild(pageButton);
    }

    const nextButton = createArrowButton(
      "nextPage",
      "img/right-arrow.png",
      currentPage === totalPages,
      function () {
        if (currentPage < totalPages) {
          currentPage++;
          renderEvents();
          renderPaginationEvent();
        }
      }
    );
    paginationContainer.appendChild(nextButton);
  }

  function renderPaginationBooking() {
    const paginationContainer = document.getElementById("pagination");
    paginationContainer.innerHTML = "";

    const totalPages = getTotalPagesBookings();

    const prevButton = createArrowButton(
      "prevPage",
      "img/left-arrow.png",
      currentPage === 1,
      function () {
        if (currentPage > 1) {
          currentPage--;
          renderBookings();
          renderPaginationBooking();
        }
      }
    );
    paginationContainer.appendChild(prevButton);

    for (let i = 1; i <= totalPages; i++) {
      const pageButton = document.createElement("a");
      pageButton.href = "#";
      pageButton.classList.add("page");
      if (i === currentPage) pageButton.classList.add("active");
      pageButton.textContent = i;
      pageButton.addEventListener("click", function (e) {
        e.preventDefault();
        currentPage = i;
        renderBookings();
        renderPaginationBooking();
      });
      paginationContainer.appendChild(pageButton);
    }

    const nextButton = createArrowButton(
      "nextPage",
      "img/right-arrow.png",
      currentPage === totalPages,
      function () {
        if (currentPage < totalPages) {
          currentPage++;
          renderBookings();
          renderPaginationBooking();
        }
      }
    );
    paginationContainer.appendChild(nextButton);
  }

  function setupCategoryFilter() {
    const categoryButtons = document.querySelectorAll(".filter-button");
    categoryButtons.forEach((button) => {
      button.addEventListener("click", function () {
        categoryButtons.forEach((btn) => btn.classList.remove("active"));
        this.classList.add("active");
        const selectedCategory = this.getAttribute("data-category");

        if (selectedCategory === "EVENTS") {
          filterEventsByCategory("EVENTS");
        } else if (selectedCategory === "BOOKINGS") {
          filterEventsByCategory("BOOKINGS");
        }
      });
    });
  }

  function createArrowButton(id, imgSrc, isDisabled, onClick) {
    const button = document.createElement("button");
    button.id = id;
    button.classList.add("arrow");
    if (isDisabled) {
      button.disabled = true;
      button.style.opacity = 0.5;
    }

    const img = document.createElement("img");
    img.src = imgSrc;
    img.alt = id;

    button.appendChild(img);

    button.addEventListener("click", onClick);

    return button;
  }

  function checkUserRegistration(eventID) {
    // URL to your PHP script that checks registration status
    const url = "db/check_event_registration.php";

    // Return a promise to handle asynchronous operation
    return fetch(url, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ eventID }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          return data.isRegistered; // This should be true or false based on registration status
        } else {
          console.error("Error checking registration status:", data.message);
          return false;
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        return false;
      });
  }

  function unregisterEvent(registrationID) {
    // Show confirmation dialog
    const confirmation = confirm(
      "Are you sure you want to unregister from this event?"
    );

    // If the user confirms, proceed with the unregister operation
    if (confirmation) {
      console.log("Unregistering event with ID:", registrationID); // Debugging log

      fetch("db/unregister_event.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ registrationID }),
      })
        .then((response) => response.json())
        .then((data) => {
          console.log("Response from server:", data); // Debugging log

          if (data.success) {
            showModal("Successfully unregistered from the event!");
          } else {
            alert("Failed to unregister from the event. Please try again.");
          }
        })
        .catch((error) => console.error("Error:", error));
    } else {
      console.log("User canceled the unregistration.");
    }
  }

  function unregisterBooking(bookingID) {
    // Show confirmation dialog
    const confirmation = confirm(
      "Are you sure you want to cancel this booking?"
    );

    // If the user confirms, proceed with the booking cancellation
    if (confirmation) {
      fetch("db/unregister_booking.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ bookingID }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            showModal("Successfully unregistered from the booking!");
          } else {
            alert("Failed to unregister from the booking. Please try again.");
          }
        })
        .catch((error) => console.error("Error:", error));
    } else {
      console.log("User canceled the booking cancellation.");
    }
  }

  function showConfirmationModal(message, onConfirm) {
    const modal = document.getElementById("confirmationModal");
    const messageElement = document.getElementById("confirmation-message");

    messageElement.textContent = message;
    modal.style.display = "block";

    // Handle the confirm action
    document.getElementById("confirmButton").onclick = function () {
      onConfirm(); // Call the onConfirm callback when confirmed
      modal.style.display = "none";
    };

    // Handle the cancel action
    document.getElementById("cancelButton").onclick = function () {
      modal.style.display = "none";
    };

    // Close modal when clicking outside the modal content
    window.onclick = function (event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    };
  }

  function unregisterEvent(registrationID) {
    showConfirmationModal(
      "Are you sure you want to unregister from this event?",
      function () {
        fetch("db/unregister_event.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ registrationID }),
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              showModal("Successfully unregistered from the event!");
            } else {
              alert("Failed to unregister from the event. Please try again.");
            }
          })
          .catch((error) => console.error("Error:", error));
      }
    );
  }
  function unregisterBooking(bookingID) {
    showConfirmationModal(
      "Are you sure you want to cancel this booking?",
      function () {
        fetch("db/unregister_booking.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ bookingID }),
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              showModal("Successfully unregistered from the booking!");
            } else {
              alert("Failed to unregister from the booking. Please try again.");
            }
          })
          .catch((error) => console.error("Error:", error));
      }
    );
  }

  function showModal(message) {
    const modal = document.getElementById("successModal");
    const modalMessage = document.getElementById("modal-message");
    modalMessage.textContent = message; // Set the modal message
    modal.style.display = "block"; // Show the modal

    // Close modal when clicking the close button or OK button
    document.getElementById("okButton").onclick = function () {
      modal.style.display = "none";
      setTimeout(() => {
        location.reload();
      }, 500); // Adjust the timeout duration as needed
    };

    // Close modal when clicking outside the modal content
    window.onclick = function (event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    };
  }

  // Initial setup
  setupCategoryFilter();
});
