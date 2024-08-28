document.querySelectorAll(".faq-question").forEach((question) => {
  question.addEventListener("click", function () {
    const faqItem = this.parentElement;
    const faqAnswer = faqItem.querySelector(".faq-answer");
    const isExpanded = this.getAttribute("aria-expanded") === "true";

    if (faqItem.classList.contains("expanded")) {
      faqAnswer.style.maxHeight = faqAnswer.scrollHeight + "px";
      faqAnswer.style.opacity = "1";
      requestAnimationFrame(() => {
        faqAnswer.style.maxHeight = "0";
        faqAnswer.style.opacity = "0";
      });

      faqAnswer.addEventListener(
        "transitionend",
        () => {
          faqAnswer.style.display = "none";
        },
        { once: true }
      );

      faqItem.classList.remove("expanded");
      this.setAttribute("aria-expanded", "false");
    } else {
      faqAnswer.style.display = "block";
      const height = faqAnswer.scrollHeight + "px";
      faqAnswer.style.maxHeight = "0";
      faqAnswer.style.opacity = "0";

      requestAnimationFrame(() => {
        faqAnswer.style.maxHeight = height;
        faqAnswer.style.opacity = "1";
      });

      faqItem.classList.add("expanded");
      this.setAttribute("aria-expanded", "true");

      faqAnswer.addEventListener(
        "transitionend",
        () => {
          faqAnswer.style.maxHeight = "none";
        },
        { once: true }
      );
    }
  });
});
