document.addEventListener("DOMContentLoaded", function () {
  const eventsPerPage = 6;
  let currentPage = 1;
  let currentCategory = "ALL";
  let allEvents = [];
  let filteredEvents = [];

  function getTotalPages() {
    return Math.ceil(filteredEvents.length / eventsPerPage);
  }

  function filterEventsByTime(timeFilters) {
    const now = new Date();
    return allEvents.filter((event) => {
      const eventDate = new Date(event.date);
      if (timeFilters.includes("thisWeek")) {
        const weekStart = new Date(now.setDate(now.getDate() - now.getDay()));
        const weekEnd = new Date(now.setDate(weekStart.getDate() + 6));
        if (eventDate >= weekStart && eventDate <= weekEnd) return true;
      }
      if (timeFilters.includes("thisMonth")) {
        const monthStart = new Date(now.getFullYear(), now.getMonth(), 1);
        const monthEnd = new Date(now.getFullYear(), now.getMonth() + 1, 0);
        if (eventDate >= monthStart && eventDate <= monthEnd) return true;
      }
      if (timeFilters.includes("nextMonth")) {
        const nextMonthStart = new Date(
          now.getFullYear(),
          now.getMonth() + 1,
          1
        );
        const nextMonthEnd = new Date(now.getFullYear(), now.getMonth() + 2, 0);
        if (eventDate >= nextMonthStart && eventDate <= nextMonthEnd)
          return true;
      }
      if (timeFilters.includes("thisYear")) {
        const yearStart = new Date(now.getFullYear(), 0, 1);
        const yearEnd = new Date(now.getFullYear(), 11, 31);
        if (eventDate >= yearStart && eventDate <= yearEnd) return true;
      }
      return false;
    });
  }

  function filterEvents() {
    let timeFilters = [];
    document
      .querySelectorAll('.time-filter input[type="checkbox"]:checked')
      .forEach((checkbox) => {
        timeFilters.push(checkbox.getAttribute("data-time"));
      });

    filteredEvents = allEvents;

    if (timeFilters.length > 0) {
      filteredEvents = filterEventsByTime(timeFilters);
    }

    if (currentCategory !== "ALL") {
      filteredEvents = filteredEvents.filter(
        (event) => event.category === currentCategory
      );
    }

    currentPage = 1;
    renderEvents();
    renderPagination();
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

    checkUserSession().then((isLoggedIn) => {
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
                  <a href="${
                    isLoggedIn ? "#" : "login.php"
                  }" class="event-cta ${
            userRegistered ? "disabled" : ""
          }" data-event-id="${event.eventID}">
                      ${
                        userRegistered
                          ? "Already Registered"
                          : isLoggedIn
                          ? "Register to Event"
                          : "Login to Register"
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

        document.querySelectorAll(".event-cta").forEach((button) => {
          button.addEventListener("click", function (e) {
            if (!isLoggedIn) {
              // Redirect to login if not logged in
              window.location.href = "login.php";
            } else {
              e.preventDefault();
              const eventID = this.getAttribute("data-event-id");

              if (!this.classList.contains("disabled")) {
                registerEvent(eventID);
              }
            }
          });
        });
      });
    });
  }

  function checkUserSession() {
    return fetch("db/check_user_session_event.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
    })
      .then((response) => response.json())
      .then((data) => {
        return data.isLoggedIn; // This should return true if the user is logged in
      })
      .catch((error) => {
        console.error("Error checking user session:", error);
        return false;
      });
  }

  function renderPagination() {
    const paginationContainer = document.getElementById("pagination");
    paginationContainer.innerHTML = "";

    const totalPages = getTotalPages();

    const prevButton = createArrowButton(
      "prevPage",
      "img/left-arrow.png",
      currentPage === 1,
      function () {
        if (currentPage > 1) {
          currentPage--;
          renderEvents();
          renderPagination();
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
        renderPagination();
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
          renderPagination();
        }
      }
    );
    paginationContainer.appendChild(nextButton);
  }

  function setupTimeFilter() {
    const timeCheckboxes = document.querySelectorAll(
      '.time-filter input[type="checkbox"]'
    );
    timeCheckboxes.forEach((checkbox) => {
      checkbox.addEventListener("change", filterEvents);
    });
  }

  function setupCategoryFilter() {
    const categoryButtons = document.querySelectorAll(".filter-button");
    categoryButtons.forEach((button) => {
      button.addEventListener("click", function () {
        categoryButtons.forEach((btn) => btn.classList.remove("active"));
        this.classList.add("active");
        const selectedCategory = this.getAttribute("data-category");
        filterEventsByCategory(selectedCategory);
      });
    });
  }

  // Fetch events data from the server
  fetch("db/event_fetch.php")
    .then((response) => response.json())
    .then((events) => {
      allEvents = events; // Store the fetched events
      filteredEvents = allEvents; // Initially, show all events
      setupCategoryFilter();
      setupTimeFilter();
      filterEvents(); // Initially filter and display events
    })
    .catch((error) => console.error("Error fetching events:", error));
});

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

function registerEvent(eventID) {
  fetch("db/register_event.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ eventID }),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log("Response from server:", data); // Debugging log

      if (data.success) {
        showModal("Successfully registered for the event!");

        // Find the button that was clicked using eventID
        const button = document.querySelector(
          `.event-cta[data-event-id="${eventID}"]`
        );
        if (button) {
          button.textContent = "Already Registered"; // Change button text
          button.classList.add("disabled"); // Add disabled class
          button.style.backgroundColor = "#cccccc"; // Optional: Change button color
          button.style.color = "#666666"; // Optional: Change button text color
          button.style.cursor = "not-allowed"; // Optional: Change cursor
          button.removeEventListener("click", registerEventHandler); // Remove click event handler to prevent further clicks
        }
      } else {
        alert("Failed to register for the event. Please try again.");
      }
    })
    .catch((error) => console.error("Error:", error));
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

function registerEventHandler(e) {
  e.preventDefault();
  const eventID = this.getAttribute("data-event-id");
  if (!this.classList.contains("disabled")) {
    registerEvent(eventID);
  }
}

function showModal(message) {
  const modal = document.getElementById("successModal");
  const modalMessage = document.getElementById("modal-message");
  modalMessage.textContent = message; // Set the modal message
  modal.style.display = "block"; // Show the modal

  // Close modal when clicking the close button or OK button
  document.querySelector(".close-button").onclick = function () {
    modal.style.display = "none";
  };
  document.getElementById("okButton").onclick = function () {
    modal.style.display = "none";
  };

  // Close modal when clicking outside the modal content
  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  };
}
