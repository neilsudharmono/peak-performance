const hamburger = document.getElementById("hamburger-menu");
const navMenu = document.querySelector(".nav-menu");
const headerButton = document.querySelector(".header-desktop-button");

hamburger.addEventListener("click", () => {
  const isExpanded =
    hamburger.getAttribute("aria-expanded") === "true" || false;

  navMenu.classList.toggle("active");
  headerButton.classList.toggle("active");
  hamburger.setAttribute("aria-expanded", !isExpanded);
});

document.addEventListener("DOMContentLoaded", function () {
  const collapsibleHeader = document.querySelector(".collapsible-header");
  const collapsibleContent = document.querySelector(".collapsible-content");

  collapsibleHeader.addEventListener("click", function () {
    collapsibleContent.classList.toggle("active");
    collapsibleHeader.classList.toggle("active");

    if (collapsibleContent.style.display === "block") {
      collapsibleContent.style.display = "none";
    } else {
      collapsibleContent.style.display = "block";
    }
  });
});
