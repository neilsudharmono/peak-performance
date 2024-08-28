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

    eventsToShow.forEach((event) => {
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
                    <a href="#" class="event-cta">Learn More</a>
                </div>
            `;
      container.appendChild(eventTile);
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
