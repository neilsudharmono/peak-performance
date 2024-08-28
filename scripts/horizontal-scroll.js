function updateArrowButtons() {
  const leftArrowImg = leftArrow.querySelector("img");
  const rightArrowImg = rightArrow.querySelector("img");

  if (container.scrollLeft === 0) {
    leftArrow.disabled = true;
    leftArrowImg.style.opacity = 0.5;
    leftArrowImg.style.pointerEvents = "none";
  } else {
    leftArrow.disabled = false;
    leftArrowImg.style.opacity = 1;
    leftArrowImg.style.pointerEvents = "auto";
  }

  if (container.scrollLeft + container.clientWidth >= container.scrollWidth) {
    rightArrow.disabled = true;
    rightArrowImg.style.opacity = 0.5;
    rightArrowImg.style.pointerEvents = "none";
  } else {
    rightArrow.disabled = false;
    rightArrowImg.style.opacity = 1;
    rightArrowImg.style.pointerEvents = "auto";
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const container = document.querySelector(".events-container");

  // Fetch events data from the server
  fetch("db/event_fetch.php")
    .then((response) => response.json())
    .then((events) => {
      events.forEach((event) => {
        const eventTile = document.createElement("div");
        eventTile.classList.add("event-tile");

        eventTile.innerHTML = `
          <div class="category-tag">${event.category}</div> 
          <img src="${event.imgSrc}" alt="${event.title}" />
          <div class="event-info">
            <h4 class="event-date">${new Date(
              event.date
            ).toLocaleDateString()}</h4>
            <h3 class="event-title">${event.title}</h3>
            <p>${event.description}</p>
          </div>
        `;

        container.appendChild(eventTile);
      });

      updateArrowButtons();
    })
    .catch((error) => console.error("Error fetching events:", error));

  const leftArrow = document.querySelector(".left-arrow");
  const rightArrow = document.querySelector(".right-arrow");

  leftArrow.addEventListener("click", function () {
    container.scrollBy({
      left: -300,
      behavior: "smooth",
    });
    updateArrowButtons();
  });

  rightArrow.addEventListener("click", function () {
    container.scrollBy({
      left: 300,
      behavior: "smooth",
    });
    updateArrowButtons();
  });

  container.addEventListener("scroll", updateArrowButtons);

  updateArrowButtons();
});
